<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-8">

    <!-- Hero Header Banner (Gradient Emerald Standard) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-leaf text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-3xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-book-open"></i> Yayasan Assalafiyyah Mlangi
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Program Kerja Asrama & Unit
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Daftar program kebersihan yang berjalan di seluruh asrama, Gemerlap, Satgas Kebersihan, dan unit lembaga. Seluruh unit dapat memantau program secara transparan.
                </p>
                <?php if ($isLoggedIn && !$isAdminOrAuditor && $currentUserUnit): ?>
                    <div class="pt-1 flex items-center gap-2 text-xs font-extrabold text-teal-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Anda login sebagai pengelola unit: <strong class="text-white underline"><?= esc($currentUserUnit['nama_unit']) ?></strong></span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($isLoggedIn): ?>
                <div class="flex-shrink-0">
                    <a href="<?= base_url('program-kerja/create') ?>" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </div>
                        <span>Tambah Program Baru</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Stats Cards (4 Cards) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-4 sm:p-5 border border-slate-200/80 bg-white shadow-md flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Program</p>
                <p class="text-xl font-extrabold font-heading text-slate-900"><?= $stats['total'] ?></p>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-4 sm:p-5 border border-slate-200/80 bg-white shadow-md flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Rutin Berjalan</p>
                <p class="text-xl font-extrabold font-heading text-emerald-700"><?= $stats['rutin'] ?></p>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-4 sm:p-5 border border-slate-200/80 bg-white shadow-md flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                <i class="fa-solid fa-spinner"></i>
            </div>
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Sedang Berjalan</p>
                <p class="text-xl font-extrabold font-heading text-amber-700"><?= $stats['berjalan'] ?></p>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-4 sm:p-5 border border-slate-200/80 bg-white shadow-md flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Terencana</p>
                <p class="text-xl font-extrabold font-heading text-teal-700"><?= $stats['terencana'] ?></p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar with Explicit Cari Button -->
    <div class="glass-card rounded-3xl p-5 sm:p-6 shadow-xl border border-slate-200/80 bg-white space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            
            <!-- Filter Unit -->
            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-house text-emerald-600 text-xs"></i>
                    <span>Filter Asrama / Unit</span>
                </label>
                <select id="filter_unit" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="all">Semua Asrama & Unit</option>
                    <?php foreach ($allUnits as $u): ?>
                        <option value="<?= $u['id'] ?>">
                            <?= esc($u['nama_unit']) ?> (<?= esc($u['tipe']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-traffic-light text-amber-500 text-xs"></i>
                    <span>Status Program</span>
                </label>
                <select id="filter_status" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="all">Semua Status</option>
                    <option value="Terlaksana Rutin">Terlaksana Rutin</option>
                    <option value="Sedang Berjalan">Sedang Berjalan</option>
                    <option value="Terencana">Terencana</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <!-- Filter Kategori Kader / Umum -->
            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-layer-group text-teal-600 text-xs"></i>
                    <span>Kelompok Program</span>
                </label>
                <select id="filter_kader" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="all">Semua Kelompok</option>
                    <option value="GEMERLAP">Buku Terpadu GEMERLAP</option>
                    <option value="Satgas">Buku Terpadu SATGAS</option>
                    <option value="Non-Kader">Proker Unit Standar</option>
                </select>
            </div>

            <!-- Search Input -->
            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-500 text-xs"></i>
                    <span>Cari Kata Kunci</span>
                </label>
                <div class="relative">
                    <input type="text" id="filter_search" onkeydown="if(event.key === 'Enter') filterProkerTable()" placeholder="Cari nama proker, PJ, tujuan..." class="w-full pl-4 pr-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white text-xs font-bold focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

        </div>

        <!-- Action Button Row for Search and Reset -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500 font-semibold" id="filterInfoText">
                Menampilkan seluruh program kerja.
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="resetProkerFilter()" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-heading font-extrabold text-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Reset</span>
                </button>
                <button type="button" onclick="filterProkerTable()" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Cari Program</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Table Card of Work Programs -->
    <div class="glass-card rounded-3xl shadow-xl border border-slate-200/80 bg-white overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-table-list text-emerald-600"></i> Tabel Buku Program Kerja Terpadu
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Seluruh unit dapat melihat daftar lengkap proker lintas asrama secara transparan.</p>
            </div>
            <span class="px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-700 font-mono text-xs font-bold border border-slate-200">
                Total: <?= count($prokerList) ?> Program
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-4 text-center w-12">No</th>
                        <th class="py-4 px-4 min-w-[220px]">Program Kerja</th>
                        <th class="py-4 px-4 min-w-[170px]">Asrama / Unit Pelaksana</th>
                        <th class="py-4 px-4 min-w-[130px]">Dimulai & Periode</th>
                        <th class="py-4 px-4 min-w-[140px]">Penanggung Jawab</th>
                        <th class="py-4 px-4 text-center min-w-[130px]">Status</th>
                        <th class="py-4 px-4 text-center min-w-[140px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    <?php if (!empty($prokerList)): ?>
                        <?php foreach ($prokerList as $idx => $p): 
                            // Hak Edit: Admin / Auditor atau Pengurus milik unit bersangkutan
                            $canEditThis = $isAdminOrAuditor || ($isLoggedIn && $userUnitId && (int)$p['unit_id'] === (int)$userUnitId);
                            
                            $statusBadge = match($p['status']) {
                                'Terlaksana Rutin' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                'Sedang Berjalan'  => 'bg-amber-50 text-amber-800 border-amber-200',
                                'Terencana'        => 'bg-teal-50 text-teal-800 border-teal-200',
                                'Selesai'          => 'bg-slate-100 text-slate-700 border-slate-200',
                                default            => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                            $searchText = strtolower(($p['nama_program'] ?? '') . ' ' . ($p['sub_kegiatan'] ?? '') . ' ' . ($p['nama_unit'] ?? '') . ' ' . ($p['penanggung_jawab'] ?? '') . ' ' . ($p['tujuan_program'] ?? ''));
                        ?>
                            <tr class="proker-row hover:bg-slate-50/60 transition group" data-unit="<?= esc($p['unit_id'] ?? '') ?>" data-status="<?= esc($p['status'] ?? '') ?>" data-kader="<?= esc($p['kader_type'] ?? '') ?>" data-search="<?= esc($searchText) ?>">
                                <td class="py-4 px-4 text-center font-bold text-slate-400 row-number">
                                    <?= $idx + 1 ?>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-0.5">
                                        <div class="font-extrabold text-slate-900 group-hover:text-emerald-700 transition">
                                            <?= esc($p['nama_program']) ?>
                                        </div>
                                        <?php if (!empty($p['sub_kegiatan'])): ?>
                                            <div class="text-[11px] font-bold text-slate-500">
                                                <?= esc($p['sub_kegiatan']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="pt-0.5 flex items-center gap-2">
                                            <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-1">
                                                <i class="fa-solid fa-file-import text-[9px]"></i> Input: <?= esc($p['sumber_input']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1">
                                        <div class="font-extrabold text-slate-800 flex items-center gap-1.5">
                                            <i class="fa-solid fa-house-laptop text-emerald-600 text-[11px]"></i>
                                            <span><?= esc($p['nama_unit'] ?? 'Buku Terpadu') ?></span>
                                        </div>
                                        <?php if ($p['kader_type'] === 'GEMERLAP'): ?>
                                            <span class="inline-block px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 text-[9.5px] font-extrabold border border-amber-200">
                                                ✨ Buku Kader GEMERLAP
                                            </span>
                                        <?php elseif ($p['kader_type'] === 'Satgas'): ?>
                                            <span class="inline-block px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 text-[9.5px] font-extrabold border border-teal-200">
                                                🛡️ Buku Satgas Terpadu
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-block px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[9.5px] font-bold">
                                                <?= esc($p['unit_tipe'] ?? 'Asrama') ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1">
                                        <div class="font-mono text-[11px] font-bold text-slate-700 flex items-center gap-1">
                                            <i class="fa-regular fa-calendar text-slate-400 text-[10px]"></i>
                                            <span><?= $p['tgl_mulai'] ? date('d M Y', strtotime($p['tgl_mulai'])) : '-' ?></span>
                                        </div>
                                        <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-bold">
                                            Frekuensi: <?= esc($p['periode_frekuensi'] ?? 'Mingguan') ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-800 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-user-check text-emerald-600 text-[11px]"></i>
                                        <span><?= esc($p['penanggung_jawab'] ?: 'PJ Unit') ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold border <?= $statusBadge ?> inline-flex items-center gap-1 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <?= esc($p['status']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Tombol Detail Halaman Baru -->
                                        <a href="<?= base_url('program-kerja/detail/' . $p['id']) ?>" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 transition flex items-center justify-center text-xs shadow-2xs" title="Lihat Detail Program">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Tombol Edit & Delete Halaman Baru -->
                                        <?php if ($canEditThis): ?>
                                            <a href="<?= base_url('program-kerja/edit/' . $p['id']) ?>" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/70 transition flex items-center justify-center text-xs shadow-2xs" title="Edit Program Unit Anda">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="<?= base_url('program-kerja/delete/' . $p['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus program kerja ini?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition flex items-center justify-center text-xs shadow-2xs" title="Hapus Program">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="w-8 h-8 flex items-center justify-center text-slate-300 text-xs" title="Hanya pemilik unit / Admin yang dapat mengedit">
                                                <i class="fa-solid fa-lock"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls & Info Bar -->
        <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
            <div class="text-xs text-slate-500 font-semibold" id="paginationInfo">
                Menampilkan data 1 - 10 dari total 10 data
            </div>
            
            <div class="flex items-center gap-1.5" id="paginationControls">
                <!-- Pagination buttons generated by JavaScript -->
            </div>
        </div>
    </div>

</div>

<!-- ================================================= -->
<!-- 👁️ MODAL DETAIL PROGRAM KERJA (LEMBAR DETAIL) -->
<!-- ================================================= -->
<div id="modalDetailProker" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="glass-card bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative my-8 space-y-5">
        <div class="flex items-start justify-between border-b border-slate-100 pb-4">
            <div class="space-y-1">
                <span id="detail_badge_kategori" class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold uppercase border border-emerald-200">
                    Proker Unit
                </span>
                <h3 id="detail_nama_program" class="font-heading font-extrabold text-xl text-slate-900 pt-1">
                    Nama Program Kerja
                </h3>
                <p id="detail_sub_kegiatan" class="text-xs text-slate-500 font-bold"></p>
            </div>
            <button type="button" onclick="closeModalDetailProker()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200">
            <div>
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Unit Pelaksana</div>
                <div id="detail_unit" class="text-xs font-extrabold text-slate-800 mt-0.5">-</div>
            </div>
            <div>
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Mulai Pelaksanaan</div>
                <div id="detail_tgl" class="text-xs font-mono font-bold text-slate-800 mt-0.5">-</div>
            </div>
            <div>
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Frekuensi</div>
                <div id="detail_frekuensi" class="text-xs font-bold text-slate-800 mt-0.5">-</div>
            </div>
            <div>
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Status</div>
                <div id="detail_status" class="text-xs font-extrabold text-emerald-700 mt-0.5">-</div>
            </div>
        </div>

        <!-- Tujuan & Latar Belakang -->
        <div class="space-y-1.5">
            <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-bullseye text-emerald-600"></i> Tujuan & Sasaran Program
            </h4>
            <div id="detail_tujuan" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line">
                -
            </div>
        </div>

        <!-- Mekanisme / Cara Kerja -->
        <div class="space-y-1.5">
            <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-gears text-teal-600"></i> Mekanisme & Alur Operasional Kerja
            </h4>
            <div id="detail_mekanisme" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line">
                -
            </div>
        </div>

        <!-- Target & Indikator Capaian -->
        <div class="space-y-1.5">
            <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-flag-checkered text-amber-600"></i> Target & Indikator Keberhasilan
            </h4>
            <div id="detail_target" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line">
                -
            </div>
        </div>

        <!-- PJ Info Footer -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500 font-semibold flex items-center gap-2">
                <i class="fa-solid fa-user-tie text-emerald-600"></i>
                <span>Penanggung Jawab: <strong id="detail_pj" class="text-slate-800">-</strong></span>
            </div>
            <button type="button" onclick="closeModalDetailProker()" class="px-5 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<?php if ($isLoggedIn): ?>
<!-- ================================================= -->
<!-- 📝 MODAL TAMBAH / EDIT PROGRAM KERJA -->
<!-- ================================================= -->
<div id="modalProker" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="glass-card bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative my-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
                <div>
                    <h3 id="modalProkerTitle" class="font-heading font-extrabold text-lg text-slate-900">Tambah Program Kerja</h3>
                    <p class="text-xs text-slate-500 font-semibold">Daftarkan rencana & realisasi agenda kegiatan kebersihan.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalProker()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formProker" action="<?= base_url('program-kerja/store') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Asrama / Unit Pelaksana</label>
                    <select id="proker_unit_id" name="unit_id" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php foreach ($allUnits as $u): ?>
                            <?php 
                                // Jika user bukan admin, hanya bisa memilih unitnya sendiri
                                $isDisabled = (!$isAdminOrAuditor && $userUnitId && (int)$u['id'] !== (int)$userUnitId);
                            ?>
                            <option value="<?= $u['id'] ?>" <?= $isDisabled ? 'disabled class="text-slate-300"' : '' ?> <?= ($userUnitId == $u['id']) ? 'selected' : '' ?>>
                                <?= esc($u['nama_unit']) ?> (<?= esc($u['tipe']) ?>) <?= $isDisabled ? '- [Terkunci]' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Penanggung Jawab (PJ / Kader)</label>
                    <input type="text" id="proker_pj" name="penanggung_jawab" placeholder="Nama PJ yang bertugas..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Program Kerja</label>
                    <input type="text" id="proker_nama" name="nama_program" required placeholder="Misal: Sidak Kebersihan Kamar Mingguan" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Sub Kegiatan / Kategori Ringkas</label>
                    <input type="text" id="proker_sub" name="sub_kegiatan" placeholder="Misal: Standar Harian Asrama Santri" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Dimulai</label>
                    <input type="date" id="proker_tgl_mulai" name="tgl_mulai" value="<?= date('Y-m-d') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Periode / Frekuensi</label>
                    <select id="proker_periode" name="periode_frekuensi" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Harian">Harian (Setiap Hari)</option>
                        <option value="Mingguan" selected>Mingguan</option>
                        <option value="Bulanan">Bulanan</option>
                        <option value="Insidental">Insidental / Kondisional</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Pelaksanaan</label>
                    <select id="proker_status" name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Terlaksana Rutin">🟢 Terlaksana Rutin</option>
                        <option value="Sedang Berjalan" selected>🟡 Sedang Berjalan</option>
                        <option value="Terencana">🔵 Terencana</option>
                        <option value="Selesai">⚪ Selesai</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tujuan & Latar Belakang Program</label>
                <textarea id="proker_tujuan" name="tujuan_program" rows="2" placeholder="Apa tujuan utama dilaksanakannya program kebersihan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Mekanisme Kerja / Langkah Operasional</label>
                <textarea id="proker_mekanisme" name="mekanisme_kerja" rows="2.5" placeholder="Bagaimana cara kerja, alur teknis, atau langkah-langkah pelaksanaan program ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Target & Indikator Keberhasilan</label>
                <input type="text" id="proker_target" name="target_indikator" placeholder="Misal: 100% kamar bebas sampah plastik dan wangi..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalProker()" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-600 font-heading font-extrabold text-xs hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">
                    Simpan Program Kerja
                </button>
            </div>
        </form>
    </div>
</div>

<?php if ($isAdminOrAuditor): ?>
<!-- ================================================= -->
<!-- 🔄 MODAL TARIK / SINKRONISASI DARI LPJ BULANAN -->
<!-- ================================================= -->
<div id="modalSyncLpj" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="glass-card bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 relative space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Tarik Proker dari LPJ
            </h3>
            <button type="button" onclick="closeModalSyncLpj()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <p class="text-xs text-slate-500 font-medium">Pilih buku LPJ bulanan yang ingin diekstrak daftar agendanya menjadi program kerja:</p>
        
        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
            <?php foreach ($bukuLpjList as $b): ?>
                <a href="<?= base_url('program-kerja/sync-lpj/' . $b['id']) ?>" data-confirm-msg="Impor seluruh kegiatan proker dari buku LPJ <?= esc($b['bulan'] . ' ' . $b['tahun']) ?>?" class="p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 flex items-center justify-between transition group">
                    <div class="space-y-0.5">
                        <div class="font-extrabold text-slate-800 group-hover:text-emerald-700 text-xs">
                            <?= esc($b['judul'] ?: ('Buku LPJ ' . $b['bulan'] . ' ' . $b['tahun'])) ?>
                        </div>
                        <div class="text-[10px] text-slate-400 font-mono"><?= esc($b['bulan'] . ' ' . $b['tahun']) ?></div>
                    </div>
                    <span class="px-2.5 py-1 rounded-xl bg-white group-hover:bg-emerald-600 group-hover:text-white text-slate-600 text-[10px] font-extrabold border border-slate-200 transition">
                        Tarik Data
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    function filterProkerTable() {
        const unitVal   = document.getElementById('filter_unit')?.value || 'all';
        const statusVal = document.getElementById('filter_status')?.value || 'all';
        const kaderVal  = document.getElementById('filter_kader')?.value || 'all';
    let currentPage = 1;
    const pageSize = 8;
    let matchingRows = [];

    function filterProkerTable() {
        const unitVal   = document.getElementById('filter_unit')?.value || 'all';
        const statusVal = document.getElementById('filter_status')?.value || 'all';
        const kaderVal  = document.getElementById('filter_kader')?.value || 'all';
        const searchVal = (document.getElementById('filter_search')?.value || '').toLowerCase().trim();

        const rows = document.querySelectorAll('.proker-row');
        matchingRows = [];

        rows.forEach(row => {
            const rUnit   = row.getAttribute('data-unit') || '';
            const rStatus = row.getAttribute('data-status') || '';
            const rKader  = row.getAttribute('data-kader') || '';
            const rSearch = row.getAttribute('data-search') || '';

            const matchUnit   = (unitVal === 'all' || rUnit === unitVal);
            const matchStatus = (statusVal === 'all' || rStatus === statusVal);
            const matchKader  = (kaderVal === 'all' || rKader === kaderVal);
            const matchSearch = (!searchVal || rSearch.includes(searchVal));

            if (matchUnit && matchStatus && matchKader && matchSearch) {
                matchingRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        const totalMatching = matchingRows.length;

        // Update info text
        const infoText = document.getElementById('filterInfoText');
        if (infoText) {
            if (unitVal === 'all' && statusVal === 'all' && kaderVal === 'all' && !searchVal) {
                infoText.textContent = 'Menampilkan seluruh program kerja (' + totalMatching + ' program).';
            } else {
                infoText.innerHTML = 'Ditemukan <strong class="text-emerald-700 font-extrabold">' + totalMatching + ' program</strong> sesuai kriteria pencarian.';
            }
        }

        // Reset to page 1 on new filter
        currentPage = 1;
        renderProkerPagination();

        // Update empty state if no rows visible
        let emptyMsgRow = document.getElementById('noResultsRow');
        const tbody = document.querySelector('tbody');
        if (totalMatching === 0 && tbody) {
            if (!emptyMsgRow) {
                emptyMsgRow = document.createElement('tr');
                emptyMsgRow.id = 'noResultsRow';
                emptyMsgRow.innerHTML = '<td colspan="7" class="py-12 text-center text-slate-400 italic font-medium">Tidak ada program kerja yang cocok dengan filter yang dicari.</td>';
                tbody.appendChild(emptyMsgRow);
            } else {
                emptyMsgRow.style.display = '';
            }
        } else if (emptyMsgRow) {
            emptyMsgRow.style.display = 'none';
        }
    }
    window.filterProkerTable = filterProkerTable;

    function renderProkerPagination() {
        const totalItems = matchingRows.length;
        const totalPages = Math.ceil(totalItems / pageSize) || 1;

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex   = Math.min(startIndex + pageSize, totalItems);

        // Hide all, show only current page items
        const allRows = document.querySelectorAll('.proker-row');
        allRows.forEach(r => r.style.display = 'none');

        for (let i = startIndex; i < endIndex; i++) {
            const row = matchingRows[i];
            if (row) {
                row.style.display = '';
                const numberCell = row.querySelector('.row-number');
                if (numberCell) numberCell.textContent = i + 1;
            }
        }

        // Update pagination text
        const pageInfo = document.getElementById('paginationInfo');
        if (pageInfo) {
            if (totalItems === 0) {
                pageInfo.textContent = 'Menampilkan 0 data';
            } else {
                pageInfo.innerHTML = `Menampilkan data <strong class="text-slate-800">${startIndex + 1} - ${endIndex}</strong> dari total <strong class="text-slate-800">${totalItems}</strong> data`;
            }
        }

        // Render pagination buttons
        const controls = document.getElementById('paginationControls');
        if (!controls) return;
        controls.innerHTML = '';

        if (totalPages <= 1) return;

        // Prev Button
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = `w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold transition ${currentPage === 1 ? 'text-slate-300 cursor-not-allowed bg-slate-100' : 'text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 shadow-2xs'}`;
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i>';
        prevBtn.disabled = (currentPage === 1);
        prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderProkerPagination(); } };
        controls.appendChild(prevBtn);

        // Page Numbers
        for (let p = 1; p <= totalPages; p++) {
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.className = `w-8 h-8 rounded-xl flex items-center justify-center text-xs font-heading font-extrabold transition ${p === currentPage ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/25 border border-emerald-600' : 'text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 shadow-2xs'}`;
            pageBtn.textContent = p;
            pageBtn.onclick = () => { currentPage = p; renderProkerPagination(); };
            controls.appendChild(pageBtn);
        }

        // Next Button
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = `w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold transition ${currentPage === totalPages ? 'text-slate-300 cursor-not-allowed bg-slate-100' : 'text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 shadow-2xs'}`;
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right text-[10px]"></i>';
        nextBtn.disabled = (currentPage === totalPages);
        nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderProkerPagination(); } };
        controls.appendChild(nextBtn);
    }
    window.renderProkerPagination = renderProkerPagination;

    function resetProkerFilter() {
        if (document.getElementById('filter_unit')) document.getElementById('filter_unit').value = 'all';
        if (document.getElementById('filter_status')) document.getElementById('filter_status').value = 'all';
        if (document.getElementById('filter_kader')) document.getElementById('filter_kader').value = 'all';
        if (document.getElementById('filter_search')) document.getElementById('filter_search').value = '';
        filterProkerTable();
    }
    window.resetProkerFilter = resetProkerFilter;

    // Initial table setup on page load
    filterProkerTable();
</script>

<script>
    function openModalDetailProker(data) {
        document.getElementById('detail_nama_program').textContent = data.nama_program || '-';
        document.getElementById('detail_sub_kegiatan').textContent = data.sub_kegiatan || '';
        document.getElementById('detail_unit').textContent = data.nama_unit || (data.kader_type === 'GEMERLAP' ? 'Posko GEMERLAP' : 'Satgas');
        document.getElementById('detail_tgl').textContent = data.tgl_mulai || '-';
        document.getElementById('detail_frekuensi').textContent = data.periode_frekuensi || 'Mingguan';
        document.getElementById('detail_status').textContent = data.status || 'Sedang Berjalan';
        document.getElementById('detail_tujuan').textContent = data.tujuan_program || 'Belum ada catatan tujuan.';
        document.getElementById('detail_mekanisme').textContent = data.mekanisme_kerja || 'Belum ada rincian alur kerja operasional.';
        document.getElementById('detail_target').textContent = data.target_indikator || 'Belum ada rincian target indikator.';
        document.getElementById('detail_pj').textContent = data.penanggung_jawab || '-';

        const badge = document.getElementById('detail_badge_kategori');
        if (data.kader_type === 'GEMERLAP') {
            badge.className = 'px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 text-[10px] font-extrabold uppercase border border-amber-200';
            badge.textContent = '✨ Proker Terpadu GEMERLAP';
        } else if (data.kader_type === 'Satgas') {
            badge.className = 'px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-800 text-[10px] font-extrabold uppercase border border-teal-200';
            badge.textContent = '🛡️ Proker Terpadu Satgas';
        } else {
            badge.className = 'px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold uppercase border border-emerald-200';
            badge.textContent = '🏢 Proker Unit ' + (data.unit_tipe || 'Asrama');
        }

        document.getElementById('modalDetailProker').classList.remove('hidden');
    }

    function closeModalDetailProker() {
        document.getElementById('modalDetailProker').classList.add('hidden');
    }

    function openModalAddProker() {
        document.getElementById('modalProkerTitle').textContent = 'Tambah Program Kerja Baru';
        const form = document.getElementById('formProker');
        form.action = '<?= base_url('program-kerja/store') ?>';
        form.reset();

        document.getElementById('modalProker').classList.remove('hidden');
    }

    function openModalEditProker(data) {
        document.getElementById('modalProkerTitle').textContent = 'Edit Program Kerja (' + (data.nama_unit || '') + ')';
        const form = document.getElementById('formProker');
        form.action = '<?= base_url('program-kerja/update/') ?>' + data.id;

        document.getElementById('proker_unit_id').value = data.unit_id || '';
        document.getElementById('proker_nama').value = data.nama_program || '';
        document.getElementById('proker_sub').value = data.sub_kegiatan || '';
        document.getElementById('proker_pj').value = data.penanggung_jawab || '';
        document.getElementById('proker_tgl_mulai').value = data.tgl_mulai || '<?= date('Y-m-d') ?>';
        document.getElementById('proker_periode').value = data.periode_frekuensi || 'Mingguan';
        document.getElementById('proker_status').value = data.status || 'Sedang Berjalan';
        document.getElementById('proker_tujuan').value = data.tujuan_program || '';
        document.getElementById('proker_mekanisme').value = data.mekanisme_kerja || '';
        document.getElementById('proker_target').value = data.target_indikator || '';

        document.getElementById('modalProker').classList.remove('hidden');
    }

    function closeModalProker() {
        document.getElementById('modalProker').classList.add('hidden');
    }

    function openModalSyncLpj() {
        document.getElementById('modalSyncLpj').classList.remove('hidden');
    }

    function closeModalSyncLpj() {
        document.getElementById('modalSyncLpj').classList.add('hidden');
    }

    // Modal dismiss on overlay
    document.getElementById('modalProker')?.addEventListener('click', function(e) {
        if (e.target === this) closeModalProker();
    });
    document.getElementById('modalDetailProker')?.addEventListener('click', function(e) {
        if (e.target === this) closeModalDetailProker();
    });
    document.getElementById('modalSyncLpj')?.addEventListener('click', function(e) {
        if (e.target === this) closeModalSyncLpj();
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>
