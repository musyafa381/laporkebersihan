<?php

namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\MasterUnitModel;
use App\Models\UserModel;
use App\Models\UnitPjModel;
use App\Models\TipeUnitModel;
use App\Models\KategoriAlatModel;
use App\Libraries\CloudinaryService;

class Pengaturan extends BaseController
{
    protected $pengaturanModel;
    protected $unitModel;
    protected $userModel;
    protected $unitPjModel;
    protected $tipeUnitModel;
    protected $kategoriAlatModel;
    protected $unitKaderModel;
    protected $cloudinary;

    public function __construct()
    {
        $this->pengaturanModel   = new PengaturanModel();
        $this->unitModel         = new MasterUnitModel();
        $this->userModel         = new UserModel();
        $this->unitPjModel       = new UnitPjModel();
        $this->tipeUnitModel     = new TipeUnitModel();
        $this->kategoriAlatModel = new KategoriAlatModel();
        $this->unitKaderModel    = new \App\Models\UnitKaderModel();
        $this->cloudinary        = new CloudinaryService();
    }

    public function index()
    {
        $settings = $this->pengaturanModel->getAllAsMap();
        $units    = $this->unitModel->findAll();
        $users    = $this->userModel->findAll();

        // Map users by ID and by role
        $usersById = [];
        $pengurusList = [];
        $kaderList = [];

        foreach ($users as $u) {
            $usersById[$u['id']] = $u;
            if ($u['role'] === 'Pengurus') {
                $pengurusList[] = $u;
            } elseif ($u['role'] === 'Kader') {
                $kaderList[] = $u;
            }
        }

        // Attach cadres and PJ details (multi-PJ) to each unit
        foreach ($units as &$unit) {
            $unitId = $unit['id'];
            $adaKader = $unit['ada_kader'] ?? 'Ya';
            
            if ($adaKader === 'Tidak') {
                $unit['kader_label'] = 'Tanpa Kader';
                $unit['kaders'] = [];
            } else {
                $isAsrama = stripos($unit['tipe'] ?? '', 'Asrama') !== false || stripos($unit['nama_unit'], 'Asrama') !== false || stripos($unit['nama_unit'], 'Kos') !== false || stripos($unit['nama_unit'], 'Komplek') !== false;
                $defaultLabel = $isAsrama ? 'Gemerlap' : 'Satgas Kebersihan';
                $unit['kader_label'] = $unit['jenis_kader'] ?: $defaultLabel;

                // Tentukan linked unit IDs (unit fisik + posko kader terkait jika ada)
                $namaUnitClean = trim(preg_replace('/^(GEMERLAP|Satgas\s*Kebersihan|Satgas)\s*/i', '', $unit['nama_unit']));
                $linkedUnitIds = [(int)$unitId];
                foreach ($units as $ou) {
                    if ((int)$ou['id'] === (int)$unitId) continue;
                    $ouClean = trim(preg_replace('/^(GEMERLAP|Satgas\s*Kebersihan|Satgas)\s*/i', '', $ou['nama_unit']));
                    if (strcasecmp($namaUnitClean, $ouClean) === 0 || stripos($ou['nama_unit'], $namaUnitClean) !== false || stripos($unit['nama_unit'], $ouClean) !== false) {
                        $linkedUnitIds[] = (int)$ou['id'];
                    }
                }

                // Ambil data anggota kader dari tbl_unit_kader
                $kadersFromDb = [];
                foreach ($linkedUnitIds as $lId) {
                    $kData = $this->unitKaderModel->getKadersByUnitId($lId);
                    if (!empty($kData)) {
                        $kadersFromDb = array_merge($kadersFromDb, $kData);
                    }
                }

                // Jika ada anggota dari tbl_unit_kader, pakai itu. Jika belum ada, fallback ke akun user kader
                if (!empty($kadersFromDb)) {
                    $unit['kaders'] = $kadersFromDb;
                } else {
                    $unitKaders = array_filter($users, function ($usr) use ($linkedUnitIds) {
                        return in_array((int)($usr['unit_id'] ?? 0), $linkedUnitIds);
                    });
                    $unit['kaders'] = array_values($unitKaders);
                }
            }

            // Fetch Multi-PJs from tbl_unit_pj
            $pjs = $this->unitPjModel->getPjsByUnitId($unitId);
            if (empty($pjs) && (!empty($unit['pj_user_id']) || !empty($unit['pj_nama']))) {
                // Fallback for legacy single-PJ format
                $pjs = [[
                    'id'        => 0,
                    'unit_id'   => $unitId,
                    'user_id'   => $unit['pj_user_id'],
                    'nama_pj'   => $unit['pj_nama'] ?: ($usersById[$unit['pj_user_id']]['nama_lengkap'] ?? 'PJ Unit'),
                    'kontak_pj' => $unit['pj_kontak'] ?: ($usersById[$unit['pj_user_id']]['no_hp'] ?? ''),
                    'peran'     => 'Penanggung Jawab Utama',
                    'user_nama' => $usersById[$unit['pj_user_id']]['nama_lengkap'] ?? null,
                    'username'  => $usersById[$unit['pj_user_id']]['username'] ?? null,
                ]];
            }
            $unit['pjs'] = $pjs;
        }
        unset($unit);

        $tipeList = $this->tipeUnitModel->getAllOrdered();
        $kategoriAlatList = $this->kategoriAlatModel->getAllOrdered();

        $data = [
            'title'            => 'Pengaturan Sistem Kebersihan',
            'settings'         => $settings,
            'unitsList'        => $units,
            'tipeList'         => $tipeList,
            'kategoriAlatList' => $kategoriAlatList,
            'usersList'        => $users,
            'pengurusList'     => $pengurusList,
            'kaderList'        => $kaderList,
            'activeTab'        => $this->request->getGet('tab') ?? 'general',
        ];

        return view('pengaturan/index', $data);
    }

