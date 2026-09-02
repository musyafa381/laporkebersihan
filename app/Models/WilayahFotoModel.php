<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahFotoModel extends Model
{
    protected $table            = 'tbl_wilayah_foto';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'wilayah_id',
        'foto_url',
        'public_id',
        'caption',
        'is_primary',
        'created_at'
    ];
    protected $useTimestamps    = false;

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
                'foto_url' => [
                    'type' => 'TEXT'
                ],
                'public_id' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true
                ],
                'caption' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true
                ],
                'is_primary' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ]
            ]);
            $forge->addKey('id', true);
            $forge->addKey('wilayah_id');
            $forge->createTable($this->table, true);
        }
    }

    public function getByWilayah(int $wilayahId)
    {
        return $this->where('wilayah_id', $wilayahId)->orderBy('is_primary', 'DESC')->orderBy('id', 'ASC')->findAll();
    }
}
