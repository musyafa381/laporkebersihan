<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 pb-12">
    <!-- Top Header Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-200/80 bg-white relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 relative z-10">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-heading font-extrabold tracking-wide uppercase border border-emerald-200/60 shadow-2xs">
                    <i class="fa-solid fa-map-location-dot text-emerald-600"></i>
                    <span>Sistem Monitoring Area Pesantren</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                    Pemetaan Wilayah Kebersihan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-2xl leading-relaxed">
                    Kelola area kebersihan, plotting shift penanggung jawab unit, dan pantau bukti laporan kebersihan harian seluruh pesantren secara real-time.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-center flex-shrink-0">
                <a href="<?= base_url('wilayah/laporan') ?>" class="px-4 py-2.5 rounded-2xl bg-white text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 border border-slate-200/90 font-heading font-extrabold text-xs transition shadow-2xs hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-check text-emerald-600"></i>
                    <span>Rekap Laporan Harian</span>
                </a>

                <?php if (session()->get('role') === 'Admin'): ?>
                    <button type="button" onclick="openModalTambahWilayah()" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Tambah Wilayah Baru</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Summary Stats Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mt-6 pt-6 border-t border-slate-100">
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Total Wilayah</div>
                <div class="text-xl sm:text-2xl font-heading font-extrabold text-slate-900 mt-0.5"><?= $totalWilayah ?> <span class="text-xs font-semibold text-slate-400">Area</span></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200/70">
                <div class="text-[11px] font-extrabold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Sudah Lapor Hari Ini
                </div>
                <div class="text-xl sm:text-2xl font-heading font-extrabold text-emerald-700 mt-0.5"><?= $totalSudahLapor ?> <span class="text-xs font-semibold text-emerald-600/80">Wilayah</span></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-rose-50/70 border border-rose-200/70">
                <div class="text-[11px] font-extrabold text-rose-800 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span> Belum Lapor Hari Ini
                </div>
                <div class="text-xl sm:text-2xl font-heading font-extrabold text-rose-700 mt-0.5"><?= $totalBelumLapor ?> <span class="text-xs font-semibold text-rose-600/80">Wilayah</span></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-teal-50/70 border border-teal-200/70">
                <div class="text-[11px] font-extrabold text-teal-800 uppercase tracking-wider">Rata-rata Skor Harian</div>
                <div class="text-xl sm:text-2xl font-heading font-extrabold text-teal-700 mt-0.5"><?= $avgPesantrenScore ?>%</div>
            </div>
        </div>
    </div>

    <!-- Toolbar Filter & Search -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-slate-50/80 p-3 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div class="relative flex-1 min-w-[220px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            <input type="text" id="searchWilayahInput" onkeyup="filterWilayahCards()" placeholder="Cari nama wilayah, kode, gedung, atau unit pengampu..." class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
        </div>
        
        <div class="flex items-center gap-2 flex-wrap">
            <select id="filterKategoriWilayah" onchange="filterWilayahCards()" class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-extrabold bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                <option value="">Semua Kategori Area</option>
                <option value="Lapangan & Outdoor">Lapangan & Outdoor</option>
                <option value="Tempat Ibadah & Selasar">Tempat Ibadah & Selasar</option>
                <option value="Gedung Sekolah & Kelas">Gedung Sekolah & Kelas</option>
                <option value="Asrama & Kamar Mandi">Asrama & Kamar Mandi</option>
                <option value="Dapur & Kantin">Dapur & Kantin</option>
                <option value="Jalan & Saluran Air">Jalan & Saluran Air</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <select id="filterStatusLapor" onchange="filterWilayahCards()" class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-extrabold bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                <option value="">Status Hari Ini (Semua)</option>
                <option value="sudah">🟢 Sudah Lapor Hari Ini</option>
                <option value="belum">🔴 Belum Lapor Hari Ini</option>
            </select>
        </div>
    </div>

    <!-- Grid Wilayah Cards -->
    <?php if (!empty($wilayahList)): ?>
        <div id="wilayahGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
            <?php foreach ($wilayahList as $w): ?>
                <div class="wilayah-card glass-card rounded-3xl border border-slate-200/80 bg-white overflow-hidden shadow-lg shadow-slate-200/30 hover:shadow-xl transition-all duration-300 flex flex-col group"
                     data-name="<?= strtolower(esc($w['nama_wilayah'])) ?>"
                     data-code="<?= strtolower(esc($w['kode_wilayah'] ?? '')) ?>"
                     data-gedung="<?= strtolower(esc($w['lokasi_gedung'] ?? '')) ?>"
                     data-category="<?= strtolower(esc($w['kategori_area'] ?? '')) ?>"
                     data-reported="<?= $w['is_reported_today'] ? 'sudah' : 'belum' ?>"
                     data-units="<?= strtolower(esc(implode(' ', array_map(function($p) { return ($p['nama_unit'] ?? '') . ' ' . ($p['shift'] ?? ''); }, $w['penugasan'] ?? [])))) ?>">
                    
                    <!-- Card Image Thumbnail -->
                    <div class="relative h-48 bg-slate-100 overflow-hidden border-b border-slate-100">
                        <?php if (!empty($w['primary_foto'])): ?>
                            <img src="<?= esc($w['primary_foto']) ?>" alt="<?= esc($w['nama_wilayah']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400 gap-2">
                                <i class="fa-solid fa-image text-3xl"></i>
                                <span class="text-[11px] font-bold">Belum Ada Foto Master</span>
                            </div>
                        <?php endif; ?>

                        <!-- Top Badges Overlay -->
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2 pointer-events-none">
                            <span class="px-2.5 py-1 rounded-xl bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-heading font-extrabold shadow-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-tag text-emerald-400"></i>
                                <?= esc($w['kode_wilayah'] ?: 'WIL-0' . $w['id']) ?>
                            </span>

                            <span class="px-2.5 py-1 rounded-xl bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-heading font-extrabold shadow-sm">
                                <?= esc($w['kategori_area']) ?>
                            </span>
                        </div>

                        <!-- Bottom Photos Count Badge -->
                        <?php if (!empty($w['fotos']) && count($w['fotos']) > 1): ?>
                            <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded-lg bg-black/60 backdrop-blur-md text-white text-[10px] font-extrabold flex items-center gap-1 shadow-2xs">
                                <i class="fa-solid fa-images"></i>
                                <span><?= count($w['fotos']) ?> Foto</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Body Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-heading font-extrabold text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition">
                                    <a href="<?= base_url('wilayah/detail/' . $w['id']) ?>">
                                        <?= esc($w['nama_wilayah']) ?>
                                    </a>
                                </h3>
                            </div>

                            <?php if (!empty($w['lokasi_gedung'])): ?>
                                <p class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-rose-500 text-[11px]"></i>
                                    <span><?= esc($w['lokasi_gedung']) ?></span>
                                    <?php if (!empty($w['luas_area'])): ?>
                                        <span>&bull;</span>
                                        <span><?= esc($w['luas_area']) ?></span>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($w['deskripsi'])): ?>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                    <?= esc($w['deskripsi']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Assigned Shifts & Units -->
                        <div class="pt-3 border-t border-slate-100 space-y-2">
                            <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center justify-between">
                                <span>Unit Penanggung Jawab</span>
                                <span><?= count($w['penugasan'] ?? []) ?> Shift</span>
                            </div>

                            <?php if (!empty($w['penugasan'])): ?>
                                <div class="flex flex-wrap gap-1.5">
                                    <?php foreach ($w['penugasan'] as $p): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-xl bg-slate-50 border border-slate-200/90 text-slate-700 text-[11px] font-bold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full <?= $p['shift'] === 'Pagi' ? 'bg-amber-400' : ($p['shift'] === 'Sore' ? 'bg-blue-400' : 'bg-teal-400') ?>"></span>
                                            <strong class="text-slate-900"><?= esc($p['shift']) ?>:</strong>
                                            <span><?= esc($p['nama_unit'] ?: 'Belum diatur') ?></span>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-xs text-slate-400 italic py-1">Belum ada unit yang ditugaskan.</div>
                            <?php endif; ?>
                        </div>

                        <!-- Today's Status & Action Footer -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <div>
                                <?php if ($w['is_reported_today']): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/80 text-[11px] font-extrabold shadow-2xs">
                                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                        <span>Sudah Lapor (<?= $w['today_avg_score'] ?>%)</span>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-rose-50 text-rose-800 border border-rose-200/80 text-[11px] font-extrabold shadow-2xs">
                                        <i class="fa-solid fa-clock text-rose-500"></i>
                                        <span>Belum Lapor Hari Ini</span>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($w['active_cs_count'])): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200/80 text-[10px] font-extrabold ml-1 shadow-2xs" title="<?= $w['active_cs_count'] ?> Laporan Masuk">
                                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                                        <span><?= $w['active_cs_count'] ?> Laporan</span>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <a href="<?= base_url('wilayah/detail/' . $w['id']) ?>" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 font-heading font-extrabold text-xs transition border border-slate-200/80 flex items-center gap-1.5 shadow-2xs">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination Bar for Wilayah Master Cards -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-200/80 px-1" id="pagination-container-wilayah-cards">
            <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                <span id="page-info-wilayah-cards">Menampilkan 0 wilayah</span>
                <select id="pageSize-wilayah-cards" onchange="changeWilayahPageSize(this.value)" class="ml-2 px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    <option value="4">4 / hal</option>
                    <option value="8" selected>8 / hal</option>
                    <option value="12">12 / hal</option>
                    <option value="16">16 / hal</option>
                    <option value="24">24 / hal</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="page-buttons-wilayah-cards"></div>
        </div>
    <?php else: ?>
        <div class="glass-card rounded-3xl p-12 text-center bg-white border border-slate-200 shadow-sm space-y-3">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <h3 class="font-heading font-extrabold text-base text-slate-800">Belum Ada Data Wilayah Kebersihan</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto">Klik tombol "Tambah Wilayah Baru" untuk mendaftarkan area kebersihan pesantren dan memploting shift unit.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Tambah Wilayah Baru (2-Column Compact No-Scroll) -->