    public function detailUnit($id)
    {
        $unit = $this->unitModel->find($id);
        if (!$unit) {
            return redirect()->to(base_url('pengaturan?tab=units'))->with('msg_error', 'Unit / Instansi tidak ditemukan.');
        }

        $settings = $this->pengaturanModel->getAllAsMap();
        $users    = $this->userModel->findAll();
        $usersById = [];
        foreach ($users as $u) {
            $usersById[$u['id']] = $u;
        }

        // Multi-PJs
        $pjs = $this->unitPjModel->getPjsByUnitId($id);
        if (empty($pjs) && (!empty($unit['pj_user_id']) || !empty($unit['pj_nama']))) {
            $pjs = [[
                'id'        => 0,
                'unit_id'   => $id,
                'user_id'   => $unit['pj_user_id'],
                'nama_pj'   => $unit['pj_nama'] ?: ($usersById[$unit['pj_user_id']]['nama_lengkap'] ?? 'PJ Unit'),
                'kontak_pj' => $unit['pj_kontak'] ?: ($usersById[$unit['pj_user_id']]['no_hp'] ?? ''),
                'peran'     => 'Penanggung Jawab Utama',
                'user_nama' => $usersById[$unit['pj_user_id']]['nama_lengkap'] ?? null,
                'username'  => $usersById[$unit['pj_user_id']]['username'] ?? null,
                'no_hp'     => $usersById[$unit['pj_user_id']]['no_hp'] ?? null,
                'role'      => $usersById[$unit['pj_user_id']]['role'] ?? null,
            ]];
        }

        // Cadres attached to this unit
        $kaderList = array_values(array_filter($users, function ($usr) use ($id) {
            return (int)($usr['unit_id'] ?? 0) === (int)$id;
        }));

        // Database instance
        $db = \Config\Database::connect();

        // 1. Tool distribution history for this unit
        $distribHistory = [];
        if ($db->tableExists('alat_transaksi')) {
            $builder = $db->table('alat_transaksi t');
            $builder->select('t.*, a.nama_alat, a.kode_alat, a.satuan, a.kategori');
            $builder->join('alat_inventaris a', 'a.id = t.alat_id', 'left');
            $builder->groupStart()
                    ->like('t.unit_tujuan', $unit['nama_unit'])
                    ->orLike('t.penerima_penyerah', $unit['nama_unit'])
                    ->groupEnd();
            $builder->orderBy('t.tanggal', 'DESC');
            $distribHistory = $builder->get()->getResultArray();
        }

        // Summary of tools currently allocated to this unit (Total Masuk Keluar)
        $allocatedTools = [];
        foreach ($distribHistory as $d) {
            $alatId = $d['alat_id'];
            if (!isset($allocatedTools[$alatId])) {
                $allocatedTools[$alatId] = [
                    'nama_alat' => $d['nama_alat'] ?? 'Alat Kebersihan',
                    'kode_alat' => $d['kode_alat'] ?? '-',
                    'satuan'    => $d['satuan'] ?? 'Pcs',
                    'kategori'  => $d['kategori'] ?? 'Peralatan',
                    'jumlah'    => 0,
                    'terakhir'  => $d['tanggal'],
                ];
            }
            if ($d['jenis_transaksi'] === 'Keluar') {
                $allocatedTools[$alatId]['jumlah'] += (int)$d['jumlah'];
            }
        }

        // 2. Complaint / CS Reports for this unit
        $csHistory = [];
        if ($db->tableExists('cs_reports')) {
            $builder = $db->table('cs_reports');
            $builder->groupStart()
                    ->like('unit_lokasi', $unit['nama_unit'])
                    ->orLike('nama_pengirim', $unit['nama_unit'])
                    ->groupEnd();
            $builder->orderBy('created_at', 'DESC');
            $csHistory = $builder->get()->getResultArray();
        }

        $data = [
            'title'          => 'Detail Instansi: ' . $unit['nama_unit'],
            'unit'           => $unit,
            'settings'       => $settings,
            'pjs'            => $pjs,
            'kaderList'      => $kaderList,
            'usersList'      => $users,
            'distribHistory' => $distribHistory,
            'allocatedTools' => array_values($allocatedTools),
            'csHistory'      => $csHistory,
        ];

        return view('pengaturan/unit_detail', $data);
    }

