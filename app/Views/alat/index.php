<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header & Metric Cards Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white/90 backdrop-blur-xl space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-slate-100">
            <!-- Left Title -->
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200/80 shadow-2xs">
                    <i class="fa-solid fa-boxes-stacked text-emerald-600"></i>
                    <span>Modul Inventaris & Gudang K3L</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight leading-snug">
                    Inventaris & Peralatan Kebersihan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-semibold">
                    Pencatatan real-time persediaan gudang, arus barang masuk/keluar, dan penyerahan ke unit-unit pesantren.
                </p>
            </div>

            <?php if (session()->get('role') === 'Admin'): ?>
            <!-- Right Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-center flex-shrink-0">
                <button type="button" onclick="openModalTambahAlat()" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Tambah Alat Baru</span>
                </button>

                <button type="button" onclick="openModalKelolaKategori()" class="px-4 py-2.5 rounded-2xl bg-teal-50 text-teal-800 hover:bg-teal-100 border border-teal-200/80 font-heading font-extrabold text-xs transition shadow-2xs hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-tags text-teal-600"></i>
                    <span>Kelola Kategori</span>
                </button>

                <button type="button" onclick="openModalCatatKeluar()" class="px-4 py-2.5 rounded-2xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 font-heading font-extrabold text-xs transition shadow-2xs hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-circle-up"></i>
                    <span>Catat Barang Keluar</span>
                </button>

                <button type="button" onclick="openModalCatatMasuk()" class="px-4 py-2.5 rounded-2xl bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200/80 font-heading font-extrabold text-xs transition shadow-2xs hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-circle-down"></i>
                    <span>Catat Barang Masuk</span>
                </button>
            </div>
            <?php endif; ?>
        </div>

        <!-- 4 Metric Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-1.5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block">Total Jenis Alat</span>
                    <div class="w-9 h-9 rounded-xl bg-slate-200/70 text-slate-700 flex items-center justify-center text-base shadow-2xs">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
                <p class="font-heading font-extrabold text-2xl text-slate-900"><?= $totalJenis ?> <span class="text-xs text-slate-400 font-bold">Ragam</span></p>
            </div>

            <div class="p-5 rounded-2xl bg-blue-50/80 border border-blue-200/80 space-y-1.5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold text-blue-800 uppercase tracking-wider block">Total Barang Masuk</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-200/80 text-blue-800 flex items-center justify-center text-base shadow-2xs">
                        <i class="fa-solid fa-circle-down"></i>
                    </div>
                </div>
                <p class="font-heading font-extrabold text-2xl text-blue-900"><?= $totalMasuk ?> <span class="text-xs text-blue-700 font-bold">Item</span></p>
            </div>

            <div class="p-5 rounded-2xl bg-rose-50/80 border border-rose-200/80 space-y-1.5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold text-rose-800 uppercase tracking-wider block">Total Barang Keluar</span>
                    <div class="w-9 h-9 rounded-xl bg-rose-200/80 text-rose-800 flex items-center justify-center text-base shadow-2xs">
                        <i class="fa-solid fa-circle-up"></i>
                    </div>
                </div>
                <p class="font-heading font-extrabold text-2xl text-rose-900"><?= $totalKeluar ?> <span class="text-xs text-rose-700 font-bold">Item</span></p>
            </div>

            <div class="p-5 rounded-2xl bg-amber-50/80 border border-amber-200/80 space-y-1.5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold text-amber-800 uppercase tracking-wider block">Stok Kritis / Perlu Perhatian</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-200/80 text-amber-800 flex items-center justify-center text-base shadow-2xs">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <p class="font-heading font-extrabold text-2xl text-amber-900"><?= $stokKritis ?> <span class="text-xs text-amber-700 font-bold">Item</span></p>
            </div>
        </div>

        <!-- Segmented Floating Navbar -->
        <div class="pt-2">
            <nav class="bg-white p-2 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center gap-1.5 overflow-x-auto">
                <button onclick="switchTabAlat('stok')" id="tab-stok" class="tab-btn flex-1 min-w-max py-2.5 px-4 rounded-xl text-xs font-heading font-extrabold transition-all duration-200 flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20 whitespace-nowrap">
                    <i class="fa-solid fa-warehouse text-sm"></i>
                    <span>1. Stok & Gudang Utama</span>
                    <span class="px-2 py-0.5 rounded-full bg-white/20 text-[10px] font-extrabold text-white flex-shrink-0"><?= count($alatList) ?> Alat</span>
                </button>

                <button onclick="switchTabAlat('keluar')" id="tab-keluar" class="tab-btn flex-1 min-w-max py-2.5 px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-truck-ramp-box text-sm"></i>
                    <span>2. Barang Keluar & Distribusi Unit</span>
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-[10px] font-extrabold text-slate-600 flex-shrink-0"><?= count($transaksiKeluar) ?> Mutasi</span>
                </button>

                <button onclick="switchTabAlat('masuk')" id="tab-masuk" class="tab-btn flex-1 min-w-max py-2.5 px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-boxes-packing text-sm"></i>
                    <span>3. Barang Masuk & Restok</span>
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-[10px] font-extrabold text-slate-600 flex-shrink-0"><?= count($transaksiMasuk) ?> Masuk</span>
                </button>
            </nav>
        </div>
    </div>

    <!-- TAB 1: STOK & GUDANG INVENTARIS UTAMA -->
    <div id="content-stok" class="tab-content space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-emerald-600"></i> Master Daftar Peralatan Kebersihan
                </h3>
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
                    <!-- Filter Kategori Dropdown -->
                    <div class="relative w-full sm:w-48">
                        <select id="filterKategoriAlat" onchange="filterAlatTable()" class="w-full px-3.5 py-2 rounded-2xl border border-slate-200 text-xs font-bold text-slate-700 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="">Semua Kategori (<?= count($alatList) ?>)</option>
                            <?php foreach ($kategoriList as $k): ?>
                                <option value="<?= esc($k['nama_kategori']) ?>"><?= esc($k['nama_kategori']) ?> (<?= $categoryCounts[$k['nama_kategori']] ?? 0 ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="relative w-full sm:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input type="text" id="searchAlatInput" onkeyup="filterAlatTable()" placeholder="Cari nama alat / kode / lokasi..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table id="tableAlatMaster" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3.5 px-3 text-center">NO</th>
                            <th width="11%" class="py-3.5 px-4">KODE ALAT</th>
                            <th width="24%" class="py-3.5 px-4">NAMA PERALATAN & LOKASI</th>
                            <th width="15%" class="py-3.5 px-4">KATEGORI</th>
                            <th width="7%" class="py-3.5 px-3 text-center">AWAL</th>
                            <th width="7%" class="py-3.5 px-3 text-center">MASUK</th>
                            <th width="7%" class="py-3.5 px-3 text-center">KELUAR</th>
                            <th width="11%" class="py-3.5 px-4 text-center">SISA GUDANG</th>
                            <th width="14%" class="py-3.5 px-4 text-center">KONDISI</th>
                            <?php if (session()->get('role') === 'Admin'): ?>
                                <th width="8%" class="py-3.5 px-3 text-center">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($alatList)): ?>
                            <?php foreach ($alatList as $idx => $a): ?>
                                <tr class="alat-row hover:bg-slate-50/90 transition-all">
                                    <td class="py-3.5 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 font-mono font-extrabold border border-emerald-200/90 text-[11px] shadow-2xs">
                                            <i class="fa-solid fa-barcode text-[10px] text-emerald-600"></i>
                                            <?= esc($a['kode_alat']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-extrabold text-slate-900 text-xs tracking-tight"><?= esc($a['nama_alat']) ?></div>
                                        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-slate-100/90 text-slate-500 text-[10px] font-semibold mt-1">
                                            <i class="fa-solid fa-location-dot text-emerald-600 text-[9px]"></i>
                                            <span><?= esc($a['lokasi_gudang']) ?></span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200/70">
                                            <i class="fa-solid fa-layer-group text-slate-400 text-[10px]"></i>
                                            <?= esc($a['kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-3 text-center font-bold text-slate-500">
                                        <?= $a['stok_awal'] ?> <span class="text-[10px] text-slate-400 font-semibold"><?= esc($a['satuan']) ?></span>
                                    </td>
                                    <td class="py-3.5 px-3 text-center">
                                        <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-extrabold text-xs border border-blue-100">
                                            +<?= $a['stok_masuk'] ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-3 text-center">
                                        <span class="px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 font-extrabold text-xs border border-rose-100">
                                            -<?= $a['stok_keluar'] ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <?php if ($a['stok_sisa'] <= 3): ?>
                                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-900 text-xs font-extrabold border border-rose-200 inline-flex items-center gap-1 shadow-2xs animate-pulse whitespace-nowrap">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                                <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 text-xs font-extrabold border border-emerald-200 inline-flex items-center gap-1 shadow-2xs whitespace-nowrap">
                                                <i class="fa-solid fa-box-archive text-[10px] text-emerald-700"></i>
                                                <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <?php if ($a['kondisi'] === 'Baik'): ?>
                                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Baik
                                            </span>
                                        <?php elseif ($a['kondisi'] === 'Rusak Ringan'): ?>
                                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                Rusak Ringan
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-800 text-xs font-extrabold border border-rose-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                                Perlu Diganti
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if (session()->get('role') === 'Admin'): ?>
                                    <td class="py-3.5 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" onclick="openModalEditAlat(<?= htmlspecialchars(json_encode($a)) ?>)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 flex items-center justify-center transition shadow-2xs" title="Edit Alat">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>
                                            <a href="<?= base_url('alat/delete/' . $a['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus data alat ini?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition shadow-2xs" title="Hapus Alat">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="py-10 text-center text-slate-400 font-medium italic">Belum ada data peralatan kebersihan. Silakan klik + Tambah Alat Baru.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer Tab 1 -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-stok">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-stok">Menampilkan 0 data</span>
                    <select id="pageSize-stok" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5">5 / hal</option>
                        <option value="10" selected>10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-stok"></div>
            </div>
        </div>
    </div>

    <!-- TAB 2: BARANG KELUAR & DISTRIBUSI UNIT -->
    <div id="content-keluar" class="tab-content hidden space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-hand-holding-box text-rose-600"></i> Riwayat Barang Keluar & Penyerahan Ke Unit
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Pencatatan alat kebersihan yang didistribusikan kepada kader / pengurus unit.</p>
                </div>
                <?php if (session()->get('role') === 'Admin'): ?>
                <button type="button" onclick="openModalCatatKeluar()" class="px-4 py-2 rounded-2xl bg-rose-600 text-white font-extrabold text-xs hover:bg-rose-700 transition shadow-md shadow-rose-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Catat Barang Keluar</span>
                </button>
                <?php endif; ?>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table id="tableBarangKeluar" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="12%" class="py-3 px-4">TANGGAL</th>
                            <th width="24%" class="py-3 px-4">NAMA PERALATAN</th>
                            <th width="10%" class="py-3 px-3 text-center">JUMLAH KELUAR</th>
                            <th width="20%" class="py-3 px-4">DIBERIKAN KEPADA (PENERIMA)</th>
                            <th width="20%" class="py-3 px-4">UNIT / PERUNTUKAN</th>
                            <?php if (session()->get('role') === 'Admin'): ?>
                                <th width="10%" class="py-3 px-3 text-center">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($transaksiKeluar)): ?>
                            <?php foreach ($transaksiKeluar as $idx => $tk): ?>
                                <tr class="hover:bg-slate-50/80 transition-all">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3 px-4 font-bold text-slate-600"><?= date('d M Y', strtotime($tk['tanggal'])) ?></td>
                                    <td class="py-3 px-4 font-extrabold text-slate-900">
                                        <?= esc($tk['nama_alat']) ?>
                                        <span class="text-[10px] font-mono text-slate-400 block font-normal"><?= esc($tk['kode_alat']) ?></span>
                                    </td>
                                    <td class="py-3 px-3 text-center font-extrabold text-rose-600">
                                        <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-800 border border-rose-200">
                                            -<?= $tk['jumlah'] ?> <?= esc($tk['satuan']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-extrabold text-slate-800">
                                        <i class="fa-solid fa-user-tag text-slate-400 mr-1.5"></i><?= esc($tk['penerima_penyerah']) ?>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-emerald-800">
                                        <i class="fa-solid fa-building-user text-emerald-600 mr-1.5"></i><?= esc($tk['unit_tujuan']) ?>
                                    </td>
                                    <?php if (session()->get('role') === 'Admin'): ?>
                                    <td class="py-3 px-3 text-center">
                                        <a href="<?= base_url('alat/transaksi/delete/' . $tk['id']) ?>" data-confirm-msg="Hapus riwayat barang keluar ini dan kembalikan stok?" class="w-7 h-7 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition mx-auto" title="Hapus Riwayat">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-400 font-medium italic">Belum ada catatan barang keluar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer Tab 2 -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-keluar">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-keluar">Menampilkan 0 data</span>
                    <select id="pageSize-keluar" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5">5 / hal</option>
                        <option value="10" selected>10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-keluar"></div>
            </div>
        </div>
    </div>

    <!-- TAB 3: BARANG MASUK & RESTOK -->
    <div id="content-masuk" class="tab-content hidden space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-cart-flatbed text-blue-600"></i> Riwayat Barang Masuk & Penambahan Stok
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Pencatatan pembelian baru, pasokan, atau hibah alat ke gudang K3L.</p>
                </div>
                <?php if (session()->get('role') === 'Admin'): ?>
                <button type="button" onclick="openModalCatatMasuk()" class="px-4 py-2 rounded-2xl bg-blue-600 text-white font-extrabold text-xs hover:bg-blue-700 transition shadow-md shadow-blue-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Catat Barang Masuk</span>
                </button>
                <?php endif; ?>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table id="tableBarangMasuk" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="12%" class="py-3 px-4">TANGGAL</th>
                            <th width="26%" class="py-3 px-4">NAMA PERALATAN</th>
                            <th width="12%" class="py-3 px-3 text-center">JUMLAH MASUK</th>
                            <th width="20%" class="py-3 px-4">SUMBER / SUPPLIER</th>
                            <th width="18%" class="py-3 px-4">KETERANGAN</th>
                            <?php if (session()->get('role') === 'Admin'): ?>
                                <th width="8%" class="py-3 px-3 text-center">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($transaksiMasuk)): ?>
                            <?php foreach ($transaksiMasuk as $idx => $tm): ?>
                                <tr class="hover:bg-slate-50/80 transition-all">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3 px-4 font-bold text-slate-600"><?= date('d M Y', strtotime($tm['tanggal'])) ?></td>
                                    <td class="py-3 px-4 font-extrabold text-slate-900">
                                        <?= esc($tm['nama_alat']) ?>
                                        <span class="text-[10px] font-mono text-slate-400 block font-normal"><?= esc($tm['kode_alat']) ?></span>
                                    </td>
                                    <td class="py-3 px-3 text-center font-extrabold text-blue-600">
                                        <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-800 border border-blue-200">
                                            +<?= $tm['jumlah'] ?> <?= esc($tm['satuan']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-800">
                                        <i class="fa-solid fa-store text-slate-400 mr-1.5"></i><?= esc($tm['penerima_penyerah'] ?: '-') ?>
                                    </td>
                                    <td class="py-3 px-4 text-slate-600"><?= esc($tm['keterangan'] ?: '-') ?></td>
                                    <?php if (session()->get('role') === 'Admin'): ?>
                                    <td class="py-3 px-3 text-center">
                                        <a href="<?= base_url('alat/transaksi/delete/' . $tm['id']) ?>" data-confirm-msg="Hapus riwayat barang masuk ini?" class="w-7 h-7 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition mx-auto" title="Hapus Riwayat">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-400 font-medium italic">Belum ada catatan barang masuk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer Tab 3 -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-masuk">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-masuk">Menampilkan 0 data</span>
                    <select id="pageSize-masuk" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5">5 / hal</option>
                        <option value="10" selected>10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-masuk"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Alat Baru -->
<div id="modalTambahAlat" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-emerald-600"></i> Tambah Peralatan Kebersihan Baru
            </h3>
            <button onclick="closeModalTambahAlat()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('alat/store') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Alat</label>
                    <input type="text" name="kode_alat" placeholder="ALT-007" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">Kategori</label>
                        <button type="button" onclick="openModalKelolaKategori()" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-800 hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-gear text-[10px]"></i> Atur Kategori
                        </button>
                    </div>
                    <select name="kategori" id="add_kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php if (!empty($kategoriList)): ?>
                            <?php foreach ($kategoriList as $k): ?>
                                <option value="<?= esc($k['nama_kategori']) ?>"><?= esc($k['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="Sapu & Pel">Sapu & Pel</option>
                            <option value="Wadah Sampah">Wadah Sampah</option>
                            <option value="Cairan & Bahan Kimia">Cairan & Bahan Kimia</option>
                            <option value="Mesin & Alat Berat">Mesin & Alat Berat</option>
                            <option value="Lainnya">Lainnya</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Peralatan</label>
                <input type="text" name="nama_alat" placeholder="Misal: Sapu Ijuk Super Gagang Aluminium" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Stok Awal</label>
                    <input type="number" name="stok_awal" value="10" min="0" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Satuan</label>
                    <input type="text" name="satuan" value="Pcs" placeholder="Pcs/Unit/Set" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kondisi</label>
                    <select name="kondisi" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Baik">🟢 Baik</option>
                        <option value="Rusak Ringan">🟡 Rusak Ringan</option>
                        <option value="Perlu Diganti">🔴 Perlu Diganti</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi Penyimpanan Gudang</label>
                <input type="text" name="lokasi_gudang" placeholder="Misal: Gudang K3L Rak A1" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahAlat()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Alat Baru</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Alat -->
<div id="modalEditAlat" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Edit Data Peralatan
            </h3>
            <button onclick="closeModalEditAlat()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formEditAlat" action="" method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Alat</label>
                    <input type="text" id="edit_kode_alat" name="kode_alat" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">Kategori</label>
                        <button type="button" onclick="openModalKelolaKategori()" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-800 hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-gear text-[10px]"></i> Atur Kategori
                        </button>
                    </div>
                    <select id="edit_kategori" name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php if (!empty($kategoriList)): ?>
                            <?php foreach ($kategoriList as $k): ?>
                                <option value="<?= esc($k['nama_kategori']) ?>"><?= esc($k['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="Sapu & Pel">Sapu & Pel</option>
                            <option value="Wadah Sampah">Wadah Sampah</option>
                            <option value="Cairan & Bahan Kimia">Cairan & Bahan Kimia</option>
                            <option value="Mesin & Alat Berat">Mesin & Alat Berat</option>
                            <option value="Lainnya">Lainnya</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Peralatan</label>
                <input type="text" id="edit_nama_alat" name="nama_alat" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Stok Awal</label>
                    <input type="number" id="edit_stok_awal" name="stok_awal" min="0" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Satuan</label>
                    <input type="text" id="edit_satuan" name="satuan" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kondisi</label>
                    <select id="edit_kondisi" name="kondisi" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Baik">🟢 Baik</option>
                        <option value="Rusak Ringan">🟡 Rusak Ringan</option>
                        <option value="Perlu Diganti">🔴 Perlu Diganti</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi Penyimpanan Gudang</label>
                <input type="text" id="edit_lokasi_gudang" name="lokasi_gudang" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEditAlat()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Update Alat</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Catat Barang Keluar -->
<div id="modalCatatKeluar" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-hand-holding-box text-rose-600"></i> Catat Barang Keluar & Distribusi
            </h3>
            <button onclick="closeModalCatatKeluar()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('alat/transaksi/store') ?>" method="POST" class="space-y-4">
            <input type="hidden" name="jenis_transaksi" value="Keluar">

            <!-- Searchable Alat Picker for Catat Keluar -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Pilih Peralatan (Dari Gudang) <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="keluar_alat_id" name="alat_id" required value="">
                <div class="relative">
                    <i class="fa-solid fa-barcode absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-600 text-xs pointer-events-none"></i>
                    <input type="text" id="keluar_alat_search" placeholder="Cari nama atau kode alat..." autocomplete="off" onfocus="openKeluarAlatDropdown()" oninput="filterKeluarAlatOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 transition shadow-2xs cursor-pointer placeholder-slate-400" required>
                    <button type="button" onclick="toggleKeluarAlatDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="keluarAlatIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="keluarAlatDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <?php foreach ($alatList as $a): ?>
                        <div class="keluar-alat-item px-4 py-2.5 hover:bg-rose-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $a['id'] ?>" data-name="<?= esc($a['kode_alat']) ?> • <?= esc($a['nama_alat']) ?> (Sisa: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>)" onclick="selectKeluarAlat(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-900"><?= esc($a['nama_alat']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 font-mono font-bold border border-emerald-200/60"><?= esc($a['kode_alat']) ?></span>
                                    <span>&bull;</span>
                                    <span><?= esc($a['kategori']) ?></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold <?= $a['stok_sisa'] > 3 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' ?>">
                                    Sisa: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noKeluarAlatFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan peralatan yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Keluar</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah Keluar</label>
                    <input type="number" name="jumlah" value="1" min="1" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Diberikan Kepada (Penerima)</label>
                <input type="text" name="penerima_penyerah" placeholder="Misal: Kang Ahmad / Ibu Halimah" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Unit / Peruntukan</label>
                <input type="text" name="unit_tujuan" placeholder="Misal: GEMERLAP Asrama Komplek B / Satgas MA" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan (Opsional)</label>
                <input type="text" name="keterangan" placeholder="Keterangan tambahan keperluan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalCatatKeluar()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-rose-600 text-white text-xs font-extrabold hover:bg-rose-700 shadow-md shadow-rose-600/20 transition">Simpan Barang Keluar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Catat Barang Masuk -->
<div id="modalCatatMasuk" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-cart-flatbed text-blue-600"></i> Catat Barang Masuk & Penambahan Stok
            </h3>
            <button onclick="closeModalCatatMasuk()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('alat/transaksi/store') ?>" method="POST" class="space-y-4">
            <input type="hidden" name="jenis_transaksi" value="Masuk">

            <!-- Searchable Alat Picker for Catat Masuk -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Pilih Peralatan <span class="text-blue-500">*</span></span>
                    <span class="text-[10px] text-blue-600 font-bold lowercase bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200/60 flex items-center gap-1">
                        <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="masuk_alat_id" name="alat_id" required value="">
                <div class="relative">
                    <i class="fa-solid fa-barcode absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-600 text-xs pointer-events-none"></i>
                    <input type="text" id="masuk_alat_search" placeholder="Cari nama atau kode alat..." autocomplete="off" onfocus="openMasukAlatDropdown()" oninput="filterMasukAlatOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition shadow-2xs cursor-pointer placeholder-slate-400" required>
                    <button type="button" onclick="toggleMasukAlatDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="masukAlatIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="masukAlatDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <?php foreach ($alatList as $a): ?>
                        <div class="masuk-alat-item px-4 py-2.5 hover:bg-blue-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $a['id'] ?>" data-name="<?= esc($a['kode_alat']) ?> • <?= esc($a['nama_alat']) ?>" onclick="selectMasukAlat(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-900"><?= esc($a['nama_alat']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                    <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-800 font-mono font-bold border border-blue-200/60"><?= esc($a['kode_alat']) ?></span>
                                    <span>&bull;</span>
                                    <span><?= esc($a['kategori']) ?></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-700">
                                    Gudang: <?= $a['stok_sisa'] ?> <?= esc($a['satuan']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noMasukAlatFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan peralatan yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Masuk</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah Masuk</label>
                    <input type="number" name="jumlah" value="5" min="1" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Sumber / Supplier / Hibah</label>
                <input type="text" name="penerima_penyerah" placeholder="Misal: Pembelian Toko Kebersihan Maju / Bantuan Yayasan" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan (Opsional)</label>
                <input type="text" name="keterangan" placeholder="Keterangan nota / pengadaan LPJ..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalCatatMasuk()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-blue-600 text-white text-xs font-extrabold hover:bg-blue-700 shadow-md shadow-blue-600/20 transition">Simpan Barang Masuk</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Kelola Kategori Alat Kebersihan (CRUD Master Kategori) -->
<div id="modalKelolaKategori" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-teal-100/80 text-teal-700 flex items-center justify-center text-sm shadow-2xs">
                    <i class="fa-solid fa-tags"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Kelola Kategori Alat Kebersihan
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Tambah, ubah nama, atau hapus kategori kelompok inventaris alat.</p>
                </div>
            </div>
            <button onclick="closeModalKelolaKategori()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Tambah / Edit Kategori Alat -->
        <form id="formKategoriAlat" action="<?= base_url('alat/kategori/store') ?>" method="POST" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
            <div class="flex items-center justify-between">
                <span id="formKategoriTitle" class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-plus-circle text-teal-600"></i> Form Tambah Kategori Alat
                </span>
                <button type="button" id="btnCancelEditKategori" onclick="resetFormKategori()" class="hidden text-[11px] font-bold text-slate-500 hover:text-slate-800 underline">
                    Batal Edit
                </button>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" id="input_nama_kategori" name="nama_kategori" placeholder="Misal: Sapu & Pel / Wadah Sampah / Mesin" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Urutan</label>
                    <input type="number" id="input_urutan_kategori" name="urutan" value="0" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Keterangan Singkat (Opsional)</label>
                <input type="text" id="input_keterangan_kategori" name="keterangan" placeholder="Contoh: Alat kebersihan lantai, ember, pel..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" id="btnSubmitKategori" class="px-5 py-2 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-heading font-extrabold text-xs hover:from-teal-700 hover:to-emerald-700 transition shadow-md shadow-teal-600/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>

        <!-- Tabel Daftar Kategori Alat -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Daftar Kategori Tersedia</span>
                <span class="text-[11px] font-extrabold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-full border border-teal-200/80">
                    <?= count($kategoriList ?? []) ?> Kategori
                </span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs max-h-60 overflow-y-auto">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200 sticky top-0 bg-white">
                        <tr>
                            <th width="8%" class="py-2.5 px-3 text-center">NO</th>
                            <th width="35%" class="py-2.5 px-4">NAMA KATEGORI</th>
                            <th width="32%" class="py-2.5 px-4">KETERANGAN</th>
                            <th width="12%" class="py-2.5 px-2 text-center">ALAT</th>
                            <th width="13%" class="py-2.5 px-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($kategoriList)): ?>
                            <?php foreach ($kategoriList as $idx => $kat): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3 px-4 font-extrabold text-slate-900">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-teal-50 text-teal-800 border border-teal-200/80 text-xs shadow-2xs">
                                            <i class="fa-solid fa-layer-group text-[10px] text-teal-600"></i>
                                            <?= esc($kat['nama_kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-500 text-xs font-medium">
                                        <?= esc($kat['keterangan'] ?: '-') ?>
                                    </td>
                                    <td class="py-3 px-2 text-center font-bold text-slate-600">
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-[11px] font-extrabold text-slate-700 border border-slate-200">
                                            <?= $categoryCounts[$kat['nama_kategori']] ?? 0 ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" onclick="editKategoriRow(<?= htmlspecialchars(json_encode($kat)) ?>)" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:text-teal-700 hover:bg-teal-50 border border-slate-200/80 flex items-center justify-center transition" title="Edit Kategori">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </button>
                                            <a href="<?= base_url('alat/kategori/delete/' . $kat['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus kategori '<?= esc($kat['nama_kategori']) ?>'?" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/80 flex items-center justify-center transition" title="Hapus Kategori">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 font-bold text-xs">Belum ada kategori alat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-2 flex justify-end border-t border-slate-100">
            <button type="button" onclick="closeModalKelolaKategori()" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    var paginatorStok, paginatorKeluar, paginatorMasuk;

    function initAlatPaginator() {
        if (typeof TablePaginator !== 'undefined') {
            if (document.getElementById('tableAlatMaster')) {
                paginatorStok = new TablePaginator('tableAlatMaster', 'page-info-stok', 'page-buttons-stok', 'pageSize-stok');
                paginatorStok.render();
            }
            if (document.getElementById('tableBarangKeluar')) {
                paginatorKeluar = new TablePaginator('tableBarangKeluar', 'page-info-keluar', 'page-buttons-keluar', 'pageSize-keluar');
                paginatorKeluar.render();
            }
            if (document.getElementById('tableBarangMasuk')) {
                paginatorMasuk = new TablePaginator('tableBarangMasuk', 'page-info-masuk', 'page-buttons-masuk', 'pageSize-masuk');
                paginatorMasuk.render();
            }
        }
    }
    window.initAlatPaginator = initAlatPaginator;
    window.rebindPageEvents = initAlatPaginator;

    document.addEventListener('DOMContentLoaded', initAlatPaginator);
    initAlatPaginator();

    function switchTabAlat(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = "tab-btn flex-1 min-w-max py-2.5 px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap";
        });

        const activeContent = document.getElementById('content-' + tab);
        const activeBtn = document.getElementById('tab-' + tab);

        if (activeContent) activeContent.classList.remove('hidden');
        if (activeBtn) {
            activeBtn.className = "tab-btn flex-1 min-w-max py-2.5 px-4 rounded-xl text-xs font-heading font-extrabold transition-all duration-200 flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20 whitespace-nowrap";
        }

        if (tab === 'stok' && paginatorStok) paginatorStok.render();
        if (tab === 'keluar' && paginatorKeluar) paginatorKeluar.render();
        if (tab === 'masuk' && paginatorMasuk) paginatorMasuk.render();
    }
    window.switchTabAlat = switchTabAlat;

    function filterAlatTable() {
        const input = document.getElementById('searchAlatInput');
        const filterKat = (document.getElementById('filterKategoriAlat')?.value || '').toLowerCase();
        const filter = input ? input.value.toLowerCase() : '';
        const rows = document.querySelectorAll('#tableAlatMaster tbody tr.alat-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const matchesText = !filter || text.includes(filter);
            const matchesCategory = !filterKat || text.includes(filterKat);
            row.dataset.searchFiltered = (matchesText && matchesCategory) ? 'true' : 'false';
        });

        if (paginatorStok) {
            paginatorStok.currentPage = 1;
            paginatorStok.render();
        }
    }
    window.filterAlatTable = filterAlatTable;

    function openModalTambahAlat() {
        const modal = document.getElementById('modalTambahAlat');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalTambahAlat = openModalTambahAlat;

    function closeModalTambahAlat() {
        const modal = document.getElementById('modalTambahAlat');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalTambahAlat = closeModalTambahAlat;

    function openModalKelolaKategori() {
        const modal = document.getElementById('modalKelolaKategori');
        if (modal) modal.classList.remove('hidden');
        resetFormKategori();
    }
    window.openModalKelolaKategori = openModalKelolaKategori;

    function closeModalKelolaKategori() {
        const modal = document.getElementById('modalKelolaKategori');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalKelolaKategori = closeModalKelolaKategori;

    function editKategoriRow(kat) {
        const form = document.getElementById('formKategoriAlat');
        if (form) form.action = "<?= base_url('alat/kategori/update/') ?>" + kat.id;
        
        document.getElementById('formKategoriTitle').innerHTML = '<i class="fa-solid fa-pen text-amber-500"></i> Edit Kategori: ' + kat.nama_kategori;
        document.getElementById('input_nama_kategori').value = kat.nama_kategori || '';
        document.getElementById('input_urutan_kategori').value = kat.urutan || 0;
        document.getElementById('input_keterangan_kategori').value = kat.keterangan || '';
        document.getElementById('btnSubmitKategori').innerHTML = '<i class="fa-solid fa-check"></i><span>Update Kategori</span>';
        document.getElementById('btnCancelEditKategori').classList.remove('hidden');
    }
    window.editKategoriRow = editKategoriRow;

    function resetFormKategori() {
        const form = document.getElementById('formKategoriAlat');
        if (form) form.action = "<?= base_url('alat/kategori/store') ?>";
        
        document.getElementById('formKategoriTitle').innerHTML = '<i class="fa-solid fa-plus-circle text-teal-600"></i> Form Tambah Kategori Alat';
        document.getElementById('input_nama_kategori').value = '';
        document.getElementById('input_urutan_kategori').value = 0;
        document.getElementById('input_keterangan_kategori').value = '';
        document.getElementById('btnSubmitKategori').innerHTML = '<i class="fa-solid fa-save"></i><span>Simpan Kategori</span>';
        document.getElementById('btnCancelEditKategori').classList.add('hidden');
    }
    window.resetFormKategori = resetFormKategori;

    function openModalCatatKeluar() {
        const modal = document.getElementById('modalCatatKeluar');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalCatatKeluar = openModalCatatKeluar;

    function closeModalCatatKeluar() {
        const modal = document.getElementById('modalCatatKeluar');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalCatatKeluar = closeModalCatatKeluar;

    function openModalCatatMasuk() {
        const modal = document.getElementById('modalCatatMasuk');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalCatatMasuk = openModalCatatMasuk;

    function closeModalCatatMasuk() {
        const modal = document.getElementById('modalCatatMasuk');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalCatatMasuk = closeModalCatatMasuk;

    function openModalEditAlat(alat) {
        const form = document.getElementById('formEditAlat');
        if (form) form.action = "<?= base_url('alat/update/') ?>" + alat.id;
        const kodeEl = document.getElementById('edit_kode_alat');
        if (kodeEl) kodeEl.value = alat.kode_alat || '';
        const namaEl = document.getElementById('edit_nama_alat');
        if (namaEl) namaEl.value = alat.nama_alat || '';
        const katEl = document.getElementById('edit_kategori');
        if (katEl) katEl.value = alat.kategori || (katEl.options[0]?.value || '');
        const stokEl = document.getElementById('edit_stok_awal');
        if (stokEl) stokEl.value = alat.stok_awal || 0;
        const satEl = document.getElementById('edit_satuan');
        if (satEl) satEl.value = alat.satuan || 'Pcs';
        const konEl = document.getElementById('edit_kondisi');
        if (konEl) konEl.value = alat.kondisi || 'Baik';
        const gudEl = document.getElementById('edit_lokasi_gudang');
        if (gudEl) gudEl.value = alat.lokasi_gudang || '';

        const modal = document.getElementById('modalEditAlat');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalEditAlat = openModalEditAlat;

    function closeModalEditAlat() {
        const modal = document.getElementById('modalEditAlat');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalEditAlat = closeModalEditAlat;

    // Searchable Alat Picker Logic for Catat Keluar
    function openKeluarAlatDropdown() {
        const dd = document.getElementById('keluarAlatDropdownList');
        const icon = document.getElementById('keluarAlatIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openKeluarAlatDropdown = openKeluarAlatDropdown;

    function toggleKeluarAlatDropdown() {
        const dd = document.getElementById('keluarAlatDropdownList');
        const icon = document.getElementById('keluarAlatIcon');
        if (dd) {
            dd.classList.toggle('hidden');
            if (icon) icon.classList.toggle('rotate-180', !dd.classList.contains('hidden'));
        }
    }
    window.toggleKeluarAlatDropdown = toggleKeluarAlatDropdown;

    function filterKeluarAlatOptions(query) {
        openKeluarAlatDropdown();
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.keluar-alat-item');
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
        const noFound = document.getElementById('noKeluarAlatFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterKeluarAlatOptions = filterKeluarAlatOptions;

    function selectKeluarAlat(el) {
        const id = el.dataset.id || '';
        const name = el.dataset.name || '';
        document.getElementById('keluar_alat_id').value = id;
        document.getElementById('keluar_alat_search').value = name;
        const dd = document.getElementById('keluarAlatDropdownList');
        const icon = document.getElementById('keluarAlatIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.selectKeluarAlat = selectKeluarAlat;

    // Searchable Alat Picker Logic for Catat Masuk
    function openMasukAlatDropdown() {
        const dd = document.getElementById('masukAlatDropdownList');
        const icon = document.getElementById('masukAlatIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openMasukAlatDropdown = openMasukAlatDropdown;

    function toggleMasukAlatDropdown() {
        const dd = document.getElementById('masukAlatDropdownList');
        const icon = document.getElementById('masukAlatIcon');
        if (dd) {
            dd.classList.toggle('hidden');
            if (icon) icon.classList.toggle('rotate-180', !dd.classList.contains('hidden'));
        }
    }
    window.toggleMasukAlatDropdown = toggleMasukAlatDropdown;

    function filterMasukAlatOptions(query) {
        openMasukAlatDropdown();
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.masuk-alat-item');
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
        const noFound = document.getElementById('noMasukAlatFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterMasukAlatOptions = filterMasukAlatOptions;

    function selectMasukAlat(el) {
        const id = el.dataset.id || '';
        const name = el.dataset.name || '';
        document.getElementById('masuk_alat_id').value = id;
        document.getElementById('masuk_alat_search').value = name;
        const dd = document.getElementById('masukAlatDropdownList');
        const icon = document.getElementById('masukAlatIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.selectMasukAlat = selectMasukAlat;

    document.addEventListener('click', function(e) {
        // Dismiss Keluar Dropdown
        const keluarSearch = document.getElementById('keluar_alat_search');
        const keluarDd = document.getElementById('keluarAlatDropdownList');
        if (keluarDd && keluarSearch && !keluarSearch.contains(e.target) && !keluarDd.contains(e.target)) {
            keluarDd.classList.add('hidden');
            const icon = document.getElementById('keluarAlatIcon');
            if (icon) icon.classList.remove('rotate-180');
        }

        // Dismiss Masuk Dropdown
        const masukSearch = document.getElementById('masuk_alat_search');
        const masukDd = document.getElementById('masukAlatDropdownList');
        if (masukDd && masukSearch && !masukSearch.contains(e.target) && !masukDd.contains(e.target)) {
            masukDd.classList.add('hidden');
            const icon = document.getElementById('masukAlatIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    });
</script>
<?= $this->endSection() ?>
