<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-boxes-stacked text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-boxes-stacked"></i> Modul Pengajuan Multi-Alat Unit
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Permohonan Peralatan Baru Gudang Kebersihan
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Pengurus & Kader dapat mengajukan beberapa jenis alat kebersihan sekaligus dalam satu form pengajuan resmi ke Gudang K3L.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Form Pengajuan Alat (Multi-Item Cart) -->
        <div class="lg:col-span-5 glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-cart-flatbed text-emerald-600"></i> Formulir Pengajuan Alat
                </h3>
                <span id="cartSummaryBadge" class="text-[11px] font-extrabold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                    1 Jenis Alat
                </span>
            </div>

            <form action="<?= base_url('app/pengajuan-alat/store') ?>" method="POST" id="formPengajuanMulti" class="space-y-5">
                <!-- Multi-Item Container -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Daftar Alat Yang Diajukan <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" onclick="addPengajuanRow()" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1 rounded-xl border border-emerald-200/80 transition flex items-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-plus text-[10px]"></i> Tambah Alat Lain
                        </button>
                    </div>

                    <div id="pengajuanItemsContainer" class="space-y-3">
                        <!-- Item Row 0 (Default) -->
                        <div class="pengajuan-item-card p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:border-emerald-300 transition space-y-3 relative group" data-row-index="0">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-extrabold text-slate-600 bg-white px-2 py-0.5 rounded-md border border-slate-200 shadow-2xs item-number-label">
                                    <i class="fa-solid fa-box text-emerald-600 mr-1"></i> Item #1
                                </span>
                                <button type="button" onclick="removePengajuanRow(this)" class="text-slate-400 hover:text-rose-600 text-xs p-1 rounded-lg hover:bg-rose-50 transition btn-remove-row hidden" title="Hapus baris ini">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>

                            <div class="space-y-2">
                                <!-- Searchable Alat Picker for Row 0 -->
                                <div class="relative row-alat-picker-container">
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1 flex items-center justify-between">
                                        <span>Pilih Alat <span class="text-rose-500">*</span></span>
                                        <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                            <i class="fa-solid fa-magnifying-glass text-[8px]"></i> Bisa dicari
                                        </span>
                                    </label>
                                    <input type="hidden" name="items[0][alat_id]" class="input-alat-id" required value="">
                                    <div class="relative">
                                        <i class="fa-solid fa-broom-ball absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                                        <input type="text" placeholder="Ketik nama alat untuk mencari..." autocomplete="off" onfocus="openRowAlatPicker(this)" oninput="filterRowAlatPicker(this)" class="input-alat-search w-full pl-9 pr-8 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400" required>
                                        <button type="button" onclick="toggleRowAlatPicker(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 row-alat-icon"></i>
                                        </button>
                                    </div>

                                    <!-- Dropdown List -->
                                    <div class="row-alat-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                                        <?php foreach ($alatList as $a): ?>
                                            <div class="row-alat-option px-3.5 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer"
                                                 data-id="<?= $a['id'] ?>"
                                                 data-name="<?= esc($a['nama_alat']) ?>"
                                                 data-stok="<?= $a['stok_sisa'] ?>"
                                                 data-satuan="<?= esc($a['satuan']) ?>"
                                                 data-kategori="<?= esc($a['kategori'] ?? 'Umum') ?>"
                                                 onclick="selectRowAlatOption(this)">
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
                                        <div class="no-alat-option-found px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                            Tidak ditemukan alat kebersihan yang sesuai.
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3 items-end">
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Jumlah</label>
                                        <div class="relative">
                                            <input type="number" name="items[0][jumlah]" value="1" min="1" required oninput="updateCartSummary()" class="input-jumlah w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                                        </div>
                                    </div>
                                    <div class="pb-1 text-right">
                                        <div class="stock-info-badge inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-slate-100 text-slate-500 border border-slate-200">
                                            <span>Pilih alat dulu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alasan Keperluan Pengajuan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alasan_keperluan" rows="3" placeholder="Jelaskan kebutuhan pengajuan alat ini secara ringkas..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                </div>

                <button type="submit" id="btnSubmitPengajuan" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span id="btnSubmitLabel">Kirim Pengajuan ke Admin K3L</span>
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Pengajuan Alat -->
        <div class="lg:col-span-7 glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Riwayat Pengajuan Alat Unit Saya
                </h3>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-56">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input type="text" id="searchMyPengajuanPageInput" onkeyup="filterMyPengajuanPageTable()" placeholder="Cari alat / alasan..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    </div>
                    <span class="text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 whitespace-nowrap">
                        <?= count($myPengajuan) ?> Pengajuan
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
                <table id="tableMyPengajuanPage" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                        <tr>
                            <th width="5%" class="py-3.5 px-3 text-center">NO</th>
                            <th width="20%" class="py-3.5 px-4">TANGGAL</th>
                            <th width="30%" class="py-3.5 px-4">PERALATAN</th>
                            <th width="30%" class="py-3.5 px-4">ALASAN KEPERLUAN</th>
                            <th width="15%" class="py-3.5 px-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($myPengajuan)): ?>
                            <?php foreach ($myPengajuan as $idx => $p): ?>
                                <tr class="my-pengajuan-page-row hover:bg-slate-50/90 transition-all">
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
                                <td colspan="5" class="py-12 text-center text-slate-400 italic font-medium">Belum ada riwayat pengajuan alat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-my-pengajuan-page">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-my-pengajuan-page">Menampilkan 0 data</span>
                    <select id="pageSize-my-pengajuan-page" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5">5 / hal</option>
                        <option value="10" selected>10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-my-pengajuan-page"></div>
            </div>
        </div>
    </div>
