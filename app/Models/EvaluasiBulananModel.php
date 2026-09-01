<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluasiBulananModel extends Model
{
    protected $table            = 'evaluasi_bulanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'evaluasi_text', 'created_at'];
}
