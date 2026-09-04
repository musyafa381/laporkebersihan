<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'tbl_faq_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kategori',      // 'Umum', 'Operasional & Wilayah', 'Inventaris & Alat', 'Buku LPJ', 'SOP & Regulasi'
        'pertanyaan',
        'jawaban',
        'target_role',   // 'All', 'Publik', 'Pengurus', 'Kader', 'Auditor', 'Admin'
        'urutan',
        'status',        // 'Aktif', 'Nonaktif'
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;

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
                'kategori' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 60,
                    'default'    => 'Umum',
                ],
                'pertanyaan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'jawaban' => [
                    'type'       => 'TEXT',
                ],
                'target_role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'default'    => 'All',
                ],
                'urutan' => [
                    'type'       => 'INT',
                    'constraint' => 5,
                    'default'    => 1,
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'Aktif',
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->createTable($this->table, true);

            $this->seedInitialFaq();
        }
    }

    private function seedInitialFaq()
    {
        $now = date('Y-m-d H:i:s');
        $seeds = [
            [
                'kategori'    => 'Umum',
                'pertanyaan'  => 'Apa tujuan utama dari Sistem Informasi Manajemen Kebersihan & K3L ini?',
                'jawaban'     => 'Sistem ini bertujuan untuk memantau, mendokumentasikan, dan mengelola seluruh operasional kebersihan asrama, sekolah, dan fasilitas umum secara digital, terpadu, dan transparan mulai dari laporan harian, logistik alat, hingga pembukuan LPJ bulanan.',
                'target_role' => 'All',
                'urutan'      => 1,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'Umum',
                'pertanyaan'  => 'Bagaimana cara masyarakat atau santri menyampaikan keluhan / aduan sampah?',
                'jawaban'     => 'Masyarakat, santri, dan civitas dapat langsung mengakses menu Customer Service (CS) Publik tanpa perlu login, kemudian mengunggah foto area kotor beserta deskripsi lokasi. Laporan akan otomatis diteruskan ke tim unit terkait.',
                'target_role' => 'All',
                'urutan'      => 2,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'Operasional & Wilayah',
                'pertanyaan'  => 'Kapan laporan kebersihan wilayah harian wajib diunggah oleh petugas/kader?',
                'jawaban'     => 'Laporan wajib diunggah segera setelah selesai menjalankan shift bertugas (maksimal 30 menit pasca shift) dengan melampirkan foto bukti kondisi area yang telah bersih serta catatan kendala jika ada.',
                'target_role' => 'Pengurus',
                'urutan'      => 3,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'Operasional & Wilayah',
                'pertanyaan'  => 'Apa yang harus dilakukan jika petugas berhalangan hadir saat shift kerja?',
                'jawaban'     => 'Petugas yang berhalangan wajib berkoordinasi dengan Penanggung Jawab (PJ) Unit atau rekan satu tim untuk mencari pengganti (badal shift) agar area tanggung jawab tetap terjaga kebersihannya.',
                'target_role' => 'Pengurus',
                'urutan'      => 4,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'Inventaris & Alat',
                'pertanyaan'  => 'Bagaimana prosedur pengajuan alat kebersihan baru atau isi ulang sabun/pembersih?',
                'jawaban'     => 'Buka menu Pengajuan Alat di portal mobile, pilih nama barang dan tentukan jumlah yang diajukan. Admin K3L akan memverifikasi stok di gudang dan menyetujui pengambilan barang.',
                'target_role' => 'Pengurus',
                'urutan'      => 5,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'Inventaris & Alat',
                'pertanyaan'  => 'Apa yang harus dilakukan jika alat kebersihan mengalami kerusakan fisik?',
                'jawaban'     => 'Laporkan alat yang rusak kepada Admin Gudang K3L untuk dicatat sebagai barang afkir/rusak dan diajukan penggantian unit baru.',
                'target_role' => 'Pengurus',
                'urutan'      => 6,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'Buku LPJ',
                'pertanyaan'  => 'Kapan batas waktu finalisasi Buku LPJ Bulanan?',
                'jawaban'     => 'Buku LPJ bulanan ditutup setiap tanggal 25 akhir bulan berjalan agar dapat dievaluasi oleh Pimpinan dan diaudit sebelum laporan cetak diterbitkan.',
                'target_role' => 'Pengurus',
                'urutan'      => 7,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kategori'    => 'SOP & Regulasi',
                'pertanyaan'  => 'Di mana saya bisa membaca peraturan resmi dan SOP standar kebersihan?',
                'jawaban'     => 'Seluruh peraturan, kebijakan pimpinan, program utama, dan panduan teknis kebersihan dapat diakses secara lengkap pada menu Standar Operasional Prosedur (SOP).',
                'target_role' => 'All',
                'urutan'      => 8,
                'status'      => 'Aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->insertBatch($seeds);
    }
}
