<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-pen-to-square text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-book-open"></i> Modul Pengisian LPJ Unit Kebersihan
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Laporan Pertanggungjawaban (LPJ) Unit
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Pilih periode Buku LPJ di bawah ini untuk mengisi capaian target, kendala lapangan, rencana tindakan, dan usulan unit kebersihan Anda.
                </p>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
        <!-- Unit Info Bar -->
        <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 text-xs font-semibold text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-600/20">
                    <i class="fa-solid fa-building-user text-base"></i>
                </div>
                <div>
                    <div class="font-extrabold text-[11px] text-emerald-800 uppercase tracking-wider">Unit Instansi Pengampu Anda</div>
                    <div class="text-base font-extrabold text-emerald-950"><?= esc($userUnit['nama_unit'] ?? 'Pengurus K3L Pusat') ?></div>
                </div>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <span class="px-3 py-1 rounded-xl bg-white border border-emerald-200 text-emerald-800 text-xs font-extrabold shadow-2xs">
                    <i class="fa-solid fa-layer-group mr-1 text-emerald-600"></i>
                    <?= esc($userUnit['tipe'] ?? 'Pusat') ?>
                </span>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-book-bookmark text-emerald-600"></i> Pilih Periode Buku LPJ
                </h3>
                <span class="text-xs font-extrabold text-slate-500">
                    <?= count($bukuList) ?> Periode Tersedia
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (!empty($bukuList)): ?>
                    <?php foreach ($bukuList as $b): 
                        $bStatus = $b['status'] ?: 'Aktif';
                        $isAktif = (strtolower(trim($bStatus)) === 'aktif' || strtolower(trim($bStatus)) === 'berjalan' || strtolower(trim($bStatus)) === 'active');
                        $hasEvaluasi = !empty($evaluasiByBuku[$b['id']]);
                    ?>
                        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 bg-white space-y-4 shadow-2xs hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full <?= $isAktif ? 'bg-emerald-100 text-emerald-900 border-emerald-200' : 'bg-slate-100 text-slate-700 border-slate-200' ?> text-xs font-extrabold border">
                                    <i class="fa-regular fa-calendar-days mr-1 text-emerald-700"></i>
                                    <?= esc($b['bulan']) ?> <?= esc($b['tahun']) ?>
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <?php if ($hasEvaluasi): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <i class="fa-solid fa-check-double text-[9px] text-emerald-600"></i> Sudah Diisi
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200">
                                            <i class="fa-solid fa-clock text-[9px] text-amber-600"></i> Belum Diisi
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($isAktif): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            <i class="fa-solid fa-lock text-[10px]"></i>
                                            Terkunci
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-heading font-extrabold text-base text-slate-900 leading-snug"><?= esc($b['judul']) ?></h4>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= esc($b['deskripsi'] ?? 'Laporan kinerja dan evaluasi bulanan bidang kebersihan & penataan lingkungan.') ?></p>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-2">
                                <?php if (!empty($userUnit)): ?>
                                    <?php if ($isAktif): ?>
                                        <a href="<?= base_url('buku/evaluasi/form/' . $b['id'] . '/' . $userUnit['id']) ?>" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span><?= $hasEvaluasi ? 'Edit Laporan LPJ' : 'Isi Formulir LPJ' ?></span>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('buku/evaluasi/form/' . $b['id'] . '/' . $userUnit['id']) ?>" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition border border-slate-200/80 flex items-center justify-center gap-2 shadow-2xs">
                                            <i class="fa-solid fa-eye text-slate-500"></i>
                                            <span>Lihat Laporan (Terkunci)</span>
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?= base_url('buku/detail/' . $b['id']) ?>" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs text-center transition">
                                        Detail Buku LPJ
                                    </a>
                                <?php endif; ?>

                                <a href="<?= base_url('buku/cetak/' . $b['id']) ?>" target="_blank" class="w-full sm:w-auto py-2.5 px-3.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition border border-emerald-200/80 flex items-center justify-center gap-1.5 shadow-2xs" title="Lihat hasil format cetak buku LPJ lengkap">
                                    <i class="fa-solid fa-print"></i>
                                    <span class="hidden sm:inline">Cetak</span>
                                </a>
                            </div>
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
