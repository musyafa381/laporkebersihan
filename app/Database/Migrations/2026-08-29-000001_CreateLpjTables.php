<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLpjTables extends Migration
{
    public function up()
    {
        // 1. Buku LPJ
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'bulan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'tahun' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Draft Proker',
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('buku_lpj', true);

        // 2. Master Unit (Asrama & Sekolah)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_unit', true);

        // 3. Proker Agenda
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'buku_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kategori_badge' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Koordinasi PJ',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('proker_agenda', true);

        // 4. Target Bulanan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'buku_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'target_text' => [
                'type' => 'TEXT',
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Umum',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('target_bulanan', true);

        // 5. Laporan Hasil Koordinasi
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'buku_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'hari_tanggal' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tempat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'bersama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'hasil_materi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'terjadwal',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('laporan_koordinasi', true);

        // 6. Capaian & Permasalahan per Unit
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'buku_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'unit_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'capaian_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'target_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'permasalahan_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'evaluasi_solusi_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('capaian_evaluasi', true);
    }

    public function down()
    {
        $this->forge->dropTable('capaian_evaluasi', true);
        $this->forge->dropTable('laporan_koordinasi', true);
        $this->forge->dropTable('target_bulanan', true);
        $this->forge->dropTable('proker_agenda', true);
        $this->forge->dropTable('master_unit', true);
        $this->forge->dropTable('buku_lpj', true);
    }
}
