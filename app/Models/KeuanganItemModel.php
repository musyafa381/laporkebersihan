<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganItemModel extends Model
{
    protected $table            = 'keuangan_item_pembelian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['buku_id', 'keuangan_id', 'item_pembelian', 'plafon', 'terserap', 'created_at'];

    protected $useTimestamps = false;
}
