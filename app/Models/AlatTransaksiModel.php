<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatTransaksiModel extends Model
{
    protected $table            = 'alat_transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'alat_id',
        'jenis_transaksi',
        'tanggal',
        'jumlah',
        'penerima_penyerah',
        'unit_tujuan',
        'keterangan',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;
}
