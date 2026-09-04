<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Top Navigation & Flash Message -->
    <div class="flex items-center justify-between">
        <a href="<?= base_url('pengaturan?tab=units') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:text-emerald-700 hover:border-emerald-200 font-extrabold text-xs transition shadow-2xs">
            <i class="fa-solid fa-arrow-left text-emerald-600"></i>
            <span>Kembali ke Pengaturan Unit</span>
        </a>

        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="<?= base_url('/') ?>" class="hover:text-emerald-600">Beranda</a>
            <span>/</span>
            <a href="<?= base_url('pengaturan?tab=units') ?>" class="hover:text-emerald-600">Instansi</a>
            <span>/</span>
            <span class="text-slate-800 font-extrabold"><?= esc($unit['nama_unit']) ?></span>
        </div>
    </div>

    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span><?= session()->getFlashdata('msg_success') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg_error')): ?>
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                <span><?= session()->getFlashdata('msg_error') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <!-- Main Hero Banner Profil Instansi (Premium Emerald Theme) -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white relative overflow-hidden space-y-6">
        <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="space-y-3 max-w-2xl">
                <!-- Badges Row -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-extrabold bg-slate-900 text-emerald-300 shadow-2xs">
                        <?= esc($unit['kode_unit'] ?: 'UNIT-' . $unit['id']) ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <?= esc($unit['tipe']) ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold <?= ($unit['status'] ?? 'Aktif') === 'Aktif' ? 'bg-emerald-100/70 text-emerald-900 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' ?>">
                        <span class="w-1.5 h-1.5 rounded-full inline-block mr-1.5 <?= ($unit['status'] ?? 'Aktif') === 'Aktif' ? 'bg-emerald-600' : 'bg-rose-600' ?>"></span>
                        <?= esc($unit['status'] ?? 'Aktif') ?>
                    </span>
                    <?php if (($unit['ada_kader'] ?? 'Ya') === 'Tidak'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                            Tidak Ada Kader
                        </span>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-teal-50 text-teal-800 border border-teal-200">
                            <?= esc($unit['jenis_kader'] ?: 'Gemerlap') ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div>
                    <h1 class="font-heading font-black text-2xl sm:text-3xl text-slate-900 tracking-tight leading-tight">
                        <?= esc($unit['nama_unit']) ?>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-semibold mt-1 flex flex-wrap items-center gap-2">
                        <span class="text-emerald-700 font-bold">Instansi Kebersihan K3L Assalafiyyah</span>
                        <span class="text-slate-300">•</span>
                        <span>Terdaftar Sejak: <?= date('d M Y', strtotime($unit['created_at'] ?? 'now')) ?></span>
                    </p>
                </div>
            </div>

            <!-- Quick Action & Stats Pill -->
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-1 bg-slate-50/90 p-2 rounded-2xl border border-slate-200/90 shadow-2xs">
                    <div class="px-3.5 py-1.5 text-center border-r border-slate-200">
                        <div class="font-heading font-black text-base text-slate-900 leading-none"><?= count($pjs) ?></div>
                        <div class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider mt-1">PJ Unit</div>
                    </div>
                    <div class="px-3.5 py-1.5 text-center border-r border-slate-200">
                        <div class="font-heading font-black text-base text-emerald-700 leading-none"><?= count($kaderList) ?></div>
                        <div class="text-[9px] text-emerald-700 font-extrabold uppercase tracking-wider mt-1">Anggota</div>
                    </div>
                    <div class="px-3.5 py-1.5 text-center">
                        <div class="font-heading font-black text-base text-teal-700 leading-none"><?= count($allocatedTools) ?></div>
                        <div class="text-[9px] text-teal-700 font-extrabold uppercase tracking-wider mt-1">Jenis Alat</div>
                    </div>
                </div>

                <?php if (session()->get('role') === 'Admin'): ?>
                <button onclick="openModalAddPj()" class="px-5 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tambah PJ Unit</span>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Grid 2 Kolom: Penanggung Jawab (Multi-PJ) & Anggota Kader -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Kartu Daftar Multi-PJ -->
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                    <div>
                        <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-emerald-600"></i>
                            <span>Penanggung Jawab (Multi-PJ)</span>
                        </h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Daftar seluruh pengurus penanggung jawab unit ini.</p>
                    </div>
                    <?php if (session()->get('role') === 'Admin'): ?>
                    <button onclick="openModalAddPj()" class="px-3 py-1 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-extrabold border border-emerald-200 transition">
                        + Tambah PJ
                    </button>
                    <?php endif; ?>
                </div>

                <?php if (!empty($pjs)): ?>
                    <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                        <?php foreach ($pjs as $pj): ?>
                            <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-center justify-between gap-3 hover:bg-white hover:border-emerald-300 hover:shadow-sm transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-700 to-teal-600 text-white font-heading font-extrabold text-sm flex items-center justify-center shadow-xs flex-shrink-0">
                                        <?= strtoupper(substr($pj['nama_pj'], 0, 2)) ?>
                                    </div>
                                    <div>
                                        <div class="font-heading font-extrabold text-xs text-slate-900 flex items-center gap-1.5">
                                            <span><?= esc($pj['nama_pj']) ?></span>
                                            <?php if (!empty($pj['username'])): ?>
                                                <span class="text-[10px] text-slate-400 font-normal">(@<?= esc($pj['username']) ?>)</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-semibold flex items-center gap-2 mt-0.5">
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800">
                                                <?= esc($pj['peran'] ?: 'Penanggung Jawab') ?>
                                            </span>
                                            <?php if (!empty($pj['kontak_pj'])): ?>
                                                <span class="text-slate-400">• WA: <?= esc($pj['kontak_pj']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($pj['id'] > 0 && session()->get('role') === 'Admin'): ?>
                                    <a href="<?= base_url('unit/pj/delete/' . $pj['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus PJ ini dari unit?" class="w-7 h-7 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:bg-rose-50 hover:border-rose-200 flex items-center justify-center transition shadow-2xs" title="Hapus PJ">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-8 text-center bg-slate-50/60 rounded-2xl border border-dashed border-slate-200 text-slate-400 text-xs italic">
                        Belum ada Penanggung Jawab (PJ) yang ditautkan ke unit ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kartu Daftar Anggota Kader Terdaftar -->
        <?php 
            $isPoskoUnit = (stripos($unit['tipe'] ?? '', 'Posko') !== false || stripos($unit['nama_unit'], 'GEMERLAP') !== false || stripos($unit['nama_unit'], 'Satgas') !== false);
            $sectionTitle = 'Daftar Anggota Kader';
            if ($isPoskoUnit) {
                $teamSubtext = ($unit['ada_kader'] ?? 'Ya') === 'Tidak' ? 'Unit ini berstatus Tanpa Kader.' : 'Tim ' . esc($unit['jenis_kader'] ?: 'Gemerlap / Satgas') . ' yang bertugas.';
            } else {
                if (!empty($linkedUnitName)) {
                    $teamSubtext = 'Terintegrasi dari posko: <strong class="text-teal-700 font-bold">' . esc($linkedUnitName) . '</strong>';
                } else {
                    $teamSubtext = ($unit['ada_kader'] ?? 'Ya') === 'Tidak' ? 'Unit ini berstatus Tanpa Kader.' : 'Tim ' . esc($unit['jenis_kader'] ?: 'Gemerlap / Satgas') . ' yang bertugas.';
                }
            }
        ?>
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                    <div>
                        <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-users text-teal-600"></i>
                            <span><?= $sectionTitle ?></span>
                        </h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">
                            <?= $teamSubtext ?>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-teal-50 text-teal-800 border border-teal-200">
                            <?= count($kaderList) ?> Kader
                        </span>
                        <?php if (($unit['ada_kader'] ?? 'Ya') !== 'Tidak' && session()->get('role') === 'Admin'): ?>
                            <button onclick="openModalAddKader()" class="px-3 py-1 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-extrabold border border-teal-200 transition">
                                + Tambah Kader
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (($unit['ada_kader'] ?? 'Ya') === 'Tidak'): ?>
                    <div class="p-8 text-center bg-slate-50/60 rounded-2xl border border-dashed border-slate-200 text-slate-400 text-xs italic">
                        Unit / Instansi ini berstatus <strong>Tidak Ada Kader</strong>.
                    </div>
                <?php elseif (!empty($kaderList)): ?>
                    <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                        <?php foreach ($kaderList as $k): ?>
                            <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-center justify-between gap-3 hover:bg-white hover:border-teal-300 hover:shadow-sm transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-teal-700 to-emerald-600 text-white font-heading font-extrabold text-sm flex items-center justify-center shadow-xs flex-shrink-0">
                                        <?= strtoupper(substr($k['nama_kader'] ?? $k['nama_lengkap'] ?? 'KD', 0, 2)) ?>
                                    </div>
                                    <div>
                                        <div class="font-heading font-extrabold text-xs text-slate-900 flex items-center gap-1.5">
                                            <span><?= esc($k['nama_kader'] ?? $k['nama_lengkap']) ?></span>
                                            <?php if (!empty($k['kamar_kelas'])): ?>
                                                <span class="text-[10px] text-slate-400 font-normal">(<?= esc($k['kamar_kelas']) ?>)</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-semibold flex items-center gap-2 mt-0.5">
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-teal-100 text-teal-800">
                                                <?= esc($k['jabatan_kader'] ?? 'Anggota Kader') ?>
                                            </span>
                                            <?php if (!empty($k['kontak_kader'])): ?>
                                                <span class="text-slate-400">• WA: <?= esc($k['kontak_kader']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($k['id']) && session()->get('role') === 'Admin'): ?>
                                    <a href="<?= base_url('unit/kader/delete/' . $k['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus nama kader ini?" class="w-7 h-7 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:bg-rose-50 hover:border-rose-200 flex items-center justify-center transition shadow-2xs" title="Hapus Kader">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-8 text-center bg-slate-50/60 rounded-2xl border border-dashed border-slate-200 text-slate-400 text-xs italic space-y-2">
                        <div>Belum ada daftar nama anggota kader yang didaftarkan pada unit ini.</div>
                        <?php if (session()->get('role') === 'Admin'): ?>
                        <button onclick="openModalAddKader()" class="px-4 py-2 rounded-xl bg-teal-600 text-white font-extrabold text-xs hover:bg-teal-700 transition shadow-xs">
                            + Tambah Kader Pertama
                        </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- 4 Tab Riwayat Instansi (Inventaris Terlokasi, Distribusi Alat, Pengajuan Alat, Reports CS) -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">

        <!-- Tab Header Buttons -->
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
            <button id="tab-btn-allocated" onclick="switchDetailTab('allocated')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs bg-emerald-600 text-white shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Alat & Inventaris Terlokasi (<?= count($allocatedTools) ?>)</span>
            </button>
            <button id="tab-btn-history" onclick="switchDetailTab('history')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs text-slate-600 hover:bg-slate-100 transition flex items-center gap-2">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <span>Riwayat Distribusi Alat (<?= count($distribHistory) ?>)</span>
            </button>
            <button id="tab-btn-pengajuan" onclick="switchDetailTab('pengajuan')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs text-slate-600 hover:bg-slate-100 transition flex items-center gap-2">
                <i class="fa-solid fa-hand-holding-hand"></i>
                <span>Riwayat Pengajuan Alat (<?= count($pengajuanHistory) ?>)</span>
            </button>
            <button id="tab-btn-cs" onclick="switchDetailTab('cs')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs text-slate-600 hover:bg-slate-100 transition flex items-center gap-2">
                <i class="fa-solid fa-comments"></i>
                <span>Riwayat Pelaporan CS (<?= count($csHistory) ?>)</span>
            </button>
        </div>

        <!-- Tab Content 1: Alat Kebersihan Terlokasi -->
        <div id="tab-detail-allocated" class="tab-detail-panel space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-box text-emerald-600"></i> Alat Kebersihan Yang Diberikan / Aktif Terlokasi Di Unit
                    </h4>
                    <p class="text-xs text-slate-500 font-semibold">Daftar akumulasi peralatan kebersihan hasil distribusi dari Gudang Pusat K3L.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Kode</th>
                            <th class="py-3 px-4">Nama Peralatan</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4 text-center">Jumlah Alokasi</th>
                            <th class="py-3 px-4 text-right">Terakhir Didistribusikan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        <?php if (!empty($allocatedTools)): ?>
                            <?php foreach ($allocatedTools as $tool): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-mono font-bold text-slate-600">
                                        <?= esc($tool['kode_alat']) ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-heading font-extrabold text-slate-900">
                                        <?= esc($tool['nama_alat']) ?>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                            <?= esc($tool['kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-200">
                                            <?= number_format($tool['jumlah']) ?> <?= esc($tool['satuan']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-medium text-slate-500">
                                        <?= date('d M Y', strtotime($tool['terakhir'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs italic">
                                    Belum ada alokasi alat kebersihan yang tercatat didistribusikan ke unit ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content 2: Riwayat Distribusi & Pengeluaran Barang -->
        <div id="tab-detail-history" class="tab-detail-panel hidden space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Log Transaksi Distribusi & Penyerahan Barang
                    </h4>
                    <p class="text-xs text-slate-500 font-semibold">Riwayat penyerahan alat kebersihan dari Gudang K3L ke unit ini.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Alat Kebersihan</th>
                            <th class="py-3 px-4 text-center">Jenis Transaksi</th>
                            <th class="py-3 px-4 text-center">Jumlah</th>
                            <th class="py-3 px-4">Penerima / Penyerah</th>
                            <th class="py-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        <?php if (!empty($distribHistory)): ?>
                            <?php foreach ($distribHistory as $dh): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-mono text-slate-600 font-semibold">
                                        <?= date('d/m/Y', strtotime($dh['tanggal'])) ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-heading font-extrabold text-slate-900">
                                        <?= esc($dh['nama_alat'] ?: 'Peralatan Kebersihan') ?>
                                        <span class="block text-[10px] text-slate-400 font-mono"><?= esc($dh['kode_alat'] ?: '-') ?></span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-800 border border-blue-200">
                                            Penyerahan ke Unit
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-black text-slate-900">
                                        <?= number_format($dh['jumlah']) ?> <?= esc($dh['satuan'] ?: 'Pcs') ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700">
                                        <?= esc($dh['penerima_penyerah'] ?: '-') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500 font-medium max-w-xs truncate">
                                        <?= esc($dh['keterangan'] ?: '-') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs italic">
                                    Belum ada log transaksi distribusi barang untuk unit ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content 3: Riwayat Pengajuan Alat dari Unit -->
        <div id="tab-detail-pengajuan" class="tab-detail-panel hidden space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-hand-holding-hand text-emerald-600"></i> Riwayat Pengajuan Alat Kebersihan dari Unit
                    </h4>
                    <p class="text-xs text-slate-500 font-semibold">Pengajuan kebutuhan alat baru/tambahan yang diajukan oleh PJ atau Kader unit ini.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Alat Diajukan</th>
                            <th class="py-3 px-4 text-center">Jumlah</th>
                            <th class="py-3 px-4">Pemohon</th>
                            <th class="py-3 px-4">Alasan / Keperluan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        <?php if (!empty($pengajuanHistory)): ?>
                            <?php foreach ($pengajuanHistory as $p): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-mono text-slate-600 font-semibold">
                                        <?= date('d/m/Y', strtotime($p['created_at'])) ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-heading font-extrabold text-slate-900">
                                        <?= esc($p['nama_alat'] ?: 'Alat Kebersihan') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-black text-slate-900">
                                        <?= number_format($p['jumlah']) ?> <?= esc($p['satuan'] ?: 'Pcs') ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700">
                                        <?= esc($p['pemohon_nama'] ?: $p['pemohon_username'] ?: '-') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 font-medium max-w-xs truncate">
                                        <?= esc($p['alasan_keperluan'] ?: '-') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <?php
                                            $st = strtolower($p['status'] ?? 'pending');
                                            $badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                                            if ($st === 'disetujui' || $st === 'approved') $badgeClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                                            if ($st === 'ditolak' || $st === 'rejected') $badgeClass = 'bg-rose-50 text-rose-800 border-rose-200';
                                        ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border <?= $badgeClass ?>">
                                            <?= ucfirst(esc($p['status'] ?? 'Pending')) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs italic">
                                    Belum ada catatan pengajuan alat dari unit ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content 4: Riwayat Laporan Kebersihan CS -->
        <div id="tab-detail-cs" class="tab-detail-panel hidden space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-emerald-600"></i> Riwayat Pelaporan & Pengaduan CS Kebersihan
                    </h4>
                    <p class="text-xs text-slate-500 font-semibold">Aspirasi & laporan kebersihan di lokasi unit ini dari santri atau pengunjung.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Pelapor</th>
                            <th class="py-3 px-4">Kategori Laporan</th>
                            <th class="py-3 px-4">Isi Laporan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        <?php if (!empty($csHistory)): ?>
                            <?php foreach ($csHistory as $cs): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                        #<?= esc($cs['id']) ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-700">
                                        <?= esc($cs['nama_pengirim'] ?: 'Santri') ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-600">
                                        <?= esc($cs['kategori'] ?: 'Pengaduan Kebersihan') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 font-medium max-w-sm">
                                        <?= esc($cs['isi_laporan'] ?: '-') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <?php
                                            $st = strtolower($cs['status'] ?? 'pending');
                                            $badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                                            if ($st === 'selesai' || $st === 'resolved') $badgeClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                                            if ($st === 'proses' || $st === 'diproses') $badgeClass = 'bg-blue-50 text-blue-800 border-blue-200';
                                        ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border <?= $badgeClass ?>">
                                            <?= ucfirst(esc($cs['status'] ?? 'Pending')) ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-slate-500 font-medium">
                                        <?= date('d M Y, H:i', strtotime($cs['created_at'] ?? 'now')) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs italic">
                                    Belum ada riwayat pengaduan CS tercatat untuk lokasi unit ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Modal Tambah Penanggung Jawab (PJ) Baru -->
<div id="modalAddPj" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-emerald-600"></i> Tambah Penanggung Jawab (PJ)
            </h3>
            <button onclick="closeModalAddPj()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('unit/pj/add/' . $unit['id']) ?>" method="POST" class="space-y-4">
            <!-- Searchable User Picker for Add PJ -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Pilih Akun Terdaftar (Opsional)</span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="add_pj_user_id" name="user_id" value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="add_pj_user_search" placeholder="Cari nama akun, username, role..." autocomplete="off" onfocus="openAddPjDropdown()" oninput="filterAddPjOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                    <button type="button" onclick="toggleAddPjDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="addPjIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="addPjDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-48 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <div class="add-pj-item px-4 py-2 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer font-bold text-xs text-slate-500" data-id="" data-name="" data-nama="" data-hp="" onclick="selectAddPj(this)">
                        <span class="italic text-slate-400">-- Input Manual Tanpa Akun Terdaftar --</span>
                    </div>
                    <?php foreach ($usersList as $u): ?>
                        <div class="add-pj-item px-4 py-2 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-name="<?= esc($u['nama_lengkap']) ?> (@<?= esc($u['username']) ?>)" data-nama="<?= esc($u['nama_lengkap']) ?>" data-hp="<?= esc($u['no_hp'] ?? '') ?>" onclick="selectAddPj(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($u['nama_lengkap']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5">
                                    <span class="text-emerald-700 font-bold">@<?= esc($u['username']) ?></span>
                                    <span>&bull;</span>
                                    <span class="px-1.5 py-0.2 rounded bg-slate-100 text-[9px]"><?= esc($u['role']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noAddPjFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan akun pengguna yang sesuai.
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Penanggung Jawab</label>
                <input type="text" id="add_pj_nama" name="nama_pj" placeholder="Kang Ahmad Musyafa" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">No. Kontak / WA</label>
                    <input type="text" id="add_pj_kontak" name="kontak_pj" placeholder="0812xxxx" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Peran PJ</label>
                    <select name="peran" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Penanggung Jawab Utama">PJ Utama</option>
                        <option value="Pendamping Asrama">Pendamping Asrama</option>
                        <option value="Koordinator Lapangan">Koordinator Lapangan</option>
                        <option value="Anggota Pengurus">Anggota Pengurus</option>
                    </select>
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalAddPj()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan PJ Unit</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Anggota Kader Baru -->
<div id="modalAddKader" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-teal-600"></i> Tambah Anggota Kader Baru
            </h3>
            <button onclick="closeModalAddKader()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('unit/kader/add/' . $unit['id']) ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Santri / Kader <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_kader" placeholder="Contoh: M. Rifqi Maulana" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kamar / Kelas</label>
                    <input type="text" name="kamar_kelas" placeholder="Kamar 04 / Kelas 2B" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Posisi / Jabatan</label>
                    <select name="jabatan_kader" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                        <option value="Anggota Kader">Anggota Kader</option>
                        <option value="Ketua Tim Kader">Ketua Tim Kader</option>
                        <option value="Wakil Ketua">Wakil Ketua</option>
                        <option value="Koordinator Kebersihan">Koordinator</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">No. Kontak / WhatsApp (Opsional)</label>
                <input type="text" name="kontak_kader" placeholder="0812xxxx" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalAddKader()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 text-white text-xs font-extrabold hover:from-teal-700 hover:to-emerald-700 shadow-md shadow-teal-600/20 transition">Simpan Anggota Kader</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchDetailTab(tabName) {
        const panels = document.querySelectorAll('.tab-detail-panel');
        panels.forEach(p => p.classList.add('hidden'));

        const btns = document.querySelectorAll('.tab-detail-btn');
        btns.forEach(b => {
            b.classList.remove('bg-emerald-600', 'text-white', 'shadow-md', 'shadow-emerald-600/20');
            b.classList.add('text-slate-600', 'hover:bg-slate-100');
        });

        const targetPanel = document.getElementById('tab-detail-' + tabName);
        if (targetPanel) targetPanel.classList.remove('hidden');

        const activeBtn = document.getElementById('tab-btn-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:bg-slate-100');
            activeBtn.classList.add('bg-emerald-600', 'text-white', 'shadow-md', 'shadow-emerald-600/20');
        }
    }
    window.switchDetailTab = switchDetailTab;

    function openModalAddPj() {
        const idEl = document.getElementById('add_pj_user_id');
        if (idEl) idEl.value = '';
        const searchEl = document.getElementById('add_pj_user_search');
        if (searchEl) searchEl.value = '';
        filterAddPjOptions('');
        closeAddPjDropdown();
        const modal = document.getElementById('modalAddPj');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalAddPj = openModalAddPj;

    function closeModalAddPj() {
        const modal = document.getElementById('modalAddPj');
        if (modal) modal.classList.add('hidden');
        closeAddPjDropdown();
    }
    window.closeModalAddPj = closeModalAddPj;

    function openAddPjDropdown() {
        const list = document.getElementById('addPjDropdownList');
        const icon = document.getElementById('addPjIcon');
        if (list) list.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openAddPjDropdown = openAddPjDropdown;

    function closeAddPjDropdown() {
        const list = document.getElementById('addPjDropdownList');
        const icon = document.getElementById('addPjIcon');
        if (list) list.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.closeAddPjDropdown = closeAddPjDropdown;

    function toggleAddPjDropdown() {
        const list = document.getElementById('addPjDropdownList');
        if (list && list.classList.contains('hidden')) {
            openAddPjDropdown();
        } else {
            closeAddPjDropdown();
        }
    }
    window.toggleAddPjDropdown = toggleAddPjDropdown;

    function filterAddPjOptions(val) {
        val = (val || '').toLowerCase().trim();
        const items = document.querySelectorAll('.add-pj-item');
        let visibleCount = 0;
        items.forEach(item => {
            const id = item.getAttribute('data-id');
            if (!id) {
                item.style.display = 'flex';
                return;
            }
            const text = item.innerText.toLowerCase();
            if (!val || text.includes(val)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noAddPjFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0 || !val);
        }
        openAddPjDropdown();
    }
    window.filterAddPjOptions = filterAddPjOptions;

    function selectAddPj(el) {
        const id = el.getAttribute('data-id') || '';
        const name = el.getAttribute('data-name') || '';
        const nama = el.getAttribute('data-nama') || '';
        const hp = el.getAttribute('data-hp') || '';

        const idEl = document.getElementById('add_pj_user_id');
        const searchEl = document.getElementById('add_pj_user_search');
        if (idEl) idEl.value = id;
        if (searchEl) searchEl.value = name;

        const namaEl = document.getElementById('add_pj_nama');
        if (namaEl && nama) namaEl.value = nama;
        const kontakEl = document.getElementById('add_pj_kontak');
        if (kontakEl && hp) kontakEl.value = hp;

        closeAddPjDropdown();
    }
    window.selectAddPj = selectAddPj;

    function openModalAddKader() {
        const modal = document.getElementById('modalAddKader');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalAddKader = openModalAddKader;

    function closeModalAddKader() {
        const modal = document.getElementById('modalAddKader');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalAddKader = closeModalAddKader;

    document.addEventListener('click', function(e) {
        const addPjContainer = document.getElementById('add_pj_user_search')?.closest('.relative');
        if (addPjContainer && !addPjContainer.contains(e.target)) {
            closeAddPjDropdown();
        }

        const modalAddPj = document.getElementById('modalAddPj');
        if (e.target === modalAddPj) {
            closeModalAddPj();
        }

        const modalAddKader = document.getElementById('modalAddKader');
        if (e.target === modalAddKader) {
            closeModalAddKader();
        }
    });
</script>
<?= $this->endSection() ?>
