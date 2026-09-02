<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 pb-12">
    <!-- Header Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-200/80 bg-white relative overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 relative z-10">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="<?= base_url('wilayah') ?>" class="hover:text-emerald-600 transition flex items-center gap-1">
                        <i class="fa-solid fa-map-location-dot text-emerald-600"></i>
                        <span>Pemetaan Wilayah</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                    <span class="text-slate-700">Rekapitulasi Laporan Harian</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                    Rekap Laporan Kebersihan Harian
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-2xl leading-relaxed">
                    Arsip seluruh laporan kebersihan wilayah yang dikirimkan oleh unit-unit pelaksana beserta nilai capaian dan bukti foto harian.
                </p>
            </div>

            <div class="flex items-center gap-2 self-start lg:self-center">
                <a href="<?= base_url('wilayah') ?>" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition shadow-2xs">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Wilayah
                </a>
            </div>
        </div>

        <!-- Filter Bar Form -->
        <form method="GET" action="<?= base_url('wilayah/laporan') ?>" class="grid grid-cols-1 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-slate-100">
            <div>
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Pilih Tanggal</label>
                <input type="date" name="tanggal" value="<?= esc($filters['tanggal'] ?? date('Y-m-d')) ?>" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Filter Wilayah</label>
                <select name="wilayah_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="">Semua Wilayah</option>
                    <?php foreach ($wilayahList as $w): ?>
                        <option value="<?= $w['id'] ?>" <?= (!empty($filters['wilayah_id']) && $filters['wilayah_id'] == $w['id']) ? 'selected' : '' ?>>
                            <?= esc($w['nama_wilayah']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Filter Unit Pelaksana</label>
                <select name="unit_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="">Semua Unit</option>
                    <?php foreach ($unitsList as $un): ?>
                        <option value="<?= $un['id'] ?>" <?= (!empty($filters['unit_id']) && $filters['unit_id'] == $un['id']) ? 'selected' : '' ?>>
                            <?= esc($un['nama_unit']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-filter"></i>
                    <span>Terapkan Filter</span>
                </button>
                <a href="<?= base_url('wilayah/laporan') ?>" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition shadow-2xs" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table of Daily Reports -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-emerald-600"></i> Daftar Laporan Kebersihan
            </h2>
            <span class="text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/80">
                <?= count($laporanList) ?> Laporan Ditemukan
            </span>
        </div>

        <?php if (!empty($laporanList)): ?>
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">TANGGAL & SHIFT</th>
                            <th class="py-3 px-4">WILAYAH KEBERSIHAN</th>
                            <th class="py-3 px-4">UNIT PENGAMPU</th>
                            <th class="py-3 px-3 text-center">NILAI CAPAIAN</th>
                            <th class="py-3 px-4">BUKTI FOTO HARIAN</th>
                            <th class="py-3 px-4">CATATAN PEMERIKSAAN</th>
                            <th class="py-3 px-3 text-center">STATUS</th>
                            <?php if (session()->get('role') === 'Admin'): ?>
                                <th class="py-3 px-3 text-center">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php foreach ($laporanList as $lap): ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                    <div><?= date('d M Y', strtotime($lap['tanggal_lapor'])) ?></div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-extrabold <?= $lap['shift'] === 'Pagi' ? 'bg-amber-50 text-amber-800' : 'bg-blue-50 text-blue-800' ?>">
                                            Shift <?= esc($lap['shift']) ?>
                                        </span>
                                        <?php if (!empty($lap['jam_lapor'])): ?>
                                            <span class="text-[10px] text-slate-400 font-semibold">Pk <?= esc($lap['jam_lapor']) ?> WIB</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-slate-900">
                                    <a href="<?= base_url('wilayah/detail/' . $lap['wilayah_id']) ?>" class="hover:text-emerald-700 transition">
                                        <?= esc($lap['nama_wilayah'] ?: 'Wilayah #' . $lap['wilayah_id']) ?>
                                    </a>
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5"><?= esc($lap['kategori_area'] ?? '') ?></div>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-sitemap text-emerald-600 text-xs"></i>
                                        <span><?= esc($lap['nama_unit'] ?: 'Unit') ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">Oleh: <?= esc($lap['nama_pelapor'] ?: 'Petugas Unit') ?></div>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <?php
                                        $skor = (int)$lap['nilai_kebersihan'];
                                        $badgeBg = $skor >= 80 ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($skor >= 60 ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200');
                                    ?>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-heading font-extrabold border <?= $badgeBg ?> shadow-2xs">
                                        <span><?= $skor ?>%</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <?php if (!empty($lap['foto_bukti_url'])): ?>
                                        <div class="relative group w-16 h-12 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 cursor-pointer shadow-2xs" onclick="openLightbox('<?= esc($lap['foto_bukti_url']) ?>')">
                                            <img src="<?= esc($lap['foto_bukti_url']) ?>" alt="Bukti Bersih" class="w-full h-full object-cover group-hover:scale-110 transition">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[10px]">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-600 font-medium max-w-xs">
                                    <?= esc($lap['catatan'] ?: '-') ?>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-extrabold <?= $lap['status_verifikasi'] === 'Sudah Bersih' ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-800' ?>">
                                        <i class="fa-solid <?= $lap['status_verifikasi'] === 'Sudah Bersih' ? 'fa-check' : 'fa-triangle-exclamation' ?>"></i>
                                        <span><?= esc($lap['status_verifikasi']) ?></span>
                                    </span>
                                </td>
                                <?php if (session()->get('role') === 'Admin'): ?>
                                    <td class="py-3.5 px-3 text-center">
                                        <a href="<?= base_url('wilayah/laporan/delete/' . $lap['id']) ?>" data-confirm-msg="Hapus data laporan kebersihan harian ini?" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 inline-flex items-center justify-center transition shadow-2xs" title="Hapus Laporan">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <i class="fa-solid fa-clipboard-question text-3xl text-slate-300"></i>
                <p class="text-xs text-slate-500 font-semibold">Tidak ada data laporan kebersihan yang sesuai dengan filter yang dipilih.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Lightbox Modal Preview Foto -->
<div id="lightboxModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden flex items-center justify-center p-4 cursor-pointer" onclick="closeLightbox()">
    <div class="max-w-4xl max-h-[90vh] relative" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="Preview Foto" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain mx-auto">
        <button onclick="closeLightbox()" class="absolute -top-3 -right-3 w-9 h-9 rounded-full bg-white text-slate-800 flex items-center justify-center shadow-lg text-sm font-bold">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>

<script>
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
</script>
<?= $this->endSection() ?>
