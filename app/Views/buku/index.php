<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6 sm:space-y-8">
    <!-- Hero Banner / Page Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-6 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-leaf text-[160px] sm:text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-book-open"></i> Yayasan Assalafiyyah Mlangi
                </span>
                <h1 class="text-2xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Buku LPJ Kebersihan Bulanan
                </h1>
                <p class="text-emerald-100/90 text-xs sm:text-base leading-relaxed">
                    Kelola rancangan program kerja, kalender kegiatan, laporan hasil koordinasi sowan/seminar, dan rekapitulasi pertanggungjawaban kebersihan.
                </p>
            </div>

            <?php if (session()->get('role') === 'Admin'): ?>
            <div class="flex-shrink-0">
                <button onclick="openModalCreate()" class="w-full sm:w-auto px-5 sm:px-6 py-3 sm:py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-xs sm:text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <span>Buat Buku Bulan Baru</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Toolbar Filter & Search -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4">
        <!-- Status Filter Pills -->
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <button type="button" onclick="setBukuFilterStatus('all')" id="buku-pill-all" class="buku-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20">
                <i class="fa-solid fa-layer-group mr-1.5"></i> Semua (<?= count($buku_list ?? []) ?>)
            </button>
            <button type="button" onclick="setBukuFilterStatus('aktif')" id="buku-pill-aktif" class="buku-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-1.5"></span> Aktif
            </button>
            <button type="button" onclick="setBukuFilterStatus('draft proker')" id="buku-pill-draft" class="buku-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                <span class="w-2 h-2 rounded-full bg-amber-500 inline-block mr-1.5"></span> Draft Proker
            </button>
            <button type="button" onclick="setBukuFilterStatus('selesai')" id="buku-pill-selesai" class="buku-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                <span class="w-2 h-2 rounded-full bg-blue-500 inline-block mr-1.5"></span> Selesai
            </button>
        </div>

        <!-- Search Input -->
        <div class="relative w-full sm:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            <input type="text" id="searchBukuInput" oninput="filterBukuCards()" placeholder="Cari bulan, tahun, judul LPJ..." class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 bg-white text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
            <button type="button" id="clearSearchBukuBtn" onclick="clearSearchBuku()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs hidden" title="Hapus Pencarian">
                <i class="fa-solid fa-circle-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Grid List Buku Bulanan -->
    <div id="bukuCardsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php if (!empty($buku_list)): ?>
            <?php foreach ($buku_list as $buku): ?>
                <div class="buku-card group bg-white rounded-3xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 border border-slate-200/80 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden"
                     data-bulan="<?= strtolower(esc($buku['bulan'])) ?>"
                     data-tahun="<?= esc($buku['tahun']) ?>"
                     data-judul="<?= strtolower(esc($buku['judul'])) ?>"
                     data-status="<?= strtolower(esc($buku['status'] ?: 'aktif')) ?>">
                    
                    <!-- Decorative Top Border Gradient -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r 
                        <?= $buku['status'] === 'Draft Proker' ? 'from-amber-400 to-orange-500' : '' ?>
                        <?= ($buku['status'] === 'Aktif' || $buku['status'] === 'AKTIF' || $buku['status'] === 'Berjalan' || empty($buku['status'])) ? 'from-emerald-400 to-teal-500' : '' ?>
                        <?= $buku['status'] === 'Selesai' ? 'from-blue-500 to-indigo-600' : '' ?>">
                    </div>

                    <div>
                        <!-- Status Badge & Quick Edit/Delete Actions -->
                        <div class="flex items-center justify-between mb-5 pt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider
                                <?= $buku['status'] === 'Draft Proker' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' ?>
                                <?= ($buku['status'] === 'Aktif' || $buku['status'] === 'AKTIF' || $buku['status'] === 'Berjalan' || empty($buku['status'])) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' ?>
                                <?= $buku['status'] === 'Selesai' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' ?>">
                                <span class="w-2 h-2 rounded-full 
                                    <?= $buku['status'] === 'Draft Proker' ? 'bg-amber-500 animate-pulse' : '' ?>
                                    <?= ($buku['status'] === 'Aktif' || $buku['status'] === 'AKTIF' || $buku['status'] === 'Berjalan' || empty($buku['status'])) ? 'bg-emerald-500 animate-pulse' : '' ?>
                                    <?= $buku['status'] === 'Selesai' ? 'bg-blue-500' : '' ?>"></span>
                                <?= esc($buku['status'] ?: 'Aktif') ?>
                            </span>

                            <!-- Card Edit & Delete Dropdown Buttons -->
                            <?php if (session()->get('role') === 'Admin'): ?>
                            <div class="flex items-center gap-1">
                                <button onclick="openModalEdit(<?= $buku['id'] ?>, '<?= esc(addslashes($buku['judul'])) ?>', '<?= esc($buku['bulan']) ?>', <?= esc($buku['tahun']) ?>, '<?= esc($buku['status']) ?>')" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition flex items-center justify-center text-xs" title="Edit Informasi Buku">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <a href="<?= base_url('buku/delete/' . $buku['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus Buku LPJ ini beserta seluruh datanya?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition flex items-center justify-center text-xs" title="Hapus Buku">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Content Body -->
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex flex-col items-center justify-center text-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                                <span class="font-heading font-extrabold text-base uppercase leading-none"><?= substr($buku['bulan'], 0, 3) ?></span>
                                <span class="text-[10px] text-emerald-100 font-semibold mt-0.5"><?= esc($buku['tahun']) ?></span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-emerald-600 transition leading-snug">
                                    Buku LPJ <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2"><?= esc($buku['judul']) ?></p>
                            </div>
                        </div>

                        <!-- Quick Stats Indicators -->
                        <div class="grid grid-cols-2 gap-2 p-3 rounded-2xl bg-slate-50/80 border border-slate-100 text-xs mb-6">
                            <div class="flex items-center gap-2 text-slate-600">
                                <div class="w-6 h-6 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center text-[10px]">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>
                                <span class="font-semibold text-slate-800"><?= $buku['total_proker'] ?></span>
                                <span class="text-slate-400 text-[11px]">Agenda</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px]">
                                    <i class="fa-solid fa-handshake"></i>
                                </div>
                                <span class="font-semibold text-slate-800"><?= $buku['total_koordinasi'] ?></span>
                                <span class="text-slate-400 text-[11px]">Laporan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                        <?php 
                            $userRole = session()->get('role');
                            $bStatus = $buku['status'] ?? 'Aktif';
                            $isAktifBuku = in_array(strtolower(trim($bStatus)), ['aktif', 'berjalan']);
                            $canEditThisBuku = ($userRole === 'Admin') || $isAktifBuku;
                        ?>
                        <?php if ($canEditThisBuku): ?>
                            <a href="<?= base_url('buku/detail/' . $buku['id']) ?>" class="flex-1 py-2.5 px-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs text-center hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5">
                                <i class="fa-solid fa-folder-open"></i> <span>Kelola & Isi LPJ</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('buku/detail/' . $buku['id']) ?>" class="flex-1 py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs text-center transition-all duration-200 flex items-center justify-center gap-1.5 border border-slate-200 shadow-2xs">
                                <i class="fa-solid fa-eye text-emerald-600"></i> <span>Lihat LPJ (Hanya Lihat)</span>
                            </a>
                        <?php endif; ?>
                        <button type="button" onclick="openModalPreviewDoc(<?= $buku['id'] ?>, 'Buku LPJ <?= esc(addslashes($buku['bulan'] . ' ' . $buku['tahun'])) ?>')" class="py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-extrabold text-xs transition-all duration-200 border border-emerald-200/90 flex items-center justify-center gap-1.5 shadow-2xs" title="Preview Hasil Dokumen LPJ Langsung">
                            <i class="fa-solid fa-eye text-emerald-600"></i>
                        </button>
                        <a href="<?= base_url('buku/cetak/' . $buku['id']) ?>" target="_blank" class="py-2.5 px-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition border border-slate-200 flex items-center justify-center" title="Buka Halaman Cetak (Tab Baru)">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- No search results alert -->
            <div id="noBukuFoundAlert" class="col-span-full py-14 text-center bg-white rounded-3xl border border-slate-200 shadow-sm space-y-3 hidden">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 mx-auto flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <h4 class="font-heading font-extrabold text-slate-800 text-sm">Tidak Ditemukan Buku LPJ</h4>
                    <p class="text-slate-500 text-xs mt-0.5">Coba gunakan kata kunci pencarian atau filter status yang lain.</p>
                </div>
                <button type="button" onclick="resetBukuFilters()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    Reset Pencarian
                </button>
            </div>
        <?php else: ?>
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center text-3xl">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-slate-800 text-lg">Belum Ada Buku Kebersihan Bulanan</h3>
                    <p class="text-slate-500 text-xs mt-1">Mulai buat rancangan proker dan LPJ bulanan pertama Anda.</p>
                </div>
                <button onclick="openModalCreate()" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold text-xs hover:bg-emerald-700 transition shadow-md">
                    + Buat Buku Pertama
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Footer for Buku LPJ Cards -->
    <?php if (!empty($buku_list)): ?>
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-200/80 px-1 mt-6" id="bukuPaginationContainer">
        <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
            <span id="bukuPageInfo">Menampilkan <?= !empty($buku_list) ? ('1 - ' . min(6, count($buku_list)) . ' dari ' . count($buku_list) . ' buku') : '0 buku' ?></span>
            <select id="bukuPageSize" onchange="changeBukuPageSize(this.value)" class="ml-2 px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                <option value="6" selected>6 / hal</option>
                <option value="9">9 / hal</option>
                <option value="12">12 / hal</option>
                <option value="24">24 / hal</option>
                <option value="all">Semua</option>
            </select>
        </div>
        <div class="flex items-center gap-1.5" id="bukuPageButtons"></div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal 1: Buat Buku Baru -->
<div id="modalCreate" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-7 shadow-2xl space-y-5 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-sm"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900">Buat Buku Bulan Baru</h3>
            </div>
            <button onclick="closeModalCreate()" class="text-slate-400 hover:text-slate-600 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form action="<?= base_url('buku/store') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Pilih Bulan</label>
                <select name="bulan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September" selected>September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tahun</label>
                <input type="number" name="tahun" value="<?= date('Y') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalCreate()" class="px-5 py-2.5 rounded-xl text-slate-600 text-xs font-semibold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 shadow-md shadow-emerald-500/20">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Edit Buku LPJ (CARD EDIT FEATURE) -->
<div id="modalEdit" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-7 shadow-2xl space-y-5 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900">Edit Informas Buku LPJ</h3>
            </div>
            <button onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form id="formEditBuku" action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Buku LPJ</label>
                <input type="text" name="judul" id="edit_judul" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Bulan</label>
                    <select name="bulan" id="edit_bulan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tahun</label>
                    <input type="number" name="tahun" id="edit_tahun" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Status Buku</label>
                <select name="status" id="edit_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs font-semibold bg-slate-50">
                    <option value="Aktif">🟢 Aktif</option>
                    <option value="Draft Proker">🟠 Draft Proker</option>
                    <option value="Selesai">🔵 Selesai</option>
                </select>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEdit()" class="px-5 py-2.5 rounded-xl text-slate-600 text-xs font-semibold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 shadow-md shadow-emerald-500/20">Perbarui Buku</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Quick Preview Dokumen LPJ -->
<div id="modalPreviewDoc" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden flex items-center justify-center p-2 sm:p-4 md:p-6 overflow-hidden">
    <div class="bg-white rounded-3xl max-w-5xl w-full h-[92vh] max-h-[900px] shadow-2xl flex flex-col border border-slate-200 overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Preview Modal Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/90 gap-3 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-cyan-600 to-teal-500 text-white flex items-center justify-center shadow-md shadow-cyan-600/20 flex-shrink-0">
                    <i class="fa-solid fa-file-invoice text-sm"></i>
                </div>
                <div>
                    <h3 id="previewDocTitle" class="font-heading font-extrabold text-sm sm:text-base text-slate-900 leading-tight">
                        Preview Dokumen LPJ
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium">Tampilan langsung hasil cetak dokumen LPJ</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2 flex-wrap justify-end">
                <!-- Zoom Controller Bar -->
                <div class="flex items-center bg-white border border-slate-200/90 rounded-xl p-0.5 shadow-2xs">
                    <button type="button" onclick="modalZoomDoc(-0.1)" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-600 flex items-center justify-center text-xs transition" title="Perkecil / Zoom Out (Ctrl -)">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <button type="button" onclick="modalResetZoom()" id="modalZoomBadge" class="px-2 py-0.5 text-[11px] font-bold text-slate-700 hover:text-emerald-700 min-w-[44px] text-center" title="Klik untuk reset 100%">
                        100%
                    </button>
                    <button type="button" onclick="modalZoomDoc(0.1)" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-600 flex items-center justify-center text-xs transition" title="Perbesar / Zoom In (Ctrl +)">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <button type="button" onclick="modalFitWidth()" class="px-2 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-extrabold flex items-center gap-1 transition ml-0.5 border border-emerald-200/60" title="Sesuaikan Lebar Layar (Fit Width)">
                        <i class="fa-solid fa-arrows-left-right text-[10px]"></i>
                        <span class="hidden sm:inline">Fit</span>
                    </button>
                </div>

                <a id="previewOpenTabBtn" href="#" target="_blank" class="py-1.5 px-3 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition border border-slate-200 shadow-2xs" title="Buka di tab baru">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-500"></i>
                    <span class="hidden sm:inline">Tab Baru</span>
                </a>
                <button type="button" onclick="printPreviewIframe()" class="py-1.5 px-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-xs flex items-center gap-1.5 shadow-md shadow-emerald-600/20 transition" title="Cetak Dokumen">
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

<script>
    function openModalCreate() {
        const modal = document.getElementById('modalCreate');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalCreate = openModalCreate;

    function closeModalCreate() {
        const modal = document.getElementById('modalCreate');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalCreate = closeModalCreate;

    function openModalEdit(id, judul, bulan, tahun, status) {
        const form = document.getElementById('formEditBuku');
        if (form) form.action = '<?= base_url('buku/update/') ?>' + id;
        const judulEl = document.getElementById('edit_judul');
        if (judulEl) judulEl.value = judul;
        const bulanEl = document.getElementById('edit_bulan');
        if (bulanEl) bulanEl.value = bulan;
        const tahunEl = document.getElementById('edit_tahun');
        if (tahunEl) tahunEl.value = tahun;

        var normStatus = 'Aktif';
        if (status) {
            const s = status.toString().toLowerCase();
            if (s.includes('draft')) normStatus = 'Draft Proker';
            else if (s.includes('selesai')) normStatus = 'Selesai';
            else normStatus = 'Aktif';
        }

        const statEl = document.getElementById('edit_status');
        if (statEl) statEl.value = normStatus;
        const modal = document.getElementById('modalEdit');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalEdit = openModalEdit;

    function closeModalEdit() {
        const modal = document.getElementById('modalEdit');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalEdit = closeModalEdit;

    // Quick Preview Modal Functions & Zoom Controller
    let currentModalZoom = 1.0;

    function openModalPreviewDoc(id, title) {
        const modal = document.getElementById('modalPreviewDoc');
        const iframe = document.getElementById('previewDocIframe');
        const loader = document.getElementById('previewIframeLoader');
        const titleEl = document.getElementById('previewDocTitle');
        const tabBtn = document.getElementById('previewOpenTabBtn');
        const rawUrl = '<?= base_url('buku/cetak/') ?>' + id;
        const embedUrl = rawUrl + '?embed=1';

        currentModalZoom = 1.0;
        updateModalZoomUI(1.0);

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

        // Auto zoom comfortably on small screens
        const iframe = document.getElementById('previewDocIframe');
        if (iframe && iframe.clientWidth < 880) {
            modalFitWidth();
        }
    }
    window.handleIframeLoaded = handleIframeLoaded;

    function modalZoomDoc(delta) {
        const iframe = document.getElementById('previewDocIframe');
        if (!iframe || !iframe.contentWindow) return;
        currentModalZoom = Math.min(Math.max(0.3, parseFloat((currentModalZoom + delta).toFixed(2))), 2.5);
        updateModalZoomUI(currentModalZoom);
        iframe.contentWindow.postMessage({ action: 'setZoom', zoom: currentModalZoom }, '*');
    }
    window.modalZoomDoc = modalZoomDoc;

    function modalResetZoom() {
        currentModalZoom = 1.0;
        updateModalZoomUI(1.0);
        const iframe = document.getElementById('previewDocIframe');
        if (iframe && iframe.contentWindow) {
            iframe.contentWindow.postMessage({ action: 'resetZoom' }, '*');
        }
    }
    window.modalResetZoom = modalResetZoom;

    function modalFitWidth() {
        const iframe = document.getElementById('previewDocIframe');
        if (iframe && iframe.contentWindow) {
            iframe.contentWindow.postMessage({ action: 'fitWidth' }, '*');
        }
    }
    window.modalFitWidth = modalFitWidth;

    function updateModalZoomUI(zoomVal) {
        const badge = document.getElementById('modalZoomBadge');
        if (badge) {
            badge.textContent = Math.round(zoomVal * 100) + '%';
        }
    }

    // Sync when iframe changes zoom (e.g. from internal floating zoom widget)
    window.addEventListener('message', function(e) {
        if (!e.data) return;
        if (e.data.action === 'zoomChanged' && typeof e.data.zoom === 'number') {
            currentModalZoom = e.data.zoom;
            updateModalZoomUI(e.data.zoom);
        }
    });

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
            closeModalCreate();
            closeModalEdit();
        }
    });

    // Client-side Search, Status Filter & Pagination Logic for Buku LPJ
    let currentBukuStatusFilter = 'all';
    let currentBukuPage = 1;
    let bukuPageSize = 6;

    function changeBukuPageSize(val) {
        bukuPageSize = val === 'all' ? 999999 : parseInt(val, 10);
        currentBukuPage = 1;
        filterBukuCards();
    }
    window.changeBukuPageSize = changeBukuPageSize;

    function setBukuFilterStatus(status) {
        currentBukuStatusFilter = status;
        currentBukuPage = 1;
        document.querySelectorAll('.buku-filter-pill').forEach(pill => {
            pill.className = 'buku-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-white text-slate-700 border-slate-200 hover:bg-slate-50';
        });

        const activePillId = status === 'all' ? 'buku-pill-all' : (status === 'aktif' ? 'buku-pill-aktif' : (status === 'draft proker' ? 'buku-pill-draft' : 'buku-pill-selesai'));
        const activePill = document.getElementById(activePillId);
        if (activePill) {
            activePill.className = 'buku-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20';
        }
        filterBukuCards();
    }
    window.setBukuFilterStatus = setBukuFilterStatus;

    function filterBukuCards() {
        const input = document.getElementById('searchBukuInput');
        const clearBtn = document.getElementById('clearSearchBukuBtn');
        const query = (input?.value || '').toLowerCase().trim();

        if (clearBtn) {
            clearBtn.classList.toggle('hidden', !query);
        }

        const cards = Array.from(document.querySelectorAll('.buku-card'));
        const matchedCards = [];

        cards.forEach(card => {
            const bulan = card.dataset.bulan || '';
            const tahun = card.dataset.tahun || '';
            const judul = card.dataset.judul || '';
            const status = card.dataset.status || '';

            const matchSearch = !query || bulan.includes(query) || tahun.includes(query) || judul.includes(query);
            const matchStatus = (currentBukuStatusFilter === 'all') || (status.includes(currentBukuStatusFilter));

            if (matchSearch && matchStatus) {
                matchedCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        const total = matchedCards.length;
        const totalPages = Math.ceil(total / bukuPageSize) || 1;
        if (currentBukuPage > totalPages) currentBukuPage = totalPages;
        if (currentBukuPage < 1) currentBukuPage = 1;

        const startIdx = (currentBukuPage - 1) * bukuPageSize;
        const endIdx = startIdx + bukuPageSize;

        matchedCards.forEach((card, idx) => {
            if (idx >= startIdx && idx < endIdx) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        // Update Empty State
        const noFoundAlert = document.getElementById('noBukuFoundAlert');
        if (noFoundAlert) {
            noFoundAlert.classList.toggle('hidden', total > 0 || cards.length === 0);
        }

        // Update Pagination Info & Buttons
        const paginationContainer = document.getElementById('bukuPaginationContainer');
        const pageInfo = document.getElementById('bukuPageInfo');
        const pageButtons = document.getElementById('bukuPageButtons');

        if (paginationContainer) {
            paginationContainer.classList.toggle('hidden', cards.length === 0 || total === 0);
        }

        if (pageInfo) {
            if (total === 0) {
                pageInfo.textContent = 'Menampilkan 0 buku';
            } else {
                const actualEnd = Math.min(endIdx, total);
                pageInfo.textContent = `Menampilkan ${startIdx + 1} - ${actualEnd} dari ${total} buku`;
            }
        }

        if (pageButtons) {
            pageButtons.innerHTML = '';
            if (totalPages > 1) {
                // Prev button
                const prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-bold transition flex items-center gap-1 ${
                    currentBukuPage === 1
                    ? 'bg-slate-50 text-slate-300 border-slate-200 cursor-not-allowed'
                    : 'bg-white text-slate-700 border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 shadow-2xs'
                }`;
                prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i> <span class="hidden sm:inline">Sebelumnya</span>';
                prevBtn.disabled = currentBukuPage === 1;
                prevBtn.onclick = () => {
                    if (currentBukuPage > 1) {
                        currentBukuPage--;
                        filterBukuCards();
                        document.getElementById('bukuCardsGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                };
                pageButtons.appendChild(prevBtn);

                // Numbered buttons
                let startPage = Math.max(1, currentBukuPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                if (startPage > 1) {
                    addBukuPageBtn(1, pageButtons);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.className = 'px-1 text-slate-400 text-xs font-bold';
                        dots.textContent = '...';
                        pageButtons.appendChild(dots);
                    }
                }

                for (let p = startPage; p <= endPage; p++) {
                    addBukuPageBtn(p, pageButtons);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.className = 'px-1 text-slate-400 text-xs font-bold';
                        dots.textContent = '...';
                        pageButtons.appendChild(dots);
                    }
                    addBukuPageBtn(totalPages, pageButtons);
                }

                // Next button
                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-bold transition flex items-center gap-1 ${
                    currentBukuPage === totalPages
                    ? 'bg-slate-50 text-slate-300 border-slate-200 cursor-not-allowed'
                    : 'bg-white text-slate-700 border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 shadow-2xs'
                }`;
                nextBtn.innerHTML = '<span class="hidden sm:inline">Berikutnya</span> <i class="fa-solid fa-chevron-right text-[10px]"></i>';
                nextBtn.disabled = currentBukuPage === totalPages;
                nextBtn.onclick = () => {
                    if (currentBukuPage < totalPages) {
                        currentBukuPage++;
                        filterBukuCards();
                        document.getElementById('bukuCardsGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                };
                pageButtons.appendChild(nextBtn);
            }
        }
    }
    window.filterBukuCards = filterBukuCards;

    function addBukuPageBtn(page, container) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `w-8 h-8 rounded-xl text-xs font-extrabold transition flex items-center justify-center ${
            page === currentBukuPage
            ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20'
            : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:text-emerald-600 shadow-2xs'
        }`;
        btn.textContent = page;
        btn.onclick = () => {
            currentBukuPage = page;
            filterBukuCards();
            document.getElementById('bukuCardsGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };
        container.appendChild(btn);
    }

    function clearSearchBuku() {
        const input = document.getElementById('searchBukuInput');
        if (input) {
            input.value = '';
            input.focus();
        }
        currentBukuPage = 1;
        filterBukuCards();
    }
    window.clearSearchBuku = clearSearchBuku;

    function resetBukuFilters() {
        clearSearchBuku();
        setBukuFilterStatus('all');
    }
    window.resetBukuFilters = resetBukuFilters;

    // Initialize pagination immediately and on DOM load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', filterBukuCards);
    } else {
        filterBukuCards();
    }
    setTimeout(filterBukuCards, 50);
</script>

<?= $this->endSection() ?>
