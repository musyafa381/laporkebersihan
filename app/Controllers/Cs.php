<?php

namespace App\Controllers;

use App\Models\CsReportModel;
use App\Models\PengajuanAlatModel;
use App\Models\AlatModel;
use App\Libraries\CloudinaryService;

class Cs extends BaseController
{
    protected $csModel;
    protected $pengajuanModel;
    protected $alatModel;
    protected $unitModel;
    protected $cloudinary;

    public function __construct()
    {
        $this->csModel        = new CsReportModel();
        $this->pengajuanModel = new PengajuanAlatModel();
        $this->alatModel      = new AlatModel();
        $this->unitModel      = new \App\Models\MasterUnitModel();
        $this->cloudinary     = new CloudinaryService();
    }

    private function respondJsonOrRedirect($message, $success = true, $redirectUrl = null)
    {
        if ($this->request->isAJAX()) {
            $jsonData = ['status' => $success ? 'success' : 'error', 'message' => $message];
            if ($redirectUrl) {
                $jsonData['redirect'] = $redirectUrl;
            }
            return $this->response->setJSON($jsonData);
        }

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('cs'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    public function index()
    {
        $session = session();
        $isUserAdminOrAuditor = $session->get('isLoggedIn') && in_array($session->get('role'), ['Admin', 'Auditor']);

        // Generate random math CAPTCHA for public form
        if (!$session->get('captcha_num1')) {
            $num1 = rand(3, 9);
            $num2 = rand(2, 8);
            $session->set([
                'captcha_num1'   => $num1,
                'captcha_num2'   => $num2,
                'captcha_answer' => $num1 + $num2
            ]);
        }

        $pengaturanModel = new \App\Models\PengaturanModel();
        $settings = $pengaturanModel->getAllAsMap();

        $wilayahModel = new \App\Models\WilayahModel();
        $wilayahList  = $wilayahModel->where('status', 'Aktif')->orderBy('nama_wilayah', 'ASC')->findAll();

        $unitModel    = new \App\Models\MasterUnitModel();
        $unitList     = $unitModel->getActiveUnitsNonKader();

        // Get fallback PJ data from tbl_unit_pj
        $unitPjModel = new \App\Models\UnitPjModel();
        $allPjs = $unitPjModel->findAll();
        $pjsByUnit = [];
        foreach ($allPjs as $pj) {
            if (!empty($pj['unit_id']) && !isset($pjsByUnit[$pj['unit_id']])) {
                $pjsByUnit[$pj['unit_id']] = $pj;
            }
        }

        foreach ($unitList as &$u) {
            if (empty($u['pj_kontak']) && isset($pjsByUnit[$u['id']])) {
                $u['pj_kontak'] = $pjsByUnit[$u['id']]['kontak_pj'] ?? '';
                if (empty($u['pj_nama'])) {
                    $u['pj_nama'] = $pjsByUnit[$u['id']]['nama_pj'] ?? '';
                }
            }
        }
        unset($u);

        $penugasanModel = new \App\Models\WilayahPenugasanModel();
        $penugasanList  = $penugasanModel
            ->select('tbl_wilayah_penugasan.*, master_unit.nama_unit, master_unit.kode_unit, master_unit.pj_nama, master_unit.pj_kontak')
            ->join('master_unit', 'master_unit.id = tbl_wilayah_penugasan.unit_id', 'left')
            ->findAll();

        foreach ($penugasanList as &$pen) {
            if (empty($pen['pj_kontak']) && !empty($pen['unit_id']) && isset($pjsByUnit[$pen['unit_id']])) {
                $pen['pj_kontak'] = $pjsByUnit[$pen['unit_id']]['kontak_pj'] ?? '';
                if (empty($pen['pj_nama'])) {
                    $pen['pj_nama'] = $pjsByUnit[$pen['unit_id']]['nama_pj'] ?? '';
                }
            }
        }
        unset($pen);

        $reportsList   = [];
        $pengajuanList = [];

        // Only fetch inbox list if logged in as Admin or Auditor
        if ($isUserAdminOrAuditor) {
            $reports = $this->csModel
                ->select('cs_reports.*, master_unit.pj_nama, master_unit.pj_kontak, master_unit.kode_unit, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.lokasi_gedung, tbl_wilayah_kebersihan.luas_area, tbl_wilayah_kebersihan.kategori_area')
                ->join('master_unit', '(cs_reports.unit_id IS NOT NULL AND cs_reports.unit_id > 0 AND master_unit.id = cs_reports.unit_id) OR ((cs_reports.unit_id IS NULL OR cs_reports.unit_id = 0) AND master_unit.nama_unit = cs_reports.unit_lokasi)', 'left')
                ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = cs_reports.wilayah_id', 'left')
                ->groupBy('cs_reports.id')
                ->orderBy('cs_reports.id', 'DESC')
                ->findAll();

            // Build penugasan lookup map by [wilayah_id][shift]
            $penugasanMap = [];
            foreach ($penugasanList as $pen) {
                if (!empty($pen['wilayah_id']) && !empty($pen['shift'])) {
                    $penugasanMap[$pen['wilayah_id']][$pen['shift']] = $pen;
                }
            }

            // Build unit lookup map by [unit_id]
            $unitsMap = [];
            foreach ($unitList as $u) {
                $unitsMap[$u['id']] = $u;
            }

            foreach ($reports as &$r) {
                $assignedPj = null;
                // If report has wilayah_id and shift, resolve PJ of the unit assigned to this shift
                if (!empty($r['wilayah_id']) && !empty($r['shift']) && isset($penugasanMap[$r['wilayah_id']][$r['shift']])) {
                    $assignedPj = $penugasanMap[$r['wilayah_id']][$r['shift']];
                }

                if ($assignedPj) {
                    $r['pj_unit_id']   = $assignedPj['unit_id'];
                    $r['pj_unit_nama'] = $assignedPj['nama_unit'] ?? $r['unit_lokasi'];
                    $r['pj_nama']      = !empty($assignedPj['pj_nama']) ? $assignedPj['pj_nama'] : ($r['pj_nama'] ?? '');
                    $r['pj_kontak']    = !empty($assignedPj['pj_kontak']) ? $assignedPj['pj_kontak'] : ($r['pj_kontak'] ?? '');
                } else {
                    $targetUnitId = $r['unit_id'] ?: null;
                    if ($targetUnitId && isset($unitsMap[$targetUnitId])) {
                        $uObj = $unitsMap[$targetUnitId];
                        $r['pj_unit_id']   = $uObj['id'];
                        $r['pj_unit_nama'] = $uObj['nama_unit'];
                        if (empty($r['pj_nama'])) $r['pj_nama'] = $uObj['pj_nama'] ?? '';
                        if (empty($r['pj_kontak'])) $r['pj_kontak'] = $uObj['pj_kontak'] ?? '';
                    } else {
                        $r['pj_unit_id']   = $r['unit_id'] ?? null;
                        $r['pj_unit_nama'] = $r['unit_lokasi'] ?? '';
                    }
                }

                $finalUnitId = $r['pj_unit_id'] ?? $r['unit_id'] ?? null;
                if ($finalUnitId && isset($pjsByUnit[$finalUnitId])) {
                    if (empty($r['pj_kontak'])) {
                        $r['pj_kontak'] = $pjsByUnit[$finalUnitId]['kontak_pj'] ?? '';
                    }
                    if (empty($r['pj_nama'])) {
                        $r['pj_nama'] = $pjsByUnit[$finalUnitId]['nama_pj'] ?? '';
                    }
                }
            }
            unset($r);
            $reportsList = $reports;

            $pengajuanList = $this->pengajuanModel
                ->select('pengajuan_alat.*, users.nama_lengkap, users.username, alat_inventaris.nama_alat, alat_inventaris.kode_alat, alat_inventaris.satuan')
                ->join('users', 'users.id = pengajuan_alat.user_id', 'left')
                ->join('alat_inventaris', 'alat_inventaris.id = pengajuan_alat.alat_id', 'left')
                ->orderBy('pengajuan_alat.id', 'DESC')
                ->findAll();
        }

        $userUnit = null;
        if ($session->get('isLoggedIn')) {
            $unitId = $session->get('unit_id');
            if (!$unitId && $session->get('userId')) {
                $uObj = (new \App\Models\UserModel())->find($session->get('userId'));
                $unitId = $uObj['unit_id'] ?? null;
            }
            if ($unitId) {
                $userUnit = $this->unitModel->find($unitId);
            }
        }
        $defaultNamaPengirim = !empty($userUnit['pj_nama']) ? $userUnit['pj_nama'] : ($session->get('nama_lengkap') ?? '');
        $defaultKontakHp     = !empty($userUnit['pj_kontak']) ? $userUnit['pj_kontak'] : ($session->get('no_hp') ?? $session->get('kontak') ?? '');

        $data = [
            'title'                => $isUserAdminOrAuditor ? 'Inbox Customer Service Admin K3L' : 'Lapor Kebersihan & Layanan Bantuan (CS)',
            'isUserAdminOrAuditor' => $isUserAdminOrAuditor,
            'isAuditor'            => ($session->get('role') === 'Auditor'),
            'isAdmin'              => ($session->get('role') === 'Admin'),
            'reportsList'          => $reportsList,
            'pengajuanList'        => $pengajuanList,
            'wilayahList'          => $wilayahList,
            'unitList'             => $unitList,
            'penugasanList'        => $penugasanList,
            'settings'             => $settings,
            'userUnit'             => $userUnit,
            'defaultNamaPengirim'  => $defaultNamaPengirim,
            'defaultKontakHp'      => $defaultKontakHp,
            'captcha_num1'         => $session->get('captcha_num1'),
            'captcha_num2'         => $session->get('captcha_num2'),
        ];

        return view('cs/index', $data);
    }

    public function storePublicReport()
    {
        $session = session();
        $isLoggedIn = (bool)$session->get('isLoggedIn');

        // Only enforce captcha check for guest / public non-logged in users
        if (!$isLoggedIn) {
            $userAnswer   = (int)$this->request->getPost('captcha_user');
            $actualAnswer = (int)$session->get('captcha_answer');

            if ($actualAnswer === 0 || $userAnswer !== $actualAnswer) {
                // Generate pertanyaan baru jika salah
                $num1 = rand(3, 9);
                $num2 = rand(2, 8);
                $session->set([
                    'captcha_num1'   => $num1,
                    'captcha_num2'   => $num2,
                    'captcha_answer' => $num1 + $num2
                ]);

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status'       => 'error',
                        'message'      => 'Verifikasi Keamanan (Anti-SPAM) salah. Silakan coba lagi.',
                        'new_captcha'  => [
                            'num1'   => $num1,
                            'num2'   => $num2,
                            'prompt' => "Berapa {$num1} + {$num2} = ?"
                        ]
                    ]);
                }

                return $this->respondJsonOrRedirect('Verifikasi Keamanan (Anti-SPAM) salah. Silakan coba lagi.', false);
            }
        }

