<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahPenugasanModel extends Model
{
    protected $table            = 'tbl_wilayah_penugasan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'wilayah_id',
        'unit_id',
        'shift',
        'jam_mulai',
        'jam_selesai',
        'hari_aktif',
        'keterangan',
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
                'shift' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Pagi'
                ],
                'jam_mulai' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'default'    => '06:00'
                ],
                'jam_selesai' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'default'    => '07:30'
                ],
                'hari_aktif' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'default'    => 'Setiap Hari'
                ],
                'keterangan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true
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
            $forge->createTable($this->table, true);
        }
    }

    public function getPenugasanWithUnit(int $wilayahId = null)
    {
        $builder = $this->select('tbl_wilayah_penugasan.*, master_unit.nama_unit, master_unit.tipe as tipe_unit, master_unit.pj_nama, master_unit.pj_kontak, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.kode_wilayah')
            ->join('master_unit', 'master_unit.id = tbl_wilayah_penugasan.unit_id', 'left')
            ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = tbl_wilayah_penugasan.wilayah_id', 'left');

        if ($wilayahId !== null) {
            $builder->where('tbl_wilayah_penugasan.wilayah_id', $wilayahId);
        }

        return $builder->orderBy('tbl_wilayah_penugasan.shift', 'ASC')->findAll();
    }

    public function getPenugasanByUnit(int $unitId)
    {
        return $this->select('tbl_wilayah_penugasan.*, tbl_wilayah_kebersihan.nama_wilayah, tbl_wilayah_kebersihan.kode_wilayah, tbl_wilayah_kebersihan.kategori_area, tbl_wilayah_kebersihan.lokasi_gedung, tbl_wilayah_kebersihan.deskripsi, tbl_wilayah_kebersihan.luas_area, tbl_wilayah_kebersihan.status as status_wilayah')
            ->join('tbl_wilayah_kebersihan', 'tbl_wilayah_kebersihan.id = tbl_wilayah_penugasan.wilayah_id', 'inner')
            ->where('tbl_wilayah_penugasan.unit_id', $unitId)
            ->orderBy('tbl_wilayah_penugasan.id', 'ASC')
            ->findAll();
    }
}
