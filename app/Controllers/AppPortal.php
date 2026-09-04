<?php

namespace App\Controllers;

use App\Models\BukuLpjModel;
use App\Models\MasterUnitModel;
use App\Models\AlatModel;
use App\Models\PengajuanAlatModel;
use App\Models\CsReportModel;
use App\Models\WilayahModel;
use App\Models\WilayahFotoModel;
use App\Models\WilayahPenugasanModel;
use App\Models\WilayahLaporanModel;
use App\Libraries\CloudinaryService;

class AppPortal extends BaseController
{
    protected $bukuModel;
    protected $unitModel;
    protected $alatModel;
    protected $pengajuanModel;
    protected $csModel;
    protected $wilayahModel;
    protected $fotoModel;
    protected $penugasanModel;
    protected $laporanModel;
    protected $cloudinary;

    public function __construct()
    {
        $this->bukuModel      = new BukuLpjModel();
        $this->unitModel      = new MasterUnitModel();
        $this->alatModel      = new AlatModel();
        $this->pengajuanModel = new PengajuanAlatModel();
        $this->csModel        = new CsReportModel();
        $this->wilayahModel   = new WilayahModel();
        $this->fotoModel      = new WilayahFotoModel();
        $this->penugasanModel = new WilayahPenugasanModel();
        $this->laporanModel   = new WilayahLaporanModel();
        $this->cloudinary     = new CloudinaryService();
    }

    private function respondJsonOrRedirect($message, $success = true, $redirectUrl = null)
    {
        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            $jsonData = ['status' => $success ? 'success' : 'error', 'message' => $message];
            if ($redirectUrl) {
                $jsonData['redirect'] = $redirectUrl;
            }
            return $this->response->setJSON($jsonData);
        }