        // Generate CAPTCHA baru untuk laporan berikutnya
        $num1 = rand(3, 9);
        $num2 = rand(2, 8);
        $session->set([
            'captcha_num1'   => $num1,
            'captcha_num2'   => $num2,
            'captcha_answer' => $num1 + $num2
        ]);

        $nama     = trim($this->request->getPost('nama_pengirim') ?? '');
        $kontak   = trim($this->request->getPost('kontak_hp') ?? '');
        $lokasi   = trim($this->request->getPost('unit_lokasi') ?? '');
        $laporan  = trim($this->request->getPost('isi_laporan') ?? '');
        $kategori = $this->request->getPost('kategori') ?: 'Kendala Kebersihan';

        if (empty($nama) || empty($kontak) || empty($laporan)) {
            return $this->respondJsonOrRedirect('Nama, nomor kontak HP, dan isi laporan wajib diisi.', false);
        }

        // 1. Validasi Format Nomor Kontak
        $cleanPhone = preg_replace('/[^0-9]/', '', $kontak);
        if (strlen($cleanPhone) < 9 || strlen($cleanPhone) > 15) {
            return $this->respondJsonOrRedirect('Nomor WhatsApp / HP tidak valid. Masukkan nomor yang benar.', false);
        }

        // 2. Filter Kata Tidak Pantas (Profanity & SARA & Judi Online Filter)
        $badWords = [
            'anjing', 'babi', 'monyet', 'bangsat', 'kontol', 'memek', 'jembut', 'pantek', 'asu',
            'bajingan', 'tolol', 'goblok', 'idiot', 'perek', 'lonte', 'silit', 'itil', 'pepek',
            'slot', 'gacor', 'judi', 'togel', 'bokep', 'porn', 'porno', 'ngocok', 'open bo'
        ];