<div id="modalTambahWilayah" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-slate-100 animate-in fade-in zoom-in duration-200">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-2xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center text-sm shadow-2xs flex-shrink-0">
                    <i class="fa-solid fa-plus-circle"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-base sm:text-lg text-slate-900 leading-tight">
                        Tambah Wilayah Kebersihan Baru
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium">Daftarkan area/zona kebersihan baru dan unggah foto master paten.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalTambahWilayah()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition flex-shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="<?= base_url('wilayah/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-3.5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                <!-- Left Column -->
                <div class="space-y-2.5">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Wilayah / Area <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_wilayah" placeholder="Misal: Lapangan Utama Putri / Masjid" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori Area</label>
                            <select name="kategori_area" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                                <option value="Lapangan & Outdoor">Lapangan</option>
                                <option value="Tempat Ibadah & Selasar">Tempat Ibadah</option>
                                <option value="Gedung Sekolah & Kelas">Sekolah & Kelas</option>
                                <option value="Asrama & Kamar Mandi">Asrama & KM</option>
                                <option value="Dapur & Kantin">Dapur/Kantin</option>
                                <option value="Jalan & Saluran Air">Saluran Air</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kode (Opsional)</label>
                            <input type="text" name="kode_wilayah" placeholder="Auto-generate" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Lokasi Gedung</label>
                            <input type="text" name="lokasi_gedung" placeholder="Gedung C / Asrama" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Luas Area</label>
                            <input type="text" name="luas_area" placeholder="600 m²" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-2.5">
                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi & Batasan Area</label>
                        <textarea name="deskripsi" rows="2" placeholder="Batasan area yang harus disapu, dipel, atau dikontrol..." class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between">
                            <span>Foto Master Wilayah</span>
                            <span class="text-[9px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60">Cloudinary</span>
                        </label>
                        <input type="file" name="foto_wilayah[]" multiple accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-[11px] font-bold bg-slate-50 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-extrabold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition shadow-2xs cursor-pointer">
                    </div>

                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 text-[10.5px] text-slate-500 font-medium flex items-center gap-2">
                        <i class="fa-solid fa-images text-emerald-600 flex-shrink-0 text-xs"></i>
                        <span>Foto master tersimpan paten sebagai profil wilayah kebersihan.</span>
                    </div>
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahWilayah()" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition">Simpan Wilayah</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalTambahWilayah() {
        const modal = document.getElementById('modalTambahWilayah');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalTambahWilayah = openModalTambahWilayah;

    function closeModalTambahWilayah() {
        const modal = document.getElementById('modalTambahWilayah');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalTambahWilayah = closeModalTambahWilayah;

    var currentWilayahPage = 1;
    var wilayahPageSize = 8;
    var visibleWilayahCards = [];

    function renderWilayahPagination() {
        const allCards = Array.from(document.querySelectorAll('.wilayah-card'));
        allCards.forEach(c => c.style.display = 'none');

        const totalItems = visibleWilayahCards.length;
        const totalPages = Math.ceil(totalItems / wilayahPageSize) || 1;

        if (currentWilayahPage > totalPages) currentWilayahPage = totalPages;
        if (currentWilayahPage < 1) currentWilayahPage = 1;

        const startIdx = (currentWilayahPage - 1) * wilayahPageSize;
        const endIdx = Math.min(startIdx + wilayahPageSize, totalItems);

        for (let i = startIdx; i < endIdx; i++) {
            if (visibleWilayahCards[i]) {
                visibleWilayahCards[i].style.display = 'flex';
            }
        }

        // Update Info
        const infoEl = document.getElementById('page-info-wilayah-cards');
        if (infoEl) {
            if (totalItems === 0) {
                infoEl.innerText = 'Tidak ada wilayah yang sesuai filter';
            } else {
                infoEl.innerText = `Menampilkan ${startIdx + 1} - ${endIdx} dari ${totalItems} wilayah`;
            }
        }

        // Render buttons
        const buttonsEl = document.getElementById('page-buttons-wilayah-cards');
        if (!buttonsEl) return;
        buttonsEl.innerHTML = '';
        if (totalPages <= 1) return;

        // Prev
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${currentWilayahPage === 1 ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i>';
        prevBtn.disabled = currentWilayahPage === 1;
        prevBtn.onclick = () => { if (currentWilayahPage > 1) { currentWilayahPage--; renderWilayahPagination(); } };
        buttonsEl.appendChild(prevBtn);

        // Numbers
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentWilayahPage - 1 && p <= currentWilayahPage + 1)) {
                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.className = `w-8 h-8 rounded-xl text-xs font-heading font-extrabold transition shadow-2xs ${p === currentWilayahPage ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700'}`;
                pageBtn.innerText = p;
                pageBtn.onclick = () => { currentWilayahPage = p; renderWilayahPagination(); };
                buttonsEl.appendChild(pageBtn);
            } else if (p === currentWilayahPage - 2 || p === currentWilayahPage + 2) {
                const dots = document.createElement('span');
                dots.className = 'px-1 text-slate-400 text-xs font-bold';
                dots.innerText = '...';
                buttonsEl.appendChild(dots);
            }
        }

        // Next
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-heading font-extrabold transition shadow-2xs ${currentWilayahPage === totalPages ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border-slate-200'}`;
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right text-[10px]"></i>';
        nextBtn.disabled = currentWilayahPage === totalPages;
        nextBtn.onclick = () => { if (currentWilayahPage < totalPages) { currentWilayahPage++; renderWilayahPagination(); } };
        buttonsEl.appendChild(nextBtn);
    }

    function changeWilayahPageSize(val) {
        wilayahPageSize = parseInt(val) || 8;
        currentWilayahPage = 1;
        renderWilayahPagination();
    }
    window.changeWilayahPageSize = changeWilayahPageSize;

    function filterWilayahCards() {
        const search = (document.getElementById('searchWilayahInput')?.value || '').toLowerCase().trim();
        const kat    = (document.getElementById('filterKategoriWilayah')?.value || '').toLowerCase().trim();
        const rep    = (document.getElementById('filterStatusLapor')?.value || '').toLowerCase().trim();

        const allCards = Array.from(document.querySelectorAll('.wilayah-card'));
        visibleWilayahCards = allCards.filter(card => {
            const name     = (card.getAttribute('data-name') || '').toLowerCase();
            const code     = (card.getAttribute('data-code') || '').toLowerCase();
            const gedung   = (card.getAttribute('data-gedung') || '').toLowerCase();
            const category = (card.getAttribute('data-category') || '').toLowerCase();
            const reported = (card.getAttribute('data-reported') || '').toLowerCase();
            const units    = (card.getAttribute('data-units') || '').toLowerCase();

            const matchesSearch = !search || name.includes(search) || code.includes(search) || gedung.includes(search) || units.includes(search);
            const matchesKat    = !kat || category.includes(kat);
            const matchesRep    = !rep || reported === rep;

            return matchesSearch && matchesKat && matchesRep;
        });

        currentWilayahPage = 1;
        renderWilayahPagination();
    }
    window.filterWilayahCards = filterWilayahCards;

    document.addEventListener('DOMContentLoaded', function() {
        visibleWilayahCards = Array.from(document.querySelectorAll('.wilayah-card'));
        renderWilayahPagination();
    });
</script>
<?= $this->endSection() ?>
