<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    <!-- Hero Banner / Page Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-calculator text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-coins"></i> Keuangan Kebersihan
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Buku Keuangan Kebersihan Bulanan
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Kelola laporan keuangan, kode buku, informasi dana masuk, plafon anggaran, serta realisasi pengeluaran kas kebersihan per periode bulan.
                </p>
            </div>

            <?php if (session()->get('role') === 'Admin'): ?>
            <div class="flex-shrink-0">
                <button onclick="openModalCreateKeuangan()" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <span>Buat Buku Keuangan Baru</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Toolbar Filter & Search -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4">
        <!-- Year Filter Pills -->
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <button type="button" onclick="setKeuanganYearFilter('all')" id="kug-pill-all" class="kug-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20">
                <i class="fa-solid fa-layer-group mr-1.5"></i> Semua (<?= count($keuangan_list ?? []) ?>)
            </button>
            <?php 
                $uniqueYears = [];
                if (!empty($keuangan_list)) {
                    foreach ($keuangan_list as $kb) {
                        $y = (string)$kb['tahun'];
                        if (!in_array($y, $uniqueYears)) $uniqueYears[] = $y;
                    }
                    rsort($uniqueYears);
                }
            ?>
            <?php foreach ($uniqueYears as $yr): ?>
                <button type="button" onclick="setKeuanganYearFilter('<?= $yr ?>')" id="kug-pill-<?= $yr ?>" class="kug-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <i class="fa-regular fa-calendar mr-1"></i> <?= $yr ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Search Input -->
        <div class="relative w-full sm:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            <input type="text" id="searchKeuanganInput" oninput="filterKeuanganCards()" placeholder="Cari bulan, tahun, kode keuangan..." class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 bg-white text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
            <button type="button" id="clearSearchKeuanganBtn" onclick="clearSearchKeuangan()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs hidden" title="Hapus Pencarian">
                <i class="fa-solid fa-circle-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Grid List Buku Keuangan Bulanan -->
    <div id="keuanganCardsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php if (!empty($keuangan_list)): ?>
            <?php foreach ($keuangan_list as $buku): ?>
                <div class="keuangan-card group bg-white rounded-3xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 border border-slate-200/80 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden"
                     data-bulan="<?= strtolower(esc($buku['bulan'])) ?>"
                     data-tahun="<?= esc($buku['tahun']) ?>"
                     data-judul="<?= strtolower(esc($buku['judul'])) ?>"
                     data-kode="<?= strtolower(esc($buku['kode_keuangan'] ?? '')) ?>">
                    
                    <!-- Decorative Top Border Gradient -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-400 to-teal-500"></div>

                    <div>
                        <!-- Header & Actions -->
                        <div class="flex items-center justify-between mb-4 pt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <?= esc($buku['kode_keuangan'] ?: 'KUG-' . $buku['tahun']) ?>
                            </span>

                            <?php if (session()->get('role') === 'Admin'): ?>
                            <div class="flex items-center gap-1">
                                <button onclick="openModalEditKeuangan(<?= $buku['id'] ?>, '<?= esc(addslashes($buku['kode_keuangan'] ?? '')) ?>', '<?= esc($buku['bulan']) ?>', <?= esc($buku['tahun']) ?>)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition flex items-center justify-center text-xs" title="Edit Buku Keuangan">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <a href="<?= base_url('keuangan/delete/' . $buku['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus Buku Keuangan ini beserta seluruh data transaksinya?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition flex items-center justify-center text-xs" title="Hapus Buku Keuangan">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Content Body -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex flex-col items-center justify-center text-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                                <span class="font-heading font-extrabold text-base uppercase leading-none"><?= substr($buku['bulan'], 0, 3) ?></span>
                                <span class="text-[10px] text-emerald-100 font-semibold mt-0.5"><?= esc($buku['tahun']) ?></span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-emerald-600 transition leading-snug">
                                    <?= esc($buku['judul']) ?>
                                </h3>
                                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                                    <i class="fa-solid fa-receipt text-slate-400"></i> <?= $buku['total_items'] ?> Item Pembelian
                                </p>
                            </div>
                        </div>

                        <!-- Financial Summary Box inside Card -->
                        <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-200/80 space-y-2 mb-6">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 font-medium">Dana Masuk:</span>
                                <span class="font-extrabold text-blue-700">Rp <?= number_format($buku['total_masuk'], 0, ',', '.') ?></span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 font-medium">Realisasi Terserap:</span>
                                <span class="font-extrabold text-rose-700">Rp <?= number_format($buku['total_terserap'], 0, ',', '.') ?></span>
                            </div>
                            <div class="pt-2 border-t border-slate-200/80 flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-700">Saldo Sisa:</span>
                                <span class="font-extrabold text-emerald-700 text-sm">Rp <?= number_format($buku['saldo_sisa'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button (Emerald Green Theme) -->
                    <div>
                        <a href="<?= base_url('keuangan/detail/' . $buku['id']) ?>" class="w-full py-3 px-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5">
                            <span>Buka Laporan Keuangan</span>
                            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- No search results alert -->
            <div id="noKeuanganFoundAlert" class="col-span-full py-14 text-center bg-white rounded-3xl border border-slate-200 shadow-sm space-y-3 hidden">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 mx-auto flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <h4 class="font-heading font-extrabold text-slate-800 text-sm">Tidak Ditemukan Buku Keuangan</h4>
                    <p class="text-slate-500 text-xs mt-0.5">Coba gunakan kata kunci pencarian atau filter tahun yang lain.</p>
                </div>
                <button type="button" onclick="resetKeuanganFilters()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    Reset Pencarian
                </button>
            </div>
        <?php else: ?>
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="font-heading font-bold text-lg text-slate-800">Belum Ada Buku Keuangan</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Klik tombol di bawah untuk membuat laporan keuangan bulan baru.</p>
                </div>
                <button onclick="openModalCreateKeuangan()" class="px-6 py-2.5 rounded-2xl bg-emerald-600 text-white font-heading font-bold text-xs hover:bg-emerald-700 transition shadow-md">
                    + Buat Buku Keuangan Baru
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Footer for Buku Keuangan Cards -->
    <?php if (!empty($keuangan_list)): ?>
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-200/80 px-1 mt-6" id="keuanganPaginationContainer">
        <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
            <span id="keuanganPageInfo">Menampilkan <?= !empty($keuangan_list) ? ('1 - ' . min(6, count($keuangan_list)) . ' dari ' . count($keuangan_list) . ' buku') : '0 buku' ?></span>
            <select id="keuanganPageSize" onchange="changeKeuanganPageSize(this.value)" class="ml-2 px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                <option value="6" selected>6 / hal</option>
                <option value="9">9 / hal</option>
                <option value="12">12 / hal</option>
                <option value="24">24 / hal</option>
                <option value="all">Semua</option>
            </select>
        </div>
        <div class="flex items-center gap-1.5" id="keuanganPageButtons"></div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Create Buku Keuangan -->
<div id="modalCreateKeuangan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">Buat Buku Keuangan Baru</h3>
                    <p class="text-xs text-slate-500">Pilih periode bulan, tahun, dan kode keuangan</p>
                </div>
            </div>
            <button onclick="closeModalCreateKeuangan()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('keuangan/store') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Keuangan (Opsional)</label>
                <input type="text" name="kode_keuangan" placeholder="Misal: KUG-2026-09 (Otomatis jika kosong)" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Bulan Laporan</label>
                <select name="bulan" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
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
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Laporan</label>
                <select name="tahun" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    <?php
                    $tahunSekarang = date('Y');
                    for ($t = $tahunSekarang - 1; $t <= $tahunSekarang + 3; $t++) :
                    ?>
                        <option value="<?= $t ?>" <?= ($t == $tahunSekarang) ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-slate-100">
                <button type="button" onclick="closeModalCreateKeuangan()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">
                    Buat Buku Keuangan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Buku Keuangan -->
<div id="modalEditKeuangan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">Edit Buku Keuangan</h3>
                    <p class="text-xs text-slate-500">Ubah informasi kode, bulan, dan tahun</p>
                </div>
            </div>
            <button onclick="closeModalEditKeuangan()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formEditKeuangan" action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Keuangan</label>
                <input type="text" name="kode_keuangan" id="edit_kode_keuangan" placeholder="Misal: KUG-2026-08" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Bulan Laporan</label>
                <select name="bulan" id="edit_bulan" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    <?php foreach ($daftarBulan as $b) : ?>
                        <option value="<?= $b ?>"><?= $b ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Laporan</label>
                <select name="tahun" id="edit_tahun" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    <?php for ($t = $tahunSekarang - 1; $t <= $tahunSekarang + 3; $t++) : ?>
                        <option value="<?= $t ?>"><?= $t ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-slate-100">
                <button type="button" onclick="closeModalEditKeuangan()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalCreateKeuangan() {
        const modal = document.getElementById('modalCreateKeuangan');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalCreateKeuangan = openModalCreateKeuangan;

    function closeModalCreateKeuangan() {
        const modal = document.getElementById('modalCreateKeuangan');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalCreateKeuangan = closeModalCreateKeuangan;

    function openModalEditKeuangan(id, kode, bulan, tahun) {
        const form = document.getElementById('formEditKeuangan');
        if (form) form.action = '<?= base_url('keuangan/update/') ?>' + id;
        const kodeEl = document.getElementById('edit_kode_keuangan');
        if (kodeEl) kodeEl.value = kode;
        const bulanEl = document.getElementById('edit_bulan');
        if (bulanEl) bulanEl.value = bulan;
        const tahunEl = document.getElementById('edit_tahun');
        if (tahunEl) tahunEl.value = tahun;
        const modal = document.getElementById('modalEditKeuangan');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalEditKeuangan = openModalEditKeuangan;

    function closeModalEditKeuangan() {
        const modal = document.getElementById('modalEditKeuangan');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalEditKeuangan = closeModalEditKeuangan;

    // Client-side Search, Year Filter & Pagination Logic for Buku Keuangan
    let currentKeuanganYearFilter = 'all';
    let currentKeuanganPage = 1;
    let keuanganPageSize = 6;

    function changeKeuanganPageSize(val) {
        keuanganPageSize = val === 'all' ? 999999 : parseInt(val, 10);
        currentKeuanganPage = 1;
        filterKeuanganCards();
    }
    window.changeKeuanganPageSize = changeKeuanganPageSize;

    function setKeuanganYearFilter(year) {
        currentKeuanganYearFilter = year;
        currentKeuanganPage = 1;
        document.querySelectorAll('.kug-filter-pill').forEach(pill => {
            pill.className = 'kug-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-white text-slate-700 border-slate-200 hover:bg-slate-50';
        });

        const activePillId = year === 'all' ? 'kug-pill-all' : 'kug-pill-' + year;
        const activePill = document.getElementById(activePillId);
        if (activePill) {
            activePill.className = 'kug-filter-pill px-3.5 py-2 rounded-2xl text-xs font-extrabold transition-all duration-200 border bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20';
        }
        filterKeuanganCards();
    }
    window.setKeuanganYearFilter = setKeuanganYearFilter;

    function filterKeuanganCards() {
        const input = document.getElementById('searchKeuanganInput');
        const clearBtn = document.getElementById('clearSearchKeuanganBtn');
        const query = (input?.value || '').toLowerCase().trim();

        if (clearBtn) {
            clearBtn.classList.toggle('hidden', !query);
        }

        const cards = Array.from(document.querySelectorAll('.keuangan-card'));
        const matchedCards = [];

        cards.forEach(card => {
            const bulan = card.dataset.bulan || '';
            const tahun = card.dataset.tahun || '';
            const judul = card.dataset.judul || '';
            const kode = card.dataset.kode || '';

            const matchSearch = !query || bulan.includes(query) || tahun.includes(query) || judul.includes(query) || kode.includes(query);
            const matchYear = (currentKeuanganYearFilter === 'all') || (tahun === currentKeuanganYearFilter);

            if (matchSearch && matchYear) {
                matchedCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        const total = matchedCards.length;
        const totalPages = Math.ceil(total / keuanganPageSize) || 1;
        if (currentKeuanganPage > totalPages) currentKeuanganPage = totalPages;
        if (currentKeuanganPage < 1) currentKeuanganPage = 1;

        const startIdx = (currentKeuanganPage - 1) * keuanganPageSize;
        const endIdx = startIdx + keuanganPageSize;

        matchedCards.forEach((card, idx) => {
            if (idx >= startIdx && idx < endIdx) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        // Update Empty State
        const noFoundAlert = document.getElementById('noKeuanganFoundAlert');
        if (noFoundAlert) {
            noFoundAlert.classList.toggle('hidden', total > 0 || cards.length === 0);
        }

        // Update Pagination Info & Buttons
        const paginationContainer = document.getElementById('keuanganPaginationContainer');
        const pageInfo = document.getElementById('keuanganPageInfo');
        const pageButtons = document.getElementById('keuanganPageButtons');

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
                    currentKeuanganPage === 1
                    ? 'bg-slate-50 text-slate-300 border-slate-200 cursor-not-allowed'
                    : 'bg-white text-slate-700 border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 shadow-2xs'
                }`;
                prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i> <span class="hidden sm:inline">Sebelumnya</span>';
                prevBtn.disabled = currentKeuanganPage === 1;
                prevBtn.onclick = () => {
                    if (currentKeuanganPage > 1) {
                        currentKeuanganPage--;
                        filterKeuanganCards();
                        document.getElementById('keuanganCardsGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                };
                pageButtons.appendChild(prevBtn);

                // Numbered buttons
                let startPage = Math.max(1, currentKeuanganPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                if (startPage > 1) {
                    addKeuanganPageBtn(1, pageButtons);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.className = 'px-1 text-slate-400 text-xs font-bold';
                        dots.textContent = '...';
                        pageButtons.appendChild(dots);
                    }
                }

                for (let p = startPage; p <= endPage; p++) {
                    addKeuanganPageBtn(p, pageButtons);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.className = 'px-1 text-slate-400 text-xs font-bold';
                        dots.textContent = '...';
                        pageButtons.appendChild(dots);
                    }
                    addKeuanganPageBtn(totalPages, pageButtons);
                }

                // Next button
                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.className = `px-3 py-1.5 rounded-xl border text-xs font-bold transition flex items-center gap-1 ${
                    currentKeuanganPage === totalPages
                    ? 'bg-slate-50 text-slate-300 border-slate-200 cursor-not-allowed'
                    : 'bg-white text-slate-700 border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 shadow-2xs'
                }`;
                nextBtn.innerHTML = '<span class="hidden sm:inline">Berikutnya</span> <i class="fa-solid fa-chevron-right text-[10px]"></i>';
                nextBtn.disabled = currentKeuanganPage === totalPages;
                nextBtn.onclick = () => {
                    if (currentKeuanganPage < totalPages) {
                        currentKeuanganPage++;
                        filterKeuanganCards();
                        document.getElementById('keuanganCardsGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                };
                pageButtons.appendChild(nextBtn);
            }
        }
    }
    window.filterKeuanganCards = filterKeuanganCards;

    function addKeuanganPageBtn(page, container) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `w-8 h-8 rounded-xl text-xs font-extrabold transition flex items-center justify-center ${
            page === currentKeuanganPage
            ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20'
            : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:text-emerald-600 shadow-2xs'
        }`;
        btn.textContent = page;
        btn.onclick = () => {
            currentKeuanganPage = page;
            filterKeuanganCards();
            document.getElementById('keuanganCardsGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };
        container.appendChild(btn);
    }

    function clearSearchKeuangan() {
        const input = document.getElementById('searchKeuanganInput');
        if (input) {
            input.value = '';
            input.focus();
        }
        currentKeuanganPage = 1;
        filterKeuanganCards();
    }
    window.clearSearchKeuangan = clearSearchKeuangan;

    function resetKeuanganFilters() {
        clearSearchKeuangan();
        setKeuanganYearFilter('all');
    }
    window.resetKeuanganFilters = resetKeuanganFilters;

    // Initialize pagination immediately and on DOM load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', filterKeuanganCards);
    } else {
        filterKeuanganCards();
    }
    setTimeout(filterKeuanganCards, 50);

    // ESC key closes modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalCreateKeuangan();
            closeModalEditKeuangan();
        }
    });
</script>

<?= $this->endSection() ?>