        $combinedText = strtolower($nama . ' ' . $laporan . ' ' . $lokasi);
        $foundBadWord = null;
        foreach ($badWords as $bw) {
            if (preg_match('/\b' . preg_quote($bw, '/') . '\b/i', $combinedText) || stripos($combinedText, $bw) !== false) {
                $foundBadWord = $bw;
                break;
            }
        }

        if ($foundBadWord !== null) {
            return $this->respondJsonOrRedirect('Laporan ditolak: Ditemukan kata/kalimat yang tidak pantas atau melanggar etika.', false);
        }

        // 3. Perekaman IP Address & User Agent serta Rate Limiting (Maks. 5 laporan per 15 menit per IP)
        $ipAddress = $this->request->getIPAddress();
        $userAgent = substr($this->request->getUserAgent()->getAgentString(), 0, 250);

        $fifteenMinsAgo = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        $recentCount = $this->csModel
            ->where('ip_address', $ipAddress)
            ->where('created_at >=', $fifteenMinsAgo)
            ->countAllResults();

        if ($recentCount >= 5) {
            return $this->respondJsonOrRedirect('Anda telah mengirim terlalu banyak laporan dalam waktu singkat. Mohon tunggu beberapa menit lagi.', false);
        }

        $uploadedFiles = $this->request->getFiles();
        $fotoNames = $this->request->getPost('foto_names') ?: [];
        $fotoPaths = [];

