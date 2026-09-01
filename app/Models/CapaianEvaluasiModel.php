<?php

namespace App\Models;

use CodeIgniter\Model;

class CapaianEvaluasiModel extends Model
{
    protected $table            = 'capaian_evaluasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'unit_id', 'capaian_text', 'target_text', 'permasalahan_text', 'evaluasi_solusi_text', 'usulan_text', 'created_at', 'updated_at'];
}
