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

            <div class="flex-shrink-0 flex flex-wrap items-center gap-2.5">
                <a href="<?= base_url('faq') ?>" class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-emerald-600/60 hover:bg-emerald-600 text-white font-heading font-extrabold text-sm border border-emerald-400/40 backdrop-blur-md transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-question text-xs"></i>
                    <span>Panduan Alur & FAQ</span>
                </a>
                <a href="<?= base_url('app/lpj') ?>" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </div>
                    <span>Isi LPJ Unit Kebersihan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Daily Wilayah Tasks Progress Bar Widget (New Smart Feature) -->
    <?php
        $totalActive = $todayTotalActiveCount ?? 0;
        $reported = $todayReportedCount ?? 0;
        $percentComplete = $totalActive > 0 ? round(($reported / $totalActive) * 100) : 100;
        $isAllDone = ($totalActive > 0 && $reported >= $totalActive) || ($totalActive === 0);
    ?>
    <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-xl shadow-slate-200/40 space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl <?= $isAllDone ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' ?> flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fa-solid <?= $isAllDone ? 'fa-circle-check' : 'fa-list-check' ?>"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-sm sm:text-base text-slate-900">
                        Progres Tugas Kebersihan Hari Ini (<?= date('d M Y') ?>)
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        <?= $totalActive > 0 ? "{$reported} dari {$totalActive} shift spot wilayah aktif telah dilaporkan." : "Tidak ada jadwal tugas kebersihan aktif hari ini." ?>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-center">
                <span class="px-3 py-1 rounded-full text-xs font-extrabold <?= $isAllDone ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' ?>">
                    <?= $percentComplete ?>% Selesai
                </span>
                <a href="<?= base_url('app/lapor-wilayah') ?>" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-emerald-700 text-white text-xs font-extrabold transition shadow-2xs flex items-center gap-1.5">
                    <span><?= $isAllDone ? 'Lihat Wilayah' : 'Lapor Sekarang' ?></span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-500 <?= $isAllDone ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-gradient-to-r from-amber-500 to-emerald-500' ?>" style="width: <?= $percentComplete ?>%;"></div>
        </div>
    </div>

    <!-- 4 Quick Action Dashboard Cards (Symmetric & Premium Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Action 1: Lapor Wilayah Harian (Utama) -->
        <a href="<?= base_url('app/lapor-wilayah') ?>" class="group relative overflow-hidden p-5 rounded-3xl bg-gradient-to-br from-emerald-50/90 via-white to-emerald-50/40 border border-emerald-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full <?= $isAllDone ? 'bg-emerald-100/90 text-emerald-800 border border-emerald-200' : 'bg-rose-100/90 text-rose-800 border border-rose-200' ?> text-[10.5px] font-extrabold">
                    <i class="fa-solid <?= $isAllDone ? 'fa-check' : 'fa-bell' ?> text-[9px]"></i>
                    <span><?= $totalActive > 0 ? "{$reported}/{$totalActive} Lapor" : 'Siap' ?></span>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-emerald-700 transition-colors">
                    1. Lapor Wilayah Harian
                </h3>
                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                    Kirim capaian skor & foto bukti kebersihan harian per shift.
                </p>
            </div>
        </a>

        <!-- Action 2: LPJ -->
        <a href="<?= base_url('app/lpj') ?>" class="group relative overflow-hidden p-5 rounded-3xl bg-gradient-to-br from-amber-50/90 via-white to-amber-50/40 border border-amber-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-lg shadow-md shadow-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-100/90 text-amber-800 text-[10.5px] font-extrabold border border-amber-200 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <span>Buka Form</span>
                    <i class="fa-solid fa-arrow-right text-[8px] group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-amber-700 transition-colors">
                    2. Isi LPJ Unit Kebersihan
                </h3>
                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                    Input capaian target, koordinasi, & evaluasi bulanan unit.
                </p>
            </div>
        </a>

        <!-- Action 3: Pengajuan Alat -->
        <a href="<?= base_url('app/pengajuan-alat') ?>" class="group relative overflow-hidden p-5 rounded-3xl bg-gradient-to-br from-teal-50/90 via-white to-teal-50/40 border border-teal-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-teal-600 to-cyan-500 text-white flex items-center justify-center text-lg shadow-md shadow-teal-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-teal-100/90 text-teal-800 text-[10.5px] font-extrabold border border-teal-200 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <span><?= !empty($myPengajuan) ? (count($myPengajuan) . ' Riwayat') : 'Buka Form' ?></span>
                    <i class="fa-solid fa-arrow-right text-[8px] group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-teal-700 transition-colors">
                    3. Pengajuan Alat Kebersihan
                </h3>
                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                    Permohonan alokasi sapu, pel, atau alat baru dari Gudang K3L.
                </p>
            </div>
        </a>

        <!-- Action 4: Lapor Kendala & Tindak Lanjut Aduan Unit -->
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
        <a href="<?= base_url('app/laporan-kebersihan') ?>" class="group relative overflow-hidden p-5 rounded-3xl bg-gradient-to-br from-blue-50/90 via-white to-blue-50/40 border border-blue-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div class="relative w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center text-lg shadow-md shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-headset"></i>
                    <?php if ($pendingAduanCount > 0): ?>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white rounded-full text-[9px] font-black flex items-center justify-center border-2 border-white animate-pulse">
                            <?= $pendingAduanCount ?>
                        </span>
                    <?php endif; ?>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-100/90 text-blue-800 text-[10.5px] font-extrabold border border-blue-200 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span><?= $pendingAduanCount > 0 ? "{$pendingAduanCount} Aduan Baru" : 'Buka Form' ?></span>
                    <i class="fa-solid fa-arrow-right text-[8px] group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-blue-700 transition-colors">
                    4. Pengaduan & Lapor Kendala
                </h3>
                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                    Kirim laporan kendala & tindak lanjuti aduan masuk unit Anda.
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
                        <th width="25%" class="py-3.5 px-4">ALASAN KEPERLUAN</th>
                        <th width="15%" class="py-3.5 px-4 text-center">STATUS & CATATAN</th>
                        <th width="15%" class="py-3.5 px-4 text-center">AKSI</th>
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
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <?php if ($p['status'] !== 'Disetujui'): ?>
                                            <button type="button"
                                                    onclick='openEditPengajuanModal(<?= json_encode([
                                                        'id' => (int)$p['id'],
                                                        'alat_id' => (int)$p['alat_id'],
                                                        'nama_alat' => $p['nama_alat'] ?? '',
                                                        'jumlah' => (int)$p['jumlah'],
                                                        'satuan' => $p['satuan'] ?? 'Unit',
                                                        'stok_sisa' => (int)($p['stok_sisa'] ?? 0),
                                                        'kategori' => $p['kategori'] ?? 'Umum',
                                                        'alasan_keperluan' => $p['alasan_keperluan'] ?? '',
                                                        'status' => $p['status'] ?? 'Pending',
                                                        'catatan_admin' => $p['catatan_admin'] ?? '',
                                                    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                                                    class="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 hover:text-emerald-800 text-[11px] font-extrabold border border-emerald-200/80 transition flex items-center gap-1 shadow-2xs hover:shadow-sm"
                                                    title="Edit Pengajuan">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                <span>Edit</span>
                                            </button>
                                            <button type="button"
                                                    onclick="confirmDeletePengajuan('<?= base_url('app/pengajuan-alat/delete/' . $p['id']) ?>', '<?= esc($p['nama_alat'] ?? 'Alat') ?>')"
                                                    class="px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-800 text-[11px] font-extrabold border border-rose-200/80 transition flex items-center gap-1 shadow-2xs hover:shadow-sm"
                                                    title="Batalkan Pengajuan">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                <span>Batal</span>
                                            </button>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-400 text-[10px] font-bold border border-slate-200 cursor-not-allowed" title="Pengajuan telah disetujui oleh gudang dan tidak dapat diubah">
                                                <i class="fa-solid fa-lock text-[9px]"></i>
                                                <span>Terkunci</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 italic font-medium">Belum ada riwayat pengajuan alat kebersihan.</td>
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

<!-- Modal Edit Pengajuan Alat -->
<div id="modalEditPengajuanAlat" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-fade-in my-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 px-6 py-5 text-white flex items-center justify-between border-b border-emerald-600/30">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-emerald-200 border border-white/20">
                    <i class="fa-solid fa-pen-to-square text-base"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-base sm:text-lg leading-tight">Edit Pengajuan Alat</h3>
                    <p class="text-xs text-emerald-200/80 mt-0.5">Perbarui jenis alat, jumlah, atau alasan keperluan</p>
                </div>
            </div>
            <button type="button" onclick="closeEditPengajuanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Form Edit -->
        <form id="formEditPengajuanAlat" action="" method="POST" class="p-6 space-y-4">
            <input type="hidden" id="editPengajuanId" name="id" value="">
            
            <!-- Alert jika status Ditolak -->
            <div id="editRejectedNotice" class="hidden p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-2.5">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 mt-0.5 text-sm flex-shrink-0"></i>
                <div>
                    <span class="font-bold">Pengajuan ini sebelumnya Ditolak.</span>
                    <p class="text-[11px] text-amber-800 mt-0.5">Dengan menyimpan perubahan baru, status akan otomatis diubah kembali menjadi <strong class="text-amber-900 font-extrabold">Pending</strong> agar dapat ditinjau ulang oleh Admin Gudang.</p>
                </div>
            </div>

            <!-- Searchable Alat Picker for Edit -->
            <div class="relative edit-alat-picker-container">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between">
                    <span>Pilih Alat Kebersihan <span class="text-rose-500">*</span></span>
                    <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        <i class="fa-solid fa-magnifying-glass text-[8px]"></i> Bisa dicari
                    </span>
                </label>
                <input type="hidden" name="alat_id" id="editAlatId" required value="">
                <div class="relative">
                    <i class="fa-solid fa-broom-ball absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                    <input type="text" id="editAlatSearch" placeholder="Ketik nama alat untuk mencari..." autocomplete="off" onfocus="openEditAlatPicker(this)" oninput="filterEditAlatPicker(this)" class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400" required>
                    <button type="button" onclick="toggleEditAlatPicker(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 edit-alat-icon"></i>
                    </button>
                </div>

                <!-- Dropdown List for Edit -->
                <div class="edit-alat-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200/90 ring-1 ring-slate-900/10 max-h-52 overflow-y-auto z-[100] hidden divide-y divide-slate-100">
                    <?php if (!empty($alatList)): ?>
                        <?php foreach ($alatList as $a): ?>
                            <div class="edit-alat-option px-3.5 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer"
                                 data-id="<?= $a['id'] ?>"
                                 data-name="<?= esc($a['nama_alat']) ?>"
                                 data-stok="<?= $a['stok_sisa'] ?>"
                                 data-satuan="<?= esc($a['satuan']) ?>"
                                 data-kategori="<?= esc($a['kategori'] ?? 'Umum') ?>"
                                 onclick="selectEditAlatOption(this)">
                                <div>
                                    <div class="font-extrabold text-xs text-slate-900"><?= esc($a['nama_alat']) ?></div>
                                    <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-bold border border-slate-200/60"><?= esc($a['kategori'] ?? 'Umum') ?></span>
                                        <?php if (!empty($a['lokasi_gudang'])): ?>
                                            <span>&bull;</span>
                                            <span><i class="fa-solid fa-warehouse text-emerald-600 mr-0.5"></i><?= esc($a['lokasi_gudang']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold <?= $a['stok_sisa'] > 3 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($a['stok_sisa'] > 0 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-rose-50 text-rose-800 border border-rose-200') ?>">
                                        Stok: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="no-edit-alat-found px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan alat kebersihan yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 items-end">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">
                        Jumlah <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="jumlah" id="editJumlah" value="1" min="1" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div class="pb-1 text-right">
                    <div id="editStockBadge" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-slate-100 text-slate-500 border border-slate-200">
                        <span>Pilih alat</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">
                    Alasan Keperluan Pengajuan <span class="text-rose-500">*</span>
                </label>
                <textarea name="alasan_keperluan" id="editAlasanKeperluan" rows="3" placeholder="Jelaskan alasan/kebutuhan pengajuan ini..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditPengajuanModal()" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
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

    // Modal Edit Pengajuan Handlers
    function openEditPengajuanModal(data) {
        if (!data || !data.id) return;
        const modal = document.getElementById('modalEditPengajuanAlat');
        const form = document.getElementById('formEditPengajuanAlat');
        if (!modal || !form) return;

        form.action = '<?= base_url('app/pengajuan-alat/update') ?>/' + data.id;
        document.getElementById('editPengajuanId').value = data.id;
        document.getElementById('editAlatId').value = data.alat_id || '';
        
        const stok = parseInt(data.stok_sisa || 0, 10);
        const satuan = data.satuan || 'Unit';
        document.getElementById('editAlatSearch').value = data.nama_alat ? `${data.nama_alat} (Sisa: ${stok} ${satuan})` : '';
        document.getElementById('editJumlah').value = data.jumlah || 1;
        document.getElementById('editAlasanKeperluan').value = data.alasan_keperluan || '';

        // Stock badge
        const badge = document.getElementById('editStockBadge');
        if (badge) {
            if (stok > 3) {
                badge.className = 'inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200';
                badge.innerHTML = `<i class="fa-solid fa-check text-[9px]"></i> Sisa: ${stok} ${satuan}`;
            } else if (stok > 0) {
                badge.className = 'inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200';
                badge.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Menipis: ${stok} ${satuan}`;
            } else {
                badge.className = 'inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-rose-50 text-rose-800 border border-rose-200';
                badge.innerHTML = `<i class="fa-solid fa-ban text-[9px]"></i> Stok Habis (0 ${satuan})`;
            }
        }

        // Rejected notice
        const rejNotice = document.getElementById('editRejectedNotice');
        if (rejNotice) {
            rejNotice.classList.toggle('hidden', data.status !== 'Ditolak');
        }

        modal.classList.remove('hidden');
    }
    window.openEditPengajuanModal = openEditPengajuanModal;

    function closeEditPengajuanModal() {
        const modal = document.getElementById('modalEditPengajuanAlat');
        if (modal) modal.classList.add('hidden');
        closeAllEditAlatPickers();
    }
    window.closeEditPengajuanModal = closeEditPengajuanModal;

    // Modal Edit Searchable Alat Picker Handlers
    function openEditAlatPicker(input) {
        closeAllEditAlatPickers();
        const container = input.closest('.edit-alat-picker-container');
        if (!container) return;
        const dropdown = container.querySelector('.edit-alat-dropdown');
        const icon = container.querySelector('.edit-alat-icon');
        if (dropdown) dropdown.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openEditAlatPicker = openEditAlatPicker;

    function toggleEditAlatPicker(btn) {
        const container = btn.closest('.edit-alat-picker-container');
        if (!container) return;
        const dropdown = container.querySelector('.edit-alat-dropdown');
        const icon = container.querySelector('.edit-alat-icon');
        if (dropdown) {
            const isHidden = dropdown.classList.contains('hidden');
            closeAllEditAlatPickers();
            if (isHidden) {
                dropdown.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            }
        }
    }
    window.toggleEditAlatPicker = toggleEditAlatPicker;

    function closeAllEditAlatPickers() {
        document.querySelectorAll('.edit-alat-dropdown').forEach(dd => dd.classList.add('hidden'));
        document.querySelectorAll('.edit-alat-icon').forEach(icon => icon.classList.remove('rotate-180'));
    }
    window.closeAllEditAlatPickers = closeAllEditAlatPickers;

    function filterEditAlatPicker(input) {
        openEditAlatPicker(input);
        const container = input.closest('.edit-alat-picker-container');
        if (!container) return;

        const query = (input.value || '').toLowerCase().trim();
        const options = container.querySelectorAll('.edit-alat-option');
        let found = 0;

        options.forEach(opt => {
            const text = opt.innerText.toLowerCase();
            const name = (opt.dataset.name || '').toLowerCase();
            const kategori = (opt.dataset.kategori || '').toLowerCase();
            if (!query || text.includes(query) || name.includes(query) || kategori.includes(query)) {
                opt.style.display = 'flex';
                found++;
            } else {
                opt.style.display = 'none';
            }
        });

        const noFound = container.querySelector('.no-edit-alat-found');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterEditAlatPicker = filterEditAlatPicker;

    function selectEditAlatOption(opt) {
        const container = opt.closest('.edit-alat-picker-container');
        if (!container) return;

        const id = opt.dataset.id || '';
        const name = opt.dataset.name || '';
        const stok = parseInt(opt.dataset.stok || '0', 10);
        const satuan = opt.dataset.satuan || 'Unit';

        const inputId = document.getElementById('editAlatId');
        const inputSearch = document.getElementById('editAlatSearch');
        const badge = document.getElementById('editStockBadge');

        if (inputId) inputId.value = id;
        if (inputSearch) inputSearch.value = `${name} (Sisa: ${stok} ${satuan})`;

        if (badge) {
            if (stok > 3) {
                badge.className = 'inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200';
                badge.innerHTML = `<i class="fa-solid fa-check text-[9px]"></i> Sisa: ${stok} ${satuan}`;
            } else if (stok > 0) {
                badge.className = 'inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200';
                badge.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Menipis: ${stok} ${satuan}`;
            } else {
                badge.className = 'inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-extrabold bg-rose-50 text-rose-800 border border-rose-200';
                badge.innerHTML = `<i class="fa-solid fa-ban text-[9px]"></i> Stok Habis (0 ${satuan})`;
            }
        }

        closeAllEditAlatPickers();
    }
    window.selectEditAlatOption = selectEditAlatOption;

    // Confirm Delete Pengajuan Handler
    function confirmDeletePengajuan(deleteUrl, namaAlat) {
        if (typeof SwalCustom !== 'undefined' || typeof Swal !== 'undefined') {
            const swalObj = typeof SwalCustom !== 'undefined' ? SwalCustom : Swal;
            swalObj.fire({
                title: 'Batalkan Pengajuan?',
                text: `Apakah Anda yakin ingin membatalkan pengajuan "${namaAlat}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Batalkan',
                cancelButtonText: 'Kembali',
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin membatalkan pengajuan "${namaAlat}"?`)) {
                window.location.href = deleteUrl;
            }
        }
    }
    window.confirmDeletePengajuan = confirmDeletePengajuan;

    // Close modal on click outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('modalEditPengajuanAlat');
        if (modal && e.target === modal) {
            closeEditPengajuanModal();
        }
        if (!e.target.closest('.edit-alat-picker-container')) {
            closeAllEditAlatPickers();
        }
    });
</script>
<?= $this->endSection() ?>
