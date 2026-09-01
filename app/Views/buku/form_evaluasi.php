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
?>

<div class="max-w-5xl mx-auto space-y-6">

<?php
    $role = session()->get('role');
    $isPengurusOrKader = in_array($role, ['Pengurus', 'Kader']);
    $backUrl = $isPengurusOrKader ? base_url('app/lpj') : base_url('buku/detail/' . $buku['id'] . '?tab=evaluasi');
    $backText = $isPengurusOrKader ? 'Kembali ke Dashboard Portal Unit' : 'Kembali ke Buku LPJ (' . esc($buku['bulan']) . ' ' . esc($buku['tahun']) . ')';
?>
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

        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-extrabold shadow-2xs flex items-center gap-1.5">
                <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                LPJ <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </span>
        </div>
    </div>

    <!-- Main Form Container -->
    <form action="<?= base_url('buku/evaluasi/store/' . $buku['id']) ?>" method="POST" class="space-y-6">
        <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">

        <!-- CARD 1: CAPAIAN REALISASI BULAN INI (SINGLE-COLUMN REPEATER) -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i> Capaian Realisasi Bulan Ini
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Klik "Tambah Capaian" untuk menambahkan poin-poin realisasi kebersihan yang telah terlaksana.</p>
                </div>

                <button type="button" onclick="addCapaianRow()" class="py-2.5 px-4 rounded-2xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-heading font-extrabold text-xs transition border border-emerald-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Capaian</span>
                </button>
            </div>

            <div id="capaianContainer" class="space-y-3">
                <?php foreach ($capaianRows as $idx => $cVal): 
                    $cId = 'capaian_' . $idx . '_' . time();
                ?>
                    <div id="<?= $cId ?>" class="capaian-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <textarea name="capaian[]" rows="2" placeholder="Tuliskan poin capaian kebersihan yang telah terlaksana..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($cVal) ?></textarea>
                        <button type="button" onclick="removeRowElement('<?= $cId ?>', '.capaian-row', 'capaianContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CARD 2: PERMASALAHAN DI LAPANGAN & TINDAKAN (2-COLUMN REPEATER) -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Permasalahan & Tindakan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Isi kolom <b>Permasalahan</b> di sebelah kiri dan <b>Tindakan</b> di sebelah kanan.</p>
                </div>

                <button type="button" onclick="addMasalahRow()" class="py-2.5 px-4 rounded-2xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-heading font-extrabold text-xs transition border border-rose-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Permasalahan & Tindakan</span>
                </button>
            </div>

            <!-- Table Header Titles (Desktop) -->
            <div class="hidden md:grid grid-cols-12 gap-4 px-2 text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                <div class="col-span-6 flex items-center gap-1.5 text-rose-700">
                    <i class="fa-solid fa-triangle-exclamation"></i> Permasalahan
                </div>
                <div class="col-span-5 flex items-center gap-1.5 text-emerald-700">
                    <i class="fa-solid fa-gavel"></i> Tindakan
                </div>
                <div class="col-span-1 text-center text-slate-400">
                    Aksi
                </div>
            </div>

            <div id="masalahContainer" class="space-y-4">
                <?php foreach ($masalahRows as $idx => $mRow): 
                    $mId = 'masalah_' . $idx . '_' . time();
                ?>
                    <div id="<?= $mId ?>" class="masalah-row p-4 rounded-3xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex flex-col md:grid md:grid-cols-12 gap-4 items-start md:items-center transition-all">
                        <!-- Kolom Kiri: Masalah (dengan Nomor Urut) -->
                        <div class="w-full md:col-span-6 space-y-1">
                            <label class="block text-[10px] font-extrabold text-rose-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                                <i class="fa-solid fa-triangle-exclamation"></i> Permasalahan di Lapangan (Kiri)
                            </label>
                            <div class="flex items-start gap-2.5 w-full">
                                <span class="num-badge w-7 h-7 rounded-xl bg-rose-100 text-rose-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0 mt-1 shadow-2xs">
                                    <?= $idx + 1 ?>
                                </span>
                                <textarea name="masalah[]" rows="2" placeholder="Tuliskan permasalahan di lapangan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white transition shadow-2xs leading-relaxed"><?= esc($mRow['masalah']) ?></textarea>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Tindakan -->
                        <div class="w-full md:col-span-5 space-y-1">
                            <label class="block text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                                <i class="fa-solid fa-gavel"></i> Tindakan / Solusi (Kanan)
                            </label>
                            <textarea name="tindakan[]" rows="2" placeholder="Tuliskan tindakan / solusi yang dilakukan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($mRow['tindakan']) ?></textarea>
                        </div>

                        <!-- Action Hapus -->
                        <div class="w-full md:col-span-1 flex justify-end md:justify-center pt-1 md:pt-0">
                            <button type="button" onclick="removeRowElement('<?= $mId ?>', '.masalah-row', 'masalahContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs" title="Hapus Baris">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CARD 3: TARGET BULAN DEPAN & RENCANA TINDAKAN (2-COLUMN REPEATER) -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-bullseye text-teal-600"></i> Target Bulan Depan & Rencana Tindakan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Isi kolom <b>Target</b> di sebelah kiri dan <b>Rencana Tindakan</b> di sebelah kanan.</p>
                </div>

                <button type="button" onclick="addTargetRow()" class="py-2.5 px-4 rounded-2xl bg-teal-50 text-teal-700 hover:bg-teal-100 font-heading font-extrabold text-xs transition border border-teal-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Target & Tindakan</span>
                </button>
            </div>

            <!-- Table Header Titles (Desktop) -->
            <div class="hidden md:grid grid-cols-12 gap-4 px-2 text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                <div class="col-span-6 flex items-center gap-1.5 text-teal-700">
                    <i class="fa-solid fa-bullseye"></i> Target Bulan Depan
                </div>
                <div class="col-span-5 flex items-center gap-1.5 text-emerald-700">
                    <i class="fa-solid fa-list-check"></i> Rencana Tindakan
                </div>
                <div class="col-span-1 text-center text-slate-400">
                    Aksi
                </div>
            </div>

            <div id="targetContainer" class="space-y-4">
                <?php foreach ($targetRows as $idx => $tRow): 
                    $tId = 'target_' . $idx . '_' . time();
                ?>
                    <div id="<?= $tId ?>" class="target-row p-4 rounded-3xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex flex-col md:grid md:grid-cols-12 gap-4 items-start md:items-center transition-all">
                        <!-- Kolom Kiri: Target (dengan Nomor Urut) -->
                        <div class="w-full md:col-span-6 space-y-1">
                            <label class="block text-[10px] font-extrabold text-teal-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                                <i class="fa-solid fa-bullseye"></i> Target Bulan Depan (Kiri)
                            </label>
                            <div class="flex items-start gap-2.5 w-full">
                                <span class="num-badge w-7 h-7 rounded-xl bg-teal-100 text-teal-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0 mt-1 shadow-2xs">
                                    <?= $idx + 1 ?>
                                </span>
                                <textarea name="target_item[]" rows="2" placeholder="Tuliskan target kebersihan bulan depan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($tRow['target']) ?></textarea>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Tindakan -->
                        <div class="w-full md:col-span-5 space-y-1">
                            <label class="block text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                                <i class="fa-solid fa-list-check"></i> Rencana Tindakan (Kanan)
                            </label>
                            <textarea name="target_tindakan[]" rows="2" placeholder="Tuliskan rencana tindakan / langkah..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($tRow['tindakan']) ?></textarea>
                        </div>

                        <!-- Action Hapus -->
                        <div class="w-full md:col-span-1 flex justify-end md:justify-center pt-1 md:pt-0">
                            <button type="button" onclick="removeRowElement('<?= $tId ?>', '.target-row', 'targetContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs" title="Hapus Baris">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CARD 4: USULAN / SARAN / MASUKAN (SINGLE-COLUMN REPEATER) -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i> Usulan / Rekomendasi Unit
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Klik "+ Tambah Usulan" untuk menambahkan poin-poin usulan atau rekomendasi fasilitas/kebersihan unit.</p>
                </div>

                <button type="button" onclick="addUsulanRow()" class="py-2.5 px-4 rounded-2xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-heading font-extrabold text-xs transition border border-amber-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Usulan</span>
                </button>
            </div>

            <div id="usulanContainer" class="space-y-3">
                <?php foreach ($usulanRows as $idx => $uVal): 
                    $uId = 'usulan_' . $idx . '_' . time();
                ?>
                    <div id="<?= $uId ?>" class="usulan-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <textarea name="usulan[]" rows="2" placeholder="Tuliskan poin usulan / masukan rekomendasi..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($uVal) ?></textarea>
                        <button type="button" onclick="removeRowElement('<?= $uId ?>', '.usulan-row', 'usulanContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Submit & Cancel Bar -->
        <div class="glass-card rounded-3xl p-5 border border-slate-200/80 bg-white flex items-center justify-between shadow-lg shadow-slate-200/40">
            <a href="<?= base_url('buku/detail/' . $buku['id'] . '?tab=evaluasi') ?>" class="px-5 py-2.5 rounded-2xl text-slate-600 hover:text-slate-900 text-xs font-bold transition hover:bg-slate-100">
                Batal & Kembali
            </a>
            <button type="submit" class="py-3 px-8 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk text-sm"></i>
                <span>Simpan Data Laporan Unit</span>
            </button>
        </div>
    </form>

