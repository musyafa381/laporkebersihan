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
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Peralatan Yang Dibutuhkan</label>
                    <select name="alat_id" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="">-- Pilih Alat --</option>
                        <?php foreach ($alatList as $a): ?>
                            <option value="<?= $a['id'] ?>">
                                <?= esc($a['nama_alat']) ?> (Stok Gudang: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
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
</script>
<?= $this->endSection() ?>
