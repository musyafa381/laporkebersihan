<?php

namespace App\Controllers;

use App\Models\BukuLpjModel;
use App\Models\BukuKeuanganModel;
use App\Models\AlatModel;
use App\Models\CsReportModel;
use App\Models\MasterUnitModel;

class Home extends BaseController
{
    public function index()
    {
        $bukuModel     = new BukuLpjModel();
        $keuanganModel = new BukuKeuanganModel();
        $alatModel     = new AlatModel();
        $csModel       = new CsReportModel();
        $unitModel     = new MasterUnitModel();

        $totalBuku     = $bukuModel->countAllResults();
        $totalKeuangan = $keuanganModel->countAllResults();
        $totalAlat     = $alatModel->countAllResults();
        $totalCs       = $csModel->countAllResults();
        $totalUnit     = $unitModel->countAllResults();

        // Recent public LPJ books
        $latestLpj = $bukuModel->orderBy('id', 'DESC')->findAll(3);

        $pengaturanModel = new \App\Models\PengaturanModel();
        $settings        = $pengaturanModel->getAllAsMap();
        $hotlineWa       = !empty($settings['hotline_wa']) && $settings['hotline_wa'] !== '081234567890' ? $settings['hotline_wa'] : '0895320276800';

        $data = [
            'title'         => 'Website resmi pengaduan dan pengelolaan kebersihan Assalafiyyah Mlangi - Admin ' . $hotlineWa,
            'hotlineWa'     => $hotlineWa,
            'totalBuku'     => $totalBuku,
            'totalKeuangan' => $totalKeuangan,
            'totalAlat'     => $totalAlat,
            'totalCs'       => $totalCs,
            'totalUnit'     => $totalUnit,
            'latestLpj'     => $latestLpj,
        ];

        return view('home/index', $data);
    }
}
