<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-8 pb-10">

    <!-- Header Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-200/80 bg-white/95 backdrop-blur-xl space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/80 shadow-2xs">
                    <i class="fa-solid fa-sliders text-emerald-600"></i>
                    <span>Konfigurasi & Pengaturan Sistem</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight leading-snug">
                    Pengaturan Sistem Kebersihan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-semibold">
                    Kelola identitas instansi, pengesahan PDF, unit kebersihan & PJ/Kader (Gemerlap & Satgas), notifikasi CS, dan pemeliharaan database.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="<?= base_url('pengaturan/backup') ?>" class="px-5 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-heading font-extrabold text-xs transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-database text-emerald-400"></i>
                    <span>Backup Database SQL</span>
                </a>
            </div>
        </div>

        <!-- Alert Flash Messages -->
        <?php if (session()->getFlashdata('msg_success')): ?>
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center gap-3 shadow-2xs">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span><?= session()->getFlashdata('msg_success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('msg_error')): ?>
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-bold flex items-center gap-3 shadow-2xs">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                <span><?= session()->getFlashdata('msg_error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Segmented Floating Tab Navbar (Mobile Horizontal Scrollable & Clean Desktop Tabs) -->
        <div class="mt-6">
            <div class="bg-white p-1.5 sm:p-2 rounded-2xl border border-slate-200/90 shadow-sm overflow-x-auto">
                <nav class="flex items-center gap-1.5 min-w-max">
                    <button type="button" onclick="switchTab('general')" id="tab-btn-general" class="tab-nav-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold transition-all duration-200 flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20 whitespace-nowrap">
                        <i class="fa-solid fa-building text-sm"></i>
                        <span>1. Identitas & Info Umum</span>
                    </button>

                    <button type="button" onclick="switchTab('pengesahan')" id="tab-btn-pengesahan" class="tab-nav-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-file-signature text-sm"></i>
                        <span>2. Pengesahan PDF</span>
                    </button>

                    <button type="button" onclick="switchTab('units')" id="tab-btn-units" class="tab-nav-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-sitemap text-sm"></i>
                        <span>3. Instansi & PJ/Kader</span>
                    </button>

                    <button type="button" onclick="switchTab('cs')" id="tab-btn-cs" class="tab-nav-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-comments text-sm"></i>
                        <span>4. Notifikasi CS WhatsApp</span>
                    </button>

                    <button type="button" onclick="switchTab('backup')" id="tab-btn-backup" class="tab-nav-btn flex-1 py-2.5 px-3.5 sm:px-4 rounded-xl text-xs font-heading font-extrabold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                        <span>5. Backup Database</span>
                    </button>
                </nav>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 1: IDENTITAS & INFORMASI UMUM ==================== -->
    <div id="tab-content-general" class="tab-content-panel space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-building text-emerald-600"></i> Identitas & Profil Instansi
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Pengaturan nama yayasan/layanan, alamat resmi, hotline CS, dan pesan running text.</p>
                </div>
            </div>

            <form action="<?= base_url('pengaturan/update-general') ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Instansi / Pengelola Kebersihan</label>
                        <input type="text" name="nama_instansi" value="<?= esc($settings['nama_instansi'] ?? '') ?>" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Hotline CS</label>
                        <input type="text" name="hotline_wa" value="<?= esc($settings['hotline_wa'] ?? '') ?>" placeholder="Misal: 081234567890" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap Instansi</label>
                    <textarea name="alamat_instansi" rows="2" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"><?= esc($settings['alamat_instansi'] ?? '') ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pengumuman / Running Text (Tampil di CS Public Portal)</label>
                    <textarea name="running_text" rows="2" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"><?= esc($settings['running_text'] ?? '') ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Upload Logo Resmi Instansi (PNG/JPG)</label>
                    <div class="flex items-center gap-4">
                        <?php if (!empty($settings['logo_img']) && has_valid_image($settings['logo_img'])): ?>
                            <div class="w-16 h-16 rounded-2xl border border-slate-200 bg-slate-50 p-2 flex items-center justify-center flex-shrink-0">
                                <img src="<?= image_url($settings['logo_img'], 'uploads/settings') ?>" alt="Logo" class="max-h-full max-w-full object-contain">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="logo_img" accept="image/*" class="text-xs font-semibold text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20">
                        Simpan Pengaturan Umum
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== TAB 2: PENGESAHAN CETAK PDF ==================== -->
    <div id="tab-content-pengesahan" class="tab-content-panel hidden space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                <div>
                    <h2 class="font-heading font-extrabold text-xl text-slate-900 flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base border border-emerald-200/80 shadow-2xs">
                            <i class="fa-solid fa-file-signature"></i>
                        </span>
                        <span>Pengesahan & Tanda Tangan Cetak PDF</span>
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold mt-1">Konfigurasi nama pejabat penandatangan (Ketua K3L, Koordinator Kebersihan, Sekretaris), serta upload tanda tangan digital & stempel untuk lembar pengesahan LPJ PDF.</p>
                </div>
            </div>

            <form action="<?= base_url('pengaturan/update-pengesahan') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                
                <!-- GRID 4 KARTU PENGESAHAN -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- 1. KETUA PENGURUS K3L (EMERALD) -->
                    <div class="rounded-3xl p-6 bg-slate-50/70 border border-slate-200/90 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-300 space-y-5 flex flex-col justify-between">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-center justify-between gap-3 border-b border-slate-200/70 pb-3.5 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-sm shadow-md shadow-emerald-600/20 flex-shrink-0">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-heading font-extrabold text-xs text-slate-900 uppercase tracking-wider">1. Ketua Pengurus K3L</h3>
                                        <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 inline-block mt-0.5">Penandatangan Utama</span>
                                    </div>
                                </div>
                                <?php if (!empty($settings['ttd_ketua_img']) && file_exists(FCPATH . $settings['ttd_ketua_img'])): ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-emerald-100 text-emerald-800 text-[10px] font-extrabold flex items-center gap-1 border border-emerald-200">
                                        <i class="fa-solid fa-check text-[9px]"></i> TTD Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-slate-200/80 text-slate-600 text-[10px] font-extrabold">Belum Ada TTD</span>
                                <?php endif; ?>
                            </div>

                            <!-- Input Fields -->
                            <div class="space-y-3.5">
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-user text-emerald-600 text-xs"></i>
                                        <span>Nama Lengkap Ketua</span>
                                    </label>
                                    <input type="text" id="input_nama_ketua" name="nama_ketua_k3l" value="<?= esc($settings['nama_ketua_k3l'] ?? 'Bapak Afif Muzayyin') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-id-badge text-emerald-600 text-xs"></i>
                                        <span>Jabatan Pada Cetak PDF</span>
                                    </label>
                                    <input type="text" id="input_jabatan_ketua" name="jabatan_ketua" value="<?= esc($settings['jabatan_ketua'] ?? 'Ketua K3L Assalafiyyah') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
                                </div>
                            </div>
                        </div>

                        <!-- TTD Upload & Box Preview -->
                        <div class="pt-3 border-t border-slate-200/70">
                            <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-2">Tanda Tangan Digital (PNG Transparan)</label>
                            <div class="flex items-center gap-4 bg-white p-3 rounded-2xl border border-slate-200/80 shadow-2xs">
                                <div class="w-24 h-16 rounded-xl border border-dashed border-emerald-300 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0 relative group">
                                    <?php if (!empty($settings['ttd_ketua_img']) && has_valid_image($settings['ttd_ketua_img'])): ?>
                                        <img id="preview_ttd_ketua" src="<?= image_url($settings['ttd_ketua_img'], 'uploads/settings') ?>" alt="TTD Ketua" class="max-h-full max-w-full object-contain">
                                    <?php else: ?>
                                        <img id="preview_ttd_ketua" src="" alt="TTD Ketua" class="max-h-full max-w-full object-contain hidden">
                                        <span id="placeholder_ttd_ketua" class="text-[10px] text-slate-400 font-extrabold text-center leading-tight"><i class="fa-solid fa-signature text-slate-300 text-base block mb-0.5"></i>Kosong</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input type="file" name="ttd_ketua_img" accept="image/png,image/jpeg" onchange="previewImage(this, 'preview_ttd_ketua', 'placeholder_ttd_ketua')" class="text-xs font-semibold text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition file:cursor-pointer w-full">
                                    <p class="text-[10px] text-slate-400 font-semibold">Format PNG transparan resolusi tinggi (maks. 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. KOORDINATOR KEBERSIHAN (TEAL) -->
                    <div class="rounded-3xl p-6 bg-slate-50/70 border border-slate-200/90 hover:border-teal-300 hover:shadow-lg hover:shadow-teal-500/5 transition-all duration-300 space-y-5 flex flex-col justify-between">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-center justify-between gap-3 border-b border-slate-200/70 pb-3.5 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-teal-600 to-cyan-500 text-white flex items-center justify-center text-sm shadow-md shadow-teal-600/20 flex-shrink-0">
                                        <i class="fa-solid fa-user-gear"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-heading font-extrabold text-xs text-slate-900 uppercase tracking-wider">2. Koordinator Kebersihan</h3>
                                        <span class="text-[10px] text-teal-700 font-bold bg-teal-50 px-2 py-0.5 rounded-full border border-teal-200/60 inline-block mt-0.5">Penanggung Jawab Operasional</span>
                                    </div>
                                </div>
                                <?php if (!empty($settings['ttd_koordinator_img']) && has_valid_image($settings['ttd_koordinator_img'])): ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-teal-100 text-teal-800 text-[10px] font-extrabold flex items-center gap-1 border border-teal-200">
                                        <i class="fa-solid fa-check text-[9px]"></i> TTD Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-slate-200/80 text-slate-600 text-[10px] font-extrabold">Belum Ada TTD</span>
                                <?php endif; ?>
                            </div>

                            <!-- Input Fields -->
                            <div class="space-y-3.5">
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-user text-teal-600 text-xs"></i>
                                        <span>Nama Lengkap Koordinator</span>
                                    </label>
                                    <input type="text" id="input_nama_koordinator" name="nama_koordinator" value="<?= esc($settings['nama_koordinator'] ?? 'Bapak Muhammad Ashar') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-2xs placeholder-slate-400">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-id-badge text-teal-600 text-xs"></i>
                                        <span>Jabatan Pada Cetak PDF</span>
                                    </label>
                                    <input type="text" id="input_jabatan_koordinator" name="jabatan_koordinator" value="<?= esc($settings['jabatan_koordinator'] ?? 'Koordinator Kebersihan') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-2xs placeholder-slate-400">
                                </div>
                            </div>
                        </div>

                        <!-- TTD Upload & Box Preview -->
                        <div class="pt-3 border-t border-slate-200/70">
                            <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-2">Tanda Tangan Digital (PNG Transparan)</label>
                            <div class="flex items-center gap-4 bg-white p-3 rounded-2xl border border-slate-200/80 shadow-2xs">
                                <div class="w-24 h-16 rounded-xl border border-dashed border-teal-300 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0 relative group">
                                    <?php if (!empty($settings['ttd_koordinator_img']) && has_valid_image($settings['ttd_koordinator_img'])): ?>
                                        <img id="preview_ttd_koordinator" src="<?= image_url($settings['ttd_koordinator_img'], 'uploads/settings') ?>" alt="TTD Koordinator" class="max-h-full max-w-full object-contain">
                                    <?php else: ?>
                                        <img id="preview_ttd_koordinator" src="" alt="TTD Koordinator" class="max-h-full max-w-full object-contain hidden">
                                        <span id="placeholder_ttd_koordinator" class="text-[10px] text-slate-400 font-extrabold text-center leading-tight"><i class="fa-solid fa-signature text-slate-300 text-base block mb-0.5"></i>Kosong</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input type="file" name="ttd_koordinator_img" accept="image/png,image/jpeg" onchange="previewImage(this, 'preview_ttd_koordinator', 'placeholder_ttd_koordinator')" class="text-xs font-semibold text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-extrabold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition file:cursor-pointer w-full">
                                    <p class="text-[10px] text-slate-400 font-semibold">Format PNG transparan resolusi tinggi (maks. 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. SEKRETARIS KEBERSIHAN (BLUE) -->
                    <div class="rounded-3xl p-6 bg-slate-50/70 border border-slate-200/90 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 space-y-5 flex flex-col justify-between">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-center justify-between gap-3 border-b border-slate-200/70 pb-3.5 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center text-sm shadow-md shadow-blue-600/20 flex-shrink-0">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-heading font-extrabold text-xs text-slate-900 uppercase tracking-wider">3. Sekretaris Kebersihan</h3>
                                        <span class="text-[10px] text-blue-700 font-bold bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200/60 inline-block mt-0.5">Pembuat Dokumen LPJ</span>
                                    </div>
                                </div>
                                <?php if (!empty($settings['ttd_sekretaris_img']) && has_valid_image($settings['ttd_sekretaris_img'])): ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-blue-100 text-blue-800 text-[10px] font-extrabold flex items-center gap-1 border border-blue-200">
                                        <i class="fa-solid fa-check text-[9px]"></i> TTD Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-slate-200/80 text-slate-600 text-[10px] font-extrabold">Belum Ada TTD</span>
                                <?php endif; ?>
                            </div>

                            <!-- Input Fields -->
                            <div class="space-y-3.5">
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-user text-blue-600 text-xs"></i>
                                        <span>Nama Lengkap Sekretaris</span>
                                    </label>
                                    <input type="text" id="input_nama_sekretaris" name="nama_sekretaris" value="<?= esc($settings['nama_sekretaris'] ?? 'Ahmad Musyafa') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-2xs placeholder-slate-400">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-id-badge text-blue-600 text-xs"></i>
                                        <span>Jabatan Pada Cetak PDF</span>
                                    </label>
                                    <input type="text" id="input_jabatan_sekretaris" name="jabatan_sekretaris" value="<?= esc($settings['jabatan_sekretaris'] ?? 'Sekretaris Kebersihan') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-2xs placeholder-slate-400">
                                </div>
                            </div>
                        </div>

                        <!-- TTD Upload & Box Preview -->
                        <div class="pt-3 border-t border-slate-200/70">
                            <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-2">Tanda Tangan Digital (PNG Transparan)</label>
                            <div class="flex items-center gap-4 bg-white p-3 rounded-2xl border border-slate-200/80 shadow-2xs">
                                <div class="w-24 h-16 rounded-xl border border-dashed border-blue-300 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0 relative group">
                                    <?php if (!empty($settings['ttd_sekretaris_img']) && has_valid_image($settings['ttd_sekretaris_img'])): ?>
                                        <img id="preview_ttd_sekretaris" src="<?= image_url($settings['ttd_sekretaris_img'], 'uploads/settings') ?>" alt="TTD Sekretaris" class="max-h-full max-w-full object-contain">
                                    <?php else: ?>
                                        <img id="preview_ttd_sekretaris" src="" alt="TTD Sekretaris" class="max-h-full max-w-full object-contain hidden">
                                        <span id="placeholder_ttd_sekretaris" class="text-[10px] text-slate-400 font-extrabold text-center leading-tight"><i class="fa-solid fa-signature text-slate-300 text-base block mb-0.5"></i>Kosong</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input type="file" name="ttd_sekretaris_img" accept="image/png,image/jpeg" onchange="previewImage(this, 'preview_ttd_sekretaris', 'placeholder_ttd_sekretaris')" class="text-xs font-semibold text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-extrabold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition file:cursor-pointer w-full">
                                    <p class="text-[10px] text-slate-400 font-semibold">Format PNG transparan resolusi tinggi (maks. 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. STEMPEL DIGITAL & LOKASI CETAK (PURPLE) -->
                    <div class="rounded-3xl p-6 bg-slate-50/70 border border-slate-200/90 hover:border-purple-300 hover:shadow-lg hover:shadow-purple-500/5 transition-all duration-300 space-y-5 flex flex-col justify-between">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-center justify-between gap-3 border-b border-slate-200/70 pb-3.5 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-fuchsia-500 text-white flex items-center justify-center text-sm shadow-md shadow-purple-600/20 flex-shrink-0">
                                        <i class="fa-solid fa-stamp"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-heading font-extrabold text-xs text-slate-900 uppercase tracking-wider">4. Stempel & Legalisasi</h3>
                                        <span class="text-[10px] text-purple-700 font-bold bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200/60 inline-block mt-0.5">Cap Resmi Lembaga</span>
                                    </div>
                                </div>
                                <?php if (!empty($settings['stempel_img']) && has_valid_image($settings['stempel_img'])): ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-purple-100 text-purple-800 text-[10px] font-extrabold flex items-center gap-1 border border-purple-200">
                                        <i class="fa-solid fa-check text-[9px]"></i> Stempel Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 rounded-xl bg-slate-200/80 text-slate-600 text-[10px] font-extrabold">Belum Ada Stempel</span>
                                <?php endif; ?>
                            </div>

                            <!-- Input Fields -->
                            <div class="space-y-3.5">
                                <div>
                                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-purple-600 text-xs"></i>
                                        <span>Kota Lokasi Dokumen (Titimangsa)</span>
                                    </label>
                                    <input type="text" id="input_kota_dokumen" name="kota_dokumen" value="<?= esc($settings['kota_dokumen'] ?? 'Sleman') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition shadow-2xs placeholder-slate-400" placeholder="Contoh: Sleman / Yogyakarta">
                                </div>
                            </div>
                        </div>

                        <!-- Stempel Upload & Box Preview -->
                        <div class="pt-3 border-t border-slate-200/70">
                            <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-2">Upload Stempel Resmi PNG (Transparan)</label>
                            <div class="flex items-center gap-4 bg-white p-3 rounded-2xl border border-slate-200/80 shadow-2xs">
                                <div class="w-24 h-16 rounded-xl border border-dashed border-purple-300 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0 relative group">
                                    <?php if (!empty($settings['stempel_img']) && has_valid_image($settings['stempel_img'])): ?>
                                        <img id="preview_stempel" src="<?= image_url($settings['stempel_img'], 'uploads/settings') ?>" alt="Stempel" class="max-h-full max-w-full object-contain">
                                    <?php else: ?>
                                        <img id="preview_stempel" src="" alt="Stempel" class="max-h-full max-w-full object-contain hidden">
                                        <span id="placeholder_stempel" class="text-[10px] text-slate-400 font-extrabold text-center leading-tight"><i class="fa-solid fa-stamp text-slate-300 text-base block mb-0.5"></i>Kosong</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input type="file" name="stempel_img" accept="image/png,image/jpeg" onchange="previewImage(this, 'preview_stempel', 'placeholder_stempel')" class="text-xs font-semibold text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-extrabold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition file:cursor-pointer w-full">
                                    <p class="text-[10px] text-slate-400 font-semibold">Format PNG transparan stempel (maks. 3MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- SIMULASI REALISTIS LEMBAR PENGESAHAN PDF -->
                <div class="rounded-3xl p-6 sm:p-7 bg-slate-900 text-white space-y-4 border border-slate-800 shadow-2xl">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-eye text-emerald-400 text-sm"></i>
                            <h4 class="font-heading font-extrabold text-xs tracking-wider uppercase text-slate-200">Simulasi Tampilan Lembar Pengesahan Pada Dokumen PDF</h4>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-slate-800 text-emerald-400 font-mono text-[10px] font-bold border border-slate-700">Live PDF Mockup</span>
                    </div>

                    <!-- Mini Document Canvas Preview -->
                    <div class="bg-white rounded-2xl p-6 text-slate-900 shadow-inner font-sans border border-slate-200">
                        <div class="text-center space-y-1 border-b border-slate-200 pb-4 mb-6">
                            <h5 class="font-heading font-extrabold text-sm tracking-wide text-slate-900">LEMBAR PENGESAHAN LAPORAN PERTANGGUNGJAWABAN</h5>
                            <p class="text-[11px] text-slate-500 font-semibold">K3L Yayasan Assalafiyyah Mlangi Sleman Yogyakarta</p>
                        </div>

                        <!-- 3 Column Signature Mockup -->
                        <div class="grid grid-cols-3 gap-4 text-center items-end relative py-2">
                            <!-- Koordinator -->
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500 font-bold mb-10">Mengetahui,<br><span class="text-slate-800 font-extrabold text-[11px]"><?= esc($settings['jabatan_koordinator'] ?? 'Koordinator Kebersihan') ?></span></p>
                                <p class="font-heading font-extrabold text-xs text-slate-900 underline decoration-slate-400 decoration-1 underline-offset-4"><?= esc($settings['nama_koordinator'] ?? 'Bapak Muhammad Ashar') ?></p>
                            </div>

                            <!-- Ketua (Center with Stempel) -->
                            <div class="space-y-1 relative">
                                <p class="text-[10px] text-slate-500 font-bold mb-10">Mengesahkan,<br><span class="text-slate-800 font-extrabold text-[11px]"><?= esc($settings['jabatan_ketua'] ?? 'Ketua K3L Assalafiyyah') ?></span></p>
                                <p class="font-heading font-extrabold text-xs text-slate-900 underline decoration-slate-400 decoration-1 underline-offset-4"><?= esc($settings['nama_ketua_k3l'] ?? 'Bapak Afif Muzayyin') ?></p>
                            </div>

                            <!-- Sekretaris -->
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500 font-bold mb-10"><?= esc($settings['kota_dokumen'] ?? 'Sleman') ?>, <?= date('d F Y') ?><br><span class="text-slate-800 font-extrabold text-[11px]"><?= esc($settings['jabatan_sekretaris'] ?? 'Sekretaris Kebersihan') ?></span></p>
                                <p class="font-heading font-extrabold text-xs text-slate-900 underline decoration-slate-400 decoration-1 underline-offset-4"><?= esc($settings['nama_sekretaris'] ?? 'Ahmad Musyafa') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-slate-500 font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i>
                        <span>Perubahan tanda tangan dan pejabat langsung berlaku ke semua export PDF.</span>
                    </p>
                    <button type="submit" class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Pengesahan & Tanda Tangan PDF</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Image Preview Helper -->
    <script>
        function previewImage(input, previewId, placeholderId) {
            const previewEl = document.getElementById(previewId);
            const placeholderEl = document.getElementById(placeholderId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewEl) {
                        previewEl.src = e.target.result;
                        previewEl.classList.remove('hidden');
                    }
                    if (placeholderEl) {
                        placeholderEl.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- ==================== TAB 3: KELOLA INSTANSI / UNIT & PJ / KADER ==================== -->
    <div id="tab-content-units" class="tab-content-panel hidden space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-sitemap text-emerald-600"></i> Kelola Instansi / Unit Kebersihan & PJ / Kader
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Daftar unit kebersihan pesantren. Setiap unit memiliki Penanggung Jawab serta anggota Kader.</p>
                </div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <button type="button" onclick="openModalKelolaTipe()" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2">
                        <i class="fa-solid fa-tags text-emerald-600"></i>
                        <span>Kelola Tipe Unit</span>
                    </button>
                    <button type="button" onclick="openModalKelolaKategoriPengaturan()" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-teal-600"></i>
                        <span>Kelola Kategori Alat</span>
                    </button>
                    <button type="button" onclick="openModalTambahUnit()" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2 flex-shrink-0">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Unit Baru</span>
                    </button>
                </div>
            </div>

            <!-- Toolbar Filter & Search -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-slate-50/80 p-3 rounded-2xl border border-slate-200/80">
                <div class="relative flex-1 min-w-[220px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="unitSearchInput" onkeyup="filterUnitTable()" placeholder="Cari nama unit, kode, tipe, atau PJ..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
                </div>
                
                <div class="flex items-center gap-2 flex-wrap">
                    <select id="unitTipeFilter" onchange="filterUnitTable()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-extrabold bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                        <option value="">Semua Tipe Unit</option>
                        <?php if (!empty($tipeList)): ?>
                            <?php foreach ($tipeList as $tp): ?>
                                <option value="<?= esc($tp['nama_tipe']) ?>"><?= esc($tp['nama_tipe']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <div class="flex items-center gap-1.5 bg-white px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 shadow-2xs">
                        <span class="text-[11px] text-slate-400 font-semibold">Tampil:</span>
                        <select id="unitPerPageSelect" onchange="changeUnitPerPage(this.value)" class="bg-transparent border-0 text-xs font-extrabold text-slate-800 focus:ring-0 cursor-pointer p-0">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="all">Semua</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabel Master Unit & Mapping PJ/Kader -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 shadow-2xs">
                <table class="w-full text-left text-xs font-semibold" id="unitMasterTable">
                    <thead class="bg-slate-50 text-slate-600 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3.5 px-3 text-center">NO</th>
                            <th width="15%" class="py-3.5 px-4">KODE & TIPE</th>
                            <th width="25%" class="py-3.5 px-4">NAMA UNIT / INSTANSI</th>
                            <th width="25%" class="py-3.5 px-4">PENANGGUNG JAWAB (PJ)</th>
                            <th width="20%" class="py-3.5 px-4">GEMERLAP / SATGAS</th>
                            <th width="11%" class="py-3.5 px-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white" id="unitTableBody">
                        <?php if (!empty($unitsList)): ?>
                            <?php foreach ($unitsList as $idx => $u): ?>
                                <?php 
                                    $pjNames = [];
                                    if (!empty($u['pjs'])) {
                                        foreach ($u['pjs'] as $p) { $pjNames[] = $p['nama_pj']; }
                                    }
                                    $pjStr = implode(' ', $pjNames);
                                ?>
                                <tr class="unit-row hover:bg-slate-50/80 transition" 
                                    data-nama="<?= strtolower(esc($u['nama_unit'])) ?>" 
                                    data-kode="<?= strtolower(esc($u['kode_unit'] ?: 'UNIT-' . $u['id'])) ?>" 
                                    data-tipe="<?= strtolower(esc($u['tipe'])) ?>" 
                                    data-pj="<?= strtolower(esc($pjStr)) ?>">
                                    <td class="py-4 px-3 text-center font-extrabold text-slate-400 unit-row-no"><?= $idx + 1 ?></td>
                                    <td class="py-4 px-4 space-y-1">
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono font-extrabold text-[11px] border border-slate-200 inline-block">
                                            <?= esc($u['kode_unit'] ?: 'UNIT-' . $u['id']) ?>
                                        </span>
                                        <div class="text-[11px] text-slate-500 font-medium"><?= esc($u['tipe']) ?></div>
                                    </td>
                                    <td class="py-4 px-4 font-extrabold text-slate-900 text-xs">
                                        <div><?= esc($u['nama_unit']) ?></div>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold <?= ($u['status'] ?? 'Aktif') === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' ?>">
                                            <?= esc($u['status'] ?? 'Aktif') ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php if (!empty($u['pjs'])): ?>
                                            <div class="space-y-1.5">
                                                <?php foreach ($u['pjs'] as $pIdx => $pj): ?>
                                                    <div class="font-extrabold text-slate-800 text-xs flex items-center gap-1.5">
                                                        <i class="fa-solid fa-user-check text-emerald-600 text-[11px]"></i>
                                                        <span><?= esc($pj['nama_pj']) ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                                <?php if (count($u['pjs']) > 1): ?>
                                                    <div class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-md inline-block border border-emerald-200/60">
                                                        <?= count($u['pjs']) ?> Penanggung Jawab
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-slate-400 italic text-[11px]">- Belum ditentukan -</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php if (($u['ada_kader'] ?? 'Ya') === 'Tidak'): ?>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 inline-block">
                                                Tidak Ada
                                            </span>
                                        <?php else: ?>
                                            <div class="space-y-1">
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border <?= strpos($u['kader_label'], 'Gemerlap') !== false ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-blue-50 text-blue-800 border-blue-200' ?>">
                                                    <?= esc($u['kader_label']) ?>
                                                </span>
                                                <div class="text-[11px] font-semibold text-slate-600">
                                                    <?= count($u['kaders']) ?> Anggota
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="<?= base_url('unit/detail/' . $u['id']) ?>" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200/80 flex items-center justify-center transition shadow-2xs" title="Lihat Detail Instansi & Riwayat">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>
                                            <button type="button" onclick="openModalEditUnit(<?= htmlspecialchars(json_encode($u)) ?>)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 border border-slate-200/60 flex items-center justify-center transition shadow-2xs" title="Edit Unit & PJ">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>
                                            <a href="<?= base_url('pengaturan/unit/delete/' . $u['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus unit kebersihan ini?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/60 flex items-center justify-center transition shadow-2xs" title="Hapus Unit">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="unitEmptyRow">
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada unit kebersihan terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2 border-t border-slate-100">
                <div class="text-xs text-slate-500 font-semibold">
                    Menampilkan <span id="unitPageStart" class="font-extrabold text-slate-800">1</span>-<span id="unitPageEnd" class="font-extrabold text-slate-800">10</span> dari <span id="unitTotalCount" class="font-extrabold text-slate-800"><?= count($unitsList ?? []) ?></span> Unit
                </div>

                <div id="unitPaginationContainer" class="flex items-center gap-1">
                    <!-- Pagination buttons rendered via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 4: NOTIFIKASI & CS WHATSAPP ==================== -->
    <div id="tab-content-cs" class="tab-content-panel hidden space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-comments text-emerald-600"></i> Notifikasi & CS WhatsApp Settings
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Atur jam operasional layanan pengaduan CS dan template balasan notifikasi otomatis.</p>
                </div>
            </div>

            <form action="<?= base_url('pengaturan/update-cs') ?>" method="POST" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jam Buka Layanan CS</label>
                        <input type="time" name="jam_cs_buka" value="<?= esc($settings['jam_cs_buka'] ?? '06:00') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jam Tutup Layanan CS</label>
                        <input type="time" name="jam_cs_tutup" value="<?= esc($settings['jam_cs_tutup'] ?? '21:00') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Plafon Pengajuan Alat Maksimal (Rp)</label>
                        <input type="number" name="plafon_pengajuan" value="<?= esc($settings['plafon_pengajuan'] ?? '500000') ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Template Pesan Balasan Laporan Diterima</label>
                    <textarea name="wa_template_terima" rows="3" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"><?= esc($settings['wa_template_terima'] ?? '') ?></textarea>
                    <span class="text-[11px] text-slate-400 font-medium">Gunakan variabel <code class="text-emerald-700 font-bold">{REPORT_ID}</code> untuk ID Laporan.</span>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Template Pesan Balasan Laporan Selesai</label>
                    <textarea name="wa_template_selesai" rows="3" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"><?= esc($settings['wa_template_selesai'] ?? '') ?></textarea>
                    <span class="text-[11px] text-slate-400 font-medium">Gunakan variabel <code class="text-emerald-700 font-bold">{REPORT_ID}</code> dan <code class="text-emerald-700 font-bold">{LOKASI}</code>.</span>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20">
                        Simpan Pengaturan CS
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== TAB 5: BACKUP & PEMELIHARAAN ==================== -->
    <div id="tab-content-backup" class="tab-content-panel hidden space-y-6">
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i> Backup & Pemeliharaan Database
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Unduh cadangan data database sistem secara berkala untuk mencegah kehilangan data pengaduan & LPJ.</p>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="font-heading font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-database text-emerald-600"></i> Backup Full Database (.SQL)
                    </div>
                    <p class="text-xs text-slate-600 font-medium max-w-xl">
                        Mengekspor seluruh tabel database `master_unit`, `tbl_pengaturan`, `buku_lpj`, `keuangan_item`, `cs_report`, `users`, dan struktur bagan.
                    </p>
                </div>

                <a href="<?= base_url('pengaturan/backup') ?>" class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 text-white font-heading font-extrabold text-xs hover:from-slate-800 hover:to-slate-700 transition shadow-lg flex items-center justify-center gap-2 flex-shrink-0">
                    <i class="fa-solid fa-download text-emerald-400"></i>
                    <span>Download SQL Backup Now</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Unit Kebersihan Baru -->
<div id="modalTambahUnit" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-plus text-emerald-600"></i> Tambah Unit Kebersihan Baru
            </h3>
            <button onclick="closeModalTambahUnit()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('pengaturan/unit/store') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Unit / Instansi</label>
                <input type="text" name="nama_unit" placeholder="Misal: Asrama Komplek C / Satgas SMP" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Unit</label>
                    <select name="tipe" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php if (!empty($tipeList)): ?>
                            <?php foreach ($tipeList as $tp): ?>
                                <option value="<?= esc($tp['nama_tipe']) ?>"><?= esc($tp['nama_tipe']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="Asrama Santri">Asrama Santri</option>
                            <option value="Sekolah / Lembaga">Sekolah / Lembaga</option>
                            <option value="Fasilitas Umum">Fasilitas Umum</option>
                            <option value="Pusat K3L">Pusat K3L</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Unik Unit</label>
                    <input type="text" name="kode_unit" placeholder="ASR-01" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Kepemilikan Kader</label>
                    <select name="ada_kader" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Ya" selected>Ada Kader</option>
                        <option value="Tidak">Tanpa Kader</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kader (Jika Ada)</label>
                    <select name="jenis_kader" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Gemerlap">Gemerlap (Asrama)</option>
                        <option value="Satgas Kebersihan">Satgas Kebersihan (Sekolah)</option>
                        <option value="Kader Kebersihan">Kader Kebersihan (Umum)</option>
                    </select>
                </div>
            </div>

            <!-- Searchable PJ User Picker for Modal Tambah Unit -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Akun Penanggung Jawab (PJ)</span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="add_pj_user_id" name="pj_user_id" value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="add_pj_user_search" placeholder="Cari nama PJ, @username, atau role..." autocomplete="off" onfocus="openAddPjDropdown()" oninput="filterAddPjOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                    <button type="button" onclick="toggleAddPjDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="addPjIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="addPjDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <div class="add-pj-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer font-bold text-xs text-slate-500" data-id="" data-name="" data-nama="" data-hp="" onclick="selectAddPj(this)">
                        <span class="text-slate-500 italic">-- Tanpa Akun PJ Terhubung / Pilih Nanti --</span>
                    </div>
                    <?php foreach ($usersList as $u): ?>
                        <div class="add-pj-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-name="<?= esc($u['nama_lengkap']) ?> (@<?= esc($u['username']) ?>)" data-nama="<?= esc($u['nama_lengkap']) ?>" data-hp="<?= esc($u['no_hp'] ?? '') ?>" onclick="selectAddPj(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($u['nama_lengkap']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                    <span class="text-emerald-700 font-bold">@<?= esc($u['username']) ?></span>
                                    <span>&bull;</span>
                                    <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[9px] font-extrabold border border-slate-200/80"><?= esc($u['role']) ?></span>
                                </div>
                            </div>
                            <span class="text-xs text-slate-300 group-hover:text-emerald-600"><i class="fa-solid fa-check text-[10px]"></i></span>
                        </div>
                    <?php endforeach; ?>
                    <div id="noAddPjFound" class="px-4 py-4 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan akun pengguna yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama PJ Manual</label>
                    <input type="text" name="pj_nama" placeholder="Kang Ahmad" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">No. Kontak / WA PJ</label>
                    <input type="text" name="pj_kontak" placeholder="0812xxxx" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahUnit()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Unit</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Unit -->
<div id="modalEditUnit" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Edit Data Unit & Penanggung Jawab
            </h3>
            <button onclick="closeModalEditUnit()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formEditUnit" action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Unit / Instansi</label>
                <input type="text" id="edit_nama_unit" name="nama_unit" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Unit</label>
                    <select id="edit_tipe" name="tipe" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php if (!empty($tipeList)): ?>
                            <?php foreach ($tipeList as $tp): ?>
                                <option value="<?= esc($tp['nama_tipe']) ?>"><?= esc($tp['nama_tipe']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="Asrama Santri">Asrama Santri</option>
                            <option value="Sekolah / Lembaga">Sekolah / Lembaga</option>
                            <option value="Fasilitas Umum">Fasilitas Umum</option>
                            <option value="Pusat K3L">Pusat K3L</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Unik Unit</label>
                    <input type="text" id="edit_kode_unit" name="kode_unit" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Kepemilikan Kader</label>
                    <select id="edit_ada_kader" name="ada_kader" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Ya">Ada Kader</option>
                        <option value="Tidak">Tanpa Kader</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kader (Jika Ada)</label>
                    <select id="edit_jenis_kader" name="jenis_kader" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Gemerlap">Gemerlap (Asrama)</option>
                        <option value="Satgas Kebersihan">Satgas Kebersihan (Sekolah)</option>
                        <option value="Kader Kebersihan">Kader Kebersihan (Umum)</option>
                    </select>
                </div>
            </div>

            <!-- Searchable PJ User Picker for Modal Edit Unit -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Akun Penanggung Jawab (PJ)</span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="edit_pj_user_id" name="pj_user_id" value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="edit_pj_user_search" placeholder="Cari nama PJ, @username, atau role..." autocomplete="off" onfocus="openEditPjDropdown()" oninput="filterEditPjOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                    <button type="button" onclick="toggleEditPjDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="editPjIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="editPjDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <div class="edit-pj-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer font-bold text-xs text-slate-500" data-id="" data-name="" data-nama="" data-hp="" onclick="selectEditPj(this)">
                        <span class="text-slate-500 italic">-- Tanpa Akun PJ Terhubung / Pilih Nanti --</span>
                    </div>
                    <?php foreach ($usersList as $u): ?>
                        <div class="edit-pj-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-name="<?= esc($u['nama_lengkap']) ?> (@<?= esc($u['username']) ?>)" data-nama="<?= esc($u['nama_lengkap']) ?>" data-hp="<?= esc($u['no_hp'] ?? '') ?>" onclick="selectEditPj(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($u['nama_lengkap']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                    <span class="text-emerald-700 font-bold">@<?= esc($u['username']) ?></span>
                                    <span>&bull;</span>
                                    <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[9px] font-extrabold border border-slate-200/80"><?= esc($u['role']) ?></span>
                                </div>
                            </div>
                            <span class="text-xs text-slate-300 group-hover:text-emerald-600"><i class="fa-solid fa-check text-[10px]"></i></span>
                        </div>
                    <?php endforeach; ?>
                    <div id="noEditPjFound" class="px-4 py-4 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan akun pengguna yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama PJ Manual</label>
                    <input type="text" id="edit_pj_nama" name="pj_nama" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">No. Kontak / WA PJ</label>
                    <input type="text" id="edit_pj_kontak" name="pj_kontak" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Operasional Unit</label>
                <select id="edit_status" name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="Aktif">Aktif</option>
                    <option value="Non-Aktif">Non-Aktif / Renovasi</option>
                </select>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEditUnit()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Kelola Tipe Unit (CRUD Master Tipe) -->
<div id="modalKelolaTipe" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center text-sm shadow-2xs">
                    <i class="fa-solid fa-tags"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Kelola Master Tipe Unit
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Tambah, ubah, atau hapus kategori / tipe unit kebersihan.</p>
                </div>
            </div>
            <button onclick="closeModalKelolaTipe()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Tambah / Edit Tipe Unit -->
        <form id="formTipeUnit" action="<?= base_url('pengaturan/tipe/store') ?>" method="POST" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
            <div class="flex items-center justify-between">
                <span id="formTipeTitle" class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-plus-circle text-emerald-600"></i> Form Tambah Tipe Unit
                </span>
                <button type="button" id="btnCancelEditTipe" onclick="resetFormTipe()" class="hidden text-[11px] font-bold text-slate-500 hover:text-slate-800 underline">
                    Batal Edit
                </button>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Nama Tipe Unit <span class="text-rose-500">*</span></label>
                    <input type="text" id="input_nama_tipe" name="nama_tipe" placeholder="Misal: Asrama Santri / Gedung Serbaguna" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Urutan</label>
                    <input type="number" id="input_urutan_tipe" name="urutan" value="0" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Keterangan Singkat (Opsional)</label>
                <input type="text" id="input_keterangan_tipe" name="keterangan" placeholder="Keterangan peruntukan tipe unit..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" id="btnSubmitTipe" class="px-5 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Tipe</span>
                </button>
            </div>
        </form>

        <!-- Tabel Daftar Tipe Unit -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Daftar Tipe Unit Tersedia</span>
                <span class="text-[11px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/80">
                    <?= count($tipeList ?? []) ?> Tipe
                </span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs max-h-60 overflow-y-auto">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200 sticky top-0 bg-white">
                        <tr>
                            <th width="8%" class="py-2.5 px-3 text-center">NO</th>
                            <th width="35%" class="py-2.5 px-4">NAMA TIPE</th>
                            <th width="40%" class="py-2.5 px-4">KETERANGAN</th>
                            <th width="17%" class="py-2.5 px-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($tipeList)): ?>
                            <?php foreach ($tipeList as $idx => $tp): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3 px-4 font-extrabold text-slate-900">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/80 text-xs shadow-2xs">
                                            <i class="fa-solid fa-tag text-emerald-600 text-[10px]"></i>
                                            <?= esc($tp['nama_tipe']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-500 font-medium text-[11px]">
                                        <?= esc($tp['keterangan'] ?: '-') ?>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" onclick="editTipeItem(<?= htmlspecialchars(json_encode($tp)) ?>)" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 border border-slate-200/70 flex items-center justify-center transition shadow-2xs" title="Edit Tipe">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </button>
                                            <a href="<?= base_url('pengaturan/tipe/delete/' . $tp['id']) ?>" data-confirm-msg="Hapus tipe '<?= esc($tp['nama_tipe']) ?>'?" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/70 flex items-center justify-center transition shadow-2xs" title="Hapus Tipe">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 font-medium italic">Belum ada data tipe unit.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-3 flex justify-end border-t border-slate-100">
            <button type="button" onclick="closeModalKelolaTipe()" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Kelola Kategori Alat di Pengaturan -->
<div id="modalKelolaKategoriPengaturan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-teal-100/80 text-teal-700 flex items-center justify-center text-sm shadow-2xs">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Kelola Kategori Alat Kebersihan
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Tambah, ubah nama, atau hapus kategori kelompok peralatan inventaris.</p>
                </div>
            </div>
            <button onclick="closeModalKelolaKategoriPengaturan()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Tambah / Edit Kategori Alat -->
        <form id="formKategoriAlatPengaturan" action="<?= base_url('pengaturan/kategori-alat/store') ?>" method="POST" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
            <div class="flex items-center justify-between">
                <span id="formKategoriAlatTitle" class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-plus-circle text-teal-600"></i> Form Tambah Kategori Alat
                </span>
                <button type="button" id="btnCancelEditKategoriAlat" onclick="resetFormKategoriAlat()" class="hidden text-[11px] font-bold text-slate-500 hover:text-slate-800 underline">
                    Batal Edit
                </button>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" id="input_nama_kategori_p" name="nama_kategori" placeholder="Misal: Sapu & Pel / Wadah Sampah / Mesin" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Urutan</label>
                    <input type="number" id="input_urutan_kategori_p" name="urutan" value="0" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1">Keterangan Singkat (Opsional)</label>
                <input type="text" id="input_keterangan_kategori_p" name="keterangan" placeholder="Keterangan peruntukan kelompok alat..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" id="btnSubmitKategoriAlat" class="px-5 py-2 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-heading font-extrabold text-xs hover:from-teal-700 hover:to-emerald-700 transition shadow-md shadow-teal-600/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>

        <!-- Tabel Daftar Kategori Alat -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Daftar Kategori Tersedia</span>
                <span class="text-[11px] font-extrabold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-full border border-teal-200/80">
                    <?= count($kategoriAlatList ?? []) ?> Kategori
                </span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs max-h-60 overflow-y-auto">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200 sticky top-0 bg-white">
                        <tr>
                            <th width="8%" class="py-2.5 px-3 text-center">NO</th>
                            <th width="35%" class="py-2.5 px-4">NAMA KATEGORI</th>
                            <th width="40%" class="py-2.5 px-4">KETERANGAN</th>
                            <th width="17%" class="py-2.5 px-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($kategoriAlatList)): ?>
                            <?php foreach ($kategoriAlatList as $idx => $kat): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3 px-4 font-extrabold text-slate-900">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-teal-50 text-teal-800 border border-teal-200/80 text-xs shadow-2xs">
                                            <i class="fa-solid fa-layer-group text-teal-600 text-[10px]"></i>
                                            <?= esc($kat['nama_kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-500 font-medium text-[11px]">
                                        <?= esc($kat['keterangan'] ?: '-') ?>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" onclick="editKategoriAlatItem(<?= htmlspecialchars(json_encode($kat)) ?>)" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:text-teal-700 hover:bg-teal-50 border border-slate-200/70 flex items-center justify-center transition shadow-2xs" title="Edit Kategori">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </button>
                                            <a href="<?= base_url('pengaturan/kategori-alat/delete/' . $kat['id']) ?>" data-confirm-msg="Hapus kategori '<?= esc($kat['nama_kategori']) ?>'?" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/70 flex items-center justify-center transition shadow-2xs" title="Hapus Kategori">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 font-medium italic">Belum ada data kategori alat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-3 flex justify-end border-t border-slate-100">
            <button type="button" onclick="closeModalKelolaKategoriPengaturan()" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition">Tutup</button>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all content panels
        const panels = document.querySelectorAll('.tab-content-panel');
        panels.forEach(p => p.classList.add('hidden'));

        // Reset button styles to inactive LPJ style
        const btns = document.querySelectorAll('.tab-nav-btn');
        btns.forEach(b => {
            b.classList.remove('bg-gradient-to-r', 'from-emerald-600', 'to-teal-600', 'text-white', 'shadow-md', 'shadow-emerald-600/20');
            b.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
        });

        // Show target panel
        const targetPanel = document.getElementById('tab-content-' + tabName);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        // Highlight active button in LPJ active gradient style
        const activeBtn = document.getElementById('tab-btn-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
            activeBtn.classList.add('bg-gradient-to-r', 'from-emerald-600', 'to-teal-600', 'text-white', 'shadow-md', 'shadow-emerald-600/20');
        }

        // Save active tab in URL and sessionStorage
        try {
            sessionStorage.setItem('activeTab_pengaturan', tabName);
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabName);
            window.history.replaceState(null, '', url.toString());
        } catch (e) {}
    }
    window.switchTab = switchTab;

    function rebindPageEvents() {
        try {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            const savedTab = sessionStorage.getItem('activeTab_pengaturan');
            const activeTab = tabParam || savedTab || '<?= esc($activeTab ?? 'general') ?>' || 'general';
            if (typeof switchTab === 'function' && activeTab && document.getElementById('tab-btn-' + activeTab)) {
                switchTab(activeTab);
            }

            // Initialize Unit Pagination
            if (typeof initUnitPagination === 'function') {
                initUnitPagination();
            }
        } catch (e) {}
    }
    window.rebindPageEvents = rebindPageEvents;

    // ==========================================
    // UNIT TABLE PAGINATION & FILTER LOGIC
    // ==========================================
    var unitCurrentPage = 1;
    var unitPerPage = 10;
    var filteredUnitRows = [];

    function initUnitPagination() {
        const rows = Array.from(document.querySelectorAll('#unitTableBody .unit-row'));
        filteredUnitRows = rows;
        unitCurrentPage = 1;
        renderUnitTablePage();
    }
    window.initUnitPagination = initUnitPagination;

    function filterUnitTable() {
        const query = (document.getElementById('unitSearchInput')?.value || '').toLowerCase().trim();
        const tipeFilter = (document.getElementById('unitTipeFilter')?.value || '').toLowerCase().trim();
        const rows = Array.from(document.querySelectorAll('#unitTableBody .unit-row'));

        filteredUnitRows = rows.filter(row => {
            const nama = row.getAttribute('data-nama') || '';
            const kode = row.getAttribute('data-kode') || '';
            const tipe = row.getAttribute('data-tipe') || '';
            const pj   = row.getAttribute('data-pj') || '';

            const matchQuery = !query || nama.includes(query) || kode.includes(query) || tipe.includes(query) || pj.includes(query);
            const matchTipe  = !tipeFilter || tipe.includes(tipeFilter);

            return matchQuery && matchTipe;
        });

        unitCurrentPage = 1;
        renderUnitTablePage();
    }
    window.filterUnitTable = filterUnitTable;

    function changeUnitPerPage(val) {
        unitPerPage = val === 'all' ? 999999 : parseInt(val, 10);
        unitCurrentPage = 1;
        renderUnitTablePage();
    }
    window.changeUnitPerPage = changeUnitPerPage;

    function renderUnitTablePage() {
        const allRows = Array.from(document.querySelectorAll('#unitTableBody .unit-row'));
        const total = filteredUnitRows.length;
        const totalPages = Math.max(1, Math.ceil(total / unitPerPage));

        if (unitCurrentPage > totalPages) unitCurrentPage = totalPages;
        if (unitCurrentPage < 1) unitCurrentPage = 1;

        const startIndex = (unitCurrentPage - 1) * unitPerPage;
        const endIndex   = Math.min(startIndex + unitPerPage, total);

        // Hide all rows initially
        allRows.forEach(r => r.classList.add('hidden'));

        // Show only active page's rows & update row number
        filteredUnitRows.slice(startIndex, endIndex).forEach((row, i) => {
            row.classList.remove('hidden');
            const noCell = row.querySelector('.unit-row-no');
            if (noCell) noCell.innerText = startIndex + i + 1;
        });

        // Update footer info
        const pageStartEl = document.getElementById('unitPageStart');
        const pageEndEl   = document.getElementById('unitPageEnd');
        const totalCountEl= document.getElementById('unitTotalCount');

        if (pageStartEl) pageStartEl.innerText = total > 0 ? (startIndex + 1) : 0;
        if (pageEndEl)   pageEndEl.innerText   = endIndex;
        if (totalCountEl)totalCountEl.innerText= total;

        // Render Pagination buttons
        renderUnitPaginationButtons(totalPages);
    }
    window.renderUnitTablePage = renderUnitTablePage;

    function renderUnitPaginationButtons(totalPages) {
        const container = document.getElementById('unitPaginationContainer');
        if (!container) return;

        if (totalPages <= 1) {
            container.innerHTML = '';
            return;
        }

        let html = '';

        // Prev button
        html += `
            <button type="button" onclick="goToUnitPage(${unitCurrentPage - 1})" ${unitCurrentPage === 1 ? 'disabled class="w-8 h-8 rounded-xl bg-slate-100 text-slate-300 flex items-center justify-center text-xs cursor-not-allowed"' : 'class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center text-xs font-bold transition shadow-2xs cursor-pointer"'}>
                <i class="fa-solid fa-chevron-left"></i>
            </button>
        `;

        // Numeric page buttons
        let startPage = Math.max(1, unitCurrentPage - 2);
        let endPage   = Math.min(totalPages, unitCurrentPage + 2);

        if (startPage > 1) {
            html += `<button type="button" onclick="goToUnitPage(1)" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center text-xs font-bold transition shadow-2xs">1</button>`;
            if (startPage > 2) {
                html += `<span class="px-1 text-slate-400 text-xs font-bold">...</span>`;
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            if (p === unitCurrentPage) {
                html += `<button type="button" class="w-8 h-8 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white flex items-center justify-center text-xs font-extrabold shadow-md shadow-emerald-600/20">${p}</button>`;
            } else {
                html += `<button type="button" onclick="goToUnitPage(${p})" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center text-xs font-bold transition shadow-2xs">${p}</button>`;
            }
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += `<span class="px-1 text-slate-400 text-xs font-bold">...</span>`;
            }
            html += `<button type="button" onclick="goToUnitPage(${totalPages})" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center text-xs font-bold transition shadow-2xs">${totalPages}</button>`;
        }

        // Next button
        html += `
            <button type="button" onclick="goToUnitPage(${unitCurrentPage + 1})" ${unitCurrentPage === totalPages ? 'disabled class="w-8 h-8 rounded-xl bg-slate-100 text-slate-300 flex items-center justify-center text-xs cursor-not-allowed"' : 'class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center text-xs font-bold transition shadow-2xs cursor-pointer"'}>
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        `;

        container.innerHTML = html;
    }
    window.renderUnitPaginationButtons = renderUnitPaginationButtons;

    function goToUnitPage(page) {
        unitCurrentPage = page;
        renderUnitTablePage();
    }
    window.goToUnitPage = goToUnitPage;

    const allUsersDataPengaturan = <?= json_encode(array_map(function($u) {
        return [
            'id' => (string)$u['id'],
            'nama_lengkap' => $u['nama_lengkap'],
            'username' => $u['username'],
            'role' => $u['role'],
            'no_hp' => $u['no_hp'] ?? ''
        ];
    }, $usersList ?? [])) ?>;

    function openModalTambahUnit() {
        const idEl = document.getElementById('add_pj_user_id');
        if (idEl) idEl.value = '';
        const searchEl = document.getElementById('add_pj_user_search');
        if (searchEl) searchEl.value = '';
        filterAddPjOptions('');
        closeAddPjDropdown();
        const modal = document.getElementById('modalTambahUnit');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalTambahUnit = openModalTambahUnit;

    function closeModalTambahUnit() {
        const modal = document.getElementById('modalTambahUnit');
        if (modal) modal.classList.add('hidden');
        closeAddPjDropdown();
    }
    window.closeModalTambahUnit = closeModalTambahUnit;

    function openModalEditUnit(unit) {
        const form = document.getElementById('formEditUnit');
        if (form) form.action = "<?= base_url('pengaturan/unit/update/') ?>" + unit.id;
        const namaEl = document.getElementById('edit_nama_unit');
        if (namaEl) namaEl.value = unit.nama_unit || '';
        const tipeEl = document.getElementById('edit_tipe');
        if (tipeEl) tipeEl.value = unit.tipe || 'Asrama Santri';
        const kodeEl = document.getElementById('edit_kode_unit');
        if (kodeEl) kodeEl.value = unit.kode_unit || '';
        
        // Populate PJ user in Searchable picker
        const pjUserEl = document.getElementById('edit_pj_user_id');
        const pjSearchEl = document.getElementById('edit_pj_user_search');
        if (pjUserEl) pjUserEl.value = unit.pj_user_id || '';
        
        if (pjSearchEl) {
            if (unit.pj_user_id) {
                const found = allUsersDataPengaturan.find(u => u.id == unit.pj_user_id);
                if (found) {
                    pjSearchEl.value = `${found.nama_lengkap} (@${found.username})`;
                } else if (unit.pj_nama) {
                    pjSearchEl.value = unit.pj_nama;
                } else {
                    pjSearchEl.value = '';
                }
            } else {
                pjSearchEl.value = '';
            }
        }
        filterEditPjOptions('');
        closeEditPjDropdown();

        const pjNamaEl = document.getElementById('edit_pj_nama');
        if (pjNamaEl) pjNamaEl.value = unit.pj_nama || '';
        const pjKontakEl = document.getElementById('edit_pj_kontak');
        if (pjKontakEl) pjKontakEl.value = unit.pj_kontak || '';
        const statEl = document.getElementById('edit_status');
        if (statEl) statEl.value = unit.status || 'Aktif';
        const adaKaderEl = document.getElementById('edit_ada_kader');
        if (adaKaderEl) adaKaderEl.value = unit.ada_kader || 'Ya';
        const jnsKaderEl = document.getElementById('edit_jenis_kader');
        if (jnsKaderEl) jnsKaderEl.value = unit.jenis_kader || 'Gemerlap';

        const modal = document.getElementById('modalEditUnit');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalEditUnit = openModalEditUnit;

    function closeModalEditUnit() {
        const modal = document.getElementById('modalEditUnit');
        if (modal) modal.classList.add('hidden');
        closeEditPjDropdown();
    }
    window.closeModalEditUnit = closeModalEditUnit;

    // Searchable PJ Picker Functions for Tambah Unit
    function openAddPjDropdown() {
        const list = document.getElementById('addPjDropdownList');
        const icon = document.getElementById('addPjIcon');
        if (list) list.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openAddPjDropdown = openAddPjDropdown;

    function closeAddPjDropdown() {
        const list = document.getElementById('addPjDropdownList');
        const icon = document.getElementById('addPjIcon');
        if (list) list.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.closeAddPjDropdown = closeAddPjDropdown;

    function toggleAddPjDropdown() {
        const list = document.getElementById('addPjDropdownList');
        if (list && list.classList.contains('hidden')) {
            openAddPjDropdown();
        } else {
            closeAddPjDropdown();
        }
    }
    window.toggleAddPjDropdown = toggleAddPjDropdown;

    function filterAddPjOptions(val) {
        val = (val || '').toLowerCase().trim();
        const items = document.querySelectorAll('.add-pj-item');
        let visibleCount = 0;
        items.forEach(item => {
            const id = item.getAttribute('data-id');
            if (!id) {
                item.style.display = 'flex';
                return;
            }
            const text = item.innerText.toLowerCase();
            if (!val || text.includes(val)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noAddPjFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0 || !val);
        }
        openAddPjDropdown();
    }
    window.filterAddPjOptions = filterAddPjOptions;

    function selectAddPj(el) {
        const id = el.getAttribute('data-id') || '';
        const name = el.getAttribute('data-name') || '';
        const nama = el.getAttribute('data-nama') || '';
        const hp = el.getAttribute('data-hp') || '';

        const idEl = document.getElementById('add_pj_user_id');
        const searchEl = document.getElementById('add_pj_user_search');
        if (idEl) idEl.value = id;
        if (searchEl) searchEl.value = name;

        // Auto-fill manual PJ inputs if empty
        const form = document.getElementById('modalTambahUnit');
        if (form) {
            const pjNamaInput = form.querySelector('input[name="pj_nama"]');
            const pjKontakInput = form.querySelector('input[name="pj_kontak"]');
            if (pjNamaInput && nama && (!pjNamaInput.value || pjNamaInput.value.trim() === '')) {
                pjNamaInput.value = nama;
            }
            if (pjKontakInput && hp && (!pjKontakInput.value || pjKontakInput.value.trim() === '')) {
                pjKontakInput.value = hp;
            }
        }
        closeAddPjDropdown();
    }
    window.selectAddPj = selectAddPj;

    // Searchable PJ Picker Functions for Edit Unit
    function openEditPjDropdown() {
        const list = document.getElementById('editPjDropdownList');
        const icon = document.getElementById('editPjIcon');
        if (list) list.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openEditPjDropdown = openEditPjDropdown;

    function closeEditPjDropdown() {
        const list = document.getElementById('editPjDropdownList');
        const icon = document.getElementById('editPjIcon');
        if (list) list.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.closeEditPjDropdown = closeEditPjDropdown;

    function toggleEditPjDropdown() {
        const list = document.getElementById('editPjDropdownList');
        if (list && list.classList.contains('hidden')) {
            openEditPjDropdown();
        } else {
            closeEditPjDropdown();
        }
    }
    window.toggleEditPjDropdown = toggleEditPjDropdown;

    function filterEditPjOptions(val) {
        val = (val || '').toLowerCase().trim();
        const items = document.querySelectorAll('.edit-pj-item');
        let visibleCount = 0;
        items.forEach(item => {
            const id = item.getAttribute('data-id');
            if (!id) {
                item.style.display = 'flex';
                return;
            }
            const text = item.innerText.toLowerCase();
            if (!val || text.includes(val)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noEditPjFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0 || !val);
        }
        openEditPjDropdown();
    }
    window.filterEditPjOptions = filterEditPjOptions;

    function selectEditPj(el) {
        const id = el.getAttribute('data-id') || '';
        const name = el.getAttribute('data-name') || '';
        const nama = el.getAttribute('data-nama') || '';
        const hp = el.getAttribute('data-hp') || '';

        const idEl = document.getElementById('edit_pj_user_id');
        const searchEl = document.getElementById('edit_pj_user_search');
        if (idEl) idEl.value = id;
        if (searchEl) searchEl.value = name;

        // Auto-fill manual PJ inputs if empty
        const pjNamaInput = document.getElementById('edit_pj_nama');
        const pjKontakInput = document.getElementById('edit_pj_kontak');
        if (pjNamaInput && nama && (!pjNamaInput.value || pjNamaInput.value.trim() === '')) {
            pjNamaInput.value = nama;
        }
        if (pjKontakInput && hp && (!pjKontakInput.value || pjKontakInput.value.trim() === '')) {
            pjKontakInput.value = hp;
        }
        closeEditPjDropdown();
    }
    window.selectEditPj = selectEditPj;

    // Close searchable dropdowns on outside click
    document.addEventListener('click', function(e) {
        const addPjContainer = document.getElementById('add_pj_user_search')?.closest('.relative');
        if (addPjContainer && !addPjContainer.contains(e.target)) {
            closeAddPjDropdown();
        }
        const editPjContainer = document.getElementById('edit_pj_user_search')?.closest('.relative');
        if (editPjContainer && !editPjContainer.contains(e.target)) {
            closeEditPjDropdown();
        }
    });

    function openModalKelolaTipe() {
        resetFormTipe();
        const modal = document.getElementById('modalKelolaTipe');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalKelolaTipe = openModalKelolaTipe;

    function closeModalKelolaTipe() {
        const modal = document.getElementById('modalKelolaTipe');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalKelolaTipe = closeModalKelolaTipe;

    function editTipeItem(tipe) {
        const form = document.getElementById('formTipeUnit');
        if (form) form.action = "<?= base_url('pengaturan/tipe/update/') ?>" + tipe.id;
        const namaEl = document.getElementById('input_nama_tipe');
        if (namaEl) namaEl.value = tipe.nama_tipe || '';
        const ketEl = document.getElementById('input_keterangan_tipe');
        if (ketEl) ketEl.value = tipe.keterangan || '';
        const urutEl = document.getElementById('input_urutan_tipe');
        if (urutEl) urutEl.value = tipe.urutan || 0;
        
        const titleEl = document.getElementById('formTipeTitle');
        if (titleEl) titleEl.innerHTML = '<i class="fa-solid fa-pen-to-square text-amber-600"></i> Form Edit Tipe Unit';
        const btnSubmit = document.getElementById('btnSubmitTipe');
        if (btnSubmit) btnSubmit.innerHTML = '<i class="fa-solid fa-save"></i><span>Simpan Perubahan</span>';
        const btnCancel = document.getElementById('btnCancelEditTipe');
        if (btnCancel) btnCancel.classList.remove('hidden');
        if (namaEl) namaEl.focus();
    }
    window.editTipeItem = editTipeItem;

    function resetFormTipe() {
        const form = document.getElementById('formTipeUnit');
        if (form) form.action = "<?= base_url('pengaturan/tipe/store') ?>";
        const namaEl = document.getElementById('input_nama_tipe');
        if (namaEl) namaEl.value = '';
        const ketEl = document.getElementById('input_keterangan_tipe');
        if (ketEl) ketEl.value = '';
        const urutEl = document.getElementById('input_urutan_tipe');
        if (urutEl) urutEl.value = '0';

        const titleEl = document.getElementById('formTipeTitle');
        if (titleEl) titleEl.innerHTML = '<i class="fa-solid fa-plus-circle text-emerald-600"></i> Form Tambah Tipe Unit';
        const btnSubmit = document.getElementById('btnSubmitTipe');
        if (btnSubmit) btnSubmit.innerHTML = '<i class="fa-solid fa-save"></i><span>Simpan Tipe</span>';
        const btnCancel = document.getElementById('btnCancelEditTipe');
        if (btnCancel) btnCancel.classList.add('hidden');
    }
    window.resetFormTipe = resetFormTipe;

    function openModalKelolaKategoriPengaturan() {
        resetFormKategoriAlat();
        const modal = document.getElementById('modalKelolaKategoriPengaturan');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalKelolaKategoriPengaturan = openModalKelolaKategoriPengaturan;

    function closeModalKelolaKategoriPengaturan() {
        const modal = document.getElementById('modalKelolaKategoriPengaturan');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalKelolaKategoriPengaturan = closeModalKelolaKategoriPengaturan;

    function editKategoriAlatItem(kat) {
        const form = document.getElementById('formKategoriAlatPengaturan');
        if (form) form.action = "<?= base_url('pengaturan/kategori-alat/update/') ?>" + kat.id;
        const namaEl = document.getElementById('input_nama_kategori_p');
        if (namaEl) namaEl.value = kat.nama_kategori || '';
        const ketEl = document.getElementById('input_keterangan_kategori_p');
        if (ketEl) ketEl.value = kat.keterangan || '';
        const urutEl = document.getElementById('input_urutan_kategori_p');
        if (urutEl) urutEl.value = kat.urutan || 0;
        
        const titleEl = document.getElementById('formKategoriAlatTitle');
        if (titleEl) titleEl.innerHTML = '<i class="fa-solid fa-pen-to-square text-amber-600"></i> Form Edit Kategori Alat';
        const btnSubmit = document.getElementById('btnSubmitKategoriAlat');
        if (btnSubmit) btnSubmit.innerHTML = '<i class="fa-solid fa-save"></i><span>Simpan Perubahan</span>';
        const btnCancel = document.getElementById('btnCancelEditKategoriAlat');
        if (btnCancel) btnCancel.classList.remove('hidden');
        if (namaEl) namaEl.focus();
    }
    window.editKategoriAlatItem = editKategoriAlatItem;

    function resetFormKategoriAlat() {
        const form = document.getElementById('formKategoriAlatPengaturan');
        if (form) form.action = "<?= base_url('pengaturan/kategori-alat/store') ?>";
        const namaEl = document.getElementById('input_nama_kategori_p');
        if (namaEl) namaEl.value = '';
        const ketEl = document.getElementById('input_keterangan_kategori_p');
        if (ketEl) ketEl.value = '';
        const urutEl = document.getElementById('input_urutan_kategori_p');
        if (urutEl) urutEl.value = '0';

        const titleEl = document.getElementById('formKategoriAlatTitle');
        if (titleEl) titleEl.innerHTML = '<i class="fa-solid fa-plus-circle text-teal-600"></i> Form Tambah Kategori Alat';
        const btnSubmit = document.getElementById('btnSubmitKategoriAlat');
        if (btnSubmit) btnSubmit.innerHTML = '<i class="fa-solid fa-save"></i><span>Simpan Kategori</span>';
        const btnCancel = document.getElementById('btnCancelEditKategoriAlat');
        if (btnCancel) btnCancel.classList.add('hidden');
    }
    window.resetFormKategoriAlat = resetFormKategoriAlat;

    // Auto activate tab on initial page load
    document.addEventListener("DOMContentLoaded", function() {
        const activeTab = "<?= esc($activeTab ?? 'general') ?>";
        switchTab(activeTab);
    });
    // Also run immediately
    rebindPageEvents();
</script>
<?= $this->endSection() ?>
