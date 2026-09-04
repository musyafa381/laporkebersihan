<?php

namespace App\Controllers;

use App\Models\FaqModel;
use App\Models\FaqAlurModel;

class Faq extends BaseController
{
    protected $faqModel;
    protected $faqAlurModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
        $this->faqAlurModel = new FaqAlurModel();
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

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('faq'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    public function index()
    {
        $session = session();
        $userRole = $session->get('role'); // e.g. 'Admin', 'Auditor', 'Pengurus', 'Kader', null
        $isAdmin = ($userRole === 'Admin');

        // Fetch FAQ Items
        if ($isAdmin) {
            $faqList = $this->faqModel->orderBy('urutan', 'ASC')->orderBy('id', 'ASC')->findAll();
        } else {
            $builder = $this->faqModel->where('status', 'Aktif');
            if ($userRole) {
                $builder->groupStart()
                    ->where('target_role', 'All')
                    ->orWhere('target_role', $userRole)
                    ->orWhere('target_role', 'Publik')
                    ->groupEnd();
            } else {
                $builder->groupStart()
                    ->where('target_role', 'All')
                    ->orWhere('target_role', 'Publik')
                    ->groupEnd();
            }
            $faqList = $builder->orderBy('urutan', 'ASC')->orderBy('id', 'ASC')->findAll();
        }

        // Fetch Workflow Guides (Alur Menu)
        if ($isAdmin) {
            $alurList = $this->faqAlurModel->orderBy('urutan', 'ASC')->orderBy('id', 'ASC')->findAll();
        } else {
            $builder = $this->faqAlurModel->where('status', 'Aktif');
            if ($userRole) {
                $builder->groupStart()
                    ->where('target_role', 'All')
                    ->orWhere('target_role', $userRole)
                    ->orWhere('target_role', 'Publik')
                    ->groupEnd();
            } else {
                $builder->groupStart()
                    ->where('target_role', 'All')
                    ->orWhere('target_role', 'Publik')
                    ->groupEnd();
            }
            $alurList = $builder->orderBy('urutan', 'ASC')->orderBy('id', 'ASC')->findAll();
        }

        // Extract available FAQ categories
        $categories = ['Semua'];
        foreach ($faqList as $f) {
            if (!empty($f['kategori']) && !in_array($f['kategori'], $categories)) {
                $categories[] = $f['kategori'];
            }
        }

        $data = [
            'title'       => 'Pusat Bantuan, FAQ & Panduan Alur Sistem',
            'faqList'     => $faqList,
            'alurList'    => $alurList,
            'categories'  => $categories,
            'userRole'    => $userRole,
            'isAdmin'     => $isAdmin,
        ];

        return view('faq/index', $data);
    }

    // =========================================================================
    // ADMIN ACTIONS: FAQ CRUD
    // =========================================================================

    public function storeFaq()
    {
        if (session()->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak. Hanya Admin yang dapat mengelola FAQ.', false);
        }

        $pertanyaan = trim($this->request->getPost('pertanyaan') ?? '');
        $jawaban    = trim($this->request->getPost('jawaban') ?? '');
        $kategori   = trim($this->request->getPost('kategori') ?: 'Umum');
        $targetRole = $this->request->getPost('target_role') ?: 'All';
        $urutan     = (int)($this->request->getPost('urutan') ?: 1);
        $status     = $this->request->getPost('status') ?: 'Aktif';

        if (empty($pertanyaan) || empty($jawaban)) {
            return $this->respondJsonOrRedirect('Pertanyaan dan jawaban FAQ wajib diisi.', false);
        }

        $this->faqModel->insert([
            'kategori'    => $kategori,
            'pertanyaan'  => $pertanyaan,
            'jawaban'     => $jawaban,
            'target_role' => $targetRole,
            'urutan'      => $urutan,
            'status'      => $status,
        ]);

        return $this->respondJsonOrRedirect('Berhasil menambahkan item FAQ baru!', true, base_url('faq?tab=faq_kelola'));
    }

    public function updateFaq($id)
    {
        if (session()->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak. Hanya Admin yang dapat mengelola FAQ.', false);
        }

        $item = $this->faqModel->find($id);
        if (!$item) {
            return $this->respondJsonOrRedirect('Item FAQ tidak ditemukan.', false);
        }

        $pertanyaan = trim($this->request->getPost('pertanyaan') ?? '');
        $jawaban    = trim($this->request->getPost('jawaban') ?? '');
        $kategori   = trim($this->request->getPost('kategori') ?: $item['kategori']);
        $targetRole = $this->request->getPost('target_role') ?: $item['target_role'];
        $urutan     = (int)($this->request->getPost('urutan') ?: $item['urutan']);
        $status     = $this->request->getPost('status') ?: $item['status'];

        if (empty($pertanyaan) || empty($jawaban)) {
            return $this->respondJsonOrRedirect('Pertanyaan dan jawaban FAQ tidak boleh kosong.', false);
        }

        $this->faqModel->update($id, [
            'kategori'    => $kategori,
            'pertanyaan'  => $pertanyaan,
            'jawaban'     => $jawaban,
            'target_role' => $targetRole,
            'urutan'      => $urutan,
            'status'      => $status,
        ]);

        return $this->respondJsonOrRedirect('Item FAQ berhasil diperbarui!', true, base_url('faq?tab=faq_kelola'));
    }

    public function deleteFaq($id)
    {
        if (session()->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak. Hanya Admin yang dapat mengelola FAQ.', false);
        }

        $item = $this->faqModel->find($id);
        if (!$item) {
            return $this->respondJsonOrRedirect('Item FAQ tidak ditemukan.', false);
        }

        $this->faqModel->delete($id);
        return $this->respondJsonOrRedirect('Item FAQ berhasil dihapus.', true, base_url('faq?tab=faq_kelola'));
    }

    // =========================================================================
    // ADMIN ACTIONS: ALUR GUIDE CRUD
    // =========================================================================

    public function storeAlur()
    {
        if (session()->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak. Hanya Admin yang dapat mengelola Panduan Alur.', false);
        }

        $judul      = trim($this->request->getPost('judul_alur') ?? '');
        $ringkasan  = trim($this->request->getPost('ringkasan') ?? '');
        $icon       = trim($this->request->getPost('icon') ?: 'fa-solid fa-route');
        $badgeColor = $this->request->getPost('badge_color') ?: 'emerald';
        $targetRole = $this->request->getPost('target_role') ?: 'Pengurus';
        $linkMenu   = trim($this->request->getPost('link_menu') ?? '');
        $urutan     = (int)($this->request->getPost('urutan') ?: 1);
        $status     = $this->request->getPost('status') ?: 'Aktif';

        $stepsRaw = $this->request->getPost('steps'); // array of titles/descs
        $steps = [];
        if (is_array($stepsRaw)) {
            foreach ($stepsRaw as $st) {
                if (!empty($st['title'])) {
                    $steps[] = [
                        'title' => trim($st['title']),
                        'desc'  => trim($st['desc'] ?? ''),
                    ];
                }
            }
        }

        if (empty($judul)) {
            return $this->respondJsonOrRedirect('Judul Panduan Alur wajib diisi.', false);
        }

        $this->faqAlurModel->insert([
            'judul_alur'   => $judul,
            'ringkasan'    => $ringkasan,
            'icon'         => $icon,
            'badge_color'  => $badgeColor,
            'steps'        => json_encode($steps),
            'target_role'  => $targetRole,
            'link_menu'    => $linkMenu,
            'urutan'       => $urutan,
            'status'       => $status,
        ]);

        return $this->respondJsonOrRedirect('Berhasil menambahkan Card Panduan Alur baru!', true, base_url('faq?tab=alur_kelola'));
    }

    public function updateAlur($id)
    {
        if (session()->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak. Hanya Admin yang dapat mengelola Panduan Alur.', false);
        }

        $item = $this->faqAlurModel->find($id);
        if (!$item) {
            return $this->respondJsonOrRedirect('Card Panduan Alur tidak ditemukan.', false);
        }

        $judul      = trim($this->request->getPost('judul_alur') ?? '');
        $ringkasan  = trim($this->request->getPost('ringkasan') ?? '');
        $icon       = trim($this->request->getPost('icon') ?: $item['icon']);
        $badgeColor = $this->request->getPost('badge_color') ?: $item['badge_color'];
        $targetRole = $this->request->getPost('target_role') ?: $item['target_role'];
        $linkMenu   = trim($this->request->getPost('link_menu') ?? '');
        $urutan     = (int)($this->request->getPost('urutan') ?: $item['urutan']);
        $status     = $this->request->getPost('status') ?: $item['status'];

        $stepsRaw = $this->request->getPost('steps');
        $steps = [];
        if (is_array($stepsRaw)) {
            foreach ($stepsRaw as $st) {
                if (!empty($st['title'])) {
                    $steps[] = [
                        'title' => trim($st['title']),
                        'desc'  => trim($st['desc'] ?? ''),
                    ];
                }
            }
        }

        if (empty($judul)) {
            return $this->respondJsonOrRedirect('Judul Panduan Alur tidak boleh kosong.', false);
        }

        $this->faqAlurModel->update($id, [
            'judul_alur'   => $judul,
            'ringkasan'    => $ringkasan,
            'icon'         => $icon,
            'badge_color'  => $badgeColor,
            'steps'        => json_encode($steps),
            'target_role'  => $targetRole,
            'link_menu'    => $linkMenu,
            'urutan'       => $urutan,
            'status'       => $status,
        ]);

        return $this->respondJsonOrRedirect('Card Panduan Alur berhasil diperbarui!', true, base_url('faq?tab=alur_kelola'));
    }

    public function deleteAlur($id)
    {
        if (session()->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak. Hanya Admin yang dapat mengelola Panduan Alur.', false);
        }

        $item = $this->faqAlurModel->find($id);
        if (!$item) {
            return $this->respondJsonOrRedirect('Card Panduan Alur tidak ditemukan.', false);
        }

        $this->faqAlurModel->delete($id);
        return $this->respondJsonOrRedirect('Card Panduan Alur berhasil dihapus.', true, base_url('faq?tab=alur_kelola'));
    }
}
