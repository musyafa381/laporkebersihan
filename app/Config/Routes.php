<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Routes Buku LPJ Bulanan
$routes->get('/buku', 'Buku::index');
$routes->post('/buku/store', 'Buku::store');
$routes->post('/buku/update/(:num)', 'Buku::updateBuku/$1');
$routes->get('/buku/delete/(:num)', 'Buku::deleteBuku/$1');

$routes->get('/buku/detail/(:num)', 'Buku::detail/$1');
$routes->post('/buku/update-status/(:num)', 'Buku::updateStatus/$1');

// Sub-modul Proker, Target, Capaian & Evaluasi
$routes->post('/buku/proker/store/(:num)', 'Buku::storeProker/$1');
$routes->post('/buku/proker/update/(:num)', 'Buku::updateProker/$1');
$routes->get('/buku/proker/delete/(:num)', 'Buku::deleteProker/$1');
$routes->post('/buku/target/store/(:num)', 'Buku::storeTarget/$1');
$routes->get('/buku/target/delete/(:num)', 'Buku::deleteTarget/$1');
$routes->post('/buku/capaian/store/(:num)', 'Buku::storeCapaian/$1');
$routes->get('/buku/capaian/delete/(:num)', 'Buku::deleteCapaian/$1');
$routes->post('/buku/evaluasi-bulanan/store/(:num)', 'Buku::storeEvaluasiBulanan/$1');
$routes->get('/buku/evaluasi-bulanan/delete/(:num)', 'Buku::deleteEvaluasiBulanan/$1');

// Sub-modul Koordinasi
$routes->post('/buku/koordinasi/store/(:num)', 'Buku::storeKoordinasi/$1');
$routes->get('/buku/koordinasi/delete/(:num)', 'Buku::deleteKoordinasi/$1');
$routes->get('/buku/koordinasi/delete-foto/(:num)', 'Buku::deleteFotoKoordinasi/$1');

// Sub-modul Evaluasi Unit & Master Unit
$routes->get('/buku/evaluasi/form/(:num)/(:num)', 'Buku::formEvaluasi/$1/$2');
$routes->post('/buku/evaluasi/store/(:num)', 'Buku::storeEvaluasi/$1');
$routes->post('/buku/unit/store', 'Buku::storeUnit');
$routes->get('/buku/unit/delete/(:num)', 'Buku::deleteUnit/$1');

// Import / Link Keuangan ke Buku LPJ
$routes->post('/buku/keuangan/import/(:num)', 'Buku::importKeuangan/$1');
$routes->get('/buku/keuangan/unlink/(:num)', 'Buku::unlinkKeuangan/$1');

// Cetak / Print View PDF LPJ
$routes->get('/buku/cetak/(:num)', 'Buku::cetak/$1');

// Menu & Sub-modul Keuangan Standalone (Option B)
$routes->get('/keuangan', 'Keuangan::index');
$routes->post('/keuangan/store', 'Keuangan::store');
$routes->post('/keuangan/update/(:num)', 'Keuangan::update/$1');
$routes->get('/keuangan/detail/(:num)', 'Keuangan::detail/$1');
$routes->get('/keuangan/delete/(:num)', 'Keuangan::delete/$1');
$routes->post('/keuangan/store-masuk/(:num)', 'Keuangan::storeKeuanganMasuk/$1');
$routes->post('/keuangan/store-pembelian/(:num)', 'Keuangan::storeKeuanganPembelian/$1');
$routes->get('/keuangan/cetak/(:num)', 'Keuangan::cetak/$1');

// Menu Tambahan Navbar & Modul Alat Inventaris
$routes->get('/alat', 'Alat::index');
$routes->post('/alat/store', 'Alat::storeAlat');
$routes->post('/alat/update/(:num)', 'Alat::updateAlat/$1');
$routes->get('/alat/delete/(:num)', 'Alat::deleteAlat/$1');
$routes->post('/alat/transaksi/store', 'Alat::storeTransaksi');
$routes->get('/alat/transaksi/delete/(:num)', 'Alat::deleteTransaksi/$1');