        if (!empty($uploadedFiles['foto_files'])) {
            $files = is_array($uploadedFiles['foto_files']) ? $uploadedFiles['foto_files'] : [$uploadedFiles['foto_files']];
            foreach ($files as $idx => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->getSize() > 3 * 1024 * 1024) {
                        return $this->respondJsonOrRedirect("File foto '{$file->getClientName()}' melebihi batas maksimal 3MB.", false);
                    }
                    $customName = !empty($fotoNames[$idx]) ? trim($fotoNames[$idx]) : ('bukti_' . ($idx + 1));
                    // Coba upload ke Cloudinary dengan nama kustom
                    $cldRes = $this->cloudinary->upload($file, 'cs_reports', $customName);
                    if ($cldRes['success'] && !empty($cldRes['url'])) {
                        $fotoPaths[] = $cldRes['url'];
                    } else {
                        // Fallback penyimpanan lokal jika terjadi kendala koneksi
                        $uploadDir = FCPATH . 'uploads/cs/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $cleanLocalName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $customName) . '_' . substr(uniqid(), -4) . '.' . $file->guessExtension();
                        $file->move($uploadDir, $cleanLocalName);
                        $fotoPaths[] = $cleanLocalName;
                    }
                }
            }
        }

        $wilayahId   = $this->request->getPost('wilayah_id') ? (int)$this->request->getPost('wilayah_id') : null;
        $namaWilayah = null;
        if ($wilayahId) {
            $wRecord = (new \App\Models\WilayahModel())->find($wilayahId);
            if ($wRecord) {
                $namaWilayah = $wRecord['nama_wilayah'];
                if (!empty($wRecord['lokasi_gedung'])) {
                    $lokasi = $wRecord['lokasi_gedung'];
                }
            }
        }

        $hour = (int)date('H');
        $autoShift = ($hour >= 5 && $hour < 12) ? 'Pagi' : (($hour >= 12 && $hour < 15) ? 'Siang' : (($hour >= 15 && $hour < 18) ? 'Sore' : 'Malam'));
        $shift = trim($this->request->getPost('shift') ?: '');

        $unitId = $this->request->getPost('unit_id') ? (int)$this->request->getPost('unit_id') : null;

        // Smart shift routing: assign destination unit_id to specific PJ unit assigned to this shift
        if ($wilayahId && !empty($shift)) {
            $penugasanModel = new \App\Models\WilayahPenugasanModel();
            $assignedPj = $penugasanModel
                ->select('tbl_wilayah_penugasan.*, master_unit.nama_unit')
                ->join('master_unit', 'master_unit.id = tbl_wilayah_penugasan.unit_id', 'left')
                ->where('tbl_wilayah_penugasan.wilayah_id', $wilayahId)
                ->where('tbl_wilayah_penugasan.shift', $shift)
                ->first();

            if ($assignedPj && !empty($assignedPj['unit_id'])) {
                $unitId = (int)$assignedPj['unit_id'];
            }
        }

        if (!$unitId && !empty($lokasi)) {
            $uMatch = (new \App\Models\MasterUnitModel())->where('nama_unit', $lokasi)->first();
            if ($uMatch) {
                $unitId = (int)$uMatch['id'];
            }
        }

        $data = [
            'nama_pengirim' => $nama,
            'kontak_hp'     => $kontak,
            'unit_lokasi'   => $lokasi ?: ($namaWilayah ?: 'Umum / Pesantren'),
            'unit_id'       => $unitId,
            'wilayah_id'    => $wilayahId,
            'nama_wilayah'  => $namaWilayah,
            'shift'         => $shift,
            'kategori'      => $kategori,
            'isi_laporan'   => $laporan,
            'foto_lampiran' => !empty($fotoPaths) ? json_encode($fotoPaths) : null,
            'status'        => 'Baru',
            'ip_address'    => $ipAddress,
            'user_agent'    => $userAgent,
            'is_flagged'    => 0,
        ];

        $this->csModel->insert($data);
        return $this->respondJsonOrRedirect('Laporan/Pengaduan Anda beserta foto bukti berhasil dikirim ke Cloud Storage & Tim CS!');
    }

    public function updateReportStatus($id)
    {
        $report = $this->csModel->find($id);
        if (!$report) {
            return $this->respondJsonOrRedirect('Laporan tidak ditemukan.', false);
        }

        $namaPengirim = trim($this->request->getPost('nama_pengirim') ?? $report['nama_pengirim']);
        $kontakHp     = trim($this->request->getPost('kontak_hp') ?? $report['kontak_hp']);
        $unitLokasi   = trim($this->request->getPost('unit_lokasi') ?? $report['unit_lokasi']);
        $wilayahId    = $this->request->getPost('wilayah_id') !== null ? ($this->request->getPost('wilayah_id') === '' ? null : (int)$this->request->getPost('wilayah_id')) : ($report['wilayah_id'] ?? null);
        $namaWilayah  = null;
        if ($wilayahId) {
            $wRecord = (new \App\Models\WilayahModel())->find($wilayahId);
            if ($wRecord) {
                $namaWilayah = $wRecord['nama_wilayah'];
            }
        }
        $shift        = $this->request->getPost('shift') !== null ? trim($this->request->getPost('shift')) : ($report['shift'] ?? null);
        $kategori     = trim($this->request->getPost('kategori') ?? $report['kategori']);
        $isiLaporan   = trim($this->request->getPost('isi_laporan') ?? $report['isi_laporan']);
        $status       = $this->request->getPost('status') ?: $report['status'];
        $tanggapan    = trim($this->request->getPost('tanggapan_admin') ?? '');

        // Cek daftar foto yang dipertahankan admin (jika ada yang dihapus via modal)
        $retainedFotos = $this->request->getPost('existing_fotos');
        $existingFotos = json_decode($report['foto_lampiran'] ?? '[]', true) ?: [];
        if ($retainedFotos !== null) {
            $existingFotos = array_values(array_intersect($existingFotos, is_array($retainedFotos) ? $retainedFotos : []));
        }

        // Handle upload foto baru oleh admin
        $adminFiles = $this->request->getFiles();
        if (!empty($adminFiles['foto_files'])) {
            $files = is_array($adminFiles['foto_files']) ? $adminFiles['foto_files'] : [$adminFiles['foto_files']];
            $fotoNames = $this->request->getPost('foto_names') ?: [];
            foreach ($files as $idx => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->getSize() > 3 * 1024 * 1024) {
                        return $this->respondJsonOrRedirect("File foto '{$file->getClientName()}' melebihi batas 3MB.", false);
                    }
                    $customName = !empty($fotoNames[$idx]) ? trim($fotoNames[$idx]) : ('admin_bukti_' . ($idx + 1));
                    $cldRes = $this->cloudinary->upload($file, 'cs_reports', $customName);
                    if ($cldRes['success'] && !empty($cldRes['url'])) {
                        $existingFotos[] = $cldRes['url'];
                    } else {
                        $uploadDir = FCPATH . 'uploads/cs/';
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                        $cleanLocalName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $customName) . '_' . substr(uniqid(), -4) . '.' . $file->guessExtension();
                        $file->move($uploadDir, $cleanLocalName);
                        $existingFotos[] = $cleanLocalName;
                    }
                }
            }
        }

        $unitId = $this->request->getPost('unit_id') ? (int)$this->request->getPost('unit_id') : ($report['unit_id'] ?? null);

        // Smart shift routing update: assign destination unit_id without overwriting physical location
        if ($wilayahId && !empty($shift)) {
            $penugasanModel = new \App\Models\WilayahPenugasanModel();
            $assignedPj = $penugasanModel
                ->select('tbl_wilayah_penugasan.*, master_unit.nama_unit')
                ->join('master_unit', 'master_unit.id = tbl_wilayah_penugasan.unit_id', 'left')
                ->where('tbl_wilayah_penugasan.wilayah_id', $wilayahId)
                ->where('tbl_wilayah_penugasan.shift', $shift)
                ->first();

            if ($assignedPj && !empty($assignedPj['unit_id'])) {
                $unitId = (int)$assignedPj['unit_id'];
            }
        }

        if (!empty($unitLokasi) && !$unitId) {
            $uMatch = (new \App\Models\MasterUnitModel())->where('nama_unit', $unitLokasi)->first();
            if ($uMatch) {
                $unitId = (int)$uMatch['id'];
            }
        }

        $this->csModel->update($id, [
            'nama_pengirim'   => $namaPengirim,
            'kontak_hp'       => $kontakHp,
            'unit_lokasi'     => $unitLokasi,
            'unit_id'         => $unitId,
            'wilayah_id'      => $wilayahId,
            'nama_wilayah'    => $namaWilayah,
            'shift'           => $shift,
            'kategori'        => $kategori,
            'isi_laporan'     => $isiLaporan,
            'foto_lampiran'   => !empty($existingFotos) ? json_encode(array_values($existingFotos)) : null,
            'status'          => $status,
            'tanggapan_admin' => $tanggapan
        ]);

        return $this->respondJsonOrRedirect("Laporan CS berhasil diperbarui & status diset ke '{$status}'!");
    }

    public function updatePengajuanStatus($id)
    {
        $pengajuan = $this->pengajuanModel->find($id);
        if (!$pengajuan) {
            return $this->respondJsonOrRedirect('Pengajuan alat tidak ditemukan.', false);
        }

        $jumlah          = (int)($this->request->getPost('jumlah') ?: $pengajuan['jumlah']);
        $alasanKeperluan = trim($this->request->getPost('alasan_keperluan') ?? $pengajuan['alasan_keperluan']);
        $status          = $this->request->getPost('status') ?: $pengajuan['status'];
        $catatan         = trim($this->request->getPost('catatan_admin') ?? '');

        $this->pengajuanModel->update($id, [
            'jumlah'           => $jumlah,
            'alasan_keperluan' => $alasanKeperluan,
            'status'           => $status,
            'catatan_admin'    => $catatan
        ]);

        return $this->respondJsonOrRedirect("Pengajuan alat berhasil diperbarui & status diset ke '{$status}'!");
    }

    public function deleteReport($id)
    {
        $report = $this->csModel->find($id);
        if (!$report) {
            return $this->respondJsonOrRedirect('Laporan tidak ditemukan.', false);
        }

        // Hapus semua foto bukti terkait (foto aduan & foto tindakan unit) dari Cloudinary atau disk lokal
        $fotos = json_decode($report['foto_lampiran'] ?? '[]', true) ?: [];
        $unitFotos = json_decode($report['foto_tindakan_unit'] ?? '[]', true) ?: [];
        $allFotos = array_merge($fotos, $unitFotos);
        foreach ($allFotos as $f) {
            if (str_contains($f, 'cloudinary.com')) {
                $this->cloudinary->delete($f);
            } elseif (file_exists(FCPATH . 'uploads/cs/' . $f)) {
                @unlink(FCPATH . 'uploads/cs/' . $f);
            }
        }

        $this->csModel->delete($id);
        return $this->respondJsonOrRedirect('Laporan CS beserta lampiran berhasil dihapus.');
    }

    public function deletePengajuan($id)
    {
        $pengajuan = $this->pengajuanModel->find($id);
        if (!$pengajuan) {
            return $this->respondJsonOrRedirect('Pengajuan alat tidak ditemukan.', false);
        }

        $this->pengajuanModel->delete($id);
        return $this->respondJsonOrRedirect('Pengajuan alat berhasil dihapus.');
    }
}
