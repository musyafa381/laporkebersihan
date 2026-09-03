<?php

namespace App\Controllers;

use App\Models\ProgramKerjaModel;
use App\Models\MasterUnitModel;
use App\Models\BukuLpjModel;
use App\Models\PengaturanModel;
use App\Libraries\CloudinaryService;

class ProgramKerja extends BaseController
{
    protected $prokerModel;
    protected $unitModel;
    protected $bukuModel;
    protected $pengaturanModel;
    protected $cloudinary;

    public function __construct()
    {
        $this->prokerModel     = new ProgramKerjaModel();
        $this->unitModel       = new MasterUnitModel();
        $this->bukuModel       = new BukuLpjModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->cloudinary      = new CloudinaryService();
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

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('program-kerja'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    public function index()
    {
        $session = session();
        $isLoggedIn = $session->get('isLoggedIn');
        $userRole   = $session->get('role');
        $userUnitId = $session->get('unit_id');

        $isAdminOrAuditor = $isLoggedIn && in_array($userRole, ['Admin', 'Auditor']);

        // Ambil filter dari request
        $filterUnit   = $this->request->getGet('unit_id');
        $filterKader  = $this->request->getGet('kader_type');
        $filterStatus = $this->request->getGet('status');
        $searchKeyword= trim($this->request->getGet('q') ?? '');

        // Query daftar program kerja
        $builder = $this->prokerModel
            ->select('tbl_program_kerja.*, master_unit.nama_unit, master_unit.tipe as unit_tipe, master_unit.ada_kader, master_unit.jenis_kader')
            ->join('master_unit', 'master_unit.id = tbl_program_kerja.unit_id', 'left')
            ->orderBy('tbl_program_kerja.tgl_mulai', 'DESC')
            ->orderBy('tbl_program_kerja.id', 'DESC');

        if (!empty($filterUnit) && $filterUnit !== 'all') {
            $builder->where('tbl_program_kerja.unit_id', (int)$filterUnit);
        }

        if (!empty($filterKader) && $filterKader !== 'all') {
            $builder->where('tbl_program_kerja.kader_type', $filterKader);
        }

        if (!empty($filterStatus) && $filterStatus !== 'all') {
            $builder->where('tbl_program_kerja.status', $filterStatus);
        }

        if (!empty($searchKeyword)) {
            $builder->groupStart()
                ->like('tbl_program_kerja.nama_program', $searchKeyword)
                ->orLike('tbl_program_kerja.sub_kegiatan', $searchKeyword)
                ->orLike('tbl_program_kerja.tujuan_program', $searchKeyword)
                ->orLike('tbl_program_kerja.penanggung_jawab', $searchKeyword)
                ->orLike('master_unit.nama_unit', $searchKeyword)
                ->groupEnd();
        }

        $prokerList = $builder->findAll();

        // Ambil semua master unit untuk pilihan dropdown filter & form
        $allUnits = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();

        // Cari informasi unit pengguna yang sedang login
        $currentUserUnit = $userUnitId ? $this->unitModel->find($userUnitId) : null;

        // Ambil buku LPJ aktif untuk sinkronisasi jika diperlukan
        $bukuLpjList = $this->bukuModel->orderBy('id', 'DESC')->findAll();

        // Statistik Proker
        $allProker = $this->prokerModel->findAll();
        $stats = [
            'total'     => count($allProker),
            'rutin'     => count(array_filter($allProker, fn($p) => $p['status'] === 'Terlaksana Rutin')),
            'berjalan'  => count(array_filter($allProker, fn($p) => $p['status'] === 'Sedang Berjalan')),
            'terencana' => count(array_filter($allProker, fn($p) => $p['status'] === 'Terencana')),
        ];

        $settings = $this->pengaturanModel->getAllAsMap();

        $data = [
            'title'            => 'Buku Program Kerja Unit & Kader - K3L',
            'prokerList'       => $prokerList,
            'allUnits'         => $allUnits,
            'currentUserUnit'  => $currentUserUnit,
            'bukuLpjList'      => $bukuLpjList,
            'stats'            => $stats,
            'settings'         => $settings,
            'filterUnit'       => $filterUnit,
            'filterKader'      => $filterKader,
            'filterStatus'     => $filterStatus,
            'searchKeyword'    => $searchKeyword,
            'isLoggedIn'       => $isLoggedIn,
            'isAdminOrAuditor' => $isAdminOrAuditor,
            'userRole'         => $userRole,
            'userUnitId'       => $userUnitId,
        ];

        return view('program_kerja/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole   = $session->get('role');
        $userUnitId = $session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        $allUnits = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();
        $currentUserUnit = $userUnitId ? $this->unitModel->find($userUnitId) : null;

        $data = [
            'title'            => 'Tambah Program Kerja Baru',
            'proker'           => null,
            'allUnits'         => $allUnits,
            'currentUserUnit'  => $currentUserUnit,
            'isAdminOrAuditor' => $isAdminOrAuditor,
            'userUnitId'       => $userUnitId,
        ];

        return view('program_kerja/form', $data);
    }

    public function edit($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $proker = $this->prokerModel
            ->select('tbl_program_kerja.*, master_unit.nama_unit')
            ->join('master_unit', 'master_unit.id = tbl_program_kerja.unit_id', 'left')
            ->find($id);

        if (!$proker) {
            return redirect()->to(base_url('program-kerja'))->with('error', 'Data program kerja tidak ditemukan.');
        }

        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        // Proteksi Otorisasi: Pengurus hanya bisa mengedit unitnya sendiri
        if (!$isAdminOrAuditor) {
            if (!$userUnitId || (int)$proker['unit_id'] !== $userUnitId) {
                return redirect()->to(base_url('program-kerja'))->with('error', 'Akses ditolak. Anda hanya diizinkan mengedit program kerja milik unit Anda.');
            }
        }

        $allUnits = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();
        $currentUserUnit = $userUnitId ? $this->unitModel->find($userUnitId) : null;

        $data = [
            'title'            => 'Edit Program Kerja: ' . $proker['nama_program'],
            'proker'           => $proker,
            'allUnits'         => $allUnits,
            'currentUserUnit'  => $currentUserUnit,
            'isAdminOrAuditor' => $isAdminOrAuditor,
            'userUnitId'       => $userUnitId,
        ];

        return view('program_kerja/form', $data);
    }

    public function detail($id)
    {
        $proker = $this->prokerModel
            ->select('tbl_program_kerja.*, master_unit.nama_unit, master_unit.tipe as unit_tipe, master_unit.pj_nama, master_unit.pj_kontak, master_unit.ada_kader, master_unit.jenis_kader')
            ->join('master_unit', 'master_unit.id = tbl_program_kerja.unit_id', 'left')
            ->find($id);

        if (!$proker) {
            return redirect()->to(base_url('program-kerja'))->with('error', 'Program kerja tidak ditemukan.');
        }

        if ($this->request->isAJAX() && $this->request->getHeaderLine('Accept') === 'application/json') {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $proker
            ]);
        }

        $session = session();
        $isLoggedIn = $session->get('isLoggedIn');
        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAuditor  = ($userRole === 'Auditor');
        $isAdmin    = ($userRole === 'Admin');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);
        $canEdit    = ($isLoggedIn && $isAdmin) || ($isLoggedIn && !$isAuditor && $userUnitId && (int)$proker['unit_id'] === $userUnitId);

        $data = [
            'title'            => 'Detail Program Kerja: ' . $proker['nama_program'],
            'proker'           => $proker,
            'canEdit'          => $canEdit,
            'isAdminOrAuditor' => $isAdminOrAuditor,
        ];

        return view('program_kerja/detail', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respondJsonOrRedirect('Silakan login terlebih dahulu.', false, base_url('login'));
        }

        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        $unitId = (int)$this->request->getPost('unit_id');

        // Proteksi Otorisasi: Pengurus/Kader hanya boleh menambah untuk unitnya sendiri
        if (!$isAdminOrAuditor) {
            if (!$userUnitId || $unitId !== $userUnitId) {
                return $this->respondJsonOrRedirect('Akses ditolak. Anda hanya memiliki izin menambah program kerja untuk unit Anda sendiri.', false);
            }
        }

        $targetUnit = $this->unitModel->find($unitId);
        if (!$targetUnit) {
            return $this->respondJsonOrRedirect('Unit kerja tidak valid.', false);
        }

        // Tentukan kader_type secara otomatis sesuai karakteristik unit
        $kaderType = 'Non-Kader';
        if ($targetUnit['tipe'] === 'Posko Gemerlap' || stripos($targetUnit['nama_unit'], 'Gemerlap') !== false) {
            $kaderType = 'GEMERLAP';
        } elseif ($targetUnit['tipe'] === 'Satgas' || stripos($targetUnit['nama_unit'], 'Satgas') !== false) {
            $kaderType = 'Satgas';
        }

        $namaProgram   = trim($this->request->getPost('nama_program') ?? '');
        $subKegiatan   = trim($this->request->getPost('sub_kegiatan') ?? '');
        $tglMulai      = $this->request->getPost('tgl_mulai') ?: date('Y-m-d');
        $periode       = $this->request->getPost('periode_frekuensi') ?: 'Mingguan';
        $tujuan        = trim($this->request->getPost('tujuan_program') ?? '');
        $mekanisme     = trim($this->request->getPost('mekanisme_kerja') ?? '');
        $targetInd     = trim($this->request->getPost('target_indikator') ?? '');
        $pj            = trim($this->request->getPost('penanggung_jawab') ?? $targetUnit['pj_nama']);
        $status        = $this->request->getPost('status') ?: 'Sedang Berjalan';

        if (empty($namaProgram)) {
            return $this->respondJsonOrRedirect('Nama Program Kerja wajib diisi.', false);
        }

        $data = [
            'unit_id'            => $unitId,
            'kader_type'         => $kaderType,
            'nama_program'       => $namaProgram,
            'sub_kegiatan'       => $subKegiatan,
            'tgl_mulai'          => $tglMulai,
            'periode_frekuensi'  => $periode,
            'tujuan_program'     => $tujuan,
            'mekanisme_kerja'    => $mekanisme,
            'target_indikator'   => $targetInd,
            'penanggung_jawab'   => $pj,
            'status'             => $status,
            'sumber_input'       => 'Manual',
            'created_by_user_id' => $session->get('userId'),
        ];

        $this->prokerModel->insert($data);
        return $this->respondJsonOrRedirect('Program kerja berhasil ditambahkan ke buku program!');
    }

