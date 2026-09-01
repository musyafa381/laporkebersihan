<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* Organization Tree Diagram Connectors */
    .tree-connector-v {
        width: 2px;
        height: 24px;
        background-color: #cbd5e1;
        margin: 0 auto;
    }
    .node-btn {
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .node-btn:hover {
        transform: translateY(-4px) scale(1.03);
    }

    @media print {
        @page {
            size: A3 landscape;
            margin: 8mm 10mm;
        }
        *, *::before, *::after {
            box-shadow: none !important;
            text-shadow: none !important;
        }
        html, body {
            width: 100% !important;
            height: 100% !important;
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
            space-y: 0 !important;
        }
        .print-chart-container {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow: visible !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .print-chart-container > div {
            min-width: 100% !important;
            transform: scale(0.98);
            transform-origin: top center;
        }
    }
</style>

<div class="max-w-6xl mx-auto space-y-6 sm:space-y-8 py-2 sm:py-6">
    <!-- Hero Banner / Page Header (Disembunyikan saat cetak) -->
    <div class="hero-page-banner no-print relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-6 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-sitemap text-[160px] sm:text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-sitemap"></i> Bagan Organisasi Kebersihan
                </span>
                <h1 class="text-2xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Bagan Struktur Organisasi Kebersihan
                </h1>
                <p class="text-emerald-100/90 text-xs sm:text-base leading-relaxed">
                    Struktur kepengurusan dan penanggung jawab kebersihan seluruh unit instansi Yayasan Assalafiyyah Mlangi.
                </p>
            </div>

            <div class="flex-shrink-0 no-print">
                <button type="button" onclick="window.print()" class="w-full sm:w-auto px-5 sm:px-6 py-3 sm:py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs sm:text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-print text-xs"></i>
                    </div>
                    <span>Cetak Bagan (A3)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- INTERACTIVE ORGANIZATIONAL TREE DIAGRAM (CLEAN EMERALD THEME) -->
    <div class="print-chart-container glass-card rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 bg-white overflow-x-auto">
        <div class="min-w-[980px] flex flex-col items-center py-4 space-y-8 text-center">

            <!-- LEVEL 1: KETUA K3L (THEME EMERALD GRADIENT) -->
            <div class="w-80">
                <div class="rounded-2xl bg-gradient-to-r from-emerald-800 via-teal-800 to-emerald-900 text-white p-4 shadow-xl shadow-emerald-900/20 border border-emerald-700/60 relative group hover:scale-105 transition-all duration-300">
                    <div class="text-xs font-heading font-black uppercase tracking-widest text-emerald-200 pb-1.5 border-b border-emerald-700/60">
                        <?= esc($pimpinan['ketua']['jabatan'] ?? 'KETUA K3L') ?>
                    </div>
                    <div class="pt-2 text-sm font-heading font-extrabold text-white tracking-wide">
                        <?= esc($pimpinan['ketua']['nama_penanggung_jawab'] ?? 'Bapak Afif Muzayyin') ?>
                    </div>
                    <?php if (!empty($pimpinan['ketua']['kontak_hp'])): ?>
                        <div class="text-[11px] text-emerald-300/80 font-medium mt-0.5"><?= esc($pimpinan['ketua']['kontak_hp']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- LEVEL 2: KOORDINATOR UTAMA (CLEAN WHITE CARD WITH EMERALD ACCENT) -->
            <div class="w-80">
                <div class="rounded-2xl bg-white text-slate-800 p-4 shadow-lg shadow-slate-200/50 border-2 border-emerald-500/80 relative group hover:scale-105 transition-all duration-300">
                    <div class="text-xs font-heading font-black uppercase tracking-widest text-emerald-800 pb-1.5 border-b border-slate-100">
                        <?= esc($pimpinan['koordinator']['jabatan'] ?? 'KOORDINATOR UTAMA') ?>
                    </div>
                    <div class="pt-2 text-sm font-heading font-extrabold text-slate-900">
                        <?= esc($pimpinan['koordinator']['nama_penanggung_jawab'] ?? 'Bapak Muhammad Ashar') ?>
                    </div>
                    <?php if (!empty($pimpinan['koordinator']['kontak_hp'])): ?>
                        <div class="text-[11px] text-slate-400 font-medium mt-0.5"><?= esc($pimpinan['koordinator']['kontak_hp']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- LEVEL 3: SEKRETARIS (KIRI) & LOGISTIK (KANAN) -->
            <div class="w-[600px] flex justify-between gap-8 pt-0">
                <!-- Card Sekretaris -->
                <div class="w-64">
                    <div class="rounded-2xl bg-white text-slate-800 p-3.5 shadow-md border border-slate-200/90 hover:border-emerald-500 hover:scale-105 transition-all duration-300">
                        <div class="text-xs font-heading font-black uppercase tracking-wider text-slate-800 pb-1 border-b border-slate-100">
                            <?= esc($pimpinan['sekretaris']['jabatan'] ?? 'SEKRETARIS') ?>
                        </div>
                        <div class="pt-1.5 text-xs font-heading font-extrabold text-emerald-800">
                            <?= esc($pimpinan['sekretaris']['nama_penanggung_jawab'] ?? 'Ahmad Musyafa') ?>
                        </div>
                    </div>
                </div>

                <!-- Card Logistik -->
                <div class="w-64">
                    <div class="rounded-2xl bg-white text-slate-800 p-3.5 shadow-md border border-slate-200/90 hover:border-emerald-500 hover:scale-105 transition-all duration-300">
                        <div class="text-xs font-heading font-black uppercase tracking-wider text-slate-800 pb-1 border-b border-slate-100">
                            <?= esc($pimpinan['logistik']['jabatan'] ?? 'LOGISTIK') ?>
                        </div>
                        <div class="pt-1.5 text-xs font-heading font-extrabold text-emerald-800">
                            <?= esc($pimpinan['logistik']['nama_penanggung_jawab'] ?? 'Ahmad Fakhri Maulana') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LEVEL 4 & 5: 5 COLUMNS HIERARCHY (ASRAMA, GEMERLAP, LEMBAGA LAIN, SEKOLAH, SATGAS) -->
            <div class="grid grid-cols-5 gap-4 w-full max-w-5xl pt-4 items-start">

                <!-- KOLOM 1: ASRAMA -->
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-full p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200 shadow-sm text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-widest">
                            ASRAMA
                        </div>
                        <span class="text-[10px] font-extrabold text-emerald-700 bg-white px-2.5 py-0.5 rounded-full mt-1.5 inline-block border border-emerald-200/80 shadow-2xs">
                            <?= count($asramaUnits) ?> Unit
                        </span>
                    </div>

                    <!-- Sub-units Vertical Chain -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($asramaUnits)): ?>
                            <?php foreach ($asramaUnits as $u): 
                                $pjList = $u['pj_list'] ?? [];
                                $primaryPj = !empty($pjList) ? $pjList[0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: 'Belum ada PJ');
                            ?>
                                <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="font-heading font-extrabold text-xs text-slate-900 truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($u['nama_unit']) ?>
                                    </div>
                                    <div class="space-y-0.5 pt-0.5">
                                        <?php if (!empty($pjList)): ?>
                                            <?php foreach ($pjList as $pj): ?>
                                                <div class="text-[11px] text-slate-600 font-semibold flex items-center gap-1 truncate" title="<?= esc($pj['nama_pj']) ?>">
                                                    <i class="fa-solid fa-user-check text-[9px] text-emerald-600"></i>
                                                    <span><?= esc($pj['nama_pj']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-[11px] text-slate-500 font-semibold truncate">
                                                <?= esc($primaryPjName) ?>
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
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-full p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200 shadow-sm text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-widest">
                            GEMERLAP
                        </div>
                        <span class="text-[10px] font-extrabold text-emerald-700 bg-white px-2.5 py-0.5 rounded-full mt-1.5 inline-block border border-emerald-200/80 shadow-2xs">
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
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '-');
                            ?>
                                <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="font-heading font-extrabold text-xs text-slate-900 truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($cleanName ?: $u['nama_unit']) ?>
                                    </div>
                                    <div class="text-[11px] text-emerald-700 font-bold truncate flex items-center justify-between">
                                        <span>Kader GEMERLAP</span>
                                        <?php if (!empty($kaderMembers)): ?>
                                            <span class="text-[9.5px] px-1.5 py-0.2 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 font-extrabold"><?= count($kaderMembers) ?> Anggota</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!empty($kaderMembers)): ?>
                                        <div class="pt-1 border-t border-slate-100 space-y-0.5">
                                            <?php foreach (array_slice($kaderMembers, 0, 3) as $km): ?>
                                                <div class="text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($km['nama_kader']) ?>">
                                                    <i class="fa-solid fa-circle-user text-[9px] text-emerald-600"></i>
                                                    <span><?= esc($km['nama_kader']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php if (count($kaderMembers) > 3): ?>
                                                <div class="text-[9px] text-slate-400 italic">+<?= count($kaderMembers) - 3 ?> anggota lainnya</div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-[10px] text-slate-400 font-medium">PJ: <?= esc($primaryPjName) ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada kader aktif</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KOLOM 3: LEMBAGA LAIN (KSY, Gedung Umum, Kos, dll) -->
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-full p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200 shadow-sm text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-widest">
                            LEMBAGA LAIN
                        </div>
                        <span class="text-[10px] font-extrabold text-emerald-700 bg-white px-2.5 py-0.5 rounded-full mt-1.5 inline-block border border-emerald-200/80 shadow-2xs">
                            <?= count($lembagaUnits) ?> Unit
                        </span>
                    </div>

                    <!-- Sub-units Lembaga Lain -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($lembagaUnits)): ?>
                            <?php foreach ($lembagaUnits as $u): 
                                $pjList = $u['pj_list'] ?? [];
                                $primaryPj = !empty($pjList) ? $pjList[0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: 'Belum ada PJ');
                            ?>
                                <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="font-heading font-extrabold text-xs text-slate-900 truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($u['nama_unit']) ?>
                                    </div>
                                    <div class="space-y-0.5 pt-0.5">
                                        <?php if (!empty($pjList)): ?>
                                            <?php foreach ($pjList as $pj): ?>
                                                <div class="text-[11px] text-slate-600 font-semibold flex items-center gap-1 truncate" title="<?= esc($pj['nama_pj']) ?>">
                                                    <i class="fa-solid fa-user-check text-[9px] text-emerald-600"></i>
                                                    <span><?= esc($pj['nama_pj']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-[11px] text-slate-500 font-semibold truncate">
                                                <?= esc($primaryPjName) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-[10px] text-emerald-700 font-medium"><?= esc($u['tipe'] ?: 'Lembaga') ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-[10px] text-slate-400 italic">Belum ada unit lembaga lain</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KOLOM 4: SEKOLAH (MTS, MA, SMK, dll) -->
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-full p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200 shadow-sm text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-widest">
                            SEKOLAH
                        </div>
                        <span class="text-[10px] font-extrabold text-emerald-700 bg-white px-2.5 py-0.5 rounded-full mt-1.5 inline-block border border-emerald-200/80 shadow-2xs">
                            <?= count($sekolahUnits) ?> Lembaga
                        </span>
                    </div>

                    <!-- Sub-units Sekolah -->
                    <div class="w-full space-y-2">
                        <?php if (!empty($sekolahUnits)): ?>
                            <?php foreach ($sekolahUnits as $u): 
                                $pjList = $u['pj_list'] ?? [];
                                $primaryPj = !empty($pjList) ? $pjList[0] : null;
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: 'Belum ada PJ');
                            ?>
                                <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="font-heading font-extrabold text-xs text-slate-900 truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($u['nama_unit']) ?>
                                    </div>
                                    <div class="space-y-0.5 pt-0.5">
                                        <?php if (!empty($pjList)): ?>
                                            <?php foreach ($pjList as $pj): ?>
                                                <div class="text-[11px] text-slate-600 font-semibold flex items-center gap-1 truncate" title="<?= esc($pj['nama_pj']) ?>">
                                                    <i class="fa-solid fa-user-check text-[9px] text-emerald-600"></i>
                                                    <span><?= esc($pj['nama_pj']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-[11px] text-slate-500 font-semibold truncate">
                                                <?= esc($primaryPjName) ?>
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
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-full p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200 shadow-sm text-center">
                        <div class="font-heading font-black text-xs text-emerald-950 uppercase tracking-widest">
                            SATGAS
                        </div>
                        <span class="text-[10px] font-extrabold text-emerald-700 bg-white px-2.5 py-0.5 rounded-full mt-1.5 inline-block border border-emerald-200/80 shadow-2xs">
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
                                $primaryPjName = $primaryPj ? $primaryPj['nama_pj'] : ($u['pj_nama'] ?: '-');
                            ?>
                                <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs text-left hover:shadow-md hover:border-emerald-400 transition space-y-1">
                                    <div class="font-heading font-extrabold text-xs text-slate-900 truncate" title="<?= esc($u['nama_unit']) ?>">
                                        <?= esc($cleanSatgasName ?: $u['nama_unit']) ?>
                                    </div>
                                    <div class="text-[11px] text-emerald-700 font-bold truncate flex items-center justify-between">
                                        <span>Satgas Kebersihan</span>
                                        <?php if (!empty($kaderMembers)): ?>
                                            <span class="text-[9.5px] px-1.5 py-0.2 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 font-extrabold"><?= count($kaderMembers) ?> Anggota</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($kaderMembers)): ?>
                                        <div class="pt-1 border-t border-slate-100 space-y-0.5">
                                            <?php foreach (array_slice($kaderMembers, 0, 3) as $km): ?>
                                                <div class="text-[10px] text-slate-700 font-semibold flex items-center gap-1 truncate" title="<?= esc($km['nama_kader']) ?>">
                                                    <i class="fa-solid fa-circle-user text-[9px] text-emerald-600"></i>
                                                    <span><?= esc($km['nama_kader']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php if (count($kaderMembers) > 3): ?>
                                                <div class="text-[9px] text-slate-400 italic">+<?= count($kaderMembers) - 3 ?> anggota lainnya</div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-[10px] text-slate-400 font-medium">PJ: <?= esc($primaryPjName) ?></div>
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

<!-- Modal Tambah & Edit Form -->
<?php if (!empty($isLoggedIn)): ?>
    <div id="modalAddStruktur" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[999999] flex items-center justify-center p-4 hidden">
        <div class="glass-card rounded-3xl p-6 sm:p-7 max-w-lg w-full bg-white shadow-2xl space-y-5 border border-slate-200 relative animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-extrabold">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <h3 class="font-heading font-extrabold text-base text-slate-900">Tambah Anggota Struktur</h3>
                </div>
                <button type="button" onclick="closeAddStrukturModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="<?= base_url('struktur/store') ?>" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Penempatan Bagian (Node Bagan)</label>
                    <select name="node_category" id="addNodeCategory" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="koordinator">1. Koordinator Kebersihan</option>
                        <option value="wakil">2. Wakil / Sekretaris</option>
                        <option value="gudang">3. Gudang & Logistik</option>
                        <option value="asrama_pj" selected>4. Asrama ➔ PJ Asrama</option>
                        <option value="asrama_gemerlap">4. Asrama ➔ Gemerlap</option>
                        <option value="unit_kos_ungu">5. Unit ➔ Kos Ungu</option>
                        <option value="unit_kos_iso">5. Unit ➔ Kos ISO</option>
                        <option value="unit_mess">5. Unit ➔ MESS</option>
                        <option value="unit_perkantoran">5. Unit ➔ Perkantoran</option>
                        <option value="unit_bump">5. Unit ➔ BUMP</option>
                        <option value="sekolah_pj">6. Sekolah ➔ PJ Sekolah</option>
                        <option value="sekolah_satgas">6. Sekolah ➔ Satgas Kebersihan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Jabatan / Posisi</label>
                    <input type="text" name="jabatan" placeholder="Contoh: Koordinator Asrama Putra..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Penanggung Jawab</label>
                    <input type="text" name="nama_penanggung_jawab" placeholder="Ketik nama lengkap beserta gelar..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Role</label>
                        <select name="role_kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="Pimpinan">Pimpinan</option>
                            <option value="Pengurus Harian" selected>Pengurus Harian</option>
                            <option value="Divisi Teknis">Divisi Teknis</option>
                            <option value="Penanggung Jawab Unit">Penanggung Jawab Unit</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp / HP</label>
                        <input type="text" name="kontak_hp" placeholder="08123456789..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tugas & Wewenang</label>
                    <textarea name="tugas_wewenang" rows="3" placeholder="Jelaskan rincian tugas pokok..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeAddStrukturModal()" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-600 font-extrabold text-xs hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs shadow-md shadow-emerald-600/20 hover:from-emerald-700 hover:to-teal-700 transition">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

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

    function openAddStrukturModal() {
        document.getElementById('modalAddStruktur').classList.remove('hidden');
    }
    window.openAddStrukturModal = openAddStrukturModal;

    function closeAddStrukturModal() {
        document.getElementById('modalAddStruktur').classList.add('hidden');
    }
    window.closeAddStrukturModal = closeAddStrukturModal;

    // Drag and Drop Engine
    function initStrukturDragAndDrop() {
        const container = document.getElementById('sortableStrukturList');
        if (!container) return;

        const cards = container.querySelectorAll('.struktur-card[draggable="true"]');
        let draggedCard = null;

        cards.forEach(card => {
            card.addEventListener('dragstart', (e) => {
                draggedCard = card;
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', card.dataset.id);
                setTimeout(() => {
                    card.classList.add('opacity-40', 'scale-95', 'border-emerald-500', 'ring-2', 'ring-emerald-400');
                }, 0);
            });

            card.addEventListener('dragend', () => {
                card.classList.remove('opacity-40', 'scale-95', 'border-emerald-500', 'ring-2', 'ring-emerald-400');
                draggedCard = null;
                updateOrderNumbers();
                saveNewStrukturOrder();
            });

            card.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                if (!draggedCard || draggedCard === card) return;

                const bounding = card.getBoundingClientRect();
                const offset = e.clientY - bounding.top - (bounding.height / 2);

                if (offset > 0) {
                    card.after(draggedCard);
                } else {
                    card.before(draggedCard);
                }
            });
        });

        function updateOrderNumbers() {
            const allCards = container.querySelectorAll('.struktur-card');
            allCards.forEach((c, idx) => {
                const badge = c.querySelector('.order-number');
                if (badge) badge.textContent = idx + 1;
            });
        }

        async function saveNewStrukturOrder() {
            const allCards = container.querySelectorAll('.struktur-card');
            const orderIds = Array.from(allCards).map(c => c.dataset.id);

            try {
                const formData = new FormData();
                orderIds.forEach(id => formData.append('order[]', id));

                const response = await fetch("<?= base_url('struktur/update-order') ?>", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const res = await response.json();
                if (res.status === 'success' && typeof showToast === 'function') {
                    showToast(res.message, 'success');
                }
            } catch (err) {
                console.error('Failed to save order:', err);
            }
        }
    }
    window.initStrukturDragAndDrop = initStrukturDragAndDrop;

    document.addEventListener('DOMContentLoaded', initStrukturDragAndDrop);
    window.rebindPageEvents = initStrukturDragAndDrop;
    initStrukturDragAndDrop();
</script>
<?= $this->endSection() ?>
