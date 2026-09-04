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

        try {
            $namaWilayah  = trim($this->request->getPost('nama_wilayah'));
            $kategoriArea = $this->request->getPost('kategori_area') ?: 'Area Terbuka';
            $lokasiGedung = $this->request->getPost('lokasi_gedung') ?: '';
            $deskripsi    = $this->request->getPost('deskripsi') ?: '';
            $luasArea     = $this->request->getPost('luas_area') ?: '';
            $kodeWilayah  = $this->request->getPost('kode_wilayah') ?: 'WIL-' . strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $namaWilayah), 0, 4)) . '-' . rand(10, 99);
            $urutan       = (int)($this->request->getPost('urutan') ?: 0);

            if (empty($namaWilayah)) {
                return redirect()->to('/wilayah')->with('error', 'Nama wilayah kebersihan wajib diisi.');
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

            if (!$wilayahId) {
                return redirect()->to('/wilayah')->with('error', 'Gagal menambahkan data wilayah kebersihan.');
            }

            // Upload Multi-Photos to Cloudinary with Local Fallback
            $files = $this->request->getFiles();
            if (isset($files['foto_wilayah'])) {
                $uploadedFiles = is_array($files['foto_wilayah']) ? $files['foto_wilayah'] : [$files['foto_wilayah']];
                $isFirst = true;

                foreach ($uploadedFiles as $f) {
                    if ($f && $f->isValid() && !$f->hasMoved()) {
                        $customName = 'wilayah_' . $wilayahId . '_' . time() . '_' . rand(100, 999);
                        $cldRes = null;
                        try {
                            $cldRes = $this->cloudinary->upload($f, 'wilayah_kebersihan', $customName);
                        } catch (\Throwable $e) {
                            $cldRes = ['success' => false];
                        }
                        
                        if ($cldRes && !empty($cldRes['success']) && !empty($cldRes['url'])) {
                            $this->fotoModel->insert([
                                'wilayah_id' => $wilayahId,
                                'foto_url'   => $cldRes['url'],
                                'public_id'  => $cldRes['public_id'] ?? null,
                                'caption'    => 'Foto Master Wilayah ' . $namaWilayah,
                                'is_primary' => $isFirst ? 1 : 0,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $isFirst = false;
                        } else {
                            // Fallback to local uploads/wilayah/
                            $uploadDir = FCPATH . 'uploads/wilayah/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $ext = $f->guessExtension() ?: 'jpg';
                            $cleanLocalName = $customName . '.' . $ext;
                            $f->move($uploadDir, $cleanLocalName);

                            $this->fotoModel->insert([
                                'wilayah_id' => $wilayahId,
                                'foto_url'   => base_url('uploads/wilayah/' . $cleanLocalName),
                                'public_id'  => null,
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
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah')->with('error', 'Terjadi kesalahan saat menyimpan wilayah: ' . $e->getMessage());
        }
    }

    public function update($id)
    {
        $this->checkAuth();

        try {
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
            $urutan       = (int)($this->request->getPost('urutan') ?: ($wilayah['urutan'] ?? 0));

            if (empty($namaWilayah)) {
                return redirect()->to('/wilayah/detail/' . $id)->with('error', 'Nama wilayah kebersihan wajib diisi.');
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

            return redirect()->to('/wilayah/detail/' . $id)->with('success', 'Data wilayah "' . $namaWilayah . '" berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah/detail/' . $id)->with('error', 'Terjadi kesalahan saat memperbarui wilayah: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->checkAuth();

        try {
            $wilayah = $this->wilayahModel->find($id);
            if (!$wilayah) {
                return redirect()->to('/wilayah')->with('error', 'Data wilayah tidak ditemukan.');
            }

            // Delete associated photos from Cloudinary and disk
            $fotos = $this->fotoModel->where('wilayah_id', $id)->findAll();
            foreach ($fotos as $f) {
                if (!empty($f['public_id'])) {
                    try {
                        $this->cloudinary->delete($f['public_id']);
                    } catch (\Throwable $e) {}
                }
                if (!empty($f['foto_url']) && str_contains($f['foto_url'], 'uploads/wilayah/')) {
                    $localPath = FCPATH . 'uploads/wilayah/' . basename($f['foto_url']);
                    if (file_exists($localPath)) {
                        @unlink($localPath);
                    }
                }
            }

            // Cascade delete related records using Query Builder
            $this->fotoModel->builder()->where('wilayah_id', $id)->delete();
            $this->penugasanModel->builder()->where('wilayah_id', $id)->delete();
            $this->laporanModel->builder()->where('wilayah_id', $id)->delete();
            $this->wilayahModel->delete($id);

            return redirect()->to('/wilayah')->with('success', 'Wilayah kebersihan "' . $wilayah['nama_wilayah'] . '" beserta foto dan penugasan berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah')->with('error', 'Terjadi kesalahan saat menghapus wilayah: ' . $e->getMessage());
        }
    }

    public function uploadFoto($wilayahId)
    {
        $this->checkAuth();

        try {
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
                        $cldRes = null;
                        try {
                            $cldRes = $this->cloudinary->upload($f, 'wilayah_kebersihan', $customName);
                        } catch (\Throwable $e) {
                            $cldRes = ['success' => false];
                        }
                        
                        if ($cldRes && !empty($cldRes['success']) && !empty($cldRes['url'])) {
                            $this->fotoModel->insert([
                                'wilayah_id' => $wilayahId,
                                'foto_url'   => $cldRes['url'],
                                'public_id'  => $cldRes['public_id'] ?? null,
                                'caption'    => 'Foto Wilayah ' . $wilayah['nama_wilayah'],
                                'is_primary' => empty($existingPrimary) && $uploadedCount === 0 ? 1 : 0,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $uploadedCount++;
                        } else {
                            // Fallback to local upload
                            $uploadDir = FCPATH . 'uploads/wilayah/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $ext = $f->guessExtension() ?: 'jpg';
                            $cleanLocalName = $customName . '.' . $ext;
                            $f->move($uploadDir, $cleanLocalName);

                            $this->fotoModel->insert([
                                'wilayah_id' => $wilayahId,
                                'foto_url'   => base_url('uploads/wilayah/' . $cleanLocalName),
                                'public_id'  => null,
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
                return redirect()->to('/wilayah/detail/' . $wilayahId)->with('success', $uploadedCount . ' foto master wilayah berhasil disimpan.');
            }

            return redirect()->to('/wilayah/detail/' . $wilayahId)->with('error', 'Gagal mengunggah foto. Pastikan format file gambar valid.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah/detail/' . $wilayahId)->with('error', 'Terjadi kesalahan saat mengunggah foto: ' . $e->getMessage());
        }
    }

    public function deleteFoto($fotoId)
    {
        $this->checkAuth();

        try {
            $foto = $this->fotoModel->find($fotoId);
            if ($foto) {
                $wilayahId = $foto['wilayah_id'];
                $wasPrimary = (int)($foto['is_primary'] ?? 0) === 1;

                if (!empty($foto['public_id'])) {
                    try {
                        $this->cloudinary->delete($foto['public_id']);
                    } catch (\Throwable $e) {}
                }
                if (!empty($foto['foto_url']) && str_contains($foto['foto_url'], 'uploads/wilayah/')) {
                    $localPath = FCPATH . 'uploads/wilayah/' . basename($foto['foto_url']);
                    if (file_exists($localPath)) {
                        @unlink($localPath);
                    }
                }

                $this->fotoModel->delete($fotoId);

                // If deleted photo was primary, assign the next available photo as primary
                if ($wasPrimary) {
                    $nextFoto = $this->fotoModel->where('wilayah_id', $wilayahId)->first();
                    if ($nextFoto) {
                        $this->fotoModel->update($nextFoto['id'], ['is_primary' => 1]);
                    }
                }

                return redirect()->to('/wilayah/detail/' . $wilayahId)->with('success', 'Foto master wilayah berhasil dihapus.');
            }

            return redirect()->to('/wilayah')->with('error', 'Foto tidak ditemukan.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah')->with('error', 'Terjadi kesalahan saat menghapus foto: ' . $e->getMessage());
        }
    }

    public function setPrimaryFoto($fotoId)
    {
        $this->checkAuth();

        try {
            $foto = $this->fotoModel->find($fotoId);
            if ($foto) {
                $wilayahId = $foto['wilayah_id'];
                // Reset all photos for this wilayah to 0
                $this->fotoModel->builder()->where('wilayah_id', $wilayahId)->update(['is_primary' => 0]);
                // Set the selected photo to 1
                $this->fotoModel->update($fotoId, ['is_primary' => 1]);
                return redirect()->to('/wilayah/detail/' . $wilayahId)->with('success', 'Foto utama wilayah berhasil diubah.');
            }

            return redirect()->to('/wilayah')->with('error', 'Foto tidak ditemukan.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah')->with('error', 'Terjadi kesalahan saat mengatur foto utama: ' . $e->getMessage());
        }
    }

    public function storePenugasan($wilayahId)
    {
        $this->checkAuth();

        try {
            $wilayah = $this->wilayahModel->find($wilayahId);
            if (!$wilayah) {
                return redirect()->to('/wilayah')->with('error', 'Data wilayah tidak ditemukan.');
            }

            $unitId     = (int)$this->request->getPost('unit_id');
            $shift      = $this->request->getPost('shift') ?: 'Pagi';
            $jamMulai   = $this->request->getPost('jam_mulai') ?: '06:00';
            $jamSelesai = $this->request->getPost('jam_selesai') ?: '07:30';
            $hariAktif  = $this->request->getPost('hari_aktif') ?: 'Setiap Hari';
            $customDays = $this->request->getPost('hari_custom');
            if ($hariAktif === 'Custom' && !empty($customDays) && is_array($customDays)) {
                $hariAktif = implode(', ', $customDays);
            }
            $keterangan = trim($this->request->getPost('keterangan') ?: '');

            if (empty($unitId)) {
                return redirect()->to('/wilayah/detail/' . $wilayahId)->with('error', 'Pilih unit penanggung jawab terlebih dahulu.');
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

            return redirect()->to('/wilayah/detail/' . $wilayahId)->with('success', 'Penugasan shift ' . $shift . ' berhasil disimpan.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah/detail/' . $wilayahId)->with('error', 'Terjadi kesalahan saat menyimpan shift penugasan: ' . $e->getMessage());
        }
    }

    public function updatePenugasan($id)
    {
        $this->checkAuth();

        try {
            $penugasan = $this->penugasanModel->find($id);
            if (!$penugasan) {
                return redirect()->to('/wilayah')->with('error', 'Data penugasan shift tidak ditemukan.');
            }

            $wilayahId  = $penugasan['wilayah_id'];
            $unitId     = (int)$this->request->getPost('unit_id');
            $shift      = $this->request->getPost('shift') ?: 'Pagi';
            $jamMulai   = $this->request->getPost('jam_mulai') ?: '06:00';
            $jamSelesai = $this->request->getPost('jam_selesai') ?: '07:30';
            $hariAktif  = $this->request->getPost('hari_aktif') ?: 'Setiap Hari';
            $customDays = $this->request->getPost('hari_custom');
            if ($hariAktif === 'Custom' && !empty($customDays) && is_array($customDays)) {
                $hariAktif = implode(', ', $customDays);
            }
            $keterangan = trim($this->request->getPost('keterangan') ?: '');

            if (empty($unitId)) {
                return redirect()->to('/wilayah/detail/' . $wilayahId)->with('error', 'Pilih unit penanggung jawab terlebih dahulu.');
            }

            $this->penugasanModel->update($id, [
                'unit_id'     => $unitId,
                'shift'       => $shift,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'hari_aktif'  => $hariAktif,
                'keterangan'  => $keterangan
            ]);

            return redirect()->to('/wilayah/detail/' . $wilayahId)->with('success', 'Penugasan shift ' . $shift . ' berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah')->with('error', 'Terjadi kesalahan saat memperbarui shift penugasan: ' . $e->getMessage());
        }
    }

    public function deletePenugasan($id)
    {
        $this->checkAuth();

        try {
            $penugasan = $this->penugasanModel->find($id);
            if ($penugasan) {
                $wilayahId = $penugasan['wilayah_id'];
                $this->penugasanModel->delete($id);
                return redirect()->to('/wilayah/detail/' . $wilayahId)->with('success', 'Penugasan shift unit berhasil dihapus.');
            }

            return redirect()->to('/wilayah')->with('error', 'Data penugasan tidak ditemukan.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah')->with('error', 'Terjadi kesalahan saat menghapus shift penugasan: ' . $e->getMessage());
        }
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

        try {
            $laporan = $this->laporanModel->find($id);
            if ($laporan) {
                if (!empty($laporan['foto_bukti_public_id'])) {
                    try {
                        $this->cloudinary->delete($laporan['foto_bukti_public_id']);
                    } catch (\Throwable $e) {}
                }
                $this->laporanModel->delete($id);
                return redirect()->to('/wilayah/laporan')->with('success', 'Data laporan kebersihan harian berhasil dihapus.');
            }

            return redirect()->to('/wilayah/laporan')->with('error', 'Data laporan tidak ditemukan.');
        } catch (\Throwable $e) {
            return redirect()->to('/wilayah/laporan')->with('error', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
        }
    }
}
