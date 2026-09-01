<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table            = 'alat_inventaris';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_alat',
        'nama_alat',
        'kategori',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_sisa',
        'satuan',
        'kondisi',
        'lokasi_gudang',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;
}
