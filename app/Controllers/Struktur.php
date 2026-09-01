<?php

namespace App\Controllers;

use App\Models\StrukturModel;

class Struktur extends BaseController
{
    protected $strukturModel;

    public function __construct()
    {
        $this->strukturModel = new StrukturModel();
    }

    public function index()
    {
        $session  = session();
        $isLoggedIn = $session->get('isLoggedIn');
        $userRole   = $session->get('role');

        $strukturList = $this->strukturModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();

        $byNode = [];
        foreach ($strukturList as $item) {
            $cat = $item['node_category'] ?? 'asrama_pj';
            if (!isset($byNode[$cat])) {
                $byNode[$cat] = [];
            }
            $byNode[$cat][] = $item;
        }

        // Ambil data unit dinamis dari master_unit beserta data PJ & data Anggota Kader
        $unitModel      = new \App\Models\MasterUnitModel();
        $unitPjModel    = new \App\Models\UnitPjModel();
        $unitKaderModel = new \App\Models\UnitKaderModel();
        $allUnits       = $unitModel->orderBy('nama_unit', 'ASC')->findAll();

        foreach ($allUnits as &$u) {
            $pjs = $unitPjModel->getPjsByUnitId($u['id']);
            if (!empty($pjs)) {
                $u['pj_list'] = $pjs;
                $pjNames = array_map(function($pj) {
                    return $pj['nama_pj'];
                }, $pjs);
                $u['pj_nama'] = implode(', ', $pjNames);

                $firstContact = array_filter($pjs, function($pj) {
                    return !empty($pj['kontak_pj']);
                });
                if (!empty($firstContact)) {
                    $u['pj_kontak'] = reset($firstContact)['kontak_pj'];
                }
            } else {
                $u['pj_list'] = [];
                if (!empty($u['pj_nama'])) {
                    $u['pj_list'][] = [
                        'nama_pj'   => $u['pj_nama'],
                        'kontak_pj' => $u['pj_kontak'] ?? ''
                    ];
                }
            }

            // Tentukan linked unit IDs untuk mengambil anggota kader yang terdaftar
            $uClean = trim(preg_replace('/^(GEMERLAP|Satgas\s*Kebersihan|Satgas)\s*/i', '', $u['nama_unit']));
            $linkedUnitIds = [(int)$u['id']];
            foreach ($allUnits as $ou) {
                if ((int)$ou['id'] === (int)$u['id']) continue;
                $ouClean = trim(preg_replace('/^(GEMERLAP|Satgas\s*Kebersihan|Satgas)\s*/i', '', $ou['nama_unit']));
                if (strcasecmp($uClean, $ouClean) === 0 || stripos($ou['nama_unit'], $uClean) !== false || stripos($u['nama_unit'], $ouClean) !== false) {
                    $linkedUnitIds[] = (int)$ou['id'];
                }
            }

            $uKaders = [];
            foreach ($linkedUnitIds as $lId) {
                $kd = $unitKaderModel->getKadersByUnitId($lId);
                if (!empty($kd)) {
                    $uKaders = array_merge($uKaders, $kd);
                }
            }
            $u['kader_members'] = $uKaders;
        }
        unset($u);

        $asramaUnits   = [];
        $gemerlapUnits = [];
        $sekolahUnits  = [];
        $satgasUnits   = [];
        $lembagaUnits  = [];

        foreach ($allUnits as $u) {
            $namaLower = strtolower($u['nama_unit'] ?? '');
            $tipeLower = strtolower($u['tipe'] ?? '');
            $isGemerlapName = strpos($namaLower, 'gemerlap') !== false;
            $isSatgasName   = strpos($namaLower, 'satgas') !== false;

            if ($isGemerlapName) {
                // Ini adalah unit khusus kader GEMERLAP
                $gemerlapUnits[] = $u;
            } elseif ($isSatgasName) {
                // Ini adalah unit khusus Satgas Kebersihan
                $satgasUnits[] = $u;
            } elseif (strpos($tipeLower, 'asrama') !== false || strpos($namaLower, 'asrama') !== false || strpos($namaLower, 'kitab') !== false || strpos($namaLower, 'tahfidz') !== false || strpos($namaLower, 'takhasus') !== false) {
                // Ini adalah unit fisik Asrama (PJ Asrama)
                $asramaUnits[] = $u;
            } elseif (strpos($tipeLower, 'sekolah') !== false || strpos($tipeLower, 'madrasah') !== false || strpos($namaLower, 'mts') !== false || strpos($namaLower, 'ma ') !== false || strpos($namaLower, 'smk') !== false || strpos($namaLower, 'smp') !== false || strpos($namaLower, 'sd') !== false) {
                // Ini adalah unit fisik Sekolah / Madrasah
                $sekolahUnits[] = $u;
            } else {
                // Lembaga lain / Gedung umum / KSY / Perkantoran
                $lembagaUnits[] = $u;
            }
        }

        // Ambil data pengaturan (Lembar Pengesahan PDF / Settings)
        $pengaturanModel = new \App\Models\PengaturanModel();
        $settings = $pengaturanModel->getAllAsMap();

        // Cari ketua, koordinator, sekretaris, logistik dari strukturList dengan fallback / prioritas pengaturan resmi
        $pimpinan = [
            'ketua'       => [
                'jabatan'               => $settings['jabatan_ketua'] ?? 'KETUA K3L',
                'nama_penanggung_jawab' => $settings['nama_ketua_k3l'] ?? 'Bapak Afif Muzayyin',
                'kontak_hp'             => '',
            ],
            'koordinator' => [
                'jabatan'               => $settings['jabatan_koordinator'] ?? 'KOORDINATOR UTAMA KEBERSIHAN',
                'nama_penanggung_jawab' => $settings['nama_koordinator'] ?? 'Bapak Muhammad Ashar',
                'kontak_hp'             => $settings['hotline_wa'] ?? '',
            ],
            'sekretaris'  => [
                'jabatan'               => $settings['jabatan_sekretaris'] ?? 'WAKIL / SEKRETARIS KEBERSIHAN',
                'nama_penanggung_jawab' => $settings['nama_sekretaris'] ?? 'Ahmad Musyafa',
                'kontak_hp'             => '',
            ],
            'logistik'    => [
                'jabatan'               => 'DIVISI LOGISTIK & GUDANG',
                'nama_penanggung_jawab' => 'Ahmad Fakhri Maulana',
                'kontak_hp'             => '',
            ],
        ];

        // Jika ada penyesuaian khusus dari tabel tbl_struktur, padukan dengan data pengesahan
        foreach ($strukturList as $s) {
            $j = strtolower($s['jabatan'] ?? '');
            $n = strtolower($s['node_category'] ?? '');
            if (strpos($j, 'ketua') !== false || strpos($n, 'ketua') !== false) {
                if (!empty($s['kontak_hp'])) $pimpinan['ketua']['kontak_hp'] = $s['kontak_hp'];
            } elseif (strpos($j, 'koordinator') !== false || strpos($n, 'koordinator') !== false) {
                if (!empty($s['kontak_hp'])) $pimpinan['koordinator']['kontak_hp'] = $s['kontak_hp'];
            } elseif (strpos($j, 'sekretaris') !== false || strpos($j, 'wakil') !== false || strpos($n, 'wakil') !== false) {
                if (!empty($s['kontak_hp'])) $pimpinan['sekretaris']['kontak_hp'] = $s['kontak_hp'];
            } elseif (strpos($j, 'logistik') !== false || strpos($j, 'gudang') !== false || strpos($n, 'gudang') !== false) {
                $pimpinan['logistik']['jabatan'] = $s['jabatan'];
                $pimpinan['logistik']['nama_penanggung_jawab'] = $s['nama_penanggung_jawab'];
                if (!empty($s['kontak_hp'])) $pimpinan['logistik']['kontak_hp'] = $s['kontak_hp'];
            }
        }

        $data = [
            'title'          => 'Struktur Organisasi Kebersihan - Yayasan Assalafiyyah',
            'strukturList'   => $strukturList,
            'byNode'         => $byNode,
            'asramaUnits'    => $asramaUnits,
            'gemerlapUnits'  => $gemerlapUnits,
            'sekolahUnits'   => $sekolahUnits,
            'satgasUnits'    => $satgasUnits,
            'lembagaUnits'   => $lembagaUnits,
            'pimpinan'       => $pimpinan,
            'settings'       => $settings,
            'isLoggedIn'     => $isLoggedIn,
            'userRole'       => $userRole,
        ];

        return view('struktur/index', $data);
    }

