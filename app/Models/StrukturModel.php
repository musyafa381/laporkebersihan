<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturModel extends Model
{
    protected $table            = 'struktur_kebersihan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'jabatan',
        'nama_penanggung_jawab',
        'role_kategori',
        'node_category',
        'kontak_hp',
        'tugas_wewenang',
        'foto_avatar',
        'sort_order',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;
}
