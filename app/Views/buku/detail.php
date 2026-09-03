<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Modern Header & Segmented Navbar -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-slate-100">
            <!-- Left: Breadcrumb & Title -->
            <div class="space-y-2.5">
                <a href="<?= base_url('buku') ?>" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100/80 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 text-xs font-bold transition-all border border-slate-200/60 shadow-2xs group">
                    <i class="fa-solid fa-arrow-left text-[10px] group-hover:-translate-x-0.5 transition"></i> 
                    <span>Kembali ke Daftar Buku</span>
                </a>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight leading-snug">
                        <?= esc($buku['judul']) ?>
                    </h1>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/80">
                        <i class="fa-solid fa-calendar text-[10px] text-emerald-600"></i>
                        <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
                    </span>
                </div>
            </div>

            <!-- Right: Status Control & Action Buttons -->
            <div class="flex items-center gap-3 self-start lg:self-center flex-shrink-0">
                <?php if (session()->get('role') === 'Admin'): ?>
                    <form action="<?= base_url('buku/update-status/' . $buku['id']) ?>" method="POST" class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider hidden sm:inline">Status:</span>
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()" class="appearance-none pl-3.5 pr-8 py-2.5 rounded-xl border border-slate-200 text-xs font-extrabold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 shadow-2xs cursor-pointer">
                                <option value="Aktif" <?= ($buku['status'] === 'Aktif' || $buku['status'] === 'AKTIF' || $buku['status'] === 'Berjalan' || empty($buku['status'])) ? 'selected' : '' ?>>🟢 Aktif</option>
                                <option value="Draft Proker" <?= ($buku['status'] === 'Draft Proker') ? 'selected' : '' ?>>🟠 Draft Proker</option>
                                <option value="Selesai" <?= ($buku['status'] === 'Selesai') ? 'selected' : '' ?>>🔵 Selesai</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </form>

                    <button onclick="openModalImportKeuangan()" class="px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-extrabold text-xs transition border border-emerald-200/90 shadow-2xs flex items-center gap-2">
                        <i class="fa-solid fa-file-import text-emerald-600"></i>
                        <span>Import Keuangan</span>
                    </button>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Status: <?= esc($buku['status'] ?: 'Aktif') ?>
                    </span>
                <?php endif; ?>

                <button type="button" onclick="openModalPreviewDoc(<?= $buku['id'] ?>, 'Buku LPJ <?= esc(addslashes($buku['bulan'] . ' ' . $buku['tahun'])) ?>')" class="px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-extrabold text-xs transition border border-emerald-200/90 shadow-2xs flex items-center gap-2" title="Preview Dokumen LPJ Langsung">
                    <i class="fa-solid fa-eye text-emerald-600"></i>
                    <span>Preview Dokumen</span>
                </button>

                <a href="<?= base_url('buku/cetak/' . $buku['id']) ?>" target="_blank" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-bold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 flex items-center gap-2 shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:-translate-y-0.5" title="Buka Halaman Cetak (Tab Baru)">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak / PDF</span>
                </a>
            </div>
        </div>

        <!-- Segmented Floating Tab Navbar (Mobile Horizontal Scrollable & Clean Desktop Tabs) -->
        <div class="mt-6">
            <div class="bg-white p-1.5 sm:p-2 rounded-2xl border border-slate-200/90 shadow-sm overflow-x-auto">
                <nav class="flex items-center gap-1.5 min-w-max">
                    <button onclick="switchTab('proker')" id="tab-proker" class="tab-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold transition-all duration-200 flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20 whitespace-nowrap">
                        <i class="fa-solid fa-calendar-days text-sm"></i>
                        <span>1. Proker & Kalender</span>
                    </button>

                    <button onclick="switchTab('koordinasi')" id="tab-koordinasi" class="tab-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-handshake text-sm"></i>
                        <span>2. Laporan Hasil Koordinasi</span>
                    </button>

                    <button onclick="switchTab('evaluasi')" id="tab-evaluasi" class="tab-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-building-user text-sm"></i>
                        <span>3. Capaian & Evaluasi Unit</span>
                    </button>

                    <button onclick="switchTab('kader')" id="tab-kader" class="tab-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-users-gear text-sm"></i>
                        <span>4. Evaluasi Kader Kebersihan</span>
                    </button>

                    <button onclick="switchTab('keuangan')" id="tab-keuangan" class="tab-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        <span>5. Laporan Keuangan</span>
                        <?php if (!empty($importedKeuangan)): ?>
                            <span class="tab-badge px-2 py-0.5 rounded-full bg-emerald-100 text-[10px] font-extrabold text-emerald-700 flex-shrink-0"><i class="fa-solid fa-check text-[9px] mr-0.5"></i> Terimport</span>
                        <?php else: ?>
                            <span class="tab-badge px-2 py-0.5 rounded-full bg-amber-100 text-[10px] font-extrabold text-amber-700 flex-shrink-0">Belum Import</span>
                        <?php endif; ?>
                    </button>
                </nav>
            </div>
        </div>
    </div>

    <!-- TAB 1: PROKER & KALENDER BULANAN -->
    <div id="content-proker" class="tab-content space-y-6">
        <!-- Visual Kalender Bulanan Interaktif (Dynamic Month & Day Alignment) -->
        <?php
            // Indonesian month translation map
            $bulanMap = [
                'Januari'   => 1,
                'Februari'  => 2,
                'Maret'     => 3,
                'April'     => 4,
                'Mei'       => 5,
                'Juni'      => 6,
                'Juli'      => 7,
                'Agustus'   => 8,
                'September' => 9,
                'Oktober'   => 10,
                'November'  => 11,
                'Desember'  => 12,
            ];

            $monthNum = $bulanMap[$buku['bulan']] ?? 9;
            $yearNum  = (int)$buku['tahun'];

            $firstDayTimestamp = strtotime(sprintf('%04d-%02d-01', $yearNum, $monthNum));
            $daysInMonth       = (int)date('t', $firstDayTimestamp);
            $startDayOfWeek    = (int)date('w', $firstDayTimestamp); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
        ?>
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <i class="fa-solid fa-calendar-check text-base"></i>
                        </div>
                        <div>
                            <h2 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">
                                Kalender Kegiatan: <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
                            </h2>
                            <p class="text-xs text-slate-500 font-medium">Tersusun otomatis sesuai jumlah hari & posisi tanggal bulan <?= esc($buku['bulan']) ?>.</p>
                        </div>
                    </div>
                </div>

                <!-- Legend Badges -->
                <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-50 text-cyan-700 border border-cyan-200/80 shadow-2xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 shadow-sm"></span> Koordinasi PJ
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm"></span> Koordinasi Sowan
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200/80 shadow-2xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-sm"></span> Koordinasi Kader
                    </span>
                </div>
            </div>

            <!-- Grid Calendar -->
            <div class="grid grid-cols-7 gap-2.5 text-center">
                <!-- Day Name Headers -->
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-rose-600 font-heading font-extrabold text-[11px] uppercase tracking-wider">MINGGU</div>
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-slate-700 font-heading font-extrabold text-[11px] uppercase tracking-wider">SENIN</div>
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-slate-700 font-heading font-extrabold text-[11px] uppercase tracking-wider">SELASA</div>
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-slate-700 font-heading font-extrabold text-[11px] uppercase tracking-wider">RABU</div>
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-slate-700 font-heading font-extrabold text-[11px] uppercase tracking-wider">KAMIS</div>
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-slate-700 font-heading font-extrabold text-[11px] uppercase tracking-wider">JUMAT</div>
                <div class="py-2.5 rounded-xl bg-slate-100/80 text-emerald-700 font-heading font-extrabold text-[11px] uppercase tracking-wider">SABTU</div>

                <!-- Empty Cells Before 1st Day -->
                <?php for ($e = 0; $e < $startDayOfWeek; $e++): ?>
                    <div class="min-h-[100px] p-2 rounded-2xl bg-slate-50/40 border border-dashed border-slate-200/60 opacity-40"></div>
                <?php endfor; ?>

                <!-- Day Cells -->
                <?php 
                    for ($d = 1; $d <= $daysInMonth; $d++) {
                        $currentDateFormatted = sprintf('%04d-%02d-%02d', $yearNum, $monthNum, $d);
                        
                        // Find matching agendas for date $d
                        $matchingAgendas = array_filter($proker, function($p) use ($yearNum, $monthNum, $d) {
                            $pTime = strtotime($p['tanggal']);
                            return (int)date('Y', $pTime) === $yearNum && (int)date('n', $pTime) === $monthNum && (int)date('j', $pTime) === $d;
                        });
                        $hasAgendas = !empty($matchingAgendas);

                        // Determine primary event category for matching cell styling
                        $cellBorderClass = 'bg-white border-slate-200/80 hover:border-slate-300 hover:shadow-xs';
                        $numBoxStyle     = '';
                        $pingDotStyle    = '';

                        if ($hasAgendas) {
                            $firstAg = reset($matchingAgendas);
                            $firstBadgeText = !empty($firstAg['kategori_badge']) ? $firstAg['kategori_badge'] : $firstAg['kegiatan'];
                            
                            $cellPJ    = stripos($firstBadgeText, 'PJ') !== false;
                            $cellSowan = stripos($firstBadgeText, 'Sowan') !== false;
                            $cellKader = stripos($firstBadgeText, 'Kader') !== false;

                            if ($cellPJ) {
                                $cellBorderClass = 'bg-cyan-50/30 border-cyan-300 hover:border-cyan-500 shadow-sm';
                                $numBoxStyle     = 'background-color: #06b6d4 !important; color: #ffffff !important;';
                                $pingDotStyle    = 'background-color: #06b6d4 !important;';
                            } elseif ($cellSowan) {
                                $cellBorderClass = 'bg-emerald-50/30 border-emerald-300 hover:border-emerald-500 shadow-sm';
                                $numBoxStyle     = 'background-color: #10b981 !important; color: #ffffff !important;';
                                $pingDotStyle    = 'background-color: #10b981 !important;';
                            } elseif ($cellKader) {
                                $cellBorderClass = 'bg-rose-50/30 border-rose-300 hover:border-rose-500 shadow-sm';
                                $numBoxStyle     = 'background-color: #f43f5e !important; color: #ffffff !important;';
                                $pingDotStyle    = 'background-color: #f43f5e !important;';
                            } else {
                                $cellBorderClass = 'bg-sky-50/30 border-sky-300 hover:border-sky-500 shadow-sm';
                                $numBoxStyle     = 'background-color: #0284c7 !important; color: #ffffff !important;';
                                $pingDotStyle    = 'background-color: #0284c7 !important;';
                            }
                        }
                ?>
                    <div class="min-h-[100px] p-2 rounded-2xl border transition-all duration-200 flex flex-col justify-between text-left group relative <?= $cellBorderClass ?>">
                        
                        <div class="flex items-center justify-between">
                            <span class="w-6 h-6 rounded-lg flex items-center justify-center font-heading font-extrabold text-xs <?= $hasAgendas ? 'shadow-xs' : 'text-slate-700 bg-slate-100/80' ?>"
                                  style="<?= $numBoxStyle ?>">
                                <?= $d ?>
                            </span>
                            <?php if ($hasAgendas): ?>
                                <span class="w-2 h-2 rounded-full animate-ping" style="<?= $pingDotStyle ?>"></span>
                            <?php endif; ?>
                        </div>

                        <!-- Agenda Items Inside Date Cell -->
                        <div class="space-y-1 mt-1.5 overflow-hidden">
                            <?php foreach ($matchingAgendas as $ag): 
                                $badgeText = !empty($ag['kategori_badge']) ? $ag['kategori_badge'] : $ag['kegiatan'];
                                $isPJ    = stripos($badgeText, 'PJ') !== false;
                                $isSowan = stripos($badgeText, 'Sowan') !== false;
                                $isKader = stripos($badgeText, 'Kader') !== false;

                                $inlineBg = $isPJ 
                                    ? 'background-color: #06b6d4 !important; color: #ffffff !important;' 
                                    : ($isSowan 
                                        ? 'background-color: #10b981 !important; color: #ffffff !important;' 
                                        : ($isKader 
                                            ? 'background-color: #f43f5e !important; color: #ffffff !important;' 
                                            : 'background-color: #0284c7 !important; color: #ffffff !important;'));
                            ?>
                                <div class="px-2 py-1 rounded-lg text-[10px] font-extrabold shadow-xs truncate transition-all hover:scale-[1.02] cursor-pointer"
                                    style="<?= $inlineBg ?>"
                                    title="<?= esc($ag['kegiatan']) ?>: <?= esc($ag['keterangan']) ?>">
                                    <i class="fa-solid fa-circle text-[5px] mr-1 opacity-90"></i>
                                    <?= esc($badgeText) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Section Add Agenda & Table (High Aesthetic Design) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">
            <!-- Form Tambah Agenda (Left Card) -->
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 tracking-tight">Tambah Agenda Proker</h3>
                        <p class="text-xs text-slate-500 font-medium">Input agenda kegiatan baru ke dalam kalender.</p>
                    </div>
                </div>

                <form action="<?= base_url('buku/proker/store/' . $buku['id']) ?>" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Kegiatan</label>
                        <div class="relative">
                            <input type="date" name="tanggal" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Badge Kalender</label>
                        <select name="kategori_badge" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs">
                            <option value="Koordinasi PJ">🩵 Koordinasi PJ (Cyan)</option>
                            <option value="Koordinasi Sowan">💚 Koordinasi Sowan (Hijau)</option>
                            <option value="Koordinasi Kader">🩷 Koordinasi Kader (Merah)</option>
                            <option value="Lainnya">💙 Lainnya (Biru)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kegiatan</label>
                        <input type="text" name="kegiatan" placeholder="Misal: Koordinasi Dengan Pengurus" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan / Detail Agenda</label>
                        <textarea name="keterangan" rows="3" placeholder="Tuliskan penjelasan singkat kegiatan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Simpan Agenda Proker</span>
                    </button>
                </form>
            </div>

            <!-- Tabel Agenda Proker (Right Card) -->
            <div class="lg:col-span-2 glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i class="fa-solid fa-list-check text-base"></i>
                        </div>
                        <div>
                            <h3 class="font-heading font-extrabold text-lg text-slate-900 tracking-tight">Tabel Program Kerja Kebersihan</h3>
                            <p class="text-xs text-slate-500 font-medium">Daftar agenda kegiatan yang tersimpan.</p>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/80">
                        <i class="fa-solid fa-layer-group text-[10px] text-emerald-600"></i>
                        <?= count($proker) ?> Agenda
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100/90 text-slate-600 font-heading font-extrabold uppercase text-[10px] tracking-wider">
                                <th class="p-3.5 rounded-l-2xl">No</th>
                                <th class="p-3.5">Tanggal</th>
                                <th class="p-3.5">Kegiatan</th>
                                <th class="p-3.5">Keterangan</th>
                                <th class="p-3.5 text-center rounded-r-2xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                                <?php if (!empty($proker)): ?>
                                    <?php foreach ($proker as $idx => $p): 
                                        $bText  = $p['kategori_badge'];
                                        $bPJ    = stripos($bText, 'PJ') !== false;
                                        $bSowan = stripos($bText, 'Sowan') !== false;
                                        $bKader = stripos($bText, 'Kader') !== false;

                                        $numBadgeStyle = $bPJ 
                                            ? 'background-color: #06b6d4 !important; color: #ffffff !important;' 
                                            : ($bSowan 
                                                ? 'background-color: #10b981 !important; color: #ffffff !important;' 
                                                : ($bKader 
                                                    ? 'background-color: #f43f5e !important; color: #ffffff !important;' 
                                                    : 'background-color: #0284c7 !important; color: #ffffff !important;'));
                                    ?>
                                        <tr class="hover:bg-emerald-50/30 transition-all duration-150">
                                            <td class="p-3.5">
                                                <span class="w-7 h-7 rounded-xl font-extrabold text-xs flex items-center justify-center shadow-xs" style="<?= $numBadgeStyle ?>" title="Kategori: <?= esc($p['kategori_badge']) ?>">
                                                    <?= $idx + 1 ?>
                                                </span>
                                            </td>
                                        <td class="p-3.5 font-extrabold text-slate-800 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-calendar-day text-emerald-600 text-xs"></i>
                                                <?= date('d M Y', strtotime($p['tanggal'])) ?>
                                            </div>
                                        </td>
                                        <td class="p-3.5 font-bold text-slate-900">
                                            <span class="text-slate-900 font-extrabold text-xs"><?= esc($p['kegiatan']) ?></span>
                                        </td>
                                        <td class="p-3.5 text-slate-600 leading-relaxed font-medium"><?= esc($p['keterangan']) ?></td>
                                        <td class="p-3.5 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <button onclick="openModalEditProker(<?= $p['id'] ?>, '<?= esc($p['tanggal']) ?>', '<?= esc(addslashes($p['kategori_badge'])) ?>', '<?= esc(addslashes($p['kegiatan'])) ?>', '<?= esc(addslashes($p['keterangan'])) ?>')" class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white transition-all flex items-center justify-center text-xs shadow-2xs" title="Edit Agenda">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <a href="<?= base_url('buku/proker/delete/' . $p['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus agenda ini?" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center text-xs shadow-2xs" title="Hapus Agenda">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-slate-400 font-medium italic">
                                        <i class="fa-solid fa-calendar-xmark text-2xl text-slate-300 mb-2 block"></i>
                                        Belum ada agenda proker tersimpan. Silakan isi form di sebelah kiri.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CARD 1: TARGET UTAMA KEBERSIHAN BULAN INI (SINGLE-COLUMN REPEATER) -->
        <form action="<?= base_url('buku/target/store/' . $buku['id']) ?>" method="POST" class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                        <i class="fa-solid fa-bullseye text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 tracking-tight">Target Utama Kebersihan Bulan Ini</h3>
                        <p class="text-xs text-slate-500 font-medium">Klik "Tambah Target" untuk menambahkan poin-poin target spesifik kebersihan bulan ini.</p>
                    </div>
                </div>

                <button type="button" onclick="addTargetRow()" class="py-2.5 px-4 rounded-2xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-heading font-extrabold text-xs transition border border-emerald-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Target</span>
                </button>
            </div>

            <div id="targetContainer" class="space-y-3">
                <?php 
                $targetList = !empty($targets) ? $targets : [['target_text' => '']];
                foreach ($targetList as $idx => $tg): 
                    $tId = 'target_' . $idx . '_' . time();
                ?>
                    <div id="<?= $tId ?>" class="target-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <textarea name="target_text[]" rows="2" placeholder="Tuliskan poin target kebersihan bulan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($tg['target_text'] ?? '') ?></textarea>
                        <button type="button" onclick="removeRowElement('<?= $tId ?>', '.target-row', 'targetContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="py-3 px-7 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>Simpan Target Utama</span>
                </button>
            </div>
        </form>

        <!-- CARD 2: CAPAIAN UTAMA KEBERSIHAN BULAN INI (SINGLE-COLUMN REPEATER) -->
        <form action="<?= base_url('buku/capaian/store/' . $buku['id']) ?>" method="POST" class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-teal-600 to-emerald-500 text-white flex items-center justify-center shadow-lg shadow-teal-500/20 flex-shrink-0">
                        <i class="fa-solid fa-trophy text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">Capaian Utama Kebersihan Bulan Ini</h3>
                        <p class="text-xs text-slate-500 font-medium">Klik "Tambah Capaian" untuk menambahkan poin-poin realisasi/capaian kebersihan yang telah terlaksana.</p>
                    </div>
                </div>

                <button type="button" onclick="addCapaianRow()" class="py-2.5 px-4 rounded-2xl bg-teal-50 text-teal-700 hover:bg-teal-100 font-heading font-extrabold text-xs transition border border-teal-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Capaian</span>
                </button>
            </div>

            <div id="capaianContainer" class="space-y-3">
                <?php 
                $capList = !empty($capaianList) ? $capaianList : [['capaian_text' => '']];
                foreach ($capList as $idx => $cp): 
                    $cpId = 'capaian_' . $idx . '_' . time();
                ?>
                    <div id="<?= $cpId ?>" class="capaian-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-teal-100 text-teal-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <textarea name="capaian_text[]" rows="2" placeholder="Tuliskan poin realisasi/capaian kebersihan bulan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($cp['capaian_text'] ?? '') ?></textarea>
                        <button type="button" onclick="removeRowElement('<?= $cpId ?>', '.capaian-row', 'capaianContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="py-3 px-7 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-heading font-extrabold text-xs hover:from-teal-700 hover:to-emerald-700 transition-all duration-200 shadow-md shadow-teal-600/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>Simpan Capaian Utama</span>
                </button>
            </div>
        </form>

        <!-- CARD 3: EVALUASI UTAMA KEBERSIHAN BULAN INI (SINGLE-COLUMN REPEATER) -->
        <form action="<?= base_url('buku/evaluasi-bulanan/store/' . $buku['id']) ?>" method="POST" class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/20 flex-shrink-0">
                        <i class="fa-solid fa-clipboard-check text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">Evaluasi Utama Kebersihan Bulan Ini</h3>
                        <p class="text-xs text-slate-500 font-medium">Klik "Tambah Evaluasi" untuk menambahkan catatan evaluasi, kendala, atau hal yang perlu dibenahi.</p>
                    </div>
                </div>

                <button type="button" onclick="addEvaluasiRow()" class="py-2.5 px-4 rounded-2xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-heading font-extrabold text-xs transition border border-amber-200/80 flex items-center gap-2 shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Tambah Evaluasi</span>
                </button>
            </div>

            <div id="evaluasiContainer" class="space-y-3">
                <?php 
                $evalList = !empty($evaluasiBulananList) ? $evaluasiBulananList : [['evaluasi_text' => '']];
                foreach ($evalList as $idx => $evB): 
                    $evId = 'evaluasi_' . $idx . '_' . time();
                ?>
                    <div id="<?= $evId ?>" class="evaluasi-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                        <span class="num-badge w-7 h-7 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                            <?= $idx + 1 ?>
                        </span>
                        <textarea name="evaluasi_text[]" rows="2" placeholder="Tuliskan catatan evaluasi kebersihan bulan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white transition shadow-2xs leading-relaxed"><?= esc($evB['evaluasi_text'] ?? '') ?></textarea>
                        <button type="button" onclick="removeRowElement('<?= $evId ?>', '.evaluasi-row', 'evaluasiContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="py-3 px-7 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-heading font-extrabold text-xs hover:from-amber-600 hover:to-orange-600 transition-all duration-200 shadow-md shadow-amber-500/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>Simpan Evaluasi Utama</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2: LAPORAN HASIL KOORDINASI (PROKER AGENDA CARDS) -->
    <div id="content-koordinasi" class="tab-content hidden space-y-6">
        <!-- Header Info Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-handshake text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">Laporan Hasil Koordinasi Program Kerja</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Kelola detail <b>Bersama</b>, <b>Tempat</b>, <b>Foto Dokumentasi</b>, dan <b>Hasil Materi</b> untuk setiap agenda proker bulan ini.</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/80">
                <i class="fa-solid fa-layer-group text-[10px] text-emerald-600"></i>
                <?= count($proker) ?> Agenda Proker
            </span>
        </div>

        <!-- Proker Agenda Cards List -->
        <?php if (!empty($proker)): ?>
            <div class="space-y-6">
                <?php foreach ($proker as $idx => $p): 
                    $kData = $koordinasiMap[$p['id']] ?? null;
                    $isFilled = $kData && (!empty($kData['tempat']) || !empty($kData['bersama']) || !empty($kData['hasil_materi']) || !empty($kData['foto']));

                    $bText  = $p['kategori_badge'];
                    $bPJ    = stripos($bText, 'PJ') !== false;
                    $bSowan = stripos($bText, 'Sowan') !== false;
                    $bKader = stripos($bText, 'Kader') !== false;

                    $badgeStyle = $bPJ 
                        ? 'background-color: #06b6d4 !important; color: #ffffff !important;' 
                        : ($bSowan 
                            ? 'background-color: #10b981 !important; color: #ffffff !important;' 
                            : ($bKader 
                                ? 'background-color: #f43f5e !important; color: #ffffff !important;' 
                                : 'background-color: #0284c7 !important; color: #ffffff !important;'));
                ?>
                    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg shadow-slate-200/30 border border-slate-200/80 bg-white space-y-5">
                        <!-- Card Header Info -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div class="flex items-start sm:items-center gap-3">
                                <span class="w-8 h-8 rounded-xl font-extrabold text-xs flex items-center justify-center flex-shrink-0 shadow-xs" style="<?= $badgeStyle ?>">
                                    <?= $idx + 1 ?>
                                </span>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold shadow-2xs" style="<?= $badgeStyle ?>">
                                            <?= esc($p['kategori_badge']) ?>
                                        </span>
                                        <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                                            <i class="fa-solid fa-calendar-day text-emerald-600"></i>
                                            <?= date('d M Y', strtotime($p['tanggal'])) ?>
                                        </span>
                                    </div>
                                    <h4 class="font-heading font-extrabold text-slate-900 text-base sm:text-lg leading-snug">
                                        <?= esc($p['kegiatan']) ?>
                                    </h4>
                                </div>
                            </div>

                            <div class="self-start sm:self-center">
                                <?php if ($isFilled): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200 shadow-2xs">
                                        <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i> Laporan Terisi
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold shadow-2xs">
                                        <i class="fa-solid fa-clock text-slate-400 text-xs"></i> Belum Diisi
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card Form -->
                        <form action="<?= base_url('buku/koordinasi/store/' . $buku['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                            <input type="hidden" name="proker_id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="kegiatan" value="<?= esc($p['kegiatan']) ?>">
                            <input type="hidden" name="hari_tanggal" value="<?= date('d M Y', strtotime($p['tanggal'])) ?>">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Bersama (Pihak Terkait)</label>
                                    <input type="text" name="bersama" value="<?= esc($kData['bersama'] ?? '') ?>" placeholder="Misal: Get Plastic Jogja / Pengurus Asrama" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tempat / Lokasi</label>
                                    <input type="text" name="tempat" value="<?= esc($kData['tempat'] ?? '') ?>" placeholder="Misal: Ndalem Pak KH. Chasan" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Hasil / Materi Koordinasi</label>
                                    <textarea name="hasil_materi" rows="3" placeholder="Tuliskan poin-poin hasil koordinasi..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/80 focus:bg-white transition-all shadow-2xs leading-relaxed"><?= esc($kData['hasil_materi'] ?? '') ?></textarea>
                                </div>

                                <div class="space-y-2 pt-2 border-t border-slate-100">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">Dokumentasi Foto Kegiatan</label>
                                        <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-arrows-up-down-left-right text-emerald-600 mr-1"></i> Klik & Geser foto untuk sesuaikan posisi</span>
                                    </div>
                                    
                                    <input type="hidden" name="foto_position" id="foto_pos_<?= $p['id'] ?>" value="<?= esc($kData['foto_position'] ?? '50% 50%') ?>">

                                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-center">
                                        <!-- Draggable Image Box (16:9 Aspect Ratio) -->
                                        <div class="sm:col-span-2">
                                            <div id="container_preview_<?= $p['id'] ?>" class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm group flex items-center justify-center cursor-grab select-none">
                                                <?php if (!empty($kData['foto'])): ?>
                                                    <img id="img_preview_<?= $p['id'] ?>" src="<?= image_url($kData['foto'], 'uploads') ?>" alt="Foto Dokumentasi" class="w-full h-full object-cover transition-all duration-75" style="object-position: <?= esc($kData['foto_position'] ?? '50% 50%') ?>;">
                                                    <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-1.5 pointer-events-none">
                                                        <a href="<?= image_url($kData['foto'], 'uploads') ?>" target="_blank" class="pointer-events-auto px-2.5 py-1 bg-white/90 text-slate-900 rounded-xl text-[10px] font-bold shadow-md hover:bg-white transition">
                                                            <i class="fa-solid fa-up-right-from-square"></i> Perbesar
                                                        </a>
                                                        <button type="button" onclick="resetPhotoPosition('img_preview_<?= $p['id'] ?>', 'foto_pos_<?= $p['id'] ?>')" class="pointer-events-auto px-2.5 py-1 bg-slate-900/80 text-white rounded-xl text-[10px] font-bold shadow-md hover:bg-slate-900 transition">
                                                            <i class="fa-solid fa-rotate-left"></i> Reset
                                                        </button>
                                                        <a href="<?= base_url('buku/koordinasi/delete-foto/' . $kData['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus foto dokumentasi ini?" class="pointer-events-auto px-2.5 py-1 bg-rose-600/90 text-white rounded-xl text-[10px] font-bold shadow-md hover:bg-rose-700 transition" title="Hapus Foto">
                                                            <i class="fa-solid fa-trash"></i> Hapus
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <img id="img_preview_<?= $p['id'] ?>" src="" alt="Pratinjau Foto" class="w-full h-full object-cover hidden transition-all duration-75" style="object-position: 50% 50%;">
                                                    <div id="placeholder_<?= $p['id'] ?>" class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                                        <i class="fa-solid fa-image text-2xl mb-1 text-slate-300"></i>
                                                        <span class="text-[11px] font-semibold">Belum Ada Foto (16:9)</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- File Upload Selector -->
                                        <div class="sm:col-span-3 space-y-2">
                                            <div class="flex items-center gap-2">
                                                <input type="file" name="foto" accept="image/*" onchange="previewImageLive(this, 'img_preview_<?= $p['id'] ?>', 'placeholder_<?= $p['id'] ?>', 'container_preview_<?= $p['id'] ?>', 'foto_pos_<?= $p['id'] ?>')" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition shadow-2xs">
                                                <?php if (!empty($kData['foto'])): ?>
                                                    <a href="<?= base_url('buku/koordinasi/delete-foto/' . $kData['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus foto dokumentasi ini?" class="px-3.5 py-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all text-xs font-bold flex items-center gap-1.5 shadow-2xs flex-shrink-0" title="Hapus Foto">
                                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                                        <span>Hapus Foto</span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-[11px] text-slate-400 font-medium leading-relaxed">Pilih foto (JPG, PNG, WEBP). Foto akan otomatis disesuaikan dalam rasio **16:9**. Anda dapat **mengklik dan menggeser foto** di kotak pratinjau untuk menata posisi gambar.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit" class="py-2.5 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                                    <span>Simpan Laporan Koordinasi</span>
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-12 rounded-3xl bg-white text-center border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <p class="text-xs text-slate-500 font-medium italic">Belum ada agenda program kerja di Tab 1. Silakan tambahkan agenda proker terlebih dahulu.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- TAB 3: CAPAIAN & EVALUASI UNIT -->
    <div id="content-evaluasi" class="tab-content hidden space-y-6">
        <!-- Header & Action Bar -->
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-building-user text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">Input Realisasi, Capaian & Permasalahan Unit</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Pilih unit Asrama atau Sekolah di bawah untuk mengisikan lembar capaian dan evaluasi kebersihan.</p>
                </div>
            </div>
        </div>

        <!-- Grid Cards Unit -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($units as $unit): 
                $evData = $evaluasiMap[$unit['id']] ?? null;
                $isAsrama = stripos($unit['tipe'] ?? $unit['kategori'] ?? '', 'Asrama') !== false;
            ?>
                <div class="glass-card rounded-3xl p-6 border border-slate-200/80 bg-white shadow-lg shadow-slate-200/30 flex flex-col justify-between space-y-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <span class="px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider <?= $isAsrama ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/60' : 'bg-teal-50 text-teal-700 border border-teal-200/60' ?>">
                                <i class="fa-solid <?= $isAsrama ? 'fa-house-user' : 'fa-school' ?> mr-1"></i>
                                <?= esc($unit['tipe'] ?? $unit['kategori'] ?? 'Unit') ?>
                            </span>

                            <div class="flex items-center gap-2">
                                <?php if ($evData): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i> Terisi
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400">
                                        Belum diisi
                                    </span>
                                <?php endif; ?>

                                <a href="<?= base_url('buku/unit/delete/' . $unit['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus unit kebersihan ini?" class="w-7 h-7 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center text-xs transition" title="Hapus Unit">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <h4 class="font-heading font-extrabold text-slate-900 text-lg leading-snug">
                            <?= esc($unit['nama_unit']) ?>
                        </h4>

                    </div>

                    <a href="<?= base_url('buku/evaluasi/form/' . $buku['id'] . '/' . $unit['id']) ?>" class="w-full py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Isi / Edit Laporan Unit</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- TAB 4: EVALUASI KADER KEBERSIHAN (GEMERLAP & SATGAS) -->
    <div id="content-kader" class="tab-content hidden space-y-6">
        <!-- Header & Action Bar -->
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-users-gear text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">Evaluasi Kader Kebersihan (GEMERLAP & Satgas)</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Kelola lembar evaluasi kader <b>GEMERLAP</b> (Asrama) dan <b>Satgas Kebersihan</b> (Sekolah).</p>
                </div>
            </div>
        </div>

        <!-- Grid Cards Unit Kader -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($kaderUnits as $kUnit): 
                $evData = $evaluasiMap[$kUnit['id']] ?? null;
                $isAsrama = stripos($kUnit['nama_unit'] . ' ' . $kUnit['tipe'], 'Asrama') !== false || stripos($kUnit['nama_unit'], 'Gemerlap') !== false;
                $badgeName = $isAsrama ? 'GEMERLAP Asrama' : 'Satgas Sekolah';
            ?>
                <div class="glass-card rounded-3xl p-6 border border-slate-200/80 bg-white shadow-lg shadow-slate-200/30 flex flex-col justify-between space-y-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <span class="px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider <?= $isAsrama ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-teal-50 text-teal-700 border border-teal-200/60' ?>">
                                <i class="fa-solid <?= $isAsrama ? 'fa-leaf' : 'fa-shield-halved' ?> mr-1"></i>
                                <?= $badgeName ?>
                            </span>

                            <div class="flex items-center gap-2">
                                <?php if ($evData): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i> Terisi
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400">
                                        Belum diisi
                                    </span>
                                <?php endif; ?>

                                <a href="<?= base_url('buku/unit/delete/' . $kUnit['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus unit kader ini?" class="w-7 h-7 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center text-xs transition" title="Hapus Unit Kader">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <h4 class="font-heading font-extrabold text-slate-900 text-lg leading-snug">
                            <?= esc($kUnit['nama_unit']) ?>
                        </h4>
                    </div>

                    <a href="<?= base_url('buku/evaluasi/form/' . $buku['id'] . '/' . $kUnit['id']) ?>" class="w-full py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Isi / Edit Laporan Kader</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- TAB 5: LAPORAN KEUANGAN KEBERSIHAN (IMPORTED) -->
    <div id="content-keuangan" class="tab-content hidden space-y-6">
        <?php if (!empty($importedKeuangan)): ?>
            <?php
                $totalPlafon   = 0;
                $totalTerserap = 0;
                foreach ($keuanganPembelian as $kp) {
                    $totalPlafon   += (float)$kp['plafon'];
                    $totalTerserap += (float)$kp['terserap'];
                }
                $totalSaldoAkhir = $totalPlafon - $totalTerserap;

                $totalDanaMasuk = 0;
                foreach ($keuanganMasuk as $km) {
                    $totalDanaMasuk += (float)$km['nominal'];
                }

                $saldoSisaBulan = $totalDanaMasuk - $totalTerserap;
            ?>

            <!-- Header Banner Imported Keuangan -->
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold border border-emerald-200">
                                    <i class="fa-solid fa-barcode mr-1"></i><?= esc($importedKeuangan['kode_keuangan']) ?>
                                </span>
                                <span class="text-xs text-emerald-700 font-extrabold flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> Terimport Sempurna
                                </span>
                            </div>
                            <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight"><?= esc($importedKeuangan['judul']) ?></h3>
                            <p class="text-xs text-slate-500 font-medium">Periode: <b><?= esc($importedKeuangan['bulan'] . ' ' . $importedKeuangan['tahun']) ?></b></p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <a href="<?= base_url('keuangan/detail/' . $importedKeuangan['id']) ?>" target="_blank" class="px-4 py-2.5 rounded-2xl bg-emerald-50 text-emerald-700 font-extrabold text-xs hover:bg-emerald-100 transition border border-emerald-200 shadow-2xs flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>Edit Keuangan Utama</span>
                        </a>

                        <button type="button" onclick="openModalImportKeuangan()" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-extrabold text-xs hover:bg-slate-200 transition border border-slate-200 shadow-2xs flex items-center gap-2">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span>Ubah Import</span>
                        </button>

                        <a href="<?= base_url('buku/keuangan/unlink/' . $buku['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin memutuskan tautan Laporan Keuangan dari LPJ ini?" class="px-3.5 py-2.5 rounded-2xl bg-rose-50 text-rose-600 font-extrabold text-xs hover:bg-rose-100 transition border border-rose-200 shadow-2xs flex items-center gap-1.5" title="Putuskan Tautan">
                            <i class="fa-solid fa-link-slash"></i>
                        </a>
                    </div>
                </div>

                <!-- Summary Cards Row -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-2xl bg-blue-50/80 border border-blue-200/70 space-y-1">
                        <span class="text-[10px] font-extrabold text-blue-800 uppercase tracking-wider block">Total Dana Masuk (Anggaran)</span>
                        <p class="font-heading font-extrabold text-blue-900 text-lg">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></p>
                    </div>
                    <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200/70 space-y-1">
                        <span class="text-[10px] font-extrabold text-amber-800 uppercase tracking-wider block">Total Plafon Anggaran</span>
                        <p class="font-heading font-extrabold text-amber-900 text-lg">Rp <?= number_format($totalPlafon, 0, ',', '.') ?></p>
                    </div>
                    <div class="p-4 rounded-2xl bg-rose-50/80 border border-rose-200/70 space-y-1">
                        <span class="text-[10px] font-extrabold text-rose-800 uppercase tracking-wider block">Total Realisasi Terserap</span>
                        <p class="font-heading font-extrabold text-rose-900 text-lg">Rp <?= number_format($totalTerserap, 0, ',', '.') ?></p>
                    </div>
                    <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/70 space-y-1">
                        <span class="text-[10px] font-extrabold text-emerald-800 uppercase tracking-wider block">Saldo Sisa Bulan Ini</span>
                        <p class="font-heading font-extrabold text-emerald-900 text-lg">Rp <?= number_format($saldoSisaBulan, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>

            <!-- 1. TABEL LAPORAN KEUANGAN KEBERSIHAN (ITEM PEMBELIAN) -->
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
                <h4 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-receipt text-emerald-600"></i> LAPORAN KEUANGAN KEBERSIHAN (ITEM PEMBELIAN)
                </h4>

                <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                    <table class="w-full text-left text-xs font-semibold">
                        <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th width="5%" class="py-3 px-3 text-center">NO</th>
                                <th width="45%" class="py-3 px-4">ITEM PEMBELIAN</th>
                                <th width="20%" class="py-3 px-4 text-right">PLAFON</th>
                                <th width="20%" class="py-3 px-4 text-right">TERSERAP</th>
                                <th width="20%" class="py-3 px-4 text-right">SALDO AKHIR</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <?php if (!empty($keuanganPembelian)): ?>
                                <?php foreach ($keuanganPembelian as $idx => $kp): 
                                    $sAkhir = (float)$kp['plafon'] - (float)$kp['terserap'];
                                ?>
                                    <tr class="hover:bg-slate-50/80 transition-all">
                                        <td class="py-3 px-3 text-center font-extrabold text-slate-500"><?= $idx + 1 ?></td>
                                        <td class="py-3 px-4 text-slate-900 font-extrabold"><?= esc($kp['item_pembelian']) ?></td>
                                        <td class="py-3 px-4 text-right font-extrabold text-amber-700">Rp <?= number_format($kp['plafon'], 0, ',', '.') ?></td>
                                        <td class="py-3 px-4 text-right font-extrabold text-rose-700">Rp <?= number_format($kp['terserap'], 0, ',', '.') ?></td>
                                        <td class="py-3 px-4 text-right font-extrabold text-emerald-700">Rp <?= number_format($sAkhir, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 font-medium italic">Belum ada data item pembelian.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="bg-slate-100/90 font-heading font-extrabold text-xs text-slate-900 border-t-2 border-slate-200">
                            <tr>
                                <td colspan="2" class="py-3.5 px-4 uppercase text-right tracking-wider">JUMLAH SALDO</td>
                                <td class="py-3.5 px-4 text-right bg-amber-100/80 text-amber-900 border-x border-amber-200">Rp <?= number_format($totalPlafon, 0, ',', '.') ?></td>
                                <td class="py-3.5 px-4 text-right bg-rose-100/80 text-rose-900 border-r border-rose-200">Rp <?= number_format($totalTerserap, 0, ',', '.') ?></td>
                                <td class="py-3.5 px-4 text-right bg-emerald-100/80 text-emerald-900 border-r border-emerald-200">Rp <?= number_format($totalSaldoAkhir, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- SALDO SISA BULAN BANNER -->
            <div class="rounded-3xl p-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h5 class="font-heading font-extrabold text-base tracking-tight">SALDO SISA BULAN <?= strtoupper(esc($importedKeuangan['bulan'])) ?></h5>
                        <p class="text-xs text-blue-100 font-medium">Formula: Total Dana Masuk (Anggaran) − Total Realisasi Terserap</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-heading font-extrabold text-2xl text-white tracking-wide">
                        Rp <?= number_format($saldoSisaBulan, 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <!-- 2. TABEL INFORMASI DANA MASUK -->
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
                <h4 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-piggy-bank text-emerald-600"></i> INFORMASI DANA MASUK
                </h4>

                <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                    <table class="w-full text-left text-xs font-semibold">
                        <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th width="5%" class="py-3 px-3 text-center">NO</th>
                                <th width="35%" class="py-3 px-4">SUMBER DANA</th>
                                <th width="15%" class="py-3 px-4 text-right">NOMINAL</th>
                                <th width="45%" class="py-3 px-4">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <?php if (!empty($keuanganMasuk)): ?>
                                <?php foreach ($keuanganMasuk as $idx => $km): ?>
                                    <tr class="hover:bg-slate-50/80 transition-all">
                                        <td class="py-3 px-3 text-center font-extrabold text-slate-500"><?= $idx + 1 ?></td>
                                        <td class="py-3 px-4 text-slate-900 font-extrabold"><?= esc($km['sumber_dana']) ?></td>
                                        <td class="py-3 px-4 text-right font-extrabold text-blue-700">Rp <?= number_format($km['nominal'], 0, ',', '.') ?></td>
                                        <td class="py-3 px-4 text-slate-600"><?= esc($km['keterangan']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400 font-medium italic">Belum ada data dana masuk.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="bg-slate-100/90 font-heading font-extrabold text-xs text-slate-900 border-t-2 border-slate-200">
                            <tr>
                                <td colspan="2" class="py-3.5 px-4 uppercase text-right tracking-wider">TOTAL INFORMASI DANA MASUK</td>
                                <td class="py-3.5 px-4 text-right bg-blue-100/80 text-blue-900 border-x border-blue-200">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <!-- Placeholder When No Keuangan Imported -->
            <div class="glass-card rounded-3xl p-10 sm:p-12 text-center shadow-xl border border-slate-200/80 bg-white space-y-5 max-w-2xl mx-auto">
                <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto text-3xl shadow-inner border border-amber-200/60">
                    <i class="fa-solid fa-file-circle-exclamation"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="font-heading font-extrabold text-xl text-slate-900">Belum Ada Laporan Keuangan Terimport</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Silakan import dan tautkan Laporan Keuangan dari menu utama Keuangan untuk menyelaraskan arus kas pada LPJ ini.
                    </p>
                </div>
                <button type="button" onclick="openModalImportKeuangan()" class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-lg shadow-emerald-600/20 hover:-translate-y-0.5 flex items-center gap-2 mx-auto">
                    <i class="fa-solid fa-file-import"></i>
                    <span>Import Laporan Keuangan Sekarang</span>
                </button>
            </div>
        <?php endif; ?>
    </div>

<!-- Modal Import Laporan Keuangan -->
<div id="modalImportKeuangan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-file-import"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">Import Laporan Keuangan</h3>
                    <p class="text-xs text-slate-500">Tautkan data keuangan berdasarkan Kode atau Bulan & Tahun</p>
                </div>
            </div>
            <button onclick="closeModalImportKeuangan()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('buku/keuangan/import/' . $buku['id']) ?>" method="POST" class="space-y-4">
            <!-- Option 1: Choose from existing Keuangan Books Dropdown -->
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">1. Pilih Dari Daftar Buku Keuangan</label>
                <select name="keuangan_id" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    <option value="">-- Pilih Buku Keuangan --</option>
                    <?php if (!empty($allKeuanganBooks)): ?>
                        <?php foreach ($allKeuanganBooks as $kb): ?>
                            <option value="<?= $kb['id'] ?>" <?= (!empty($importedKeuangan) && $importedKeuangan['id'] == $kb['id']) ? 'selected' : '' ?>>
                                <?= esc($kb['kode_keuangan'] ?: 'KUG-' . $kb['tahun']) ?> &bull; <?= esc($kb['judul']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink mx-3 text-[10px] font-extrabold uppercase text-slate-400">Atau Gunakan Pencarian Kode</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <!-- Option 2: Enter Kode Keuangan manually -->
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">2. Ketik Kode Keuangan</label>
                <input type="text" name="kode_keuangan" placeholder="Misal: KUG-2026-08" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink mx-3 text-[10px] font-extrabold uppercase text-slate-400">Atau Pilih Bulan & Tahun</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <!-- Option 3: Select Bulan & Tahun -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Bulan</label>
                    <select name="bulan" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                        <option value="">-- Pilih Bulan --</option>
                        <?php
                        $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        foreach ($daftarBulan as $b) :
                        ?>
                            <option value="<?= $b ?>"><?= $b ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tahun</label>
                    <select name="tahun" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                        <option value="">-- Pilih Tahun --</option>
                        <?php
                        $tahunSekarang = date('Y');
                        for ($t = $tahunSekarang - 1; $t <= $tahunSekarang + 3; $t++) :
                        ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalImportKeuangan()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-file-import"></i>
                    <span>Import Laporan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Unit Kader Baru -->
<div id="modalTambahKader" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-emerald-600"></i> Tambah Unit Kader Baru
            </h3>
            <button onclick="closeModalTambahKader()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('buku/unit/store') ?>" method="POST" class="space-y-4">
            <input type="hidden" name="jenis_laporan" value="kader">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Unit Kader</label>
                <input type="text" name="nama_unit" placeholder="Misal: GEMERLAP Asrama Komplek B / Satgas Kebersihan MA" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Unit Kader</label>
                <select name="tipe" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50 focus:bg-white transition shadow-2xs">
                    <option value="Asrama">GEMERLAP (Asrama)</option>
                    <option value="Sekolah">Satgas Kebersihan (Sekolah)</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahKader()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Unit Kader</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Unit Baru -->
<div id="modalTambahUnit" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-emerald-600"></i> Tambah Unit Kebersihan Baru
            </h3>
            <button onclick="closeModalTambahUnit()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('buku/unit/store') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Unit Kebersihan</label>
                <input type="text" name="nama_unit" placeholder="Misal: Asrama Tahfidz Putra 2 / Kantin Utama" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tipe / Kategori Unit</label>
                <select name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50 focus:bg-white transition shadow-2xs">
                    <option value="Asrama">Asrama</option>
                    <option value="Sekolah">Sekolah</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahUnit()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Unit Baru</button>
            </div>
        </form>
    </div>
</div>
</div>



<!-- Modal Edit Agenda Proker -->
<div id="modalEditProker" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-7 shadow-2xl space-y-5 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900">Edit Agenda Proker</h3>
            </div>
            <button onclick="closeModalEditProker()" class="text-slate-400 hover:text-slate-600 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form id="formEditProker" action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tanggal Kegiatan</label>
                <input type="date" name="tanggal" id="edit_proker_tanggal" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori Badge Kalender</label>
                <select name="kategori_badge" id="edit_proker_kategori" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
                    <option value="Koordinasi PJ">🩵 Koordinasi PJ (Cyan)</option>
                    <option value="Koordinasi Sowan">💚 Koordinasi Sowan (Hijau)</option>
                    <option value="Koordinasi Kader">🩷 Koordinasi Kader (Merah)</option>
                    <option value="Lainnya">💙 Lainnya (Biru)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Kegiatan</label>
                <input type="text" name="kegiatan" id="edit_proker_kegiatan" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Keterangan / Detail Agenda</label>
                <textarea name="keterangan" id="edit_proker_keterangan" rows="3" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50"></textarea>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEditProker()" class="px-5 py-2.5 rounded-xl text-slate-600 text-xs font-semibold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 shadow-md shadow-emerald-500/20">Perbarui Agenda</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

        // Reset all tab button styles to inactive
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('bg-gradient-to-r', 'from-emerald-600', 'to-teal-600', 'text-white', 'shadow-md', 'shadow-emerald-600/20');
            el.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
            const badge = el.querySelector('.tab-badge');
            if (badge) {
                badge.classList.remove('bg-white/20', 'text-white');
                badge.classList.add('bg-slate-100', 'text-slate-600');
            }
        });

        // Show active content
        const targetContent = document.getElementById('content-' + tabName);
        if (targetContent) {
            targetContent.classList.remove('hidden');
            setTimeout(() => {
                if (typeof window.initAutoResizeTextareas === 'function') {
                    window.initAutoResizeTextareas();
                }
            }, 10);
        }

        // Apply active pill styles
        const activeBtn = document.getElementById('tab-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
            activeBtn.classList.add('bg-gradient-to-r', 'from-emerald-600', 'to-teal-600', 'text-white', 'shadow-md', 'shadow-emerald-600/20');
            const badge = activeBtn.querySelector('.tab-badge');
            if (badge) {
                badge.classList.remove('bg-slate-100', 'text-slate-600');
                badge.classList.add('bg-white/20', 'text-white');
            }
        }

        // Save active tab in sessionStorage & update URL
        try {
            sessionStorage.setItem('activeTab_lpj_<?= $buku['id'] ?>', tabName);
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabName);
            window.history.replaceState(null, '', url.toString());
        } catch (e) {}
    }
    window.switchTab = switchTab;

    // Restore active tab on DOM load (check URL parameter first, then sessionStorage)
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        const savedTab = sessionStorage.getItem('activeTab_lpj_<?= $buku['id'] ?>');

        const activeTab = tabParam || savedTab || 'proker';
        if (activeTab && document.getElementById('tab-' + activeTab)) {
            switchTab(activeTab);
        }
    });

    function openModalEditProker(id, tanggal, kategori, kegiatan, keterangan) {
        document.getElementById('formEditProker').action = '<?= base_url('buku/proker/update/') ?>' + id;
        document.getElementById('edit_proker_tanggal').value = tanggal;
        document.getElementById('edit_proker_kategori').value = kategori;
        document.getElementById('edit_proker_kegiatan').value = kegiatan;
        document.getElementById('edit_proker_keterangan').value = keterangan;
        document.getElementById('modalEditProker').classList.remove('hidden');
    }

    function closeModalEditProker() {
        document.getElementById('modalEditProker').classList.add('hidden');
    }

    function makePhotoBoxDraggable(containerId, imgId, posInputId) {
        const container = document.getElementById(containerId);
        const img = document.getElementById(imgId);
        const posInput = document.getElementById(posInputId);
        if (!container || !img) return;

        let isDragging = false;
        let startX = 0, startY = 0;
        let posX = 50, posY = 50;

        if (posInput && posInput.value) {
            const parts = posInput.value.split(' ');
            if (parts.length === 2) {
                posX = parseFloat(parts[0]) || 50;
                posY = parseFloat(parts[1]) || 50;
            }
        }

        const onStart = (clientX, clientY) => {
            if (img.classList.contains('hidden')) return;
            isDragging = true;
            startX = clientX;
            startY = clientY;
            container.style.cursor = 'grabbing';
        };

        const onMove = (clientX, clientY) => {
            if (!isDragging) return;
            const dx = clientX - startX;
            const dy = clientY - startY;
            startX = clientX;
            startY = clientY;

            posX = Math.max(0, Math.min(100, posX - (dx * 0.4)));
            posY = Math.max(0, Math.min(100, posY - (dy * 0.4)));

            img.style.objectPosition = `${posX.toFixed(1)}% ${posY.toFixed(1)}%`;
            if (posInput) posInput.value = `${posX.toFixed(1)}% ${posY.toFixed(1)}%`;
        };

        const onEnd = () => {
            if (isDragging) {
                isDragging = false;
                container.style.cursor = 'grab';
            }
        };

        container.onmousedown = (e) => { e.preventDefault(); onStart(e.clientX, e.clientY); };
        window.addEventListener('mousemove', (e) => onMove(e.clientX, e.clientY));
        window.addEventListener('mouseup', onEnd);

        container.ontouchstart = (e) => { if (e.touches[0]) onStart(e.touches[0].clientX, e.touches[0].clientY); };
        window.addEventListener('touchmove', (e) => { if (e.touches[0]) onMove(e.touches[0].clientX, e.touches[0].clientY); });
        window.addEventListener('touchend', onEnd);
    }

    function previewImageLive(input, imgId, placeholderId, containerId, posInputId) {
        const imgEl = document.getElementById(imgId);
        const phEl = document.getElementById(placeholderId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (imgEl) {
                    imgEl.src = e.target.result;
                    imgEl.classList.remove('hidden');
                }
                if (phEl) {
                    phEl.classList.add('hidden');
                }
                makePhotoBoxDraggable(containerId, imgId, posInputId);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetPhotoPosition(imgId, posInputId) {
        const imgEl = document.getElementById(imgId);
        const posInput = document.getElementById(posInputId);
        if (imgEl) imgEl.style.objectPosition = '50% 50%';
        if (posInput) posInput.value = '50% 50%';
    }

    function rebindPageEvents() {
        // 1. Restore active tab from URL parameter or SessionStorage
        try {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            const savedTab = sessionStorage.getItem('activeTab_lpj_<?= $buku['id'] ?>');
            const activeTab = tabParam || savedTab || 'proker';
            if (typeof switchTab === 'function' && activeTab && document.getElementById('tab-' + activeTab)) {
                switchTab(activeTab);
            }
        } catch (e) {}

        // 2. Re-bind draggable photo preview boxes
        document.querySelectorAll('[id^="container_preview_"]').forEach(box => {
            const id = box.id.replace('container_preview_', '');
            makePhotoBoxDraggable(box.id, 'img_preview_' + id, 'foto_pos_' + id);
        });
    }

    document.addEventListener('DOMContentLoaded', rebindPageEvents);
    window.rebindPageEvents = rebindPageEvents;

    function openModalUnit(id, nama, capaian, target, permasalahan, evaluasi) {
        document.getElementById('unit_id_field').value = id;
        document.getElementById('unitModalTitle').innerText = 'Laporan Unit: ' + nama;
        document.getElementById('capaian_field').value = capaian;
        document.getElementById('target_field').value = target;
        document.getElementById('permasalahan_field').value = permasalahan;
        document.getElementById('evaluasi_field').value = evaluasi;
        document.getElementById('modalUnit').classList.remove('hidden');
    }

    function closeModalUnit() {
        document.getElementById('modalUnit').classList.add('hidden');
    }

    function openModalTambahUnit() {
        document.getElementById('modalTambahUnit').classList.remove('hidden');
    }

    function closeModalTambahUnit() {
        document.getElementById('modalTambahUnit').classList.add('hidden');
    }

    function openModalTambahKader() {
        document.getElementById('modalTambahKader').classList.remove('hidden');
    }

    function closeModalTambahKader() {
        document.getElementById('modalTambahKader').classList.add('hidden');
    }

    // Dynamic Repeater Functions for Target, Capaian & Evaluasi Cards
    function addTargetRow() {
        const container = document.getElementById('targetContainer');
        if (!container) return;
        const rowId = 'target_' + Date.now();
        const count = container.querySelectorAll('.target-row').length + 1;
        const html = `
            <div id="${rowId}" class="target-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                <span class="num-badge w-7 h-7 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                    ${count}
                </span>
                <textarea name="target_text[]" rows="2" placeholder="Tuliskan poin target kebersihan bulan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition shadow-2xs leading-relaxed"></textarea>
                <button type="button" onclick="removeRowElement('${rowId}', '.target-row', 'targetContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexNumberBadges('.target-row', 'targetContainer');
        if (typeof window.initAutoResizeTextareas === 'function') window.initAutoResizeTextareas();
    }

    function addCapaianRow() {
        const container = document.getElementById('capaianContainer');
        if (!container) return;
        const rowId = 'capaian_' + Date.now();
        const count = container.querySelectorAll('.capaian-row').length + 1;
        const html = `
            <div id="${rowId}" class="capaian-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                <span class="num-badge w-7 h-7 rounded-xl bg-teal-100 text-teal-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                    ${count}
                </span>
                <textarea name="capaian_text[]" rows="2" placeholder="Tuliskan poin realisasi/capaian kebersihan bulan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white transition shadow-2xs leading-relaxed"></textarea>
                <button type="button" onclick="removeRowElement('${rowId}', '.capaian-row', 'capaianContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexNumberBadges('.capaian-row', 'capaianContainer');
        if (typeof window.initAutoResizeTextareas === 'function') window.initAutoResizeTextareas();
    }

    function addEvaluasiRow() {
        const container = document.getElementById('evaluasiContainer');
        if (!container) return;
        const rowId = 'evaluasi_' + Date.now();
        const count = container.querySelectorAll('.evaluasi-row').length + 1;
        const html = `
            <div id="${rowId}" class="evaluasi-row p-3 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-2xs flex items-center gap-3 transition-all">
                <span class="num-badge w-7 h-7 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                    ${count}
                </span>
                <textarea name="evaluasi_text[]" rows="2" placeholder="Tuliskan catatan evaluasi kebersihan bulan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white transition shadow-2xs leading-relaxed"></textarea>
                <button type="button" onclick="removeRowElement('${rowId}', '.evaluasi-row', 'evaluasiContainer')" class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs flex-shrink-0" title="Hapus Poin Ini">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexNumberBadges('.evaluasi-row', 'evaluasiContainer');
        if (typeof window.initAutoResizeTextareas === 'function') window.initAutoResizeTextareas();
    }

    function removeRowElement(rowId, selectorClass, containerId) {
        const el = document.getElementById(rowId);
        if (el) {
            el.remove();
            reindexNumberBadges(selectorClass, containerId);
        }
    }

    function reindexNumberBadges(selectorClass, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const rows = container.querySelectorAll(selectorClass);
        rows.forEach((row, idx) => {
            const badge = row.querySelector('.num-badge');
            if (badge) badge.textContent = idx + 1;
        });
    }

    // Keuangan Repeater & Calculation Helpers
    function formatRupiahInput(el) {
        let val = el.value.replace(/[^\d]/g, '');
        if (val) {
            el.value = parseInt(val, 10).toLocaleString('id-ID');
        } else {
            el.value = '';
        }
    }

    function parseRupiah(valStr) {
        if (!valStr) return 0;
        const clean = valStr.toString().replace(/[^\d]/g, '');
        return clean ? parseInt(clean, 10) : 0;
    }

    function updateKeuanganTotals() {
        let totalPlafon = 0;
        let totalTerserap = 0;

        document.querySelectorAll('.kp-row').forEach(row => {
            const plafonInp = row.querySelector('.kp-plafon');
            const terserapInp = row.querySelector('.kp-terserap');
            const saldoTd = row.querySelector('.kp-saldo');

            const plafon = parseRupiah(plafonInp ? plafonInp.value : 0);
            const terserap = parseRupiah(terserapInp ? terserapInp.value : 0);
            const saldo = plafon - terserap;

            if (saldoTd) saldoTd.textContent = 'Rp ' + saldo.toLocaleString('id-ID');

            totalPlafon += plafon;
            totalTerserap += terserap;
        });

        const totalSaldoAkhir = totalPlafon - totalTerserap;

        let totalDanaMasuk = 0;
        document.querySelectorAll('.km-row').forEach(row => {
            const nomInp = row.querySelector('.km-nominal');
            totalDanaMasuk += parseRupiah(nomInp ? nomInp.value : 0);
        });

        const saldoSisaBulan = totalDanaMasuk - totalTerserap;

        // Update footer cells
        const totalPlafonCell = document.getElementById('totalPlafonCell');
        if (totalPlafonCell) totalPlafonCell.textContent = 'Rp ' + totalPlafon.toLocaleString('id-ID');

        const totalTerserapCell = document.getElementById('totalTerserapCell');
        if (totalTerserapCell) totalTerserapCell.textContent = 'Rp ' + totalTerserap.toLocaleString('id-ID');

        const totalSaldoCell = document.getElementById('totalSaldoCell');
        if (totalSaldoCell) totalSaldoCell.textContent = 'Rp ' + totalSaldoAkhir.toLocaleString('id-ID');

        const totalMasukCell = document.getElementById('totalMasukCell');
        if (totalMasukCell) totalMasukCell.textContent = 'Rp ' + totalDanaMasuk.toLocaleString('id-ID');

        // Update summary cards & banners
        const bannerJumlahAnggaran = document.getElementById('bannerJumlahAnggaran');
        if (bannerJumlahAnggaran) bannerJumlahAnggaran.textContent = 'Rp ' + totalDanaMasuk.toLocaleString('id-ID');

        const cardTotalPlafon = document.getElementById('cardTotalPlafon');
        if (cardTotalPlafon) cardTotalPlafon.textContent = 'Rp ' + totalPlafon.toLocaleString('id-ID');

        const cardTotalTerserap = document.getElementById('cardTotalTerserap');
        if (cardTotalTerserap) cardTotalTerserap.textContent = 'Rp ' + totalTerserap.toLocaleString('id-ID');

        const cardSaldoSisa = document.getElementById('cardSaldoSisa');
        if (cardSaldoSisa) cardSaldoSisa.textContent = 'Rp ' + saldoSisaBulan.toLocaleString('id-ID');

        const saldoSisaBulanBanner = document.getElementById('saldoSisaBulanBanner');
        if (saldoSisaBulanBanner) saldoSisaBulanBanner.textContent = 'Rp ' + saldoSisaBulan.toLocaleString('id-ID');
    }

    function addKpRow() {
        const container = document.getElementById('keuanganPembelianContainer');
        if (!container) return;
        const count = container.querySelectorAll('.kp-row').length + 1;
        const html = `
            <tr class="kp-row hover:bg-slate-50/80 transition-all">
                <td class="num-badge-kp py-2.5 px-3 text-center font-extrabold text-slate-500">${count}</td>
                <td class="py-2.5 px-3">
                    <input type="text" name="item_pembelian[]" placeholder="Nama item pembelian / koordinasi..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="plafon[]" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="kp-plafon w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="terserap[]" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="kp-terserap w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-4 text-right font-extrabold text-slate-800 kp-saldo">Rp 0</td>
                <td class="py-2.5 px-3 text-center">
                    <button type="button" onclick="removeKpRow(this)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs mx-auto" title="Hapus Baris">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexKpBadges();
        updateKeuanganTotals();
    }

    function removeKpRow(btn) {
        const row = btn.closest('.kp-row');
        if (row) {
            row.remove();
            reindexKpBadges();
            updateKeuanganTotals();
        }
    }

    function reindexKpBadges() {
        document.querySelectorAll('.kp-row').forEach((row, idx) => {
            const badge = row.querySelector('.num-badge-kp');
            if (badge) badge.textContent = idx + 1;
        });
    }

    function addKmRow() {
        const container = document.getElementById('keuanganMasukContainer');
        if (!container) return;
        const count = container.querySelectorAll('.km-row').length + 1;
        const html = `
            <tr class="km-row hover:bg-slate-50/80 transition-all">
                <td class="num-badge-km py-2.5 px-3 text-center font-extrabold text-slate-500">${count}</td>
                <td class="py-2.5 px-3">
                    <input type="text" name="sumber_dana[]" placeholder="Misal: Subsidi Yayasan / Saldo Sisa Bulan Lalu..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="nominal[]" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="km-nominal w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="keterangan[]" placeholder="Keterangan tambahan (opsional)..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3 text-center">
                    <button type="button" onclick="removeKmRow(this)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs mx-auto" title="Hapus Baris">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexKmBadges();
        updateKeuanganTotals();
    }

    function removeKmRow(btn) {
        const row = btn.closest('.km-row');
        if (row) {
            row.remove();
            reindexKmBadges();
            updateKeuanganTotals();
        }
    }

    function reindexKmBadges() {
        document.querySelectorAll('.km-row').forEach((row, idx) => {
            const badge = row.querySelector('.num-badge-km');
            if (badge) badge.textContent = idx + 1;
        });
    }

    function openModalImportKeuangan() {
        const modal = document.getElementById('modalImportKeuangan');
        if (modal) modal.classList.remove('hidden');
    }

    function closeModalImportKeuangan() {
        const modal = document.getElementById('modalImportKeuangan');
        if (modal) modal.classList.add('hidden');
    }

    // Quick Preview Modal Functions
    function openModalPreviewDoc(id, title) {
        const modal = document.getElementById('modalPreviewDoc');
        const iframe = document.getElementById('previewDocIframe');
        const loader = document.getElementById('previewIframeLoader');
        const titleEl = document.getElementById('previewDocTitle');
        const tabBtn = document.getElementById('previewOpenTabBtn');
        const rawUrl = '<?= base_url('buku/cetak/') ?>' + id;
        const embedUrl = rawUrl + '?embed=1';

        if (titleEl) titleEl.innerText = 'Preview: ' + title;
        if (tabBtn) tabBtn.href = rawUrl;
        if (loader) loader.classList.remove('hidden');

        if (iframe) {
            iframe.src = embedUrl;
        }

        if (modal) modal.classList.remove('hidden');
    }
    window.openModalPreviewDoc = openModalPreviewDoc;

    function handleIframeLoaded() {
        const loader = document.getElementById('previewIframeLoader');
        if (loader) loader.classList.add('hidden');
    }
    window.handleIframeLoaded = handleIframeLoaded;

    function closeModalPreviewDoc() {
        const modal = document.getElementById('modalPreviewDoc');
        const iframe = document.getElementById('previewDocIframe');
        if (iframe) iframe.src = '';
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalPreviewDoc = closeModalPreviewDoc;

    function printPreviewIframe() {
        const iframe = document.getElementById('previewDocIframe');
        if (iframe && iframe.contentWindow) {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }
    }
    window.printPreviewIframe = printPreviewIframe;

    // Close preview modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalPreviewDoc();
        }
    });
</script>

<!-- Modal Quick Preview Dokumen LPJ -->
<div id="modalPreviewDoc" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden flex items-center justify-center p-2 sm:p-4 md:p-6 overflow-hidden">
    <div class="bg-white rounded-3xl max-w-5xl w-full h-[92vh] max-h-[900px] shadow-2xl flex flex-col border border-slate-200 overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Preview Modal Header -->
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/80 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-cyan-600 to-teal-500 text-white flex items-center justify-center shadow-md shadow-cyan-600/20 flex-shrink-0">
                    <i class="fa-solid fa-file-invoice text-sm"></i>
                </div>
                <div>
                    <h3 id="previewDocTitle" class="font-heading font-extrabold text-sm sm:text-base text-slate-900 leading-tight">
                        Preview Dokumen LPJ
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium">Tampilan langsung hasil dokumen tanpa meninggalkan halaman</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a id="previewOpenTabBtn" href="#" target="_blank" class="py-2 px-3 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition border border-slate-200 shadow-2xs" title="Buka di tab baru">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-500"></i>
                    <span class="hidden sm:inline">Tab Baru</span>
                </a>
                <button type="button" onclick="printPreviewIframe()" class="py-2 px-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-xs flex items-center gap-1.5 shadow-md shadow-emerald-600/20 transition" title="Cetak Dokumen">
                    <i class="fa-solid fa-print"></i>
                    <span class="hidden sm:inline">Cetak</span>
                </button>
                <button type="button" onclick="closeModalPreviewDoc()" class="w-8 h-8 rounded-xl bg-slate-200/80 hover:bg-rose-100 hover:text-rose-600 text-slate-500 flex items-center justify-center transition" title="Tutup Preview">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Preview Modal Body (Iframe) -->
        <div class="flex-1 w-full bg-slate-100 overflow-hidden relative">
            <!-- Loading Indicator -->
            <div id="previewIframeLoader" class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 z-10 gap-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </div>
                <div class="text-center">
                    <div class="text-xs font-extrabold text-slate-800">Memuat Tampilan Dokumen LPJ...</div>
                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">Menyiapkan layout lembar laporan</div>
                </div>
            </div>

            <!-- Preview Iframe -->
            <iframe id="previewDocIframe" src="" class="w-full h-full border-0 bg-white" onload="handleIframeLoaded()"></iframe>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