    public function update($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respondJsonOrRedirect('Silakan login terlebih dahulu.', false, base_url('login'));
        }

        $proker = $this->prokerModel->find($id);
        if (!$proker) {
            return $this->respondJsonOrRedirect('Data program kerja tidak ditemukan.', false);
        }

        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        // Proteksi Otorisasi: Pengurus/Kader hanya boleh mengedit program kerja unitnya sendiri!
        if (!$isAdminOrAuditor) {
            if (!$userUnitId || (int)$proker['unit_id'] !== $userUnitId) {
                return $this->respondJsonOrRedirect('Akses ditolak. Anda hanya diizinkan mengedit program kerja milik unit Anda.', false);
            }
        }

        $unitId = (int)($this->request->getPost('unit_id') ?? $proker['unit_id']);
        if (!$isAdminOrAuditor) {
            $unitId = (int)$proker['unit_id']; // Kunci agar pengurus tidak bisa memindah unit
        }

        $targetUnit = $this->unitModel->find($unitId);
        $kaderType  = $proker['kader_type'];
        if ($targetUnit) {
            if ($targetUnit['tipe'] === 'Posko Gemerlap' || stripos($targetUnit['nama_unit'], 'Gemerlap') !== false) {
                $kaderType = 'GEMERLAP';
            } elseif ($targetUnit['tipe'] === 'Satgas' || stripos($targetUnit['nama_unit'], 'Satgas') !== false) {
                $kaderType = 'Satgas';
            } else {
                $kaderType = 'Non-Kader';
            }
        }

