<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialLpjSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Master Unit (Asrama & Sekolah)
        $units = [
            // Asrama
            ['nama_unit' => 'Asrama Kitab Putra', 'tipe' => 'Asrama'],
            ['nama_unit' => 'Asrama Kitab Putri', 'tipe' => 'Asrama'],
            ['nama_unit' => 'Asrama Tahfidz Putra', 'tipe' => 'Asrama'],
            ['nama_unit' => 'Asrama Tahfidz Putri', 'tipe' => 'Asrama'],
            ['nama_unit' => 'Asrama Takhasus Putra', 'tipe' => 'Asrama'],
            ['nama_unit' => 'Asrama Takhasus Putri', 'tipe' => 'Asrama'],
            // Sekolah
            ['nama_unit' => 'MTs Assalafiyyah', 'tipe' => 'Sekolah'],
            ['nama_unit' => 'MA Assalafiyyah', 'tipe' => 'Sekolah'],
            ['nama_unit' => 'SMK Assalafiyah', 'tipe' => 'Sekolah'],
            ['nama_unit' => 'Internasional Assalafiyyah', 'tipe' => 'Sekolah'],
            ['nama_unit' => 'PDF Assalafiyyah', 'tipe' => 'Sekolah'],
        ];

        foreach ($units as $unit) {
            $unit['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('master_unit')->insert($unit);
        }

        // 2. Seed Sample Buku LPJ September 2026
        $this->db->table('buku_lpj')->insert([
            'judul'      => 'Laporan Pertanggungjawaban (LPJ) Kebersihan Bulan September 2026',
            'bulan'      => 'September',
            'tahun'      => 2026,
            'status'     => 'Berjalan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $bukuId = $this->db->insertID();

        // 3. Seed Proker Agenda (Tabel & Kalender Bulan September 2026)
        $agendas = [
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-02',
                'kegiatan'       => 'Koordinasi Dengan Pengurus Kebersihan Asrama',
                'keterangan'     => 'Koordinasi terkait pelaporan LPJ Kebersihan asrama masing-masing, yang mencakup evaluasi, permasalahan, capaian, dan target kebersihan kedepannya.',
                'kategori_badge' => 'Koordinasi PJ',
            ],
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-07',
                'kegiatan'       => 'Koordinasi Dengan Pengurus Kebersihan Sekolah',
                'keterangan'     => 'Koordinasi terkait pelaporan LPJ Kebersihan instansi sekolah masing-masing, yang mencakup evaluasi, permasalahan, capaian, dan target kebersihan kedepannya.',
                'kategori_badge' => 'Koordinasi PJ',
            ],
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-10',
                'kegiatan'       => 'Koordinasi Dengan Pihak TPS3R Assalafiyyah',
                'keterangan'     => 'Koordinasi rutin dari kebersihan untuk memastikan, memberikan evaluasi, atau memberi masukan terkait program yang dijalankan.',
                'kategori_badge' => 'Koordinasi Sowan',
            ],
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-13',
                'kegiatan'       => 'Koordinasi Dengan Ketua K3L (Bapak Afif Muzayyin)',
                'keterangan'     => 'Koordinasi rutin untuk melaporkan hasil program kerja bidang kebersihan yang telah setengah bulan dilakukan.',
                'kategori_badge' => 'Koordinasi Sowan',
            ],
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-21',
                'kegiatan'       => 'Koordinasi Dengan Pengurus Gemerlap',
                'keterangan'     => 'Koordinasi terkait pelaporan evaluasi, permasalahan, capaian, dan target program kebersihan jangka waktu 1 bulan.',
                'kategori_badge' => 'Koordinasi Kader',
            ],
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-24',
                'kegiatan'       => 'Koordinasi Dengan Pengurus Satgas Sekolah',
                'keterangan'     => 'Koordinasi terkait pelaporan evaluasi, permasalahan, capaian, dan target program kebersihan jangka waktu 1 bulan.',
                'kategori_badge' => 'Koordinasi Kader',
            ],
            [
                'buku_id'        => $bukuId,
                'tanggal'        => '2026-09-25',
                'kegiatan'       => "Koordinasi Dengan Ketua Yayasan (Bapak KH. Zar'anuddin)",
                'keterangan'     => 'Koordinasi terkait pelaporan hasil kinerja program kebersihan, penyampaian evaluasi dan permasalahan yang belum bisa ditemukan solusi terbaiknya.',
                'kategori_badge' => 'Koordinasi Sowan',
            ],
        ];

        foreach ($agendas as $agenda) {
            $agenda['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('proker_agenda')->insert($agenda);
        }

        // 4. Seed Target Bulanan
        $targets = [
            'Pendistribusian alat kebersihan di lingkungan sekolah & asrama.',
            'Mensukseskan koordinasi kebersihan rutin tepat waktu.',
            'Pencatatan & penilaian piket kebersihan kamar secara terjadwal.',
            'Pemberian reward bagi kamar/asrama paling bersih.',
        ];

        foreach ($targets as $target) {
            $this->db->table('target_bulanan')->insert([
                'buku_id'     => $bukuId,
                'target_text' => $target,
                'kategori'    => 'Umum',
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        // 5. Seed Laporan Hasil Koordinasi Terjadwal (Sampel Agustus 2026)
        $laporans = [
            [
                'buku_id'      => $bukuId,
                'kegiatan'     => 'Seminar Bersama Get Plastic Jogja',
                'hari_tanggal' => 'Sabtu, 1 Agustus 2026',
                'tempat'       => 'Trajumas',
                'bersama'      => 'Get Plastic Jogja',
                'hasil_materi' => "1. Mengetahui proses pembuatan BBM dari sampah plastik.\n2. Mengikat kerjasama dengan Get Plastic untuk pengadaan alat pirolisis.",
                'jenis'        => 'terjadwal',
            ],
            [
                'buku_id'      => $bukuId,
                'kegiatan'     => 'Koordinasi Sowan',
                'hari_tanggal' => 'Minggu, 9 Agustus 2026',
                'tempat'       => 'Ndalem Pak KH. Chasan',
                'bersama'      => 'Pak Afif Muzayyin',
                'hasil_materi' => '1. Pelaporan LPJ Kebersihan',
                'jenis'        => 'terjadwal',
            ],
            [
                'buku_id'      => $bukuId,
                'kegiatan'     => 'Koordinasi Kebersihan Asrama',
                'hari_tanggal' => 'Rabu, 12 Agustus 2026',
                'tempat'       => 'Perpustakaan',
                'bersama'      => 'Kebersihan Asrama',
                'hasil_materi' => "1. Menyetorkan LPJ Bulanan.\n2. Pembahasan Permasalahan.",
                'jenis'        => 'terjadwal',
            ],
        ];

        foreach ($laporans as $laporan) {
            $laporan['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('laporan_koordinasi')->insert($laporan);
        }
    }
}
