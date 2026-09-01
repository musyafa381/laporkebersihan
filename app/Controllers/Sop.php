<?php

namespace App\Controllers;

use App\Models\SopModel;
use App\Models\PengaturanModel;

class Sop extends BaseController
{
    protected $sopModel;
    protected $pengaturanModel;

    public function __construct()
    {
        $this->sopModel        = new SopModel();
        $this->pengaturanModel = new PengaturanModel();
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

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('sop'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    public function index()
    {
        $session = session();
        $isLoggedIn = $session->get('isLoggedIn');
        $userRole   = $session->get('role');
        $isAdminOrAuditor = $isLoggedIn && in_array($userRole, ['Admin', 'Auditor']);

        $kategoriFilter = $this->request->getGet('kategori');
        $searchKeyword  = trim($this->request->getGet('q') ?? '');

        $builder = $this->sopModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');

        // Jika bukan admin/auditor, hanya tampilkan yang berstatus 'Aktif'
        if (!$isAdminOrAuditor) {
            $builder->where('status', 'Aktif');
        }

        if (!empty($kategoriFilter) && in_array($kategoriFilter, ['Peraturan', 'Kebijakan', 'Program Utama', 'Panduan'])) {
            $builder->where('kategori', $kategoriFilter);
        }

        if (!empty($searchKeyword)) {
            $builder->groupStart()
                ->like('judul', $searchKeyword)
                ->orLike('sub_judul', $searchKeyword)
                ->orLike('deskripsi', $searchKeyword)
                ->orLike('poin_poin', $searchKeyword)
                ->groupEnd();
        }

        $sopList = $builder->findAll();

        // Hitung statistik per kategori
        $allActiveSop = $this->sopModel->where('status', 'Aktif')->findAll();
        $stats = [
            'total'        => count($allActiveSop),
            'peraturan'    => count(array_filter($allActiveSop, fn($s) => $s['kategori'] === 'Peraturan')),
            'kebijakan'    => count(array_filter($allActiveSop, fn($s) => $s['kategori'] === 'Kebijakan')),
            'program'      => count(array_filter($allActiveSop, fn($s) => $s['kategori'] === 'Program Utama')),
            'panduan'      => count(array_filter($allActiveSop, fn($s) => $s['kategori'] === 'Panduan')),
        ];

        $settings = $this->pengaturanModel->getAllAsMap();

        $data = [
            'title'            => 'SOP, Peraturan & Program Kebersihan - Yayasan Assalafiyyah',
            'sopList'          => $sopList,
            'stats'            => $stats,
            'settings'         => $settings,
            'currentKategori'  => $kategoriFilter,
            'searchKeyword'    => $searchKeyword,
            'isAdminOrAuditor' => $isAdminOrAuditor,
            'isLoggedIn'       => $isLoggedIn,
        ];

        return view('sop/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || !in_array($session->get('role'), ['Admin', 'Auditor'])) {
            return redirect()->to(base_url('sop'))->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Tambah SOP / Regulasi Kebersihan Baru',
            'sop'   => null,
        ];

        return view('sop/form', $data);
    }

    public function edit($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || !in_array($session->get('role'), ['Admin', 'Auditor'])) {
            return redirect()->to(base_url('sop'))->with('error', 'Akses ditolak.');
        }

        $sop = $this->sopModel->find($id);
        if (!$sop) {
            return redirect()->to(base_url('sop'))->with('error', 'Data SOP tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit SOP / Kebijakan: ' . $sop['judul'],
            'sop'   => $sop,
        ];

        return view('sop/form', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || !in_array($session->get('role'), ['Admin', 'Auditor'])) {
            return $this->respondJsonOrRedirect('Akses ditolak. Anda tidak memiliki wewenang mengelola SOP.', false);
        }

        $judul     = trim($this->request->getPost('judul') ?? '');
        $subJudul  = trim($this->request->getPost('sub_judul') ?? '');
        $kategori  = $this->request->getPost('kategori') ?: 'Peraturan';
        $deskripsi = trim($this->request->getPost('deskripsi') ?? '');
        $sasaran   = trim($this->request->getPost('target_sasaran') ?? 'Seluruh Santri & Warga');
        $icon      = trim($this->request->getPost('icon') ?? 'fa-solid fa-file-shield');
        $badgeColor= $this->request->getPost('badge_color') ?: 'emerald';
        $sortOrder = (int)($this->request->getPost('sort_order') ?: 0);
        $status    = $this->request->getPost('status') ?: 'Aktif';

        $rawPoints = $this->request->getPost('poin_list');
        $pointsArr = [];
        if (!empty($rawPoints) && is_array($rawPoints)) {
            foreach ($rawPoints as $pt) {
                $pt = trim($pt);
                if (!empty($pt)) {
                    $pointsArr[] = $pt;
                }
            }
        }

        if (empty($judul)) {
            return $this->respondJsonOrRedirect('Judul SOP / Peraturan wajib diisi.', false);
        }

        $data = [
            'kategori'       => $kategori,
            'judul'          => $judul,
            'sub_judul'      => $subJudul,
            'deskripsi'      => $deskripsi,
            'poin_poin'      => !empty($pointsArr) ? json_encode(array_values($pointsArr)) : null,
            'target_sasaran' => $sasaran,
            'icon'           => $icon,
            'badge_color'    => $badgeColor,
            'sort_order'     => $sortOrder,
            'status'         => $status,
        ];

        $this->sopModel->insert($data);
        return $this->respondJsonOrRedirect('Data SOP / Kebijakan Kebersihan berhasil ditambahkan!');
    }

    public function update($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || !in_array($session->get('role'), ['Admin', 'Auditor'])) {
            return $this->respondJsonOrRedirect('Akses ditolak. Anda tidak memiliki wewenang mengedit SOP.', false);
        }

        $sop = $this->sopModel->find($id);
        if (!$sop) {
            return $this->respondJsonOrRedirect('Data SOP tidak ditemukan.', false);
        }

        $judul     = trim($this->request->getPost('judul') ?? $sop['judul']);
        $subJudul  = trim($this->request->getPost('sub_judul') ?? $sop['sub_judul']);
        $kategori  = $this->request->getPost('kategori') ?: $sop['kategori'];
        $deskripsi = trim($this->request->getPost('deskripsi') ?? $sop['deskripsi']);
        $sasaran   = trim($this->request->getPost('target_sasaran') ?? $sop['target_sasaran']);
        $icon      = trim($this->request->getPost('icon') ?? $sop['icon']);
        $badgeColor= $this->request->getPost('badge_color') ?: $sop['badge_color'];
        $sortOrder = (int)($this->request->getPost('sort_order') ?? $sop['sort_order']);
        $status    = $this->request->getPost('status') ?: $sop['status'];

        $rawPoints = $this->request->getPost('poin_list');
        $pointsArr = [];
        if (!empty($rawPoints) && is_array($rawPoints)) {
            foreach ($rawPoints as $pt) {
                $pt = trim($pt);
                if (!empty($pt)) {
                    $pointsArr[] = $pt;
                }
            }
        }

        if (empty($judul)) {
            return $this->respondJsonOrRedirect('Judul SOP / Peraturan wajib diisi.', false);
        }

        $data = [
            'kategori'       => $kategori,
            'judul'          => $judul,
            'sub_judul'      => $subJudul,
            'deskripsi'      => $deskripsi,
            'poin_poin'      => !empty($pointsArr) ? json_encode(array_values($pointsArr)) : null,
            'target_sasaran' => $sasaran,
            'icon'           => $icon,
            'badge_color'    => $badgeColor,
            'sort_order'     => $sortOrder,
            'status'         => $status,
        ];

        $this->sopModel->update($id, $data);
        return $this->respondJsonOrRedirect('Data SOP / Kebijakan Kebersihan berhasil diperbarui!');
    }

    public function delete($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || !in_array($session->get('role'), ['Admin', 'Auditor'])) {
            return $this->respondJsonOrRedirect('Akses ditolak. Anda tidak memiliki wewenang menghapus SOP.', false);
        }

        $sop = $this->sopModel->find($id);
        if (!$sop) {
            return $this->respondJsonOrRedirect('Data SOP tidak ditemukan.', false);
        }

        $this->sopModel->delete($id);
        return $this->respondJsonOrRedirect('Data SOP / Kebijakan Kebersihan berhasil dihapus.');
    }
}
