<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuLpjModel extends Model
{
    protected $table            = 'buku_lpj';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'bulan', 'tahun', 'status', 'keuangan_id', 'created_at', 'updated_at'];
    protected $useTimestamps    = true;
}
