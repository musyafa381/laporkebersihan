<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* Tree Connectors */
    .tree-line-v {
        width: 2px;
        background-color: #10b981;
        margin: 0 auto;
    }
    .tree-line-h {
        height: 2px;
        background-color: #10b981;
    }
    .tree-dot {
        width: 6px;
        height: 6px;
        border-radius: 9999px;
        background-color: #059669;
        margin: 0 auto;
    }
    .node-btn {
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .node-btn:hover {
        transform: translateY(-3px) scale(1.02);
    }

    @media print {
        @page {
            size: portrait;
            margin: 6mm 6mm;
        }
        *, *::before, *::after {
            box-shadow: none !important;
            text-shadow: none !important;
        }
        html, body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            color: #0f172a !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        header, nav, footer, aside, .no-print, #navbar, .sidebar, .hero-page-banner, #modalNodeDetail {
            display: none !important;
        }
        .max-w-6xl {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 2px solid #065f46;
        }
        .print-chart-container {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow: visible !important;
            background: transparent !important;
        }
        .print-chart-container > div {
            min-width: 100% !important;
            width: 100% !important;
            padding: 0 !important;
            transform: none !important;
            gap: 6px !important;
        }
        /* Top Level Cards in Portrait Print */
        .print-chart-container .w-80 {
            width: 250px !important;
            max-width: 100% !important;
        }
        .print-chart-container .w-\[540px\] {
            width: 100% !important;
            max-width: 440px !important;
            justify-content: center !important;
            gap: 12px !important;
        }
        .print-chart-container .w-60 {
            width: 205px !important;
        }
        /* 5-Column Grid in Portrait Print */
        .print-chart-container .grid-cols-5 {
            display: grid !important;
            grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
            gap: 4.5px !important;
            width: 100% !important;
            max-width: 100% !important;
            padding-top: 2px !important;
            align-items: start !important;
        }
        .print-chart-container .grid-cols-5 > div {
            gap: 5px !important;
        }
        /* Card styles in Print */
        .print-unit-card {
            border-radius: 6px !important;
            padding: 4.5px 5px !important;
            border-width: 1px !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .print-unit-card .unit-title {
            font-size: 8px !important;
            line-height: 1.1 !important;
        }
        .print-unit-card .unit-badge {
            font-size: 7px !important;
            line-height: 1 !important;
            padding: 1px 3px !important;
        }
        .print-unit-card .member-item {
            font-size: 7px !important;
            line-height: 1.1 !important;
        }
        .print-unit-card .fa-solid, .print-unit-card .fa-regular {
            font-size: 6.5px !important;
        }
        .tree-line-v {
            background-color: #059669 !important;
        }
        .tree-line-h {
            background-color: #059669 !important;
        }
        .tree-dot {
            background-color: #047857 !important;
        }
    }
</style>

<div class="max-w-6xl mx-auto space-y-6 sm:space-y-8 py-2 sm:py-6">
    <!-- Print Only Formal Header / Kop Bagan -->
    <div class="print-header hidden">
        <div class="inline-block px-3 py-0.5 mb-1 rounded-full bg-emerald-50 border border-emerald-300 text-emerald-900 font-extrabold text-[9px] uppercase tracking-widest">
            TIM K3L (Kebersihan, Ketertiban & Keindahan Lingkungan)
        </div>
        <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">BAGAN STRUKTUR ORGANISASI KEBERSIHAN</h2>
        <p class="text-[10.5px] font-bold text-emerald-800">YAYASAN PONDOK PESANTREN ASSALAFIYYAH MLANGI YOGYAKARTA</p>
    </div>

    <!-- Hero Banner / Page Header (Frosted Glass Theme) -->
    <div class="hero-page-banner no-print relative overflow-hidden rounded-[32px] p-6 sm:p-10 shadow-[0_20px_50px_rgba(6,78,59,0.22)] border border-white/25 bg-gradient-to-br from-emerald-950/90 via-teal-900/85 to-slate-950/90 backdrop-blur-2xl text-white">
        <!-- Ambient Background Glowing Circles -->
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-extrabold uppercase tracking-wider border border-white/20">
                    <i class="fa-solid fa-sitemap text-emerald-400"></i> Bagan Organisasi Kebersihan
                </span>
                <h1 class="text-2xl sm:text-4xl font-heading font-black tracking-tight leading-tight text-white drop-shadow-md">
                    Bagan Struktur Organisasi Kebersihan
                </h1>
                <p class="text-slate-200 text-xs sm:text-base leading-relaxed font-medium">
                    Struktur kepengurusan dan penanggung jawab kebersihan seluruh unit instansi Yayasan Assalafiyyah Mlangi.
                </p>
            </div>

            <div class="flex-shrink-0 no-print">
                <button type="button" onclick="window.print()" class="w-full sm:w-auto px-5 sm:px-6 py-3 sm:py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs sm:text-sm hover:bg-emerald-50 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 shadow-lg flex items-center justify-center gap-2 group active:scale-95">
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-print text-xs"></i>
                    </div>
                    <span>Cetak Bagan (Portrait)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ORGANIZATIONAL TREE DIAGRAM CARD -->
    <div class="print-chart-container glass-card rounded-[32px] p-4 sm:p-8 shadow-[0_12px_40px_rgba(0,0,0,0.06)] border border-white/80 bg-white/80 backdrop-blur-2xl overflow-x-auto">
        <div class="min-w-[980px] flex flex-col items-center py-2 space-y-0 text-center">

            <!-- LEVEL 1: KETUA K3L -->
            <div class="w-80 relative z-10">
                <div class="rounded-2xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white p-3.5 shadow-lg shadow-emerald-900/25 border-2 border-emerald-500/70 relative group hover:scale-105 transition-all duration-300">
                    <div class="inline-block px-2.5 py-0.5 rounded-full bg-white/15 text-[10px] font-heading font-black uppercase tracking-widest text-emerald-200 border border-white/20">
                        <?= esc($pimpinan['ketua']['jabatan'] ?? 'KETUA PENGURUS K3L ASSALAFIYYAH') ?>
                    </div>
                    <div class="pt-1.5 text-sm sm:text-base font-heading font-black text-white tracking-wide">
                        <?= esc($pimpinan['ketua']['nama_penanggung_jawab'] ?? 'Bapak Afif Muzayyin') ?>
                    </div>
                    <?php if (!empty($pimpinan['ketua']['kontak_hp'])): ?>
                        <div class="text-[10.5px] text-emerald-300 font-semibold mt-0.5 flex items-center justify-center gap-1">
                            <i class="fa-brands fa-whatsapp text-[10px]"></i>
                            <span><?= esc($pimpinan['ketua']['kontak_hp']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CONNECTOR LEVEL 1 -> LEVEL 2 -->
            <div class="w-full flex flex-col items-center">
                <div class="tree-line-v h-5"></div>
                <div class="tree-dot"></div>
                <div class="tree-line-v h-5"></div>
            </div>

            <!-- LEVEL 2: KOORDINATOR KEBERSIHAN -->
            <div class="w-80 relative z-10">
                <div class="rounded-2xl bg-white text-slate-800 p-3.5 shadow-md border-t-4 border-t-emerald-600 border-x border-b border-slate-200 relative group hover:scale-105 transition-all duration-300">
                    <div class="inline-block px-2 py-0.5 rounded-md bg-emerald-50 text-[10px] font-heading font-black uppercase tracking-wider text-emerald-800 border border-emerald-200">
                        <?= esc($pimpinan['koordinator']['jabatan'] ?? 'KOORDINATOR KEBERSIHAN') ?>
                    </div>
                    <div class="pt-1.5 text-sm sm:text-base font-heading font-black text-slate-900">
                        <?= esc($pimpinan['koordinator']['nama_penanggung_jawab'] ?? 'Bapak Muhammad Ashar') ?>
                    </div>
                    <?php if (!empty($pimpinan['koordinator']['kontak_hp'])): ?>
                        <div class="text-[10.5px] text-slate-500 font-semibold mt-0.5 flex items-center justify-center gap-1">
                            <i class="fa-solid fa-phone text-[9px] text-emerald-600"></i>
                            <span><?= esc($pimpinan['koordinator']['kontak_hp']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CONNECTOR LEVEL 2 -> LEVEL 3 (T-SPLIT) -->
            <div class="w-full flex flex-col items-center">
                <div class="tree-line-v h-4"></div>
                <div class="w-[380px] tree-line-h"></div>
                <div class="w-[380px] flex justify-between">
                    <div class="tree-line-v h-4"></div>
                    <div class="tree-line-v h-4"></div>
                </div>
            </div>

            <!-- LEVEL 3: SEKRETARIS (KIRI) & DIVISI LOGISTIK (KANAN) -->
            <div class="w-[540px] flex justify-between gap-6 relative z-10">
                <!-- Card Sekretaris -->
                <div class="w-60">
                    <div class="rounded-2xl bg-white text-slate-800 p-3 shadow-sm border-t-3 border-t-teal-600 border-x border-b border-slate-200 hover:border-teal-500 hover:scale-105 transition-all duration-300">
                        <div class="text-[10px] font-heading font-black uppercase tracking-wider text-slate-700 pb-0.5">
                            <i class="fa-solid fa-pen-fancy text-[9px] text-teal-600 mr-1"></i>
                            <?= esc($pimpinan['sekretaris']['jabatan'] ?? 'SEKRETARIS KEBERSIHAN') ?>
                        </div>
                        <div class="pt-0.5 text-xs sm:text-sm font-heading font-extrabold text-emerald-900">
                            <?= esc($pimpinan['sekretaris']['nama_penanggung_jawab'] ?? 'Ahmad Musyafa') ?>
                        </div>
                    </div>
                </div>

                <!-- Card Logistik -->
                <div class="w-60">
                    <div class="rounded-2xl bg-white text-slate-800 p-3 shadow-sm border-t-3 border-t-emerald-600 border-x border-b border-slate-200 hover:border-emerald-500 hover:scale-105 transition-all duration-300">
                        <div class="text-[10px] font-heading font-black uppercase tracking-wider text-slate-700 pb-0.5">
                            <i class="fa-solid fa-boxes-stacked text-[9px] text-emerald-600 mr-1"></i>
                            <?= esc($pimpinan['logistik']['jabatan'] ?? 'DIVISI LOGISTIK & GUDANG') ?>
                        </div>
                        <div class="pt-0.5 text-xs sm:text-sm font-heading font-extrabold text-emerald-900">
                            <?= esc($pimpinan['logistik']['nama_penanggung_jawab'] ?? 'Ahmad Fakhri Maulana') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONNECTOR LEVEL 3 -> 5 COLUMNS DISTRIBUTION TREE -->
            <div class="w-full flex flex-col items-center">
                <!-- Central Trunk Down from Center -->
                <div class="tree-line-v h-4"></div>
                <!-- 5-Way Horizontal Distribution Bar -->
                <div class="w-[90%] max-w-5xl tree-line-h"></div>
                <!-- 5 Downward Drop Lines into each Column Header -->
                <div class="w-[90%] max-w-5xl grid grid-cols-5">
                    <div class="flex justify-center"><div class="tree-line-v h-4"></div></div>
                    <div class="flex justify-center"><div class="tree-line-v h-4"></div></div>
                    <div class="flex justify-center"><div class="tree-line-v h-4"></div></div>
                    <div class="flex justify-center"><div class="tree-line-v h-4"></div></div>
                    <div class="flex justify-center"><div class="tree-line-v h-4"></div></div>
                </div>
            </div>

            <!-- LEVEL 4 & 5: 5 COLUMNS HIERARCHY (ASRAMA, GEMERLAP, LEMBAGA LAIN, SEKOLAH, SATGAS) -->
            <div class="grid grid-cols-5 gap-3.5 w-full max-w-5xl items-start relative z-10">

                <!-- KOLOM 1: ASRAMA -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-full p-2.5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50/80 border border-emerald-300/80 shadow-2xs text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-wider flex items-center justify-center gap-1">
                            <i class="fa-solid fa-hotel text-[10px] text-emerald-700"></i>
                            <span>ASRAMA</span>
                        </div>
                        <span class="text-[9.5px] font-extrabold text-emerald-800 bg-white px-2 py-0.2 rounded-full mt-1 inline-block border border-emerald-200 shadow-2xs">
                            <?= count($asramaUnits) ?> Unit
                        </span>
                    </div>

                    <!-- Sub-units Vertical Chain -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($asramaUnits)): ?>
                            <?php foreach ($asramaUnits as $u): 
                                $pjList = $u['pj_list'] ?? [];
                                $primaryPj = !empty($pjList) ? $pjList[0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '');
                            ?>
                                <div class="print-unit-card p-2.5 rounded-xl bg-white border border-slate-200/90 border-l-4 border-l-emerald-600 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="unit-title font-heading font-black text-[11px] text-slate-900 leading-tight truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($u['nama_unit']) ?>
                                    </div>
                                    <div class="space-y-0.5 pt-0.5">
                                        <?php if (!empty($pjList)): ?>
                                            <?php foreach ($pjList as $pj): ?>
                                                <div class="member-item text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($pj['nama_pj']) ?>">
                                                    <i class="fa-solid fa-user-tie text-[9px] text-emerald-700"></i>
                                                    <span><?= esc($pj['nama_pj']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php elseif (!empty($primaryPjName)): ?>
                                            <div class="member-item text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate">
                                                <i class="fa-solid fa-user-tie text-[9px] text-emerald-700"></i>
                                                <span><?= esc($primaryPjName) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="member-item text-[9.5px] text-slate-400 italic">
                                                <i class="fa-regular fa-circle-question text-[8.5px] mr-0.5"></i> Belum ada PJ
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada unit asrama</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KOLOM 2: GEMERLAP (Kader Asrama) -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-full p-2.5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50/80 border border-emerald-300/80 shadow-2xs text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-wider flex items-center justify-center gap-1">
                            <i class="fa-solid fa-sparkles text-[10px] text-emerald-700"></i>
                            <span>GEMERLAP</span>
                        </div>
                        <span class="text-[9.5px] font-extrabold text-emerald-800 bg-white px-2 py-0.2 rounded-full mt-1 inline-block border border-emerald-200 shadow-2xs">
                            <?= count($gemerlapUnits) ?> Posko Kader
                        </span>
                    </div>

                    <!-- Sub-units Gemerlap -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($gemerlapUnits)): ?>
                            <?php foreach ($gemerlapUnits as $u): 
                                $cleanName = preg_replace('/^GEMERLAP\s*(Asrama\s*)?/i', '', $u['nama_unit']);
                                $kaderMembers = $u['kader_members'] ?? [];
                                $primaryPj = !empty($u['pj_list']) ? $u['pj_list'][0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '');
                            ?>
                                <div class="print-unit-card p-2.5 rounded-xl bg-white border border-slate-200/90 border-l-4 border-l-teal-600 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="unit-title font-heading font-black text-[11px] text-slate-900 leading-tight truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($cleanName ?: $u['nama_unit']) ?>
                                    </div>
                                    <div class="unit-badge text-[10px] text-teal-800 font-bold truncate flex items-center justify-between">
                                        <span>Kader GEMERLAP</span>
                                        <?php if (!empty($kaderMembers)): ?>
                                            <span class="text-[8.5px] px-1.5 py-0.2 rounded bg-teal-50 text-teal-800 border border-teal-200 font-black"><?= count($kaderMembers) ?> Anggota</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!empty($kaderMembers)): ?>
                                        <div class="pt-1 border-t border-slate-100 space-y-0.5">
                                            <?php foreach ($kaderMembers as $km): ?>
                                                <div class="member-item text-[9.5px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($km['nama_kader']) ?>">
                                                    <i class="fa-solid fa-circle-user text-[8.5px] text-teal-600"></i>
                                                    <span><?= esc($km['nama_kader']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php elseif (!empty($primaryPjName)): ?>
                                        <div class="member-item text-[9.5px] text-slate-600 font-medium">PJ: <?= esc($primaryPjName) ?></div>
                                    <?php else: ?>
                                        <div class="member-item text-[9px] text-slate-400 italic">Belum ada kader</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada kader aktif</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KOLOM 3: LEMBAGA LAIN (KSY, Gedung Umum, Kos, dll) -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-full p-2.5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50/80 border border-emerald-300/80 shadow-2xs text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-wider flex items-center justify-center gap-1">
                            <i class="fa-solid fa-building-columns text-[10px] text-emerald-700"></i>
                            <span>LEMBAGA LAIN</span>
                        </div>
                        <span class="text-[9.5px] font-extrabold text-emerald-800 bg-white px-2 py-0.2 rounded-full mt-1 inline-block border border-emerald-200 shadow-2xs">
                            <?= count($lembagaUnits) ?> Unit
                        </span>
                    </div>

                    <!-- Sub-units Lembaga Lain -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($lembagaUnits)): ?>
                            <?php foreach ($lembagaUnits as $u): 
                                $pjList = $u['pj_list'] ?? [];
                                $primaryPj = !empty($pjList) ? $pjList[0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '');
                            ?>
                                <div class="print-unit-card p-2.5 rounded-xl bg-white border border-slate-200/90 border-l-4 border-l-emerald-600 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="unit-title font-heading font-black text-[11px] text-slate-900 leading-tight truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($u['nama_unit']) ?>
                                    </div>
                                    <div class="space-y-0.5 pt-0.5">
                                        <?php if (!empty($pjList)): ?>
                                            <?php foreach ($pjList as $pj): ?>
                                                <div class="member-item text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($pj['nama_pj']) ?>">
                                                    <i class="fa-solid fa-user-check text-[9px] text-emerald-700"></i>
                                                    <span><?= esc($pj['nama_pj']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php elseif (!empty($primaryPjName)): ?>
                                            <div class="member-item text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate">
                                                <i class="fa-solid fa-user-check text-[9px] text-emerald-700"></i>
                                                <span><?= esc($primaryPjName) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="member-item text-[9.5px] text-slate-400 italic">
                                                <i class="fa-regular fa-circle-question text-[8.5px] mr-0.5"></i> Belum ada PJ
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="unit-badge text-[9px] text-emerald-700 font-bold"><?= esc($u['tipe'] ?: 'Pusat K3L') ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada unit lembaga lain</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KOLOM 4: SEKOLAH (MTS, MA, SMK, dll) -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-full p-2.5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50/80 border border-emerald-300/80 shadow-2xs text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-wider flex items-center justify-center gap-1">
                            <i class="fa-solid fa-graduation-cap text-[10px] text-emerald-700"></i>
                            <span>SEKOLAH</span>
                        </div>
                        <span class="text-[9.5px] font-extrabold text-emerald-800 bg-white px-2 py-0.2 rounded-full mt-1 inline-block border border-emerald-200 shadow-2xs">
                            <?= count($sekolahUnits) ?> Lembaga
                        </span>
                    </div>

                    <!-- Sub-units Sekolah -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($sekolahUnits)): ?>
                            <?php foreach ($sekolahUnits as $u): 
                                $pjList = $u['pj_list'] ?? [];
                                $primaryPj = !empty($pjList) ? $pjList[0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '');
                            ?>
                                <div class="print-unit-card p-2.5 rounded-xl bg-white border border-slate-200/90 border-l-4 border-l-emerald-600 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="unit-title font-heading font-black text-[11px] text-slate-900 leading-tight truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($u['nama_unit']) ?>
                                    </div>
                                    <div class="space-y-0.5 pt-0.5">
                                        <?php if (!empty($pjList)): ?>
                                            <?php foreach ($pjList as $pj): ?>
                                                <div class="member-item text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($pj['nama_pj']) ?>">
                                                    <i class="fa-solid fa-user-check text-[9px] text-emerald-700"></i>
                                                    <span><?= esc($pj['nama_pj']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php elseif (!empty($primaryPjName)): ?>
                                            <div class="member-item text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate">
                                                <i class="fa-solid fa-user-check text-[9px] text-emerald-700"></i>
                                                <span><?= esc($primaryPjName) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="member-item text-[9.5px] text-slate-400 italic">
                                                <i class="fa-regular fa-circle-question text-[8.5px] mr-0.5"></i> Belum ada PJ
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada unit sekolah</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KOLOM 5: SATGAS (Satgas Sekolah) -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-full p-2.5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50/80 border border-emerald-300/80 shadow-2xs text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-wider flex items-center justify-center gap-1">
                            <i class="fa-solid fa-shield-halved text-[10px] text-emerald-700"></i>
                            <span>SATGAS</span>
                        </div>
                        <span class="text-[9.5px] font-extrabold text-emerald-800 bg-white px-2 py-0.2 rounded-full mt-1 inline-block border border-emerald-200 shadow-2xs">
                            <?= count($satgasUnits) ?> Posko Satgas
                        </span>
                    </div>

                    <!-- Sub-units Satgas -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($satgasUnits)): ?>
                            <?php foreach ($satgasUnits as $u): 
                                $cleanSatgasName = preg_replace('/^Satgas\s*(Kebersihan\s*)?/i', '', $u['nama_unit']);
                                $kaderMembers = $u['kader_members'] ?? [];
                                $primaryPj = !empty($u['pj_list']) ? $u['pj_list'][0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '');
                            ?>
                                <div class="print-unit-card p-2.5 rounded-xl bg-white border border-slate-200/90 border-l-4 border-l-teal-600 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="unit-title font-heading font-black text-[11px] text-slate-900 leading-tight truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($cleanSatgasName ?: $u['nama_unit']) ?>
                                    </div>
                                    <div class="unit-badge text-[10px] text-teal-800 font-bold truncate flex items-center justify-between">
                                        <span>Satgas Kebersihan</span>
                                        <?php if (!empty($kaderMembers)): ?>
                                            <span class="text-[8.5px] px-1.5 py-0.2 rounded bg-teal-50 text-teal-800 border border-teal-200 font-black"><?= count($kaderMembers) ?> Anggota</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($kaderMembers)): ?>
                                        <div class="pt-1 border-t border-slate-100 space-y-0.5">
                                            <?php foreach ($kaderMembers as $km): ?>
                                                <div class="member-item text-[9.5px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($km['nama_kader']) ?>">
                                                    <i class="fa-solid fa-circle-user text-[8.5px] text-teal-600"></i>
                                                    <span><?= esc($km['nama_kader']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php elseif (!empty($primaryPjName)): ?>
                                        <div class="member-item text-[9.5px] text-slate-600 font-medium">PJ: <?= esc($primaryPjName) ?></div>
                                    <?php else: ?>
                                        <div class="member-item text-[9px] text-slate-400 italic">Belum ada anggota satgas</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada satgas aktif</div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Modal Pop Up Detail Personel Node -->
<div id="modalNodeDetail" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[999999] flex items-center justify-center p-4 hidden">
    <div class="glass-card rounded-3xl p-6 sm:p-7 max-w-xl w-full bg-white shadow-2xl space-y-5 border border-slate-200 relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-sitemap"></i>
                </div>
                <div>
                    <h3 id="nodeModalTitle" class="font-heading font-extrabold text-base text-slate-900">Detail Bagian</h3>
                    <p class="text-xs text-slate-500 font-medium">Daftar Pengurus & Penanggung Jawab Kebersihan</p>
                </div>
            </div>
            <button type="button" onclick="closeNodeDetailModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Node Personnel Items List Container -->
        <div id="nodePersonnelList" class="space-y-3.5 max-h-[60vh] overflow-y-auto pr-1">
            <!-- Rendered via JS -->
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-400">Total Personel: <b id="nodeCountBadge" class="text-emerald-700">0</b></span>
            <button type="button" onclick="closeNodeDetailModal()" class="px-5 py-2 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs hover:bg-slate-200 transition">Tutup Modal</button>
        </div>
    </div>
</div>

<script>
    var byNodeData = <?= json_encode($byNode ?? []) ?>;

    function showNodeDetails(nodeKey, titleLabel) {
        document.getElementById('nodeModalTitle').innerText = titleLabel;
        const container = document.getElementById('nodePersonnelList');
        const countBadge = document.getElementById('nodeCountBadge');
        container.innerHTML = '';

        const personnel = byNodeData[nodeKey] || [];
        countBadge.innerText = personnel.length;

        if (personnel.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200 space-y-2">
                    <i class="fa-solid fa-users text-3xl text-slate-300"></i>
                    <p class="text-xs font-semibold text-slate-500">Belum ada nama pengurus/personel yang terdaftar di bagian ${titleLabel}.</p>
                </div>
            `;
        } else {
            personnel.forEach(p => {
                let cleanHp = (p.kontak_hp || '').replace(/[^0-9]/g, '');
                if (cleanHp.startsWith('0')) cleanHp = '62' + cleanHp.substring(1);

                const div = document.createElement('div');
                div.className = "p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2.5 shadow-2xs hover:bg-white transition";
                div.innerHTML = `
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-extrabold text-sm shadow-2xs">
                                <i class="fa-solid fa-user-circle text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-heading font-extrabold text-sm text-slate-900">${p.nama_penanggung_jawab}</h4>
                                <p class="text-xs text-emerald-700 font-bold">${p.jabatan}</p>
                            </div>
                        </div>
                        ${cleanHp ? `
                            <a href="https://wa.me/${cleanHp}" target="_blank" class="px-3 py-1 rounded-xl bg-emerald-600 text-white font-extrabold text-[11px] hover:bg-emerald-700 transition flex items-center gap-1.5 shadow-2xs">
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>Hubungi WA</span>
                            </a>
                        ` : ''}
                    </div>
                    ${p.tugas_wewenang ? `
                        <div class="p-3 rounded-xl bg-white border border-slate-200/80 text-xs text-slate-700 leading-relaxed font-medium">
                            <span class="font-bold text-slate-500 text-[10px] uppercase block mb-0.5">Tugas & Tanggung Jawab:</span>
                            "${p.tugas_wewenang}"
                        </div>
                    ` : ''}
                `;
                container.appendChild(div);
            });
        }

        document.getElementById('modalNodeDetail').classList.remove('hidden');
    }
    window.showNodeDetails = showNodeDetails;

    function closeNodeDetailModal() {
        document.getElementById('modalNodeDetail').classList.add('hidden');
    }
    window.closeNodeDetailModal = closeNodeDetailModal;
</script>
<?= $this->endSection() ?>
