<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'tbl_pengaturan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['setting_key', 'setting_value', 'created_at', 'updated_at'];

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
                'setting_key' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'unique'     => true,
                ],
                'setting_value' => [
                    'type' => 'TEXT',
                    'null' => true,
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
        }
        $this->seedDefaults();
    }

    public function seedDefaults()
    {
        $defaults = [
            'nama_instansi'        => 'K3L Yayasan Assalafiyyah Mlangi',
            'alamat_instansi'      => 'Jl. Assalafiyyah, Mlangi, Nogotirto, Gamping, Sleman, Yogyakarta 55292',
            'hotline_wa'           => '081234567890',
            'running_text'         => 'Selamat datang di Portal Pengaduan & Kebersihan Yayasan Assalafiyyah Mlangi. Jaga kebersihan lingkungan demi kenyamanan ibadah & santri.',
            'nama_ketua_k3l'       => 'Bapak Afif Muzayyin',
            'jabatan_ketua'        => 'Ketua K3L',
            'ttd_ketua_img'        => '',
            'nama_koordinator'     => 'Bapak Muhammad Ashar',
            'jabatan_koordinator'  => 'Koordinator Kebersihan',
            'ttd_koordinator_img'  => '',
            'nama_sekretaris'      => 'Ahmad Musyafa',
            'jabatan_sekretaris'   => 'Sekretaris Kebersihan',
            'ttd_sekretaris_img'   => '',
            'stempel_img'          => '',
            'kota_dokumen'         => 'Sleman',
            'wa_template_terima'   => 'Assalamu\'alaikum Wr. Wb. Laporan pengaduan kebersihan Anda dengan ID #{REPORT_ID} telah diterima oleh Tim CS K3L dan sedang dalam penanganan. Terima kasih.',
            'wa_template_selesai'  => 'Assalamu\'alaikum Wr. Wb. Laporan pengaduan kebersihan #{REPORT_ID} di lokasi {LOKASI} telah SELESAI ditindaklanjuti. Terima kasih atas partisipasi Anda.',
            'jam_cs_buka'          => '06:00',
            'jam_cs_tutup'         => '21:00',
            'plafon_pengajuan'     => '500000',
        ];

        foreach ($defaults as $key => $val) {
            $existing = $this->where('setting_key', $key)->first();
            if (!$existing) {
                $this->insert([
                    'setting_key'   => $key,
                    'setting_value' => $val,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function getAllAsMap(): array
    {
        $this->seedDefaults();
        $rows = $this->findAll();
        $map = [];
        foreach ($rows as $row) {
            $map[$row['setting_key']] = $row['setting_value'];
        }
        return $map;
    }

    public function updateKey(string $key, ?string $value): void
    {
        $existing = $this->where('setting_key', $key)->first();
        if ($existing) {
            $this->update($existing['id'], [
                'setting_value' => $value,
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->insert([
                'setting_key'   => $key,
                'setting_value' => $value,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
