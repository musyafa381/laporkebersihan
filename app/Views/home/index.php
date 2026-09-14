<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- ADVANCED VIBRANT EMERALD INTERACTIVE BENTO GRID STYLES -->
<style>
    /* Root Scope & Font Tweaks */
    .outreach-universe {
        position: relative;
        isolation: isolate;
        color: #f0fdf4;
    }

    /* Ambient Fullscreen Starfield & Mesh Canvas */
    #outreachCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        pointer-events: none;
        z-index: 0;
        opacity: 0.92;
    }

    /* Interactive Mouse Spotlight Follower */
    #cursorLightSpotlight {
        position: fixed;
        width: 700px;
        height: 700px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(52, 211, 153, 0.2) 0%, rgba(16, 185, 129, 0.08) 40%, transparent 70%);
        pointer-events: none;
        z-index: 1;
        transform: translate(-50%, -50%);
        transition: opacity 0.3s ease;
        will-change: left, top;
        opacity: 0;
    }

    /* Bento Card Master Base - Rich Vivid Emerald Glassmorphism */
    .bento-card {
        position: relative;
        background: linear-gradient(145deg, rgba(6, 95, 70, 0.90) 0%, rgba(4, 78, 59, 0.93) 50%, rgba(15, 118, 110, 0.88) 100%);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(110, 231, 183, 0.35);
        border-radius: 28px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                    border-color 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                    box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform;
        box-shadow: 0 20px 45px -10px rgba(6, 95, 70, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.2);
    }
    
    /* Interactive Mouse Border Highlight Effect (Emerald Glow Trail) */
    .bento-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 28px;
        padding: 1.5px;
        background: radial-gradient(400px circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(167, 243, 208, 0.95), rgba(52, 211, 153, 0.5), transparent 70%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .bento-card:hover::before {
        opacity: 1;
    }
    .bento-card:hover {
        transform: translateY(-4px) scale(1.006);
        box-shadow: 0 25px 50px -12px rgba(6, 95, 70, 0.5), 0 0 45px rgba(52, 211, 153, 0.3);
        border-color: rgba(167, 243, 208, 0.65);
    }

    /* Scroll Reveal & Kinetic Engine */
    .scroll-reveal {
        opacity: 1;
        transform: translateY(0);
        filter: none;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bento-card {
        animation: bentoSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    @keyframes bentoSlideUp {
        from {
            opacity: 0.7;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Infinite Marquee Animation */
    @keyframes marqueeScroll {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }
    .marquee-track {
        display: flex;
        width: max-content;
        animation: marqueeScroll 28s linear infinite;
    }
    .marquee-track:hover {
        animation-play-state: paused;
    }

    /* Holographic Radar Pulse Animation */
    @keyframes radarPulse {
        0% { transform: scale(0.6); opacity: 1; }
        100% { transform: scale(2.4); opacity: 0; }
    }
    .radar-pulse-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 1.5px solid #6ee7b7;
        animation: radarPulse 2.8s cubic-bezier(0.2, 0.8, 0.2, 1) infinite;
    }

    /* Shimmering Cosmic Text Gradient */
    .cosmic-gradient-text {
        background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 35%, #6ee7b7 70%, #fef08a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: cosmicShimmer 7s linear infinite;
    }
    @keyframes cosmicShimmer {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Orbit Rotate Animation */
    @keyframes orbitSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-orbit {
        animation: orbitSpin 35s linear infinite;
    }
    .animate-orbit-reverse {
        animation: orbitSpin 25s linear infinite reverse;
    }
</style>

<!-- BACKGROUND CANVAS PARTICLES -->
<canvas id="outreachCanvas"></canvas>
<div id="cursorLightSpotlight"></div>

<div class="outreach-universe max-w-5xl mx-auto space-y-6 sm:space-y-8 py-4 sm:py-8 px-3 sm:px-4 relative z-10">

    <!-- 1. HERO SECTION (Cinematic Galactic Portal in Vivid Emerald) -->
    <div class="bento-card scroll-reveal p-6 sm:p-12 text-center relative overflow-hidden bg-gradient-to-br from-emerald-900/95 via-emerald-800/90 to-teal-900/95 border-emerald-400/50 shadow-[0_25px_60px_-15px_rgba(5,150,105,0.4)]">
        <!-- Floating Orbital Concentric Rings in Hero Background -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[580px] h-[580px] rounded-full border border-emerald-300/25 pointer-events-none animate-orbit">
            <div class="absolute top-8 left-12 w-3.5 h-3.5 rounded-full bg-emerald-300 blur-[1px] shadow-[0_0_15px_#6ee7b7]"></div>
            <div class="absolute bottom-16 right-20 w-2.5 h-2.5 rounded-full bg-teal-200 blur-[1px] shadow-[0_0_12px_#99f6e4]"></div>
        </div>
        <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-[380px] h-[380px] rounded-full border border-teal-300/20 pointer-events-none animate-orbit-reverse"></div>
        <div class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-[480px] h-48 bg-emerald-400/25 rounded-full blur-[90px] pointer-events-none"></div>

        <div class="relative z-10 space-y-5 sm:space-y-6 max-w-3xl mx-auto">
            <!-- Top Status Pill -->
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-emerald-950/60 border border-emerald-300/50 text-emerald-200 text-[11px] sm:text-xs font-extrabold uppercase tracking-widest shadow-[0_0_25px_rgba(52,211,153,0.25)] backdrop-blur-md">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
                </span>
                <span>DIVISI KEBERSIHAN &bull; YAYASAN ASSALAFIYYAH</span>
            </div>

            <!-- Big Cinematic Title -->
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-heading font-black tracking-tight leading-[1.12] text-white drop-shadow-md">
                Website Terpadu <br class="hidden sm:inline">
                <span class="cosmic-gradient-text">Pengaduan & Kebersihan</span><br>
                <span class="text-emerald-100 text-2xl sm:text-4xl font-extrabold">Assalafiyyah Mlangi</span>
            </h1>

            <?php
                $csNum = !empty($hotlineWa) ? $hotlineWa : '0895320276800';
                $cleanCsNum = preg_replace('/[^0-9]/', '', $csNum);
                if (substr($cleanCsNum, 0, 1) === '0') $cleanCsNum = '62' . substr($cleanCsNum, 1);
                elseif (substr($cleanCsNum, 0, 2) !== '62') $cleanCsNum = '62' . $cleanCsNum;
                $csUrl = "https://wa.me/" . $cleanCsNum . "?text=" . urlencode("Assalamu'alaikum Admin Kebersihan Assalafiyyah, saya ingin menyampaikan laporan/pertanyaan.");
            ?>

            <p class="text-xs sm:text-base text-emerald-50 font-medium leading-relaxed max-w-2xl mx-auto">
                Portal respon cepat pengaduan sarana santri, pengelolaan logistik peralatan, pemetaan wilayah kompleks, dan transparansi LPJ bulanan.
            </p>

            <!-- Hero Action Buttons -->
            <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                <a href="<?= base_url('cs') ?>" class="group px-7 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-300 via-teal-200 to-emerald-300 text-emerald-950 font-heading font-black text-xs sm:text-sm shadow-[0_0_30px_rgba(52,211,153,0.45)] hover:shadow-[0_0_45px_rgba(52,211,153,0.65)] hover:scale-105 active:scale-95 transition-all duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-emerald-950 group-hover:translate-x-1 transition-transform"></i>
                    <span>Lapor Pengaduan (CS)</span>
                </a>

                <a href="<?= $csUrl ?>" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 rounded-2xl bg-emerald-950/50 hover:bg-emerald-900/70 border border-emerald-300/40 text-emerald-100 font-heading font-bold text-xs sm:text-sm hover:border-emerald-200 hover:scale-105 active:scale-95 transition-all duration-300 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-brands fa-whatsapp text-emerald-300 text-base"></i>
                    <span>Hotline: <?= esc($csNum) ?></span>
                </a>
            </div>
        </div>

        <!-- Animated Running Ticker in Emerald -->
        <div class="mt-8 pt-6 border-t border-emerald-400/25 overflow-hidden relative">
            <div class="marquee-track flex items-center gap-8 text-[11px] sm:text-xs font-extrabold uppercase tracking-wider text-emerald-100/90">
                <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-emerald-300"></i> RESPON CEPAT PENGADUAN</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-teal-200"></i> LINGKUNGAN ASRI & SUCI</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-people-carry-box text-emerald-200"></i> KADER KEBERSIHAN AKTIF</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-file-invoice text-amber-300"></i> TRANSPARANSI LPJ REAL-TIME</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-emerald-300"></i> RESPON CEPAT PENGADUAN</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-teal-200"></i> LINGKUNGAN ASRI & SUCI</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-people-carry-box text-emerald-200"></i> KADER KEBERSIHAN AKTIF</span>
                <span class="text-emerald-300/40">&bull;</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-file-invoice text-amber-300"></i> TRANSPARANSI LPJ REAL-TIME</span>
            </div>
        </div>
    </div>

    <!-- 2. BENTO GRID ARCHITECTURE (Ultra-Interactive Feature Modules in Emerald) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">

        <!-- BENTO CARD 1 (Large 2 Cols): INTERACTIVE CS WORKFLOW SIMULATOR -->
        <div class="bento-card scroll-reveal md:col-span-2 p-6 sm:p-8 flex flex-col justify-between space-y-6">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/25 border border-emerald-300/40 text-emerald-200 text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md">
                        <i class="fa-solid fa-wand-magic-sparkles text-emerald-300"></i>
                        <span>Alur Pelayanan Kebersihan</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-white">
                        Sistem Penanganan Lapor Cepat CS
                    </h3>
                    <p class="text-xs sm:text-sm text-emerald-100/90">
                        Klik tahapan di bawah untuk mensimulasikan proses penanganan dari awal pengaduan hingga tuntas.
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/30 text-emerald-200 flex items-center justify-center text-xl flex-shrink-0 border border-emerald-300/40 shadow-[0_0_20px_rgba(52,211,153,0.3)]">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>

            <!-- Interactive Step Progress Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-2">
                <!-- Step 1 -->
                <button type="button" onclick="setWorkflowStep(1)" id="flowBtn-1" class="workflow-btn text-left p-3.5 rounded-2xl bg-emerald-300 text-emerald-950 font-extrabold border border-emerald-200 transition-all duration-300 shadow-md">
                    <div class="text-[10px] font-mono font-bold text-emerald-900">01. LAPOR</div>
                    <div class="text-xs font-extrabold mt-0.5">Input Form CS</div>
                </button>
                <!-- Step 2 -->
                <button type="button" onclick="setWorkflowStep(2)" id="flowBtn-2" class="workflow-btn text-left p-3.5 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 text-emerald-100/90 hover:text-white hover:border-emerald-300 hover:bg-emerald-800/70 transition-all duration-300 backdrop-blur-md">
                    <div class="text-[10px] font-mono font-bold text-emerald-300/80">02. DISPOSISI</div>
                    <div class="text-xs font-extrabold mt-0.5">Verifikasi Admin</div>
                </button>
                <!-- Step 3 -->
                <button type="button" onclick="setWorkflowStep(3)" id="flowBtn-3" class="workflow-btn text-left p-3.5 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 text-emerald-100/90 hover:text-white hover:border-emerald-300 hover:bg-emerald-800/70 transition-all duration-300 backdrop-blur-md">
                    <div class="text-[10px] font-mono font-bold text-emerald-300/80">03. EKSEKUSI</div>
                    <div class="text-xs font-extrabold mt-0.5">Tim Bertindak</div>
                </button>
                <!-- Step 4 -->
                <button type="button" onclick="setWorkflowStep(4)" id="flowBtn-4" class="workflow-btn text-left p-3.5 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 text-emerald-100/90 hover:text-white hover:border-emerald-300 hover:bg-emerald-800/70 transition-all duration-300 backdrop-blur-md">
                    <div class="text-[10px] font-mono font-bold text-emerald-300/80">04. TUNTAS</div>
                    <div class="text-xs font-extrabold mt-0.5">Konfirmasi Selesai</div>
                </button>
            </div>

            <!-- Step Description Box -->
            <div id="workflowDetailBox" class="p-4 rounded-2xl bg-emerald-950/60 border border-emerald-400/40 text-xs sm:text-sm text-emerald-50 flex items-center justify-between gap-4 backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <div id="workflowIcon" class="w-8 h-8 rounded-xl bg-emerald-400/30 text-emerald-200 flex items-center justify-center flex-shrink-0 text-sm border border-emerald-400/40">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div id="workflowText" class="font-medium">
                        Santri / Civitas mengisi form kendala sarana / sampah secara instan dan mengunggah bukti foto.
                    </div>
                </div>
                <a href="<?= base_url('cs') ?>" class="px-4 py-2 rounded-xl bg-emerald-300 hover:bg-emerald-200 text-emerald-950 font-heading font-extrabold text-xs whitespace-nowrap transition-all shadow-md">
                    Buka Form CS &rarr;
                </a>
            </div>
        </div>

        <!-- BENTO CARD 2: LIVE STATS RADAR -->
        <div class="bento-card scroll-reveal p-6 sm:p-7 flex flex-col justify-between space-y-5 bg-gradient-to-br from-emerald-900/95 via-teal-900/90 to-emerald-800/95">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-1.5 text-[10px] font-mono font-bold text-emerald-300 uppercase tracking-widest">
                    <i class="fa-solid fa-chart-simple"></i> METRIK REAL-TIME
                </div>
                <h4 class="text-lg font-heading font-extrabold text-white">Monitoring Operasional</h4>
            </div>

            <div class="space-y-3">
                <!-- Stat Item 1 -->
                <div class="p-3 rounded-2xl bg-emerald-950/50 border border-emerald-400/30 flex items-center justify-between backdrop-blur-md">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-400/30 text-emerald-200 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-mosque"></i>
                        </div>
                        <span class="text-xs font-bold text-emerald-100">Unit Terjangkau</span>
                    </div>
                    <span class="text-lg font-heading font-black text-emerald-300 count-up-val" data-target="<?= $totalUnit ?? 0 ?>"><?= number_format($totalUnit ?? 0, 0, ',', '.') ?></span>
                </div>

                <!-- Stat Item 2 -->
                <div class="p-3 rounded-2xl bg-emerald-950/50 border border-emerald-400/30 flex items-center justify-between backdrop-blur-md">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-teal-400/30 text-teal-200 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span class="text-xs font-bold text-emerald-100">Total Pengaduan</span>
                    </div>
                    <span class="text-lg font-heading font-black text-teal-200 count-up-val" data-target="<?= $totalCs ?? 0 ?>"><?= number_format($totalCs ?? 0, 0, ',', '.') ?></span>
                </div>

                <!-- Stat Item 3 -->
                <div class="p-3 rounded-2xl bg-emerald-950/50 border border-emerald-400/30 flex items-center justify-between backdrop-blur-md">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-amber-400/30 text-amber-200 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <span class="text-xs font-bold text-emerald-100">Item Alat Gudang</span>
                    </div>
                    <span class="text-lg font-heading font-black text-amber-300 count-up-val" data-target="<?= $totalAlat ?? 0 ?>"><?= number_format($totalAlat ?? 0, 0, ',', '.') ?></span>
                </div>
            </div>

            <div class="text-[11px] text-emerald-100/80 text-center font-medium">
                Data sinkron otomatis dengan server kebersihan.
            </div>
        </div>

        <!-- BENTO CARD 3: INTERACTIVE REGIONAL COMPLEX RADAR (PETA ZONA) -->
        <div class="bento-card scroll-reveal p-6 sm:p-7 flex flex-col justify-between space-y-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-1.5 text-[10px] font-mono font-bold text-emerald-300 uppercase tracking-widest">
                    <i class="fa-solid fa-satellite-dish"></i> ZONA PELAYANAN
                </div>
                <h4 class="text-lg font-heading font-extrabold text-white">Seluruh Civitas</h4>
            </div>

            <!-- Radar Visual Node Animation -->
            <div class="relative h-36 w-full rounded-2xl bg-emerald-950/60 border border-emerald-400/40 flex items-center justify-center overflow-hidden backdrop-blur-md">
                <div class="radar-pulse-ring"></div>
                <div class="w-20 h-20 rounded-full border border-emerald-300/40"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-300 shadow-[0_0_14px_#6ee7b7] z-10"></div>

                <!-- Floating Interactive Node Chips -->
                <div class="absolute top-3 left-4 px-2.5 py-1 rounded-full bg-emerald-800/90 border border-emerald-300/50 text-[9.5px] font-bold text-emerald-100 shadow-md">
                    Asrama Santri
                </div>
                <div class="absolute bottom-3 right-4 px-2.5 py-1 rounded-full bg-teal-800/90 border border-teal-300/50 text-[9.5px] font-bold text-teal-100 shadow-md">
                    Madrasah
                </div>
                <div class="absolute top-4 right-5 px-2.5 py-1 rounded-full bg-emerald-700/90 border border-emerald-200/60 text-[9.5px] font-bold text-emerald-50 shadow-md">
                    Perkantoran
                </div>
                <div class="absolute bottom-4 left-5 px-2.5 py-1 rounded-full bg-teal-700/90 border border-teal-200/60 text-[9.5px] font-bold text-teal-50 shadow-md">
                    Hunian Lain
                </div>
            </div>

            <p class="text-xs text-emerald-100/90 leading-relaxed font-medium">
                Pembersihan terjadwal rutin di seluruh unit asrama, lingkungan santri, dan sarana ibadah.
            </p>
        </div>

        <!-- BENTO CARD 4 (2 Cols): LOGISTIK & REALISASI PERALATAN (DARI DATABASE KATEGORI ALAT) -->
        <?php
            if (!function_exists('getKategoriIconHome')) {
                function getKategoriIconHome($nama) {
                    $n = strtolower((string)$nama);
                    if (strpos($n, 'sapu') !== false || strpos($n, 'pel') !== false) return 'fa-broom';
                    if (strpos($n, 'sampah') !== false || strpos($n, 'wadah') !== false || strpos($n, 'tong') !== false) return 'fa-trash-can';
                    if (strpos($n, 'cairan') !== false || strpos($n, 'kimia') !== false || strpos($n, 'sabun') !== false || strpos($n, 'karbol') !== false) return 'fa-spray-can-sparkles';
                    if (strpos($n, 'mesin') !== false || strpos($n, 'berat') !== false) return 'fa-gears';
                    return 'fa-boxes-stacked';
                }
            }

            $rawCategories = !empty($kategoriAlatList) ? $kategoriAlatList : [
                ['id' => 1, 'nama_kategori' => 'Sapu & Pel', 'keterangan' => 'Alat pembersih lantai, sapu, pel, kemoceng, serok'],
                ['id' => 2, 'nama_kategori' => 'Wadah Sampah', 'keterangan' => 'Tong sampah, tempat sampah pilah, polybag, kontainer'],
                ['id' => 3, 'nama_kategori' => 'Cairan & Bahan Kimia', 'keterangan' => 'Sabun pel, karbol, pembersih kaca, deterjen, disinfektan'],
                ['id' => 4, 'nama_kategori' => 'Mesin & Alat Berat', 'keterangan' => 'Mesin rumput, vacuum cleaner, floor polisher, pressure washer'],
                ['id' => 5, 'nama_kategori' => 'Lainnya', 'keterangan' => 'Perlengkapan APD kebersihan, sarung tangan, masker, sikat, dsb.'],
            ];

            $firstKat = $rawCategories[0] ?? ['id' => 1, 'nama_kategori' => 'Kategori Alat', 'keterangan' => 'Inventaris logistik kebersihan pesantren.'];
            $firstIcon = getKategoriIconHome($firstKat['nama_kategori'] ?? '');
        ?>
        <div class="bento-card scroll-reveal md:col-span-2 p-6 sm:p-8 flex flex-col justify-between space-y-5 bg-gradient-to-br from-emerald-900/95 via-teal-900/90 to-emerald-800/95">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 text-[10px] font-mono font-bold text-emerald-300 uppercase tracking-widest">
                        <i class="fa-solid fa-box-open"></i> KATEGORI ALAT & LOGISTIK
                    </div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-white">
                        Manajemen Peralatan & Pengajuan Barang
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-400/30 text-emerald-200 flex items-center justify-center text-lg flex-shrink-0 border border-emerald-300/40">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
            </div>

            <!-- Dynamic Tool Filter Chips from Database -->
            <div class="space-y-3">
                <div class="flex flex-wrap gap-2 text-xs font-bold">
                    <?php foreach ($rawCategories as $index => $kat): ?>
                        <?php 
                            $isActive = ($index === 0);
                            $btnClass = $isActive 
                                ? 'tool-preview-tab px-3.5 py-1.5 rounded-xl bg-emerald-300 text-emerald-950 font-extrabold shadow-md'
                                : 'tool-preview-tab px-3.5 py-1.5 rounded-xl bg-emerald-950/50 text-emerald-100 hover:text-white border border-emerald-400/30 backdrop-blur-md';
                        ?>
                        <button type="button" 
                                onclick="filterToolPreview(<?= (int)$kat['id'] ?>)" 
                                id="toolTab-<?= (int)$kat['id'] ?>" 
                                class="<?= $btnClass ?>">
                            <?= esc($kat['nama_kategori']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div id="toolPreviewContent" class="p-4 rounded-2xl bg-emerald-950/60 border border-emerald-400/40 flex items-center justify-between text-xs sm:text-sm backdrop-blur-md">
                    <div class="flex items-center gap-3">
                        <div id="toolIconBox" class="w-8 h-8 rounded-lg bg-emerald-400/30 text-emerald-200 flex items-center justify-center font-bold border border-emerald-400/30">
                            <i id="toolIcon" class="fa-solid <?= $firstIcon ?>"></i>
                        </div>
                        <div>
                            <div id="toolTitle" class="font-extrabold text-white"><?= esc($firstKat['nama_kategori']) ?></div>
                            <div id="toolDesc" class="text-xs text-emerald-100 font-medium"><?= esc(!empty($firstKat['keterangan']) ? $firstKat['keterangan'] : 'Stok logistik tersedia untuk kebutuhan pesantren.') ?></div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-emerald-400/30 text-emerald-100 font-mono font-bold text-xs border border-emerald-300/40 whitespace-nowrap">
                        Kategori Terdaftar
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-1 text-xs">
                <span class="text-emerald-100 font-medium">Pengurus unit dapat mengajukan permintaan alat kapan saja.</span>
                <a href="<?= base_url('cs') ?>" class="text-emerald-300 hover:text-emerald-200 font-bold inline-flex items-center gap-1 hover:underline">
                    Ajukan Alat &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- 3. KUTIPAN HIKMAH (Interactive Specular Card in Vivid Emerald) -->
    <div class="bento-card scroll-reveal p-7 sm:p-11 text-center relative overflow-hidden bg-gradient-to-br from-emerald-900/95 via-teal-900/90 to-emerald-800/95 border-emerald-400/50 shadow-[0_20px_50px_rgba(5,150,105,0.3)]">
        <div class="relative z-10 space-y-4 max-w-2xl mx-auto">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-300 to-teal-200 text-emerald-950 flex items-center justify-center text-2xl mx-auto shadow-[0_0_30px_rgba(52,211,153,0.45)]">
                <i class="fa-solid fa-quote-left"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-heading font-black text-white tracking-tight">
                "Kebersihan Adalah Sebagian Dari Iman"
            </h2>
            <p class="text-xs sm:text-base text-emerald-50 font-medium italic leading-relaxed">
                « Mencegah kekotoran, merawat kerapian sarana ibadah & asrama santri, serta menjaga lingkungan pesantren agar senantiasa bersih, suci, dan nyaman untuk menuntut ilmu agama. »
            </p>
        </div>
    </div>

    <!-- 4. BOTTOM ACTION BANNER (Glowing Aurora Light Sweep) -->
    <div class="bento-card scroll-reveal p-7 sm:p-10 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-6 shadow-[0_20px_50px_rgba(5,150,105,0.45)] border-emerald-300/50">
        <div class="space-y-2 relative z-10 max-w-xl">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider border border-white/30">
                <i class="fa-solid fa-paper-plane text-[9px]"></i> Layanan Responsif Santri
            </div>
            <h3 class="font-heading font-black text-xl sm:text-2xl text-white">
                Menemukan Kendala Kebersihan Hari Ini?
            </h3>
            <p class="text-xs sm:text-sm text-emerald-50 font-medium leading-relaxed">
                Laporkan secara langsung kepada Tim Customer Service K3L Yayasan Assalafiyyah untuk penanganan tuntas.
            </p>
        </div>

        <a href="<?= base_url('cs') ?>" class="relative z-10 px-8 py-4 rounded-2xl bg-white text-emerald-950 font-heading font-black text-xs sm:text-sm hover:bg-emerald-50 hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300 shadow-xl flex items-center justify-center gap-2 flex-shrink-0">
            <i class="fa-solid fa-paper-plane text-emerald-600"></i>
            <span>Buka Form Pengaduan</span>
        </a>
    </div>

</div>

<!-- ADVANCED INTERACTIVE SCRIPTS -->
<script>
(function() {
    function initHomePage() {
        // 1. REVEAL ELEMENTS IMMEDIATELY & SETUP OBSERVER
        const revealElements = document.querySelectorAll('.scroll-reveal');
        
        function checkAndReveal() {
            const vh = window.innerHeight || document.documentElement.clientHeight;
            revealElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top <= vh - 20) {
                    el.classList.add('active-revealed');
                    const counters = el.querySelectorAll('.count-up-val');
                    counters.forEach(c => {
                        if (!c.dataset.done) {
                            c.dataset.done = "true";
                            runCounter(c);
                        }
                    });
                }
            });
        }

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active-revealed');
                        const counters = entry.target.querySelectorAll('.count-up-val');
                        counters.forEach(c => {
                            if (!c.dataset.done) {
                                c.dataset.done = "true";
                                runCounter(c);
                            }
                        });
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.05, rootMargin: '0px 0px -20px 0px' });

            revealElements.forEach(el => observer.observe(el));
        }

        // Run immediate check so visible cards appear without delay on SPA navigation
        checkAndReveal();
        setTimeout(checkAndReveal, 100);

        // 2. STARFIELD & COSMIC CANVAS ENGINE
        if (window.homeCanvasAnimId) {
            cancelAnimationFrame(window.homeCanvasAnimId);
            window.homeCanvasAnimId = null;
        }

        const canvas = document.getElementById('outreachCanvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let width = canvas.width = window.innerWidth;
            let height = canvas.height = window.innerHeight;
            let mouse = { x: width / 2, y: height / 2, active: false };

            const handleResize = () => {
                if (!document.getElementById('outreachCanvas')) return;
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            };
            window.removeEventListener('resize', handleResize);
            window.addEventListener('resize', handleResize);

            const handleMouseMove = (e) => {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
                mouse.active = true;

                const spotlight = document.getElementById('cursorLightSpotlight');
                if (spotlight) {
                    spotlight.style.opacity = '1';
                    spotlight.style.left = e.clientX + 'px';
                    spotlight.style.top = e.clientY + 'px';
                }

                document.querySelectorAll('.bento-card').forEach(card => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    card.style.setProperty('--mouse-x', `${x}px`);
                    card.style.setProperty('--mouse-y', `${y}px`);
                });
            };

            const handleMouseLeave = () => {
                mouse.active = false;
                const spotlight = document.getElementById('cursorLightSpotlight');
                if (spotlight) spotlight.style.opacity = '0';
            };

            window.removeEventListener('mousemove', handleMouseMove);
            window.addEventListener('mousemove', handleMouseMove);
            window.removeEventListener('mouseleave', handleMouseLeave);
            window.addEventListener('mouseleave', handleMouseLeave);

            const count = Math.min(75, Math.floor(window.innerWidth / 18));
            const particles = [];
            const colors = ['rgba(110, 231, 183, 0.65)', 'rgba(52, 211, 153, 0.6)', 'rgba(253, 224, 71, 0.5)', 'rgba(255, 255, 255, 0.55)'];

            for (let i = 0; i < count; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 0.35,
                    vy: (Math.random() - 0.5) * 0.35,
                    radius: Math.random() * 2 + 0.8,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    pulse: Math.random() * Math.PI,
                });
            }

            function drawParticles() {
                if (!document.getElementById('outreachCanvas')) return;
                ctx.clearRect(0, 0, width, height);

                particles.forEach((p, idx) => {
                    p.x += p.vx;
                    p.y += p.vy;
                    p.pulse += 0.025;

                    if (p.x < 0) p.x = width;
                    if (p.x > width) p.x = 0;
                    if (p.y < 0) p.y = height;
                    if (p.y > height) p.y = 0;

                    if (mouse.active) {
                        const dx = mouse.x - p.x;
                        const dy = mouse.y - p.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 130) {
                            const angle = Math.atan2(dy, dx);
                            p.x -= Math.cos(angle) * 1.8;
                            p.y -= Math.sin(angle) * 1.8;
                        }
                    }

                    const rad = p.radius + Math.sin(p.pulse) * 0.6;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, Math.max(0.6, rad), 0, Math.PI * 2);
                    ctx.fillStyle = p.color;
                    ctx.fill();

                    for (let j = idx + 1; j < particles.length; j++) {
                        const p2 = particles[j];
                        const dx = p.x - p2.x;
                        const dy = p.y - p2.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);

                        if (dist < 115) {
                            ctx.beginPath();
                            ctx.strokeStyle = `rgba(110, 231, 183, ${0.22 * (1 - dist / 115)})`;
                            ctx.lineWidth = 0.75;
                            ctx.moveTo(p.x, p.y);
                            ctx.lineTo(p2.x, p2.y);
                            ctx.stroke();
                        }
                    }
                });

                window.homeCanvasAnimId = requestAnimationFrame(drawParticles);
            }
            drawParticles();
        }

        // 3. STATS COUNT UP
        function runCounter(el) {
            const target = parseInt(el.dataset.target) || 0;
            if (target === 0) {
                el.textContent = "0";
                return;
            }
            const duration = 1400;
            const totalFrames = 60;
            let frame = 0;

            const interval = setInterval(() => {
                frame++;
                const progress = frame / totalFrames;
                const easeOut = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(easeOut * target).toLocaleString('id-ID');

                if (frame >= totalFrames) {
                    el.textContent = target.toLocaleString('id-ID');
                    clearInterval(interval);
                }
            }, duration / totalFrames);
        }
    }

    // 4. INTERACTIVE WORKFLOW STEP SIMULATOR
    const workflowData = {
        1: {
            icon: '<i class="fa-solid fa-pen-to-square"></i>',
            text: 'Santri / Civitas mengisi form kendala kebersihan atau sarana rusak secara instan dan mengunggah foto lokasi.'
        },
        2: {
            icon: '<i class="fa-solid fa-shield-halved"></i>',
            text: 'Admin kebersihan menerima notifikasi seketika dan melakukan verifikasi urgensi serta penugasan zona wilayah.'
        },
        3: {
            icon: '<i class="fa-solid fa-truck-fast"></i>',
            text: 'Petugas kebersihan / kader kebersihan bergerak ke lokasi untuk melakukan pembersihan atau perbaikan.'
        },
        4: {
            icon: '<i class="fa-solid fa-circle-check"></i>',
            text: 'Laporan ditandai tuntas, bukti penanganan diarsipkan transparan di sistem untuk evaluasi LPJ bulanan.'
        }
    };

    window.setWorkflowStep = function(step) {
        for (let i = 1; i <= 4; i++) {
            const btn = document.getElementById('flowBtn-' + i);
            if (btn) {
                if (i === step) {
                    btn.className = "workflow-btn text-left p-3.5 rounded-2xl bg-emerald-300 text-emerald-950 font-extrabold border border-emerald-200 transition-all duration-300 shadow-md";
                    btn.querySelector('div:first-child').className = "text-[10px] font-mono font-bold text-emerald-900";
                } else {
                    btn.className = "workflow-btn text-left p-3.5 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 text-emerald-100/90 hover:text-white hover:border-emerald-300 hover:bg-emerald-800/70 transition-all duration-300 backdrop-blur-md";
                    btn.querySelector('div:first-child').className = "text-[10px] font-mono font-bold text-emerald-300/80";
                }
            }
        }

        const data = workflowData[step] || workflowData[1];
        const iconEl = document.getElementById('workflowIcon');
        const textEl = document.getElementById('workflowText');
        if (iconEl) iconEl.innerHTML = data.icon;
        if (textEl) textEl.textContent = data.text;
    };

    // 5. INTERACTIVE TOOL PREVIEW TABS (DARI DATABASE KATEGORI ALAT)
    <?php
        $jsKatData = [];
        foreach ($rawCategories as $k) {
            $jsKatData[$k['id']] = [
                'title' => $k['nama_kategori'],
                'desc'  => !empty($k['keterangan']) ? $k['keterangan'] : 'Stok logistik tersedia untuk kebutuhan pesantren.',
                'icon'  => getKategoriIconHome($k['nama_kategori']),
            ];
        }
    ?>
    const toolData = <?= json_encode($jsKatData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

    window.filterToolPreview = function(key) {
        document.querySelectorAll('.tool-preview-tab').forEach(tab => {
            tab.className = "tool-preview-tab px-3.5 py-1.5 rounded-xl bg-emerald-950/50 text-emerald-100 hover:text-white border border-emerald-400/30 backdrop-blur-md";
        });
        const activeTab = document.getElementById('toolTab-' + key);
        if (activeTab) {
            activeTab.className = "tool-preview-tab px-3.5 py-1.5 rounded-xl bg-emerald-300 text-emerald-950 font-extrabold shadow-md";
        }

        const data = toolData[key] || Object.values(toolData)[0] || { title: 'Kategori Alat', desc: '', icon: 'fa-boxes-stacked' };
        const titleEl = document.getElementById('toolTitle');
        const descEl = document.getElementById('toolDesc');
        const iconEl = document.getElementById('toolIcon');
        if (titleEl) titleEl.textContent = data.title;
        if (descEl) descEl.textContent = data.desc;
        if (iconEl && data.icon) {
            iconEl.className = 'fa-solid ' + data.icon;
        }
    };

    // Register hook for layout SPA navigation
    window.rebindPageEvents = initHomePage;

    // Run immediately when script is injected or DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHomePage);
    } else {
        initHomePage();
    }
})();
</script>
<?= $this->endSection() ?>

