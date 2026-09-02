<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table            = 'tbl_wilayah_kebersihan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_wilayah',
        'kode_wilayah',
        'kategori_area',
        'lokasi_gedung',
        'deskripsi',
        'luas_area',
        'status',
        'urutan',
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
        $db = \Config\Database::connect();
        if (!$db->tableExists($this->table)) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true
                ],
                'nama_wilayah' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150
                ],
                'kode_wilayah' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true
                ],
                'kategori_area' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'default'    => 'Area Terbuka'
                ],
                'lokasi_gedung' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'luas_area' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Aktif', 'Perbaikan', 'Non-Aktif'],
                    'default'    => 'Aktif'
                ],
                'urutan' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ]
            ]);
            $forge->addKey('id', true);
            $forge->createTable($this->table, true);

            // Default initial seeds
            $now = date('Y-m-d H:i:s');
            $defaultZones = [
                [
                    'nama_wilayah'  => 'Lapangan Utama Putri',
                    'kode_wilayah'  => 'WIL-LP-01',
                    'kategori_area' => 'Lapangan & Outdoor',
                    'lokasi_gedung' => 'Komplek Asrama Putri',
                    'deskripsi'     => 'Area lapangan rumput dan paving serbaguna untuk kegiatan santriwati putri.',
                    'luas_area'     => '650 m²',
                    'status'        => 'Aktif',
                    'urutan'        => 1,
                    'created_at'    => $now,
                    'updated_at'    => $now
                ],
                [
                    'nama_wilayah'  => 'Halaman & Selasar Masjid Pusat',
                    'kode_wilayah'  => 'WIL-MSJ-01',
                    'kategori_area' => 'Tempat Ibadah & Selasar',
                    'lokasi_gedung' => 'Pusat Kampus Pesantren',
                    'deskripsi'     => 'Pelataran suci masjid, tempat wudhu luar, dan serambi masjid utama.',
                    'luas_area'     => '1.200 m²',
                    'status'        => 'Aktif',
                    'urutan'        => 2,
                    'created_at'    => $now,
                    'updated_at'    => $now
                ],
                [
                    'nama_wilayah'  => 'Koridor & Taman Gedung Pendidikan',
                    'kode_wilayah'  => 'WIL-GDK-01',
                    'kategori_area' => 'Gedung Sekolah & Kelas',
                    'lokasi_gedung' => 'Komplek Madrasah / Sekolah',
                    'deskripsi'     => 'Lorong koridor lantai 1-2 dan area taman hijau di depan ruang kelas.',
                    'luas_area'     => '450 m²',
                    'status'        => 'Aktif',
                    'urutan'        => 3,
                    'created_at'    => $now,
                    'updated_at'    => $now
                ]
            ];
            $db->table($this->table)->insertBatch($defaultZones);
        }
    }
}
