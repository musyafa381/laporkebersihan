<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKoordinasiModel extends Model
{
    protected $table            = 'laporan_koordinasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'buku_id',
        'proker_id',
        'kegiatan',
        'hari_tanggal',
        'tempat',
        'bersama',
        'hasil_materi',
        'foto',
        'foto_position',
        'jenis',
        'created_at',
        'updated_at'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->ensureColumnsExist();
    }

    private function ensureColumnsExist()
    {
        $db = \Config\Database::connect();
        if ($db->tableExists($this->table)) {
            $fields = $db->getFieldNames($this->table);
            $forge  = \Config\Database::forge();

            $newColumns = [];
            if (!in_array('proker_id', $fields)) {
                $newColumns['proker_id'] = [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                    'after'      => 'buku_id'
                ];
            }
            if (!in_array('foto_position', $fields)) {
                $newColumns['foto_position'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'default'    => '50% 50%',
                    'after'      => 'foto'
                ];
            }
            if (!empty($newColumns)) {
                $forge->addColumn($this->table, $newColumns);
            }
        }
    }
}