    public function addUnitPj($unitId)
    {
        $unit = $this->unitModel->find($unitId);
        if (!$unit) {
            return redirect()->back()->with('msg_error', 'Unit tidak ditemukan.');
        }

        $userId   = $this->request->getPost('user_id');
        $namaPj   = trim($this->request->getPost('nama_pj') ?? '');
        $kontakPj = trim($this->request->getPost('kontak_pj') ?? '');
        $peran    = trim($this->request->getPost('peran') ?? 'Penanggung Jawab');

        if (!empty($userId)) {
            $user = $this->userModel->find($userId);
            if ($user) {
                if (empty($namaPj)) $namaPj = $user['nama_lengkap'];
                if (empty($kontakPj)) $kontakPj = $user['no_hp'];
            }
        }

        if (empty($namaPj)) {
            return redirect()->back()->with('msg_error', 'Nama Penanggung Jawab wajib diisi.');
        }

        $this->unitPjModel->insert([
            'unit_id'    => $unitId,
            'user_id'    => $userId ?: null,
            'nama_pj'    => $namaPj,
            'kontak_pj'  => $kontakPj,
            'peran'      => $peran,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('pengaturan/unit/detail/' . $unitId))->with('msg_success', 'Penanggung Jawab (PJ) baru berhasil ditambahkan.');
    }

    public function deleteUnitPj($id)
    {
        $pj = $this->unitPjModel->find($id);
        if (!$pj) {
            return redirect()->back()->with('msg_error', 'Data PJ tidak ditemukan.');
        }

        $unitId = $pj['unit_id'];
        $this->unitPjModel->delete($id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Penanggung Jawab berhasil dihapus.',
                'redirect' => base_url('pengaturan/unit/detail/' . $unitId)
            ]);
        }

