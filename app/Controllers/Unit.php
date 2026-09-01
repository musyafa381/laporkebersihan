<?php

namespace App\Controllers;

use App\Models\MasterUnitModel;
use App\Models\UnitPjModel;
use App\Models\UnitKaderModel;
use App\Models\UserModel;
use App\Models\PengaturanModel;

class Unit extends BaseController
{
    protected $unitModel;
    protected $unitPjModel;
    protected $unitKaderModel;
    protected $userModel;
    protected $pengaturanModel;

    public function __construct()
    {
        $this->unitModel       = new MasterUnitModel();
        $this->unitPjModel     = new UnitPjModel();
        $this->unitKaderModel  = new UnitKaderModel();
        $this->userModel       = new UserModel();
        $this->pengaturanModel = new PengaturanModel();
    }

    public function detail($id)
    {
        $unit = $this->unitModel->find($id);
        if (!$unit) {
            return redirect()->to(base_url('pengaturan?tab=units'))->with('msg_error', 'Data Instansi / Unit tidak ditemukan.');
        }

        $settings = $this->pengaturanModel->getAllAsMap();
        $users    = $this->userModel->findAll();
        $usersById = [];
        foreach ($users as $u) {
            $usersById[$u['id']] = $u;
        }

        // Multi-PJs for this unit
        $pjs = $this->unitPjModel->getPjsByUnitId($id);
        if (empty($pjs) && (!empty($unit['pj_user_id']) || !empty($unit['pj_nama']))) {
            $pjs = [[
                'id'        => 0,
                'unit_id'   => $id,
                'user_id'   => $unit['pj_user_id'],
                'nama_pj'   => $unit['pj_nama'] ?: ($usersById[$unit['pj_user_id']]['nama_lengkap'] ?? 'PJ Unit'),
                'kontak_pj' => $unit['pj_kontak'] ?: '',
                'peran'     => 'Penanggung Jawab Utama',
                'user_nama' => $usersById[$unit['pj_user_id']]['nama_lengkap'] ?? null,
                'username'  => $usersById[$unit['pj_user_id']]['username'] ?? null,
                'role'      => $usersById[$unit['pj_user_id']]['role'] ?? null,
            ]];
        }

        // Tentukan Unit Posko Kader Terkait (Gemerlap / Satgas)
        $namaUnitClean = preg_replace('/^(GEMERLAP|Satgas\s*Kebersihan|Satgas)\s*/i', '', $unit['nama_unit']);
        $namaUnitClean = trim($namaUnitClean);

        $allUnits = $this->unitModel->findAll();
        $linkedUnitIds = [(int)$id];
        $linkedUnitName = null;

        foreach ($allUnits as $otherUnit) {
            if ((int)$otherUnit['id'] === (int)$id) continue;

            $otherClean = preg_replace('/^(GEMERLAP|Satgas\s*Kebersihan|Satgas)\s*/i', '', $otherUnit['nama_unit']);
            $otherClean = trim($otherClean);

            if (strcasecmp($namaUnitClean, $otherClean) === 0 || stripos($otherUnit['nama_unit'], $namaUnitClean) !== false || stripos($unit['nama_unit'], $otherClean) !== false) {
                if (stripos($otherUnit['nama_unit'], 'GEMERLAP') !== false || stripos($otherUnit['nama_unit'], 'Satgas') !== false) {
                    $linkedUnitIds[] = (int)$otherUnit['id'];
                    $linkedUnitName = $otherUnit['nama_unit'];
                }
            }
        }

        // Ambil Daftar Nama Kader dari tbl_unit_kader
        $kaderList = [];
        foreach ($linkedUnitIds as $lUnitId) {
            $kadData = $this->unitKaderModel->getKadersByUnitId($lUnitId);
            if (!empty($kadData)) {
                $kaderList = array_merge($kaderList, $kadData);
            }
        }

        // Akun login terdaftar untuk unit ini (opsional)
        $unitAccountUsers = array_values(array_filter($users, function ($usr) use ($linkedUnitIds) {
            return in_array((int)($usr['unit_id'] ?? 0), $linkedUnitIds);
        }));

        $db = \Config\Database::connect();

        // 1. Tool Distribution Log for this unit
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

        // 2. Allocated Tools Summary for this unit
        $allocatedTools = [];
        $totalAlatTerlokasi = 0;
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
                $totalAlatTerlokasi += (int)$d['jumlah'];
            }
        }

        // 3. Complaint & CS Reports for this unit
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

        // 4. Equipment Request History (pengajuan_alat) if exists
        $pengajuanHistory = [];
        if ($db->tableExists('pengajuan_alat')) {
            $builder = $db->table('pengajuan_alat p');
            $builder->select('p.*, a.nama_alat, a.kode_alat, a.satuan, u.nama_lengkap as pemohon_nama, u.username as pemohon_username');
            $builder->join('alat_inventaris a', 'a.id = p.alat_id', 'left');
            $builder->join('users u', 'u.id = p.user_id', 'left');
            $builder->where('u.unit_id', $id);
            $builder->orderBy('p.created_at', 'DESC');
            $pengajuanHistory = $builder->get()->getResultArray();
        }

        $data = [
            'title'              => 'Detail Instansi: ' . $unit['nama_unit'],
            'unit'               => $unit,
            'settings'           => $settings,
            'pjs'                => $pjs,
            'kaderList'          => $kaderList,
            'usersList'          => $users,
            'unitAccountUsers'   => $unitAccountUsers,
            'linkedUnitName'     => $linkedUnitName,
            'distribHistory'     => $distribHistory,
            'allocatedTools'     => array_values($allocatedTools),
            'totalAlatTerlokasi' => $totalAlatTerlokasi,
            'csHistory'          => $csHistory,
            'pengajuanHistory'   => $pengajuanHistory,
        ];

        return view('unit/detail', $data);
    }

    public function addPj($unitId)
    {
        $unit = $this->unitModel->find($unitId);
        if (!$unit) {
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Unit tidak ditemukan.']);
            }
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
            }
        }

        if (empty($namaPj)) {
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Penanggung Jawab wajib diisi.']);
            }
            return redirect()->back()->with('msg_error', 'Nama Penanggung Jawab wajib diisi.');
        }

        // Prevent duplicate insertion of the same PJ
        $builder = $this->unitPjModel->where('unit_id', $unitId);
        if (!empty($userId)) {
            $builder->where('user_id', $userId);
        } else {
            $builder->where('nama_pj', $namaPj);
        }
        $existing = $builder->first();

        if ($existing) {
            $this->unitPjModel->update($existing['id'], [
                'nama_pj'   => $namaPj,
                'kontak_pj' => $kontakPj,
                'peran'     => $peran,
            ]);
        } else {
            $this->unitPjModel->insert([
                'unit_id'    => $unitId,
                'user_id'    => $userId ?: null,
                'nama_pj'    => $namaPj,
                'kontak_pj'  => $kontakPj,
                'peran'      => $peran,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Penanggung Jawab (PJ) baru berhasil disimpan.',
                'redirect' => base_url('unit/detail/' . $unitId)
            ]);
        }

        return redirect()->to(base_url('unit/detail/' . $unitId))->with('msg_success', 'Penanggung Jawab (PJ) baru berhasil disimpan.');
    }

    public function deletePj($id)
    {
        $pj = $this->unitPjModel->find($id);
        if (!$pj) {
            return redirect()->back()->with('msg_error', 'Data PJ tidak ditemukan.');
        }

        $unitId = $pj['unit_id'];
        $this->unitPjModel->delete($id);

        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Penanggung Jawab berhasil dihapus.',
                'redirect' => base_url('unit/detail/' . $unitId)
            ]);
        }

        return redirect()->to(base_url('unit/detail/' . $unitId))->with('msg_success', 'Penanggung Jawab berhasil dihapus.');
    }

    public function addKader($unitId)
    {
        $unit = $this->unitModel->find($unitId);
        if (!$unit) {
            return redirect()->back()->with('msg_error', 'Unit tidak ditemukan.');
        }

        $namaKader    = trim($this->request->getPost('nama_kader') ?? '');
        $kontakKader  = trim($this->request->getPost('kontak_kader') ?? '');
        $jabatanKader = trim($this->request->getPost('jabatan_kader') ?? 'Anggota Kader');
        $kamarKelas   = trim($this->request->getPost('kamar_kelas') ?? '');

        if (empty($namaKader)) {
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Anggota Kader wajib diisi.']);
            }
            return redirect()->back()->with('msg_error', 'Nama Anggota Kader wajib diisi.');
        }

        $this->unitKaderModel->insert([
            'unit_id'       => $unitId,
            'nama_kader'    => $namaKader,
            'kontak_kader'  => $kontakKader,
            'jabatan_kader' => $jabatanKader,
            'kamar_kelas'   => $kamarKelas,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Anggota Kader baru berhasil ditambahkan.',
                'redirect' => base_url('unit/detail/' . $unitId)
            ]);
        }

        return redirect()->to(base_url('unit/detail/' . $unitId))->with('msg_success', 'Anggota Kader baru berhasil ditambahkan.');
    }

    public function deleteKader($id)
    {
        $kader = $this->unitKaderModel->find($id);
        if (!$kader) {
            return redirect()->back()->with('msg_error', 'Data Kader tidak ditemukan.');
        }

        $unitId = $kader['unit_id'];
        $this->unitKaderModel->delete($id);

        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Anggota Kader berhasil dihapus.',
                'redirect' => base_url('unit/detail/' . $unitId)
            ]);
        }

        return redirect()->to(base_url('unit/detail/' . $unitId))->with('msg_success', 'Anggota Kader berhasil dihapus.');
    }
}
