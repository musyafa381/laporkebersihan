<?php

namespace App\Controllers;

use App\Models\BukuLpjModel;
use App\Models\MasterUnitModel;
use App\Models\ProkerAgendaModel;
use App\Models\TargetBulananModel;
use App\Models\LaporanKoordinasiModel;
use App\Models\CapaianEvaluasiModel;
use App\Models\CapaianBulananModel;
use App\Models\EvaluasiBulananModel;
use App\Models\KeuanganMasukModel;
use App\Models\KeuanganItemModel;

class Buku extends BaseController
{
    protected $bukuModel;
    protected $unitModel;
    protected $prokerModel;
    protected $targetModel;
    protected $koordinasiModel;
    protected $evaluasiModel;
    protected $capaianBulananModel;
    protected $evaluasiBulananModel;
    protected $keuanganMasukModel;
    protected $keuanganItemModel;

    public function __construct()
    {
        $this->bukuModel            = new BukuLpjModel();
        $this->unitModel            = new MasterUnitModel();
        $this->prokerModel          = new ProkerAgendaModel();
        $this->targetModel          = new TargetBulananModel();
        $this->koordinasiModel      = new LaporanKoordinasiModel();
        $this->evaluasiModel        = new CapaianEvaluasiModel();
        $this->capaianBulananModel  = new CapaianBulananModel();
        $this->evaluasiBulananModel = new EvaluasiBulananModel();
        $this->keuanganMasukModel   = new KeuanganMasukModel();
        $this->keuanganItemModel    = new KeuanganItemModel();
    }

    protected function normalizeStatus($status)
    {
        if (empty($status)) {
            return 'Draft Proker';
        }

        $s = strtolower(trim((string)$status));

        if (stripos($s, 'draft') !== false || stripos($s, 'proker') !== false) {
            return 'Draft Proker';
        }
        if (stripos($s, 'selesai') !== false || stripos($s, 'done') !== false || stripos($s, 'completed') !== false) {
            return 'Selesai';
        }
        if (stripos($s, 'aktif') !== false || stripos($s, 'berjalan') !== false || stripos($s, 'active') !== false) {
            return 'Aktif';
        }

        return 'Draft Proker';
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

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('buku'));
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
        $bukuList = $this->bukuModel->findAll();
        $this->sortByTahunBulan($bukuList, 'ASC');
        
        // Enrich each book with count stats and normalized status
        foreach ($bukuList as &$buku) {
            $buku['status']           = $this->normalizeStatus($buku['status']);
            $buku['total_proker']     = $this->prokerModel->where('buku_id', $buku['id'])->countAllResults();
            $buku['total_koordinasi'] = $this->koordinasiModel->where('buku_id', $buku['id'])->countAllResults();
            $buku['total_targets']    = $this->targetModel->where('buku_id', $buku['id'])->countAllResults();
        }

