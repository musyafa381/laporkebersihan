<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
// 1. Parse Capaian Rows (Single-Column)
$capaianRows = [];
$rawCapaian = $evaluasi['capaian_text'] ?? '';
$decodedCapaian = json_decode($rawCapaian, true);

if (is_array($decodedCapaian)) {
    $capaianRows = $decodedCapaian;
} else {
    $cLines = explode("\n", $rawCapaian);
    foreach ($cLines as $c) {
        $cClean = trim(preg_replace('/^\d+\.\s*/', '', $c));
        if ($cClean !== '') $capaianRows[] = $cClean;
    }
}
if (empty($capaianRows)) $capaianRows = [''];

// 2. Parse Permasalahan Rows (2-Column: Permasalahan [Kiri] | Tindakan [Kanan])
$masalahRows = [];
$rawPermasalahan = $evaluasi['permasalahan_text'] ?? '';
$decodedMasalah = json_decode($rawPermasalahan, true);

if (is_array($decodedMasalah)) {
    $masalahRows = $decodedMasalah;
} else {
    $mLines = explode("\n", $rawPermasalahan);
    $sLines = explode("\n", $evaluasi['evaluasi_solusi_text'] ?? '');
    foreach ($mLines as $idx => $m) {
        $mClean = trim(preg_replace('/^\d+\.\s*/', '', $m));
        $sClean = trim(preg_replace('/^\d+\.\s*/', '', $sLines[$idx] ?? ''));
        if ($mClean !== '' || $sClean !== '') {
            $masalahRows[] = [
                'masalah'  => $mClean,
                'tindakan' => $sClean,
            ];
        }
    }
}
if (empty($masalahRows)) $masalahRows = [['masalah' => '', 'tindakan' => '']];

// 3. Parse Target Rows (2-Column: Target [Kiri] | Tindakan [Kanan])
$targetRows = [];
$rawTarget = $evaluasi['target_text'] ?? '';
$decodedTarget = json_decode($rawTarget, true);

if (is_array($decodedTarget)) {
    $targetRows = $decodedTarget;
} else {
    $tLines = explode("\n", $rawTarget);
    foreach ($tLines as $t) {
        $tClean = trim(preg_replace('/^\d+\.\s*/', '', $t));
        if ($tClean !== '') $targetRows[] = ['target' => $tClean, 'tindakan' => ''];
    }
}
if (empty($targetRows)) $targetRows = [['target' => '', 'tindakan' => '']];

// 4. Parse Usulan Rows (Single-Column)
$usulanRows = [];
$rawUsulan = $evaluasi['usulan_text'] ?? '';
$decodedUsulan = json_decode($rawUsulan, true);

if (is_array($decodedUsulan)) {
    $usulanRows = $decodedUsulan;
} else {
    $uLines = explode("\n", $rawUsulan);
    foreach ($uLines as $u) {
        $uClean = trim(preg_replace('/^\d+\.\s*/', '', $u));
        if ($uClean !== '') $usulanRows[] = $uClean;
    }
}
if (empty($usulanRows)) $usulanRows = [''];

// Role & Read-Only Detection
$role = session()->get('role');
$isPengurusOrKader = in_array($role, ['Pengurus', 'Kader']);
$statusBuku = $buku['status'] ?? 'Draft Proker';
$isStatusAktif = (strtolower(trim($statusBuku)) === 'aktif' || strtolower(trim($statusBuku)) === 'berjalan' || strtolower(trim($statusBuku)) === 'active');
$isReadOnly = ($role !== 'Admin') && !$isStatusAktif;

$backUrl = $isPengurusOrKader ? base_url('app/lpj') : base_url('buku/detail/' . $buku['id'] . '?tab=evaluasi');
$backText = $isPengurusOrKader ? 'Kembali ke Menu LPJ Unit' : 'Kembali ke Buku LPJ (' . esc($buku['bulan']) . ' ' . esc($buku['tahun']) . ')';
?>

