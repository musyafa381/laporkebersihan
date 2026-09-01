<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitKaderModel extends Model
{
    protected $table            = 'tbl_unit_kader';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'unit_id',
        'nama_kader',
        'kontak_kader',
        'jabatan_kader',
        'kamar_kelas',
        'created_at'
    ];

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
                'unit_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'nama_kader' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                ],
                'kontak_kader' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'jabatan_kader' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Anggota Kader',
                ],
                'kamar_kelas' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->addKey('unit_id');
            $forge->createTable($this->table, true);
        }
    }

    public function getKadersByUnitId($unitId)
    {
        return $this->where('unit_id', $unitId)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
}