// Routes Kategori Alat Kebersihan
$routes->post('/alat/kategori/store', 'Alat::storeKategori');
$routes->post('/alat/kategori/update/(:num)', 'Alat::updateKategori/$1');
$routes->get('/alat/kategori/delete/(:num)', 'Alat::deleteKategori/$1');

// Auth & User Profile Management (Admin Only Registration)
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');

$routes->get('/pengaturan', 'Pengaturan::index');
$routes->post('/pengaturan/update-general', 'Pengaturan::updateGeneral');
$routes->post('/pengaturan/update-pengesahan', 'Pengaturan::updatePengesahan');
$routes->post('/pengaturan/update-cs', 'Pengaturan::updateCs');
$routes->post('/pengaturan/unit/store', 'Pengaturan::storeUnit');
$routes->post('/pengaturan/unit/update/(:num)', 'Pengaturan::updateUnit/$1');
$routes->get('/pengaturan/unit/delete/(:num)', 'Pengaturan::deleteUnit/$1');
$routes->get('/pengaturan/unit/detail/(:num)', 'Unit::detail/$1');

// Routes CRUD Tipe Unit & Kategori Alat di Pengaturan
$routes->post('/pengaturan/tipe/store', 'Pengaturan::storeTipe');
$routes->post('/pengaturan/tipe/update/(:num)', 'Pengaturan::updateTipe/$1');
$routes->get('/pengaturan/tipe/delete/(:num)', 'Pengaturan::deleteTipe/$1');
$routes->post('/pengaturan/kategori-alat/store', 'Pengaturan::storeKategoriAlat');
$routes->post('/pengaturan/kategori-alat/update/(:num)', 'Pengaturan::updateKategoriAlat/$1');
$routes->get('/pengaturan/kategori-alat/delete/(:num)', 'Pengaturan::deleteKategoriAlat/$1');

// Standalone Modul & Halaman Detail Instansi / Unit
$routes->get('/unit/detail/(:num)', 'Unit::detail/$1');
$routes->post('/unit/pj/add/(:num)', 'Unit::addPj/$1');
$routes->get('/unit/pj/delete/(:num)', 'Unit::deletePj/$1');
$routes->post('/unit/kader/add/(:num)', 'Unit::addKader/$1');
$routes->get('/unit/kader/delete/(:num)', 'Unit::deleteKader/$1');
$routes->get('/pengaturan/backup', 'Pengaturan::backupDatabase');
$routes->get('/profil', 'Profil::index');
$routes->post('/profil/update-me', 'Profil::updateMyProfile');
$routes->post('/profil/change-password', 'Profil::changeMyPassword');
$routes->post('/profil/store', 'Profil::storeUser');
$routes->post('/profil/update/(:num)', 'Profil::updateUser/$1');
$routes->get('/profil/delete/(:num)', 'Profil::deleteUser/$1');

// Pusat Bantuan, FAQ & Panduan Alur Sistem (Multi-Role & Public)
$routes->get('/faq', 'Faq::index');
$routes->get('/bantuan', 'Faq::index');
$routes->post('/faq/store', 'Faq::storeFaq');
$routes->post('/faq/update/(:num)', 'Faq::updateFaq/$1');
$routes->get('/faq/delete/(:num)', 'Faq::deleteFaq/$1');
$routes->post('/faq/alur/store', 'Faq::storeAlur');
$routes->post('/faq/alur/update/(:num)', 'Faq::updateAlur/$1');
$routes->get('/faq/alur/delete/(:num)', 'Faq::deleteAlur/$1');

// Public & Admin Customer Service
$routes->get('/cs', 'Cs::index');
$routes->post('/cs/public/store', 'Cs::storePublicReport');
$routes->post('/cs/report/update/(:num)', 'Cs::updateReportStatus/$1');
$routes->get('/cs/report/delete/(:num)', 'Cs::deleteReport/$1');
$routes->post('/cs/pengajuan/update/(:num)', 'Cs::updatePengajuanStatus/$1');
$routes->get('/cs/pengajuan/delete/(:num)', 'Cs::deletePengajuan/$1');

