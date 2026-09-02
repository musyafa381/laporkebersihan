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

    <!-- Grid List Buku Keuangan Bulanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php if (!empty($keuangan_list)): ?>
            <?php foreach ($keuangan_list as $buku): ?>
                <div class="group bg-white rounded-3xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 border border-slate-200/80 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                    
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
</script>

<?= $this->endSection() ?>
