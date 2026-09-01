<?php

namespace App\Controllers;

use App\Models\AlatModel;
use App\Models\AlatTransaksiModel;

class Alat extends BaseController
{
    protected $alatModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->alatModel      = new AlatModel();
        $this->transaksiModel = new AlatTransaksiModel();
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

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('alat'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    private function recalculateStok($alatId)
    {
        $alat = $this->alatModel->find($alatId);
        if (!$alat) return;

        $masukRows = $this->transaksiModel->where('alat_id', $alatId)->where('jenis_transaksi', 'Masuk')->findAll();
        $totalMasuk = 0;
        foreach ($masukRows as $r) {
            $totalMasuk += (int)$r['jumlah'];
        }

        $keluarRows = $this->transaksiModel->where('alat_id', $alatId)->where('jenis_transaksi', 'Keluar')->findAll();
        $totalKeluar = 0;
        foreach ($keluarRows as $r) {
            $totalKeluar += (int)$r['jumlah'];
        }

        $stokAwal = (int)$alat['stok_awal'];
        $stokSisa = $stokAwal + $totalMasuk - $totalKeluar;

        $this->alatModel->update($alatId, [
            'stok_masuk'  => $totalMasuk,
            'stok_keluar' => $totalKeluar,
            'stok_sisa'   => $stokSisa
        ]);
    }

    public function index()
    {
        $alatList = $this->alatModel->orderBy('nama_alat', 'ASC')->findAll();
        
        // Recalculate stock for all items just in case
        foreach ($alatList as &$a) {
            $masuk = $this->transaksiModel->where('alat_id', $a['id'])->where('jenis_transaksi', 'Masuk')->selectSum('jumlah')->first();
            $keluar = $this->transaksiModel->where('alat_id', $a['id'])->where('jenis_transaksi', 'Keluar')->selectSum('jumlah')->first();
            
            $a['stok_masuk']  = (int)($masuk['jumlah'] ?? 0);
            $a['stok_keluar'] = (int)($keluar['jumlah'] ?? 0);
            $a['stok_sisa']   = (int)$a['stok_awal'] + $a['stok_masuk'] - $a['stok_keluar'];
        }

        $transaksiKeluar = $this->transaksiModel
            ->select('alat_transaksi.*, alat_inventaris.nama_alat, alat_inventaris.kode_alat, alat_inventaris.satuan')
            ->join('alat_inventaris', 'alat_inventaris.id = alat_transaksi.alat_id', 'left')
            ->where('jenis_transaksi', 'Keluar')
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        $transaksiMasuk = $this->transaksiModel
            ->select('alat_transaksi.*, alat_inventaris.nama_alat, alat_inventaris.kode_alat, alat_inventaris.satuan')
            ->join('alat_inventaris', 'alat_inventaris.id = alat_transaksi.alat_id', 'left')
            ->where('jenis_transaksi', 'Masuk')
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        // Calculate summary stats
        $totalJenis  = count($alatList);
        $totalMasuk  = 0;
        $totalKeluar = 0;
        $stokKritis  = 0;

        foreach ($alatList as $a) {
            $totalMasuk  += $a['stok_masuk'];
            $totalKeluar += $a['stok_keluar'];
            if ($a['stok_sisa'] <= 5 || $a['kondisi'] === 'Rusak Ringan' || $a['kondisi'] === 'Perlu Diganti') {
                $stokKritis++;
            }
        }

        $data = [
            'title'           => 'Inventaris & Peralatan Kebersihan',
            'alatList'        => $alatList,
            'transaksiKeluar' => $transaksiKeluar,
            'transaksiMasuk'  => $transaksiMasuk,
            'totalJenis'      => $totalJenis,
            'totalMasuk'      => $totalMasuk,
            'totalKeluar'     => $totalKeluar,
            'stokKritis'      => $stokKritis,
        ];

        return view('alat/index', $data);
    }

    public function storeAlat()
    {
        $namaAlat = trim($this->request->getPost('nama_alat') ?? '');
        if (empty($namaAlat)) {
            return $this->respondJsonOrRedirect('Nama alat tidak boleh kosong.', false);
        }

        $kodeAlat = trim($this->request->getPost('kode_alat') ?? '');
        if (empty($kodeAlat)) {
            $kodeAlat = 'ALT-' . strtoupper(substr(md5(uniqid()), 0, 4));
        }

        $stokAwal = (int)$this->request->getPost('stok_awal');

        $data = [
            'kode_alat'     => $kodeAlat,
            'nama_alat'     => $namaAlat,
            'kategori'      => $this->request->getPost('kategori') ?: 'Peralatan Kebersihan',
            'stok_awal'     => $stokAwal,
            'stok_masuk'    => 0,
            'stok_keluar'   => 0,
            'stok_sisa'     => $stokAwal,
            'satuan'        => $this->request->getPost('satuan') ?: 'Pcs',
            'kondisi'       => $this->request->getPost('kondisi') ?: 'Baik',
            'lokasi_gudang' => $this->request->getPost('lokasi_gudang') ?: 'Gudang Utama K3L',
        ];

        $this->alatModel->insert($data);
        return $this->respondJsonOrRedirect('Berhasil menambahkan alat inventaris baru!');
    }

    public function updateAlat($id)
    {
        $alat = $this->alatModel->find($id);
        if (!$alat) {
            return $this->respondJsonOrRedirect('Alat tidak ditemukan.', false);
        }

        $namaAlat = trim($this->request->getPost('nama_alat') ?? '');
        if (empty($namaAlat)) {
            return $this->respondJsonOrRedirect('Nama alat tidak boleh kosong.', false);
        }

        $stokAwal = (int)$this->request->getPost('stok_awal');

        $data = [
            'kode_alat'     => trim($this->request->getPost('kode_alat') ?? $alat['kode_alat']),
            'nama_alat'     => $namaAlat,
            'kategori'      => $this->request->getPost('kategori') ?: $alat['kategori'],
            'stok_awal'     => $stokAwal,
            'satuan'        => $this->request->getPost('satuan') ?: $alat['satuan'],
            'kondisi'       => $this->request->getPost('kondisi') ?: $alat['kondisi'],
            'lokasi_gudang' => $this->request->getPost('lokasi_gudang') ?: $alat['lokasi_gudang'],
        ];

        $this->alatModel->update($id, $data);
        $this->recalculateStok($id);

        return $this->respondJsonOrRedirect('Berhasil memperbarui data alat inventaris!');
    }

    public function deleteAlat($id)
    {
        $alat = $this->alatModel->find($id);
        if (!$alat) {
            return $this->respondJsonOrRedirect('Alat tidak ditemukan.', false);
        }

        $this->alatModel->delete($id);
        return $this->respondJsonOrRedirect('Berhasil menghapus alat dari inventaris!');
    }

    public function storeTransaksi()
    {
        $alatId = $this->request->getPost('alat_id');
        $alat   = $this->alatModel->find($alatId);

        if (!$alat) {
            return $this->respondJsonOrRedirect('Pilihan alat tidak valid.', false);
        }

        $jenis  = $this->request->getPost('jenis_transaksi') ?: 'Keluar';
        $jumlah = (int)$this->request->getPost('jumlah');

        if ($jumlah <= 0) {
            return $this->respondJsonOrRedirect('Jumlah transaksi harus lebih dari 0.', false);
        }

        if ($jenis === 'Keluar' && $jumlah > (int)$alat['stok_sisa']) {
            return $this->respondJsonOrRedirect("Stok sisa di gudang tidak mencukupi! (Sisa: {$alat['stok_sisa']} {$alat['satuan']})", false);
        }

        $data = [
            'alat_id'          => $alatId,
            'jenis_transaksi'  => $jenis,
            'tanggal'          => $this->request->getPost('tanggal') ?: date('Y-m-d'),
            'jumlah'           => $jumlah,
            'penerima_penyerah'=> trim($this->request->getPost('penerima_penyerah') ?? ''),
            'unit_tujuan'      => trim($this->request->getPost('unit_tujuan') ?? ''),
            'keterangan'       => trim($this->request->getPost('keterangan') ?? ''),
        ];

        $this->transaksiModel->insert($data);
        $this->recalculateStok($alatId);

        $msg = ($jenis === 'Keluar') ? 'Berhasil mencatatkan distribusi Barang Keluar!' : 'Berhasil mencatatkan penambahan Barang Masuk!';
        return $this->respondJsonOrRedirect($msg);
    }

    public function deleteTransaksi($id)
    {
        $trx = $this->transaksiModel->find($id);
        if (!$trx) {
            return $this->respondJsonOrRedirect('Transaksi tidak ditemukan.', false);
        }

        $alatId = $trx['alat_id'];
        $this->transaksiModel->delete($id);
        $this->recalculateStok($alatId);

        return $this->respondJsonOrRedirect('Berhasil menghapus riwayat transaksi!');
    }
}
