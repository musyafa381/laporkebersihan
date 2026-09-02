<?php

namespace App\Controllers;

use App\Models\WilayahModel;
use App\Models\WilayahFotoModel;
use App\Models\WilayahPenugasanModel;
use App\Models\WilayahLaporanModel;
use App\Models\MasterUnitModel;
use App\Models\CsReportModel;
use App\Libraries\CloudinaryService;

class Wilayah extends BaseController
{
    protected $wilayahModel;
    protected $fotoModel;
    protected $penugasanModel;
    protected $laporanModel;
    protected $unitModel;
    protected $csModel;
    protected $cloudinary;

    public function __construct()
    {
        $this->wilayahModel   = new WilayahModel();
        $this->fotoModel      = new WilayahFotoModel();
        $this->penugasanModel = new WilayahPenugasanModel();
        $this->laporanModel   = new WilayahLaporanModel();
        $this->unitModel      = new MasterUnitModel();
        $this->csModel        = new CsReportModel();
        $this->cloudinary     = new CloudinaryService();
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.')->send();
        }
    }

    public function index()
    {
        $this->checkAuth();

        $wilayahList = $this->wilayahModel->orderBy('urutan', 'ASC')->orderBy('nama_wilayah', 'ASC')->findAll();
        $unitsList   = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();
        $today       = date('Y-m-d');

        // Enhance each wilayah with photos, shifts, and today's reporting status
        $totalSudahLapor = 0;
        $totalBelumLapor = 0;
        $allScores = [];

        foreach ($wilayahList as &$w) {
            $w['fotos'] = $this->fotoModel->getByWilayah($w['id']);
            $w['primary_foto'] = !empty($w['fotos']) ? $w['fotos'][0]['foto_url'] : null;
            $w['penugasan'] = $this->penugasanModel->getPenugasanWithUnit($w['id']);

            // Get today's reports for this zone
            $todayReports = $this->laporanModel
                ->where('wilayah_id', $w['id'])
                ->where('tanggal_lapor', $today)
                ->findAll();

            $w['today_reports'] = $todayReports;
            $w['is_reported_today'] = !empty($todayReports);

            if ($w['is_reported_today']) {
                $totalSudahLapor++;
                $scores = array_column($todayReports, 'nilai_kebersihan');
                $avgScore = round(array_sum($scores) / count($scores));
                $w['today_avg_score'] = $avgScore;
                $allScores[] = $avgScore;
            } else {
                $totalBelumLapor++;
                $w['today_avg_score'] = null;
            }

            // Check linked CS complaints that are not resolved
            $w['active_cs_count'] = $this->csModel
                ->where('wilayah_id', $w['id'])
                ->where('status !=', 'Selesai')
                ->countAllResults();
        }
        unset($w);

        $avgPesantrenScore = !empty($allScores) ? round(array_sum($allScores) / count($allScores)) : 100;

        $data = [
            'title'             => 'Pemetaan Wilayah Kebersihan - GEMERLAP K3L',
            'wilayahList'       => $wilayahList,
            'unitsList'         => $unitsList,
            'totalWilayah'      => count($wilayahList),
            'totalSudahLapor'   => $totalSudahLapor,
            'totalBelumLapor'   => $totalBelumLapor,
            'avgPesantrenScore' => $avgPesantrenScore,
            'todayDate'         => $today
        ];

        return view('wilayah/index', $data);
    }

    public function detail($id)
    {
        $this->checkAuth();

        $wilayah = $this->wilayahModel->find($id);
        if (!$wilayah) {
            return redirect()->to('/wilayah')->with('error', 'Data wilayah kebersihan tidak ditemukan.');
        }

        $fotos      = $this->fotoModel->getByWilayah($id);
        $penugasan  = $this->penugasanModel->getPenugasanWithUnit($id);
        $unitsList  = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();
        
        // Riwayat laporan kebersihan wilayah ini (30 terakhir)
        $laporanList = $this->laporanModel
            ->select('tbl_wilayah_laporan_harian.*, master_unit.nama_unit, master_unit.tipe as tipe_unit')
            ->join('master_unit', 'master_unit.id = tbl_wilayah_laporan_harian.unit_id', 'left')
            ->where('tbl_wilayah_laporan_harian.wilayah_id', $id)
            ->orderBy('tbl_wilayah_laporan_harian.tanggal_lapor', 'DESC')
            ->orderBy('tbl_wilayah_laporan_harian.id', 'DESC')
            ->limit(30)
            ->findAll();

        // Linked CS Reports
        $csReports = $this->csModel
            ->where('wilayah_id', $id)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Detail Wilayah: ' . $wilayah['nama_wilayah'],
            'wilayah'     => $wilayah,
            'fotos'       => $fotos,
            'penugasan'   => $penugasan,
            'unitsList'   => $unitsList,
            'laporanList' => $laporanList,
            'csReports'   => $csReports,
        ];

        return view('wilayah/detail', $data);
    }

    public function store()
    {
        $this->checkAuth();

        $namaWilayah  = trim($this->request->getPost('nama_wilayah'));
        $kategoriArea = $this->request->getPost('kategori_area') ?: 'Area Terbuka';
        $lokasiGedung = $this->request->getPost('lokasi_gedung') ?: '';
        $deskripsi    = $this->request->getPost('deskripsi') ?: '';
        $luasArea     = $this->request->getPost('luas_area') ?: '';
        $kodeWilayah  = $this->request->getPost('kode_wilayah') ?: 'WIL-' . strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $namaWilayah), 0, 4)) . '-' . rand(10, 99);
        $urutan       = (int)($this->request->getPost('urutan') ?: 0);

        if (empty($namaWilayah)) {
            return redirect()->back()->with('error', 'Nama wilayah kebersihan wajib diisi.');
        }

        $wilayahId = $this->wilayahModel->insert([
            'nama_wilayah'  => $namaWilayah,
            'kode_wilayah'  => $kodeWilayah,
            'kategori_area' => $kategoriArea,
            'lokasi_gedung' => $lokasiGedung,
            'deskripsi'     => $deskripsi,
            'luas_area'     => $luasArea,
            'status'        => 'Aktif',
            'urutan'        => $urutan
        ]);

        // Upload Multi-Photos to Cloudinary if provided
        $files = $this->request->getFiles();
        if (isset($files['foto_wilayah'])) {
            $uploadedFiles = is_array($files['foto_wilayah']) ? $files['foto_wilayah'] : [$files['foto_wilayah']];
            $isFirst = true;

            foreach ($uploadedFiles as $f) {
                if ($f && $f->isValid() && !$f->hasMoved()) {
                    $customName = 'wilayah_' . $wilayahId . '_' . time() . '_' . rand(100, 999);
                    $cldRes = $this->cloudinary->upload($f, 'wilayah_kebersihan', $customName);
                    
                    if ($cldRes['success'] && !empty($cldRes['url'])) {
                        $this->fotoModel->insert([
                            'wilayah_id' => $wilayahId,
                            'foto_url'   => $cldRes['url'],
                            'public_id'  => $cldRes['public_id'] ?? null,
                            'caption'    => 'Foto Master Wilayah ' . $namaWilayah,
                            'is_primary' => $isFirst ? 1 : 0,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                        $isFirst = false;
                    }
                }
            }
        }

        return redirect()->to('/wilayah')->with('success', 'Wilayah kebersihan "' . $namaWilayah . '" berhasil ditambahkan.');
    }

    public function update($id)
    {
        $this->checkAuth();

        $wilayah = $this->wilayahModel->find($id);
        if (!$wilayah) {
            return redirect()->to('/wilayah')->with('error', 'Data wilayah tidak ditemukan.');
        }

        $namaWilayah  = trim($this->request->getPost('nama_wilayah'));
        $kategoriArea = $this->request->getPost('kategori_area') ?: $wilayah['kategori_area'];
        $lokasiGedung = $this->request->getPost('lokasi_gedung') ?: '';
        $deskripsi    = $this->request->getPost('deskripsi') ?: '';
        $luasArea     = $this->request->getPost('luas_area') ?: '';
        $status       = $this->request->getPost('status') ?: 'Aktif';
        $kodeWilayah  = $this->request->getPost('kode_wilayah') ?: $wilayah['kode_wilayah'];
        $urutan       = (int)($this->request->getPost('urutan') ?: 0);

        if (empty($namaWilayah)) {
            return redirect()->back()->with('error', 'Nama wilayah kebersihan wajib diisi.');
        }

        $this->wilayahModel->update($id, [
            'nama_wilayah'  => $namaWilayah,
            'kode_wilayah'  => $kodeWilayah,
            'kategori_area' => $kategoriArea,
            'lokasi_gedung' => $lokasiGedung,
            'deskripsi'     => $deskripsi,
            'luas_area'     => $luasArea,
            'status'        => $status,
            'urutan'        => $urutan
        ]);

        return redirect()->back()->with('success', 'Data wilayah "' . $namaWilayah . '" berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->checkAuth();

        $wilayah = $this->wilayahModel->find($id);
        if ($wilayah) {
            $this->wilayahModel->delete($id);
            $this->fotoModel->where('wilayah_id', $id)->delete();
            $this->penugasanModel->where('wilayah_id', $id)->delete();
            return redirect()->to('/wilayah')->with('success', 'Wilayah kebersihan "' . $wilayah['nama_wilayah'] . '" berhasil dihapus.');
        }

        return redirect()->to('/wilayah')->with('error', 'Data wilayah tidak ditemukan.');
    }

    public function uploadFoto($wilayahId)
    {
        $this->checkAuth();

        $wilayah = $this->wilayahModel->find($wilayahId);
        if (!$wilayah) {
            return redirect()->to('/wilayah')->with('error', 'Data wilayah tidak ditemukan.');
        }

        $files = $this->request->getFiles();
        $uploadedCount = 0;

        if (isset($files['foto_wilayah'])) {
            $uploadedFiles = is_array($files['foto_wilayah']) ? $files['foto_wilayah'] : [$files['foto_wilayah']];
            $existingPrimary = $this->fotoModel->where('wilayah_id', $wilayahId)->where('is_primary', 1)->first();

            foreach ($uploadedFiles as $f) {
                if ($f && $f->isValid() && !$f->hasMoved()) {
                    $customName = 'wilayah_' . $wilayahId . '_' . time() . '_' . rand(100, 999);
                    $cldRes = $this->cloudinary->upload($f, 'wilayah_kebersihan', $customName);
                    
                    if ($cldRes['success'] && !empty($cldRes['url'])) {
                        $this->fotoModel->insert([
                            'wilayah_id' => $wilayahId,
                            'foto_url'   => $cldRes['url'],
                            'public_id'  => $cldRes['public_id'] ?? null,
                            'caption'    => 'Foto Wilayah ' . $wilayah['nama_wilayah'],
                            'is_primary' => empty($existingPrimary) && $uploadedCount === 0 ? 1 : 0,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                        $uploadedCount++;
                    }
                }
            }
        }

        if ($uploadedCount > 0) {
            return redirect()->back()->with('success', $uploadedCount . ' foto master wilayah berhasil diunggah ke Cloudinary.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto. Pastikan format file gambar valid.');
    }

    public function deleteFoto($fotoId)
    {
        $this->checkAuth();

        $foto = $this->fotoModel->find($fotoId);
        if ($foto) {
            $this->fotoModel->delete($fotoId);
            return redirect()->back()->with('success', 'Foto master wilayah berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }

    public function setPrimaryFoto($fotoId)
    {
        $this->checkAuth();

        $foto = $this->fotoModel->find($fotoId);
        if ($foto) {
            // Reset all to 0
            $this->fotoModel->where('wilayah_id', $foto['wilayah_id'])->set(['is_primary' => 0])->update();
            // Set this to 1
            $this->fotoModel->update($fotoId, ['is_primary' => 1]);
            return redirect()->back()->with('success', 'Foto utama wilayah berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }

    public function storePenugasan($wilayahId)
    {
        $this->checkAuth();

        $unitId     = $this->request->getPost('unit_id');
        $shift      = $this->request->getPost('shift') ?: 'Pagi';
        $jamMulai   = $this->request->getPost('jam_mulai') ?: '06:00';
        $jamSelesai = $this->request->getPost('jam_selesai') ?: '07:30';
        $hariAktif  = $this->request->getPost('hari_aktif') ?: 'Setiap Hari';
        $keterangan = $this->request->getPost('keterangan') ?: '';

        if (empty($unitId)) {
            return redirect()->back()->with('error', 'Pilih unit penanggung jawab terlebih dahulu.');
        }

        $this->penugasanModel->insert([
            'wilayah_id'  => $wilayahId,
            'unit_id'     => $unitId,
            'shift'       => $shift,
            'jam_mulai'   => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'hari_aktif'  => $hariAktif,
            'keterangan'  => $keterangan
        ]);

        return redirect()->back()->with('success', 'Penugasan shift ' . $shift . ' berhasil disimpan.');
    }

    public function updatePenugasan($id)
    {
        $this->checkAuth();

        $penugasan = $this->penugasanModel->find($id);
        if (!$penugasan) {
            return redirect()->back()->with('error', 'Data penugasan shift tidak ditemukan.');
        }

        $unitId     = $this->request->getPost('unit_id');
        $shift      = $this->request->getPost('shift') ?: 'Pagi';
        $jamMulai   = $this->request->getPost('jam_mulai') ?: '06:00';
        $jamSelesai = $this->request->getPost('jam_selesai') ?: '07:30';
        $hariAktif  = $this->request->getPost('hari_aktif') ?: 'Setiap Hari';
        $keterangan = $this->request->getPost('keterangan') ?: '';

        if (empty($unitId)) {
            return redirect()->back()->with('error', 'Pilih unit penanggung jawab terlebih dahulu.');
        }

        $this->penugasanModel->update($id, [
            'unit_id'     => $unitId,
            'shift'       => $shift,
            'jam_mulai'   => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'hari_aktif'  => $hariAktif,
            'keterangan'  => $keterangan
        ]);

        return redirect()->back()->with('success', 'Penugasan shift ' . $shift . ' berhasil diperbarui.');
    }

    public function deletePenugasan($id)
    {
        $this->checkAuth();

        $penugasan = $this->penugasanModel->find($id);
        if ($penugasan) {
            $this->penugasanModel->delete($id);
            return redirect()->back()->with('success', 'Penugasan shift unit berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data penugasan tidak ditemukan.');
    }

    public function laporan()
    {
        $this->checkAuth();

        $wilayahId = $this->request->getGet('wilayah_id');
        $unitId    = $this->request->getGet('unit_id');
        $tanggal   = $this->request->getGet('tanggal') ?: date('Y-m-d');
        $bulan     = $this->request->getGet('bulan');
        $tahun     = $this->request->getGet('tahun');

        $filters = [];
        if (!empty($wilayahId)) $filters['wilayah_id'] = $wilayahId;
        if (!empty($unitId))    $filters['unit_id']    = $unitId;
        if (!empty($tanggal) && empty($bulan))  $filters['tanggal'] = $tanggal;
        if (!empty($bulan) && !empty($tahun)) {
            $filters['bulan'] = $bulan;
            $filters['tahun'] = $tahun;
        }

        $laporanList = $this->laporanModel->getLaporanWithDetail($filters);
        $wilayahList = $this->wilayahModel->orderBy('nama_wilayah', 'ASC')->findAll();
        $unitsList   = $this->unitModel->orderBy('nama_unit', 'ASC')->findAll();

        $data = [
            'title'       => 'Rekapitulasi Laporan Kebersihan Harian - GEMERLAP K3L',
            'laporanList' => $laporanList,
            'wilayahList' => $wilayahList,
            'unitsList'   => $unitsList,
            'selectedDate'=> $tanggal,
            'filters'     => $filters
        ];

        return view('wilayah/laporan', $data);
    }

    public function deleteLaporan($id)
    {
        $this->checkAuth();

        $laporan = $this->laporanModel->find($id);
        if ($laporan) {
            $this->laporanModel->delete($id);
            return redirect()->back()->with('success', 'Data laporan kebersihan harian berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data laporan tidak ditemukan.');
    }
}
