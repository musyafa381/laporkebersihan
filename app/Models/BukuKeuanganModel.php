<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuKeuanganModel extends Model
{
    protected $table            = 'buku_keuangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_keuangan', 'bulan', 'tahun', 'judul', 'created_at'];

    protected $useTimestamps = false;
}