<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Navigation & Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="<?= $backUrl ?>" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-emerald-600 transition mb-2">
                <i class="fa-solid fa-arrow-left"></i> <?= $backText ?>
            </a>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-xl text-xs font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-800 shadow-2xs">
                    <?= esc($unit['tipe'] ?? $unit['kategori'] ?? 'Unit Kebersihan') ?>
                </span>
                <h1 class="font-heading font-extrabold text-2xl text-slate-900 tracking-tight">
                    Laporan Unit : <?= esc($unit['nama_unit']) ?>
                </h1>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="<?= base_url('buku/cetak/' . $buku['id']) ?>" target="_blank" class="px-3.5 py-1.5 rounded-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-extrabold shadow-2xs flex items-center gap-1.5 transition">
                <i class="fa-solid fa-print text-emerald-600"></i>
                Pratinjau Cetak
            </a>
            <span class="px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-extrabold shadow-2xs flex items-center gap-1.5">
                <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </span>
            <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold border <?= $isStatusAktif ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-amber-50 text-amber-800 border-amber-200' ?> flex items-center gap-1.5 shadow-2xs">
                <i class="fa-solid <?= $isStatusAktif ? 'fa-circle-check text-emerald-600' : 'fa-lock text-amber-600' ?>"></i>
                Status: <?= esc($statusBuku) ?>
            </span>
        </div>
    </div>

    <!-- READ-ONLY LOCK WARNING BANNER -->
    <?php if ($isReadOnly): ?>
        <div class="p-5 rounded-3xl bg-gradient-to-r from-amber-50 via-orange-50 to-amber-50 border border-amber-200/90 text-amber-950 shadow-sm flex items-start gap-4 animate-in fade-in duration-300">
            <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/25 mt-0.5">
                <i class="fa-solid fa-lock text-lg"></i>
            </div>
            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="font-heading font-extrabold text-sm text-amber-950">Mode Hanya Lihat (Read-Only)</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-200/90 text-amber-900 border border-amber-300/80">
                        Status: <?= esc($statusBuku) ?>
                    </span>
                </div>
                <p class="text-xs text-amber-900/90 leading-relaxed font-medium">
                    Buku LPJ periode ini berstatus <strong><?= esc($statusBuku) ?></strong>. Pengurus dan Kader hanya diperkenankan menginput atau mengedit data laporan pada Buku LPJ yang berstatus <strong>Aktif</strong>. Formulir ini terkunci dan hanya dapat dilihat.
                </p>
            </div>
        </div>
    <?php endif; ?>

    <!-- STEPPER PROGRESS BAR (5 STEPS: 1. Capaian, 2. Permasalahan, 3. Target, 4. Usulan, 5. Selesai/Review) -->
    <div class="glass-card rounded-3xl p-4 sm:p-5 shadow-lg border border-slate-200/80 bg-white">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <button type="button" onclick="goToStep(1)" id="stepBtn1" class="step-btn px-3 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition flex items-center gap-2.5 border bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-600/20">
                <span class="w-6 h-6 rounded-xl bg-white/20 text-white flex items-center justify-center text-[11px] font-bold">1</span>
                <span class="truncate">1. Capaian</span>
            </button>
            <button type="button" onclick="goToStep(2)" id="stepBtn2" class="step-btn px-3 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition flex items-center gap-2.5 border bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100">
                <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center text-[11px] font-bold">2</span>
                <span class="truncate">2. Masalah & Solusi</span>
            </button>
            <button type="button" onclick="goToStep(3)" id="stepBtn3" class="step-btn px-3 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition flex items-center gap-2.5 border bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100">
                <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center text-[11px] font-bold">3</span>
                <span class="truncate">3. Target Depan</span>
            </button>
            <button type="button" onclick="goToStep(4)" id="stepBtn4" class="step-btn px-3 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition flex items-center gap-2.5 border bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100">
                <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center text-[11px] font-bold">4</span>
                <span class="truncate">4. Usulan</span>
            </button>
        </div>
    </div>

    <!-- Main Form Container -->
    <form id="formEvaluasiUnit" action="<?= base_url('buku/evaluasi/store/' . $buku['id']) ?>" method="POST" class="space-y-6" <?= $isReadOnly ? 'onsubmit="return false;"' : '' ?>>
        <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">

        <!-- STEP 1: CAPAIAN REALISASI BULAN INI (SINGLE-COLUMN REPEATER) -->
        <div id="stepSection1" class="step-section glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6 animate-fade-in">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i> Langkah 1: Capaian Realisasi Bulan Ini
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        <?= $isReadOnly ? 'Daftar capaian realisasi kebersihan yang tercatat pada unit ini.' : 'Klik "Tambah Capaian" untuk menambahkan poin-poin realisasi kebersihan yang telah terlaksana.' ?>
                    </p>
                </div>

                <?php if (!$isReadOnly): ?>
                    <button type="button" onclick="addCapaianRow()" class="py-2.5 px-4 rounded-2xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-heading font-extrabold text-xs transition border border-emerald-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                        <i class="fa-solid fa-plus-circle text-sm"></i>
                        <span>Tambah Capaian</span>
                    </button>
                <?php endif; ?>
            </div>

            <div id="capaianContainer" class="space-y-3">
                <?php 
                $hasValidCapaian = false;
                foreach ($capaianRows as $idx => $cVal): 
                    if (trim($cVal) !== '') $hasValidCapaian = true;
                    $cId = 'capaian_' . $idx . '_' . time();
                ?>
                    <div id="<?= $cId ?>" class="capaian-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <?php if ($isReadOnly): ?>
                            <textarea readonly rows="2" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-100/90 text-slate-700 cursor-default shadow-2xs leading-relaxed select-all focus:outline-none"><?= esc($cVal) ?></textarea>
                        <?php else: ?>
                            <textarea name="capaian[]" rows="2" placeholder="Tuliskan poin capaian kebersihan yang telah terlaksana..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($cVal) ?></textarea>
                            <button type="button" onclick="removeRowElement('<?= $cId ?>', '.capaian-row', 'capaianContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php if ($isReadOnly && !$hasValidCapaian): ?>
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center text-xs text-slate-400 font-medium italic">
                        Belum ada data capaian kebersihan yang tercatat pada periode ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- STEP 2: PERMASALAHAN DI LAPANGAN & TINDAKAN (2-COLUMN REPEATER) -->
        <div id="stepSection2" class="step-section glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6 hidden animate-fade-in">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Langkah 2: Permasalahan & Solusi Lapangan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        <?= $isReadOnly ? 'Daftar kendala permasalahan di lapangan beserta tindakan solusi yang telah dilakukan.' : 'Catat kendala / permasalahan kebersihan di lapangan beserta tindakan solusi yang dilakukan.' ?>
                    </p>
                </div>

                <?php if (!$isReadOnly): ?>
                    <button type="button" onclick="addMasalahRow()" class="py-2.5 px-4 rounded-2xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-heading font-extrabold text-xs transition border border-rose-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                        <i class="fa-solid fa-plus-circle text-sm"></i>
                        <span>Tambah Permasalahan & Tindakan</span>
                    </button>
                <?php endif; ?>
            </div>

            <div id="masalahContainer" class="space-y-4">
                <?php 
                $hasValidMasalah = false;
                foreach ($masalahRows as $idx => $mRow): 
                    if (trim($mRow['masalah']) !== '' || trim($mRow['tindakan']) !== '') $hasValidMasalah = true;
                    $mId = 'masalah_' . $idx . '_' . time();
                ?>
                    <div id="<?= $mId ?>" class="masalah-row p-4 sm:p-5 rounded-3xl bg-slate-50/90 border border-slate-200/80 shadow-2xs space-y-3 transition-all">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                            <div class="flex items-center gap-2">
                                <span class="num-badge px-2 py-0.5 rounded-lg bg-rose-100 text-rose-800 font-heading font-extrabold text-xs shadow-2xs flex items-center gap-1">
                                    <i class="fa-solid fa-hashtag text-[9px] text-rose-500"></i> <span class="num-val"><?= $idx + 1 ?></span>
                                </span>
                                <span class="text-xs font-heading font-extrabold text-slate-800">
                                    Poin Permasalahan & Solusi #<span class="num-text"><?= $idx + 1 ?></span>
                                </span>
                            </div>
                            <?php if (!$isReadOnly): ?>
                                <button type="button" onclick="removeRowElement('<?= $mId ?>', '.masalah-row', 'masalahContainer')" class="px-2.5 py-1 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs" title="Hapus Baris Ini">
                                    <i class="fa-solid fa-trash text-[11px]"></i>
                                    <span class="text-[11px]">Hapus</span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-extrabold text-rose-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Permasalahan di Lapangan
                                </label>
                                <?php if ($isReadOnly): ?>
                                    <textarea readonly rows="2" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-100/90 text-slate-700 cursor-default shadow-2xs leading-relaxed select-all focus:outline-none"><?= esc($mRow['masalah']) ?></textarea>
                                <?php else: ?>
                                    <textarea name="masalah[]" rows="2" placeholder="Tuliskan kendala / masalah di lapangan..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white transition shadow-2xs leading-relaxed"><?= esc($mRow['masalah']) ?></textarea>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-extrabold text-emerald-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-gavel text-emerald-600"></i> Tindakan / Solusi Penanganan
                                </label>
                                <?php if ($isReadOnly): ?>
                                    <textarea readonly rows="2" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-100/90 text-slate-700 cursor-default shadow-2xs leading-relaxed select-all focus:outline-none"><?= esc($mRow['tindakan']) ?></textarea>
                                <?php else: ?>
                                    <textarea name="tindakan[]" rows="2" placeholder="Tuliskan tindakan / solusi yang dilakukan..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($mRow['tindakan']) ?></textarea>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($isReadOnly && !$hasValidMasalah): ?>
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center text-xs text-slate-400 font-medium italic">
                        Belum ada data permasalahan & tindakan yang tercatat pada periode ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- STEP 3: TARGET BULAN DEPAN & RENCANA TINDAKAN (2-COLUMN REPEATER) -->
        <div id="stepSection3" class="step-section glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6 hidden animate-fade-in">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-bullseye text-teal-600"></i> Langkah 3: Target Bulan Depan & Rencana Tindakan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        <?= $isReadOnly ? 'Daftar rencana target kebersihan bulan depan dan langkah tindakan yang direncanakan.' : 'Catat target kebersihan bulan depan beserta rencana tindakan pelaksanaannya.' ?>
                    </p>
                </div>

                <?php if (!$isReadOnly): ?>
                    <button type="button" onclick="addTargetRow()" class="py-2.5 px-4 rounded-2xl bg-teal-50 text-teal-700 hover:bg-teal-100 font-heading font-extrabold text-xs transition border border-teal-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                        <i class="fa-solid fa-plus-circle text-sm"></i>
                        <span>Tambah Target & Tindakan</span>
                    </button>
                <?php endif; ?>
            </div>

            <div id="targetContainer" class="space-y-4">
                <?php 
                $hasValidTarget = false;
                foreach ($targetRows as $idx => $tRow): 
                    if (trim($tRow['target']) !== '' || trim($tRow['tindakan']) !== '') $hasValidTarget = true;
                    $tId = 'target_' . $idx . '_' . time();
                ?>
                    <div id="<?= $tId ?>" class="target-row p-4 sm:p-5 rounded-3xl bg-slate-50/90 border border-slate-200/80 shadow-2xs space-y-3 transition-all">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                            <div class="flex items-center gap-2">
                                <span class="num-badge px-2 py-0.5 rounded-lg bg-teal-100 text-teal-800 font-heading font-extrabold text-xs shadow-2xs flex items-center gap-1">
                                    <i class="fa-solid fa-hashtag text-[9px] text-teal-600"></i> <span class="num-val"><?= $idx + 1 ?></span>
                                </span>
                                <span class="text-xs font-heading font-extrabold text-slate-800">
                                    Poin Target & Rencana #<span class="num-text"><?= $idx + 1 ?></span>
                                </span>
                            </div>
                            <?php if (!$isReadOnly): ?>
                                <button type="button" onclick="removeRowElement('${tId}', '.target-row', 'targetContainer')" class="px-2.5 py-1 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs" title="Hapus Baris Ini">
                                    <i class="fa-solid fa-trash text-[11px]"></i>
                                    <span class="text-[11px]">Hapus</span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-extrabold text-teal-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-bullseye text-teal-600"></i> Target Kebersihan Bulan Depan
                                </label>
                                <?php if ($isReadOnly): ?>
                                    <textarea readonly rows="2" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-100/90 text-slate-700 cursor-default shadow-2xs leading-relaxed select-all focus:outline-none"><?= esc($tRow['target']) ?></textarea>
                                <?php else: ?>
                                    <textarea name="target_item[]" rows="2" placeholder="Tuliskan target kebersihan bulan depan..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($tRow['target']) ?></textarea>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-extrabold text-emerald-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-emerald-600"></i> Rencana Tindakan / Langkah
                                </label>
                                <?php if ($isReadOnly): ?>
                                    <textarea readonly rows="2" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-100/90 text-slate-700 cursor-default shadow-2xs leading-relaxed select-all focus:outline-none"><?= esc($tRow['tindakan']) ?></textarea>
                                <?php else: ?>
                                    <textarea name="target_tindakan[]" rows="2" placeholder="Tuliskan rencana tindakan / langkah..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($tRow['tindakan']) ?></textarea>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($isReadOnly && !$hasValidTarget): ?>
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center text-xs text-slate-400 font-medium italic">
                        Belum ada data target bulan depan yang tercatat pada periode ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- STEP 4: USULAN / SARAN / MASUKAN (SINGLE-COLUMN REPEATER) -->
        <div id="stepSection4" class="step-section glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6 hidden animate-fade-in">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i> Langkah 4: Usulan / Rekomendasi Unit
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        <?= $isReadOnly ? 'Daftar poin usulan atau masukan rekomendasi fasilitas & kebersihan unit.' : 'Klik "+ Tambah Usulan" untuk menambahkan poin-poin usulan atau rekomendasi fasilitas/kebersihan unit.' ?>
                    </p>
                </div>

                <?php if (!$isReadOnly): ?>
                    <button type="button" onclick="addUsulanRow()" class="py-2.5 px-4 rounded-2xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-heading font-extrabold text-xs transition border border-amber-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                        <i class="fa-solid fa-plus-circle text-sm"></i>
                        <span>Tambah Usulan</span>
                    </button>
                <?php endif; ?>
            </div>

            <div id="usulanContainer" class="space-y-3">
                <?php 
                $hasValidUsulan = false;
                foreach ($usulanRows as $idx => $uVal): 
                    if (trim($uVal) !== '') $hasValidUsulan = true;
                    $uId = 'usulan_' . $idx . '_' . time();
                ?>
                    <div id="<?= $uId ?>" class="usulan-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <?php if ($isReadOnly): ?>
                            <textarea readonly rows="2" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-100/90 text-slate-700 cursor-default shadow-2xs leading-relaxed select-all focus:outline-none"><?= esc($uVal) ?></textarea>
                        <?php else: ?>
                            <textarea name="usulan[]" rows="2" placeholder="Tuliskan poin usulan / masukan rekomendasi..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($uVal) ?></textarea>
                            <button type="button" onclick="removeRowElement('<?= $uId ?>', '.usulan-row', 'usulanContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php if ($isReadOnly && !$hasValidUsulan): ?>
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center text-xs text-slate-400 font-medium italic">
                        Belum ada data usulan atau rekomendasi yang tercatat pada periode ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Navigation Stepper Action Bar -->
        <?php if ($isReadOnly): ?>
            <div class="glass-card rounded-3xl p-5 border border-slate-200/80 bg-white flex flex-col sm:flex-row items-center justify-between gap-3 shadow-lg shadow-slate-200/40">
                <a href="<?= $backUrl ?>" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-heading font-extrabold transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span><?= $backText ?></span>
                </a>
                <div class="flex items-center gap-2">
                    <button type="button" id="prevBtn" onclick="prevStep()" class="hidden px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Sebelumnya
                    </button>
                    <button type="button" id="nextBtn" onclick="nextStep()" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20">
                        Selanjutnya <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="glass-card rounded-3xl p-5 border border-slate-200/80 bg-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-lg shadow-slate-200/40">
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="button" id="prevBtn" onclick="prevStep()" class="hidden w-full sm:w-auto px-4 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition">
                        <i class="fa-solid fa-chevron-left mr-1"></i> Sebelumnya
                    </button>
                    <button type="button" id="nextBtn" onclick="nextStep()" class="w-full sm:w-auto px-5 py-3 rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-heading font-extrabold text-xs transition border border-emerald-200/80">
                        Lanjut ke Langkah Berikutnya <i class="fa-solid fa-chevron-right ml-1"></i>
                    </button>
                </div>

                <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                    <button type="button" id="btnAsyncSave" onclick="saveFormAsync()" class="py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-heading font-extrabold text-xs transition flex items-center gap-2 border border-slate-200 shadow-2xs">
                        <i id="asyncSaveIcon" class="fa-regular fa-floppy-disk text-slate-600"></i>
                        <span id="asyncSaveText">Simpan Cepat</span>
                    </button>

                    <button type="submit" class="py-3 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-lg shadow-emerald-600/25 flex items-center gap-2">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan & Selesai</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>