// Frontend Mobile App Portal (Pengurus & Kader)
$routes->get('/app', 'AppPortal::index');
$routes->get('/app/lpj', 'AppPortal::lpj');
$routes->get('/app/pengajuan-alat', 'AppPortal::pengajuanAlat');
$routes->post('/app/pengajuan-alat/store', 'AppPortal::storePengajuanAlat');
$routes->get('/app/laporan-kebersihan', 'AppPortal::laporanKebersihan');
$routes->post('/app/aduan-unit/tanggapi/(:num)', 'AppPortal::tanggapiAduanUnit/$1');

// Menu Struktur Kebersihan (Drag and Drop)
$routes->get('/struktur', 'Struktur::index');
$routes->post('/struktur/update-order', 'Struktur::updateOrder');
$routes->post('/struktur/store', 'Struktur::store');
$routes->post('/struktur/update/(:num)', 'Struktur::update/$1');
$routes->get('/struktur/delete/(:num)', 'Struktur::delete/$1');

// Menu & CRUD SOP Kebersihan (Peraturan, Kebijakan, Program Utama)
$routes->get('/sop', 'Sop::index');
$routes->get('/sop/create', 'Sop::create');
$routes->post('/sop/store', 'Sop::store');
$routes->get('/sop/edit/(:num)', 'Sop::edit/$1');
$routes->post('/sop/update/(:num)', 'Sop::update/$1');
$routes->get('/sop/delete/(:num)', 'Sop::delete/$1');

// Menu & CRUD Program Kerja Asrama, Unit & Kader Terpadu
$routes->get('/program-kerja', 'ProgramKerja::index');
$routes->get('/program-kerja/create', 'ProgramKerja::create');
$routes->get('/program-kerja/detail/(:num)', 'ProgramKerja::detail/$1');
$routes->post('/program-kerja/store', 'ProgramKerja::store');
$routes->get('/program-kerja/edit/(:num)', 'ProgramKerja::edit/$1');
$routes->post('/program-kerja/update/(:num)', 'ProgramKerja::update/$1');
$routes->get('/program-kerja/delete/(:num)', 'ProgramKerja::delete/$1');
$routes->post('/program-kerja/upload-foto/(:num)', 'ProgramKerja::uploadFoto/$1');
$routes->get('/program-kerja/delete-foto/(:num)/(:any)', 'ProgramKerja::deleteFoto/$1/$2');
$routes->get('/program-kerja/sync-lpj/(:num)', 'ProgramKerja::syncFromLpj/$1');

// Menu & CRUD Pemetaan Wilayah Kebersihan (Admin & Auditor)
$routes->get('/wilayah', 'Wilayah::index');
$routes->get('/wilayah/detail/(:num)', 'Wilayah::detail/$1');
$routes->post('/wilayah/store', 'Wilayah::store');
$routes->post('/wilayah/update/(:num)', 'Wilayah::update/$1');
$routes->get('/wilayah/delete/(:num)', 'Wilayah::delete/$1');
$routes->post('/wilayah/upload-foto/(:num)', 'Wilayah::uploadFoto/$1');
$routes->get('/wilayah/delete-foto/(:num)', 'Wilayah::deleteFoto/$1');
$routes->get('/wilayah/set-primary-foto/(:num)', 'Wilayah::setPrimaryFoto/$1');
$routes->post('/wilayah/penugasan/store/(:num)', 'Wilayah::storePenugasan/$1');
$routes->post('/wilayah/penugasan/update/(:num)', 'Wilayah::updatePenugasan/$1');
$routes->get('/wilayah/penugasan/delete/(:num)', 'Wilayah::deletePenugasan/$1');
$routes->get('/wilayah/laporan', 'Wilayah::laporan');
$routes->get('/wilayah/laporan/delete/(:num)', 'Wilayah::deleteLaporan/$1');

// Lapor Kebersihan Wilayah untuk Pengurus & Kader (Mobile Portal)
$routes->get('/app/lapor-wilayah', 'AppPortal::laporWilayah');
$routes->post('/app/lapor-wilayah/store', 'AppPortal::storeLaporWilayah');
$routes->post('/app/wilayah-tugas/store', 'AppPortal::storeWilayahTugas');
$routes->get('/app/wilayah-tugas/delete/(:num)', 'AppPortal::deleteWilayahTugas/$1');




