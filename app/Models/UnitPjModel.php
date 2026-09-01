<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitPjModel extends Model
{
    protected $table            = 'tbl_unit_pj';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'unit_id',
        'user_id',
        'nama_pj',
        'kontak_pj',
        'peran',
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
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'nama_pj' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                ],
                'kontak_pj' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'peran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Penanggung Jawab Utama',
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

    public function getPjsByUnitId($unitId)
    {
        $builder = $this->db->table($this->table . ' pj');
        $builder->select('pj.*, u.username, u.nama_lengkap as user_nama, u.role');
        $builder->join('users u', 'u.id = pj.user_id', 'left');
        $builder->where('pj.unit_id', $unitId);
        $builder->orderBy('pj.id', 'ASC');
        return $builder->get()->getResultArray();
    }
}
