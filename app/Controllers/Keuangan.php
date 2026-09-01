<?php

namespace App\Controllers;

use App\Models\BukuKeuanganModel;
use App\Models\KeuanganMasukModel;
use App\Models\KeuanganItemModel;

class Keuangan extends BaseController
{
    protected $bukuKeuanganModel;
    protected $keuanganMasukModel;
    protected $keuanganItemModel;

    public function __construct()
    {
        $this->bukuKeuanganModel  = new BukuKeuanganModel();
        $this->keuanganMasukModel = new KeuanganMasukModel();
        $this->keuanganItemModel  = new KeuanganItemModel();
    }

    protected function respondJsonOrRedirect($message, $success = true, $redirectUrl = null, $data = [])
    {
        $isAjax = $this->request->isAJAX() 
               || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest'
               || stripos($this->request->getHeaderLine('Accept'), 'application/json') !== false;

        if ($isAjax) {
            $jsonData = array_merge([
                'status'  => $success ? 'success' : 'error',
                'message' => $message,
            ], $data);
            if ($redirectUrl) {
                $jsonData['redirect'] = (strpos($redirectUrl, 'http://') === 0 || strpos($redirectUrl, 'https://') === 0) 
                    ? $redirectUrl 
                    : base_url(ltrim($redirectUrl, '/'));
            }
            return $this->response->setJSON($jsonData);
        }

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('keuangan'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    protected function sortByTahunBulan(&$list, $order = 'ASC')
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

    public function index()
    {
        $keuanganList = $this->bukuKeuanganModel->findAll();
        $this->sortByTahunBulan($keuanganList, 'ASC');

        foreach ($keuanganList as &$buku) {
            $kId = $buku['id'];
            $masukList     = $this->keuanganMasukModel->where('keuangan_id', $kId)->findAll();
            $pembelianList = $this->keuanganItemModel->where('keuangan_id', $kId)->findAll();

            $totalMasuk = 0;
            foreach ($masukList as $m) {
                $totalMasuk += (float)$m['nominal'];
            }

            $totalPlafon   = 0;
            $totalTerserap = 0;
            foreach ($pembelianList as $p) {
                $totalPlafon   += (float)$p['plafon'];
                $totalTerserap += (float)$p['terserap'];
            }

            $buku['total_masuk']    = $totalMasuk;
            $buku['total_plafon']   = $totalPlafon;
            $buku['total_terserap'] = $totalTerserap;
            $buku['saldo_sisa']     = $totalMasuk - $totalTerserap;
            $buku['total_items']    = count($pembelianList);
        }

        $data = [
            'title'         => 'Daftar Laporan Keuangan Kebersihan',
            'keuangan_list' => $keuanganList,
        ];

        return view('keuangan/index', $data);
    }

    protected function generateKodeKeuangan($bulan, $tahun)
    {
        $blnMap = [
            'Januari'=>'01', 'Februari'=>'02', 'Maret'=>'03', 'April'=>'04',
            'Mei'=>'05', 'Juni'=>'06', 'Juli'=>'07', 'Agustus'=>'08',
            'September'=>'09', 'Oktober'=>'10', 'November'=>'11', 'Desember'=>'12'
        ];
        $bNum = $blnMap[$bulan] ?? '01';
        return "KUG-{$tahun}-{$bNum}";
    }

    public function store()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $kode  = trim($this->request->getPost('kode_keuangan') ?? '');

        if (!$bulan || !$tahun) {
            return $this->respondJsonOrRedirect('Bulan dan Tahun wajib dipilih!', false);
        }

        if (empty($kode)) {
            $kode = $this->generateKodeKeuangan($bulan, $tahun);
        }

        // Check if already exists for month and year
        $existing = $this->bukuKeuanganModel->where('bulan', $bulan)->where('tahun', $tahun)->first();
        if ($existing) {
            return $this->respondJsonOrRedirect("Buku Keuangan Bulan {$bulan} {$tahun} sudah ada!", false);
        }

        $judul = "Laporan Keuangan Kebersihan Bulan {$bulan} {$tahun}";

        $newId = $this->bukuKeuanganModel->insert([
            'kode_keuangan' => $kode,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'judul'         => $judul,
        ]);

        return $this->respondJsonOrRedirect('Buku Keuangan Berhasil Dibuat!', true, "/keuangan/detail/{$newId}");
    }

    public function update($id)
    {
        $buku = $this->bukuKeuanganModel->find($id);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku Keuangan tidak ditemukan!', false);
        }

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $kode  = trim($this->request->getPost('kode_keuangan') ?? '');

        if (!$bulan || !$tahun) {
            return $this->respondJsonOrRedirect('Bulan dan Tahun wajib diisi!', false);
        }

        if (empty($kode)) {
            $kode = $this->generateKodeKeuangan($bulan, $tahun);
        }

        $judul = "Laporan Keuangan Kebersihan Bulan {$bulan} {$tahun}";

        $this->bukuKeuanganModel->update($id, [
            'kode_keuangan' => $kode,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'judul'         => $judul,
        ]);

        return $this->respondJsonOrRedirect('Informasi Buku Keuangan Berhasil Diperbarui!');
    }

