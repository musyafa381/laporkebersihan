<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Hero Banner / Page Header (Struktur/LPJ Style) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-gauge-high text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard Unit
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-bold border border-white/20">
                        Role: <?= esc(session()->get('role')) ?>
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Selamat Datang, <?= esc(session()->get('nama_lengkap')) ?>!
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed flex items-center gap-2">
                    <i class="fa-solid fa-building-user text-emerald-300"></i>
                    <span>Unit Instansi: <strong><?= esc($userUnit['nama_unit'] ?? 'Pengurus K3L Pusat') ?></strong></span>
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="<?= base_url('app/lpj') ?>" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </div>
                    <span>Isi LPJ Unit Kebersihan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 3 Quick Action Dashboard Cards (Premium & Clean) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Action 1: LPJ -->
        <a href="<?= base_url('app/lpj') ?>" class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-emerald-50/90 via-white to-emerald-50/40 border border-emerald-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/80 text-emerald-800 text-[11px] font-extrabold border border-emerald-200 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <span>Buka Form</span>
                    <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-emerald-700 transition-colors">
                    1. Isi LPJ Unit Kebersihan
                </h3>
                <p class="text-xs text-slate-500 font-medium leading-relaxed">
                    Input capaian target & evaluasi kebersihan bulanan unit Anda.
                </p>
            </div>
        </a>

        <!-- Action 2: Pengajuan Alat -->
        <a href="<?= base_url('app/pengajuan-alat') ?>" class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-teal-50/90 via-white to-teal-50/40 border border-teal-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-teal-600 to-cyan-500 text-white flex items-center justify-center text-xl shadow-md shadow-teal-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100/80 text-teal-800 text-[11px] font-extrabold border border-teal-200 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <span>Buka Form</span>
                    <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-teal-700 transition-colors">
                    2. Pengajuan Alat Kebersihan
                </h3>
                <p class="text-xs text-slate-500 font-medium leading-relaxed">
                    Permohonan alokasi sapu, pel, atau alat baru dari Gudang K3L.
                </p>
            </div>
        </a>

        <!-- Action 3: Lapor Kendala & Tindak Lanjut Aduan Unit -->
        <?php 
            $pendingAduanCount = 0;
            if (!empty($unitAssignedReports)) {
                foreach ($unitAssignedReports as $uar) {
                    if (in_array($uar['status'] ?? '', ['Baru', 'Diproses']) && empty($uar['tanggapan_unit'])) {
                        $pendingAduanCount++;
                    }
                }
            }
        ?>
        <a href="<?= base_url('app/laporan-kebersihan') ?>" class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-blue-50/90 via-white to-blue-50/40 border border-blue-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-headset"></i>
                    <?php if ($pendingAduanCount > 0): ?>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white rounded-full text-[10px] font-black flex items-center justify-center border-2 border-white animate-pulse">
                            <?= $pendingAduanCount ?>
                        </span>
                    <?php endif; ?>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100/80 text-blue-800 text-[11px] font-extrabold border border-blue-200 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span><?= !empty($unitAssignedReports) ? (count($unitAssignedReports) . ' Aduan Unit') : 'Buka Form' ?></span>
                    <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-blue-700 transition-colors">
                    3. Pengaduan & Lapor Kendala
                </h3>
                <p class="text-xs text-slate-500 font-medium leading-relaxed">
                    Kirim laporan kendala & tindak lanjuti aduan masuk ke unit Anda.
                </p>
            </div>
        </a>
    </div>

    <!-- Riwayat Pengajuan Alat Unit Dashboard Table -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Riwayat Pengajuan Alat Unit Saya
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Status permohonan alat kebersihan yang diajukan ke Gudang K3L.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-60">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchMyPengajuanInput" onkeyup="filterMyPengajuanTable()" placeholder="Cari nama alat / alasan..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                </div>

                <a href="<?= base_url('app/pengajuan-alat') ?>" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i>
                    <span>Buat Pengajuan Alat</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
            <table id="tableMyPengajuanAlat" class="w-full text-left text-xs font-semibold">
                <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th width="5%" class="py-3.5 px-3 text-center">NO</th>
                        <th width="15%" class="py-3.5 px-4">TANGGAL</th>
                        <th width="25%" class="py-3.5 px-4">PERALATAN PERMOHONAN</th>
                        <th width="35%" class="py-3.5 px-4">ALASAN KEPERLUAN</th>
                        <th width="20%" class="py-3.5 px-4 text-center">STATUS & CATATAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php if (!empty($myPengajuan)): ?>
                        <?php foreach ($myPengajuan as $idx => $p): ?>
                            <tr class="my-pengajuan-row hover:bg-slate-50/90 transition-all">
                                <td class="py-4 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                <td class="py-4 px-4 font-bold text-slate-600 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar-days text-slate-400 text-xs"></i>
                                        <span><?= date('d M Y', strtotime($p['created_at'])) ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5 flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        <span><?= date('H:i', strtotime($p['created_at'])) ?> WIB</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-box text-emerald-600"></i>
                                        <span><?= esc($p['nama_alat']) ?></span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold mt-1 border border-emerald-200/80 shadow-2xs">
                                        <i class="fa-solid fa-layer-group text-[9px]"></i>
                                        <?= $p['jumlah'] ?> <?= esc($p['satuan']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                        "<?= esc($p['alasan_keperluan']) ?>"
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <?php if ($p['status'] === 'Pending'): ?>
                                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                            Pending
                                        </span>
                                    <?php elseif ($p['status'] === 'Disetujui'): ?>
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                            Disetujui
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-800 text-xs font-extrabold border border-rose-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-xmark text-rose-600 text-[10px]"></i>
                                            Ditolak
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($p['catatan_admin'])): ?>
                                        <div class="mt-1.5 text-[10px] text-slate-500 font-semibold italic text-left max-w-xs" title="<?= esc($p['catatan_admin']) ?>">
                                            Catatan: <?= esc($p['catatan_admin']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 italic font-medium">Belum ada riwayat pengajuan alat kebersihan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-my-pengajuan">
            <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                <span id="page-info-my-pengajuan">Menampilkan 0 data</span>
                <select id="pageSize-my-pengajuan" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    <option value="5">5 / hal</option>
                    <option value="10" selected>10 / hal</option>
                    <option value="25">25 / hal</option>
                    <option value="50">50 / hal</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="page-buttons-my-pengajuan"></div>
        </div>
    </div>

    <!-- Riwayat Lapor Kendala Kebersihan Saya Table Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Riwayat Lapor Kendala Kebersihan Saya
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Status pengaduan & tanggapan admin K3L atas laporan yang Anda kirimkan.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-60">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchMyReportInput" onkeyup="filterMyReportTable()" placeholder="Cari lokasi / isi laporan..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                </div>

                <a href="<?= base_url('app/laporan-kebersihan') ?>" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 whitespace-nowrap">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Lapor CS</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
            <table id="tableMyReport" class="w-full text-left text-xs font-semibold">
                <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th width="5%" class="py-3.5 px-3 text-center">NO</th>
                        <th width="15%" class="py-3.5 px-4">TANGGAL</th>
                        <th width="25%" class="py-3.5 px-4">LOKASI & KATEGORI</th>
                        <th width="35%" class="py-3.5 px-4">ISI LAPORAN PENGADUAN</th>
                        <th width="20%" class="py-3.5 px-4 text-center">STATUS & CATATAN ADMIN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php if (!empty($myReports)): ?>
                        <?php foreach ($myReports as $idx => $r): ?>
                            <tr class="my-report-row hover:bg-slate-50/90 transition-all">
                                <td class="py-4 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                <td class="py-4 px-4 font-bold text-slate-600 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar-days text-slate-400 text-xs"></i>
                                        <span><?= date('d M Y', strtotime($r['created_at'])) ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5 flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        <span><?= date('H:i', strtotime($r['created_at'])) ?> WIB</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-emerald-600"></i>
                                        <span><?= esc($r['unit_lokasi']) ?></span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 mt-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold border border-emerald-200/80 shadow-2xs">
                                            <i class="fa-solid fa-tag text-[9px]"></i>
                                            <?= esc($r['kategori']) ?>
                                        </span>
                                        <?php if (!empty($r['nama_wilayah'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200/80 text-[10px] font-extrabold shadow-2xs">
                                                <i class="fa-solid fa-map-location-dot text-teal-600 text-[9px]"></i>
                                                <span><?= esc($r['nama_wilayah']) ?></span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                        "<?= esc($r['isi_laporan']) ?>"
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <?php if ($r['status'] === 'Baru'): ?>
                                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-extrabold border border-blue-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-info text-blue-600 text-[10px]"></i>
                                            Baru
                                        </span>
                                    <?php elseif ($r['status'] === 'Diproses'): ?>
                                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                            Diproses
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                            Selesai
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($r['tanggapan_admin'])): ?>
                                        <div class="mt-1.5 p-2 rounded-xl bg-emerald-50/80 border border-emerald-200/70 text-emerald-950 text-[10px] font-semibold text-left max-w-xs" title="<?= esc($r['tanggapan_admin']) ?>">
                                            Catatan Admin: "<?= esc($r['tanggapan_admin']) ?>"
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 italic font-medium">Belum ada riwayat pengaduan kendala kebersihan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-my-report">
            <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                <span id="page-info-my-report">Menampilkan 0 data</span>
                <select id="pageSize-my-report" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    <option value="5">5 / hal</option>
                    <option value="10" selected>10 / hal</option>
                    <option value="25">25 / hal</option>
                    <option value="50">50 / hal</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="page-buttons-my-report"></div>
        </div>
    </div>
</div>

<script>
    var paginatorMyPengajuan;
    var paginatorMyReport;

    function initPortalPaginators() {
        if (typeof TablePaginator !== 'undefined') {
            if (document.getElementById('tableMyPengajuanAlat')) {
                paginatorMyPengajuan = new TablePaginator('tableMyPengajuanAlat', 'page-info-my-pengajuan', 'page-buttons-my-pengajuan', 'pageSize-my-pengajuan');
                paginatorMyPengajuan.render();
            }

            if (document.getElementById('tableMyReport')) {
                paginatorMyReport = new TablePaginator('tableMyReport', 'page-info-my-report', 'page-buttons-my-report', 'pageSize-my-report');
                paginatorMyReport.render();
            }
        }
    }
    window.initPortalPaginators = initPortalPaginators;
    window.rebindPageEvents = initPortalPaginators;

    document.addEventListener('DOMContentLoaded', initPortalPaginators);
    initPortalPaginators();

    function filterMyPengajuanTable() {
        const input = document.getElementById('searchMyPengajuanInput');
        if (!input) return;
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#tableMyPengajuanAlat tbody tr.my-pengajuan-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
        });

        if (paginatorMyPengajuan) {
            paginatorMyPengajuan.currentPage = 1;
            paginatorMyPengajuan.render();
        }
    }
    window.filterMyPengajuanTable = filterMyPengajuanTable;

    function filterMyReportTable() {
        const input = document.getElementById('searchMyReportInput');
        if (!input) return;
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#tableMyReport tbody tr.my-report-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
        });

        if (paginatorMyReport) {
            paginatorMyReport.currentPage = 1;
            paginatorMyReport.render();
        }
    }
    window.filterMyReportTable = filterMyReportTable;
</script>
<?= $this->endSection() ?>
