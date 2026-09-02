<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahLaporanModel extends Model
{
    protected $table            = 'tbl_wilayah_laporan_harian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'wilayah_id',
        'unit_id',
        'penugasan_id',
        'tanggal_lapor',
        'jam_lapor',
        'shift',
        'nilai_kebersihan',
        'foto_bukti_url',
        'foto_bukti_public_id',
        'catatan',
        'user_id_pelapor',
        'nama_pelapor',
        'status_verifikasi',
        'catatan_evaluasi',
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
        $db = \Config\Database::connect();
        if ($db->tableExists($this->table)) {
            $fields = $db->getFieldNames($this->table);
            if (!in_array('jam_lapor', $fields)) {
                $forge = \Config\Database::forge();
                $forge->addColumn($this->table, [
                    'jam_lapor' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 20,
                        'null'       => true,
                        'after'      => 'tanggal_lapor'
                    ]
                ]);
            }
        }
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
                'wilayah_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true
                ],
                'unit_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true
                ],
                'penugasan_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true
                ],
                'tanggal_lapor' => [
                    'type' => 'DATE'
                ],
                'shift' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Pagi'
                ],
                'nilai_kebersihan' => [
                    'type'       => 'INT',
                    'constraint' => 3,
                    'default'    => 100
                ],
                'foto_bukti_url' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'foto_bukti_public_id' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true
                ],
                'catatan' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'user_id_pelapor' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true
                ],
                'nama_pelapor' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true
                ],
                'status_verifikasi' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Sudah Bersih', 'Perlu Tindakan', 'Verifikasi Admin'],
                    'default'    => 'Sudah Bersih'
                ],
                'catatan_evaluasi' => [
                    'type' => 'TEXT',
                    'null' => true
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
            $forge->addKey('wilayah_id');
            $forge->addKey('unit_id');
            $forge->addKey('tanggal_lapor');
            $forge->createTable($this->table, true);
        }
    }

    public function getLaporanWithDetail(array $filters = [])
    {
        $builder = $this->select('tbl_wilayah_laporan_harian.*, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.kode_wilayah, tbl_wilayah_kebersihan.kategori_area, master_unit.nama_unit, master_unit.tipe as tipe_unit')
            ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = tbl_wilayah_laporan_harian.wilayah_id', 'left')
            ->join('master_unit', 'master_unit.id = tbl_wilayah_laporan_harian.unit_id', 'left');

        if (!empty($filters['wilayah_id'])) {
            $builder->where('tbl_wilayah_laporan_harian.wilayah_id', $filters['wilayah_id']);
        }
        if (!empty($filters['unit_id'])) {
            $builder->where('tbl_wilayah_laporan_harian.unit_id', $filters['unit_id']);
        }
        if (!empty($filters['tanggal'])) {
            $builder->where('tbl_wilayah_laporan_harian.tanggal_lapor', $filters['tanggal']);
        }
        if (!empty($filters['bulan']) && !empty($filters['tahun'])) {
            $builder->where('MONTH(tbl_wilayah_laporan_harian.tanggal_lapor)', $filters['bulan']);
            $builder->where('YEAR(tbl_wilayah_laporan_harian.tanggal_lapor)', $filters['tahun']);
        }

        return $builder->orderBy('tbl_wilayah_laporan_harian.tanggal_lapor', 'DESC')
            ->orderBy('tbl_wilayah_laporan_harian.id', 'DESC')
            ->findAll();
    }
}