</div>

<script>
    function updateRowNumbers(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const badges = container.querySelectorAll('.num-badge');
        badges.forEach((b, i) => {
            b.innerText = i + 1;
        });
    }

    // 1. Add Capaian Row (Single-Column)
    function addCapaianRow(val = '') {
        const container = document.getElementById('capaianContainer');
        const rowId = 'capaian_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="capaian-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all animate-in fade-in zoom-in duration-200">
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

    // 2. Add Permasalahan & Tindakan Row (2-Column with Number Badge)
    function addMasalahRow(mVal = '', tVal = '') {
        const container = document.getElementById('masalahContainer');
        const rowId = 'masalah_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="masalah-row p-4 rounded-3xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex flex-col md:grid md:grid-cols-12 gap-4 items-start md:items-center transition-all animate-in fade-in zoom-in duration-200">
                <div class="w-full md:col-span-6 space-y-1">
                    <label class="block text-[10px] font-extrabold text-rose-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> Permasalahan di Lapangan (Kiri)
                    </label>
                    <div class="flex items-start gap-2.5 w-full">
                        <span class="num-badge w-7 h-7 rounded-xl bg-rose-100 text-rose-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0 mt-1 shadow-2xs">
                            1
                        </span>
                        <textarea name="masalah[]" rows="2" placeholder="Tuliskan permasalahan di lapangan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white transition shadow-2xs leading-relaxed">${mVal}</textarea>
                    </div>
                </div>
                <div class="w-full md:col-span-5 space-y-1">
                    <label class="block text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                        <i class="fa-solid fa-gavel"></i> Tindakan / Solusi (Kanan)
                    </label>
                    <textarea name="tindakan[]" rows="2" placeholder="Tuliskan tindakan / solusi yang dilakukan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed">${tVal}</textarea>
                </div>
                <div class="w-full md:col-span-1 flex justify-end md:justify-center pt-1 md:pt-0">
                    <button type="button" onclick="removeRowElement('${rowId}', '.masalah-row', 'masalahContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs" title="Hapus Baris">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        updateRowNumbers('masalahContainer');
    }

    // 3. Add Target & Tindakan Row (2-Column with Number Badge)
    function addTargetRow(tgVal = '', ttVal = '') {
        const container = document.getElementById('targetContainer');
        const rowId = 'target_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="target-row p-4 rounded-3xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex flex-col md:grid md:grid-cols-12 gap-4 items-start md:items-center transition-all animate-in fade-in zoom-in duration-200">
                <div class="w-full md:col-span-6 space-y-1">
                    <label class="block text-[10px] font-extrabold text-teal-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                        <i class="fa-solid fa-bullseye"></i> Target Bulan Depan (Kiri)
                    </label>
                    <div class="flex items-start gap-2.5 w-full">
                        <span class="num-badge w-7 h-7 rounded-xl bg-teal-100 text-teal-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0 mt-1 shadow-2xs">
                            1
                        </span>
                        <textarea name="target_item[]" rows="2" placeholder="Tuliskan target kebersihan bulan depan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white transition shadow-2xs leading-relaxed">${tgVal}</textarea>
                    </div>
                </div>
                <div class="w-full md:col-span-5 space-y-1">
                    <label class="block text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider md:hidden flex items-center gap-1">
                        <i class="fa-solid fa-list-check"></i> Rencana Tindakan (Kanan)
                    </label>
                    <textarea name="target_tindakan[]" rows="2" placeholder="Tuliskan rencana tindakan / langkah..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed">${ttVal}</textarea>
                </div>
                <div class="w-full md:col-span-1 flex justify-end md:justify-center pt-1 md:pt-0">
                    <button type="button" onclick="removeRowElement('${rowId}', '.target-row', 'targetContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs" title="Hapus Baris">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        updateRowNumbers('targetContainer');
    }

    // 4. Add Usulan Row (Single-Column)
    function addUsulanRow(val = '') {
        const container = document.getElementById('usulanContainer');
        const rowId = 'usulan_' + Date.now() + '_' + Math.random().toString(36).substr(2, 4);

        const html = `
            <div id="${rowId}" class="usulan-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all animate-in fade-in zoom-in duration-200">
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
        if (typeof window.initAutoResizeTextareas === 'function') window.initAutoResizeTextareas();
    }

    // Generic Remove Row Helper with auto re-indexing
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
</script>

<?= $this->endSection() ?>