        $target = $redirectUrl ?: base_url('app');
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai Pengurus / Kader terlebih dahulu untuk mengisi LPJ & Pengajuan Alat.')->send();
        }
    }

    protected function sortByTahunBulan(&$list, $order = 'DESC')
    {
        $bulanMap = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
        ];

        usort($list, function ($a, $b) use ($bulanMap, $order) {
            $tahunA = (int)($a['tahun'] ?? 0);
            $tahunB = (int)($b['tahun'] ?? 0);

            if ($tahunA !== $tahunB) {
                return ($order === 'ASC') ? ($tahunA <=> $tahunB) : ($tahunB <=> $tahunA);
            }

            $bulanA = $bulanMap[strtolower(trim($a['bulan'] ?? ''))] ?? 0;
            $bulanB = $bulanMap[strtolower(trim($b['bulan'] ?? ''))] ?? 0;

            return ($order === 'ASC') ? ($bulanA <=> $bulanB) : ($bulanB <=> $bulanA);
        });
    }

    protected function getResolvedUnitId()
    {
        $session = session();
        $unitId  = $session->get('unit_id');

        if (empty($unitId)) {
            $userId = $session->get('userId') ?: $session->get('user_id');
            if ($userId) {
                $userModel = new \App\Models\UserModel();
                $uData = $userModel->find($userId);
                if (!empty($uData['unit_id'])) {
                    $unitId = (int)$uData['unit_id'];
                    $session->set('unit_id', $unitId);
                }
            }
        }

        return $unitId ? (int)$unitId : null;
    }

    public function index()
    {
        $this->checkAuth();

        $session  = session();
        $userRole = $session->get('role');
        $unitId   = $this->getResolvedUnitId();

        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;
        
        $bukuAktif = $this->bukuModel->where('status', 'Aktif')->first();
        if (!$bukuAktif) {
            $allBuku = $this->bukuModel->findAll();
            $this->sortByTahunBulan($allBuku, 'DESC');
            $bukuAktif = $allBuku[0] ?? null;
        }

        $myPengajuan = $this->pengajuanModel
            ->select('pengajuan_alat.*, alat_inventaris.nama_alat, alat_inventaris.kode_alat, alat_inventaris.satuan')
            ->join('alat_inventaris', 'alat_inventaris.id = pengajuan_alat.alat_id', 'left')
            ->where('user_id', $session->get('userId'))
            ->orderBy('id', 'DESC')
            ->findAll();

        $myReports = $this->csModel
            ->where('nama_pengirim', $session->get('nama_lengkap'))
            ->orderBy('id', 'DESC')
            ->findAll();

        $unitAssignedReports = [];
        if ($unitId || $userUnit) {
            $uName = $userUnit['nama_unit'] ?? '';
            $unitAssignedReports = $this->csModel
                ->groupStart()
                    ->where('unit_id', $unitId)
                    ->orWhere("(unit_id IS NULL OR unit_id = 0) AND wilayah_id IS NULL AND unit_lokasi = " . $this->csModel->db->escape($uName))
                ->groupEnd()
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        $today = date('Y-m-d');
        $penugasanList = [];
        if ($unitId) {
            $penugasanList = $this->penugasanModel->getPenugasanByUnit($unitId);
        } else {
            $penugasanList = $this->penugasanModel->getPenugasanWithUnit();
        }

        $todayTotalActiveCount = 0;
        $todayReportedCount = 0;
        foreach ($penugasanList as $p) {
            $hariAktif = $p['hari_aktif'] ?? 'Setiap Hari';
            if ($this->isDayActive($hariAktif, $today)) {
                $todayTotalActiveCount++;
                $todayReport = $this->laporanModel
                    ->where('wilayah_id', $p['wilayah_id'])
                    ->where('tanggal_lapor', $today)
                    ->where('shift', $p['shift'])
                    ->first();
                if (!empty($todayReport)) {
                    $todayReportedCount++;
                }
            }
        }

        $data = [
            'title'                 => 'Portal Mobile - GEMERLAP K3L',
            'userUnit'              => $userUnit,
            'bukuAktif'             => $bukuAktif,
            'myPengajuan'           => $myPengajuan,
            'myReports'             => $myReports,
            'unitAssignedReports'   => $unitAssignedReports,
            'todayTotalActiveCount' => $todayTotalActiveCount,
            'todayReportedCount'    => $todayReportedCount,
            'totalWilayahAssigned'  => count($penugasanList),
        ];

        return view('app_portal/index', $data);
    }

    public function lpj()
    {
        $this->checkAuth();

        $session  = session();
        $unitId   = $this->getResolvedUnitId();
        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;

        if ($userUnit) {
            $uStatus = strtolower(str_replace(['-', ' ', '_'], '', (string)($userUnit['status'] ?? 'aktif')));
            if ($uStatus === 'nonaktif' || $uStatus === 'inactive' || $uStatus === 'tidakaktif') {
                $userUnit = null; // Inactive units do not have active LPJ forms
            }
        }

        $bukuList = $this->bukuModel->findAll();
        $this->sortByTahunBulan($bukuList, 'DESC');

        $evaluasiByBuku = [];
        if ($userUnit) {
            $evaluasiList = (new \App\Models\CapaianEvaluasiModel())->where('unit_id', $userUnit['id'])->findAll();
            foreach ($evaluasiList as $ev) {
                $evaluasiByBuku[$ev['buku_id']] = $ev;
            }
        }

        $data = [
            'title'          => 'Isi Laporan LPJ Unit Kebersihan',
            'userUnit'       => $userUnit,
            'bukuList'       => $bukuList,
            'evaluasiByBuku' => $evaluasiByBuku,
        ];

        return view('app_portal/lpj', $data);
    }

    public function pengajuanAlat()
    {
        $this->checkAuth();

        $session  = session();
        $alatList = $this->alatModel->orderBy('nama_alat', 'ASC')->findAll();

        $myPengajuan = $this->pengajuanModel
            ->select('pengajuan_alat.*, alat_inventaris.nama_alat, alat_inventaris.kode_alat, alat_inventaris.satuan')
            ->join('alat_inventaris', 'alat_inventaris.id = pengajuan_alat.alat_id', 'left')
            ->where('user_id', $session->get('userId'))
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Pengajuan Alat Kebersihan',
            'alatList'    => $alatList,
            'myPengajuan' => $myPengajuan,
        ];

        return view('app_portal/pengajuan_alat', $data);
    }

    public function storePengajuanAlat()
    {
        $this->checkAuth();

        $session = session();
        $userId  = $session->get('userId') ?: $session->get('user_id');
        $alasan  = trim($this->request->getPost('alasan_keperluan') ?? '');

        if (empty($alasan)) {
            return redirect()->to('/app/pengajuan-alat')->with('error', 'Alasan keperluan pengajuan alat wajib diisi.')->withInput();
        }

        $items = $this->request->getPost('items');
        $insertedCount = 0;

        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                $alatId = (int)($item['alat_id'] ?? 0);
                $jumlah = (int)($item['jumlah'] ?? 0);
                if ($alatId > 0 && $jumlah > 0) {
                    $this->pengajuanModel->insert([
                        'user_id'          => $userId,
                        'alat_id'          => $alatId,
                        'jumlah'           => $jumlah,
                        'alasan_keperluan' => $alasan,
                        'status'           => 'Pending',
                    ]);
                    $insertedCount++;
                }
            }
        } else {
            // Fallback for single item
            $alatId = (int)$this->request->getPost('alat_id');
            $jumlah = (int)$this->request->getPost('jumlah');
            if ($alatId > 0 && $jumlah > 0) {
                $this->pengajuanModel->insert([
                    'user_id'          => $userId,
                    'alat_id'          => $alatId,
                    'jumlah'           => $jumlah,
                    'alasan_keperluan' => $alasan,
                    'status'           => 'Pending',
                ]);
                $insertedCount++;
            }
        }

        if ($insertedCount === 0) {
            return redirect()->to('/app/pengajuan-alat')->with('error', 'Pilih minimal 1 jenis alat dan tentukan jumlah yang valid.')->withInput();
        }

        return redirect()->to('/app/pengajuan-alat')->with('success', $insertedCount . ' jenis alat kebersihan berhasil diajukan ke Admin K3L!');
    }

    public function laporanKebersihan()
    {
        $this->checkAuth();

        $session = session();
        if (!$session->get('captcha_num1')) {
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            $session->set('captcha_num1', $num1);
            $session->set('captcha_num2', $num2);
            $session->set('captcha_answer', $num1 + $num2);
        }

        $unitId = $this->getResolvedUnitId();
        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;

        $defaultNamaPengirim = !empty($userUnit['pj_nama']) ? $userUnit['pj_nama'] : ($session->get('nama_lengkap') ?? '');
        $defaultKontakHp     = !empty($userUnit['pj_kontak']) ? $userUnit['pj_kontak'] : ($session->get('no_hp') ?? $session->get('kontak') ?? '');

        $unitAssignedReports = [];
        if ($unitId || $userUnit) {
            $uName = $userUnit['nama_unit'] ?? '';
            $unitAssignedReports = $this->csModel
                ->select('cs_reports.*, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.lokasi_gedung, tbl_wilayah_kebersihan.luas_area, tbl_wilayah_kebersihan.kategori_area')
                ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = cs_reports.wilayah_id', 'left')
                ->groupStart()
                    ->where('cs_reports.unit_id', $unitId)
                    ->orWhere("(cs_reports.unit_id IS NULL OR cs_reports.unit_id = 0) AND cs_reports.wilayah_id IS NULL AND cs_reports.unit_lokasi = " . $this->csModel->db->escape($uName))
                ->groupEnd()
                ->groupBy('cs_reports.id')
                ->orderBy('cs_reports.id', 'DESC')
                ->findAll();
        }

        $myReports = $this->csModel
            ->select('cs_reports.*, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.lokasi_gedung, tbl_wilayah_kebersihan.luas_area, tbl_wilayah_kebersihan.kategori_area')
            ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = cs_reports.wilayah_id', 'left')
            ->where('cs_reports.nama_pengirim', $session->get('nama_lengkap'))
            ->groupBy('cs_reports.id')
            ->orderBy('cs_reports.id', 'DESC')
            ->findAll();

        $pengaturanModel = new \App\Models\PengaturanModel();
        $settings = $pengaturanModel->getAllAsMap();

        $wilayahList = $this->wilayahModel->where('status', 'Aktif')->orderBy('nama_wilayah', 'ASC')->findAll();
        $unitList    = $this->unitModel->getActiveUnitsNonKader();

        $penugasanModel = new \App\Models\WilayahPenugasanModel();
        $penugasanList  = $penugasanModel
            ->select('tbl_wilayah_penugasan.*, master_unit.nama_unit, master_unit.kode_unit')
            ->join('master_unit', 'master_unit.id = tbl_wilayah_penugasan.unit_id', 'left')
            ->findAll();

        $data = [
            'title'               => 'Form Laporan Kendala Kebersihan',
            'captcha_num1'        => $session->get('captcha_num1'),
            'captcha_num2'        => $session->get('captcha_num2'),
            'settings'            => $settings,
            'myReports'           => $myReports,
            'unitAssignedReports' => $unitAssignedReports,
            'userUnit'            => $userUnit,
            'defaultNamaPengirim' => $defaultNamaPengirim,
            'defaultKontakHp'     => $defaultKontakHp,
            'wilayahList'         => $wilayahList,
            'unitList'            => $unitList,
            'penugasanList'       => $penugasanList,
        ];

        return view('app_portal/laporan_kebersihan', $data);
    }

    public function tanggapiAduanUnit($id)
    {
        $this->checkAuth();
        $session = session();
        $unitId = $this->getResolvedUnitId();
        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;
        $report = $this->csModel->find($id);

        if (!$report) {
            return $this->respondJsonOrRedirect('Laporan pengaduan tidak ditemukan.', false, base_url('app/laporan-kebersihan?tab=aduan_unit'));
        }

        $uName = $userUnit['nama_unit'] ?? '';
        $isAuthorized = false;
        if ($session->get('role') === 'Admin') {
            $isAuthorized = true;
        } elseif (!empty($report['unit_id'])) {
            $isAuthorized = ($unitId && (int)$report['unit_id'] === (int)$unitId);
        } else {
            $isAuthorized = (!empty($uName) && strtolower($report['unit_lokasi']) === strtolower($uName));
        }

        if (!$isAuthorized) {
            return $this->respondJsonOrRedirect('Anda tidak memiliki hak akses untuk menindaklanjuti laporan ini karena penugasan ditujukan untuk unit lain.', false, base_url('app/laporan-kebersihan?tab=aduan_unit'));
        }

        $tanggapanUnit = trim($this->request->getPost('tanggapan_unit') ?? '');
        if (empty($tanggapanUnit)) {
            return $this->respondJsonOrRedirect('Keterangan tindak lanjut / respon unit wajib diisi.', false, base_url('app/laporan-kebersihan?tab=aduan_unit'));
        }

        $keptExisting = $this->request->getPost('existing_foto_tindakan');
        $fotoPaths = is_array($keptExisting) ? array_values($keptExisting) : [];

        $uploadedFiles = $this->request->getFiles();
        if (!empty($uploadedFiles['foto_tindakan_files'])) {
            $files = is_array($uploadedFiles['foto_tindakan_files']) ? $uploadedFiles['foto_tindakan_files'] : [$uploadedFiles['foto_tindakan_files']];
            foreach ($files as $idx => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->getSize() > 3 * 1024 * 1024) {
                        return $this->respondJsonOrRedirect("File foto '{$file->getClientName()}' melebihi batas 3MB.", false, base_url('app/laporan-kebersihan?tab=aduan_unit'));
                    }
                    $customName = 'unit_action_' . $id . '_' . ($idx + 1);
                    $cldRes = $this->cloudinary->upload($file, 'cs_reports', $customName);
                    if ($cldRes['success'] && !empty($cldRes['url'])) {
                        $fotoPaths[] = $cldRes['url'];
                    } else {
                        $uploadDir = FCPATH . 'uploads/cs/';
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                        $cleanLocalName = 'unit_action_' . $id . '_' . substr(uniqid(), -4) . '.' . $file->guessExtension();
                        $file->move($uploadDir, $cleanLocalName);
                        $fotoPaths[] = $cleanLocalName;
                    }
                }
            }
        }

        $statusUpdate = $this->request->getPost('status_usulan') ?: 'Diproses';
        if (!in_array($statusUpdate, ['Diproses', 'Selesai'])) {
            $statusUpdate = 'Diproses';
        }

        $this->csModel->update($id, [
            'tanggapan_unit'          => $tanggapanUnit,
            'foto_tindakan_unit'      => !empty($fotoPaths) ? json_encode(array_values($fotoPaths)) : null,
            'nama_penanggap_unit'     => $session->get('nama_lengkap') ?: $session->get('username'),
            'ditanggapi_unit_user_id' => $session->get('userId'),
            'ditanggapi_unit_at'      => date('Y-m-d H:i:s'),
            'status'                  => $statusUpdate
        ]);

        return redirect()->to(base_url('app/laporan-kebersihan') . '?tab=aduan_unit')->with('success', 'Tanggapan & tindakan dari unit berhasil disimpan!');
    }

    public function isDayActive($hariAktif, $date = null)
    {
        if (empty($hariAktif) || $hariAktif === 'Setiap Hari') {
            return true;
        }

        $timestamp = $date ? strtotime($date) : time();
        $dayNum = (int)date('N', $timestamp); // 1 = Senin, ..., 7 = Ahad
        $dayNameIndo = match ($dayNum) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Ahad',
        };

        if ($hariAktif === 'Senin - Jumat' || $hariAktif === 'Senin - Jum\'at') {
            return $dayNum >= 1 && $dayNum <= 5;
        }
        if ($hariAktif === 'Sabtu & Ahad' || $hariAktif === 'Sabtu - Ahad' || $hariAktif === 'Weekend' || $hariAktif === 'Sabtu & Minggu') {
            return $dayNum === 6 || $dayNum === 7;
        }
        if (stripos($hariAktif, 'Jumat') !== false && (stripos($hariAktif, 'Bersih') !== false || stripos($hariAktif, 'Khusus') !== false || stripos($hariAktif, 'Tiap') !== false || stripos($hariAktif, 'Seminggu') !== false)) {
            return $dayNum === 5;
        }
        if ((stripos($hariAktif, 'Ahad') !== false || stripos($hariAktif, 'Minggu') !== false) && (stripos($hariAktif, 'Bersih') !== false || stripos($hariAktif, 'Kerja Bakti') !== false || stripos($hariAktif, 'Tiap') !== false)) {
            return $dayNum === 7;
        }

        // Check specific day name match
        if (stripos($hariAktif, $dayNameIndo) !== false) {
            return true;
        }
        if ($dayNum === 7 && stripos($hariAktif, 'Minggu') !== false) {
            return true;
        }

        return false;
    }

    public function laporWilayah()
    {
        $this->checkAuth();

        $session = session();
        $unitId  = $this->getResolvedUnitId();

        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;
        $today    = date('Y-m-d');

        // If unitId is set, get assigned zones for this unit
        // If Admin/Auditor testing, or unitId is empty, get all zones
        if ($unitId) {
            $penugasanList = $this->penugasanModel->getPenugasanByUnit($unitId);
        } else {
            // Admin testing fallback: show all active assignments or all zones
            $penugasanList = $this->penugasanModel->getPenugasanWithUnit();
        }

        $activeCountToday = 0;

        // Attach master photos, active CS reports, and today's report status for each assigned zone
        foreach ($penugasanList as &$p) {
            $p['fotos'] = $this->fotoModel->getByWilayah($p['wilayah_id']);
            $p['primary_foto'] = !empty($p['fotos']) ? $p['fotos'][0]['foto_url'] : null;

            // Fetch active CS reports linked to this wilayah AND matching this specific shift (or general without shift)
            $p['active_cs_reports'] = $this->csModel
                ->where('wilayah_id', $p['wilayah_id'])
                ->groupStart()
                    ->where('shift', $p['shift'])
                    ->orWhere('shift', '')
                    ->orWhere('shift IS NULL', null, false)
                ->groupEnd()
                ->whereIn('status', ['Baru', 'Diproses'])
                ->orderBy('id', 'DESC')
                ->findAll();
            $p['active_cs_count'] = count($p['active_cs_reports']);

            // Check if active today based on flexible hari_aktif
            $hariAktif = $p['hari_aktif'] ?? 'Setiap Hari';
            $p['is_active_today'] = $this->isDayActive($hariAktif, $today);
            if ($p['is_active_today']) {
                $activeCountToday++;
            }

            // Check if reported today for this shift
            $todayReport = $this->laporanModel
                ->where('wilayah_id', $p['wilayah_id'])
                ->where('tanggal_lapor', $today)
                ->where('shift', $p['shift'])
                ->first();

            $p['today_report'] = $todayReport;
            $p['is_reported_today'] = !empty($todayReport);
        }
        unset($p);

        // Riwayat laporan kebersihan yang pernah dikirim oleh unit ini
        $myLaporanHistory = [];
        if ($unitId) {
            $myLaporanHistory = $this->laporanModel
                ->select('tbl_wilayah_laporan_harian.*, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.kode_wilayah')
                ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = tbl_wilayah_laporan_harian.wilayah_id', 'left')
                ->where('tbl_wilayah_laporan_harian.unit_id', $unitId)
                ->orderBy('tbl_wilayah_laporan_harian.tanggal_lapor', 'DESC')
                ->orderBy('tbl_wilayah_laporan_harian.id', 'DESC')
                ->limit(20)
                ->findAll();
        }

        // Fetch all CS reports linked to the cleaning zones assigned to this unit
        $assignedWilayahIds = array_unique(array_filter(array_column($penugasanList, 'wilayah_id')));
        $csReportsForMyWilayah = [];
        if (!empty($assignedWilayahIds)) {
            $csReportsForMyWilayah = $this->csModel
                ->whereIn('wilayah_id', $assignedWilayahIds)
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        // Ambil semua master wilayah untuk opsi penambahan shift ke wilayah yang sudah ada
        $allMasterWilayah = $this->wilayahModel->orderBy('nama_wilayah', 'ASC')->findAll();
        $unitList = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();

        $data = [
            'title'                 => 'Lapor Kebersihan Wilayah Tugas - GEMERLAP K3L',
            'userUnit'              => $userUnit,
            'unitList'              => $unitList,
            'penugasanList'         => $penugasanList,
            'allMasterWilayah'      => $allMasterWilayah,
            'activeCountToday'      => $activeCountToday,
            'myLaporanHistory'      => $myLaporanHistory,
            'csReportsForMyWilayah' => $csReportsForMyWilayah,
            'todayDate'             => $today
        ];

        return view('app_portal/lapor_wilayah', $data);
    }

    public function storeLaporWilayah()
    {
        $this->checkAuth();

        $session        = session();
        $unitId         = $this->getResolvedUnitId() ?: $this->request->getPost('unit_id');
        $wilayahId      = (int)$this->request->getPost('wilayah_id');
        $penugasanId    = (int)($this->request->getPost('penugasan_id') ?: 0);
        $shift          = $this->request->getPost('shift') ?: 'Pagi';
        $jamLapor       = $this->request->getPost('jam_lapor') ?: date('H:i');
        $nilaiKebersihan= (int)($this->request->getPost('nilai_kebersihan') ?? 85);
        $catatan        = trim($this->request->getPost('catatan') ?? '');
        $tanggalLapor   = date('Y-m-d');

        $wilayah = $this->wilayahModel->find($wilayahId);
        if (!$wilayah) {
            return $this->respondJsonOrRedirect('Wilayah kebersihan tidak valid.', false, base_url('app/lapor-wilayah'));
        }

        // Upload bukti foto kebersihan harian ke Cloudinary
        $fotoBuktiUrl = null;
        $fotoBuktiPublicId = null;

        $file = $this->request->getFile('foto_bukti');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $customName = 'lapor_' . $wilayahId . '_' . $tanggalLapor . '_' . time();
            $cldRes = $this->cloudinary->upload($file, 'laporan_harian_wilayah', $customName);
            if ($cldRes['success'] && !empty($cldRes['url'])) {
                $fotoBuktiUrl = $cldRes['url'];
                $fotoBuktiPublicId = $cldRes['public_id'] ?? null;
            }
        }

        // Determine verification status: if score >= 75 -> 'Sudah Bersih', else 'Perlu Tindakan'
        $statusVerif = ($nilaiKebersihan >= 70) ? 'Sudah Bersih' : 'Perlu Tindakan';

        // Check if report already exists for today + shift
        $existing = $this->laporanModel
            ->where('wilayah_id', $wilayahId)
            ->where('tanggal_lapor', $tanggalLapor)
            ->where('shift', $shift)
            ->first();

        if ($existing) {
            // Update existing report
            $updateData = [
                'nilai_kebersihan'     => $nilaiKebersihan,
                'jam_lapor'            => $jamLapor,
                'catatan'              => $catatan,
                'user_id_pelapor'      => $session->get('userId'),
                'nama_pelapor'         => $session->get('nama_lengkap') ?: 'Pengurus Unit',
                'status_verifikasi'    => $statusVerif
            ];
            if ($fotoBuktiUrl) {
                $updateData['foto_bukti_url'] = $fotoBuktiUrl;
                $updateData['foto_bukti_public_id'] = $fotoBuktiPublicId;
            }
            $this->laporanModel->update($existing['id'], $updateData);
        } else {
            // Insert new report
            $this->laporanModel->insert([
                'wilayah_id'           => $wilayahId,
                'unit_id'              => $unitId,
                'penugasan_id'         => $penugasanId ?: null,
                'tanggal_lapor'        => $tanggalLapor,
                'jam_lapor'            => $jamLapor,
                'shift'                => $shift,
                'nilai_kebersihan'     => $nilaiKebersihan,
                'foto_bukti_url'       => $fotoBuktiUrl,
                'foto_bukti_public_id' => $fotoBuktiPublicId,
                'catatan'              => $catatan,
                'user_id_pelapor'      => $session->get('userId'),
                'nama_pelapor'         => $session->get('nama_lengkap') ?: 'Pengurus Unit',
                'status_verifikasi'    => $statusVerif
            ]);
        }

        return $this->respondJsonOrRedirect('Laporan kebersihan wilayah "' . $wilayah['nama_wilayah'] . '" (Shift ' . $shift . ' pk ' . $jamLapor . ' WIB) berhasil dikirim! Capaian nilai: ' . $nilaiKebersihan . '%.', true, base_url('app/lapor-wilayah'));
    }

    public function storeWilayahTugas()
    {
        $this->checkAuth();

        $session = session();
        $unitId  = $this->getResolvedUnitId();

        if (!$unitId && in_array($session->get('role'), ['Admin', 'Superadmin', 'Auditor'])) {
            $unitId = (int)$this->request->getPost('unit_id') ?: ($this->unitModel->first()['id'] ?? null);
        }

        if (!$unitId) {
            return redirect()->to('/app/lapor-wilayah')->with('error', 'Akun Anda belum terhubung ke unit manapun. Hubungi Admin untuk mengatur unit akun Anda.');
        }

        $isExistingMode = (int)($this->request->getPost('is_existing_wilayah') ?? 0);
        $existingWilayahId = (int)($this->request->getPost('existing_wilayah_id') ?? 0);

        $shift        = $this->request->getPost('shift') ?: 'Pagi';
        $jamMulai     = $this->request->getPost('jam_mulai') ?: '06:00';
        $jamSelesai   = $this->request->getPost('jam_selesai') ?: '07:30';
        $hariAktif    = $this->request->getPost('hari_aktif') ?: 'Setiap Hari';
        $customDays   = $this->request->getPost('hari_custom');
        if ($hariAktif === 'Custom' && !empty($customDays) && is_array($customDays)) {
            $hariAktif = implode(', ', $customDays);
        }
        $keterangan   = trim($this->request->getPost('keterangan') ?? '');

        // JIKA MENAMBAHKAN SHIFT PADA WILAYAH YANG SUDAH ADA
        if ($isExistingMode) {
            if ($existingWilayahId <= 0) {
                return redirect()->to('/app/lapor-wilayah')->with('error', 'Silakan pilih salah satu wilayah kebersihan dari daftar yang tersedia.');
            }

            $existingW = $this->wilayahModel->find($existingWilayahId);
            if (!$existingW) {
                return redirect()->to('/app/lapor-wilayah')->with('error', 'Wilayah yang dipilih tidak ditemukan.');
            }

            // Check if already assigned same shift & same unit
            $alreadyAssigned = $this->penugasanModel
                ->where('wilayah_id', $existingWilayahId)
                ->where('unit_id', $unitId)
                ->where('shift', $shift)
                ->first();

            if ($alreadyAssigned) {
                return redirect()->to('/app/lapor-wilayah')->with('error', 'Shift ' . $shift . ' untuk wilayah "' . $existingW['nama_wilayah'] . '" sudah terdaftar pada unit Anda.');
            }

            $this->penugasanModel->insert([
                'wilayah_id'  => $existingWilayahId,
                'unit_id'     => $unitId,
                'shift'       => $shift,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'hari_aktif'  => $hariAktif,
                'keterangan'  => $keterangan
            ]);

            return redirect()->to('/app/lapor-wilayah')->with('success', 'Jadwal shift baru (' . $shift . ' - ' . $hariAktif . ') untuk wilayah "' . $existingW['nama_wilayah'] . '" berhasil ditambahkan ke daftar tugas unit Anda!');
        }

        // JIKA MENDAFTARKAN MASTER WILAYAH BARU BESERTA SHIFT
        $namaWilayah  = trim($this->request->getPost('nama_wilayah') ?? '');
        $kategoriArea = $this->request->getPost('kategori_area') ?: 'Lainnya';
        $kodeWilayah  = trim($this->request->getPost('kode_wilayah') ?? '');
        $lokasiGedung = trim($this->request->getPost('lokasi_gedung') ?? '');
        $luasArea     = trim($this->request->getPost('luas_area') ?? '');
        $deskripsi    = trim($this->request->getPost('deskripsi') ?? '');

        if (empty($namaWilayah)) {
            return redirect()->to('/app/lapor-wilayah')->with('error', 'Nama wilayah / area wajib diisi.');
        }

        // Auto-generate code if empty
        if (empty($kodeWilayah)) {
            $prefix = 'WIL-';
            if (str_contains(strtolower($kategoriArea), 'asrama')) $prefix = 'WIL-ASR-';
            elseif (str_contains(strtolower($kategoriArea), 'sekolah') || str_contains(strtolower($kategoriArea), 'kelas')) $prefix = 'WIL-GDK-';
            elseif (str_contains(strtolower($kategoriArea), 'lapangan') || str_contains(strtolower($kategoriArea), 'outdoor')) $prefix = 'WIL-LAP-';
            elseif (str_contains(strtolower($kategoriArea), 'ibadah') || str_contains(strtolower($kategoriArea), 'masjid')) $prefix = 'WIL-MSJ-';
            elseif (str_contains(strtolower($kategoriArea), 'dapur') || str_contains(strtolower($kategoriArea), 'kantin')) $prefix = 'WIL-DAP-';
            else $prefix = 'WIL-ZON-';

            $totalWilayah = $this->wilayahModel->countAllResults() + 1;
            $kodeWilayah  = $prefix . str_pad($totalWilayah, 2, '0', STR_PAD_LEFT);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $currentUserId = $session->get('userId') ?: $session->get('user_id');

            // 1. Insert into Master Wilayah
            $wilayahId = $this->wilayahModel->insert([
                'nama_wilayah'  => $namaWilayah,
                'kode_wilayah'  => $kodeWilayah,
                'kategori_area' => $kategoriArea,
                'lokasi_gedung' => $lokasiGedung,
                'luas_area'     => $luasArea,
                'deskripsi'     => $deskripsi,
                'status'        => 'Aktif',
                'created_by'    => $currentUserId
            ]);

            if (!$wilayahId) {
                $db->transRollback();
                return redirect()->to('/app/lapor-wilayah')->with('error', 'Gagal menyimpan data wilayah kebersihan.');
            }

            // 2. Insert into Penugasan Unit (Langsung aktif untuk unit bersangkutan)
            $this->penugasanModel->insert([
                'wilayah_id'  => $wilayahId,
                'unit_id'     => $unitId,
                'shift'       => $shift,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'hari_aktif'  => $hariAktif,
                'keterangan'  => $keterangan
            ]);

            // 3. Upload Foto Master Wilayah (if any)
            $files = $this->request->getFiles();
            if (!empty($files['foto_wilayah'])) {
                $fotoFiles = is_array($files['foto_wilayah']) ? $files['foto_wilayah'] : [$files['foto_wilayah']];
                $isFirst = true;

                foreach ($fotoFiles as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $customName = 'master_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $kodeWilayah) . '_' . uniqid();
                        $uploadRes  = null;
                        try {
                            $uploadRes = $this->cloudinary->upload($file, 'wilayah_kebersihan', $customName);
                        } catch (\Throwable $e) {
                            $uploadRes = ['success' => false];
                        }

                        if ($uploadRes && !empty($uploadRes['success']) && !empty($uploadRes['url'])) {
                            $this->fotoModel->insert([
                                'wilayah_id' => $wilayahId,
                                'foto_url'   => $uploadRes['url'],
                                'public_id'  => $uploadRes['public_id'] ?? null,
                                'is_primary' => $isFirst ? 1 : 0
                            ]);
                            $isFirst = false;
                        } else {
                            $uploadDir = FCPATH . 'uploads/wilayah/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $cleanLocalName = $customName . '.' . ($file->guessExtension() ?: 'jpg');
                            $file->move($uploadDir, $cleanLocalName);
                            $this->fotoModel->insert([
                                'wilayah_id' => $wilayahId,
                                'foto_url'   => base_url('uploads/wilayah/' . $cleanLocalName),
                                'public_id'  => null,
                                'is_primary' => $isFirst ? 1 : 0
                            ]);
                            $isFirst = false;
                        }
                    }
                }
            }

            $db->transCommit();
            return redirect()->to('/app/lapor-wilayah')->with('success', 'Wilayah tugas baru "' . $namaWilayah . '" (Shift ' . $shift . ' - ' . $hariAktif . ') berhasil ditambahkan dan langsung aktif di daftar tugas unit Anda!');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/app/lapor-wilayah')->with('error', 'Terjadi kesalahan saat menyimpan wilayah tugas: ' . $e->getMessage());
        }
    }

    public function deleteWilayahTugas($penugasanId)
    {
        $this->checkAuth();

        $session = session();
        $unitId  = $this->getResolvedUnitId();

        $penugasan = $this->penugasanModel->find($penugasanId);
        if (!$penugasan) {
            return redirect()->to('/app/lapor-wilayah')->with('error', 'Data penugasan wilayah tidak ditemukan.');
        }

        // Check ownership (if not admin/superadmin, must belong to unit)
        if (!in_array($session->get('role'), ['Admin', 'Superadmin']) && $penugasan['unit_id'] != $unitId) {
            return redirect()->to('/app/lapor-wilayah')->with('error', 'Anda tidak memiliki hak untuk menghapus wilayah tugas unit lain.');
        }

        $this->penugasanModel->delete($penugasanId);
        return redirect()->to('/app/lapor-wilayah')->with('success', 'Wilayah tugas berhasil dilepas dari daftar penugasan unit Anda.');
    }
}
