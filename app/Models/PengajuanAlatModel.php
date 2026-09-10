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
        'kode_pengajuan',
        'user_id',
        'unit_id',
        'alasan_keperluan',
        'status',
        'catatan_admin',
        'disetujui_oleh',
        'disetujui_pada',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps    = true;

    /**
     * Auto-ensure database tables & columns exist and migrate legacy flat data safely.
     */
    public static function ensureSchema()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        // 1. Ensure pengajuan_alat table structure
        if (!$db->tableExists('pengajuan_alat')) {
            $forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'kode_pengajuan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'null'       => true,
                ],
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'unit_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'alasan_keperluan' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Pending',
                ],
                'catatan_admin' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'disetujui_oleh' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'disetujui_pada' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('pengajuan_alat', true);
        } else {
            // Add any missing columns to pengajuan_alat
            $fields = $db->getFieldNames('pengajuan_alat');
            $missingFields = [];

            if (!in_array('kode_pengajuan', $fields)) {
                $missingFields['kode_pengajuan'] = ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true, 'after' => 'id'];
            }
            if (!in_array('unit_id', $fields)) {
                $missingFields['unit_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'user_id'];
            }
            if (!in_array('disetujui_oleh', $fields)) {
                $missingFields['disetujui_oleh'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'catatan_admin'];
            }
            if (!in_array('disetujui_pada', $fields)) {
                $missingFields['disetujui_pada'] = ['type' => 'DATETIME', 'null' => true, 'after' => 'disetujui_oleh'];
            }

            if (!empty($missingFields)) {
                $forge->addColumn('pengajuan_alat', $missingFields);
            }
        }

        // 2. Ensure pengajuan_alat_item table structure
        if (!$db->tableExists('pengajuan_alat_item')) {
            $forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'pengajuan_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'alat_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'jumlah_minta' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 1,
                ],
                'jumlah_setuju' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'status_item' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Pending',
                ],
                'catatan_item' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->addKey('pengajuan_id');
            $forge->createTable('pengajuan_alat_item', true);
        }

        // 3. Auto-populate kode_pengajuan for old records and migrate old items
        $fields = $db->getFieldNames('pengajuan_alat');
        if (in_array('alat_id', $fields)) {
            // There might be legacy single-item records
            $legacyRows = $db->table('pengajuan_alat')->where('alat_id IS NOT NULL')->get()->getResultArray();
            foreach ($legacyRows as $row) {
                // If item not yet in pengajuan_alat_item
                $itemExists = $db->table('pengajuan_alat_item')->where('pengajuan_id', $row['id'])->countAllResults();
                if ($itemExists == 0 && !empty($row['alat_id'])) {
                    $db->table('pengajuan_alat_item')->insert([
                        'pengajuan_id'  => $row['id'],
                        'alat_id'       => $row['alat_id'],
                        'jumlah_minta'  => $row['jumlah'] ?? 1,
                        'jumlah_setuju' => ($row['status'] === 'Disetujui' || $row['status'] === 'Selesai') ? ($row['jumlah'] ?? 1) : null,
                        'status_item'   => $row['status'] ?? 'Pending',
                        'catatan_item'  => $row['catatan_admin'] ?? null,
                        'created_at'    => $row['created_at'] ?? date('Y-m-d H:i:s'),
                        'updated_at'    => $row['updated_at'] ?? date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        // Fill empty kode_pengajuan
        $emptyKodes = $db->table('pengajuan_alat')->where('kode_pengajuan IS NULL')->orWhere('kode_pengajuan', '')->get()->getResultArray();
        foreach ($emptyKodes as $ek) {
            $date = !empty($ek['created_at']) ? strtotime($ek['created_at']) : time();
            $kode = 'REQ-' . date('Ym', $date) . '-' . str_pad($ek['id'], 3, '0', STR_PAD_LEFT);
            $db->table('pengajuan_alat')->where('id', $ek['id'])->update(['kode_pengajuan' => $kode]);
        }
    }

    /**
     * Generate unique transaction code (e.g. REQ-202609-001)
     */
    public function generateKodePengajuan()
    {
        $prefix = 'REQ-' . date('Ym') . '-';
        $lastRow = $this->where('kode_pengajuan LIKE', $prefix . '%')
                        ->orderBy('id', 'DESC')
                        ->first();

        if ($lastRow && !empty($lastRow['kode_pengajuan'])) {
            $lastNum = (int)substr($lastRow['kode_pengajuan'], strlen($prefix));
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }

        return $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Fetch complete requests with user, unit, items, and tool info
     */
    public function getListWithItems($filters = [])
    {
        self::ensureSchema();
        $db = \Config\Database::connect();

        $builder = $db->table('pengajuan_alat p')
            ->select('p.*, u.nama_lengkap, u.username, u.role, u.no_hp, mu.nama_unit, mu.tipe as tipe_unit, mu.kode_unit, admin_u.nama_lengkap as nama_admin')
            ->join('users u', 'u.id = p.user_id', 'left')
            ->join('master_unit mu', 'mu.id = COALESCE(p.unit_id, u.unit_id)', 'left')
            ->join('users admin_u', 'admin_u.id = p.disetujui_oleh', 'left')
            ->orderBy('p.id', 'DESC');

        if (!empty($filters['user_id'])) {
            $builder->where('p.user_id', $filters['user_id']);
        }
        if (!empty($filters['unit_id'])) {
            $builder->where('(p.unit_id = ' . (int)$filters['unit_id'] . ' OR u.unit_id = ' . (int)$filters['unit_id'] . ')');
        }
        if (!empty($filters['status'])) {
            $builder->where('p.status', $filters['status']);
        }
        if (!empty($filters['id'])) {
            $builder->where('p.id', $filters['id']);
        }

        $requests = $builder->get()->getResultArray();
        if (empty($requests)) {
            return [];
        }

        $requestIds = array_column($requests, 'id');
        $itemsRaw = $db->table('pengajuan_alat_item pi')
            ->select('pi.*, ai.nama_alat, ai.kode_alat, ai.satuan, ai.kategori, ai.stok_sisa, ai.lokasi_gudang, ai.kondisi')
            ->join('alat_inventaris ai', 'ai.id = pi.alat_id', 'left')
            ->whereIn('pi.pengajuan_id', $requestIds)
            ->orderBy('pi.id', 'ASC')
            ->get()->getResultArray();

        $itemsByPengajuan = [];
        foreach ($itemsRaw as $item) {
            $itemsByPengajuan[$item['pengajuan_id']][] = $item;
        }

        foreach ($requests as &$req) {
            $req['items'] = $itemsByPengajuan[$req['id']] ?? [];
            $req['total_jenis_alat'] = count($req['items']);
            
            $totMinta = 0;
            $totSetuju = 0;
            foreach ($req['items'] as $it) {
                $totMinta += (int)($it['jumlah_minta'] ?? 0);
                $totSetuju += (int)($it['jumlah_setuju'] ?? 0);
            }
            $req['total_jumlah_minta'] = $totMinta;
            $req['total_jumlah_setuju'] = $totSetuju;
        }
        unset($req);

        return $requests;
    }
}
