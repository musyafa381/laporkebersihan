<?php

namespace App\Models;

use CodeIgniter\Model;

class TipeUnitModel extends Model
{
    protected $table            = 'tbl_tipe_unit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_tipe', 'keterangan', 'urutan', 'created_at', 'updated_at'];

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
                'nama_tipe' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'keterangan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'urutan' => [
                    'type'       => 'INT',
                    'constraint' => 5,
                    'default'    => 0,
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
            $this->seedDefaults();
        }
    }

    public function seedDefaults()
    {
        $defaults = [
            ['nama_tipe' => 'Asrama Santri', 'keterangan' => 'Unit asrama santri putra maupun putri', 'urutan' => 1],
            ['nama_tipe' => 'Sekolah / Lembaga', 'keterangan' => 'Madrasah, SMP, SMK, atau perguruan tinggi', 'urutan' => 2],
            ['nama_tipe' => 'Fasilitas Umum', 'keterangan' => 'Kantin, lapangan, dapur, atau sarana umum', 'urutan' => 3],
            ['nama_tipe' => 'Pusat K3L', 'keterangan' => 'Gudang pusat, kantor K3L, dan sekretariat yayasan', 'urutan' => 4],
        ];

        foreach ($defaults as $d) {
            $exists = $this->where('nama_tipe', $d['nama_tipe'])->first();
            if (!$exists) {
                $this->insert([
                    'nama_tipe'  => $d['nama_tipe'],
                    'keterangan' => $d['keterangan'],
                    'urutan'     => $d['urutan'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function getAllOrdered(): array
    {
        $this->ensureTableExists();
        return $this->orderBy('urutan', 'ASC')->orderBy('nama_tipe', 'ASC')->findAll();
    }
}
