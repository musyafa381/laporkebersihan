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

            <div class="flex-shrink-0">
                <button onclick="openModalCreate()" class="w-full sm:w-auto px-5 sm:px-6 py-3 sm:py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-xs sm:text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <span>Buat Buku Bulan Baru</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Grid List Buku Bulanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php if (!empty($buku_list)): ?>
            <?php foreach ($buku_list as $buku): ?>
                <div class="group bg-white rounded-3xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 border border-slate-200/80 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                    
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
                            <div class="flex items-center gap-1">
                                <button onclick="openModalEdit(<?= $buku['id'] ?>, '<?= esc(addslashes($buku['judul'])) ?>', '<?= esc($buku['bulan']) ?>', <?= esc($buku['tahun']) ?>, '<?= esc($buku['status']) ?>')" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition flex items-center justify-center text-xs" title="Edit Informasi Buku">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <a href="<?= base_url('buku/delete/' . $buku['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus Buku LPJ ini beserta seluruh datanya?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition flex items-center justify-center text-xs" title="Hapus Buku">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
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
                        <a href="<?= base_url('buku/detail/' . $buku['id']) ?>" class="flex-1 py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs text-center hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 hover:shadow-lg hover:-translate-y-0.5">
                            <i class="fa-solid fa-folder-open"></i> Kelola & Isi LPJ
                        </a>
                        <a href="<?= base_url('buku/cetak/' . $buku['id']) ?>" target="_blank" class="py-2.5 px-3.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-xs hover:bg-emerald-100 transition border border-emerald-200 flex items-center justify-center" title="Cetak / Export PDF">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
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
</script>

<?= $this->endSection() ?>
