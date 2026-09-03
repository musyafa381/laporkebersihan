<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterUnitModel extends Model
{
    protected $table            = 'master_unit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_unit',
        'tipe',
        'jenis_laporan',
        'kode_unit',
        'pj_nama',
        'pj_kontak',
        'pj_user_id',
        'status',
        'ada_kader',
        'jenis_kader',
        'parent_unit_id',
        'created_at'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->ensureColumnsExist();
    }

    private function ensureColumnsExist()
    {
        if (!$this->db->tableExists($this->table)) {
            return;
        }

        $fields = $this->db->getFieldNames($this->table);

        $forge = \Config\Database::forge();
        $fieldsToAdd = [];

        if (!in_array('kode_unit', $fields)) {
            $fieldsToAdd['kode_unit'] = ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true];
        }
        if (!in_array('pj_nama', $fields)) {
            $fieldsToAdd['pj_nama'] = ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true];
        }
        if (!in_array('pj_kontak', $fields)) {
            $fieldsToAdd['pj_kontak'] = ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true];
        }
        if (!in_array('pj_user_id', $fields)) {
            $fieldsToAdd['pj_user_id'] = ['type' => 'INT', 'constraint' => 11, 'null' => true];
        }
        if (!in_array('status', $fields)) {
            $fieldsToAdd['status'] = ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Aktif'];
        }
        if (!in_array('ada_kader', $fields)) {
            $fieldsToAdd['ada_kader'] = ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'Ya'];
        }
        if (!in_array('jenis_kader', $fields)) {
            $fieldsToAdd['jenis_kader'] = ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Gemerlap'];
        }
        if (!in_array('parent_unit_id', $fields)) {
            $fieldsToAdd['parent_unit_id'] = ['type' => 'INT', 'constraint' => 11, 'null' => true];
        }

        if (!empty($fieldsToAdd)) {
            $forge->addColumn($this->table, $fieldsToAdd);
        }
    }

    /**
     * Mengambil daftar data unit aktif saja (bukan unit posko kader dan bukan unit non-aktif)
     * untuk pilihan formulir lapor CS dan modul terkait lainnya.
     */
    public function getActiveUnitsNonKader(): array
    {
        return $this->groupStart()
                ->where('parent_unit_id IS NULL', null, false)
                ->orWhere('parent_unit_id', 0)
            ->groupEnd()
            ->groupStart()
                ->where('jenis_laporan IS NULL', null, false)
                ->orWhere('jenis_laporan !=', 'kader')
            ->groupEnd()
            ->notLike('tipe', 'Posko')
            ->notLike('nama_unit', 'GEMERLAP ', 'after')
            ->notLike('nama_unit', 'Satgas Kebersihan ', 'after')
            ->notLike('nama_unit', 'Satgas ', 'after')
            ->groupStart()
                ->where('status', 'Aktif')
                ->orWhere('status', 'aktif')
                ->orWhere('status IS NULL', null, false)
                ->orWhere('status', '')
            ->groupEnd()
            ->orderBy('nama_unit', 'ASC')
            ->findAll();
    }
}