        return redirect()->to(base_url('pengaturan/unit/detail/' . $unitId))->with('msg_success', 'Penanggung Jawab berhasil dihapus.');
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

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('pengaturan'));
        return redirect()->to($target)->with($success ? 'msg_success' : 'msg_error', $message);
    }

    public function updateGeneral()
    {
        $fields = ['nama_instansi', 'alamat_instansi', 'hotline_wa', 'running_text'];
        foreach ($fields as $f) {
            $val = $this->request->getPost($f);
            $this->pengaturanModel->updateKey($f, $val);
        }

        // Upload Logo
        $logoFile = $this->request->getFile('logo_img');
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            if ($logoFile->getSize() > 3 * 1024 * 1024) {
                return $this->respondJsonOrRedirect('Ukuran file logo melebihi batas maksimal 3MB.', false);
            }

            // Hapus logo lama dari Cloudinary / lokal jika ada
            $oldLogo = $this->pengaturanModel->getVal('logo_img');
            if (!empty($oldLogo)) {
                if (str_contains($oldLogo, 'cloudinary.com')) {
                    $this->cloudinary->delete($oldLogo);
                } elseif (file_exists(FCPATH . $oldLogo)) {
                    @unlink(FCPATH . $oldLogo);
                }
            }

            // Upload ke Cloudinary
            $customName = 'logo_instansi_' . time();
            $cldRes = $this->cloudinary->upload($logoFile, 'settings', $customName);
            if ($cldRes['success'] && !empty($cldRes['url'])) {
                $this->pengaturanModel->updateKey('logo_img', $cldRes['url']);
            } else {
                // Fallback lokal
                $newName = 'logo_' . time() . '.' . $logoFile->getExtension();
                $logoFile->move(FCPATH . 'uploads/settings', $newName);
                $this->pengaturanModel->updateKey('logo_img', 'uploads/settings/' . $newName);
            }
        }

        return $this->respondJsonOrRedirect('Pengaturan umum berhasil diperbarui.', true, base_url('pengaturan?tab=general'));
    }

    public function updatePengesahan()
    {
        $fields = [
            'nama_ketua_k3l', 'jabatan_ketua',
            'nama_koordinator', 'jabatan_koordinator',
            'nama_sekretaris', 'jabatan_sekretaris',
            'kota_dokumen'
        ];

        foreach ($fields as $f) {
            $val = $this->request->getPost($f);
            $this->pengaturanModel->updateKey($f, $val);
        }

        $maxSize = 3 * 1024 * 1024; // 3MB

        // Upload TTD Ketua K3L
        $ttdKetua = $this->request->getFile('ttd_ketua_img');
        if ($ttdKetua && $ttdKetua->isValid() && !$ttdKetua->hasMoved()) {
            if ($ttdKetua->getSize() > $maxSize) {
                return $this->respondJsonOrRedirect('Ukuran file TTD Ketua melebihi batas maksimal 3MB.', false);
            }

            $oldVal = $this->pengaturanModel->getVal('ttd_ketua_img');
            if (!empty($oldVal)) {
                if (str_contains($oldVal, 'cloudinary.com')) {
                    $this->cloudinary->delete($oldVal);
                } elseif (file_exists(FCPATH . $oldVal)) {
                    @unlink(FCPATH . $oldVal);
                }
            }

            $cldRes = $this->cloudinary->upload($ttdKetua, 'settings', 'ttd_ketua_' . time());
            if ($cldRes['success'] && !empty($cldRes['url'])) {
                $this->pengaturanModel->updateKey('ttd_ketua_img', $cldRes['url']);
            } else {
                $newName = 'ttd_ketua_' . time() . '.' . $ttdKetua->getExtension();
                $ttdKetua->move(FCPATH . 'uploads/settings', $newName);
                $this->pengaturanModel->updateKey('ttd_ketua_img', 'uploads/settings/' . $newName);
            }
        }

        // Upload TTD Koordinator Kebersihan
        $ttdKoor = $this->request->getFile('ttd_koordinator_img');
        if ($ttdKoor && $ttdKoor->isValid() && !$ttdKoor->hasMoved()) {
            if ($ttdKoor->getSize() > $maxSize) {
                return $this->respondJsonOrRedirect('Ukuran file TTD Koordinator melebihi batas maksimal 3MB.', false);
            }

            $oldVal = $this->pengaturanModel->getVal('ttd_koordinator_img');
            if (!empty($oldVal)) {
                if (str_contains($oldVal, 'cloudinary.com')) {
                    $this->cloudinary->delete($oldVal);
                } elseif (file_exists(FCPATH . $oldVal)) {
                    @unlink(FCPATH . $oldVal);
                }
            }

            $cldRes = $this->cloudinary->upload($ttdKoor, 'settings', 'ttd_koordinator_' . time());
            if ($cldRes['success'] && !empty($cldRes['url'])) {
                $this->pengaturanModel->updateKey('ttd_koordinator_img', $cldRes['url']);
            } else {
                $newName = 'ttd_koordinator_' . time() . '.' . $ttdKoor->getExtension();
                $ttdKoor->move(FCPATH . 'uploads/settings', $newName);
                $this->pengaturanModel->updateKey('ttd_koordinator_img', 'uploads/settings/' . $newName);
            }
        }

        // Upload TTD Sekretaris
        $ttdSek = $this->request->getFile('ttd_sekretaris_img');
        if ($ttdSek && $ttdSek->isValid() && !$ttdSek->hasMoved()) {
            if ($ttdSek->getSize() > $maxSize) {
                return $this->respondJsonOrRedirect('Ukuran file TTD Sekretaris melebihi batas maksimal 3MB.', false);
            }

            $oldVal = $this->pengaturanModel->getVal('ttd_sekretaris_img');
            if (!empty($oldVal)) {
                if (str_contains($oldVal, 'cloudinary.com')) {
                    $this->cloudinary->delete($oldVal);
                } elseif (file_exists(FCPATH . $oldVal)) {
                    @unlink(FCPATH . $oldVal);
                }
            }

            $cldRes = $this->cloudinary->upload($ttdSek, 'settings', 'ttd_sekretaris_' . time());
            if ($cldRes['success'] && !empty($cldRes['url'])) {
                $this->pengaturanModel->updateKey('ttd_sekretaris_img', $cldRes['url']);
            } else {
                $newName = 'ttd_sekretaris_' . time() . '.' . $ttdSek->getExtension();
                $ttdSek->move(FCPATH . 'uploads/settings', $newName);
                $this->pengaturanModel->updateKey('ttd_sekretaris_img', 'uploads/settings/' . $newName);
            }
        }

        // Upload Stempel
        $stempelFile = $this->request->getFile('stempel_img');
        if ($stempelFile && $stempelFile->isValid() && !$stempelFile->hasMoved()) {
            if ($stempelFile->getSize() > $maxSize) {
                return $this->respondJsonOrRedirect('Ukuran file stempel melebihi batas maksimal 3MB.', false);
            }

            $oldVal = $this->pengaturanModel->getVal('stempel_img');
            if (!empty($oldVal)) {
                if (str_contains($oldVal, 'cloudinary.com')) {
                    $this->cloudinary->delete($oldVal);
                } elseif (file_exists(FCPATH . $oldVal)) {
                    @unlink(FCPATH . $oldVal);
                }
            }

            $cldRes = $this->cloudinary->upload($stempelFile, 'settings', 'stempel_' . time());
            if ($cldRes['success'] && !empty($cldRes['url'])) {
                $this->pengaturanModel->updateKey('stempel_img', $cldRes['url']);
            } else {
                $newName = 'stempel_' . time() . '.' . $stempelFile->getExtension();
                $stempelFile->move(FCPATH . 'uploads/settings', $newName);
                $this->pengaturanModel->updateKey('stempel_img', 'uploads/settings/' . $newName);
            }
        }

        return $this->respondJsonOrRedirect('Pengaturan pengesahan cetak PDF & Tanda Tangan berhasil diperbarui.', true, base_url('pengaturan?tab=pengesahan'));
    }

    public function updateCs()
    {
        $fields = ['wa_template_terima', 'wa_template_selesai', 'jam_cs_buka', 'jam_cs_tutup', 'plafon_pengajuan'];
        foreach ($fields as $f) {
            $val = $this->request->getPost($f);
            $this->pengaturanModel->updateKey($f, $val);
        }

        return $this->respondJsonOrRedirect('Pengaturan notifikasi CS & operasional berhasil diperbarui.', true, base_url('pengaturan?tab=cs'));
    }

    public function storeUnit()
    {
        $nama = $this->request->getPost('nama_unit');
        $tipe = $this->request->getPost('tipe');
        $kode = $this->request->getPost('kode_unit');
        $pjNama = $this->request->getPost('pj_nama');
        $pjKontak = $this->request->getPost('pj_kontak');
        $pjUserId = $this->request->getPost('pj_user_id');
        $status = $this->request->getPost('status') ?: 'Aktif';
        $adaKader = $this->request->getPost('ada_kader') ?: 'Ya';
        $jenisKader = $this->request->getPost('jenis_kader') ?: 'Gemerlap';
        $pjUserIds = (array)$this->request->getPost('pj_user_ids');

        if (empty($nama) || empty($tipe)) {
            return redirect()->back()->with('msg_error', 'Nama Unit dan Tipe wajib diisi.');
        }

        // Auto-generate kode_unit if empty
        if (empty($kode)) {
            $prefix = (stripos($tipe, 'Asrama') !== false) ? 'ASR' : 'SCH';
            $kode = $prefix . '-' . sprintf('%02d', rand(10, 99));
        }

        // If PJ User ID is selected, get name & contact if empty
        if (!empty($pjUserId)) {
            $user = $this->userModel->find($pjUserId);
            if ($user) {
                if (empty($pjNama)) $pjNama = $user['nama_lengkap'];
            }
        }

        $unitId = $this->unitModel->insert([
            'nama_unit'     => $nama,
            'tipe'          => $tipe,
            'kode_unit'     => $kode,
            'pj_nama'       => $pjNama,
            'pj_kontak'     => $pjKontak,
            'pj_user_id'    => $pjUserId ?: null,
            'status'        => $status,
            'ada_kader'     => $adaKader,
            'jenis_kader'   => $jenisKader,
            'parent_unit_id'=> null,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        // Insert selected Multi-PJs into tbl_unit_pj
        if (!empty($pjUserIds)) {
            foreach ($pjUserIds as $uId) {
                if (empty($uId)) continue;
                $uObj = $this->userModel->find($uId);
                $this->unitPjModel->insert([
                    'unit_id'    => $unitId,
                    'user_id'    => $uId,
                    'nama_pj'    => $uObj['nama_lengkap'] ?? 'PJ Unit',
                    'kontak_pj'  => $uObj['no_hp'] ?? '',
                    'peran'      => 'Penanggung Jawab',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        } elseif (!empty($pjUserId)) {
            $uObj = $this->userModel->find($pjUserId);
            $this->unitPjModel->insert([
                'unit_id'    => $unitId,
                'user_id'    => $pjUserId,
                'nama_pj'    => $pjNama ?: ($uObj['nama_lengkap'] ?? 'PJ Utama'),
                'kontak_pj'  => $pjKontak ?: ($uObj['no_hp'] ?? ''),
                'peran'      => 'Penanggung Jawab Utama',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // =========================================================================
        // OTOMATISASI BUAT UNIT POSKO KADER TERINTEGRASI (GEMERLAP / SATGAS)
        // =========================================================================
        if ($adaKader === 'Ya') {
            $isAsramaTipe = (stripos($tipe, 'Asrama') !== false || stripos($nama, 'Asrama') !== false || stripos($nama, 'Kitab') !== false || stripos($nama, 'Tahfidz') !== false || stripos($nama, 'Komplek') !== false);
            $prefixKader = (stripos($jenisKader, 'Satgas') !== false || (!$isAsramaTipe && stripos($tipe, 'Sekolah') !== false)) ? 'Satgas Kebersihan ' : 'GEMERLAP ';
            $namaPoskoKader = $prefixKader . $nama;
            $kodePoskoKader = 'KDR-' . sprintf('%02d', rand(10, 99));

            $this->unitModel->insert([
                'nama_unit'     => $namaPoskoKader,
                'tipe'          => $isAsramaTipe ? 'Posko Gemerlap' : 'Posko Satgas',
                'kode_unit'     => $kodePoskoKader,
                'pj_nama'       => $pjNama,
                'pj_kontak'     => $pjKontak,
                'pj_user_id'    => $pjUserId ?: null,
                'status'        => $status,
                'ada_kader'     => 'Ya',
                'jenis_kader'   => $isAsramaTipe ? 'Gemerlap' : 'Satgas Kebersihan',
                'jenis_laporan' => 'kader',
                'parent_unit_id'=> $unitId,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->respondJsonOrRedirect('Unit / Instansi baru berhasil ditambahkan.', true, base_url('pengaturan?tab=units'));
    }

    public function updateUnit($id)
    {
        $unit = $this->unitModel->find($id);
        if (!$unit) {
            return $this->respondJsonOrRedirect('Unit tidak ditemukan.', false);
        }

        $nama = $this->request->getPost('nama_unit');
        $tipe = $this->request->getPost('tipe');
        $kode = $this->request->getPost('kode_unit');
        $pjNama = $this->request->getPost('pj_nama');
        $pjKontak = $this->request->getPost('pj_kontak');
        $pjUserId = $this->request->getPost('pj_user_id');
        $status = $this->request->getPost('status') ?: 'Aktif';
        $adaKader = $this->request->getPost('ada_kader') ?: 'Ya';
        $jenisKader = $this->request->getPost('jenis_kader') ?: 'Gemerlap';
        $pjUserIds = (array)$this->request->getPost('pj_user_ids');

        if (!empty($pjUserId)) {
            $user = $this->userModel->find($pjUserId);
            if ($user && empty($pjNama)) {
                $pjNama = $user['nama_lengkap'];
            }
        }

        $this->unitModel->update($id, [
            'nama_unit'   => $nama,
            'tipe'        => $tipe,
            'kode_unit'   => $kode,
            'pj_nama'     => $pjNama,
            'pj_kontak'   => $pjKontak,
            'pj_user_id'  => $pjUserId ?: null,
            'status'      => $status,
            'ada_kader'   => $adaKader,
            'jenis_kader' => $jenisKader,
        ]);

        // Sync Multi-PJs if pj_user_ids posted
        if (!empty($pjUserIds)) {
            // Delete old ones and insert new ones
            $this->unitPjModel->where('unit_id', $id)->delete();
            foreach ($pjUserIds as $uId) {
                if (empty($uId)) continue;
                $uObj = $this->userModel->find($uId);
                $this->unitPjModel->insert([
                    'unit_id'    => $id,
                    'user_id'    => $uId,
                    'nama_pj'    => $uObj['nama_lengkap'] ?? 'PJ Unit',
                    'kontak_pj'  => $uObj['no_hp'] ?? '',
                    'peran'      => 'Penanggung Jawab',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        // =========================================================================
        // SINKRONISASI UNIT POSKO KADER TERINTEGRASI (GEMERLAP / SATGAS)
        // =========================================================================
        $childKaderUnit = $this->unitModel->where('parent_unit_id', $id)->first();

        // Cari juga berdasarkan nama jika belum memiliki parent_unit_id
        if (!$childKaderUnit) {
            $childKaderUnit = $this->unitModel->groupStart()
                ->like('nama_unit', 'GEMERLAP ' . $unit['nama_unit'])
                ->orLike('nama_unit', 'Satgas Kebersihan ' . $unit['nama_unit'])
                ->orLike('nama_unit', 'Satgas ' . $unit['nama_unit'])
                ->groupEnd()
                ->first();
        }

        if ($adaKader === 'Ya') {
            $isAsramaTipe = (stripos($tipe, 'Asrama') !== false || stripos($nama, 'Asrama') !== false || stripos($nama, 'Kitab') !== false || stripos($nama, 'Tahfidz') !== false || stripos($nama, 'Komplek') !== false);
            $prefixKader = (stripos($jenisKader, 'Satgas') !== false || (!$isAsramaTipe && stripos($tipe, 'Sekolah') !== false)) ? 'Satgas Kebersihan ' : 'GEMERLAP ';
            $namaPoskoKader = $prefixKader . $nama;

            if ($childKaderUnit) {
                // Update unit posko kader yang sudah ada
                $this->unitModel->update($childKaderUnit['id'], [
                    'nama_unit'     => $namaPoskoKader,
                    'tipe'          => $isAsramaTipe ? 'Posko Gemerlap' : 'Posko Satgas',
                    'pj_nama'       => $pjNama,
                    'pj_kontak'     => $pjKontak,
                    'pj_user_id'    => $pjUserId ?: null,
                    'status'        => $status,
                    'parent_unit_id'=> $id,
                ]);
            } else {
                // Buat unit posko kader baru jika sebelumnya belum ada
                $kodePoskoKader = 'KDR-' . sprintf('%02d', rand(10, 99));
                $this->unitModel->insert([
                    'nama_unit'     => $namaPoskoKader,
                    'tipe'          => $isAsramaTipe ? 'Posko Gemerlap' : 'Posko Satgas',
                    'kode_unit'     => $kodePoskoKader,
                    'pj_nama'       => $pjNama,
                    'pj_kontak'     => $pjKontak,
                    'pj_user_id'    => $pjUserId ?: null,
                    'status'        => $status,
                    'ada_kader'     => 'Ya',
                    'jenis_kader'   => $isAsramaTipe ? 'Gemerlap' : 'Satgas Kebersihan',
                    'parent_unit_id'=> $id,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            // Jika diubah menjadi "Tidak Ada Kader", hapus posko kadernya agar tidak yatim
            if ($childKaderUnit) {
                $this->unitPjModel->where('unit_id', $childKaderUnit['id'])->delete();
                $this->unitModel->delete($childKaderUnit['id']);
            }
        }

        return $this->respondJsonOrRedirect('Data Unit / Instansi berhasil diperbarui.', true, base_url('pengaturan?tab=units'));
    }

    public function deleteUnit($id)
    {
        $unit = $this->unitModel->find($id);
        if ($unit) {
            // Hapus juga unit posko kader anaknya jika ada
            $childUnits = $this->unitModel->where('parent_unit_id', $id)->findAll();
            foreach ($childUnits as $child) {
                $this->unitPjModel->where('unit_id', $child['id'])->delete();
                $this->unitModel->delete($child['id']);
            }

            $this->unitPjModel->where('unit_id', $id)->delete();
            $this->unitModel->delete($id);
            return $this->respondJsonOrRedirect('Data Unit / Instansi berhasil dihapus.', true, base_url('pengaturan?tab=units'));
        }

        return $this->respondJsonOrRedirect('Unit tidak ditemukan.', false, base_url('pengaturan?tab=units'));
    }

    public function storeTipe()
    {
        $namaTipe   = trim($this->request->getPost('nama_tipe') ?? '');
        $keterangan = trim($this->request->getPost('keterangan') ?? '');
        $urutan     = (int)($this->request->getPost('urutan') ?? 0);

        if (empty($namaTipe)) {
            return $this->respondJsonOrRedirect('Nama Tipe Unit wajib diisi.', false, base_url('pengaturan?tab=units'));
        }

        $existing = $this->tipeUnitModel->where('nama_tipe', $namaTipe)->first();
        if ($existing) {
            return $this->respondJsonOrRedirect('Tipe Unit dengan nama tersebut sudah ada.', false, base_url('pengaturan?tab=units'));
        }

        $this->tipeUnitModel->insert([
            'nama_tipe'  => $namaTipe,
            'keterangan' => $keterangan,
            'urutan'     => $urutan,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->respondJsonOrRedirect('Tipe Unit baru berhasil ditambahkan.', true, base_url('pengaturan?tab=units'));
    }

    public function updateTipe($id)
    {
        $tipe = $this->tipeUnitModel->find($id);
        if (!$tipe) {
            return $this->respondJsonOrRedirect('Tipe Unit tidak ditemukan.', false, base_url('pengaturan?tab=units'));
        }

        $namaTipe   = trim($this->request->getPost('nama_tipe') ?? '');
        $keterangan = trim($this->request->getPost('keterangan') ?? '');
        $urutan     = (int)($this->request->getPost('urutan') ?? 0);

        if (empty($namaTipe)) {
            return $this->respondJsonOrRedirect('Nama Tipe Unit wajib diisi.', false, base_url('pengaturan?tab=units'));
        }

        $oldName = $tipe['nama_tipe'];

        $this->tipeUnitModel->update($id, [
            'nama_tipe'  => $namaTipe,
            'keterangan' => $keterangan,
            'urutan'     => $urutan,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Sync master_unit table if name changed
        if ($oldName !== $namaTipe) {
            $this->unitModel->where('tipe', $oldName)->set(['tipe' => $namaTipe])->update();
        }

        return $this->respondJsonOrRedirect('Tipe Unit berhasil diperbarui.', true, base_url('pengaturan?tab=units'));
    }

    public function deleteTipe($id)
    {
        $tipe = $this->tipeUnitModel->find($id);
        if (!$tipe) {
            return $this->respondJsonOrRedirect('Tipe Unit tidak ditemukan.', false, base_url('pengaturan?tab=units'));
        }

        $namaTipe = $tipe['nama_tipe'];
        
        // Count if units are using this type
        $unitCount = $this->unitModel->where('tipe', $namaTipe)->countAllResults();
        if ($unitCount > 0) {
            return $this->respondJsonOrRedirect("Tipe '{$namaTipe}' masih digunakan oleh {$unitCount} unit. Ubah tipe unit tersebut terlebih dahulu sebelum menghapus.", false, base_url('pengaturan?tab=units'));
        }

        $this->tipeUnitModel->delete($id);

        return $this->respondJsonOrRedirect('Tipe Unit berhasil dihapus.', true, base_url('pengaturan?tab=units'));
    }

    public function storeKategoriAlat()
    {
        $namaKategori = trim($this->request->getPost('nama_kategori') ?? '');
        $keterangan   = trim($this->request->getPost('keterangan') ?? '');
        $urutan       = (int)($this->request->getPost('urutan') ?? 0);

        if (empty($namaKategori)) {
            return $this->respondJsonOrRedirect('Nama kategori alat wajib diisi.', false, base_url('pengaturan?tab=units'));
        }

        $existing = $this->kategoriAlatModel->where('nama_kategori', $namaKategori)->first();
        if ($existing) {
            return $this->respondJsonOrRedirect("Kategori alat '{$namaKategori}' sudah ada.", false, base_url('pengaturan?tab=units'));
        }

        $this->kategoriAlatModel->insert([
            'nama_kategori' => $namaKategori,
            'keterangan'    => $keterangan,
            'urutan'        => $urutan,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return $this->respondJsonOrRedirect("Kategori alat '{$namaKategori}' berhasil ditambahkan.", true, base_url('pengaturan?tab=units'));
    }

    public function updateKategoriAlat($id)
    {
        $kat = $this->kategoriAlatModel->find($id);
        if (!$kat) {
            return $this->respondJsonOrRedirect('Kategori alat tidak ditemukan.', false, base_url('pengaturan?tab=units'));
        }

        $namaKategori = trim($this->request->getPost('nama_kategori') ?? '');
        $keterangan   = trim($this->request->getPost('keterangan') ?? '');
        $urutan       = (int)($this->request->getPost('urutan') ?? 0);

        if (empty($namaKategori)) {
            return $this->respondJsonOrRedirect('Nama kategori alat wajib diisi.', false, base_url('pengaturan?tab=units'));
        }

        $oldName = $kat['nama_kategori'];

        // Check duplicate name
        $existing = $this->kategoriAlatModel->where('nama_kategori', $namaKategori)->where('id !=', $id)->first();
        if ($existing) {
            return $this->respondJsonOrRedirect("Kategori alat '{$namaKategori}' sudah ada.", false, base_url('pengaturan?tab=units'));
        }

        $this->kategoriAlatModel->update($id, [
            'nama_kategori' => $namaKategori,
            'keterangan'    => $keterangan,
            'urutan'        => $urutan,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        // Sync category name in alat_inventaris
        $alatModel = new \App\Models\AlatModel();
        if ($oldName !== $namaKategori) {
            $alatModel->where('kategori', $oldName)->set(['kategori' => $namaKategori])->update();
        }

        return $this->respondJsonOrRedirect("Kategori alat '{$namaKategori}' berhasil diperbarui.", true, base_url('pengaturan?tab=units'));
    }

    public function deleteKategoriAlat($id)
    {
        $kat = $this->kategoriAlatModel->find($id);
        if (!$kat) {
            return $this->respondJsonOrRedirect('Kategori alat tidak ditemukan.', false, base_url('pengaturan?tab=units'));
        }

        $namaKategori = $kat['nama_kategori'];
        $alatModel    = new \App\Models\AlatModel();

        // Prevent deletion if items are using this category
        $count = $alatModel->where('kategori', $namaKategori)->countAllResults();
        if ($count > 0) {
            return $this->respondJsonOrRedirect("Kategori '{$namaKategori}' masih digunakan oleh {$count} data alat inventaris. Ubah kategori alat tersebut terlebih dahulu sebelum menghapus.", false, base_url('pengaturan?tab=units'));
        }

        $this->kategoriAlatModel->delete($id);
        return $this->respondJsonOrRedirect("Kategori alat '{$namaKategori}' berhasil dihapus.", true, base_url('pengaturan?tab=units'));
    }

    public function backupDatabase()
    {
        $db = \Config\Database::connect();
        $tables = $db->listTables();

        $output = "-- Backup Database K3L Kebersihan Assalafiyyah Mlangi\n";
        $output .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
        $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            // Get Create Table Query
            $query = $db->query("SHOW CREATE TABLE `$table`");
            $row = $query->getRowArray();
            if (isset($row['Create Table'])) {
                $output .= "-- Structure for table `$table` --\n";
                $output .= "DROP TABLE IF EXISTS `$table`;\n";
                $output .= $row['Create Table'] . ";\n\n";
            }

            // Get Data
            $queryData = $db->query("SELECT * FROM `$table`");
            $rows = $queryData->getResultArray();
            if (!empty($rows)) {
                $output .= "-- Dumping data for table `$table` --\n";
                foreach ($rows as $r) {
                    $keys = array_map(function ($k) { return "`$k`"; }, array_keys($r));
                    $vals = array_map(function ($v) use ($db) {
                        return ($v === null) ? 'NULL' : $db->escape($v);
                    }, array_values($r));

                    $output .= "INSERT INTO `$table` (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $vals) . ");\n";
                }
                $output .= "\n";
            }
        }

        $output .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $fileName = 'backup_k3l_assalafiyyah_' . date('Y-m-d_H-i-s') . '.sql';

        return $this->response->setHeader('Content-Type', 'application/sql')
                              ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                              ->setBody($output);
    }
}
