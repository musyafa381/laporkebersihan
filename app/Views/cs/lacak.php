<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 sm:space-y-8 max-w-5xl mx-auto">

    <!-- ========================================== -->
    <!-- 🔍 HERO BANNER: LACAK PENGADUAN KEBERSIHAN -->
    <!-- ========================================== -->
    <div class="relative overflow-hidden rounded-[32px] p-6 sm:p-10 shadow-[0_20px_50px_rgba(6,78,59,0.22)] border border-white/25 bg-gradient-to-br from-emerald-950/90 via-teal-900/85 to-slate-950/90 backdrop-blur-2xl text-white">
        <!-- Ambient Background Glows -->
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/15 backdrop-blur-md text-emerald-200 text-xs font-extrabold uppercase tracking-wider border border-white/20 shadow-2xs">
                    <i class="fa-solid fa-ticket text-emerald-400"></i> Status Real-time
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-heading font-black tracking-tight leading-tight text-white drop-shadow-md">
                    Lacak Status Laporan & Pengaduan
                </h1>
                <p class="text-slate-200 text-xs sm:text-sm leading-relaxed font-medium">
                    Pantau tahapan tindak lanjut kendala kebersihan yang telah Anda laporkan secara transparan menggunakan <strong>Kode Tiket Pengaduan</strong>.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?= base_url('cs') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition shadow-sm hover:scale-105">
                    <i class="fa-solid fa-plus-circle text-emerald-300"></i>
                    <span>Buat Laporan Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert / Flash Messages -->
    <?php if (session()->getFlashdata('success_tiket')): ?>
        <div class="p-5 rounded-3xl bg-emerald-500/10 border-2 border-emerald-500/30 text-emerald-900 shadow-xl backdrop-blur-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 animate-in fade-in zoom-in duration-300">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-lg flex-shrink-0 shadow-md shadow-emerald-600/30">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <h4 class="font-heading font-extrabold text-sm sm:text-base text-emerald-950">Laporan Anda Berhasil Terkirim!</h4>
                    <p class="text-xs text-emerald-800/90 mt-0.5 font-medium">
                        Simpan Kode Tiket Anda untuk memantau perkembangan penanganan: 
                        <strong class="font-mono bg-emerald-100/80 px-2 py-0.5 rounded-lg border border-emerald-300 select-all text-emerald-950"><?= esc(session()->getFlashdata('success_tiket')) ?></strong>
                    </p>
                </div>
            </div>
            <button onclick="copyTiketCode('<?= esc(session()->getFlashdata('success_tiket')) ?>')" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition shadow-md flex items-center gap-1.5 flex-shrink-0">
                <i class="fa-solid fa-copy"></i>
                <span>Salin Tiket</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- 🔎 FORM PENCARIAN KODE TIKET               -->
    <!-- ========================================== -->
    <div class="glass-card rounded-[32px] p-6 sm:p-8 shadow-[0_12px_40px_rgba(0,0,0,0.06)] border border-white/80 bg-white/90 backdrop-blur-2xl space-y-4">
        <form action="<?= base_url('lacak') ?>" method="GET" class="space-y-3" id="formLacakTiket">
            <label for="inputTiket" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass-location text-emerald-600"></i>
                    <span>Masukkan Kode Tiket Pengaduan</span>
                </span>
                <span class="text-[10px] text-slate-400 font-semibold normal-case">Contoh: CS-260910-0013</span>
            </label>
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full">
                    <i class="fa-solid fa-ticket absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="text" id="inputTiket" name="tiket" value="<?= esc($tiket ?? '') ?>" placeholder="Ketik atau tempel Kode Tiket di sini..." autocomplete="off" required class="w-full pl-11 pr-4 py-3.5 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 text-sm font-extrabold text-slate-800 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition shadow-inner font-mono tracking-wide uppercase placeholder:normal-case placeholder:font-normal placeholder:text-slate-400">
                </div>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-800 text-white font-heading font-black text-sm shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 flex-shrink-0">
                    <i class="fa-solid fa-search"></i>
                    <span>Lacak Laporan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ========================================== -->
    <!-- 📊 HASIL PELACAKAN TIKET                   -->
    <!-- ========================================== -->
    <?php if ($searched && $report): ?>
        <?php
            $status = $report['status'] ?? 'Baru';
            
            // Timeline step state calculation
            // Steps: 1. Laporan Masuk -> 2. Divalidasi & Ditugaskan -> 3. Ditindaklanjuti -> 4. Selesai
            $stepIndex = match($status) {
                'Baru'     => 1,
                'Diproses' => (!empty($report['ditanggapi_unit_at']) || !empty($report['tanggapan_unit']) || !empty($report['tanggapan_admin'])) ? 3 : 2,
                'Selesai'  => 4,
                'Ditolak'  => 4,
                default    => 1
            };

            $isDitolak = ($status === 'Ditolak');

            $statusBadgeClass = match($status) {
                'Baru'     => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                'Diproses' => 'bg-amber-50 text-amber-800 border-amber-200',
                'Selesai'  => 'bg-blue-50 text-blue-800 border-blue-200',
                'Ditolak'  => 'bg-rose-50 text-rose-800 border-rose-200',
                default    => 'bg-slate-100 text-slate-700 border-slate-200'
            };

            $statusIcon = match($status) {
                'Baru'     => 'fa-circle-dot text-emerald-600 animate-pulse',
                'Diproses' => 'fa-spinner fa-spin text-amber-600',
                'Selesai'  => 'fa-circle-check text-blue-600',
                'Ditolak'  => 'fa-circle-xmark text-rose-600',
                default    => 'fa-circle-info text-slate-500'
            };

            $fotoArray = [];
            if (!empty($report['foto_lampiran'])) {
                $decoded = json_decode($report['foto_lampiran'], true);
                $fotoArray = is_array($decoded) ? $decoded : [$report['foto_lampiran']];
            }

            $fotoTindakanArray = [];
            if (!empty($report['foto_tindakan_unit'])) {
                $decodedTindakan = json_decode($report['foto_tindakan_unit'], true);
                $fotoTindakanArray = is_array($decodedTindakan) ? $decodedTindakan : [$report['foto_tindakan_unit']];
            }
        ?>

        <div class="glass-card rounded-[32px] p-6 sm:p-9 shadow-xl shadow-slate-200/50 border border-slate-200/80 bg-white space-y-8 animate-in fade-in duration-300">
            
            <!-- Header Kartu Tiket -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span class="font-mono text-sm sm:text-base font-black px-3.5 py-1 rounded-2xl bg-slate-900 text-white tracking-wider shadow-md">
                            <?= esc($report['kode_tiket'] ?? ('CS-#' . $report['id'])) ?>
                        </span>
                        <button onclick="copyTiketCode('<?= esc($report['kode_tiket'] ?? ('CS-#' . $report['id'])) ?>')" class="text-xs text-slate-500 hover:text-emerald-700 font-bold flex items-center gap-1 bg-slate-100 hover:bg-slate-200 px-2.5 py-1 rounded-xl transition" title="Salin Kode Tiket">
                            <i class="fa-solid fa-copy"></i>
                            <span id="copyTiketText">Salin</span>
                        </button>
                    </div>
                    <div class="text-xs text-slate-400 font-medium flex items-center gap-2 flex-wrap">
                        <span><i class="fa-solid fa-calendar-days text-slate-400 mr-1"></i><?= date('d F Y', strtotime($report['created_at'])) ?></span>
                        <span>&bull;</span>
                        <span><i class="fa-solid fa-clock text-slate-400 mr-1"></i><?= date('H:i', strtotime($report['created_at'])) ?> WIB</span>
                        <span>&bull;</span>
                        <span class="text-slate-600 font-bold"><?= esc($report['kategori'] ?? 'Kendala Kebersihan') ?></span>
                    </div>
                </div>

                <!-- Status Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border font-heading font-black text-xs sm:text-sm shadow-2xs <?= $statusBadgeClass ?>">
                    <i class="fa-solid <?= $statusIcon ?>"></i>
                    <span>Status: <?= esc($status) ?></span>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 🛤️ PROGRESS TRACKER TIMELINE              -->
            <!-- ========================================== -->
            <div class="space-y-3">
                <div class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                    Tahapan Perkembangan Penanganan
                </div>

                <?php if ($isDitolak): ?>
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-medium flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base mt-0.5 flex-shrink-0"></i>
                        <div>
                            <span class="font-bold">Laporan Tidak Dapat Diproses / Ditolak.</span>
                            <p class="mt-0.5 text-rose-800"><?= esc($report['tanggapan_admin'] ?: 'Laporan tidak memenuhi kriteria atau informasi lokasi belum lengkap. Silakan hubungi hotline CS untuk konfirmasi.') ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 relative">
                        <!-- Step 1: Laporan Masuk -->
                        <div class="p-3.5 rounded-2xl border <?= $stepIndex >= 1 ? 'bg-emerald-50/80 border-emerald-200 shadow-2xs' : 'bg-slate-50 border-slate-200 opacity-60' ?> space-y-1.5 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs <?= $stepIndex >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' ?>">
                                    <i class="fa-solid <?= $stepIndex > 1 ? 'fa-check' : 'fa-paper-plane' ?>"></i>
                                </div>
                                <span class="text-[10px] font-mono font-bold text-slate-400">Tahap 1</span>
                            </div>
                            <div class="font-heading font-extrabold text-xs text-slate-900 leading-tight">Laporan Diterima</div>
                            <p class="text-[10.5px] text-slate-500 leading-tight">Tercatat di sistem K3L.</p>
                        </div>

                        <!-- Step 2: Validasi & Penugasan -->
                        <div class="p-3.5 rounded-2xl border <?= $stepIndex >= 2 ? 'bg-emerald-50/80 border-emerald-200 shadow-2xs' : 'bg-slate-50 border-slate-200 opacity-60' ?> space-y-1.5 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs <?= $stepIndex >= 2 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' ?>">
                                    <i class="fa-solid <?= $stepIndex > 2 ? 'fa-check' : 'fa-user-check' ?>"></i>
                                </div>
                                <span class="text-[10px] font-mono font-bold text-slate-400">Tahap 2</span>
                            </div>
                            <div class="font-heading font-extrabold text-xs text-slate-900 leading-tight">Divalidasi & Ditugaskan</div>
                            <p class="text-[10.5px] text-slate-500 leading-tight">Diteruskan ke PJ Unit/Shift.</p>
                        </div>

                        <!-- Step 3: Tindak Lanjut Lokasi -->
                        <div class="p-3.5 rounded-2xl border <?= $stepIndex >= 3 ? 'bg-emerald-50/80 border-emerald-200 shadow-2xs' : 'bg-slate-50 border-slate-200 opacity-60' ?> space-y-1.5 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs <?= $stepIndex >= 3 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' ?>">
                                    <i class="fa-solid <?= $stepIndex > 3 ? 'fa-check' : 'fa-broom' ?>"></i>
                                </div>
                                <span class="text-[10px] font-mono font-bold text-slate-400">Tahap 3</span>
                            </div>
                            <div class="font-heading font-extrabold text-xs text-slate-900 leading-tight">Penanganan Lokasi</div>
                            <p class="text-[10.5px] text-slate-500 leading-tight">Pembersihan oleh tim/kader.</p>
                        </div>

                        <!-- Step 4: Selesai -->
                        <div class="p-3.5 rounded-2xl border <?= $stepIndex >= 4 ? 'bg-blue-50/80 border-blue-200 shadow-2xs' : 'bg-slate-50 border-slate-200 opacity-60' ?> space-y-1.5 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs <?= $stepIndex >= 4 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' ?>">
                                    <i class="fa-solid fa-flag-checkered"></i>
                                </div>
                                <span class="text-[10px] font-mono font-bold text-slate-400">Tahap 4</span>
                            </div>
                            <div class="font-heading font-extrabold text-xs text-slate-900 leading-tight">Tuntas Selesai</div>
                            <p class="text-[10.5px] text-slate-500 leading-tight">Kendala terselesaikan.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ========================================== -->
            <!-- 🏢 DETAIL LOKASI & PENANGGUNG JAWAB        -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-emerald-600"></i> Lokasi Kendala
                    </span>
                    <div class="font-extrabold text-xs sm:text-sm text-slate-800">
                        <?= esc($report['unit_lokasi'] ?? '-') ?>
                    </div>
                    <?php if (!empty($report['nama_wilayah'])): ?>
                        <div class="text-[11px] text-teal-700 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-map-pin text-teal-500 text-[9px]"></i> Spot: <?= esc($report['nama_wilayah']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                        <i class="fa-solid fa-clock text-teal-600"></i> Waktu / Shift
                    </span>
                    <div class="font-extrabold text-xs sm:text-sm text-slate-800">
                        <?= !empty($report['shift']) ? ('Shift ' . esc($report['shift'])) : 'Shift Umum' ?>
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">
                        Pelapor: <?= esc($report['nama_pengirim'] ?? 'Warga') ?>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                        <i class="fa-solid fa-user-shield text-emerald-600"></i> Unit / PJ Penanggung Jawab
                    </span>
                    <div class="font-extrabold text-xs sm:text-sm text-slate-800">
                        <?= esc($report['nama_unit'] ?? $report['unit_lokasi'] ?? 'Tim K3L') ?>
                    </div>
                    <?php if (!empty($report['pj_nama'])): ?>
                        <div class="text-[11px] text-slate-500 font-medium">
                            PJ: <?= esc($report['pj_nama']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 📝 DETAIL KENDALA & FOTO PELAPOR           -->
            <!-- ========================================== -->
            <div class="space-y-2.5">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-file-lines text-emerald-600"></i>
                    <span>Isi Laporan / Kendala yang Dilaporkan</span>
                </label>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 text-xs sm:text-sm text-slate-800 leading-relaxed font-medium">
                    "<?= nl2br(esc($report['isi_laporan'])) ?>"
                </div>

                <!-- Foto Bukti Lampiran Pelapor -->
                <?php if (!empty($fotoArray)): ?>
                    <div class="space-y-1.5 pt-2">
                        <span class="text-[11px] font-bold text-slate-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-camera text-slate-400"></i> Foto Bukti Saat Pelaporan (<?= count($fotoArray) ?> Foto):
                        </span>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <?php foreach ($fotoArray as $fIdx => $foto): ?>
                                <?php 
                                    $imgSrc = (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://')) ? $foto : base_url('uploads/cs/' . $foto);
                                ?>
                                <a href="<?= $imgSrc ?>" target="_blank" class="group relative w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-md hover:border-emerald-500 transition transform hover:scale-105 flex-shrink-0" title="Klik untuk memperbesar foto">
                                    <img src="<?= $imgSrc ?>" class="w-full h-full object-cover">
                                    <span class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ========================================== -->
            <!-- 💬 TANGGAPAN & PENANGANAN ADMIN / PETUGAS  -->
            <!-- ========================================== -->
            <?php if (!empty($report['tanggapan_admin']) || !empty($report['tanggapan_unit']) || !empty($fotoTindakanArray)): ?>
                <div class="p-5 rounded-3xl bg-gradient-to-r from-emerald-50/90 via-teal-50/70 to-emerald-50/90 border border-emerald-200/90 space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between gap-2 border-b border-emerald-200/60 pb-2.5">
                        <h4 class="font-heading font-extrabold text-xs sm:text-sm text-emerald-950 flex items-center gap-2">
                            <i class="fa-solid fa-comments text-emerald-600"></i>
                            <span>Tanggapan & Catatan Resmi Tim Kebersihan</span>
                        </h4>
                        <?php if (!empty($report['nama_penanggap_unit'])): ?>
                            <span class="text-[10.5px] font-bold text-emerald-800 bg-white/80 px-2 py-0.5 rounded-full border border-emerald-200">
                                Oleh: <?= esc($report['nama_penanggap_unit']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($report['tanggapan_admin'])): ?>
                        <div class="text-xs sm:text-sm text-emerald-900 font-medium leading-relaxed">
                            <span class="font-bold text-emerald-950">Catatan Admin:</span> <?= nl2br(esc($report['tanggapan_admin'])) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($report['tanggapan_unit'])): ?>
                        <div class="text-xs sm:text-sm text-teal-900 font-medium leading-relaxed">
                            <span class="font-bold text-teal-950">Catatan Petugas Unit:</span> <?= nl2br(esc($report['tanggapan_unit'])) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Foto Hasil Penanganan -->
                    <?php if (!empty($fotoTindakanArray)): ?>
                        <div class="space-y-1.5 pt-2 border-t border-emerald-200/60">
                            <span class="text-[11px] font-bold text-emerald-900 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i> Foto Hasil Penanganan (<?= count($fotoTindakanArray) ?> Foto):
                            </span>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <?php foreach ($fotoTindakanArray as $tIdx => $tFoto): ?>
                                    <?php 
                                        $tImgSrc = (str_starts_with($tFoto, 'http://') || str_starts_with($tFoto, 'https://')) ? $tFoto : base_url('uploads/cs/' . $tFoto);
                                    ?>
                                    <a href="<?= $tImgSrc ?>" target="_blank" class="group relative w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden border border-emerald-300 shadow-2xs hover:shadow-md transition transform hover:scale-105 flex-shrink-0" title="Foto Bukti Penanganan">
                                        <img src="<?= $tImgSrc ?>" class="w-full h-full object-cover">
                                        <span class="absolute inset-0 bg-emerald-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        </span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-amber-900 text-xs font-medium flex items-center gap-2.5">
                    <i class="fa-solid fa-clock text-amber-600 text-sm flex-shrink-0"></i>
                    <span>Laporan ini telah diterima dan sedang dalam antrean tindak lanjut oleh petugas/unit kebersihan terkait.</span>
                </div>
            <?php endif; ?>

            <!-- Footer Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-100">
                <a href="<?= base_url('lacak') ?>" class="text-xs text-slate-500 hover:text-slate-800 font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Cari Tiket Lain</span>
                </a>
                
                <div class="flex items-center gap-2 flex-wrap">
                    <?php
                        $cleanWaNumber = preg_replace('/[^0-9]/', '', $hotlineWa ?? '0895320276800');
                        if (str_starts_with($cleanWaNumber, '0')) {
                            $cleanWaNumber = '62' . substr($cleanWaNumber, 1);
                        }
                        $waInquiryMsg = "Halo Admin Kebersihan K3L, saya ingin menanyakan perkembangan tindak lanjut untuk Kode Tiket: " . ($report['kode_tiket'] ?? ('CS-#' . $report['id'])) . ". Terima kasih.";
                        $waInquiryUrl = "https://api.whatsapp.com/send?phone=" . $cleanWaNumber . "&text=" . urlencode($waInquiryMsg);
                    ?>
                    <a href="<?= $waInquiryUrl ?>" target="_blank" class="px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs transition shadow-md flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Tanyakan ke Hotline CS</span>
                    </a>
                </div>
            </div>

        </div>

    <?php elseif ($searched && !$report): ?>
        <!-- State: Tiket Tidak Ditemukan -->
        <div class="glass-card rounded-[32px] p-8 sm:p-12 text-center shadow-xl border border-slate-200/80 bg-white space-y-4 animate-in fade-in duration-300">
            <div class="w-16 h-16 rounded-3xl bg-rose-50 text-rose-500 border border-rose-200 flex items-center justify-center text-2xl mx-auto shadow-sm">
                <i class="fa-solid fa-ticket-simple"></i>
            </div>
            <div class="space-y-1 max-w-md mx-auto">
                <h3 class="font-heading font-black text-lg text-slate-900">Kode Tiket Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    Tidak ada data pengaduan yang cocok dengan kode <strong class="font-mono text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded"><?= esc($tiket) ?></strong>. Pastikan tidak ada salah ketik pada huruf dan angka kode tiket Anda.
                </p>
            </div>
            <div class="pt-2 flex items-center justify-center gap-3">
                <a href="<?= base_url('lacak') ?>" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Coba Lagi
                </a>
                <a href="<?= base_url('cs') ?>" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition shadow-md flex items-center gap-1.5">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Buat Laporan Baru</span>
                </a>
            </div>
        </div>

    <?php else: ?>
        <!-- ========================================== -->
        <!-- 💡 PANDUAN / INFO CARD KETIKA BELUM CARI   -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="glass-card rounded-3xl p-6 shadow-sm border border-slate-200/80 bg-white space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/60 flex items-center justify-center text-base shadow-2xs">
                    <i class="fa-solid fa-1"></i>
                </div>
                <h3 class="font-heading font-extrabold text-sm text-slate-900">Dapatkan Kode Tiket</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    Kode Tiket unik otomatis diterbitkan setiap kali Anda selesai mengirim formulir pengaduan kendala kebersihan.
                </p>
            </div>

            <div class="glass-card rounded-3xl p-6 shadow-sm border border-slate-200/80 bg-white space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 border border-teal-200/60 flex items-center justify-center text-base shadow-2xs">
                    <i class="fa-solid fa-2"></i>
                </div>
                <h3 class="font-heading font-extrabold text-sm text-slate-900">Masukkan & Cari</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    Ketik kode tiket di kolom atas kapan pun Anda ingin memeriksa perkembangan tindakan oleh tim dan petugas kebersihan.
                </p>
            </div>

            <div class="glass-card rounded-3xl p-6 shadow-sm border border-slate-200/80 bg-white space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-700 border border-blue-200/60 flex items-center justify-center text-base shadow-2xs">
                    <i class="fa-solid fa-3"></i>
                </div>
                <h3 class="font-heading font-extrabold text-sm text-slate-900">Pantau Real-Time</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    Lihat foto bukti sebelum & sesudah penanganan serta tanggapan resmi dari Admin dan Unit penanggung jawab.
                </p>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    function copyTiketCode(code) {
        if (!code) return;
        navigator.clipboard.writeText(code).then(() => {
            const btnText = document.getElementById('copyTiketText');
            if (btnText) {
                btnText.textContent = 'Tersalin!';
                setTimeout(() => {
                    btnText.textContent = 'Salin';
                }, 2000);
            }
            if (typeof showToast === 'function') {
                showToast('Kode Tiket (' + code + ') berhasil disalin ke clipboard!', 'success');
            }
        }).catch(err => {
            const input = document.getElementById('inputTiket');
            if (input) {
                input.value = code;
                input.select();
                document.execCommand('copy');
                if (typeof showToast === 'function') {
                    showToast('Kode Tiket disalin!', 'success');
                }
            }
        });
    }
    window.copyTiketCode = copyTiketCode;
</script>

<?= $this->endSection() ?>
