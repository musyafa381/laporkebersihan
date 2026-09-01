<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganMasukModel extends Model
{
    protected $table            = 'keuangan_dana_masuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['buku_id', 'keuangan_id', 'sumber_dana', 'nominal', 'keterangan', 'created_at'];

    protected $useTimestamps = false;
}
