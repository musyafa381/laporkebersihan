<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Top Navigation & Flash Message -->
    <div class="flex items-center justify-between">
        <a href="<?= base_url('pengaturan?tab=units') ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 font-extrabold text-xs transition shadow-2xs">
            <i class="fa-solid fa-arrow-left text-emerald-600"></i>
            <span>Kembali ke Pengaturan Unit</span>
        </a>
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

    <!-- Main Banner Profil Unit -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-slate-900 text-emerald-400 font-mono">
                        <?= esc($unit['kode_unit'] ?: 'UNIT-' . $unit['id']) ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        <?= esc($unit['tipe']) ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold <?= ($unit['status'] ?? 'Aktif') === 'Aktif' ? 'bg-teal-50 text-teal-800 border border-teal-200/60' : 'bg-rose-50 text-rose-800 border border-rose-200/60' ?>">
                        <i class="fa-solid fa-circle text-[8px] mr-1 <?= ($unit['status'] ?? 'Aktif') === 'Aktif' ? 'text-teal-500' : 'text-rose-500' ?>"></i>
                        <?= esc($unit['status'] ?? 'Aktif') ?>
                    </span>
                    <?php if (($unit['ada_kader'] ?? 'Ya') === 'Tidak'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                            Tanpa Kader
                        </span>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-800 border border-blue-200/60">
                            <?= esc($unit['jenis_kader'] ?: 'Gemerlap') ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div>
                    <h1 class="font-heading font-black text-2xl sm:text-3xl text-slate-900 tracking-tight">
                        <?= esc($unit['nama_unit']) ?>
                    </h1>
                    <p class="text-xs text-slate-500 font-semibold mt-1 flex items-center gap-2">
                        <i class="fa-solid fa-building text-emerald-600"></i>
                        <span>Instansi Kebersihan K3L Assalafiyyah Mlangi</span>
                        <span class="text-slate-300">•</span>
                        <span>Dibuat: <?= date('d M Y', strtotime($unit['created_at'] ?? 'now')) ?></span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="openModalAddPj()" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>+ Tambah PJ Unit</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Grid 2 Kolom: Penanggung Jawab (Multi-PJ) & Anggota Kader -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Kartu Daftar Multi-PJ -->
        <div class="glass-card rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-emerald-600"></i> Penanggung Jawab (Multi-PJ)
                    </h3>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Semua pengurus yang mengampu unit instansi ini.</p>
                </div>
                <button onclick="openModalAddPj()" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 transition">
                    + Tambah PJ
                </button>
            </div>

            <?php if (!empty($pjs)): ?>
                <div class="space-y-3">
                    <?php foreach ($pjs as $pj): ?>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-3 hover:border-emerald-200 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-heading font-extrabold text-sm flex items-center justify-center shadow-xs">
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
                                        <?php if (!empty($pj['kontak_pj']) || !empty($pj['no_hp'])): ?>
                                            <span>• WA: <?= esc($pj['kontak_pj'] ?: $pj['no_hp']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php if ($pj['id'] > 0): ?>
                                <a href="<?= base_url('pengaturan/unit/pj/delete/' . $pj['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus PJ ini dari unit?" class="w-7 h-7 rounded-xl bg-slate-200/60 text-slate-500 hover:text-rose-600 hover:bg-rose-100 flex items-center justify-center transition" title="Hapus PJ">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-6 text-center text-slate-400 text-xs italic">
                    Belum ada Penanggung Jawab (PJ) yang ditautkan ke unit ini.
                </div>
            <?php endif; ?>
        </div>

        <!-- Kartu Daftar Anggota Kader (Gemerlap / Satgas) -->
        <div class="glass-card rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-users text-emerald-600"></i> Anggota KaderKebersihan
                    </h3>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">
                        <?= ($unit['ada_kader'] ?? 'Ya') === 'Tidak' ? 'Unit ini diset Tanpa Kader.' : 'Tim ' . esc($unit['jenis_kader'] ?: 'Gemerlap') . ' yang bertugas.' ?>
                    </p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-slate-100 text-slate-700">
                    <?= count($kaderList) ?> Anggota
                </span>
            </div>

            <?php if (($unit['ada_kader'] ?? 'Ya') === 'Tidak'): ?>
                <div class="p-6 text-center text-slate-400 text-xs italic">
                    Unit / Instansi ini berstatus <strong>Tanpa Kader</strong>.
                </div>
            <?php elseif (!empty($kaderList)): ?>
                <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                    <?php foreach ($kaderList as $k): ?>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-heading font-extrabold text-sm flex items-center justify-center shadow-xs">
                                    <?= strtoupper(substr($k['nama_lengkap'], 0, 2)) ?>
                                </div>
                                <div>
                                    <div class="font-heading font-extrabold text-xs text-slate-900">
                                        <?= esc($k['nama_lengkap']) ?>
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-semibold flex items-center gap-2 mt-0.5">
                                        <span>@<?= esc($k['username']) ?></span>
                                        <?php if (!empty($k['no_hp'])): ?>
                                            <span>• WA: <?= esc($k['no_hp']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-800 border border-blue-200/60">
                                <?= esc($k['role']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-6 text-center text-slate-400 text-xs italic">
                    Belum ada akun Kader yang ditautkan ke unit ini. Tambahkan akun kader dari menu <a href="<?= base_url('profil') ?>" class="text-emerald-600 underline font-bold">Kelola Akun Profil</a>.
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- 3 Tab Riwayat Instansi (Inventaris, Pengajuan & Distribusi Alat, Reports CS) -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">

        <!-- Tab Header Buttons -->
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
            <button id="tab-btn-allocated" onclick="switchDetailTab('allocated')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs bg-emerald-600 text-white shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Inventaris & Alat Terlokasi (<?= count($allocatedTools) ?>)</span>
            </button>
            <button id="tab-btn-history" onclick="switchDetailTab('history')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs text-slate-600 hover:bg-slate-100 transition flex items-center gap-2">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <span>Riwayat Distribusi Alat (<?= count($distribHistory) ?>)</span>
            </button>
            <button id="tab-btn-cs" onclick="switchDetailTab('cs')" class="tab-detail-btn px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs text-slate-600 hover:bg-slate-100 transition flex items-center gap-2">
                <i class="fa-solid fa-comments"></i>
                <span>Riwayat Laporan Kebersihan CS (<?= count($csHistory) ?>)</span>
            </button>
        </div>

        <!-- Tab Content 1: Alat Kebersihan Terlokasi -->
        <div id="tab-detail-allocated" class="tab-detail-panel space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-box text-emerald-600"></i> Alat Kebersihan Yang Diberikan / Terlokasi Di Unit
                    </h4>
                    <p class="text-xs text-slate-500 font-semibold">Alokasi peralatan kebersihan aktif hasil distribusi dari Gudang K3L.</p>
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

        <!-- Tab Content 2: Riwayat Distribusi & Pengajuan Alat -->
        <div id="tab-detail-history" class="tab-detail-panel hidden space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Log Transaksi Distribusi & Penerimaan Barang
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

        <!-- Tab Content 3: Riwayat Laporan Kebersihan CS -->
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
                            <th class="py-3 px-4">ID Laporan</th>
                            <th class="py-3 px-4">Pelapor</th>
                            <th class="py-3 px-4">Kategori Laporan</th>
                            <th class="py-3 px-4">Deskripsi / Catatan</th>
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

        <form action="<?= base_url('pengaturan/unit/pj/add/' . $unit['id']) ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Akun Terdaftar (Opsional)</label>
                <select name="user_id" onchange="fillPjFromUser(this)" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="">-- Pilih Akun Terdaftar --</option>
                    <?php foreach ($usersList as $u): ?>
                        <option value="<?= $u['id'] ?>" data-nama="<?= esc($u['nama_lengkap']) ?>" data-hp="<?= esc($u['no_hp']) ?>">
                            <?= esc($u['nama_lengkap']) ?> (@<?= esc($u['username']) ?>) - <?= esc($u['role']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
        const modal = document.getElementById('modalAddPj');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalAddPj = openModalAddPj;

    function closeModalAddPj() {
        const modal = document.getElementById('modalAddPj');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalAddPj = closeModalAddPj;

    function fillPjFromUser(selectEl) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        if (selectedOption && selectedOption.value !== '') {
            const nama = selectedOption.getAttribute('data-nama') || '';
            const hp   = selectedOption.getAttribute('data-hp') || '';
            const namaEl = document.getElementById('add_pj_nama');
            if (namaEl) namaEl.value = nama;
            const kontakEl = document.getElementById('add_pj_kontak');
            if (kontakEl) kontakEl.value = hp;
        }
    }
    window.fillPjFromUser = fillPjFromUser;
</script>
<?= $this->endSection() ?>
