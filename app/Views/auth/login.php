<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-md w-full mx-auto space-y-6">
    <!-- Logo & Title -->
    <div class="text-center space-y-2">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-3xl mx-auto shadow-xl shadow-emerald-500/25">
            <i class="fa-solid fa-leaf"></i>
        </div>
        <h1 class="font-heading font-extrabold text-2xl text-slate-900 tracking-tight">WEBSITE LAPOR KEBERSIHAN</h1>
        <p class="text-xs text-emerald-700 font-bold uppercase tracking-wider">Sistem Informasi Manajemen</p>
        <p class="text-xs text-slate-500 font-medium">Silakan masuk sesuai role akun yang didaftarkan oleh Admin.</p>
    </div>

    <!-- Login Card Form -->
    <div class="glass-card rounded-3xl p-7 shadow-2xl space-y-5 bg-white">
        <form action="<?= base_url('login/process') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Username Akun</label>
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                    <input type="text" id="usernameInput" name="username" value="<?= old('username') ?>" placeholder="Ketik username akun..." required class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                    <input type="password" id="passwordInput" name="password" placeholder="••••••••" required class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-lg shadow-emerald-600/25 flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Masuk ke Sistem</span>
            </button>
        </form>

        <div class="text-center space-y-2 pt-2 border-t border-slate-100">
            <a href="<?= base_url('cs') ?>" class="inline-flex items-center gap-1.5 text-xs text-emerald-700 hover:text-emerald-800 font-extrabold">
                <i class="fa-solid fa-headset"></i>
                <span>Buka Layanan Customer Service Publik</span>
            </a>
            <p class="text-[11px] text-slate-400">&copy; 2026 Musapang. All rights reserved.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
