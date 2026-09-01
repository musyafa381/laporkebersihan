<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKoordinasiModel extends Model
{
    protected $table            = 'laporan_koordinasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'kegiatan', 'hari_tanggal', 'tempat', 'bersama', 'hasil_materi', 'foto', 'jenis', 'created_at'];
}