        $namaProgram   = trim($this->request->getPost('nama_program') ?? $proker['nama_program']);
        $subKegiatan   = trim($this->request->getPost('sub_kegiatan') ?? $proker['sub_kegiatan']);
        $tglMulai      = $this->request->getPost('tgl_mulai') ?: $proker['tgl_mulai'];
        $periode       = $this->request->getPost('periode_frekuensi') ?: $proker['periode_frekuensi'];
        $tujuan        = trim($this->request->getPost('tujuan_program') ?? $proker['tujuan_program']);
        $mekanisme     = trim($this->request->getPost('mekanisme_kerja') ?? $proker['mekanisme_kerja']);
        $targetInd     = trim($this->request->getPost('target_indikator') ?? $proker['target_indikator']);
        $pj            = trim($this->request->getPost('penanggung_jawab') ?? $proker['penanggung_jawab']);
        $status        = $this->request->getPost('status') ?: $proker['status'];

        if (empty($namaProgram)) {
            return $this->respondJsonOrRedirect('Nama Program Kerja wajib diisi.', false);
        }

        $data = [
            'unit_id'           => $unitId,
            'kader_type'        => $kaderType,
            'nama_program'      => $namaProgram,
            'sub_kegiatan'      => $subKegiatan,
            'tgl_mulai'         => $tglMulai,
            'periode_frekuensi' => $periode,
            'tujuan_program'    => $tujuan,
            'mekanisme_kerja'   => $mekanisme,
            'target_indikator'  => $targetInd,
            'penanggung_jawab'  => $pj,
            'status'            => $status,
        ];

