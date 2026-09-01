<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6 sm:space-y-10 py-2 sm:py-8">
    <!-- HERO SECTION: Ucapan Selamat Datang Utama -->
    <div class="relative overflow-hidden glass-card rounded-3xl p-6 sm:p-14 shadow-2xl shadow-emerald-900/10 border border-emerald-200/80 bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 text-white text-center space-y-5 sm:space-y-6">
        <!-- Ambient Background Glows -->
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-3 sm:space-y-4">
            <div class="flex flex-wrap items-center justify-center gap-2">
                <div class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-300 text-[11px] sm:text-xs font-extrabold border border-emerald-400/30 shadow-inner">
                    <i class="fa-solid fa-leaf text-emerald-400"></i>
                    <span>KEBERSIHAN ASSALAFIYYAH</span>
                </div>

                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Sapaan Personal Akun Login -->
                    <div class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-bold border border-emerald-400/30 shadow-inner">
                        <span class="w-2 h-2 rounded-full <?= session()->get('role') === 'Admin' ? 'bg-emerald-400 animate-pulse' : (session()->get('role') === 'Auditor' ? 'bg-blue-400 animate-pulse' : 'bg-purple-400') ?>"></span>
                        <span class="truncate max-w-[150px] sm:max-w-none">Ahlan, <strong class="text-white font-extrabold"><?= esc(session()->get('nama_lengkap')) ?></strong></span>
                        <span class="text-[9px] sm:text-[10px] font-extrabold px-1.5 py-0.2 rounded-full uppercase tracking-wider <?= session()->get('role') === 'Admin' ? 'bg-emerald-400/30 text-emerald-100 border border-emerald-300/40' : (session()->get('role') === 'Auditor' ? 'bg-blue-400/30 text-blue-100 border border-blue-300/40' : 'bg-purple-400/30 text-purple-100 border border-purple-300/40') ?>">
                            <?= esc(session()->get('role')) ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <h1 class="text-2xl sm:text-4xl md:text-5xl font-heading font-extrabold tracking-tight leading-tight text-white drop-shadow-md">
                Selamat Datang di Website <br>
                <span class="bg-gradient-to-r from-emerald-300 via-teal-200 to-green-400 bg-clip-text text-transparent">Lapor Kebersihan</span><br>
                Pondok Pesantren Assalafiyyah
            </h1>

            <p class="text-xs sm:text-base text-slate-300 font-medium leading-relaxed max-w-2xl mx-auto px-2 sm:px-0">
                Wadah layanan pengaduan kebersihan, pemeliharaan lingkungan yang asri, serta transparansi gerakan kebersihan bersama seluruh santri & pengurus Kebersihan.
            </p>
        </div>
    </div>

    <!-- KATA-KATA KUTIPAN HIKMAH KEBERSIHAN -->
    <div class="glass-card rounded-3xl p-8 sm:p-10 shadow-xl border border-slate-200/80 bg-white/90 space-y-6 text-center">
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl mx-auto shadow-inner">
            <i class="fa-solid fa-quote-left"></i>
        </div>

        <div class="space-y-3 max-w-2xl mx-auto">
            <h2 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight">
                "Kebersihan Adalah Sebagian Dari Iman"
            </h2>
            <p class="text-sm sm:text-base text-slate-600 font-semibold italic leading-relaxed">
                « Mencegah kekotoran, merawat kerapian sarana ibadah & asrama santri, serta menjaga lingkungan pesantren agar senantiasa bersih, suci, dan nyaman untuk menuntut ilmu agama. »
            </p>
        </div>

        <!-- 3 Feature Highlight Cards (Premium & Clean) -->
        <div class="pt-3 grid grid-cols-1 sm:grid-cols-3 gap-5 text-left">
            <!-- Card 1: Lingkungan Asri & Suci -->
            <div class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-emerald-50/90 via-white to-emerald-50/40 border border-emerald-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-start">
                <div class="space-y-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
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
            <div class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-teal-50/90 via-white to-teal-50/40 border border-teal-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-start">
                <div class="space-y-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-teal-600 to-cyan-500 text-white flex items-center justify-center text-xl shadow-md shadow-teal-500/20 group-hover:scale-110 transition-transform duration-300">
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
            <div class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-blue-50/90 via-white to-blue-50/40 border border-blue-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-start">
                <div class="space-y-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h4 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-blue-700 transition-colors">
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

    <!-- BANNER MENU LAPOR KEBERSIHAN (CS) DIRECT LINK -->
    <div class="glass-card rounded-3xl p-8 shadow-xl border border-slate-200/80 bg-gradient-to-r from-emerald-600 to-teal-600 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="px-3 py-1 rounded-full bg-white/20 text-white text-[10px] font-extrabold uppercase tracking-wider">
                Menu Lapor Kebersihan (CS)
            </span>
            <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-white">
                Ada Kendala Kebersihan Di Lingkungan Anda?
            </h3>
            <p class="text-xs sm:text-sm text-emerald-100 font-medium">
                Sampaikan laporan pengaduan Anda secara langsung kepada Tim Customer Service Kebersihan Yayasan Assalafiyyah.
            </p>
        </div>

        <a href="<?= base_url('cs') ?>" class="px-7 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs hover:bg-emerald-50 transition shadow-lg flex items-center justify-center gap-2 flex-shrink-0">
            <i class="fa-solid fa-paper-plane text-emerald-600"></i>
            <span>Buka Form Lapor Kebersihan</span>
        </a>
    </div>
</div>
<?= $this->endSection() ?>
