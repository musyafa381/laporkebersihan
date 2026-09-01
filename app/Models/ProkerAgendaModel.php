<?php

namespace App\Models;

use CodeIgniter\Model;

class ProkerAgendaModel extends Model
{
    protected $table            = 'proker_agenda';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'tanggal', 'kegiatan', 'keterangan', 'kategori_badge', 'created_at'];
}
