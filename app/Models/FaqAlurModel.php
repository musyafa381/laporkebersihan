<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqAlurModel extends Model
{
    protected $table            = 'tbl_faq_alur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'judul_alur',
        'ringkasan',
        'icon',
        'badge_color',   // 'emerald', 'teal', 'blue', 'amber', 'purple', 'rose'
        'steps',         // JSON Array of steps (e.g. [{"step": 1, "title": "...", "desc": "..."}])
        'target_role',   // 'All', 'Pengurus', 'Kader', 'Auditor', 'Publik'
        'link_menu',
        'urutan',
        'status',        // 'Aktif', 'Nonaktif'
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;

    public function __construct()
    {
        parent::__construct();
        $this->ensureTableExists();
    }

    private function ensureTableExists()
    {
        if (!$this->db->tableExists($this->table)) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'judul_alur' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                ],
                'ringkasan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'default'    => 'fa-solid fa-route',
                ],
                'badge_color' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'emerald',
                ],
                'steps' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'target_role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'All',
                ],
                'link_menu' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'urutan' => [
                    'type'       => 'INT',
                    'constraint' => 5,
                    'default'    => 1,
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'Aktif',
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->createTable($this->table, true);

            $this->seedInitialAlur();
        }
    }

    private function seedInitialAlur()
    {
        $now = date('Y-m-d H:i:s');
        $seeds = [
            [
                'judul_alur'   => 'Alur Lapor Wilayah & Checklist Shift',
                'ringkasan'    => 'Panduan pengiriman laporan kebersihan harian sesuai jadwal shift kerja petugas.',
                'icon'         => 'fa-solid fa-map-location-dot',
                'badge_color'  => 'emerald',
                'steps'        => json_encode([
                    ['title' => 'Buka Menu Lapor Wilayah', 'desc' => 'Akses menu Lapor Wilayah dari portal mobile atau dashboard.'],
                    ['title' => 'Pilih Wilayah & Shift', 'desc' => 'Tentukan lokasi penugasan dan shift bertugas hari ini.'],
                    ['title' => 'Ambil Foto Dokumentasi', 'desc' => 'Ambil foto bukti kondisi area yang sudah bersih.'],
                    ['title' => 'Kirim Laporan Harian', 'desc' => 'Isi catatan kendala jika ada, lalu simpan laporan.'],
                ]),
                'target_role'  => 'Pengurus',
                'link_menu'    => 'app/lapor-wilayah',
                'urutan'       => 1,
                'status'       => 'Aktif',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'judul_alur'   => 'Alur Pengajuan Alat Kebersihan',
                'ringkasan'    => 'Panduan permohonan logistik alat kerja dan bahan pembersih ke gudang pusat.',
                'icon'         => 'fa-solid fa-broom',
                'badge_color'  => 'teal',
                'steps'        => json_encode([
                    ['title' => 'Pilih Menu Pengajuan Alat', 'desc' => 'Buka formulir pengajuan alat di portal kebersihan.'],
                    ['title' => 'Pilih Jenis Alat & Jumlah', 'desc' => 'Tentukan alat yang dibutuhkan beserta alasan keperluannya.'],
                    ['title' => 'Verifikasi Admin K3L', 'desc' => 'Admin memeriksa ketersediaan stok di gudang dan menyetujui.'],
                    ['title' => 'Pengambilan Barang', 'desc' => 'Ambil logistik di gudang pusat sesuai konfirmasi persetujuan.'],
                ]),
                'target_role'  => 'Pengurus',
                'link_menu'    => 'app/pengajuan-alat',
                'urutan'       => 2,
                'status'       => 'Aktif',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'judul_alur'   => 'Alur Buku LPJ & Evaluasi Bulanan',
                'ringkasan'    => 'Tahapan penyusunan laporan pertanggungjawaban kebersihan dan pembukuan anggaran.',
                'icon'         => 'fa-solid fa-book-bookmark',
                'badge_color'  => 'blue',
                'steps'        => json_encode([
                    ['title' => 'Buka Modul Buku LPJ', 'desc' => 'Pilih periode bulan dan tahun laporan LPJ yang aktif.'],
                    ['title' => 'Input Capaian Program', 'desc' => 'Catat pelaksanaan agenda proker dan koordinasi unit.'],
                    ['title' => 'Sinkronisasi Keuangan', 'desc' => 'Tautkan bukti pengeluaran dan kas masuk operasional.'],
                    ['title' => 'Cetak & Ekspor PDF', 'desc' => 'Terbitkan dokumen resmi LPJ lengkap dengan tanda tangan digital.'],
                ]),
                'target_role'  => 'All',
                'link_menu'    => 'buku',
                'urutan'       => 3,
                'status'       => 'Aktif',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'judul_alur'   => 'Alur Penanganan Aduan Layanan (CS)',
                'ringkasan'    => 'Mekanisme respon cepat terhadap aduan kebersihan yang dikirimkan oleh warga/santri.',
                'icon'         => 'fa-solid fa-headset',
                'badge_color'  => 'amber',
                'steps'        => json_encode([
                    ['title' => 'Aduan Masuk dari Publik', 'desc' => 'Masyarakat mengisi formulir CS publik beserta foto lokasi kotor.'],
                    ['title' => 'Disposisi Petugas Terkait', 'desc' => 'Admin meneruskan laporan kepada penanggung jawab unit terdekat.'],
                    ['title' => 'Tindakan Pembersihan Lapangan', 'desc' => 'Tim kebersihan langsung membersihkan area yang dilaporkan.'],
                    ['title' => 'Update Status Selesai', 'desc' => 'Admin memperbarui status menjadi Tuntas/Selesai.'],
                ]),
                'target_role'  => 'All',
                'link_menu'    => 'cs',
                'urutan'       => 4,
                'status'       => 'Aktif',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'judul_alur'   => 'Alur Standar Operasional Prosedur (SOP)',
                'ringkasan'    => 'Pedoman tata tertib, regulasi pimpinan, dan etika kerja kebersihan lingkungan.',
                'icon'         => 'fa-solid fa-clipboard-check',
                'badge_color'  => 'purple',
                'steps'        => json_encode([
                    ['title' => 'Akses Menu SOP Kebersihan', 'desc' => 'Buka daftar pedoman dan peraturan kebersihan resmi.'],
                    ['title' => 'Pahami Hak & Kewajiban', 'desc' => 'Pelajari standar higienitas, pemilahan sampah, dan K3.'],
                    ['title' => 'Terapkan di Unit Kerja', 'desc' => 'Jalankan aktivitas kebersihan sesuai prosedur standar.'],
                ]),
                'target_role'  => 'All',
                'link_menu'    => 'sop',
                'urutan'       => 5,
                'status'       => 'Aktif',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        $this->insertBatch($seeds);
    }
}
