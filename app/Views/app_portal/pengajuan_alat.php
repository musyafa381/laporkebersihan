<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header (Struktur/LPJ Style) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-box-open text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-box-open"></i> Modul Pengajuan Alat Kebersihan Unit
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Permohonan Peralatan Baru Gudang K3L
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Pengurus dan Kader dapat mengusulkan alokasi sapu, kain pel, cairan pembersih, atau mesin baru ke Gudang K3L.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Pengajuan Alat -->
        <div class="lg:col-span-1 glass-card rounded-3xl p-6 shadow-xl border border-slate-200/80 bg-white space-y-4">
            <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-plus-circle text-emerald-600"></i> Form Permohonan Alat
            </h3>

            <form action="<?= base_url('app/pengajuan-alat/store') ?>" method="POST" class="space-y-4">
                <!-- Searchable Alat Picker -->
                <div class="relative">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Pilih Peralatan Yang Dibutuhkan <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                            <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                        </span>
                    </label>
                    <input type="hidden" id="pengajuan_alat_id" name="alat_id" required value="">
                    <div class="relative">
                        <i class="fa-solid fa-broom-ball absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                        <input type="text" id="pengajuan_alat_search" placeholder="Cari nama alat kebersihan..." autocomplete="off" onfocus="openAlatPickerDropdown()" oninput="filterAlatPickerOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400" required>
                        <button type="button" onclick="toggleAlatPickerDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                            <i id="alatPickerIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                        </button>
                    </div>
                    <!-- Dropdown List -->
                    <div id="alatPickerDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                        <?php foreach ($alatList as $a): ?>
                            <div class="alat-picker-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $a['id'] ?>" data-name="<?= esc($a['nama_alat']) ?> (Stok: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>)" onclick="selectAlatPicker(this)">
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
                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold <?= $a['stok_sisa'] > 3 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' ?>">
                                        Stok: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div id="noAlatPickerFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                            Tidak ditemukan alat kebersihan yang sesuai.
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah Unit Permohonan</label>
                    <input type="number" name="jumlah" value="1" min="1" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Alasan Keperluan Pengajuan</label>
                    <textarea name="alasan_keperluan" rows="4" placeholder="Misal: Sapu ijuk di Asrama B rusak berat dan butuh penggantian segera..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pengajuan ke Admin</span>
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Pengajuan Alat -->
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
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
                            <th width="18%" class="py-3.5 px-4">TANGGAL</th>
                            <th width="27%" class="py-3.5 px-4">PERALATAN PERMOHONAN</th>
                            <th width="35%" class="py-3.5 px-4">ALASAN KEPERLUAN</th>
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

    document.addEventListener('DOMContentLoaded', initPengajuanPagePaginator);
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

    // Searchable Alat Picker Logic
    function openAlatPickerDropdown() {
        const dd = document.getElementById('alatPickerDropdownList');
        const icon = document.getElementById('alatPickerIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openAlatPickerDropdown = openAlatPickerDropdown;

    function toggleAlatPickerDropdown() {
        const dd = document.getElementById('alatPickerDropdownList');
        const icon = document.getElementById('alatPickerIcon');
        if (dd) {
            dd.classList.toggle('hidden');
            if (icon) icon.classList.toggle('rotate-180', !dd.classList.contains('hidden'));
        }
    }
    window.toggleAlatPickerDropdown = toggleAlatPickerDropdown;

    function filterAlatPickerOptions(query) {
        openAlatPickerDropdown();
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.alat-picker-item');
        let found = 0;
        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
                found++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noAlatPickerFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterAlatPickerOptions = filterAlatPickerOptions;

    function selectAlatPicker(el) {
        const id = el.dataset.id || '';
        const name = el.dataset.name || '';
        document.getElementById('pengajuan_alat_id').value = id;
        document.getElementById('pengajuan_alat_search').value = name;
        const dd = document.getElementById('alatPickerDropdownList');
        const icon = document.getElementById('alatPickerIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.selectAlatPicker = selectAlatPicker;

    document.addEventListener('click', function(e) {
        const searchInput = document.getElementById('pengajuan_alat_search');
        const dd = document.getElementById('alatPickerDropdownList');
        if (dd && searchInput && !searchInput.contains(e.target) && !dd.contains(e.target)) {
            dd.classList.add('hidden');
            const icon = document.getElementById('alatPickerIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    });
</script>
<?= $this->endSection() ?>