</div>

<!-- Raw Template for Cloned Searchable Dropdown Items -->
<template id="alatDropdownItemsTemplate">
    <?php foreach ($alatList as $a): ?>
        <div class="row-alat-option px-3.5 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer"
             data-id="<?= $a['id'] ?>"
             data-name="<?= esc($a['nama_alat']) ?>"
             data-stok="<?= $a['stok_sisa'] ?>"
             data-satuan="<?= esc($a['satuan']) ?>"
             data-kategori="<?= esc($a['kategori'] ?? 'Umum') ?>"
             onclick="selectRowAlatOption(this)">
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
    <div class="no-alat-option-found px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
        Tidak ditemukan alat kebersihan yang sesuai.
    </div>
</template>

<script>
    var paginatorMyPengajuanPage;

    function initPengajuanPagePaginator() {
        if (typeof TablePaginator !== 'undefined' && document.getElementById('tableMyPengajuanPage')) {
            paginatorMyPengajuanPage = new TablePaginator('tableMyPengajuanPage', 'page-info-my-pengajuan-page', 'page-buttons-my-pengajuan-page', 'pageSize-my-pengajuan-page');
            paginatorMyPengajuanPage.render();
        }
    }
    window.initPengajuanPagePaginator = initPengajuanPagePaginator;
    window.rebindPageEvents = initPengajuanPagePaginator;

    document.addEventListener('DOMContentLoaded', function() {
        initPengajuanPagePaginator();
        updateRowIndexLabels();
    });
    initPengajuanPagePaginator();

    function filterMyPengajuanPageTable() {
        const input = document.getElementById('searchMyPengajuanPageInput');
        if (!input) return;
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#tableMyPengajuanPage tbody tr.my-pengajuan-page-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
        });

        if (paginatorMyPengajuanPage) {
            paginatorMyPengajuanPage.currentPage = 1;
            paginatorMyPengajuanPage.render();
        }
    }
    window.filterMyPengajuanPageTable = filterMyPengajuanPageTable;

    // Searchable Alat Dropdown Handlers
    function openRowAlatPicker(input) {
        closeAllRowAlatPickers();
        const container = input.closest('.row-alat-picker-container');
        if (!container) return;
        const dropdown = container.querySelector('.row-alat-dropdown');
        const icon = container.querySelector('.row-alat-icon');
        if (dropdown) dropdown.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openRowAlatPicker = openRowAlatPicker;

    function toggleRowAlatPicker(btn) {
        const container = btn.closest('.row-alat-picker-container');
        if (!container) return;
        const dropdown = container.querySelector('.row-alat-dropdown');
        const icon = container.querySelector('.row-alat-icon');
        if (dropdown) {
            const isHidden = dropdown.classList.contains('hidden');
            closeAllRowAlatPickers();
            if (isHidden) {
                dropdown.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            }
        }
    }
    window.toggleRowAlatPicker = toggleRowAlatPicker;

    function closeAllRowAlatPickers() {
        document.querySelectorAll('.row-alat-dropdown').forEach(dd => dd.classList.add('hidden'));
        document.querySelectorAll('.row-alat-icon').forEach(icon => icon.classList.remove('rotate-180'));
    }
    window.closeAllRowAlatPickers = closeAllRowAlatPickers;

    function filterRowAlatPicker(input) {
        openRowAlatPicker(input);
        const container = input.closest('.row-alat-picker-container');
        if (!container) return;

        const query = (input.value || '').toLowerCase().trim();
        const options = container.querySelectorAll('.row-alat-option');
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

        const noFound = container.querySelector('.no-alat-option-found');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterRowAlatPicker = filterRowAlatPicker;

    function selectRowAlatOption(opt) {
        const card = opt.closest('.pengajuan-item-card');
        const container = opt.closest('.row-alat-picker-container');
        if (!card || !container) return;

        const id = opt.dataset.id || '';
        const name = opt.dataset.name || '';
        const stok = parseInt(opt.dataset.stok || '0', 10);
        const satuan = opt.dataset.satuan || 'Unit';

        const inputId = container.querySelector('.input-alat-id');
        const inputSearch = container.querySelector('.input-alat-search');
        const badge = card.querySelector('.stock-info-badge');

        if (inputId) inputId.value = id;
        if (inputSearch) inputSearch.value = `${name} (Sisa: ${stok} ${satuan})`;

        if (badge) {
            if (stok > 3) {
                badge.className = 'stock-info-badge inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200';
                badge.innerHTML = `<i class="fa-solid fa-check text-[9px]"></i> Sisa: ${stok} ${satuan}`;
            } else if (stok > 0) {
                badge.className = 'stock-info-badge inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200';
                badge.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Menipis: ${stok} ${satuan}`;
            } else {
                badge.className = 'stock-info-badge inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-rose-50 text-rose-800 border border-rose-200';
                badge.innerHTML = `<i class="fa-solid fa-ban text-[9px]"></i> Stok Habis (0 ${satuan})`;
            }
        }

        closeAllRowAlatPickers();
        updateCartSummary();
    }
    window.selectRowAlatOption = selectRowAlatOption;

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.row-alat-picker-container')) {
            closeAllRowAlatPickers();
        }
    });

    // Multi-Item Repeater Logic
    let rowCounter = 1;

    function addPengajuanRow() {
        const container = document.getElementById('pengajuanItemsContainer');
        const templateHtml = document.getElementById('alatDropdownItemsTemplate').innerHTML;
        const currentIndex = rowCounter++;

        const newCard = document.createElement('div');
        newCard.className = 'pengajuan-item-card p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:border-emerald-300 transition space-y-3 relative group animate-fade-in';
        newCard.dataset.rowIndex = currentIndex;

        newCard.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-slate-600 bg-white px-2 py-0.5 rounded-md border border-slate-200 shadow-2xs item-number-label">
                    <i class="fa-solid fa-box text-emerald-600 mr-1"></i> Item #${currentIndex + 1}
                </span>
                <button type="button" onclick="removePengajuanRow(this)" class="text-slate-400 hover:text-rose-600 text-xs p-1 rounded-lg hover:bg-rose-50 transition btn-remove-row" title="Hapus baris ini">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
            <div class="space-y-2">
                <div class="relative row-alat-picker-container">
                    <label class="block text-[11px] font-bold text-slate-600 mb-1 flex items-center justify-between">
                        <span>Pilih Alat <span class="text-rose-500">*</span></span>
                        <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                            <i class="fa-solid fa-magnifying-glass text-[8px]"></i> Bisa dicari
                        </span>
                    </label>
                    <input type="hidden" name="items[${currentIndex}][alat_id]" class="input-alat-id" required value="">
                    <div class="relative">
                        <i class="fa-solid fa-broom-ball absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                        <input type="text" placeholder="Ketik nama alat untuk mencari..." autocomplete="off" onfocus="openRowAlatPicker(this)" oninput="filterRowAlatPicker(this)" class="input-alat-search w-full pl-9 pr-8 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400" required>
                        <button type="button" onclick="toggleRowAlatPicker(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 row-alat-icon"></i>
                        </button>
                    </div>
                    <div class="row-alat-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                        ${templateHtml}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 items-end">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Jumlah</label>
                        <div class="relative">
                            <input type="number" name="items[${currentIndex}][jumlah]" value="1" min="1" required oninput="updateCartSummary()" class="input-jumlah w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>
                    <div class="pb-1 text-right">
                        <div class="stock-info-badge inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-slate-100 text-slate-500 border border-slate-200">
                            <span>Pilih alat dulu</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(newCard);
        updateRowIndexLabels();
        updateCartSummary();
    }
    window.addPengajuanRow = addPengajuanRow;

    function removePengajuanRow(btn) {
        const card = btn.closest('.pengajuan-item-card');
        if (card) {
            card.remove();
            updateRowIndexLabels();
            updateCartSummary();
        }
    }
    window.removePengajuanRow = removePengajuanRow;

    function updateRowIndexLabels() {
        const cards = document.querySelectorAll('.pengajuan-item-card');
        cards.forEach((card, idx) => {
            const label = card.querySelector('.item-number-label');
            if (label) {
                label.innerHTML = `<i class="fa-solid fa-box text-emerald-600 mr-1"></i> Item #${idx + 1}`;
            }
            const removeBtn = card.querySelector('.btn-remove-row');
            if (removeBtn) {
                removeBtn.classList.toggle('hidden', cards.length <= 1);
            }
        });
    }

    function updateCartSummary() {
        const cards = document.querySelectorAll('.pengajuan-item-card');
        let totalItems = 0;
        let totalUnits = 0;

        cards.forEach(card => {
            const inputId = card.querySelector('.input-alat-id');
            const inputJumlah = card.querySelector('.input-jumlah');
            if (inputId && inputId.value) {
                totalItems++;
                totalUnits += parseInt(inputJumlah?.value || '1', 10);
            }
        });

        const badge = document.getElementById('cartSummaryBadge');
        if (badge) {
            badge.innerText = `${cards.length} Jenis Alat`;
        }

        const submitBtnLabel = document.getElementById('btnSubmitLabel');
        if (submitBtnLabel) {
            if (cards.length > 1) {
                submitBtnLabel.innerText = `Kirim ${cards.length} Pengajuan Alat ke Admin`;
            } else {
                submitBtnLabel.innerText = `Kirim Pengajuan ke Admin K3L`;
            }
        }
    }
    window.updateCartSummary = updateCartSummary;
</script>
<?= $this->endSection() ?>
