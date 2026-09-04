<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header (Struktur/LPJ Style) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-pen-to-square text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-pen-to-square"></i> Pengisian LPJ Unit Kebersihan
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Formulir Laporan LPJ Kebersihan Unit
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Pilih periode Buku LPJ di bawah ini untuk mengisi capaian target dan evaluasi kebersihan unit instansi Anda.
                </p>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
        <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 text-xs font-semibold text-emerald-900 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-building-user text-emerald-600 text-2xl"></i>
                <div>
                    <div class="font-extrabold text-xs text-emerald-800">Unit Instansi Pengampu Anda:</div>
                    <div class="text-base font-extrabold text-emerald-950"><?= esc($userUnit['nama_unit'] ?? 'Pengurus K3L Pusat') ?></div>
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-book-bookmark text-emerald-600"></i> Pilih Periode Buku LPJ Untuk Diisi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (!empty($bukuList)): ?>
                    <?php foreach ($bukuList as $b): 
                        $bStatus = $b['status'] ?: 'Aktif';
                        $isAktif = (strtolower(trim($bStatus)) === 'aktif' || strtolower(trim($bStatus)) === 'berjalan' || strtolower(trim($bStatus)) === 'active');
                    ?>
                        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 bg-white space-y-4 shadow-2xs hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full <?= $isAktif ? 'bg-emerald-100 text-emerald-900 border-emerald-200' : 'bg-slate-100 text-slate-700 border-slate-200' ?> text-xs font-extrabold border">
                                    Periode: <?= esc($b['bulan']) ?> <?= esc($b['tahun']) ?>
                                </span>
                                <?php if ($isAktif): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="fa-solid fa-lock text-[10px]"></i>
                                        <?= esc($bStatus) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-heading font-extrabold text-lg text-slate-900"><?= esc($b['judul']) ?></h4>
                            </div>

                            <?php if (!empty($userUnit)): ?>
                                <?php if ($isAktif): ?>
                                    <a href="<?= base_url('buku/evaluasi/form/' . $b['id'] . '/' . $userUnit['id']) ?>" class="w-full py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Isi / Edit LPJ <?= esc($userUnit['nama_unit']) ?></span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('buku/evaluasi/form/' . $b['id'] . '/' . $userUnit['id']) ?>" class="w-full py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition border border-slate-200/80 flex items-center justify-center gap-2 shadow-2xs">
                                        <i class="fa-solid fa-eye text-slate-500"></i>
                                        <span>Lihat LPJ <?= esc($userUnit['nama_unit']) ?> (Hanya Lihat)</span>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?= base_url('buku/detail/' . $b['id']) ?>" class="w-full py-3 rounded-2xl bg-slate-100 text-slate-700 font-heading font-extrabold text-xs text-center block">
                                    Buka Detail LPJ Pusat
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-2 p-8 text-center text-slate-400 italic font-medium">
                        Belum ada periode buku LPJ yang dibuat Admin.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