        $this->prokerModel->update($id, $data);
        return $this->respondJsonOrRedirect('Program kerja berhasil diperbarui!');
    }

    public function delete($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respondJsonOrRedirect('Silakan login terlebih dahulu.', false, base_url('login'));
        }

        $proker = $this->prokerModel->find($id);
        if (!$proker) {
            return $this->respondJsonOrRedirect('Data program kerja tidak ditemukan.', false);
        }

        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        // Proteksi Otorisasi
        if (!$isAdminOrAuditor) {
            if (!$userUnitId || (int)$proker['unit_id'] !== $userUnitId) {
                return $this->respondJsonOrRedirect('Akses ditolak. Anda hanya diizinkan menghapus program kerja milik unit Anda.', false);
            }
        }

        // Hapus seluruh foto dokumentasi dari Cloudinary / lokal sebelum hapus data
        $rawExisting = json_decode($proker['foto_dokumentasi'] ?? '[]', true) ?: [];
        foreach ($rawExisting as $item) {
            $itemFile = is_array($item) ? ($item['file'] ?? '') : $item;
            if (!empty($itemFile)) {
                if (str_contains($itemFile, 'cloudinary.com')) {
                    $this->cloudinary->delete($itemFile);
                } elseif (file_exists(FCPATH . 'uploads/proker/' . basename($itemFile))) {
                    @unlink(FCPATH . 'uploads/proker/' . basename($itemFile));
                }
            }
        }

        $this->prokerModel->delete($id);
        return $this->respondJsonOrRedirect('Program kerja berhasil dihapus.');
    }

    public function uploadFoto($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respondJsonOrRedirect('Silakan login terlebih dahulu.', false, base_url('login'));
        }

        $proker = $this->prokerModel->find($id);
        if (!$proker) {
            return $this->respondJsonOrRedirect('Program kerja tidak ditemukan.', false);
        }

        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        if (!$isAdminOrAuditor) {
            if (!$userUnitId || (int)$proker['unit_id'] !== $userUnitId) {
                return $this->respondJsonOrRedirect('Akses ditolak. Anda hanya diizinkan mengunggah foto untuk unit Anda.', false);
            }
        }

        $uploadedFiles = $this->request->getFiles();
        if (empty($uploadedFiles['foto_files'])) {
            return $this->respondJsonOrRedirect('Pilih minimal satu file foto dokumentasi.', false);
        }

        $files = is_array($uploadedFiles['foto_files']) ? $uploadedFiles['foto_files'] : [$uploadedFiles['foto_files']];
        $fotoCaptions = (array)($this->request->getPost('foto_captions') ?? []);
        $rawExisting = json_decode($proker['foto_dokumentasi'] ?? '[]', true) ?: [];
        
        // Normalize existing photos into objects with 'file' and 'caption'
        $existingPhotos = [];
        foreach ($rawExisting as $item) {
            if (is_array($item)) {
                $existingPhotos[] = $item;
            } elseif (is_string($item)) {
                $existingPhotos[] = [
                    'file'    => $item,
                    'caption' => 'Dokumentasi Program'
                ];
            }
        }

        $uploadDir = FCPATH . 'uploads/proker/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $savedCount = 0;
        $maxSize = 3 * 1024 * 1024; // 3MB in bytes

        foreach ($files as $idx => $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Validasi ukuran maks. 3MB
                if ($file->getSize() > $maxSize) {
                    return $this->respondJsonOrRedirect("File '{$file->getClientName()}' melebihi batas ukuran maksimal 3MB.", false);
                }

                $mime = $file->getMimeType();
                if (!str_starts_with($mime, 'image/')) {
                    continue;
                }

                $caption = trim($fotoCaptions[$idx] ?? '') ?: pathinfo($file->getClientName(), PATHINFO_FILENAME);
                $customName = 'proker_' . $id . '_' . time() . '_' . substr(uniqid(), -4);

                // Prioritaskan upload ke Cloudinary
                $cldRes = $this->cloudinary->upload($file, 'proker_docs', $customName);
                if ($cldRes['success'] && !empty($cldRes['url'])) {
                    $existingPhotos[] = [
                        'file'       => $cldRes['url'],
                        'caption'    => $caption,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $savedCount++;
                } else {
                    // Fallback lokal jika kendala koneksi
                    $newName = $customName . '.' . $file->guessExtension();
                    $file->move($uploadDir, $newName);

                    $existingPhotos[] = [
                        'file'       => $newName,
                        'caption'    => $caption,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $savedCount++;
                }
            }
        }

        if ($savedCount > 0) {
            $this->prokerModel->update($id, [
                'foto_dokumentasi' => json_encode(array_values($existingPhotos), JSON_UNESCAPED_UNICODE)
            ]);
            return $this->respondJsonOrRedirect("Berhasil mengunggah {$savedCount} foto dokumentasi kegiatan!");
        }

        return $this->respondJsonOrRedirect('Tidak ada foto valid yang berhasil diunggah.', false);
    }

    public function deleteFoto($id, $fileName)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respondJsonOrRedirect('Silakan login terlebih dahulu.', false, base_url('login'));
        }

        $proker = $this->prokerModel->find($id);
        if (!$proker) {
            return $this->respondJsonOrRedirect('Program kerja tidak ditemukan.', false);
        }

        $userRole   = $session->get('role');
        $userUnitId = (int)$session->get('unit_id');
        $isAdminOrAuditor = in_array($userRole, ['Admin', 'Auditor']);

        if (!$isAdminOrAuditor) {
            if (!$userUnitId || (int)$proker['unit_id'] !== $userUnitId) {
                return $this->respondJsonOrRedirect('Akses ditolak.', false);
            }
        }

        $rawExisting = json_decode($proker['foto_dokumentasi'] ?? '[]', true) ?: [];
        $updatedPhotos = [];
        $targetIdx = is_numeric($fileName) ? (int)$fileName : null;

        foreach ($rawExisting as $idx => $item) {
            $itemFile = is_array($item) ? ($item['file'] ?? '') : $item;
            $isTarget = ($targetIdx !== null && $idx === $targetIdx) || 
                        ($itemFile === $fileName) || 
                        (basename($itemFile) === basename($fileName)) || 
                        (urldecode($fileName) === $itemFile);

            if ($isTarget) {
                if (str_contains($itemFile, 'cloudinary.com')) {
                    $this->cloudinary->delete($itemFile);
                } elseif (file_exists(FCPATH . 'uploads/proker/' . basename($itemFile))) {
                    @unlink(FCPATH . 'uploads/proker/' . basename($itemFile));
                }
            } else {
                $updatedPhotos[] = $item;
            }
        }

        $this->prokerModel->update($id, [
            'foto_dokumentasi' => json_encode(array_values($updatedPhotos), JSON_UNESCAPED_UNICODE)
        ]);

        return $this->respondJsonOrRedirect('Foto dokumentasi berhasil dihapus!');
    }

    // Fitur Import / Sinkronisasi Cepat dari LPJ Bulanan
    public function syncFromLpj($bukuId)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || !in_array($session->get('role'), ['Admin', 'Auditor'])) {
            return $this->respondJsonOrRedirect('Akses ditolak.', false);
        }

        $agendaModel = new \App\Models\ProkerAgendaModel();
        $agendas = $agendaModel->where('buku_id', $bukuId)->findAll();

        if (empty($agendas)) {
            return $this->respondJsonOrRedirect('Tidak ada data agenda/proker pada buku LPJ tersebut.', false);
        }

        // Cari unit default (atau Posko Gemerlap)
        $defaultUnit = $this->unitModel->first();
        $importedCount = 0;

        foreach ($agendas as $ag) {
            $existing = $this->prokerModel
                ->where('nama_program', $ag['kegiatan'])
                ->where('buku_lpj_id', $bukuId)
                ->first();

            if (!$existing) {
                $this->prokerModel->insert([
                    'unit_id'           => $defaultUnit['id'] ?? null,
                    'kader_type'        => 'Non-Kader',
                    'nama_program'      => $ag['kegiatan'],
                    'sub_kegiatan'      => 'Imported dari LPJ Bulanan',
                    'tgl_mulai'         => $ag['tanggal'] ?? date('Y-m-d'),
                    'periode_frekuensi' => 'Bulanan',
                    'tujuan_program'    => $ag['keterangan'] ?? 'Program kerja tersinkronisasi dari lembar LPJ bulanan.',
                    'status'            => 'Terlaksana Rutin',
                    'sumber_input'      => 'LPJ Bulanan',
                    'buku_lpj_id'       => $bukuId,
                ]);
                $importedCount++;
            }
        }

        return $this->respondJsonOrRedirect("Berhasil mengimpor {$importedCount} program kerja dari Buku LPJ!");
    }
}
