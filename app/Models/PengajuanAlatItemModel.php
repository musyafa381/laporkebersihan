<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanAlatItemModel extends Model
{
    protected $table            = 'pengajuan_alat_item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'pengajuan_id',
        'alat_id',
        'jumlah_minta',
        'jumlah_setuju',
        'status_item',
        'catatan_item',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;
}