    public function detail($id)
    {
        $buku = $this->bukuKeuanganModel->find($id);
        if (!$buku) {
            return redirect()->to('/keuangan')->with('error', 'Buku Keuangan tidak ditemukan!');
        }

        $keuanganMasuk     = $this->keuanganMasukModel->where('keuangan_id', $id)->orderBy('id', 'ASC')->findAll();
        $keuanganPembelian = $this->keuanganItemModel->where('keuangan_id', $id)->orderBy('id', 'ASC')->findAll();

        $data = [
            'title'             => $buku['judul'],
            'buku'              => $buku,
            'keuanganMasuk'     => $keuanganMasuk,
            'keuanganPembelian' => $keuanganPembelian,
        ];

        return view('keuangan/detail', $data);
    }

    public function delete($id)
    {
        $this->keuanganMasukModel->where('keuangan_id', $id)->delete();
        $this->keuanganItemModel->where('keuangan_id', $id)->delete();
        $this->bukuKeuanganModel->delete($id);

        return $this->respondJsonOrRedirect('Buku Keuangan Berhasil Dihapus!', true, '/keuangan');
    }

    public function storeKeuanganMasuk($keuangan_id)
    {
        $buku = $this->bukuKeuanganModel->find($keuangan_id);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku Keuangan tidak ditemukan!', false);
        }

        $sumberDanaArr = $this->request->getPost('sumber_dana');
        $nominalArr    = $this->request->getPost('nominal');
        $keteranganArr = $this->request->getPost('keterangan');

        if (is_array($sumberDanaArr)) {
            $this->keuanganMasukModel->where('keuangan_id', $keuangan_id)->delete();
            foreach ($sumberDanaArr as $idx => $sumber) {
                $s = trim($sumber ?? '');
                $nomRaw = $nominalArr[$idx] ?? 0;
                $nom = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$nomRaw));
                $ket = trim($keteranganArr[$idx] ?? '');

                if ($s !== '' || $nom > 0) {
                    $this->keuanganMasukModel->insert([
                        'keuangan_id' => $keuangan_id,
                        'sumber_dana' => $s,
                        'nominal'     => $nom,
                        'keterangan'  => $ket,
                    ]);
                }
            }
            return $this->respondJsonOrRedirect('Data Informasi Dana Masuk Berhasil Disimpan!');
        }

        return $this->respondJsonOrRedirect('Gagal menyimpan data dana masuk.', false);
    }

    public function storeKeuanganPembelian($keuangan_id)
    {
        $buku = $this->bukuKeuanganModel->find($keuangan_id);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku Keuangan tidak ditemukan!', false);
        }

        $itemArr     = $this->request->getPost('item_pembelian');
        $plafonArr   = $this->request->getPost('plafon');
        $terserapArr = $this->request->getPost('terserap');

        if (is_array($itemArr)) {
            $this->keuanganItemModel->where('keuangan_id', $keuangan_id)->delete();
            foreach ($itemArr as $idx => $item) {
                $it = trim($item ?? '');
                $pRaw = $plafonArr[$idx] ?? 0;
                $tRaw = $terserapArr[$idx] ?? 0;

                $plafon  = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$pRaw));
                $terserap = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$tRaw));

                if ($it !== '' || $plafon > 0 || $terserap > 0) {
                    $this->keuanganItemModel->insert([
                        'keuangan_id'    => $keuangan_id,
                        'item_pembelian' => $it,
                        'plafon'         => $plafon,
                        'terserap'       => $terserap,
                    ]);
                }
            }
            return $this->respondJsonOrRedirect('Data Laporan Item Pembelian Berhasil Disimpan!');
        }

        return $this->respondJsonOrRedirect('Gagal menyimpan data item pembelian.', false);
    }

    public function cetak($id)
    {
        $buku = $this->bukuKeuanganModel->find($id);
        if (!$buku) {
            return 'Buku Keuangan tidak ditemukan.';
        }

        $keuanganMasuk     = $this->keuanganMasukModel->where('keuangan_id', $id)->orderBy('id', 'ASC')->findAll();
        $keuanganPembelian = $this->keuanganItemModel->where('keuangan_id', $id)->orderBy('id', 'ASC')->findAll();

        $pengaturanModel = new \App\Models\PengaturanModel();
        $settings = $pengaturanModel->getAllAsMap();

        $data = [
            'buku'              => $buku,
            'keuanganMasuk'     => $keuanganMasuk,
            'keuanganPembelian' => $keuanganPembelian,
            'settings'          => $settings,
        ];

        return view('keuangan/cetak', $data);
    }
}
