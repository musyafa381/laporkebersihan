<?php

namespace App\Models;

use CodeIgniter\Model;

class CsReportModel extends Model
{
    protected $table            = 'cs_reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_pengirim',
        'kontak_hp',
        'unit_lokasi',
        'wilayah_id',
        'nama_wilayah',
        'kategori',
        'isi_laporan',
        'foto_lampiran',
        'status',
        'tanggapan_admin',
        'ip_address',
        'user_agent',
        'is_flagged',
        'flag_reason',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;

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
            $forge = \Config\Database::forge();

            $newCols = [];
            if (!in_array('wilayah_id', $fields)) {
                $newCols['wilayah_id'] = [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                    'after'      => 'unit_lokasi'
                ];
            }
            if (!in_array('nama_wilayah', $fields)) {
                $newCols['nama_wilayah'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                    'after'      => 'wilayah_id'
                ];
            }
            if (!in_array('foto_lampiran', $fields)) {
                $newCols['foto_lampiran'] = [
                    'type'  => 'TEXT',
                    'null'  => true,
                    'after' => 'isi_laporan'
                ];
            }
            if (!in_array('ip_address', $fields)) {
                $newCols['ip_address'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 45,
                    'null'       => true,
                    'after'      => 'tanggapan_admin'
                ];
            }
            if (!in_array('user_agent', $fields)) {
                $newCols['user_agent'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'ip_address'
                ];
            }
            if (!in_array('is_flagged', $fields)) {
                $newCols['is_flagged'] = [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'user_agent'
                ];
            }
            if (!in_array('flag_reason', $fields)) {
                $newCols['flag_reason'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'is_flagged'
                ];
            }

            if (!empty($newCols)) {
                $forge->addColumn($this->table, $newCols);
            }
        }
    }
}