    public function updateOrder()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'Admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Hanya Admin yang memiliki hak akses untuk mengubah urutan struktur organisasi.'])->setStatusCode(403);
        }

        $orderIds = $this->request->getPost('order');
        if (!is_array($orderIds) || empty($orderIds)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Urutan tidak valid.']);
        }

        foreach ($orderIds as $index => $id) {
            $this->strukturModel->update($id, [
                'sort_order' => $index + 1
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Urutan Struktur Kebersihan berhasil diperbarui!'
        ]);
    }

    private function respondJsonOrRedirect($message, $success = true, $redirectUrl = null)
    {
        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            $jsonData = ['status' => $success ? 'success' : 'error', 'message' => $message];
            if ($redirectUrl) {
                $jsonData['redirect'] = $redirectUrl;
            }
            return $this->response->setJSON($jsonData);
        }

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('struktur'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak: Hanya Admin yang memiliki izin untuk menambah anggota struktur.', false, base_url('struktur'));
        }

        $jabatan     = trim($this->request->getPost('jabatan') ?? '');
        $nama        = trim($this->request->getPost('nama_penanggung_jawab') ?? '');
        $role        = trim($this->request->getPost('role_kategori') ?? 'Pengurus Harian');
        $nodeCat     = trim($this->request->getPost('node_category') ?? 'asrama_pj');
        $kontak      = trim($this->request->getPost('kontak_hp') ?? '');
        $wewenang    = trim($this->request->getPost('tugas_wewenang') ?? '');

        if (empty($jabatan) || empty($nama)) {
            return $this->respondJsonOrRedirect('Nama jabatan dan penanggung jawab wajib diisi.', false);
        }

        $maxOrder = $this->strukturModel->selectMax('sort_order')->first();
        $nextOrder = ($maxOrder['sort_order'] ?? 0) + 1;

        $this->strukturModel->insert([
            'jabatan'               => $jabatan,
            'nama_penanggung_jawab' => $nama,
            'role_kategori'         => $role,
            'node_category'         => $nodeCat,
            'kontak_hp'             => $kontak,
            'tugas_wewenang'        => $wewenang,
            'sort_order'            => $nextOrder
        ]);

        return $this->respondJsonOrRedirect('Anggota Struktur Kebersihan baru berhasil ditambahkan!');
    }

    public function update($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak: Hanya Admin yang memiliki izin untuk mengubah data struktur.', false, base_url('struktur'));
        }

        $jabatan  = trim($this->request->getPost('jabatan') ?? '');
        $nama     = trim($this->request->getPost('nama_penanggung_jawab') ?? '');
        $role     = trim($this->request->getPost('role_kategori') ?? 'Pengurus Harian');
        $nodeCat  = trim($this->request->getPost('node_category') ?? 'asrama_pj');
        $kontak   = trim($this->request->getPost('kontak_hp') ?? '');
        $wewenang = trim($this->request->getPost('tugas_wewenang') ?? '');

        if (empty($jabatan) || empty($nama)) {
            return $this->respondJsonOrRedirect('Nama jabatan dan penanggung jawab wajib diisi.', false);
        }

        $this->strukturModel->update($id, [
            'jabatan'               => $jabatan,
            'nama_penanggung_jawab' => $nama,
            'role_kategori'         => $role,
            'node_category'         => $nodeCat,
            'kontak_hp'             => $kontak,
            'tugas_wewenang'        => $wewenang,
        ]);

        return $this->respondJsonOrRedirect('Data Struktur Kebersihan berhasil diperbarui!');
    }

    public function delete($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'Admin') {
            return $this->respondJsonOrRedirect('Akses ditolak: Hanya Admin yang memiliki izin untuk menghapus anggota struktur.', false, base_url('struktur'));
        }

        $this->strukturModel->delete($id);
        return $this->respondJsonOrRedirect('Anggota Struktur Kebersihan berhasil dihapus!');
    }
}
