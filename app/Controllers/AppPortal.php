<?php

namespace App\Controllers;

use App\Models\BukuLpjModel;
use App\Models\MasterUnitModel;
use App\Models\AlatModel;
use App\Models\PengajuanAlatModel;
use App\Models\CsReportModel;

class AppPortal extends BaseController
{
    protected $bukuModel;
    protected $unitModel;
    protected $alatModel;
    protected $pengajuanModel;
    protected $csModel;

    public function __construct()
    {
        $this->bukuModel      = new BukuLpjModel();
        $this->unitModel      = new MasterUnitModel();
        $this->alatModel      = new AlatModel();
        $this->pengajuanModel = new PengajuanAlatModel();
        $this->csModel        = new CsReportModel();
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai Pengurus / Kader terlebih dahulu untuk mengisi LPJ & Pengajuan Alat.')->send();
        }
    }

    public function index()
    {
        $this->checkAuth();

        $session  = session();
        $userRole = $session->get('role');
        $unitId   = $session->get('unit_id');

        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;
        $bukuAktif = $this->bukuModel->orderBy('id', 'DESC')->first();

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

        $data = [
            'title'       => 'Portal Mobile - GEMERLAP K3L',
            'userUnit'    => $userUnit,
            'bukuAktif'   => $bukuAktif,
            'myPengajuan' => $myPengajuan,
            'myReports'   => $myReports,
        ];

        return view('app_portal/index', $data);
    }

    public function lpj()
    {
        $this->checkAuth();

        $session  = session();
        $unitId   = $session->get('unit_id');
        $userUnit = $unitId ? $this->unitModel->find($unitId) : null;

        if ($userUnit) {
            $uStatus = strtolower(str_replace(['-', ' ', '_'], '', (string)($userUnit['status'] ?? 'aktif')));
            if ($uStatus === 'nonaktif' || $uStatus === 'inactive' || $uStatus === 'tidakaktif') {
                $userUnit = null; // Inactive units do not have active LPJ forms
            }
        }

        $bukuList = $this->bukuModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'    => 'Isi Laporan LPJ Unit Kebersihan',
            'userUnit' => $userUnit,
            'bukuList' => $bukuList,
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
        $alatId = $this->request->getPost('alat_id');
        $jumlah = (int)$this->request->getPost('jumlah');
        $alasan = trim($this->request->getPost('alasan_keperluan') ?? '');

        if (!$alatId || $jumlah <= 0 || empty($alasan)) {
            return redirect()->to('/app/pengajuan-alat')->with('error', 'Semua kolom pengajuan alat wajib diisi.')->withInput();
        }

        $data = [
            'user_id'          => $session->get('userId'),
            'alat_id'          => $alatId,
            'jumlah'           => $jumlah,
            'alasan_keperluan' => $alasan,
            'status'           => 'Pending',
        ];

        $this->pengajuanModel->insert($data);
        return redirect()->to('/app/pengajuan-alat')->with('success', 'Pengajuan alat kebersihan berhasil dikirim ke Admin K3L!');
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

        $myReports = $this->csModel
            ->where('nama_pengirim', $session->get('nama_lengkap'))
            ->orderBy('id', 'DESC')
            ->findAll();

        $pengaturanModel = new \App\Models\PengaturanModel();
        $settings = $pengaturanModel->getAllAsMap();

        $data = [
            'title'        => 'Form Laporan Kendala Kebersihan',
            'captcha_num1' => $session->get('captcha_num1'),
            'captcha_num2' => $session->get('captcha_num2'),
            'settings'     => $settings,
            'myReports'   => $myReports,
        ];

        return view('app_portal/laporan_kebersihan', $data);
    }
}