        $data = [
            'title'     => 'Daftar Buku LPJ Kebersihan Bulanan',
            'buku_list' => $bukuList,
        ];
        return view('buku/index', $data);
    }

    public function store()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if (!$bulan || !$tahun) {
            return $this->respondJsonOrRedirect('Bulan dan Tahun wajib diisi!', false);
        }

        $judul = "Laporan Pertanggungjawaban (LPJ) Kebersihan Bulan {$bulan} {$tahun}";

        $this->bukuModel->insert([
            'judul'  => $judul,
            'bulan'  => $bulan,
            'tahun'  => $tahun,
            'status' => 'Draft Proker',
        ]);

        return $this->respondJsonOrRedirect('Buku LPJ Baru Berhasil Dibuat!', true, '/buku');
    }

    public function updateBuku($id)
    {
        $judul  = $this->request->getPost('judul');
        $bulan  = $this->request->getPost('bulan');
        $tahun  = $this->request->getPost('tahun');
        $status = $this->normalizeStatus($this->request->getPost('status'));

        if (!$id || !$bulan || !$tahun) {
            return $this->respondJsonOrRedirect('Data tidak valid.', false);
        }

        if (empty($judul)) {
            $judul = "Laporan Pertanggungjawaban (LPJ) Kebersihan Bulan {$bulan} {$tahun}";
        }

        $this->bukuModel->update($id, [
            'judul'  => $judul,
            'bulan'  => $bulan,
            'tahun'  => $tahun,
            'status' => $status,
        ]);

        return $this->respondJsonOrRedirect('Data Buku LPJ Berhasil Diperbarui!', true, '/buku');
    }

    public function deleteBuku($id)
    {
        // Delete related children
        $this->prokerModel->where('buku_id', $id)->delete();
        $this->targetModel->where('buku_id', $id)->delete();
        $this->koordinasiModel->where('buku_id', $id)->delete();
        $this->evaluasiModel->where('buku_id', $id)->delete();

        // Delete parent book
        $this->bukuModel->delete($id);

        return $this->respondJsonOrRedirect('Buku LPJ Berhasil Dihapus!', true, '/buku');
    }

    public function detail($id)
    {
        $buku = $this->bukuModel->find($id);
        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku LPJ tidak ditemukan!');
        }

        $buku['status'] = $this->normalizeStatus($buku['status']);

        $allUnits            = $this->unitModel->findAll();
        $units               = [];
        $kaderUnits          = [];
        foreach ($allUnits as $u) {
            $uStatus = strtolower(str_replace(['-', ' ', '_'], '', (string)($u['status'] ?? 'aktif')));
            if ($uStatus === 'nonaktif' || $uStatus === 'inactive' || $uStatus === 'tidakaktif') {
                continue;
            }

            $isKader = (($u['jenis_laporan'] ?? 'unit') === 'kader')
                || stripos($u['tipe'] ?? '', 'Kader') !== false
                || stripos($u['tipe'] ?? '', 'Posko') !== false
                || stripos($u['tipe'] ?? '', 'Gemerlap') !== false
                || stripos($u['nama_unit'] ?? '', 'GEMERLAP ') === 0
                || stripos($u['nama_unit'] ?? '', 'Satgas Kebersihan ') === 0;

            if ($isKader) {
                $kaderUnits[] = $u;
            } else {
                $units[] = $u;
            }
        }

        $proker              = $this->prokerModel->where('buku_id', $id)->orderBy('tanggal', 'ASC')->findAll();
        $targets             = $this->targetModel->where('buku_id', $id)->findAll();
        $capaianList         = $this->capaianBulananModel->where('buku_id', $id)->findAll();
        $evaluasiBulananList = $this->evaluasiBulananModel->where('buku_id', $id)->findAll();
        $koordinasi          = $this->koordinasiModel->where('buku_id', $id)->orderBy('id', 'ASC')->findAll();
        $koordinasiMap = [];
        foreach ($koordinasi as $k) {
            if (!empty($k['proker_id'])) {
                $koordinasiMap[$k['proker_id']] = $k;
            } elseif (!empty($k['kegiatan'])) {
                foreach ($proker as $p) {
                    if (trim(strtolower($p['kegiatan'])) === trim(strtolower($k['kegiatan']))) {
                        $koordinasiMap[$p['id']] = $k;
                        break;
                    }
                }
            }
        }
        $evaluasiRaw = $this->evaluasiModel->where('buku_id', $id)->findAll();

        $evaluasiMap = [];
        foreach ($evaluasiRaw as $ev) {
            $evaluasiMap[$ev['unit_id']] = $ev;
        }

        $bukuKeuanganModel = new \App\Models\BukuKeuanganModel();
        $allKeuanganBooks  = $bukuKeuanganModel->findAll();
        $this->sortByTahunBulan($allKeuanganBooks, 'ASC');

        $importedKeuangan = null;
        $keuanganMasuk = [];
        $keuanganPembelian = [];

        if (!empty($buku['keuangan_id'])) {
            $importedKeuangan = $bukuKeuanganModel->find($buku['keuangan_id']);
            if ($importedKeuangan) {
                $keuanganMasuk     = $this->keuanganMasukModel->where('keuangan_id', $importedKeuangan['id'])->orderBy('id', 'ASC')->findAll();
                $keuanganPembelian = $this->keuanganItemModel->where('keuangan_id', $importedKeuangan['id'])->orderBy('id', 'ASC')->findAll();
            }
        }

        $data = [
            'title'               => $buku['judul'],
            'buku'                => $buku,
            'units'               => $units,
            'kaderUnits'          => $kaderUnits,
            'proker'              => $proker,
            'targets'             => $targets,
            'capaianList'         => $capaianList,
            'evaluasiBulananList' => $evaluasiBulananList,
            'koordinasi'          => $koordinasi,
            'koordinasiMap'       => $koordinasiMap,
            'evaluasiMap'         => $evaluasiMap,
            'allKeuanganBooks'    => $allKeuanganBooks,
            'importedKeuangan'    => $importedKeuangan,
            'keuanganMasuk'       => $keuanganMasuk,
            'keuanganPembelian'   => $keuanganPembelian,
        ];

        return view('buku/detail', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->normalizeStatus($this->request->getPost('status'));
        $this->bukuModel->update($id, ['status' => $status]);
        return $this->respondJsonOrRedirect('Status Buku LPJ berhasil diperbarui.');
    }

    public function storeProker($bukuId)
    {
        $tanggal  = $this->request->getPost('tanggal');
        $kegiatan = $this->request->getPost('kegiatan');
        $ket      = $this->request->getPost('keterangan');
        $badge    = $this->request->getPost('kategori_badge');

        $this->prokerModel->insert([
            'buku_id'        => $bukuId,
            'tanggal'        => $tanggal,
            'kegiatan'       => $kegiatan,
            'keterangan'     => $ket,
            'kategori_badge' => $badge,
        ]);

        return $this->respondJsonOrRedirect('Agenda Proker berhasil ditambahkan!');
    }

    public function updateProker($prokerId)
    {
        $tanggal  = $this->request->getPost('tanggal');
        $kegiatan = $this->request->getPost('kegiatan');
        $ket      = $this->request->getPost('keterangan');
        $badge    = $this->request->getPost('kategori_badge');

        $this->prokerModel->update($prokerId, [
            'tanggal'        => $tanggal,
            'kegiatan'       => $kegiatan,
            'keterangan'     => $ket,
            'kategori_badge' => $badge,
        ]);

        return $this->respondJsonOrRedirect('Agenda Proker berhasil diperbarui!');
    }

    public function deleteProker($prokerId)
    {
        $this->prokerModel->delete($prokerId);
        return $this->respondJsonOrRedirect('Agenda Proker berhasil dihapus.');
    }

    public function storeTarget($bukuId)
    {
        $targetTexts = $this->request->getPost('target_text');
        
        $this->targetModel->where('buku_id', $bukuId)->delete();
        
        if (is_array($targetTexts)) {
            foreach ($targetTexts as $text) {
                $textClean = trim($text);
                if ($textClean !== '') {
                    $this->targetModel->insert([
                        'buku_id'     => $bukuId,
                        'target_text' => $textClean,
                        'kategori'    => 'Umum',
                    ]);
                }
            }
        } elseif (!empty($targetTexts)) {
            $this->targetModel->insert([
                'buku_id'     => $bukuId,
                'target_text' => trim($targetTexts),
                'kategori'    => 'Umum',
            ]);
        }

        return $this->respondJsonOrRedirect('Target Utama Kebersihan berhasil disimpan!');
    }

    public function deleteTarget($targetId)
    {
        $this->targetModel->delete($targetId);
        return $this->respondJsonOrRedirect('Target Bulanan berhasil dihapus.');
    }

    public function storeCapaian($bukuId)
    {
        $capaianTexts = $this->request->getPost('capaian_text');
        
        $this->capaianBulananModel->where('buku_id', $bukuId)->delete();
        
        if (is_array($capaianTexts)) {
            foreach ($capaianTexts as $text) {
                $textClean = trim($text);
                if ($textClean !== '') {
                    $this->capaianBulananModel->insert([
                        'buku_id'      => $bukuId,
                        'capaian_text' => $textClean,
                    ]);
                }
            }
        } elseif (!empty($capaianTexts)) {
            $this->capaianBulananModel->insert([
                'buku_id'      => $bukuId,
                'capaian_text' => trim($capaianTexts),
            ]);
        }

        return $this->respondJsonOrRedirect('Capaian Utama Kebersihan berhasil disimpan!');
    }

    public function deleteCapaian($capaianId)
    {
        $this->capaianBulananModel->delete($capaianId);
        return $this->respondJsonOrRedirect('Capaian Utama Bulanan berhasil dihapus.');
    }

    public function storeEvaluasiBulanan($bukuId)
    {
        $evaluasiTexts = $this->request->getPost('evaluasi_text');
        
        $this->evaluasiBulananModel->where('buku_id', $bukuId)->delete();
        
        if (is_array($evaluasiTexts)) {
            foreach ($evaluasiTexts as $text) {
                $textClean = trim($text);
                if ($textClean !== '') {
                    $this->evaluasiBulananModel->insert([
                        'buku_id'       => $bukuId,
                        'evaluasi_text' => $textClean,
                    ]);
                }
            }
        } elseif (!empty($evaluasiTexts)) {
            $this->evaluasiBulananModel->insert([
                'buku_id'       => $bukuId,
                'evaluasi_text' => trim($evaluasiTexts),
            ]);
        }

        return $this->respondJsonOrRedirect('Evaluasi Utama Kebersihan berhasil disimpan!');
    }

    public function deleteEvaluasiBulanan($evaluasiId)
    {
        $this->evaluasiBulananModel->delete($evaluasiId);
        return $this->respondJsonOrRedirect('Evaluasi Utama Bulanan berhasil dihapus.');
    }

    public function storeKoordinasi($bukuId)
    {
        $prokerId     = $this->request->getPost('proker_id');
        $kegiatan     = $this->request->getPost('kegiatan');
        $hariTanggal  = $this->request->getPost('hari_tanggal');
        $tempat       = $this->request->getPost('tempat');
        $bersama      = $this->request->getPost('bersama');
        $hasil        = $this->request->getPost('hasil_materi');
        $fotoPosition = $this->request->getPost('foto_position') ?: '50% 50%';
        $jenis        = $this->request->getPost('jenis') ?? 'terjadwal';

        $fotoFile = $this->request->getFile('foto');
        $fotoName = null;

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if ($fotoFile->getSize() > 3 * 1024 * 1024) {
                return $this->respondJsonOrRedirect('Ukuran foto dokumentasi melebihi batas maksimal 3MB.', false);
            }
            $uploadDir = FCPATH . 'uploads';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fotoName = $fotoFile->getRandomName();
            $fotoFile->move($uploadDir, $fotoName);
        }

        $existing = null;
        if ($prokerId) {
            $existing = $this->koordinasiModel->where(['buku_id' => $bukuId, 'proker_id' => $prokerId])->first();
        }
        if (!$existing && !empty($kegiatan)) {
            $existing = $this->koordinasiModel->where(['buku_id' => $bukuId, 'kegiatan' => $kegiatan])->first();
        }

        if ($existing) {
            $updateData = [
                'proker_id'     => $prokerId ?: $existing['proker_id'],
                'tempat'        => $tempat,
                'bersama'       => $bersama,
                'hasil_materi'  => $hasil,
                'foto_position' => $fotoPosition,
            ];
            if ($kegiatan) $updateData['kegiatan'] = $kegiatan;
            if ($hariTanggal) $updateData['hari_tanggal'] = $hariTanggal;
            if ($fotoName) $updateData['foto'] = $fotoName;

            $this->koordinasiModel->update($existing['id'], $updateData);
        } else {
            $this->koordinasiModel->insert([
                'buku_id'       => $bukuId,
                'proker_id'     => $prokerId,
                'kegiatan'      => $kegiatan,
                'hari_tanggal'  => $hariTanggal,
                'tempat'        => $tempat,
                'bersama'       => $bersama,
                'hasil_materi'  => $hasil,
                'foto'          => $fotoName,
                'foto_position' => $fotoPosition,
                'jenis'         => $jenis,
            ]);
        }

        return $this->respondJsonOrRedirect('Laporan Hasil Koordinasi berhasil disimpan!');
    }

    public function deleteKoordinasi($id)
    {
        $this->koordinasiModel->delete($id);
        return $this->respondJsonOrRedirect('Laporan Hasil Koordinasi berhasil dihapus.');
    }

    public function deleteFotoKoordinasi($id)
    {
        $koordinasi = $this->koordinasiModel->find($id);
        if ($koordinasi) {
            if (!empty($koordinasi['foto']) && file_exists(FCPATH . 'uploads/' . $koordinasi['foto'])) {
                @unlink(FCPATH . 'uploads/' . $koordinasi['foto']);
            }
            $this->koordinasiModel->update($id, [
                'foto'          => null,
                'foto_position' => '50% 50%',
            ]);
            $bukuId = $koordinasi['buku_id'];
            return $this->respondJsonOrRedirect('Foto dokumentasi berhasil dihapus!', true, '/buku/detail/' . $bukuId . '?tab=koordinasi');
        }

        return redirect()->to('/buku');
    }

    public function formEvaluasi($bukuId, $unitId)
    {
        $buku = $this->bukuModel->find($bukuId);
        $unit = $this->unitModel->find($unitId);

        if (!$buku || !$unit) {
            return redirect()->to('/buku')->with('error', 'Data tidak ditemukan!');
        }

        $evaluasi = $this->evaluasiModel->where([
            'buku_id' => $bukuId,
            'unit_id' => $unitId,
        ])->first();

        $data = [
            'title'    => 'Laporan Unit: ' . $unit['nama_unit'],
            'buku'     => $buku,
            'unit'     => $unit,
            'evaluasi' => $evaluasi,
        ];

        return view('buku/form_evaluasi', $data);
    }

    public function storeEvaluasi($bukuId)
    {
        $unitId       = $this->request->getPost('unit_id');
        $capaian      = $this->request->getPost('capaian_text');
        $target       = $this->request->getPost('target_text');
        $permasalahan = $this->request->getPost('permasalahan_text');
        $evaluasi     = $this->request->getPost('evaluasi_solusi_text');
        $usulan       = $this->request->getPost('usulan_text');

        // 1. Process Capaian Array (Single Column Repeater)
        $capaianArr = $this->request->getPost('capaian');
        if (is_array($capaianArr)) {
            $cClean = [];
            foreach ($capaianArr as $c) {
                if (trim($c) !== '') $cClean[] = trim($c);
            }
            $capaian = json_encode($cClean, JSON_UNESCAPED_UNICODE);
        }

        // 2. Process Target & Tindakan Array (2 Column Repeater)
        $targetItemArr     = $this->request->getPost('target_item');
        $targetTindakanArr = $this->request->getPost('target_tindakan');
        if (is_array($targetItemArr) && is_array($targetTindakanArr)) {
            $tCombined = [];
            foreach ($targetItemArr as $i => $tg) {
                $tt = $targetTindakanArr[$i] ?? '';
                if (trim($tg) !== '' || trim($tt) !== '') {
                    $tCombined[] = [
                        'target'   => trim($tg),
                        'tindakan' => trim($tt),
                    ];
                }
            }
            $target = json_encode($tCombined, JSON_UNESCAPED_UNICODE);
        }

        // 3. Process Permasalahan & Tindakan Array (2 Column Repeater)
        $masalahArr  = $this->request->getPost('masalah');
        $tindakanArr = $this->request->getPost('tindakan');

        if (is_array($masalahArr) && is_array($tindakanArr)) {
            $combined = [];
            $evaluasiLines = [];
            foreach ($masalahArr as $i => $m) {
                $t = $tindakanArr[$i] ?? '';
                if (trim($m) !== '' || trim($t) !== '') {
                    $combined[] = [
                        'masalah'  => trim($m),
                        'tindakan' => trim($t),
                    ];
                    $idx = count($combined);
                    if (trim($t) !== '') {
                        $evaluasiLines[] = "$idx. " . trim($t);
                    }
                }
            }
            $permasalahan = json_encode($combined, JSON_UNESCAPED_UNICODE);
            if (!empty($evaluasiLines)) {
                $evaluasi = implode("\n", $evaluasiLines);
            }
        }

        // 4. Process Usulan Array (Single Column Repeater)
        $usulanArr = $this->request->getPost('usulan');
        if (is_array($usulanArr)) {
            $uClean = [];
            foreach ($usulanArr as $u) {
                if (trim($u) !== '') $uClean[] = trim($u);
            }
            $usulan = json_encode($uClean, JSON_UNESCAPED_UNICODE);
        }

        $existing = $this->evaluasiModel->where([
            'buku_id' => $bukuId,
            'unit_id' => $unitId,
        ])->first();

        if ($existing) {
            $this->evaluasiModel->update($existing['id'], [
                'capaian_text'         => $capaian,
                'target_text'          => $target,
                'permasalahan_text'    => $permasalahan,
                'evaluasi_solusi_text' => $evaluasi,
                'usulan_text'          => $usulan,
            ]);
        } else {
            $this->evaluasiModel->insert([
                'buku_id'              => $bukuId,
                'unit_id'              => $unitId,
                'capaian_text'         => $capaian,
                'target_text'          => $target,
                'permasalahan_text'    => $permasalahan,
                'evaluasi_solusi_text' => $evaluasi,
                'usulan_text'          => $usulan,
            ]);
        }

        $role = session()->get('role');
        if (in_array($role, ['Pengurus', 'Kader'])) {
            return $this->respondJsonOrRedirect('Laporan LPJ Unit Kebersihan Anda berhasil diperbarui!', true, '/app/lpj');
        }

        return $this->respondJsonOrRedirect('Laporan Unit berhasil diperbarui!', true, '/buku/detail/' . $bukuId . '?tab=evaluasi');
    }

    public function storeUnit()
    {
        $nama         = $this->request->getPost('nama_unit');
        $tipe         = $this->request->getPost('tipe') ?? $this->request->getPost('kategori') ?? 'Asrama';
        $jenisLaporan = $this->request->getPost('jenis_laporan') ?? 'unit';

        if (!empty($nama)) {
            $this->unitModel->insert([
                'nama_unit'     => $nama,
                'tipe'          => $tipe,
                'jenis_laporan' => $jenisLaporan,
            ]);
        }

        $msg = ($jenisLaporan === 'kader') ? 'Unit Kader Kebersihan Baru Berhasil Ditambahkan!' : 'Unit Kebersihan Baru Berhasil Ditambahkan!';
        return $this->respondJsonOrRedirect($msg);
    }

    public function deleteUnit($id)
    {
        $this->unitModel->delete($id);
        return $this->respondJsonOrRedirect('Unit Kebersihan Berhasil Dihapus!');
    }

    public function storeKeuanganMasuk($buku_id)
    {
        $buku = $this->bukuModel->find($buku_id);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku LPJ tidak ditemukan!', false);
        }

        $sumberDanaArr = $this->request->getPost('sumber_dana');
        $nominalArr    = $this->request->getPost('nominal');
        $keteranganArr = $this->request->getPost('keterangan');

        if (is_array($sumberDanaArr)) {
            $this->keuanganMasukModel->where('buku_id', $buku_id)->delete();
            foreach ($sumberDanaArr as $idx => $sumber) {
                $s = trim($sumber ?? '');
                $nomRaw = $nominalArr[$idx] ?? 0;
                $nom = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$nomRaw));
                $ket = trim($keteranganArr[$idx] ?? '');

                if ($s !== '' || $nom > 0) {
                    $this->keuanganMasukModel->insert([
                        'buku_id'     => $buku_id,
                        'sumber_dana' => $s,
                        'nominal'     => $nom,
                        'keterangan'  => $ket,
                    ]);
                }
            }
            return $this->respondJsonOrRedirect('Data Informasi Dana Masuk Berhasil Disimpan!');
        }

        $sumber = trim($this->request->getPost('sumber_dana') ?? '');
        $nomRaw = $this->request->getPost('nominal') ?? 0;
        $nom    = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$nomRaw));
        $ket    = trim($this->request->getPost('keterangan') ?? '');

        if ($sumber) {
            $this->keuanganMasukModel->insert([
                'buku_id'     => $buku_id,
                'sumber_dana' => $sumber,
                'nominal'     => $nom,
                'keterangan'  => $ket,
            ]);
        }
        return $this->respondJsonOrRedirect('Data Informasi Dana Masuk Berhasil Disimpan!');
    }

    public function storeKeuanganPembelian($buku_id)
    {
        $buku = $this->bukuModel->find($buku_id);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku LPJ tidak ditemukan!', false);
        }

        $itemArr     = $this->request->getPost('item_pembelian');
        $plafonArr   = $this->request->getPost('plafon');
        $terserapArr = $this->request->getPost('terserap');

        if (is_array($itemArr)) {
            $this->keuanganItemModel->where('buku_id', $buku_id)->delete();
            foreach ($itemArr as $idx => $item) {
                $it = trim($item ?? '');
                $pRaw = $plafonArr[$idx] ?? 0;
                $tRaw = $terserapArr[$idx] ?? 0;

                $plafon  = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$pRaw));
                $terserap = (float)str_replace(['.', ','], ['', '.'], preg_replace('/[^\d.,]/', '', (string)$tRaw));

                if ($it !== '' || $plafon > 0 || $terserap > 0) {
                    $this->keuanganItemModel->insert([
                        'buku_id'        => $buku_id,
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

    public function deleteKeuanganMasuk($id)
    {
        $this->keuanganMasukModel->delete($id);
        return $this->respondJsonOrRedirect('Data Dana Masuk Berhasil Dihapus!');
    }

    public function deleteKeuanganPembelian($id)
    {
        $this->keuanganItemModel->delete($id);
        return $this->respondJsonOrRedirect('Data Item Pembelian Berhasil Dihapus!');
    }

    public function cetak($id)
    {
        $buku = $this->bukuModel->find($id);
        if (!$buku) {
            return 'Buku LPJ tidak ditemukan.';
        }

        // Separate units into regular units and kader units (active only)
        $allUnits = $this->unitModel->findAll();
        $units      = [];
        $kaderUnits = [];
        foreach ($allUnits as $u) {
            $uStatus = strtolower(str_replace(['-', ' ', '_'], '', (string)($u['status'] ?? 'aktif')));
            if ($uStatus === 'nonaktif' || $uStatus === 'inactive' || $uStatus === 'tidakaktif') {
                continue;
            }

            $isKader = (($u['jenis_laporan'] ?? 'unit') === 'kader')
                || stripos($u['tipe'] ?? '', 'Kader') !== false
                || stripos($u['tipe'] ?? '', 'Posko') !== false
                || stripos($u['tipe'] ?? '', 'Gemerlap') !== false
                || stripos($u['nama_unit'] ?? '', 'GEMERLAP ') === 0
                || stripos($u['nama_unit'] ?? '', 'Satgas Kebersihan ') === 0;

            if ($isKader) {
                $kaderUnits[] = $u;
            } else {
                $units[] = $u;
            }
        }

        $proker              = $this->prokerModel->where('buku_id', $id)->orderBy('tanggal', 'ASC')->findAll();
        $targets             = $this->targetModel->where('buku_id', $id)->findAll();
        $capaianList         = $this->capaianBulananModel->where('buku_id', $id)->findAll();
        $evaluasiBulananList = $this->evaluasiBulananModel->where('buku_id', $id)->findAll();
        $koordinasi          = $this->koordinasiModel->where('buku_id', $id)->orderBy('id', 'ASC')->findAll();
        $evaluasiRaw         = $this->evaluasiModel->where('buku_id', $id)->findAll();
        $bukuKeuanganModel   = new \App\Models\BukuKeuanganModel();
        $importedKeuangan    = !empty($buku['keuangan_id']) ? $bukuKeuanganModel->find($buku['keuangan_id']) : null;

        $evaluasiMap = [];
        foreach ($evaluasiRaw as $ev) {
            $evaluasiMap[$ev['unit_id']] = $ev;
        }

        $prokerMap = [];
        foreach ($proker as $p) {
            $prokerMap[$p['id']] = $p;
        }

        $koordinasiMap = [];
        foreach ($koordinasi as $k) {
            if (!empty($k['proker_id'])) {
                $koordinasiMap[$k['proker_id']] = $k;
            }
        }
        $keuanganMasuk     = $importedKeuangan ? $this->keuanganMasukModel->where('keuangan_id', $importedKeuangan['id'])->orderBy('id', 'ASC')->findAll() : [];
        $keuanganPembelian = $importedKeuangan ? $this->keuanganItemModel->where('keuangan_id', $importedKeuangan['id'])->orderBy('id', 'ASC')->findAll() : [];

        $settings = (new \App\Models\PengaturanModel())->getAllAsMap();

        $data = [
            'buku'                => $buku,
            'units'               => $units,
            'kaderUnits'          => $kaderUnits,
            'proker'              => $proker,
            'prokerMap'           => $prokerMap,
            'targets'             => $targets,
            'capaianList'         => $capaianList,
            'evaluasiBulananList' => $evaluasiBulananList,
            'koordinasi'          => $koordinasi,
            'koordinasiMap'       => $koordinasiMap,
            'evaluasiMap'         => $evaluasiMap,
            'importedKeuangan'    => $importedKeuangan,
            'keuanganMasuk'       => $keuanganMasuk,
            'keuanganPembelian'   => $keuanganPembelian,
            'settings'            => $settings,
        ];

        return view('buku/cetak', $data);
    }

    public function importKeuangan($bukuId)
    {
        $buku = $this->bukuModel->find($bukuId);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku LPJ tidak ditemukan.', false);
        }

        $bukuKeuanganModel = new \App\Models\BukuKeuanganModel();

        $kodeKeuangan = trim($this->request->getPost('kode_keuangan') ?? '');
        $keuanganId   = $this->request->getPost('keuangan_id');
        $bulan        = $this->request->getPost('bulan');
        $tahun        = $this->request->getPost('tahun');

        $targetKeuangan = null;

        if (!empty($kodeKeuangan)) {
            $targetKeuangan = $bukuKeuanganModel->where('kode_keuangan', $kodeKeuangan)->first();
        }

        if (!$targetKeuangan && !empty($keuanganId)) {
            $targetKeuangan = $bukuKeuanganModel->find($keuanganId);
        }

        if (!$targetKeuangan && !empty($bulan) && !empty($tahun)) {
            $targetKeuangan = $bukuKeuanganModel->where('bulan', $bulan)->where('tahun', $tahun)->first();
        }

        if (!$targetKeuangan) {
            return $this->respondJsonOrRedirect('Laporan Keuangan yang dicari tidak ditemukan! Periksa Kode atau Bulan & Tahun.', false);
        }

        $this->bukuModel->update($bukuId, ['keuangan_id' => $targetKeuangan['id']]);

        return $this->respondJsonOrRedirect('Berhasil meng-import ' . $targetKeuangan['judul'] . '!', true, base_url('buku/detail/' . $bukuId . '?tab=keuangan'));
    }

    public function unlinkKeuangan($bukuId)
    {
        $buku = $this->bukuModel->find($bukuId);
        if (!$buku) {
            return $this->respondJsonOrRedirect('Buku LPJ tidak ditemukan.', false, base_url('buku'));
        }

        $this->bukuModel->update($bukuId, ['keuangan_id' => null]);

        return $this->respondJsonOrRedirect('Berhasil memutuskan tautan Laporan Keuangan.', true, base_url('buku/detail/' . $bukuId . '?tab=keuangan'));
    }
}
