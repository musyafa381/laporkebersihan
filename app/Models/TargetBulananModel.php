<?php

namespace App\Models;

use CodeIgniter\Model;

class TargetBulananModel extends Model
{
    protected $table            = 'target_bulanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'target_text', 'kategori', 'created_at'];
}
