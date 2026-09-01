<?php

namespace App\Models;

use CodeIgniter\Model;

class CapaianBulananModel extends Model
{
    protected $table            = 'capaian_bulanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'capaian_text', 'created_at'];
}
