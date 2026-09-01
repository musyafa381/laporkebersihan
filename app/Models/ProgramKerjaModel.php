<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramKerjaModel extends Model
{
    protected $table            = 'tbl_program_kerja';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'unit_id',             // ID unit pelaksana (master_unit)
        'kader_type',          // 'GEMERLAP', 'Satgas', 'Non-Kader'
        'nama_program',
        'sub_kegiatan',
        'tgl_mulai',           // Tanggal mulai program
        'periode_frekuensi',   // 'Harian', 'Mingguan', 'Bulanan', 'Insidental'
        'tujuan_program',
        'mekanisme_kerja',     // Cara kerja / langkah operasional
        'target_indikator',    // Sasaran & indikator keberhasilan
        'penanggung_jawab',    // Nama PJ atau Kader yang bertanggung jawab
        'foto_dokumentasi',    // JSON array of photo filenames/paths
        'status',              // 'Terlaksana Rutin', 'Sedang Berjalan', 'Terencana', 'Selesai', 'Evaluasi'
        'sumber_input',        // 'Manual', 'LPJ Bulanan'
        'buku_lpj_id',         // Relasi jika di-sync dari LPJ bulanan tertentu
        'created_by_user_id',  // User yang membuat/menginput
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;

    public function __construct()
    {
        parent::__construct();
        $this->ensureTableExists();
        $this->ensureColumnsExist();
    }

    private function ensureColumnsExist()
    {
        if (!$this->db->tableExists($this->table)) {
            return;
        }
        $fields = $this->db->getFieldNames($this->table);
        if (!in_array('foto_dokumentasi', $fields)) {
            $forge = \Config\Database::forge();
            $forge->addColumn($this->table, [
                'foto_dokumentasi' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'penanggung_jawab'
                ]
            ]);
        }
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
                'unit_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'kader_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Non-Kader',
                ],
                'nama_program' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'sub_kegiatan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'tgl_mulai' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'periode_frekuensi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Mingguan',
                ],
                'tujuan_program' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'mekanisme_kerja' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'target_indikator' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'penanggung_jawab' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Sedang Berjalan',
                ],
                'sumber_input' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Manual',
                ],
                'buku_lpj_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'created_by_user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
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

            $this->seedInitialProkerData();
        }
    }

    public function seedInitialProkerData()
    {
        if ($this->countAllResults() > 0) {
            return;
        }

        // Ambil unit-unit pertama
        $unitModel = new \App\Models\MasterUnitModel();
        $units = $unitModel->findAll();

        $unitKitab = null;
        $unitGemerlap = null;
        $unitSatgas = null;

        foreach ($units as $u) {
            if (stripos($u['nama_unit'], 'Kitab') !== false) {
                $unitKitab = $u;
            }
            if ($u['tipe'] === 'Posko Gemerlap' || stripos($u['nama_unit'], 'Gemerlap') !== false) {
                $unitGemerlap = $u;
            }
            if ($u['tipe'] === 'Satgas' || stripos($u['nama_unit'], 'Satgas') !== false) {
                $unitSatgas = $u;
            }
        }

        $seed = [
            // Proker Asrama Kitab Putra
            [
                'unit_id'           => $unitKitab ? $unitKitab['id'] : ($units[0]['id'] ?? 1),
                'kader_type'        => 'Non-Kader',
                'nama_program'      => 'Operasi Semut & Piket Kamar Harian',
                'sub_kegiatan'      => 'Standar Kebersihan Ruang Santri',
                'tgl_mulai'         => date('Y-m-01'),
                'periode_frekuensi' => 'Harian',
                'tujuan_program'    => 'Menciptakan lingkungan asrama yang sehat, wangi, rapi, dan nyaman untuk kegiatan belajar serta istirahat santri.',
                'mekanisme_kerja'   => '1. Santri membagi jadwal piket kamar beranggotakan 3 orang tiap hari.\n2. Menyapu dan mengepel sebelum berangkat ke madrasah/sekolah.\n3. Mengosongkan tempat sampah kamar ke TPS luar.',
                'target_indikator'  => '100% kamar rapi sebelum jam 07.00 WIB dan tidak ada pakaian kotor tergantung lebih dari 2 hari.',
                'penanggung_jawab'  => $unitKitab['pj_nama'] ?? 'PJ Asrama Kitab',
                'status'            => 'Terlaksana Rutin',
                'sumber_input'      => 'Manual',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            // Proker Terpadu Kader Gemerlap
            [
                'unit_id'           => $unitGemerlap ? $unitGemerlap['id'] : ($units[0]['id'] ?? 1),
                'kader_type'        => 'GEMERLAP',
                'nama_program'      => 'Sidak & Lomba Asrama Terbersih (Gemerlap Award)',
                'sub_kegiatan'      => 'Program Unggulan Kader Terpadu Asrama',
                'tgl_mulai'         => date('Y-m-05'),
                'periode_frekuensi' => 'Mingguan',
                'tujuan_program'    => 'Membangun budaya kompetisi positif antar-asrama santri dalam menjaga estetika dan higienitas lingkungan.',
                'mekanisme_kerja'   => '1. Kader GEMERLAP berkeliling melakukan inspeksi mendadak setiap hari Minggu pagi.\n2. Penilaian menggunakan form instrumen 5 kriteria.\n3. Pengumuman asrama terbersih dan sanksi asrama terendah di apel bulanan.',
                'target_indikator'  => 'Rata-rata skor kebersihan seluruh kompleks asrama minimal 85 poin.',
                'penanggung_jawab'  => 'Koordinator Kader GEMERLAP',
                'status'            => 'Sedang Berjalan',
                'sumber_input'      => 'Manual',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            // Proker Terpadu Satgas
            [
                'unit_id'           => $unitSatgas ? $unitSatgas['id'] : ($units[0]['id'] ?? 1),
                'kader_type'        => 'Satgas',
                'nama_program'      => 'Normalisasi Saluran Drainase & Pemilahan Sampah TPS',
                'sub_kegiatan'      => 'Pemeliharaan Infrastruktur Lingkungan Hidup',
                'tgl_mulai'         => date('Y-m-10'),
                'periode_frekuensi' => 'Mingguan',
                'tujuan_program'    => 'Mencegah terjadinya genangan air dan memastikan pemilahan sampah organik serta anorganik berjalan optimal.',
                'mekanisme_kerja'   => '1. Pembersihan sedimentasi selokan utama setiap hari Jum\'at pagi.\n2. Pengecekan kontainer sampah terpilah di titik strategis yayasan.\n3. Pengangkutan sampah residu ke TPS induk Sleman.',
                'target_indikator'  => 'Saluran air lancar tanpa sumbatan sampah dan area TPS bebas bau menyengat.',
                'penanggung_jawab'  => 'Komandan Satgas Kebersihan',
                'status'            => 'Terlaksana Rutin',
                'sumber_input'      => 'Manual',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($seed as $row) {
            $this->insert($row);
        }
    }
}