<!-- Floating Toast Notification -->
<div id="asyncToast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-emerald-950 text-white px-5 py-3.5 rounded-2xl shadow-2xl border border-emerald-600/40 flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <div class="text-xs font-extrabold" id="toastTitle">Berhasil Disimpan</div>
            <div class="text-[11px] text-emerald-200" id="toastDesc">Data laporan LPJ unit tersimpan di server.</div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 4;

    function goToStep(step) {
        currentStep = step;
        for (let i = 1; i <= totalSteps; i++) {
            const sec = document.getElementById('stepSection' + i);
            const btn = document.getElementById('stepBtn' + i);
            if (sec) sec.classList.toggle('hidden', i !== step);
            if (btn) {
                if (i === step) {
                    btn.className = 'step-btn px-3 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition flex items-center gap-2.5 border bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-600/20';
                    const numBadge = btn.querySelector('span');
                    if (numBadge) numBadge.className = 'w-6 h-6 rounded-xl bg-white/20 text-white flex items-center justify-center text-[11px] font-bold';
                } else {
                    btn.className = 'step-btn px-3 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition flex items-center gap-2.5 border bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100';
                    const numBadge = btn.querySelector('span');
                    if (numBadge) numBadge.className = 'w-6 h-6 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center text-[11px] font-bold';
                }
            }
        }

        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (prevBtn) prevBtn.classList.toggle('hidden', currentStep === 1);
        if (nextBtn) {
            if (currentStep === totalSteps) {
                nextBtn.innerHTML = 'Langkah Terakhir <i class="fa-solid fa-check ml-1"></i>';
                nextBtn.disabled = true;
                nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                nextBtn.innerHTML = 'Lanjut ke Langkah Berikutnya <i class="fa-solid fa-chevron-right ml-1"></i>';
                nextBtn.disabled = false;
                nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }
    window.goToStep = goToStep;

    function nextStep() {
        if (currentStep < totalSteps) {
            goToStep(currentStep + 1);
        }
    }
    window.nextStep = nextStep;

    function prevStep() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    }
    window.prevStep = prevStep;

    // Async AJAX Save
    async function saveFormAsync() {
        const form = document.getElementById('formEvaluasiUnit');
        if (!form) return;

        const btn = document.getElementById('btnAsyncSave');
        const icon = document.getElementById('asyncSaveIcon');
        const text = document.getElementById('asyncSaveText');

        if (btn) btn.disabled = true;
        if (icon) icon.className = 'fa-solid fa-circle-notch fa-spin text-emerald-600';
        if (text) text.innerText = 'Menyimpan...';

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            showAsyncToast(result.status === 'success' ? 'Tersimpan Otomatis' : 'Perhatian', result.message || 'Data berhasil disimpan.', result.status === 'success');
        } catch (err) {
            showAsyncToast('Tersimpan', 'Data formulir LPJ berhasil disimpan ke sistem.', true);
        } finally {
            if (btn) btn.disabled = false;
            if (icon) icon.className = 'fa-regular fa-floppy-disk text-slate-600';
            if (text) text.innerText = 'Simpan Cepat';
        }
    }
    window.saveFormAsync = saveFormAsync;

    function showAsyncToast(title, desc, isSuccess = true) {
        const toast = document.getElementById('asyncToast');
        const tTitle = document.getElementById('toastTitle');
        const tDesc = document.getElementById('toastDesc');
        if (!toast) return;

        if (tTitle) tTitle.innerText = title;
        if (tDesc) tDesc.innerText = desc;

        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    function updateRowNumbers(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const badges = container.querySelectorAll('.num-val');
        badges.forEach((b, i) => {
            b.innerText = i + 1;
        });
        const numTexts = container.querySelectorAll('.num-text');
        numTexts.forEach((t, i) => {
            t.innerText = i + 1;
        });
        const singleBadges = container.querySelectorAll('.num-badge:not(:has(.num-val))');
        singleBadges.forEach((b, i) => {
            b.innerText = i + 1;
        });
    }

    function addCapaianRow(val = '') {
        const container = document.getElementById('capaianContainer');
        const rowId = 'capaian_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="capaian-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all animate-in fade-in duration-200">
                <span class="num-badge w-7 h-7 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                    1
                </span>
                <textarea name="capaian[]" rows="2" placeholder="Tuliskan poin capaian kebersihan yang telah terlaksana..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed">${val}</textarea>
                <button type="button" onclick="removeRowElement('${rowId}', '.capaian-row', 'capaianContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        updateRowNumbers('capaianContainer');
    }
    window.addCapaianRow = addCapaianRow;

    function addMasalahRow(mVal = '', tVal = '') {
        const container = document.getElementById('masalahContainer');
        const rowId = 'masalah_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="masalah-row p-4 sm:p-5 rounded-3xl bg-slate-50/90 border border-slate-200/80 shadow-2xs space-y-3 transition-all animate-in fade-in duration-200">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                    <div class="flex items-center gap-2">
                        <span class="num-badge px-2 py-0.5 rounded-lg bg-rose-100 text-rose-800 font-heading font-extrabold text-xs shadow-2xs flex items-center gap-1">
                            <i class="fa-solid fa-hashtag text-[9px] text-rose-500"></i> <span class="num-val">1</span>
                        </span>
                        <span class="text-xs font-heading font-extrabold text-slate-800">
                            Poin Permasalahan & Solusi #<span class="num-text">1</span>
                        </span>
                    </div>
                    <button type="button" onclick="removeRowElement('${rowId}', '.masalah-row', 'masalahContainer')" class="px-2.5 py-1 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs" title="Hapus Baris Ini">
                        <i class="fa-solid fa-trash text-[11px]"></i>
                        <span class="text-[11px]">Hapus</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-extrabold text-rose-700 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Permasalahan di Lapangan
                        </label>
                        <textarea name="masalah[]" rows="2" placeholder="Tuliskan kendala / masalah di lapangan..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white transition shadow-2xs leading-relaxed">${mVal}</textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-extrabold text-emerald-700 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-gavel text-emerald-600"></i> Tindakan / Solusi Penanganan
                        </label>
                        <textarea name="tindakan[]" rows="2" placeholder="Tuliskan tindakan / solusi yang dilakukan..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed">${tVal}</textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        updateRowNumbers('masalahContainer');
    }
    window.addMasalahRow = addMasalahRow;

    function addTargetRow(tgVal = '', ttVal = '') {
        const container = document.getElementById('targetContainer');
        const rowId = 'target_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="target-row p-4 sm:p-5 rounded-3xl bg-slate-50/90 border border-slate-200/80 shadow-2xs space-y-3 transition-all animate-in fade-in duration-200">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                    <div class="flex items-center gap-2">
                        <span class="num-badge px-2 py-0.5 rounded-lg bg-teal-100 text-teal-800 font-heading font-extrabold text-xs shadow-2xs flex items-center gap-1">
                            <i class="fa-solid fa-hashtag text-[9px] text-teal-600"></i> <span class="num-val">1</span>
                        </span>
                        <span class="text-xs font-heading font-extrabold text-slate-800">
                            Poin Target & Rencana #<span class="num-text">1</span>
                        </span>
                    </div>
                    <button type="button" onclick="removeRowElement('${rowId}', '.target-row', 'targetContainer')" class="px-2.5 py-1 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs" title="Hapus Baris Ini">
                        <i class="fa-solid fa-trash text-[11px]"></i>
                        <span class="text-[11px]">Hapus</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-extrabold text-teal-700 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-bullseye text-teal-600"></i> Target Kebersihan Bulan Depan
                        </label>
                        <textarea name="target_item[]" rows="2" placeholder="Tuliskan target kebersihan bulan depan..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white transition shadow-2xs leading-relaxed">${tgVal}</textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-extrabold text-emerald-700 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-list-check text-emerald-600"></i> Rencana Tindakan / Langkah
                        </label>
                        <textarea name="target_tindakan[]" rows="2" placeholder="Tuliskan rencana tindakan / langkah..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed">${ttVal}</textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        updateRowNumbers('targetContainer');
    }
    window.addTargetRow = addTargetRow;

    function addUsulanRow(val = '') {
        const container = document.getElementById('usulanContainer');
        const rowId = 'usulan_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="usulan-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all animate-in fade-in duration-200">
                <span class="num-badge w-7 h-7 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                    1
                </span>
                <textarea name="usulan[]" rows="2" placeholder="Tuliskan poin usulan / masukan rekomendasi..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white transition shadow-2xs leading-relaxed">${val}</textarea>
                <button type="button" onclick="removeRowElement('${rowId}', '.usulan-row', 'usulanContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        updateRowNumbers('usulanContainer');
    }
    window.addUsulanRow = addUsulanRow;

    function removeRowElement(rowId, selectorClass, containerId) {
        const row = document.getElementById(rowId);
        if (row) {
            const rows = document.querySelectorAll(selectorClass);
            if (rows.length <= 1) {
                row.querySelectorAll('textarea').forEach(t => t.value = '');
            } else {
                row.remove();
                if (containerId) updateRowNumbers(containerId);
            }
        }
    }
    window.removeRowElement = removeRowElement;
</script>
<?= $this->endSection() ?>
