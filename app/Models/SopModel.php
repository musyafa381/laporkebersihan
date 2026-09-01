<?php

namespace App\Models;

use CodeIgniter\Model;

class SopModel extends Model
{
    protected $table            = 'tbl_sop';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kategori',      // 'Peraturan', 'Kebijakan', 'Program Utama', 'Panduan'
        'judul',
        'sub_judul',
        'deskripsi',
        'poin_poin',     // JSON Array of string / points
        'target_sasaran',// 'Seluruh Santri & Warga', 'Pengurus & Kader', 'Petugas Kebersihan', 'Umum'
        'icon',
        'badge_color',
        'sort_order',
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
                'kategori' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Peraturan',
                ],
                'judul' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'sub_judul' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'poin_poin' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'target_sasaran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'default'    => 'Seluruh Santri & Warga',
                ],
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'default'    => 'fa-solid fa-file-shield',
                ],
                'badge_color' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'default'    => 'emerald',
                ],
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Aktif', 'Nonaktif'],
                    'default'    => 'Aktif',
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->createTable($this->table, true);

            $this->seedInitialSopData();
        }
    }

    public function seedInitialSopData()
    {
        if ($this->countAllResults() > 0) {
            return;
        }

        $initialData = [
            // 1. Kategori: Peraturan Kebersihan
            [
                'kategori'       => 'Peraturan',
                'judul'          => 'Kewajiban Menjaga Kebersihan Kamar & Asrama',
                'sub_judul'      => 'Standar Kebersihan Harian Santri',
                'deskripsi'      => 'Seluruh santri dan penghuni asrama wajib menjaga ketertiban, kerapian, serta kebersihan ruangan tempat tinggal.',
                'poin_poin'      => json_encode([
                    'Melakukan piket kamar secara bergiliran setiap pagi setelah sholat Subuh dan sore hari.',
                    'Dilarang menumpuk pakaian kotor di dalam kamar lebih dari 2 hari.',
                    'Menyapu dan mengepel lantai kamar minimal 1 kali sehari.',
                    'Membuang sampah ke tempat sampah terpilah yang berada di luar kamar sebelum pukul 07.00 WIB.'
                ]),
                'target_sasaran' => 'Seluruh Santri Asrama',
                'icon'           => 'fa-solid fa-bed',
                'badge_color'    => 'emerald',
                'sort_order'     => 1,
                'status'         => 'Aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'kategori'       => 'Peraturan',
                'judul'          => 'Larangan Buang Sampah Sembarangan & Sanksi',
                'sub_judul'      => 'Ketertiban Lingkungan Pesantren',
                'deskripsi'      => 'Aturan disiplin dalam pembuangan sampah demi terciptanya lingkungan yayasan yang asri dan higienis.',
                'poin_poin'      => json_encode([
                    'Dilarang keras membuang sampah di saluran air/got, selokan, dan halaman terbuka.',
                    'Setiap sampah plastik kemasan wajib dimasukkan ke tempat sampah anorganik terdekat.',
                    'Pelanggaran buang sampah sembarangan akan dikenakan sanksi piket korve kebersihan yayasan selama 3 hari.'
                ]),
                'target_sasaran' => 'Seluruh Santri, Siswa & Warga',
                'icon'           => 'fa-solid fa-ban',
                'badge_color'    => 'rose',
                'sort_order'     => 2,
                'status'         => 'Aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            // 2. Kategori: Kebijakan
            [
                'kategori'       => 'Kebijakan',
                'judul'          => 'Kebijakan Pemilahan Sampah 2 Jalur (Organik & Anorganik)',
                'sub_judul'      => 'Sistem Pengelolaan Limbah Terpadu',
                'deskripsi'      => 'Yayasan mengimplementasikan sistem pemilahan sampah terpadu dari hulu di setiap posko dan unit.',
                'poin_poin'      => json_encode([
                    'Tempat Sampah Hijau dikhususkan untuk sisa makanan, daun, dan sisa bahan organik.',
                    'Tempat Sampah Kuning/Biru untuk botol plastik, kertas, kardus, dan bahan anorganik kering.',
                    'Pengangkutan ke TPS sentral dilakukan setiap pagi dan sore hari oleh tim operasional K3L.'
                ]),
                'target_sasaran' => 'Seluruh Posko & Pengurus Unit',
                'icon'           => 'fa-solid fa-recycle',
                'badge_color'    => 'teal',
                'sort_order'     => 3,
                'status'         => 'Aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'kategori'       => 'Kebijakan',
                'judul'          => 'Kebijakan Pengadaan & Perawatan Inventaris Alat Kebersihan',
                'sub_judul'      => 'Distribusi Logistik Resmi K3L',
                'deskripsi'      => 'Ketentuan alokasi, penggunaan, dan pengajuan penggantian alat operasional kebersihan.',
                'poin_poin'      => json_encode([
                    'Setiap unit bertanggung jawab penuh atas keutuhan alat kebersihan yang didistribusikan.',
                    'Pengajuan alat baru dilakukan melalui sistem portal oleh PJ / Kader resmi.',
                    'Alat yang rusak harus diserahkan bukti fisiknya ke Logistik K3L sebelum penggantian.'
                ]),
                'target_sasaran' => 'PJ Unit & Kader Kebersihan',
                'icon'           => 'fa-solid fa-toolbox',
                'badge_color'    => 'indigo',
                'sort_order'     => 4,
                'status'         => 'Aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            // 3. Kategori: Program Utama
            [
                'kategori'       => 'Program Utama',
                'judul'          => 'GEMERLAP (Gerakan Mlangi Bersih, Rapi, & Indah)',
                'sub_judul'      => 'Program Unggulan Kader Asrama Santri',
                'deskripsi'      => 'Gerakan pembinaan kesadaran lingkungan dan keteladanan santri dalam menjaga keindahan asrama.',
                'poin_poin'      => json_encode([
                    'Evaluasi dan sidak kebersihan kamar rutin setiap minggu.',
                    'Pemberian penghargaan "Kamar & Asrama Terbersih" bulanan.',
                    'Edukasi sanitasi dan pengelolaan lingkungan hidup bagi santri baru.'
                ]),
                'target_sasaran' => 'Santri Asrama & Kader GEMERLAP',
                'icon'           => 'fa-solid fa-sparkles',
                'badge_color'    => 'amber',
                'sort_order'     => 5,
                'status'         => 'Aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'kategori'       => 'Program Utama',
                'judul'          => 'Jum\'at Bersih & Korve Massal Lingkungan',
                'sub_judul'      => 'Gotong Royong Kebersihan Terpadu',
                'deskripsi'      => 'Kegiatan pembersihan lingkungan yayasan dan fasilitas umum yang melibatkan seluruh sivitas pesantren.',
                'poin_poin'      => json_encode([
                    'Pelaksanaan rutin setiap hari Jum\'at pagi pukul 06.30 - 08.00 WIB.',
                    'Fokus pada saluran drainase, halaman masjid, toilet umum, dan area perbatasan.',
                    'Dipimpin langsung oleh Koordinator K3L dan PJ masing-masing unit.'
                ]),
                'target_sasaran' => 'Seluruh Sivitas Yayasan Assalafiyyah',
                'icon'           => 'fa-solid fa-people-carry-box',
                'badge_color'    => 'emerald',
                'sort_order'     => 6,
                'status'         => 'Aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($initialData as $row) {
            $this->insert($row);
        }
    }
}
