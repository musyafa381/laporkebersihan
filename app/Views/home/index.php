<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6 sm:space-y-10 py-2 sm:py-6 relative z-10">
    <!-- HERO SECTION: Ucapan Selamat Datang Utama (Rich Emerald Glass Theme) -->
    <div class="relative overflow-hidden rounded-[32px] p-7 sm:p-14 shadow-[0_20px_50px_rgba(6,78,59,0.22)] border border-white/25 bg-gradient-to-br from-emerald-950/95 via-teal-900/90 to-slate-950/95 backdrop-blur-2xl text-white text-center space-y-5 sm:space-y-6">
        <!-- Soft Balanced Ambient Background Glows -->
        <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-emerald-400/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-24 -top-24 w-96 h-96 bg-teal-400/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-3 sm:space-y-4">
            <div class="flex flex-wrap items-center justify-center gap-2">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-extrabold uppercase tracking-wider border border-white/20 shadow-sm">
                    <i class="fa-solid fa-leaf text-emerald-400"></i>
                    <span class="text-white">KEBERSIHAN ASSALAFIYYAH</span>
                </div>

                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Sapaan Personal Akun Login -->
                    <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-md text-emerald-100 text-[11px] sm:text-xs font-bold border border-white/20 shadow-sm">
                        <span class="w-2 h-2 rounded-full <?= session()->get('role') === 'Admin' ? 'bg-emerald-400 animate-pulse' : (session()->get('role') === 'Auditor' ? 'bg-blue-400 animate-pulse' : 'bg-purple-400') ?>"></span>
                        <span class="truncate max-w-[150px] sm:max-w-none">Ahlan, <strong class="text-white font-extrabold"><?= esc(session()->get('nama_lengkap')) ?></strong></span>
                        <span class="text-[9.5px] sm:text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider <?= session()->get('role') === 'Admin' ? 'bg-emerald-400/30 text-emerald-100 border border-emerald-300/40' : (session()->get('role') === 'Auditor' ? 'bg-blue-400/30 text-blue-100 border border-blue-300/40' : 'bg-purple-400/30 text-purple-100 border border-purple-300/40') ?>">
                            <?= esc(session()->get('role')) ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <h1 class="text-2xl sm:text-4xl md:text-5xl font-heading font-black tracking-tight leading-tight text-white drop-shadow-md">
                Selamat Datang di Website <br>
                <span class="bg-gradient-to-r from-emerald-300 via-teal-200 to-green-300 bg-clip-text text-transparent">Lapor Kebersihan</span><br>
                Pondok Pesantren Assalafiyyah
            </h1>

            <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto px-2 sm:px-0 drop-shadow-xs">
                Wadah layanan pengaduan kebersihan, pemeliharaan lingkungan yang asri, serta transparansi gerakan kebersihan bersama seluruh santri & pengurus Kebersihan.
            </p>
        </div>
    </div>

    <!-- KATA-KATA KUTIPAN HIKMAH KEBERSIHAN (Frosted Glass Card) -->
    <div class="glass-card rounded-[32px] p-7 sm:p-11 shadow-[0_12px_40px_rgba(0,0,0,0.06)] border border-white/80 bg-white/75 backdrop-blur-2xl space-y-6 sm:space-y-8 text-center relative overflow-hidden">
        <!-- Subtle Top Glow Arc -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-28 bg-emerald-400/15 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 space-y-4 max-w-2xl mx-auto">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-2xl mx-auto shadow-md shadow-emerald-600/20 ring-4 ring-emerald-100/80">
                <i class="fa-solid fa-quote-left"></i>
            </div>

            <h2 class="font-heading font-black text-xl sm:text-3xl text-slate-900 tracking-tight">
                "Kebersihan Adalah Sebagian Dari Iman"
            </h2>
            <p class="text-xs sm:text-base text-slate-600 font-semibold italic leading-relaxed">
                « Mencegah kekotoran, merawat kerapian sarana ibadah & asrama santri, serta menjaga lingkungan pesantren agar senantiasa bersih, suci, dan nyaman untuk menuntut ilmu agama. »
            </p>
        </div>

        <!-- 3 Feature Highlight Cards (Frosted Glass Grid) -->
        <div class="pt-2 grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 text-left relative z-10">
            <!-- Card 1: Lingkungan Asri & Suci -->
            <div class="group relative overflow-hidden p-5 sm:p-6 rounded-3xl bg-white/70 hover:bg-white/95 backdrop-blur-xl border border-emerald-100/90 hover:border-emerald-300/80 shadow-xs hover:shadow-xl hover:shadow-emerald-900/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-start">
                <div class="space-y-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-600/25 ring-2 ring-emerald-100 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-broom-ball"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h4 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-emerald-700 transition-colors">
                            Lingkungan Asri & Suci
                        </h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Menjaga kompleks pesantren bebas dari sampah dan kotoran demi kenyamanan ibadah & tholabul 'ilmi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Gotong Royong Santri -->
            <div class="group relative overflow-hidden p-5 sm:p-6 rounded-3xl bg-white/70 hover:bg-white/95 backdrop-blur-xl border border-teal-100/90 hover:border-teal-300/80 shadow-xs hover:shadow-xl hover:shadow-teal-900/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-start">
                <div class="space-y-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-teal-600 to-cyan-500 text-white flex items-center justify-center text-xl shadow-md shadow-teal-600/25 ring-2 ring-teal-100 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-hands-holding-circle"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h4 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-teal-700 transition-colors">
                            Gotong Royong Santri
                        </h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Kebersihan adalah tanggung jawab bersama seluruh kader GEMERLAP, santri, dan pengurus K3L.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Layanan Lapor Cepat (CS) -->
            <div class="group relative overflow-hidden p-5 sm:p-6 rounded-3xl bg-white/70 hover:bg-white/95 backdrop-blur-xl border border-sky-100/90 hover:border-sky-300/80 shadow-xs hover:shadow-xl hover:shadow-sky-900/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-start">
                <div class="space-y-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-600 to-indigo-500 text-white flex items-center justify-center text-xl shadow-md shadow-sky-600/25 ring-2 ring-sky-100 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h4 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-sky-700 transition-colors">
                            Layanan Lapor Cepat
                        </h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Jika menemukan kendala kebersihan atau sarana rusak, laporkan instan ke tim Customer Service.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANNER MENU LAPOR KEBERSIHAN (CS) DIRECT LINK (Glassmorphism Emerald Card) -->
    <div class="relative overflow-hidden rounded-[32px] p-6 sm:p-9 shadow-[0_16px_36px_rgba(5,150,105,0.2)] border border-white/30 bg-gradient-to-r from-emerald-600/95 via-teal-600/95 to-emerald-700/95 backdrop-blur-2xl text-white flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <!-- Ambient glow inside banner -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="space-y-2 relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider border border-white/25">
                <i class="fa-solid fa-paper-plane text-[9px]"></i> Menu Lapor Kebersihan (CS)
            </span>
            <h3 class="font-heading font-black text-xl sm:text-2xl text-white">
                Ada Kendala Kebersihan Di Lingkungan Anda?
            </h3>
            <p class="text-xs sm:text-sm text-emerald-100 font-medium">
                Sampaikan laporan pengaduan Anda secara langsung kepada Tim Customer Service Kebersihan Yayasan Assalafiyyah.
            </p>
        </div>

        <a href="<?= base_url('cs') ?>" class="relative z-10 px-7 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs hover:bg-emerald-50 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 shadow-lg flex items-center justify-center gap-2 flex-shrink-0 active:scale-95">
            <i class="fa-solid fa-paper-plane text-emerald-600"></i>
            <span>Buka Form Lapor Kebersihan</span>
        </a>
    </div>
</div>
<?= $this->endSection() ?>
