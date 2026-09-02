<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriAlatModel extends Model
{
    protected $table            = 'tbl_kategori_alat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_kategori', 'keterangan', 'urutan', 'created_at', 'updated_at'];

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
                'nama_kategori' => [
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
        } else {
            // If table exists but empty, seed default categories
            if ($this->countAllResults() === 0) {
                $this->seedDefaults();
            }
        }
    }

    public function seedDefaults()
    {
        $defaults = [
            ['nama_kategori' => 'Sapu & Pel', 'keterangan' => 'Alat pembersih lantai, sapu, pel, kemoceng, serok', 'urutan' => 1],
            ['nama_kategori' => 'Wadah Sampah', 'keterangan' => 'Tong sampah, tempat sampah pilah, polybag, kontainer', 'urutan' => 2],
            ['nama_kategori' => 'Cairan & Bahan Kimia', 'keterangan' => 'Sabun pel, karbol, pembersih kaca, deterjen, disinfektan', 'urutan' => 3],
            ['nama_kategori' => 'Mesin & Alat Berat', 'keterangan' => 'Mesin rumput, vacuum cleaner, floor polisher, pressure washer', 'urutan' => 4],
            ['nama_kategori' => 'Lainnya', 'keterangan' => 'Perlengkapan APD kebersihan, sarung tangan, masker, sikat, dsb.', 'urutan' => 5],
        ];

        foreach ($defaults as $d) {
            $exists = $this->where('nama_kategori', $d['nama_kategori'])->first();
            if (!$exists) {
                $this->insert([
                    'nama_kategori' => $d['nama_kategori'],
                    'keterangan'    => $d['keterangan'],
                    'urutan'        => $d['urutan'],
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function getAllOrdered(): array
    {
        $this->ensureTableExists();
        return $this->orderBy('urutan', 'ASC')->orderBy('nama_kategori', 'ASC')->findAll();
    }
}
