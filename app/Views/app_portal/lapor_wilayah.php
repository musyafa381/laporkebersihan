<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 pb-12 w-full max-w-7xl mx-auto">
    <!-- Top Header Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/50 border border-slate-200/80 bg-white relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-52 h-52 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 relative z-10">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-heading font-extrabold tracking-wide uppercase border border-emerald-200/60 shadow-2xs">
                    <i class="fa-solid fa-map-location-dot text-emerald-600"></i>
                    <span>Portal Laporan Harian Wilayah Tugas</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                    Lapor Kebersihan Wilayah
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed max-w-2xl">
                    Kirim laporan harian wilayah tugas unit Anda, atur jam pengiriman, tentukan nilai capaian (0 – 100%), dan lampirkan bukti foto setelah dibersihkan.
                </p>
            </div>

            <?php if ($userUnit): ?>
                <div class="p-3.5 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50/70 border border-emerald-200/80 shadow-2xs self-start lg:self-center flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm font-extrabold shadow-sm flex-shrink-0">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <div>
                        <div class="text-[9px] font-extrabold text-emerald-800 uppercase tracking-wider">Unit Login Anda</div>
                        <div class="font-heading font-extrabold text-xs sm:text-sm text-slate-900"><?= esc($userUnit['nama_unit']) ?></div>
                        <div class="text-[10px] text-emerald-700 font-semibold"><?= esc($userUnit['tipe']) ?> &bull; <?= count($penugasanList ?? []) ?> Wilayah Tugas</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Workflow Steps -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 mt-5 pt-4 border-t border-slate-100 text-xs font-bold text-slate-600">
            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50/90 border border-slate-200/70">
                <span class="w-5 h-5 rounded-md bg-emerald-600 text-white text-[10px] flex items-center justify-center font-extrabold">1</span>
                <span class="text-[11px]">Pilih Wilayah</span>
            </div>
            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50/90 border border-slate-200/70">
                <span class="w-5 h-5 rounded-md bg-emerald-600 text-white text-[10px] flex items-center justify-center font-extrabold">2</span>
                <span class="text-[11px]">Sesuaikan Jam</span>
            </div>
            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50/90 border border-slate-200/70">
                <span class="w-5 h-5 rounded-md bg-emerald-600 text-white text-[10px] flex items-center justify-center font-extrabold">3</span>
                <span class="text-[11px]">Beri Nilai Skor</span>
            </div>
            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50/90 border border-slate-200/70">
                <span class="w-5 h-5 rounded-md bg-emerald-600 text-white text-[10px] flex items-center justify-center font-extrabold">4</span>
                <span class="text-[11px]">Upload Bukti Foto</span>
            </div>
        </div>
    </div>

    <!-- Assigned Zones Section: 4 Cards Per Row -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 flex-wrap">
            <h2 class="font-heading font-extrabold text-base sm:text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-emerald-600"></i> Wilayah Tugas Kebersihan Hari Ini (<?= date('d M Y') ?>)
            </h2>
            <div class="flex items-center gap-2.5 flex-wrap">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="searchAssignedCardInput" onkeyup="filterAssignedCards()" placeholder="Cari wilayah / shift..." class="pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white shadow-2xs">
                </div>
                <button type="button" onclick="openModalTambahWilayahUnit()" class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 whitespace-nowrap">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Tambah Wilayah Tugas</span>
                </button>
                <span class="text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200/80 whitespace-nowrap">
                    <?= count($penugasanList ?? []) ?> Wilayah
                </span>
            </div>
        </div>

        <?php if (!empty($penugasanList)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5" id="assignedCardsGrid">
                <?php foreach ($penugasanList as $p): ?>
                    <?php
                        $shiftBadge = 'bg-amber-500 text-white';
                        $shiftIcon  = 'fa-sun';
                        if ($p['shift'] === 'Siang') {
                            $shiftBadge = 'bg-orange-500 text-white';
                            $shiftIcon  = 'fa-sun';
                        } elseif ($p['shift'] === 'Sore') {
                            $shiftBadge = 'bg-blue-600 text-white';
                            $shiftIcon  = 'fa-cloud-sun';
                        } elseif ($p['shift'] === 'Malam') {
                            $shiftBadge = 'bg-purple-600 text-white';
                            $shiftIcon  = 'fa-moon';
                        }
                    ?>
                    <div class="assigned-wilayah-card glass-card rounded-3xl border border-slate-200/80 bg-white overflow-hidden shadow-md shadow-slate-200/30 hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between group"
                         data-name="<?= strtolower(esc($p['nama_wilayah'])) ?>"
                         data-shift="<?= strtolower(esc($p['shift'])) ?>"
                         data-code="<?= strtolower(esc($p['kode_wilayah'] ?? '')) ?>"
                         data-gedung="<?= strtolower(esc($p['lokasi_gedung'] ?? '')) ?>">
                        
                        <!-- Top Image & Badges -->
                        <div class="relative h-40 bg-slate-100 overflow-hidden border-b border-slate-100">
                            <?php if (!empty($p['primary_foto'])): ?>
                                <img src="<?= esc($p['primary_foto']) ?>" alt="<?= esc($p['nama_wilayah']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 cursor-pointer" onclick="openLightbox('<?= esc($p['primary_foto']) ?>')">
                            <?php else: ?>
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400 gap-1">
                                    <i class="fa-solid fa-image text-2xl"></i>
                                    <span class="text-[10px] font-bold">Foto Master Wilayah</span>
                                </div>
                            <?php endif; ?>

                            <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between gap-1.5 pointer-events-none">
                                <span class="px-2 py-0.5 rounded-lg bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-heading font-extrabold shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-tag text-emerald-400"></i>
                                    <?= esc($p['kode_wilayah'] ?: 'WIL-' . $p['wilayah_id']) ?>
                                </span>

                                <div class="flex items-center gap-1">
                                    <?php if (!empty($p['active_cs_count'])): ?>
                                        <span class="px-2 py-0.5 rounded-lg bg-rose-600 text-white text-[9px] font-heading font-extrabold shadow-md animate-pulse flex items-center gap-1">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                            <span><?= $p['active_cs_count'] ?> CS</span>
                                        </span>
                                    <?php endif; ?>

                                    <span class="px-2 py-0.5 rounded-lg text-[9px] font-heading font-extrabold shadow-sm <?= $shiftBadge ?>">
                                        <i class="fa-solid <?= $shiftIcon ?> mr-0.5"></i> <?= esc($p['shift']) ?> (<?= esc($p['jam_mulai']) ?>-<?= esc($p['jam_selesai']) ?>)
                                    </span>
                                </div>
                            </div>

                            <?php if (!empty($p['primary_foto'])): ?>
                                <button type="button" onclick="openLightbox('<?= esc($p['primary_foto']) ?>')" class="absolute bottom-2 right-2 px-2 py-0.5 rounded-lg bg-black/60 backdrop-blur-md text-white text-[9px] font-bold flex items-center gap-1 shadow-2xs hover:bg-black/80 transition">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i> Lihat Foto
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Content Area -->
                        <div class="p-4 flex-1 space-y-3 flex flex-col justify-between">
                            <div class="space-y-2.5">
                                <h3 class="font-heading font-extrabold text-sm text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 min-h-[2.5rem]">
                                    <?= esc($p['nama_wilayah']) ?>
                                </h3>

                                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium flex-wrap">
                                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50/70 px-1.5 py-0.5 rounded-md border border-emerald-200/50">
                                        <i class="fa-solid fa-tag text-[9px]"></i> <?= esc($p['kategori_area'] ?? 'Area') ?>
                                    </span>
                                    <?php if (!empty($p['lokasi_gedung'])): ?>
                                        <span class="text-slate-300">&bull;</span>
                                        <span class="truncate max-w-[150px]"><i class="fa-solid fa-location-dot text-rose-500 mr-0.5"></i> <?= esc($p['lokasi_gedung']) ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Active CS Complaint Alert Box -->
                                <?php if (!empty($p['active_cs_count']) && !empty($p['active_cs_reports'])): ?>
                                    <div class="p-2.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs space-y-1.5 shadow-2xs">
                                        <div class="flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1 text-[10.5px] font-extrabold text-rose-800 uppercase tracking-wide">
                                                <i class="fa-solid fa-triangle-exclamation text-rose-600 animate-bounce"></i>
                                                <span>Keluhan CS Masuk (<?= $p['active_cs_count'] ?>)</span>
                                            </span>
                                            <span class="px-1.5 py-0.5 rounded bg-rose-200 text-rose-900 text-[9px] font-extrabold">
                                                <?= esc($p['active_cs_reports'][0]['status']) ?>
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-rose-800 font-semibold italic line-clamp-2 bg-white/90 p-2 rounded-xl border border-rose-200/60 shadow-2xs">
                                            "<?= esc($p['active_cs_reports'][0]['isi_laporan']) ?>"
                                        </p>
                                        <div class="text-[9.5px] text-rose-600 font-semibold flex items-center justify-between pt-0.5">
                                            <span>Oleh: <?= esc($p['active_cs_reports'][0]['nama_pengirim']) ?></span>
                                            <?php 
                                                $csFotos = json_decode($p['active_cs_reports'][0]['foto_lampiran'] ?? '[]', true) ?: [];
                                                if (!empty($csFotos)): 
                                            ?>
                                                <button type="button" onclick="openLightbox('<?= esc($csFotos[0]) ?>')" class="text-rose-800 font-extrabold hover:underline flex items-center gap-0.5">
                                                    <i class="fa-solid fa-image text-[9px]"></i> Bukti CS
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($p['keterangan'])): ?>
                                    <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/80 text-[11px] text-slate-700 leading-relaxed font-medium">
                                        <strong class="text-amber-900 font-bold block mb-0.5"><i class="fa-solid fa-note-sticky text-amber-500 mr-1"></i> Petunjuk:</strong>
                                        <p class="line-clamp-2"><?= esc($p['keterangan']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Reporting Status Box -->
                            <div class="pt-3 border-t border-slate-100 space-y-2">
                                <?php if ($p['is_reported_today']): ?>
                                    <?php
                                        $skor = (int)($p['today_report']['nilai_kebersihan'] ?? 100);
                                        $scoreBadge = $skor >= 80 ? 'bg-emerald-600 text-white' : ($skor >= 60 ? 'bg-amber-500 text-white' : 'bg-rose-500 text-white');
                                        $jamTerkirim = !empty($p['today_report']['jam_lapor']) ? $p['today_report']['jam_lapor'] : date('H:i', strtotime($p['today_report']['created_at'] ?? 'now'));
                                    ?>
                                    <div class="p-3 rounded-2xl bg-emerald-50/90 border border-emerald-200 space-y-2 shadow-2xs">
                                        <div class="flex items-center justify-between gap-1">
                                            <div class="inline-flex items-center gap-1 text-[11px] font-heading font-extrabold text-emerald-900">
                                                <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                                                <span>Sudah Lapor</span>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-extrabold <?= $scoreBadge ?> shadow-2xs">
                                                <?= $skor ?>%
                                            </span>
                                        </div>

                                        <div class="text-[10px] text-emerald-700 font-semibold flex items-center justify-between">
                                            <span><i class="fa-regular fa-clock"></i> Pk <?= esc($jamTerkirim) ?> WIB</span>
                                            <span>Shift <?= esc($p['shift']) ?></span>
                                        </div>

                                        <div class="flex items-center gap-1.5 pt-1">
                                            <?php if (!empty($p['today_report']['foto_bukti_url'])): ?>
                                                <button type="button" onclick="openLightbox('<?= esc($p['today_report']['foto_bukti_url']) ?>')" class="px-2.5 py-1.5 rounded-xl bg-white text-emerald-800 hover:bg-emerald-100 border border-emerald-300 font-heading font-extrabold text-[11px] transition shadow-2xs flex items-center justify-center gap-1 flex-1">
                                                    <i class="fa-solid fa-image text-emerald-600 text-[10px]"></i>
                                                    <span>Bukti</span>
                                                </button>
                                            <?php endif; ?>

                                            <button type="button" onclick="openModalLapor(<?= htmlspecialchars(json_encode($p)) ?>)" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-heading font-extrabold text-[11px] transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1 flex-1">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                <span>Edit</span>
                                            </button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="p-3 rounded-2xl bg-rose-50/90 border border-rose-200 space-y-2 shadow-2xs">
                                        <div class="flex items-center justify-between gap-1">
                                            <div class="inline-flex items-center gap-1.5 text-[11px] font-heading font-extrabold text-rose-900">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                                <i class="fa-solid fa-clock text-rose-600 text-xs"></i>
                                                <span>Belum Lapor</span>
                                            </div>
                                            <span class="text-[9px] font-bold text-rose-600 bg-rose-100 px-1.5 py-0.5 rounded-md">
                                                Shift <?= esc($p['shift']) ?>
                                            </span>
                                        </div>

                                        <button type="button" onclick="openModalLapor(<?= htmlspecialchars(json_encode($p)) ?>)" class="w-full py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1.5">
                                            <i class="fa-solid fa-paper-plane text-[11px]"></i>
                                            <span>Kirim Laporan</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Bar for Assigned Wilayah Cards -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-200/80 px-1" id="pagination-container-assigned-cards">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-assigned-cards">Menampilkan 0 wilayah</span>
                    <select id="pageSize-assigned-cards" onchange="changeAssignedPageSize(this.value)" class="ml-2 px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="4">4 / hal</option>
                        <option value="8" selected>8 / hal</option>
                        <option value="12">12 / hal</option>
                        <option value="16">16 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-assigned-cards"></div>
            </div>
        <?php else: ?>
            <div class="glass-card rounded-3xl p-12 text-center bg-white border border-slate-200 space-y-3">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3 class="font-heading font-extrabold text-base text-slate-800">Tidak Ada Wilayah Tugas yang Terhubung</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">Unit Anda saat ini belum memiliki plotting wilayah tugas kebersihan. Silakan hubungi Admin K3L untuk pengaturan jadwal wilayah.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 3: History of Reports Sent by this Unit with Interactive Pagination & Search -->
    <?php if (!empty($myLaporanHistory)): ?>
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Riwayat Laporan Kebersihan Unit Anda
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Daftar arsip laporan harian yang telah terkirim beserta waktu, skor capaian, dan foto bukti.</p>
                </div>
                
                <span id="historyTotalBadge" class="text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/80 self-start sm:self-auto">
                    <?= count($myLaporanHistory) ?> Laporan Terdata
                </span>
            </div>

            <!-- Table Filter Toolbar -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-200/80">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="historySearchInput" onkeyup="filterHistoryTable()" placeholder="Cari tanggal, shift, wilayah, atau catatan..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-extrabold text-slate-500 whitespace-nowrap">Tampilkan:</span>
                    <select id="historyPageSize" onchange="changeHistoryPageSize(this.value)" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-extrabold bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                        <option value="5">5 Data</option>
                        <option value="10" selected>10 Data</option>
                        <option value="20">20 Data</option>
                        <option value="50">50 Data</option>
                    </select>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table id="historyTable" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">TANGGAL & WAKTU LOKAL</th>
                            <th class="py-3 px-4">SHIFT</th>
                            <th class="py-3 px-4">WILAYAH KEBERSIHAN</th>
                            <th class="py-3 px-3 text-center">NILAI CAPAIAN</th>
                            <th class="py-3 px-4 text-center">BUKTI FOTO</th>
                            <th class="py-3 px-4">CATATAN PEMBERSIHAN</th>
                            <th class="py-3 px-3 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody" class="divide-y divide-slate-100 bg-white">
                        <?php foreach ($myLaporanHistory as $hist): ?>
                            <?php
                                $skor = (int)$hist['nilai_kebersihan'];
                                $skorBg = $skor >= 80 ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($skor >= 60 ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200');
                                $jamLapor = !empty($hist['jam_lapor']) ? $hist['jam_lapor'] : date('H:i', strtotime($hist['created_at'] ?? 'now'));
                            ?>
                            <tr class="history-row hover:bg-slate-50/80 transition"
                                data-search="<?= strtolower(esc($hist['nama_wilayah'] . ' ' . $hist['shift'] . ' ' . $hist['tanggal_lapor'] . ' ' . ($hist['catatan'] ?? ''))) ?>">
                                <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                    <div><?= date('d M Y', strtotime($hist['tanggal_lapor'])) ?></div>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-500 font-semibold mt-0.5">
                                        <i class="fa-regular fa-clock text-slate-400"></i> Pk <?= esc($jamLapor) ?> WIB
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-extrabold <?= $hist['shift'] === 'Pagi' ? 'bg-amber-50 text-amber-800 border border-amber-200/80' : ($hist['shift'] === 'Sore' ? 'bg-blue-50 text-blue-800 border border-blue-200/80' : 'bg-teal-50 text-teal-800 border border-teal-200/80') ?>">
                                        <i class="fa-solid <?= $hist['shift'] === 'Pagi' ? 'fa-sun' : ($hist['shift'] === 'Sore' ? 'fa-cloud-sun' : 'fa-moon') ?>"></i>
                                        Shift <?= esc($hist['shift']) ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-map-pin text-emerald-600 text-xs"></i>
                                        <span><?= esc($hist['nama_wilayah']) ?></span>
                                    </div>
                                    <?php if (!empty($hist['kode_wilayah'])): ?>
                                        <span class="text-[10px] text-slate-400 font-semibold"><?= esc($hist['kode_wilayah']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-heading font-extrabold border <?= $skorBg ?> shadow-2xs">
                                        <?= $skor ?>%
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($hist['foto_bukti_url'])): ?>
                                        <div class="inline-block relative group w-14 h-11 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 cursor-pointer shadow-2xs" onclick="openLightbox('<?= esc($hist['foto_bukti_url']) ?>')" title="Lihat Foto Bukti">
                                            <img src="<?= esc($hist['foto_bukti_url']) ?>" alt="Bukti" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[10px]">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-[11px] text-slate-400 italic">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 font-medium max-w-xs">
                                    <?= esc($hist['catatan'] ?: '-') ?>
                                </td>
                                <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-extrabold <?= $hist['status_verifikasi'] === 'Sudah Bersih' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' ?>">
                                        <i class="fa-solid <?= $hist['status_verifikasi'] === 'Sudah Bersih' ? 'fa-check' : 'fa-triangle-exclamation' ?>"></i>
                                        <span><?= esc($hist['status_verifikasi']) ?></span>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar Controls -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2 border-t border-slate-100">
                <div id="historyPageInfo" class="text-xs text-slate-500 font-semibold">
                    Menampilkan 1 - 10 dari <?= count($myLaporanHistory) ?> data laporan
                </div>

                <div class="flex items-center gap-1.5" id="historyPaginationControls">
                    <!-- Dynamic Page Buttons Generated by JavaScript -->
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Section: Laporan & Keluhan CS Terkait Wilayah Tugas Unit Ini -->
    <?php if (!empty($csReportsForMyWilayah)): ?>
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg border border-amber-200/80 flex-shrink-0">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h2 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">
                            Laporan / Pengaduan CS Terkait Wilayah Tugas Unit
                        </h2>
                        <p class="text-xs text-slate-500 font-medium">Daftar keluhan santri & masyarakat pada area tugas yang diampu oleh unit Anda.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="relative w-full sm:w-60">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input type="text" id="searchUnitCsInput" onkeyup="filterUnitCsTable()" placeholder="Cari pelapor / wilayah / isi..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-extrabold text-amber-800 bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200/80 whitespace-nowrap">
                            <?= count($csReportsForMyWilayah) ?> Laporan CS
                        </span>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table id="tableUnitCsWilayah" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="14%" class="py-3 px-4">TANGGAL & WAKTU</th>
                            <th width="18%" class="py-3 px-4">WILAYAH PEMETAAN</th>
                            <th width="18%" class="py-3 px-4">PENGIRIM & KONTAK</th>
                            <th width="32%" class="py-3 px-4">ISI LAPORAN & CATATAN ADMIN</th>
                            <th width="12%" class="py-3 px-4 text-center">FOTO BUKTI CS</th>
                            <th width="12%" class="py-3 px-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php foreach ($csReportsForMyWilayah as $idx => $cs): ?>
                            <?php
                                $cleanHp = preg_replace('/[^0-9]/', '', $cs['kontak_hp'] ?? '');
                                if (substr($cleanHp, 0, 1) === '0') {
                                    $cleanHp = '62' . substr($cleanHp, 1);
                                }
                                $fotos = json_decode($cs['foto_lampiran'] ?? '[]', true) ?: [];
                            ?>
                            <tr class="unit-cs-row hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-3 text-center font-bold text-slate-400"><?= $idx + 1 ?></td>
                                <td class="py-3.5 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar-days text-slate-400 text-xs"></i>
                                        <span><?= date('d M Y', strtotime($cs['created_at'])) ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5 flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        <span><?= date('H:i', strtotime($cs['created_at'])) ?> WIB</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-slate-900">
                                    <div class="flex items-center gap-1.5 text-xs text-emerald-800">
                                        <i class="fa-solid fa-map-location-dot text-emerald-600"></i>
                                        <span><?= esc($cs['nama_wilayah'] ?: ($cs['unit_lokasi'] ?: 'Wilayah Terkait')) ?></span>
                                    </div>
                                    <?php if (!empty($cs['unit_lokasi']) && $cs['unit_lokasi'] !== $cs['nama_wilayah']): ?>
                                        <div class="text-[10px] text-slate-400 font-medium mt-0.5"><?= esc($cs['unit_lokasi']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-heading font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-user text-emerald-600 text-[10px]"></i>
                                        <span><?= esc($cs['nama_pengirim']) ?></span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 mt-1">
                                        <?php if (!empty($cs['kategori'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-bold border border-emerald-200/70">
                                                <i class="fa-solid fa-tag text-[8px]"></i>
                                                <?= esc($cs['kategori']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($cs['kontak_hp'])): ?>
                                            <a href="https://wa.me/<?= $cleanHp ?>?text=Halo%20<?= urlencode($cs['nama_pengirim']) ?>,%20terkait%20laporan%20kebersihan%20di%20<?= urlencode($cs['nama_wilayah'] ?? 'wilayah tugas') ?>" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100/70 hover:bg-emerald-200 text-emerald-800 text-[10px] font-mono font-bold transition shadow-2xs" title="Chat WhatsApp">
                                                <i class="fa-brands fa-whatsapp text-emerald-600 text-[10px]"></i>
                                                <span><?= esc($cs['kontak_hp']) ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                        "<?= esc($cs['isi_laporan']) ?>"
                                    </div>
                                    <?php if (!empty($cs['tanggapan_admin'])): ?>
                                        <div class="mt-2 p-2.5 rounded-xl bg-emerald-50/90 border border-emerald-200 text-emerald-950 text-[11px] font-semibold space-y-0.5 shadow-2xs">
                                            <div class="text-[10px] font-extrabold text-emerald-800 flex items-center gap-1 uppercase tracking-wider">
                                                <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i> Tanggapan / Tindak Lanjut Admin:
                                            </div>
                                            <p class="pl-3.5 text-slate-700 font-medium leading-relaxed">
                                                <?= esc($cs['tanggapan_admin']) ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($fotos)): ?>
                                        <div class="flex flex-wrap items-center justify-center gap-1.5">
                                            <?php foreach ($fotos as $f): ?>
                                                <?php 
                                                    $imgUrl = (strpos($f, 'http://') === 0 || strpos($f, 'https://') === 0) ? $f : base_url('uploads/cs/' . $f);
                                                ?>
                                                <div class="group relative w-12 h-12 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 cursor-pointer shadow-2xs hover:border-emerald-500 transition" onclick="openLightbox('<?= esc($imgUrl) ?>')" title="Klik untuk perbesar">
                                                    <img src="<?= esc($imgUrl) ?>" alt="Bukti Kendala" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[10px]">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="inline-block mt-1 text-[9px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                            <?= count($fotos) ?> Foto
                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic font-medium">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <?php if ($cs['status'] === 'Baru'): ?>
                                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 text-xs font-extrabold border border-emerald-300 inline-flex items-center gap-1.5 shadow-2xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                                            Baru
                                        </span>
                                    <?php elseif ($cs['status'] === 'Diproses'): ?>
                                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                            Diproses
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-extrabold border border-slate-200 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                            Selesai
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-unit-cs-wilayah">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-unit-cs-wilayah">Menampilkan 0 data</span>
                    <select id="pageSize-unit-cs-wilayah" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5" selected>5 / hal</option>
                        <option value="10">10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-unit-cs-wilayah"></div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Form Laporan Harian Kebersihan (dengan Jam Pengiriman & Interactive Slider 0-100) -->
<div id="modalLaporWilayah" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-2xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center text-base shadow-2xs">
                    <i class="fa-solid fa-clipboard-check"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Lapor Kebersihan Wilayah
                    </h3>
                    <p id="modalLaporSubtitle" class="text-xs text-slate-500 font-medium">Area: Lapangan Utama Putri</p>
                </div>
            </div>
            <button onclick="closeModalLapor()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('app/lapor-wilayah/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" id="lapor_wilayah_id" name="wilayah_id" value="">
            <input type="hidden" id="lapor_penugasan_id" name="penugasan_id" value="">
            <input type="hidden" id="lapor_shift" name="shift" value="Pagi">

            <!-- Active CS Alert Reminder Inside Modal -->
            <div id="modalCsAlertContainer" class="hidden p-3.5 rounded-2xl bg-rose-50 border border-rose-300 text-rose-900 text-xs space-y-1.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 font-extrabold text-rose-800">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        <span>Perhatian: Ada Keluhan CS Masuk untuk Wilayah Ini!</span>
                    </span>
                    <span class="px-2 py-0.5 rounded bg-rose-200 text-rose-900 text-[10px] font-extrabold">Wajib Ditindaklanjuti</span>
                </div>
                <p id="modalCsAlertText" class="text-rose-800 italic font-semibold bg-white/90 p-2 rounded-xl border border-rose-200/80 shadow-2xs">
                </p>
                <p class="text-[10.5px] text-rose-600 font-bold">
                    Pastikan kendala di atas telah diselesaikan dan dibersihkan tuntas sebelum mengirim laporan ini.
                </p>
            </div>

            <!-- Tanggal & Jam Pengiriman & Shift Block -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lapor</label>
                    <input type="date" name="tanggal_lapor" id="lapor_tanggal" value="<?= date('Y-m-d') ?>" required class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Jam Lapor</span>
                        <span class="text-[10px] text-emerald-600 font-bold lowercase">WIB</span>
                    </label>
                    <input type="time" name="jam_lapor" id="lapor_jam" value="<?= date('H:i') ?>" required class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Shift Kerja</label>
                    <input type="text" id="display_shift" readonly class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-100 text-slate-700 cursor-not-allowed">
                </div>
            </div>

            <!-- INTERACTIVE SLIDER 0 - 100 DENGAN FLOATING BADGE & DYNAMIC PROGRESS COLOR -->
            <div class="space-y-2.5 pt-2 pb-1">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-sliders text-emerald-600"></i>
                        <span>Nilai Capaian Kebersihan</span>
                    </label>
                    <span id="sliderScoreLabel" class="text-xs font-bold text-slate-500">Sangat Bersih (Tuntas)</span>
                </div>

                <!-- Custom Range Slider Container -->
                <div class="relative pt-6 pb-2 px-1">
                    <!-- Floating Value Tooltip Bubble -->
                    <div id="sliderTooltip" class="absolute top-0 -translate-x-1/2 px-2.5 py-0.5 rounded-lg bg-emerald-600 text-white font-heading font-extrabold text-[11px] shadow-md transition-colors duration-150 pointer-events-none" style="left: 85%;">
                        85%
                    </div>

                    <!-- Range Input -->
                    <input type="range" id="scoreRangeInput" name="nilai_kebersihan" min="0" max="100" value="85" oninput="updateSliderUI(this.value)" class="w-full h-2.5 rounded-lg appearance-none cursor-pointer focus:outline-none transition-all duration-150" style="background: linear-gradient(to right, #059669 0%, #059669 85%, #e2e8f0 85%, #e2e8f0 100%);">

                    <!-- Scale 0, 50, and 100 labels -->
                    <div class="flex justify-between items-center text-[10px] font-extrabold text-slate-400 mt-1.5">
                        <span class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200">0%</span>
                        <span class="text-slate-300 font-semibold">Geser slider untuk memberi nilai kebersihan</span>
                        <span class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200">100%</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Unggah Bukti Foto Kebersihan Hari Ini</span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60">Cloudinary</span>
                </label>
                <input type="file" name="foto_bukti" accept="image/*" class="w-full px-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition shadow-2xs cursor-pointer">
                <p class="text-[11px] text-slate-400 font-medium mt-1">Unggah foto hasil pembersihan wilayah hari ini sebagai bukti valid.</p>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Catatan / Keterangan Pembersihan (Opsional)</label>
                <textarea name="catatan" id="lapor_catatan" rows="2" placeholder="Contoh: Sudah disapu dan dipel bersih, tempat sampah telah dikosongkan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalLapor()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Kirim Laporan Harian</button>
            </div>
        </form>
    </div>
</div>

<!-- Lightbox Preview Modal -->
    <div id="lightboxModal" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md hidden flex items-center justify-center p-4 cursor-pointer" onclick="closeLightbox()">
        <img id="lightboxImg" src="" alt="Preview" class="max-w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl animate-in zoom-in-95 duration-200">
        <button onclick="closeLightbox()" class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>

<!-- Modal Tambah Wilayah Tugas Mandiri oleh Unit (Compact & No-Scroll 2-Column Layout) -->
<div id="modalTambahWilayahUnit" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-slate-100 animate-in fade-in zoom-in duration-200">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-2xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center text-sm shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-map-location-dot"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-base sm:text-lg text-slate-900 leading-tight">
                        Tambah Wilayah Tugas Unit
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium">Daftarkan cakupan spot/area baru yang menjadi tanggung jawab unit Anda.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalTambahWilayahUnit()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition flex-shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="<?= base_url('app/wilayah-tugas/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-3.5">
            <!-- 2-Column Main Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                
                <!-- Left Column: Identitas Wilayah & Deskripsi -->
                <div class="space-y-2.5">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Wilayah / Spot Area <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_wilayah" placeholder="Misal: Selasar Kamar 1-6 / Kamar Mandi Barat" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori Area</label>
                            <select name="kategori_area" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                                <option value="Asrama & Kamar Mandi">Asrama & KM</option>
                                <option value="Tempat Ibadah & Selasar">Tempat Ibadah</option>
                                <option value="Gedung Sekolah & Kelas">Sekolah & Kelas</option>
                                <option value="Lapangan & Outdoor">Lapangan</option>
                                <option value="Dapur & Kantin">Dapur/Kantin</option>
                                <option value="Jalan & Saluran Air">Saluran Air</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Lokasi Gedung</label>
                            <input type="text" name="lokasi_gedung" placeholder="Lantai 2 / Gd. B" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Petunjuk Kerja (Opsional)</label>
                        <textarea name="keterangan" rows="2" placeholder="Sapu selasar, pel lantai, buang sampah..." class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs resize-none"></textarea>
                    </div>
                </div>

                <!-- Right Column: Shift Tugas & Foto Master -->
                <div class="space-y-2.5">
                    <!-- Shift Card Block -->
                    <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 space-y-2">
                        <div class="text-[10px] font-extrabold text-emerald-900 uppercase tracking-wider flex items-center justify-between">
                            <span class="flex items-center gap-1"><i class="fa-solid fa-clock text-emerald-600"></i> Shift Tugas Unit</span>
                            <span class="text-[9px] bg-emerald-200/60 text-emerald-900 px-1.5 py-0.5 rounded font-bold">Wajib</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 uppercase mb-0.5">Shift</label>
                                <select name="shift" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs font-extrabold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                                    <option value="Pagi">Pagi</option>
                                    <option value="Siang">Siang</option>
                                    <option value="Sore">Sore</option>
                                    <option value="Malam">Malam</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 uppercase mb-0.5">Mulai</label>
                                <input type="time" name="jam_mulai" value="06:00" class="w-full px-1.5 py-1.5 rounded-lg border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 uppercase mb-0.5">Selesai</label>
                                <input type="time" name="jam_selesai" value="07:30" class="w-full px-1.5 py-1.5 rounded-lg border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            </div>
                        </div>
                    </div>

                    <!-- Foto Upload Block -->
                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between">
                            <span>Foto Master Area</span>
                            <span class="text-[9px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60">Cloudinary</span>
                        </label>
                        <input type="file" name="foto_wilayah[]" multiple accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-[11px] font-bold bg-slate-50 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-extrabold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition shadow-2xs cursor-pointer">
                    </div>

                    <!-- Direct Active Tip -->
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 text-[10.5px] text-slate-500 font-medium flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 flex-shrink-0 text-xs"></i>
                        <span>Wilayah langsung aktif di kartu tugas unit setelah disimpan.</span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer Action Buttons -->
            <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahWilayahUnit()" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Simpan & Aktifkan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateSliderUI(val) {
        val = parseInt(val) || 0;
        const slider = document.getElementById('scoreRangeInput');
        const tooltip = document.getElementById('sliderTooltip');
        const label = document.getElementById('sliderScoreLabel');

        if (tooltip) {
            tooltip.innerText = val + '%';
            tooltip.style.left = val + '%';

            if (val >= 80) {
                tooltip.className = "absolute top-0 -translate-x-1/2 px-2.5 py-0.5 rounded-lg bg-emerald-600 text-white font-heading font-extrabold text-[11px] shadow-md transition-colors duration-150 pointer-events-none";
                if (label) label.innerHTML = '<span class="text-emerald-700 font-extrabold">Sangat Bersih (Tuntas)</span>';
                if (slider) slider.style.background = `linear-gradient(to right, #059669 0%, #059669 ${val}%, #e2e8f0 ${val}%, #e2e8f0 100%)`;
            } else if (val >= 60) {
                tooltip.className = "absolute top-0 -translate-x-1/2 px-2.5 py-0.5 rounded-lg bg-amber-500 text-white font-heading font-extrabold text-[11px] shadow-md transition-colors duration-150 pointer-events-none";
                if (label) label.innerHTML = '<span class="text-amber-700 font-extrabold">Cukup Bersih</span>';
                if (slider) slider.style.background = `linear-gradient(to right, #d97706 0%, #d97706 ${val}%, #e2e8f0 ${val}%, #e2e8f0 100%)`;
            } else {
                tooltip.className = "absolute top-0 -translate-x-1/2 px-2.5 py-0.5 rounded-lg bg-rose-500 text-white font-heading font-extrabold text-[11px] shadow-md transition-colors duration-150 pointer-events-none";
                if (label) label.innerHTML = '<span class="text-rose-600 font-extrabold">Kurang Bersih (Perlu Tindakan)</span>';
                if (slider) slider.style.background = `linear-gradient(to right, #e11d48 0%, #e11d48 ${val}%, #e2e8f0 ${val}%, #e2e8f0 100%)`;
            }
        }
    }
    window.updateSliderUI = updateSliderUI;

    function openModalLapor(item) {
        document.getElementById('lapor_wilayah_id').value = item.wilayah_id || '';
        document.getElementById('lapor_penugasan_id').value = item.id || '';
        document.getElementById('lapor_shift').value = item.shift || 'Pagi';
        document.getElementById('display_shift').value = 'Shift ' + (item.shift || 'Pagi');
        document.getElementById('modalLaporSubtitle').innerText = 'Area: ' + (item.nama_wilayah || '');

        // Pre-fill jam lapor with current time or existing report time
        const now = new Date();
        const currentHours = String(now.getHours()).padStart(2, '0');
        const currentMinutes = String(now.getMinutes()).padStart(2, '0');
        const currentTime = `${currentHours}:${currentMinutes}`;

        if (item.today_report) {
            const score = item.today_report.nilai_kebersihan || 85;
            document.getElementById('scoreRangeInput').value = score;
            document.getElementById('lapor_catatan').value = item.today_report.catatan || '';
            document.getElementById('lapor_jam').value = item.today_report.jam_lapor || currentTime;
            updateSliderUI(score);
        } else {
            document.getElementById('scoreRangeInput').value = 85;
            document.getElementById('lapor_catatan').value = '';
            document.getElementById('lapor_jam').value = currentTime;
            updateSliderUI(85);
        }

        const csAlertBox = document.getElementById('modalCsAlertContainer');
        const csAlertText = document.getElementById('modalCsAlertText');
        if (item.active_cs_reports && item.active_cs_reports.length > 0) {
            if (csAlertBox && csAlertText) {
                csAlertText.innerText = `"${item.active_cs_reports[0].isi_laporan}" (Oleh: ${item.active_cs_reports[0].nama_pengirim || 'Pelapor CS'})`;
                csAlertBox.classList.remove('hidden');
            }
        } else {
            if (csAlertBox) csAlertBox.classList.add('hidden');
        }

        const modal = document.getElementById('modalLaporWilayah');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalLapor = openModalLapor;

    function closeModalLapor() {
        const modal = document.getElementById('modalLaporWilayah');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalLapor = closeModalLapor;

    function openModalTambahWilayahUnit() {
        const modal = document.getElementById('modalTambahWilayahUnit');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalTambahWilayahUnit = openModalTambahWilayahUnit;

    function closeModalTambahWilayahUnit() {
        const modal = document.getElementById('modalTambahWilayahUnit');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalTambahWilayahUnit = closeModalTambahWilayahUnit;

    function openLightbox(url) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        if (modal && img) {
            img.src = url;
            modal.classList.remove('hidden');
        }
    }
    window.openLightbox = openLightbox;

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        if (modal) modal.classList.add('hidden');
    }
    window.closeLightbox = closeLightbox;

    // CLIENT-SIDE PAGINATION & SEARCH FOR HISTORY TABLE
    let currentHistoryPage = 1;
    let historyPageSize = 10;
    let filteredRows = [];

    function initHistoryTablePagination() {
        const rows = Array.from(document.querySelectorAll('.history-row'));
        filteredRows = rows;
        renderHistoryPagination();
    }

    function filterHistoryTable() {
        const query = (document.getElementById('historySearchInput')?.value || '').toLowerCase().trim();
        const allRows = Array.from(document.querySelectorAll('.history-row'));

        filteredRows = allRows.filter(row => {
            const searchData = row.getAttribute('data-search') || '';
            return !query || searchData.includes(query);
        });

        currentHistoryPage = 1;
        renderHistoryPagination();
    }
    window.filterHistoryTable = filterHistoryTable;

    function changeHistoryPageSize(size) {
        historyPageSize = parseInt(size) || 10;
        currentHistoryPage = 1;
        renderHistoryPagination();
    }
    window.changeHistoryPageSize = changeHistoryPageSize;

    function renderHistoryPagination() {
        const allRows = Array.from(document.querySelectorAll('.history-row'));
        const totalItems = filteredRows.length;
        const totalPages = Math.ceil(totalItems / historyPageSize) || 1;

        if (currentHistoryPage > totalPages) currentHistoryPage = totalPages;
        if (currentHistoryPage < 1) currentHistoryPage = 1;

        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');

        // Show only rows for the current page
        const startIdx = (currentHistoryPage - 1) * historyPageSize;
        const endIdx = Math.min(startIdx + historyPageSize, totalItems);

        for (let i = startIdx; i < endIdx; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = '';
            }
        }

        // Update Info Text
        const infoEl = document.getElementById('historyPageInfo');
        if (infoEl) {
            if (totalItems === 0) {
                infoEl.innerText = 'Tidak ada laporan yang sesuai dengan pencarian.';
            } else {
                infoEl.innerText = `Menampilkan ${startIdx + 1} – ${endIdx} dari ${totalItems} data laporan`;
            }
        }

        // Render Pagination Buttons
        const controls = document.getElementById('historyPaginationControls');
        if (!controls) return;

        controls.innerHTML = '';

        if (totalPages <= 1) return;

        // Prev Button
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${currentHistoryPage === 1 ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i>';
        prevBtn.disabled = currentHistoryPage === 1;
        prevBtn.onclick = () => { if (currentHistoryPage > 1) { currentHistoryPage--; renderHistoryPagination(); } };
        controls.appendChild(prevBtn);

        // Page Number Buttons
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentHistoryPage - 1 && p <= currentHistoryPage + 1)) {
                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${p === currentHistoryPage ? 'bg-emerald-600 text-white border-emerald-600 shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
                pageBtn.innerText = p;
                pageBtn.onclick = () => { currentHistoryPage = p; renderHistoryPagination(); };
                controls.appendChild(pageBtn);
            } else if (p === currentHistoryPage - 2 || p === currentHistoryPage + 2) {
                const dots = document.createElement('span');
                dots.className = 'px-1 text-slate-400 text-xs font-bold';
                dots.innerText = '...';
                controls.appendChild(dots);
            }
        }

        // Next Button
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${currentHistoryPage === totalPages ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right text-[10px]"></i>';
        nextBtn.disabled = currentHistoryPage === totalPages;
        nextBtn.onclick = () => { if (currentHistoryPage < totalPages) { currentHistoryPage++; renderHistoryPagination(); } };
        controls.appendChild(nextBtn);
    }

    // Unit CS Table Paginator & Filter
    var paginatorUnitCs;
    function initUnitCsPaginator() {
        if (document.getElementById('tableUnitCsWilayah') && typeof TablePaginator !== 'undefined') {
            paginatorUnitCs = new TablePaginator('tableUnitCsWilayah', 'page-info-unit-cs-wilayah', 'page-buttons-unit-cs-wilayah', 'pageSize-unit-cs-wilayah');
            paginatorUnitCs.render();
        }
    }

    function filterUnitCsTable() {
        const input = document.getElementById('searchUnitCsInput');
        const query = (input ? input.value : '').toLowerCase().trim();
        const rows = document.querySelectorAll('#tableUnitCsWilayah tbody tr');

        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                delete r.dataset.searchFiltered;
            } else {
                r.dataset.searchFiltered = 'false';
            }
        });

        if (paginatorUnitCs) {
            paginatorUnitCs.currentPage = 1;
            paginatorUnitCs.render();
        }
    }
    window.filterUnitCsTable = filterUnitCsTable;

    // Assigned Cards Paginator & Filter
    var currentAssignedPage = 1;
    var assignedPageSize = 8;
    var visibleAssignedCards = [];

    function renderAssignedCardsPagination() {
        const allCards = Array.from(document.querySelectorAll('.assigned-wilayah-card'));
        allCards.forEach(c => c.style.display = 'none');

        const totalItems = visibleAssignedCards.length;
        const totalPages = Math.ceil(totalItems / assignedPageSize) || 1;

        if (currentAssignedPage > totalPages) currentAssignedPage = totalPages;
        if (currentAssignedPage < 1) currentAssignedPage = 1;

        const startIdx = (currentAssignedPage - 1) * assignedPageSize;
        const endIdx = Math.min(startIdx + assignedPageSize, totalItems);

        for (let i = startIdx; i < endIdx; i++) {
            if (visibleAssignedCards[i]) {
                visibleAssignedCards[i].style.display = 'flex';
            }
        }

        const infoEl = document.getElementById('page-info-assigned-cards');
        if (infoEl) {
            if (totalItems === 0) {
                infoEl.innerText = 'Tidak ada wilayah tugas yang sesuai filter';
            } else {
                infoEl.innerText = `Menampilkan ${startIdx + 1} - ${endIdx} dari ${totalItems} wilayah`;
            }
        }

        const buttonsEl = document.getElementById('page-buttons-assigned-cards');
        if (!buttonsEl) return;
        buttonsEl.innerHTML = '';
        if (totalPages <= 1) return;

        // Prev
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${currentAssignedPage === 1 ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i>';
        prevBtn.disabled = currentAssignedPage === 1;
        prevBtn.onclick = () => { if (currentAssignedPage > 1) { currentAssignedPage--; renderAssignedCardsPagination(); } };
        buttonsEl.appendChild(prevBtn);

        // Numbers
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentAssignedPage - 1 && p <= currentAssignedPage + 1)) {
                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.className = `w-8 h-8 rounded-xl text-xs font-heading font-extrabold transition shadow-2xs ${p === currentAssignedPage ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700'}`;
                pageBtn.innerText = p;
                pageBtn.onclick = () => { currentAssignedPage = p; renderAssignedCardsPagination(); };
                buttonsEl.appendChild(pageBtn);
            } else if (p === currentAssignedPage - 2 || p === currentAssignedPage + 2) {
                const dots = document.createElement('span');
                dots.className = 'px-1 text-slate-400 text-xs font-bold';
                dots.innerText = '...';
                buttonsEl.appendChild(dots);
            }
        }

        // Next
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${currentAssignedPage === totalPages ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right text-[10px]"></i>';
        nextBtn.disabled = currentAssignedPage === totalPages;
        nextBtn.onclick = () => { if (currentAssignedPage < totalPages) { currentAssignedPage++; renderAssignedCardsPagination(); } };
        buttonsEl.appendChild(nextBtn);
    }

    function changeAssignedPageSize(val) {
        assignedPageSize = parseInt(val) || 8;
        currentAssignedPage = 1;
        renderAssignedCardsPagination();
    }
    window.changeAssignedPageSize = changeAssignedPageSize;

    function filterAssignedCards() {
        const search = (document.getElementById('searchAssignedCardInput')?.value || '').toLowerCase().trim();
        const allCards = Array.from(document.querySelectorAll('.assigned-wilayah-card'));
        visibleAssignedCards = allCards.filter(card => {
            const name   = (card.getAttribute('data-name') || '').toLowerCase();
            const shift  = (card.getAttribute('data-shift') || '').toLowerCase();
            const code   = (card.getAttribute('data-code') || '').toLowerCase();
            const gedung = (card.getAttribute('data-gedung') || '').toLowerCase();
            return !search || name.includes(search) || shift.includes(search) || code.includes(search) || gedung.includes(search);
        });
        currentAssignedPage = 1;
        renderAssignedCardsPagination();
    }
    window.filterAssignedCards = filterAssignedCards;

    document.addEventListener('DOMContentLoaded', function() {
        updateSliderUI(85);
        visibleAssignedCards = Array.from(document.querySelectorAll('.assigned-wilayah-card'));
        renderAssignedCardsPagination();
        initHistoryTablePagination();
        initUnitCsPaginator();
    });
</script>
<?= $this->endSection() ?>
