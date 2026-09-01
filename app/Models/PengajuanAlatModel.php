<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanAlatModel extends Model
{
    protected $table            = 'pengajuan_alat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'alat_id',
        'jumlah',
        'alasan_keperluan',
        'status',
        'catatan_admin',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;
}
