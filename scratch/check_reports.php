<?php
define('FCPATH', __DIR__ . '/../public/');
require_once __DIR__ . '/../vendor/autoload.php';
$bootstrap = require_once __DIR__ . '/../system/bootstrap.php';
$app = \Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();
echo "=== CS REPORTS ===\n";
$reports = $db->table('cs_reports')->get()->getResultArray();
foreach ($reports as $r) {
    echo "ID: {$r['id']} | Nama: {$r['nama_pengirim']} | WilayahID: {$r['wilayah_id']} | NamaWilayah: {$r['nama_wilayah']} | Shift: {$r['shift']} | UnitID: {$r['unit_id']} | UnitLokasi: {$r['unit_lokasi']} | Status: {$r['status']}\n";
}

echo "\n=== WILAYAH PENUGASAN ===\n";
$penugasan = $db->table('tbl_wilayah_penugasan')->get()->getResultArray();
foreach ($penugasan as $p) {
    echo "ID: {$p['id']} | WilayahID: {$p['wilayah_id']} | Shift: {$p['shift']} | UnitID: {$p['unit_id']}\n";
}

echo "\n=== MASTER UNIT ===\n";
$units = $db->table('master_unit')->get()->getResultArray();
foreach ($units as $u) {
    echo "ID: {$u['id']} | Nama: {$u['nama_unit']} | PJ: {$u['pj_nama']}\n";
}
