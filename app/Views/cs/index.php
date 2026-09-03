<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

<?php 
    $userRole = session()->get('role');
    $isAuditor = ($userRole === 'Auditor');
    $isAdmin   = ($userRole === 'Admin');
?>

<?php if (!$isUserAdminOrAuditor || $isAuditor): ?>
    <!-- ========================================== -->
    <!-- 🌐 TAMPILAN FORM CS (PUBLIK & AUDITOR)     -->
    <!-- ========================================== -->
    <!-- Hero Banner / Page Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-6 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-headset text-[160px] sm:text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
            <div class="space-y-2 max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-headset"></i> Layanan Pengaduan Kebersihan 24/7
                </span>
                <h1 class="text-2xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Customer Service & Lapor Kebersihan
                </h1>
                <p class="text-emerald-100/90 text-xs sm:text-base leading-relaxed">
                    Silakan sampaikan kendala kebersihan atau pertanyaan seputar kebersihan pesantren. Tim Kebersihan siap membantu.
                </p>
            </div>
        </div>
    </div>

    <!-- Public Contact Grid & Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Pengaduan Publik (Anti-SPAM CAPTCHA) -->
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-emerald-600"></i> Form Lapor Kendala Kebersihan
                </h3>
                <span class="text-[10px] font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Terverifikasi Anti-SPAM
                </span>
            </div>

            <form action="<?= base_url('cs/public/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 allow-auditor" id="formLaporCsPublic">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Pengirim</label>
                        <input type="text" name="nama_pengirim" value="<?= esc(session()->get('nama_lengkap') ?? '') ?>" placeholder="Misal: Santri / Pengurus / Warga" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP</label>
                        <input type="text" name="kontak_hp" placeholder="081234567890" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Searchable Unit Picker in CS Form -->
                    <div class="relative">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>1. Lokasi / Unit Terkait</span>
                            <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                            </span>
                        </label>
                        <input type="hidden" id="cs_unit_id" name="unit_id" value="">
                        <input type="hidden" id="cs_unit_lokasi" name="unit_lokasi" required value="">
                        <div class="relative">
                            <i class="fa-solid fa-building text-emerald-600 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs pointer-events-none"></i>
                            <input type="text" id="cs_unit_search" placeholder="Pilih unit / asrama terkait..." autocomplete="off" required onfocus="openCsUnitDropdown()" oninput="filterCsUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                            <button type="button" onclick="toggleCsUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                <i id="csUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                            </button>
                        </div>
                        <!-- Dropdown List -->
                        <div id="csUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                            <?php if (!empty($unitList)): ?>
                                <?php foreach ($unitList as $u): ?>
                                    <div class="cs-unit-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['nama_unit']) ?>" onclick="selectCsUnit(this)">
                                        <div>
                                            <div class="font-extrabold text-xs text-slate-900"><?= esc($u['nama_unit']) ?></div>
                                            <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-bold border border-slate-200/60"><?= esc($u['tipe']) ?></span>
                                                <?php if (!empty($u['kode_unit'])): ?>
                                                    <span>&bull;</span>
                                                    <span class="font-mono text-slate-400"><?= esc($u['kode_unit']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-300 group-hover:text-emerald-600"><i class="fa-solid fa-check text-[10px]"></i></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium">
                                    Belum ada data unit aktif.
                                </div>
                            <?php endif; ?>
                            <div id="noCsUnitFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                Tidak ditemukan unit yang sesuai.
                            </div>
                        </div>
                    </div>

                    <!-- Searchable Wilayah Picker in CS Form -->
                    <div class="relative">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>2. Wilayah Pemetaan</span>
                            <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                <i class="fa-solid fa-filter text-[9px]"></i> Sesuai Unit
                            </span>
                        </label>
                        <input type="hidden" id="cs_wilayah_id" name="wilayah_id" value="">
                        <div class="relative">
                            <i class="fa-solid fa-map-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                            <input type="text" id="cs_wilayah_search" placeholder="Pilih unit terlebih dahulu..." autocomplete="off" onclick="openCsWilayahDropdown()" onfocus="openCsWilayahDropdown()" oninput="filterCsWilayahOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                            <button type="button" onclick="toggleCsWilayahDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                <i id="csWilayahIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                            </button>
                        </div>
                        <!-- Dropdown List -->
                        <div id="csWilayahDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                            <div class="cs-wilayah-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="" data-name="" data-lokasi-gedung="" onclick="selectCsWilayah(this)">
                                <div>
                                    <div class="font-extrabold text-xs text-slate-600 italic">-- Bukan Wilayah Khusus / Umum --</div>
                                    <div class="text-[10px] text-slate-400 font-medium">Laporan umum lingkungan unit (tanpa spot wilayah khusus)</div>
                                </div>
                            </div>
                            <?php if (!empty($wilayahList)): ?>
                                <?php foreach ($wilayahList as $w): ?>
                                    <div class="cs-wilayah-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $w['id'] ?>" data-name="<?= esc($w['nama_wilayah']) ?>" data-lokasi-gedung="<?= esc(strtolower($w['lokasi_gedung'] ?? '')) ?>" onclick="selectCsWilayah(this)">
                                        <div>
                                            <div class="font-extrabold text-xs text-slate-900"><?= esc($w['nama_wilayah']) ?></div>
                                            <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                                <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 font-bold border border-emerald-200/60"><?= esc($w['kategori_area']) ?></span>
                                                <?php if (!empty($w['lokasi_gedung'])): ?>
                                                    <span>&bull;</span>
                                                    <span><i class="fa-solid fa-location-dot text-rose-500 mr-0.5"></i><?= esc($w['lokasi_gedung']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-mono font-bold text-slate-400"><?= esc($w['kode_wilayah'] ?: 'WIL-' . $w['id']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div id="noCsWilayahFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                Tidak ada spot wilayah pemetaan di unit ini.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Step 3: Shift Selection with Smart PJ Routing (Revealed once Wilayah is picked) -->
                <div id="csPublicShiftContainer" class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2.5 hidden animate-fadeIn">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-emerald-950 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-emerald-600"></i>
                            <span>3. Pilih Shift & Penanggung Jawab Terkait</span>
                        </label>
                        <span id="csShiftAutoBadge" class="text-[10px] text-emerald-700 bg-white px-2.5 py-0.5 rounded-full border border-emerald-200 font-bold flex items-center gap-1 shadow-2xs">
                            <i class="fa-solid fa-wand-magic-sparkles text-[9px]"></i> Rekomendasi Waktu
                        </span>
                    </div>
                    <select id="cs_public_shift" name="shift" onchange="onPublicShiftChange(this)" class="w-full px-4 py-2.5 rounded-xl border border-emerald-300 text-xs font-bold bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                        <!-- Populated dynamically via JS -->
                    </select>
                    <div id="csShiftInfoPj" class="text-[11px] text-emerald-900 font-semibold flex items-center gap-1.5 pt-0.5">
                        <i class="fa-solid fa-shield-halved text-emerald-600 text-xs"></i>
                        <span>Laporan akan otomatis diteruskan ke Penanggung Jawab: <b id="csTargetUnitName" class="text-emerald-950 underline font-extrabold">-</b></span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Pengaduan</label>
                    <select name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Kendala Kebersihan">Kendala Kebersihan / Sampah Penuh</option>
                        <option value="Fasilitas Rusak">Fasilitas Tempat Kebersihan Rusak</option>
                        <option value="Pertanyaan/Konsultasi">Pertanyaan / Konsultasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Isi Pesan Laporan / Pengaduan</label>
                    <textarea name="isi_laporan" rows="4" placeholder="Jelaskan kendala kebersihan atau hal yang ingin disampaikan ke Admin Kebersihan..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                </div>

                <!-- Multiple Photo Upload with Separate Camera & Gallery Buttons and Delete Feature -->
                <div class="space-y-3 p-4 rounded-2xl bg-slate-50/90 border border-slate-200">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-camera-retro text-emerald-600"></i>
                            <span>Foto Bukti / Lokasi Kendala</span>
                        </label>
                        <span class="text-[10px] text-slate-500 font-medium">Bisa lebih dari 1 foto</span>
                    </div>

                    <!-- Hidden Inputs for Camera and Gallery -->
                    <input type="file" id="publicCameraInput" accept="image/*" capture="environment" class="hidden" onchange="handlePublicFiles(this.files)">
                    <input type="file" id="publicGalleryInput" accept="image/*" multiple class="hidden" onchange="handlePublicFiles(this.files)">
                    <!-- Real Form File Input Container managed by DataTransfer -->
                    <input type="file" id="publicRealInput" name="foto_files[]" multiple class="hidden">

                    <!-- Action Buttons: Kamera & Galeri -->
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" onclick="document.getElementById('publicCameraInput').click()" class="py-3 px-4 rounded-2xl bg-white hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-400 text-slate-700 hover:text-emerald-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <span>Buka Kamera</span>
                        </button>

                        <button type="button" onclick="document.getElementById('publicGalleryInput').click()" class="py-3 px-4 rounded-2xl bg-white hover:bg-teal-50/80 border border-slate-200 hover:border-teal-400 text-slate-700 hover:text-teal-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                                <i class="fa-solid fa-images"></i>
                            </div>
                            <span>Pilih Galeri</span>
                        </button>
                    </div>

                    <!-- Live Thumbnail Preview Container with Delete Button -->
                    <div id="publicFotoPreviewContainer" class="flex flex-wrap gap-3 pt-2 hidden border-t border-slate-200/70"></div>
                </div>

                <!-- Anti-SPAM Security Verification Code -->
                <div class="p-4 rounded-2xl bg-slate-100/90 border border-slate-200 space-y-2">
                    <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        <i class="fa-solid fa-robot text-emerald-600 mr-1"></i> Verifikasi Keamanan Anti-SPAM
                    </label>
                    <div class="flex items-center gap-3">
                        <div class="px-4 py-2 rounded-xl bg-white border border-slate-300 font-mono font-extrabold text-sm text-emerald-800 shadow-inner">
                            Berapa <?= esc($captcha_num1) ?> + <?= esc($captcha_num2) ?> = ?
                        </div>
                        <input type="number" name="captcha_user" placeholder="Jawaban..." required class="w-32 px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    </div>
                    <p class="text-[10px] text-slate-500 font-medium">Jawab pertanyaan penjumlahan matematika sederhana di atas untuk membuktikan Anda bukan bot spam.</p>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 allow-auditor">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pengaduan Ke Tim CS Kebersihan</span>
                </button>
            </form>
        </div>

        <!-- Quick Contacts Column -->
        <div class="space-y-5">
            <div class="glass-card rounded-3xl p-6 shadow-xl border border-slate-200/80 bg-white space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-500/20">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="font-heading font-extrabold text-base text-slate-900">WhatsApp Live CS</h3>
                    <p class="text-xs text-slate-500 font-medium">Layanan respon instan via WA Admin Kebersihan.</p>
                </div>
                <?php
                    $rawWa = $settings['hotline_wa'] ?? '081802787499';
                    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
                    if (str_starts_with($cleanWa, '0')) {
                        $cleanWa = '62' . substr($cleanWa, 1);
                    }
                ?>
                <a href="https://wa.me/<?= $cleanWa ?>?text=Halo%20Admin%20Kebersihan,%20saya%20butuh%20bantuan" target="_blank" class="w-full py-3 rounded-2xl bg-emerald-600 text-white font-heading font-extrabold text-xs hover:bg-emerald-700 transition flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Chat WhatsApp CS</span>
                </a>
            </div>

            <div class="glass-card rounded-3xl p-6 shadow-xl border border-slate-200/80 bg-white space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl shadow-lg shadow-teal-500/20">
                    <i class="fa-solid fa-building-flag"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="font-heading font-extrabold text-base text-slate-900">Kantor Sekretariat</h3>
                    <p class="text-xs text-slate-500 font-medium">Kantor K3L Yayasan Assalafiyyah Mlangi.</p>
                </div>
                <span class="inline-block w-full py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-extrabold text-xs text-center border border-slate-200">
                    Jam Operasional: <?= esc($settings['jam_cs_buka'] ?? '06:00') ?> – <?= esc($settings['jam_cs_tutup'] ?? '21:00') ?> WIB
                </span>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($isUserAdminOrAuditor): ?>

    <!-- ========================================== -->
    <!-- 👑 TAMPILAN INBOX CS (ADMIN & AUDITOR)     -->
    <!-- ========================================== -->
    <!-- Hero Banner / Page Header (Only show for Admin if not Auditor) -->
    <?php if ($isAdmin): ?>
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-headset text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-3xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-headset"></i> Layanan Pengaduan & Permohonan
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Kelola Inbox Customer Service & Permohonan Alat
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Halaman ini khusus untuk Admin & Auditor dalam menangani laporan kendala kebersihan dari publik serta permohonan alat dari pengurus/kader.
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Admin Inbox CS Reports & Pengajuan Alat Panel -->
    <div class="space-y-8 w-full">
        <!-- Panel 1: Inbox Laporan CS Masuk -->
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3.5 flex-wrap">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20 flex-shrink-0">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-heading font-extrabold text-lg text-slate-900">
                                Inbox Laporan CS & Pengaduan Masuk
                            </h3>
                            <span class="text-[11px] font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/90 shadow-2xs whitespace-nowrap">
                                <?= count($reportsList) ?> Laporan
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Daftar keluhan & pengaduan kendala kebersihan dari publik, pengurus, dan kader.</p>
                    </div>
                </div>

                <!-- Search Input for CS Reports -->
                <div class="relative w-full sm:w-64 flex-shrink-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchCsReportsInput" onkeyup="filterCsReportsTable()" placeholder="Cari pengirim / lokasi / isi..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
                <table id="tableCsReports" class="w-full min-w-[760px] text-left text-xs font-semibold">
                    <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                        <tr>
                            <th width="4%" class="py-3.5 px-3 text-center">NO</th>
                            <th width="13%" class="py-3.5 px-4">TANGGAL</th>
                            <th width="20%" class="py-3.5 px-4">PENGIRIM & KONTAK</th>
                            <th width="15%" class="py-3.5 px-4">LOKASI / UNIT</th>
                            <th width="<?= $isAdmin ? '27%' : '37%' ?>" class="py-3.5 px-4">ISI LAPORAN & TANGGAPAN</th>
                            <th width="11%" class="py-3.5 px-4 text-center">STATUS</th>
                            <?php if ($isAdmin): ?>
                                <th width="10%" class="py-3.5 px-3 text-center">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($reportsList)): ?>
                            <?php foreach ($reportsList as $idx => $r): ?>
                                <?php 
                                    $cleanHp = preg_replace('/[^0-9]/', '', $r['kontak_hp'] ?? '');
                                    if (substr($cleanHp, 0, 1) === '0') {
                                        $cleanHp = '62' . substr($cleanHp, 1);
                                    }
                                ?>
                                <tr class="cs-report-row hover:bg-slate-50/90 transition-all">
                                    <td class="py-4 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-4 px-4 font-bold text-slate-600 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar-days text-slate-400 text-xs"></i>
                                            <span><?= date('d M Y', strtotime($r['created_at'])) ?></span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5 flex items-center gap-1">
                                            <i class="fa-regular fa-clock text-[9px]"></i>
                                            <span><?= date('H:i', strtotime($r['created_at'])) ?> WIB</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-extrabold text-xs shadow-2xs flex-shrink-0">
                                                <?= strtoupper(substr($r['nama_pengirim'] ?? 'U', 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="font-extrabold text-slate-900 text-xs"><?= esc($r['nama_pengirim']) ?></div>
                                                <?php if (!empty($r['kontak_hp'])): ?>
                                                    <a href="https://wa.me/<?= $cleanHp ?>?text=Halo%20<?= urlencode($r['nama_pengirim']) ?>,%20terkait%20laporan%20kebersihan%20Anda" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-mono text-[10px] font-bold border border-emerald-200/80 transition mt-1">
                                                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                                        <span><?= esc($r['kontak_hp']) ?></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-[10px] text-slate-400 italic">Tanpa HP</span>
                                                <?php endif; ?>
                                                <?php if (!empty($r['ip_address'])): ?>
                                                    <div class="text-[9.5px] text-slate-400 font-mono mt-0.5 flex items-center gap-1" title="Alamat IP Pengirim: <?= esc($r['ip_address']) ?>">
                                                        <i class="fa-solid fa-network-wired text-[8px]"></i> <?= esc($r['ip_address']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php 
                                            $csWil = !empty($r['nama_wilayah']) ? $r['nama_wilayah'] : '';
                                            $csUnit = !empty($r['lokasi_gedung']) ? $r['lokasi_gedung'] : (!empty($r['unit_lokasi']) ? $r['unit_lokasi'] : '');
                                            $csLokasi = $csWil ? ($csWil . ' - ' . $csUnit) : $csUnit;
                                        ?>
                                        <div class="font-extrabold text-slate-800 flex items-center gap-1.5 text-xs">
                                            <i class="fa-solid fa-location-dot text-emerald-600 text-[11px]"></i>
                                            <span><?= esc($csLokasi) ?></span>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-1 mt-1">
                                            <span class="inline-block px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-bold border border-emerald-200/70">
                                                <?= esc($r['kategori']) ?>
                                            </span>
                                            <?php if (!empty($r['shift'])): ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200/80 text-[10px] font-extrabold shadow-2xs" title="Kejadian pada Shift <?= esc($r['shift']) ?>">
                                                    <i class="fa-regular fa-clock text-amber-600 text-[9px]"></i>
                                                    <span>Shift <?= esc($r['shift']) ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                            "<?= esc($r['isi_laporan']) ?>"
                                        </div>

                                        <?php 
                                            $fotos = json_decode($r['foto_lampiran'] ?? '[]', true) ?: [];
                                        ?>
                                        <?php if (!empty($fotos)): ?>
                                            <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                                                <?php foreach ($fotos as $f): ?>
                                                    <?php 
                                                        $imgUrl = (strpos($f, 'http://') === 0 || strpos($f, 'https://') === 0) ? $f : base_url('uploads/cs/' . $f);
                                                    ?>
                                                    <a href="<?= $imgUrl ?>" target="_blank" onclick="event.stopPropagation();" class="group relative block w-10 h-10 rounded-xl overflow-hidden border border-slate-200 hover:border-emerald-500 shadow-2xs hover:scale-105 transition flex-shrink-0" title="Klik untuk perbesar foto (Cloudinary / Storage)">
                                                        <img src="<?= $imgUrl ?>" alt="Bukti Laporan" class="w-full h-full object-cover">
                                                        <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition">
                                                            <i class="fa-solid fa-magnifying-glass-plus text-[10px]"></i>
                                                        </div>
                                                    </a>
                                                <?php endforeach; ?>
                                                <span class="text-[10px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                                    <?= count($fotos) ?> Foto Bukti
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($r['tanggapan_unit'])): ?>
                                            <div class="mt-2 p-2.5 rounded-2xl bg-sky-50/90 border border-sky-200/90 text-sky-950 text-[11px] font-semibold space-y-1 shadow-2xs">
                                                <div class="font-extrabold text-sky-800 flex items-center justify-between text-[10px] uppercase tracking-wider">
                                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-building-user text-sky-600"></i> Tindak Lanjut Unit (<?= esc($r['nama_penanggap_unit'] ?: 'Pengurus') ?>):</span>
                                                    <?php if (!empty($r['ditanggapi_unit_at'])): ?>
                                                        <span class="font-mono text-[9px] text-sky-600 font-bold lowercase"><?= date('d M H:i', strtotime($r['ditanggapi_unit_at'])) ?> WIB</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="pl-4 text-slate-700 font-medium leading-relaxed"><?= esc($r['tanggapan_unit']) ?></div>
                                                <?php 
                                                    $unitFotos = json_decode($r['foto_tindakan_unit'] ?? '[]', true) ?: [];
                                                ?>
                                                <?php if (!empty($unitFotos)): ?>
                                                    <div class="pl-4 pt-1 flex flex-wrap items-center gap-1.5">
                                                        <?php foreach ($unitFotos as $uf): ?>
                                                            <?php $ufUrl = (strpos($uf, 'http://') === 0 || strpos($uf, 'https://') === 0) ? $uf : base_url('uploads/cs/' . $uf); ?>
                                                            <a href="<?= $ufUrl ?>" target="_blank" onclick="event.stopPropagation();" class="w-8 h-8 rounded-lg overflow-hidden border border-sky-200 hover:scale-105 transition shadow-2xs" title="Foto bukti tindakan unit">
                                                                <img src="<?= $ufUrl ?>" class="w-full h-full object-cover">
                                                            </a>
                                                        <?php endforeach; ?>
                                                        <span class="text-[9px] font-extrabold text-sky-700 bg-white px-1.5 py-0.5 rounded border border-sky-200">
                                                            <?= count($unitFotos) ?> Foto Bukti Unit
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($r['tanggapan_admin'])): ?>
                                            <div class="mt-2 p-2.5 rounded-2xl bg-emerald-50/90 border border-emerald-200/90 text-emerald-900 text-[11px] font-semibold space-y-0.5 shadow-2xs">
                                                <div class="font-extrabold text-emerald-800 flex items-center gap-1.5 text-[10px] uppercase tracking-wider">
                                                    <i class="fa-solid fa-circle-check text-emerald-600"></i> Tanggapan Admin:
                                                </div>
                                                <div class="pl-4 text-slate-700 font-medium"><?= esc($r['tanggapan_admin']) ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        <?php if ($r['status'] === 'Baru'): ?>
                                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 text-xs font-extrabold border border-emerald-300/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                                                Baru
                                            </span>
                                        <?php elseif ($r['status'] === 'Diproses'): ?>
                                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                                Diproses
                                            </span>
                                        <?php elseif ($r['status'] === 'Ditolak'): ?>
                                            <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-800 text-xs font-extrabold border border-rose-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <i class="fa-solid fa-ban text-rose-600 text-[10px]"></i>
                                                Ditolak / Fiktif
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-xs font-extrabold border border-teal-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <i class="fa-solid fa-check text-teal-600 text-[10px]"></i>
                                                Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($isAdmin): ?>
                                        <td class="py-4 px-3 text-center">
                                            <?php 
                                                // Prepare WhatsApp Messages
                                                $pesanPelapor = "Assalamualaikum Wr Wb Kak " . ($r['nama_pengirim'] ?? '') . ", terima kasih telah melapor ke CS Kebersihan Yayasan.\n\n"
                                                    . "📌 *Laporan Anda:*\n"
                                                    . "Lokasi: " . ($r['unit_lokasi'] ?? '-') . (!empty($r['nama_wilayah']) ? ' - ' . $r['nama_wilayah'] : '') . (!empty($r['shift']) ? ' (Shift ' . $r['shift'] . ')' : '') . "\n"
                                                    . "Keluhan: \"" . ($r['isi_laporan'] ?? '-') . "\"\n\n"
                                                    . "📊 *Status Terbaru:* " . ($r['status'] ?? 'Diproses') . "\n";
                                                if (!empty($r['tanggapan_admin'])) {
                                                    $pesanPelapor .= "💬 *Tanggapan Admin:* " . $r['tanggapan_admin'] . "\n";
                                                }
                                                if (!empty($r['tanggapan_unit'])) {
                                                    $pesanPelapor .= "🏢 *Tindak Lanjut Unit:* " . $r['tanggapan_unit'] . "\n";
                                                }
                                                $pesanPelapor .= "\nTerima kasih atas kerja samanya dalam menjaga kebersihan pesantren.\n_Admin Kebersihan Assalafiyyah_";
                                                $waPelaporUrl = !empty($cleanHp) ? "https://api.whatsapp.com/send?phone=" . $cleanHp . "&text=" . urlencode($pesanPelapor) : '';

                                                $cleanHpPj = preg_replace('/[^0-9]/', '', $r['pj_kontak'] ?? '');
                                                if (substr($cleanHpPj, 0, 1) === '0') {
                                                    $cleanHpPj = '62' . substr($cleanHpPj, 1);
                                                }
                                                $pesanPj = "Assalamu'alaikum Wr. Wb. Pengurus " . ($r['unit_lokasi'] ?? 'Unit') . " (" . ($r['pj_nama'] ?: 'PJ Kebersihan') . "),\n\n"
                                                    . "🚨 *Pemberitahuan Pengaduan Kebersihan Masuk:*\n"
                                                    . "Pelapor: " . ($r['nama_pengirim'] ?? 'Warga/Santri') . " (" . ($r['kontak_hp'] ?? '-') . ")\n"
                                                    . "Lokasi: " . ($r['unit_lokasi'] ?? '-') . (!empty($r['nama_wilayah']) ? ' - ' . $r['nama_wilayah'] : '') . (!empty($r['shift']) ? ' (Shift ' . $r['shift'] . ')' : '') . "\n"
                                                    . "Isi Pengaduan: \"" . ($r['isi_laporan'] ?? '-') . "\"\n"
                                                    . "Tanggal: " . date('d M Y H:i', strtotime($r['created_at'])) . " WIB\n\n"
                                                    . "Mohon untuk segera dicek, ditindaklanjuti, dan isi respon melalui Portal Kebersihan: " . base_url('app/laporan-kebersihan') . "\n\nTerima kasih.\n_Admin K3L Assalafiyyah_";
                                                $waPjUrl = !empty($cleanHpPj) ? "https://api.whatsapp.com/send?phone=" . $cleanHpPj . "&text=" . urlencode($pesanPj) : '';
                                            ?>
                                            <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                                <button type="button" onclick="openModalTanggapiCs(<?= htmlspecialchars(json_encode($r)) ?>)" class="px-2.5 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-1" title="Tanggapi & Ubah Status">
                                                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                                    <span>Tanggapi</span>
                                                </button>

                                                <?php if (!empty($waPelaporUrl)): ?>
                                                    <a href="<?= $waPelaporUrl ?>" target="_blank" class="w-8 h-8 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200 flex items-center justify-center transition shadow-2xs" title="Kirim Update WhatsApp ke Pelapor">
                                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if (!empty($waPjUrl)): ?>
                                                    <a href="<?= $waPjUrl ?>" target="_blank" class="w-8 h-8 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 flex items-center justify-center transition shadow-2xs" title="Teruskan WhatsApp ke PJ Unit (<?= esc($r['pj_nama'] ?: $r['unit_lokasi']) ?>)">
                                                        <i class="fa-solid fa-share-nodes text-xs"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="<?= base_url('cs/report/delete/' . $r['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus laporan ini?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 hover:border-rose-200 border border-slate-200 flex items-center justify-center transition shadow-2xs" title="Hapus Laporan">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 italic font-medium">Belum ada laporan pengaduan masuk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer Panel 1 -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-cs">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-cs">Menampilkan 0 data</span>
                    <select id="pageSize-cs" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5">5 / hal</option>
                        <option value="10" selected>10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-cs"></div>
            </div>
        </div>

        <!-- Panel 2: Inbox Pengajuan Alat dari Pengurus & Kader -->
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3.5 flex-wrap">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20 flex-shrink-0">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-heading font-extrabold text-lg text-slate-900">
                                Inbox Permohonan Pengajuan Alat Kebersihan
                            </h3>
                            <span class="text-[11px] font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/90 shadow-2xs whitespace-nowrap">
                                <?= count($pengajuanList) ?> Permohonan
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Permohonan alokasi peralatan baru yang diajukan oleh Pengurus / Kader Unit.</p>
                    </div>
                </div>

                <!-- Search Input for Pengajuan Alat -->
                <div class="relative w-full sm:w-64 flex-shrink-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchPengajuanInput" onkeyup="filterPengajuanTable()" placeholder="Cari pemohon / alat / keperluan..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
                <table id="tablePengajuanAlat" class="w-full min-w-[760px] text-left text-xs font-semibold">
                    <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                        <tr>
                            <th width="4%" class="py-3.5 px-3 text-center">NO</th>
                            <th width="13%" class="py-3.5 px-4">TANGGAL</th>
                            <th width="18%" class="py-3.5 px-4">PEMOHON (USER)</th>
                            <th width="20%" class="py-3.5 px-4">PERALATAN PERMOHONAN</th>
                            <th width="<?= $isAdmin ? '24%' : '34%' ?>" class="py-3.5 px-4">ALASAN KEPERLUAN & CATATAN</th>
                            <th width="11%" class="py-3.5 px-4 text-center">STATUS</th>
                            <?php if ($isAdmin): ?>
                                <th width="10%" class="py-3.5 px-3 text-center">PROSES</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($pengajuanList)): ?>
                            <?php foreach ($pengajuanList as $idx => $p): ?>
                                <tr class="pengajuan-row hover:bg-slate-50/90 transition-all">
                                    <td class="py-4 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-4 px-4 font-bold text-slate-600 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar-days text-slate-400 text-xs"></i>
                                            <span><?= date('d M Y', strtotime($p['created_at'])) ?></span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5 flex items-center gap-1">
                                            <i class="fa-regular fa-clock text-[9px]"></i>
                                            <span><?= date('H:i', strtotime($p['created_at'])) ?> WIB</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-extrabold text-xs shadow-2xs flex-shrink-0">
                                                <?= strtoupper(substr($p['nama_lengkap'] ?? 'P', 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="font-extrabold text-slate-900 text-xs"><?= esc($p['nama_lengkap'] ?: 'Pengurus Unit') ?></div>
                                                <div class="text-[10px] text-slate-400 font-medium">@<?= esc($p['username']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                            <i class="fa-solid fa-box text-emerald-600"></i>
                                            <span><?= esc($p['nama_alat']) ?></span>
                                        </div>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold mt-1 border border-emerald-200/80 shadow-2xs">
                                            <i class="fa-solid fa-layer-group text-[9px]"></i>
                                            <?= $p['jumlah'] ?> <?= esc($p['satuan']) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                            "<?= esc($p['alasan_keperluan']) ?>"
                                        </div>
                                        <?php if (!empty($p['catatan_admin'])): ?>
                                            <div class="mt-2 p-2.5 rounded-2xl bg-emerald-50/90 border border-emerald-200/90 text-emerald-900 text-[11px] font-semibold space-y-0.5 shadow-2xs">
                                                <div class="font-extrabold text-emerald-800 flex items-center gap-1.5 text-[10px] uppercase tracking-wider">
                                                    <i class="fa-solid fa-circle-info text-emerald-600"></i> Catatan Admin:
                                                </div>
                                                <div class="pl-4 text-slate-700 font-medium"><?= esc($p['catatan_admin']) ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        <?php if ($p['status'] === 'Pending'): ?>
                                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                                Pending
                                            </span>
                                        <?php elseif ($p['status'] === 'Disetujui'): ?>
                                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                                Disetujui
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-800 text-xs font-extrabold border border-rose-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                                <i class="fa-solid fa-circle-xmark text-rose-600 text-[10px]"></i>
                                                Ditolak
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($isAdmin): ?>
                                        <td class="py-4 px-3 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <button type="button" onclick="openModalProsesPengajuan(<?= htmlspecialchars(json_encode($p)) ?>)" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-1.5" title="Proses Pengajuan">
                                                    <i class="fa-solid fa-sliders"></i>
                                                    <span>Proses</span>
                                                </button>
                                                <a href="<?= base_url('cs/pengajuan/delete/' . $p['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus pengajuan alat ini?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 hover:border-rose-200 border border-slate-200 flex items-center justify-center transition shadow-2xs" title="Hapus Pengajuan">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 italic font-medium">Belum ada pengajuan alat dari pengurus / kader.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer Panel 2 -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-pengajuan">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-pengajuan">Menampilkan 0 data</span>
                    <select id="pageSize-pengajuan" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5">5 / hal</option>
                        <option value="10" selected>10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-pengajuan"></div>
            </div>
        </div>
    </div>

    <!-- Modal Edit / Tanggapi CS Report (Admin Only) -->
    <div id="modalTanggapiCs" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-md hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-3xl sm:max-w-4xl w-full p-6 sm:p-8 shadow-2xl space-y-6 border border-slate-100 my-auto animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-md shadow-emerald-600/20 flex-shrink-0">
                        <i class="fa-solid fa-headset text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">
                            Edit & Tanggapi Laporan CS
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Tindak lanjuti kendala dan perbarui data laporan.</p>
                    </div>
                </div>
                <button onclick="closeModalTanggapiCs()" class="w-9 h-9 rounded-2xl bg-slate-100 text-slate-400 hover:text-slate-700 hover:bg-slate-200 flex items-center justify-center transition shadow-2xs">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="formTanggapiCs" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-user text-emerald-600 text-[10px]"></i>
                            <span>Nama Pengirim</span>
                        </label>
                        <input type="text" id="cs_nama" name="nama_pengirim" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp text-emerald-600 text-[10px]"></i>
                            <span>Kontak WhatsApp</span>
                        </label>
                        <input type="text" id="cs_kontak" name="kontak_hp" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Searchable Unit Picker in Modal Edit/Tanggapi -->
                    <div class="relative">
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-emerald-600 text-[10px]"></i>
                                <span>Lokasi / Unit Terkait</span>
                            </span>
                            <span class="text-[9px] text-emerald-600 font-bold lowercase bg-emerald-50 px-1.5 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                <i class="fa-solid fa-magnifying-glass text-[8px]"></i> Bisa dicari
                            </span>
                        </label>
                        <input type="hidden" id="cs_edit_unit_lokasi" name="unit_lokasi" value="" required>
                        <input type="hidden" id="cs_edit_unit_id" name="unit_id" value="">
                        <div class="relative">
                            <i class="fa-solid fa-building text-emerald-600 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs pointer-events-none"></i>
                            <input type="text" id="cs_edit_unit_search" placeholder="Pilih unit / asrama terkait..." autocomplete="off" required onclick="openCsEditUnitDropdown()" onfocus="openCsEditUnitDropdown()" oninput="filterCsEditUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                            <button type="button" onclick="toggleCsEditUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                <i id="csEditUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                            </button>
                        </div>
                        <!-- Dropdown List -->
                        <div id="csEditUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-[60] hidden divide-y divide-slate-100">
                            <?php if (!empty($unitList)): ?>
                                <?php foreach ($unitList as $u): ?>
                                    <div class="cs-edit-unit-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['nama_unit']) ?>" onclick="selectCsEditUnit(this)">
                                        <div>
                                            <div class="font-extrabold text-xs text-slate-900"><?= esc($u['nama_unit']) ?></div>
                                            <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-bold border border-slate-200/60"><?= esc($u['tipe']) ?></span>
                                                <?php if (!empty($u['kode_unit'])): ?>
                                                    <span>&bull;</span>
                                                    <span class="font-mono text-slate-400"><?= esc($u['kode_unit']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-300 group-hover:text-emerald-600"><i class="fa-solid fa-check text-[10px]"></i></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div id="noCsEditUnitFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                Tidak ditemukan unit yang sesuai.
                            </div>
                        </div>
                    </div>

                    <!-- Searchable Wilayah Picker in Modal Edit/Tanggapi -->
                    <div class="relative">
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-map-location-dot text-teal-600 text-[10px]"></i>
                                <span>Wilayah Pemetaan (Opsional)</span>
                            </span>
                            <span class="text-[9px] text-teal-600 font-bold lowercase bg-teal-50 px-1.5 py-0.5 rounded-full border border-teal-200/60 flex items-center gap-1">
                                <i class="fa-solid fa-magnifying-glass text-[8px]"></i> Bisa dicari
                            </span>
                        </label>
                        <input type="hidden" id="cs_edit_wilayah_id" name="wilayah_id" value="">
                        <div class="relative">
                            <i class="fa-solid fa-map-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-teal-600 text-xs pointer-events-none"></i>
                            <input type="text" id="cs_edit_wilayah_search" placeholder="Cari wilayah pemetaan..." autocomplete="off" onclick="openCsEditWilayahDropdown()" onfocus="openCsEditWilayahDropdown()" oninput="filterCsEditWilayahOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                            <button type="button" onclick="toggleCsEditWilayahDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                <i id="csEditWilayahIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                            </button>
                        </div>
                        <!-- Dropdown List -->
                        <div id="csEditWilayahDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-[60] hidden divide-y divide-slate-100">
                            <div class="cs-edit-wilayah-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="" data-name="" data-lokasi-gedung="" onclick="selectCsEditWilayah(this)">
                                <div>
                                    <div class="font-extrabold text-xs text-slate-600 italic">-- Bukan Wilayah Khusus / Umum --</div>
                                    <div class="text-[10px] text-slate-400 font-medium">Laporan umum / tidak terikat spot wilayah pemetaan</div>
                                </div>
                            </div>
                            <?php if (!empty($wilayahList)): ?>
                                <?php foreach ($wilayahList as $w): ?>
                                    <div class="cs-edit-wilayah-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $w['id'] ?>" data-name="<?= esc($w['nama_wilayah']) ?> (<?= esc($w['kategori_area']) ?>)" data-lokasi-gedung="<?= esc(strtolower($w['lokasi_gedung'] ?? '')) ?>" onclick="selectCsEditWilayah(this)">
                                        <div>
                                            <div class="font-extrabold text-xs text-slate-900"><?= esc($w['nama_wilayah']) ?></div>
                                            <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                                <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 font-bold border border-emerald-200/60"><?= esc($w['kategori_area']) ?></span>
                                                <?php if (!empty($w['lokasi_gedung'])): ?>
                                                    <span>&bull;</span>
                                                    <span><i class="fa-solid fa-location-dot text-rose-500 mr-0.5"></i><?= esc($w['lokasi_gedung']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-mono font-bold text-slate-400"><?= esc($w['kode_wilayah'] ?: 'WIL-' . $w['id']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div id="noCsEditWilayahFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                Tidak ditemukan wilayah yang sesuai.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shift & Routing in Modal -->
                <div id="csEditShiftContainer" class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-200/80 space-y-2">
                    <label class="block text-[11px] font-extrabold text-emerald-950 uppercase tracking-wider flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-emerald-600 text-[10px]"></i>
                            <span>Shift & Unit Penanggung Jawab</span>
                        </span>
                        <span class="text-[9.5px] text-emerald-700 font-bold">Smart Routing</span>
                    </label>
                    <select id="cs_edit_shift" name="shift" onchange="onEditShiftChange(this)" class="w-full px-4 py-2.5 rounded-xl border border-emerald-300 text-xs font-bold bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                        <!-- Populated dynamically via JS -->
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-tag text-emerald-600 text-[10px]"></i>
                        <span>Kategori Laporan</span>
                    </label>
                    <select id="cs_kategori" name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                        <option value="Kendala Kebersihan">Kendala Kebersihan</option>
                        <option value="Fasilitas Rusak">Fasilitas Rusak</option>
                        <option value="Pertanyaan/Konsultasi">Pertanyaan/Konsultasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-comment-dots text-emerald-600 text-[10px]"></i>
                        <span>Isi Pesan Laporan</span>
                    </label>
                    <textarea id="cs_isi" name="isi_laporan" rows="3" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
                </div>

                <!-- Foto Lampiran di Modal Edit -->
                <div class="space-y-3 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider flex items-center justify-between">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-images text-emerald-600 text-[10px]"></i>
                            <span>Foto Bukti Terlampir</span>
                        </span>
                    </label>
                    <div id="modal_cs_fotos_container" class="flex flex-wrap gap-2.5 pt-1"></div>

                    <!-- Input Tambah Foto Baru (Kamera & Galeri) -->
                    <div class="pt-2 border-t border-slate-200/80 space-y-2">
                        <div class="text-[11px] font-bold text-slate-600">Tambah Foto Bukti Tambahan / Tindak Lanjut:</div>
                        
                        <input type="file" id="adminCameraInput" accept="image/*" capture="environment" class="hidden" onchange="handleAdminFiles(this.files)">
                        <input type="file" id="adminGalleryInput" accept="image/*" multiple class="hidden" onchange="handleAdminFiles(this.files)">
                        <input type="file" id="adminRealInput" name="foto_files[]" multiple class="hidden">

                        <div class="grid grid-cols-2 gap-2.5">
                            <button type="button" onclick="document.getElementById('adminCameraInput').click()" class="py-2.5 px-3 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-slate-700 hover:text-emerald-700 font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                                <i class="fa-solid fa-camera text-emerald-600"></i>
                                <span>Buka Kamera</span>
                            </button>
                            <button type="button" onclick="document.getElementById('adminGalleryInput').click()" class="py-2.5 px-3 rounded-xl bg-white hover:bg-teal-50 border border-slate-200 hover:border-teal-300 text-slate-700 hover:text-teal-700 font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                                <i class="fa-solid fa-images text-teal-600"></i>
                                <span>Pilih Galeri</span>
                            </button>
                        </div>
                        <div id="adminFotoPreviewContainer" class="flex flex-wrap gap-2.5 pt-1.5 hidden"></div>
                    </div>
                </div>

                <!-- Preview Tanggapan Unit Jika Sudah Ditindaklanjuti Unit -->
                <div id="modal_unit_response_box" class="p-4 rounded-2xl bg-gradient-to-br from-sky-50 to-blue-50/60 border border-sky-200/90 text-sky-950 space-y-2.5 hidden">
                    <div class="flex items-center justify-between border-b border-sky-200/60 pb-2">
                        <span class="font-extrabold text-[11px] uppercase tracking-wider text-sky-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-building-user text-sky-600 text-xs"></i>
                            <span id="modal_unit_penanggap_label">Tindak Lanjut Unit</span>
                        </span>
                        <span id="modal_unit_tanggal_label" class="text-[10px] font-mono text-sky-700 font-bold bg-white/80 px-2 py-0.5 rounded-lg border border-sky-200/60"></span>
                    </div>
                    <div class="p-3 rounded-xl bg-white/90 border border-sky-100 shadow-2xs">
                        <div id="modal_unit_tanggapan_text" class="text-xs text-slate-800 font-medium leading-relaxed italic"></div>
                    </div>
                    <div id="modal_unit_fotos_container" class="flex flex-wrap gap-2 pt-0.5"></div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-3">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-traffic-light text-emerald-600 text-[10px]"></i>
                            <span>Ubah Status Laporan</span>
                        </label>
                        <select id="cs_status" name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-extrabold bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                            <option value="Baru">🔵 Baru (Belum Ditangani)</option>
                            <option value="Diproses">⏳ Diproses (Sedang Ditangani Lapangan)</option>
                            <option value="Selesai">🟢 Selesai (Tuntas Ditangani)</option>
                            <option value="Ditolak">🔴 Ditolak (Laporan Spam / Fiktif)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                            <span>Tanggapan & Solusi Admin</span>
                        </label>
                        <textarea id="cs_tanggapan" name="tanggapan_admin" rows="2.5" placeholder="Tuliskan tindak lanjut penanganan atau solusi dari tim admin..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
                    </div>
                </div>

                <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-slate-100">
                    <button type="button" onclick="closeModalTanggapiCs()" class="px-5 py-2.5 rounded-2xl text-slate-600 hover:text-slate-800 text-xs font-bold hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:shadow-lg transition flex items-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit / Proses Pengajuan Alat (Admin Only) -->
    <div id="modalProsesPengajuan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-md hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl space-y-6 border border-slate-100 my-auto animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-md shadow-emerald-600/20 flex-shrink-0">
                        <i class="fa-solid fa-sliders text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">
                            Edit & Proses Pengajuan Alat
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Tinjau permohonan dan tetapkan status alokasi alat.</p>
                    </div>
                </div>
                <button onclick="closeModalProsesPengajuan()" class="w-9 h-9 rounded-2xl bg-slate-100 text-slate-400 hover:text-slate-700 hover:bg-slate-200 flex items-center justify-center transition shadow-2xs">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="formProsesPengajuan" action="" method="POST" class="space-y-4">
                <!-- Info Box Permohonan -->
                <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 flex items-center justify-between gap-4">
                    <div class="space-y-0.5">
                        <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Peralatan Diminta</div>
                        <div class="font-heading font-extrabold text-sm text-slate-900" id="pengajuan_nama_alat_display">Peralatan: -</div>
                    </div>
                    <div class="text-right space-y-0.5">
                        <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Pemohon</div>
                        <div class="font-bold text-xs text-slate-700" id="pengajuan_pemohon_display">Pemohon: -</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-boxes-stacked text-emerald-600 text-[10px]"></i>
                            <span>Jumlah Disetujui</span>
                        </label>
                        <input type="number" id="pengajuan_jumlah" name="jumlah" min="1" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-traffic-light text-emerald-600 text-[10px]"></i>
                            <span>Keputusan Status</span>
                        </label>
                        <select id="pengajuan_status" name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-extrabold bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                            <option value="Pending">⏳ Pending (Menunggu Peninjauan)</option>
                            <option value="Disetujui">🟢 Disetujui (Alat Dialokasikan)</option>
                            <option value="Ditolak">🔴 Ditolak (Belum Disetujui)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines text-emerald-600 text-[10px]"></i>
                        <span>Alasan Keperluan Pemohon</span>
                    </label>
                    <textarea id="pengajuan_alasan" name="alasan_keperluan" rows="2.5" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-clipboard-check text-emerald-600 text-[10px]"></i>
                        <span>Catatan / Alasan Keputusan Admin</span>
                    </label>
                    <textarea id="pengajuan_catatan" name="catatan_admin" rows="3" placeholder="Tuliskan catatan alokasi atau alasan keputusan admin..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
                </div>

                <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-slate-100">
                    <button type="button" onclick="closeModalProsesPengajuan()" class="px-5 py-2.5 rounded-2xl text-slate-600 hover:text-slate-800 text-xs font-bold hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:shadow-lg transition flex items-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Keputusan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var paginatorCs, paginatorPengajuan;

        function initCsAdminPaginator() {
            if (typeof TablePaginator !== 'undefined') {
                if (document.getElementById('tableCsReports')) {
                    paginatorCs = new TablePaginator('tableCsReports', 'page-info-cs', 'page-buttons-cs', 'pageSize-cs');
                    paginatorCs.render();
                }
                if (document.getElementById('tablePengajuanAlat')) {
                    paginatorPengajuan = new TablePaginator('tablePengajuanAlat', 'page-info-pengajuan', 'page-buttons-pengajuan', 'pageSize-pengajuan');
                    paginatorPengajuan.render();
                }
            }
        }
        window.initCsAdminPaginator = initCsAdminPaginator;
        window.rebindPageEvents = initCsAdminPaginator;

        document.addEventListener('DOMContentLoaded', initCsAdminPaginator);
        // Also run immediately if elements are already in DOM (e.g. on SPA load)
        initCsAdminPaginator();

        function filterCsReportsTable() {
            const input = document.getElementById('searchCsReportsInput');
            if (!input) return;
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#tableCsReports tbody tr.cs-report-row');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
            });

            if (paginatorCs) {
                paginatorCs.currentPage = 1;
                paginatorCs.render();
            }
        }
        window.filterCsReportsTable = filterCsReportsTable;

        function filterPengajuanTable() {
            const input = document.getElementById('searchPengajuanInput');
            if (!input) return;
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#tablePengajuanAlat tbody tr.pengajuan-row');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
            });

            if (paginatorPengajuan) {
                paginatorPengajuan.currentPage = 1;
                paginatorPengajuan.render();
            }
        }
        window.filterPengajuanTable = filterPengajuanTable;

        var adminDataTransfer = new DataTransfer();
        var adminFileNames = [];

        function handleAdminFiles(files) {
            if (!files || files.length === 0) return;
            Array.from(files).forEach(file => {
                adminDataTransfer.items.add(file);
                const defaultName = file.name.replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9_\-\s]/g, "");
                adminFileNames.push(defaultName || `admin_bukti_${adminFileNames.length + 1}`);
            });
            syncAdminRealInput();
            renderAdminPreviews();
        }
        window.handleAdminFiles = handleAdminFiles;

        function removeAdminFile(index) {
            const dt = new DataTransfer();
            const files = adminDataTransfer.files;
            const newNames = [];
            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                    newNames.push(adminFileNames[i]);
                }
            }
            adminDataTransfer = dt;
            adminFileNames = newNames;
            syncAdminRealInput();
            renderAdminPreviews();
        }
        window.removeAdminFile = removeAdminFile;

        function syncAdminRealInput() {
            const realInput = document.getElementById('adminRealInput');
            if (realInput) {
                realInput.files = adminDataTransfer.files;
            }
        }
        window.syncAdminRealInput = syncAdminRealInput;

        function renderAdminPreviews() {
            const container = document.getElementById('adminFotoPreviewContainer');
            if (!container) return;
            container.innerHTML = '';
            const files = adminDataTransfer.files;

            if (files.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const card = document.createElement('div');
                    card.className = 'w-28 bg-white rounded-xl border border-slate-200 shadow-2xs p-1.5 flex flex-col gap-1 flex-shrink-0';
                    card.innerHTML = `
                        <div class="relative w-full h-16 rounded-lg overflow-hidden bg-slate-100 border border-slate-100">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <button type="button" onclick="removeAdminFile(${index})" class="absolute top-0.5 right-0.5 w-5 h-5 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-[10px] shadow transition" title="Hapus foto">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <input type="text" name="foto_names[]" value="${adminFileNames[index] || ('admin_bukti_' + (index + 1))}" onchange="adminFileNames[${index}] = this.value" placeholder="Nama gambar..." class="w-full px-1.5 py-0.5 text-[10px] font-bold rounded border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition truncate">
                    `;
                    container.appendChild(card);
                };
                reader.readAsDataURL(file);
            });
        }
        window.renderAdminPreviews = renderAdminPreviews;



        var currentReportFotos = [];

        function renderExistingFotosInModal(fotos) {
            currentReportFotos = [...fotos];
            const fotosContainer = document.getElementById('modal_cs_fotos_container');
            if (!fotosContainer) return;
            fotosContainer.innerHTML = '';

            if (currentReportFotos && currentReportFotos.length > 0) {
                currentReportFotos.forEach((f, idx) => {
                    const imgUrl = (f.startsWith('http://') || f.startsWith('https://')) ? f : ("<?= base_url('uploads/cs/') ?>" + f);
                    const wrapper = document.createElement('div');
                    wrapper.className = "group relative w-16 h-16 rounded-2xl overflow-hidden border border-slate-200 hover:border-emerald-500 shadow-2xs flex-shrink-0 bg-slate-100";
                    wrapper.innerHTML = `
                        <input type="hidden" name="existing_fotos[]" value="${f}">
                        <img src="${imgUrl}" class="w-full h-full object-cover">
                        <a href="${imgUrl}" target="_blank" class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition">
                            <i class="fa-solid fa-magnifying-glass-plus text-xs"></i>
                        </a>
                        <button type="button" onclick="removeExistingFotoInModal(${idx})" class="absolute top-0.5 right-0.5 w-5 h-5 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-[10px] shadow z-10 transition transform hover:scale-110" title="Hapus foto bukti ini">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    `;
                    fotosContainer.appendChild(wrapper);
                });
            } else {
                fotosContainer.innerHTML = '<span class="text-xs text-slate-400 italic">Tidak ada foto bukti terlampir saat pelaporan.</span>';
            }
        }
        window.renderExistingFotosInModal = renderExistingFotosInModal;

        function removeExistingFotoInModal(index) {
            currentReportFotos.splice(index, 1);
            renderExistingFotosInModal(currentReportFotos);
        }
        window.removeExistingFotoInModal = removeExistingFotoInModal;

        function closeModalTanggapiCs() {
            const modal = document.getElementById('modalTanggapiCs');
            if (modal) modal.classList.add('hidden');
        }
        window.closeModalTanggapiCs = closeModalTanggapiCs;

        function openModalProsesPengajuan(pengajuan) {
            const form = document.getElementById('formProsesPengajuan');
            if (form) {
                form.action = "<?= base_url('cs/pengajuan/update/') ?>" + pengajuan.id;
            }
            const alatEl = document.getElementById('pengajuan_nama_alat_display');
            if (alatEl) alatEl.innerText = 'Peralatan: ' + (pengajuan.nama_alat || '-');
            const pemohonEl = document.getElementById('pengajuan_pemohon_display');
            if (pemohonEl) pemohonEl.innerText = 'Pemohon: ' + (pengajuan.nama_lengkap || pengajuan.username || 'Pengurus Unit');
            const jmlEl = document.getElementById('pengajuan_jumlah');
            if (jmlEl) jmlEl.value = pengajuan.jumlah || 1;
            const statEl = document.getElementById('pengajuan_status');
            if (statEl) statEl.value = pengajuan.status || 'Pending';
            const alasanEl = document.getElementById('pengajuan_alasan');
            if (alasanEl) alasanEl.value = pengajuan.alasan_keperluan || '';
            const catatanEl = document.getElementById('pengajuan_catatan');
            if (catatanEl) catatanEl.value = pengajuan.catatan_admin || '';

            const modal = document.getElementById('modalProsesPengajuan');
            if (modal) modal.classList.remove('hidden');
        }
        window.openModalProsesPengajuan = openModalProsesPengajuan;

        function closeModalProsesPengajuan() {
            const modal = document.getElementById('modalProsesPengajuan');
            if (modal) modal.classList.add('hidden');
        }
        window.closeModalProsesPengajuan = closeModalProsesPengajuan;
    </script>
<?php endif; ?>

<script>
    var publicDataTransfer = new DataTransfer();
    var publicFileNames = [];

    function handlePublicFiles(files) {
        if (!files || files.length === 0) return;
        Array.from(files).forEach(file => {
            publicDataTransfer.items.add(file);
            const defaultName = file.name.replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9_\-\s]/g, "");
            publicFileNames.push(defaultName || `bukti_${publicFileNames.length + 1}`);
        });
        syncPublicRealInput();
        renderPublicPreviews();
    }
    window.handlePublicFiles = handlePublicFiles;

    function removePublicFile(index) {
        const dt = new DataTransfer();
        const files = publicDataTransfer.files;
        const newNames = [];
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
                newNames.push(publicFileNames[i]);
            }
        }
        publicDataTransfer = dt;
        publicFileNames = newNames;
        syncPublicRealInput();
        renderPublicPreviews();
    }
    window.removePublicFile = removePublicFile;

    function syncPublicRealInput() {
        const realInput = document.getElementById('publicRealInput');
        if (realInput) {
            realInput.files = publicDataTransfer.files;
        }
    }
    window.syncPublicRealInput = syncPublicRealInput;

    function renderPublicPreviews() {
        const container = document.getElementById('publicFotoPreviewContainer');
        if (!container) return;
        container.innerHTML = '';
        const files = publicDataTransfer.files;

        if (files.length === 0) {
            container.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.className = 'w-32 bg-white rounded-2xl border border-slate-200 shadow-sm p-2 flex flex-col gap-1.5 flex-shrink-0';
                card.innerHTML = `
                    <div class="relative w-full h-24 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute top-1 left-1 w-5 h-5 bg-emerald-700/90 text-white rounded-full text-[10px] flex items-center justify-center font-bold shadow-xs">
                            ${index + 1}
                        </span>
                        <button type="button" onclick="removePublicFile(${index})" class="absolute top-1 right-1 w-6 h-6 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-xs shadow-md transition" title="Hapus foto ini">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[9px] font-extrabold text-slate-500 uppercase tracking-wider">Nama Foto:</label>
                        <input type="text" name="foto_names[]" value="${publicFileNames[index] || ('bukti_' + (index + 1))}" onchange="publicFileNames[${index}] = this.value" placeholder="Nama gambar..." class="w-full px-2 py-1 text-[11px] font-bold rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs truncate">
                    </div>
                `;
                container.appendChild(card);
            };
            reader.readAsDataURL(file);
        });
    }
    window.renderPublicPreviews = renderPublicPreviews;

    var penugasanData = <?= json_encode($penugasanList ?? []) ?>;
    var wilayahData   = <?= json_encode($wilayahList ?? []) ?>;
    var unitData      = <?= json_encode($unitList ?? []) ?>;

    // Helper to calculate auto shift based on client time
    function getAutoShift() {
        const hr = new Date().getHours();
        if (hr >= 5 && hr < 12) return 'Pagi';
        if (hr >= 12 && hr < 15) return 'Siang';
        if (hr >= 15 && hr < 18) return 'Sore';
        return 'Malam';
    }
    window.getAutoShift = getAutoShift;

    // ==========================================
    // PUBLIC CS FORM CASCADING LOGIC (3 STEPS)
    // ==========================================

    function openCsUnitDropdown() {
        const dd = document.getElementById('csUnitDropdownList');
        const icon = document.getElementById('csUnitIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
        filterCsUnitOptions(document.getElementById('cs_unit_search')?.value || '');
    }
    window.openCsUnitDropdown = openCsUnitDropdown;

    function toggleCsUnitDropdown() {
        const dd = document.getElementById('csUnitDropdownList');
        if (dd && dd.classList.contains('hidden')) {
            openCsUnitDropdown();
        } else if (dd) {
            dd.classList.add('hidden');
            const icon = document.getElementById('csUnitIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
    window.toggleCsUnitDropdown = toggleCsUnitDropdown;

    function filterCsUnitOptions(query) {
        openCsUnitDropdown();
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.cs-unit-item');
        let found = 0;
        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
                found++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noCsUnitFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterCsUnitOptions = filterCsUnitOptions;

    function selectCsUnit(el) {
        const nama = el.dataset.nama || '';
        const id = el.dataset.id || '';
        document.getElementById('cs_unit_id').value = id;
        document.getElementById('cs_unit_lokasi').value = nama;
        document.getElementById('cs_unit_search').value = nama;
        const dd = document.getElementById('csUnitDropdownList');
        const icon = document.getElementById('csUnitIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');

        // Reset & adjust cascading wilayah dropdown
        const wilIdEl = document.getElementById('cs_wilayah_id');
        const wilSearchEl = document.getElementById('cs_wilayah_search');
        if (wilIdEl) wilIdEl.value = '';
        if (wilSearchEl) {
            wilSearchEl.value = '';
            wilSearchEl.placeholder = nama ? ('Pilih area / spot di ' + nama + ' (Opsional)...') : '-- Bukan Wilayah Khusus / Umum --';
        }

        // Hide Shift Container until Wilayah is picked
        populatePublicShifts('');
    }
    window.selectCsUnit = selectCsUnit;

    // Wilayah Picker (Cascading based on selected Unit & Penugasan)
    function openCsWilayahDropdown() {
        const dd = document.getElementById('csWilayahDropdownList');
        const icon = document.getElementById('csWilayahIcon');
        if (dd) {
            dd.classList.remove('hidden');
            filterCsWilayahOptions(document.getElementById('cs_wilayah_search')?.value || '');
        }
        if (icon) icon.classList.add('rotate-180');
    }
    window.openCsWilayahDropdown = openCsWilayahDropdown;

    function toggleCsWilayahDropdown() {
        const dd = document.getElementById('csWilayahDropdownList');
        if (dd && dd.classList.contains('hidden')) {
            openCsWilayahDropdown();
        } else if (dd) {
            dd.classList.add('hidden');
            const icon = document.getElementById('csWilayahIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
    window.toggleCsWilayahDropdown = toggleCsWilayahDropdown;

    function filterCsWilayahOptions(query) {
        const dd = document.getElementById('csWilayahDropdownList');
        const icon = document.getElementById('csWilayahIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');

        const unitVal = (document.getElementById('cs_unit_lokasi')?.value || '').toLowerCase().trim();
        const unitIdVal = document.getElementById('cs_unit_id')?.value || '';
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.cs-wilayah-item');
        let found = 0;

        items.forEach(item => {
            const id = item.dataset.id || '';
            const text = item.innerText.toLowerCase();
            const gedung = (item.dataset.lokasiGedung || '').toLowerCase();

            let matchUnit = !unitVal || !id;
            if (unitVal && id) {
                matchUnit = Boolean(gedung && (gedung.includes(unitVal) || unitVal.includes(gedung)));
            }

            const matchQuery = !query || text.includes(query);

            if (matchUnit && matchQuery) {
                item.style.display = 'flex';
                found++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noCsWilayahFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterCsWilayahOptions = filterCsWilayahOptions;

    function selectCsWilayah(el) {
        const id = el.dataset.id || '';
        const name = el.dataset.name || '';
        document.getElementById('cs_wilayah_id').value = id;
        document.getElementById('cs_wilayah_search').value = name ? name : '';
        if (!id) {
            const unitVal = document.getElementById('cs_unit_lokasi')?.value;
            document.getElementById('cs_wilayah_search').placeholder = unitVal ? ('-- Bukan Wilayah Khusus di ' + unitVal + ' --') : '-- Bukan Wilayah Khusus / Umum --';
        }
        const dd = document.getElementById('csWilayahDropdownList');
        const icon = document.getElementById('csWilayahIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');

        // Populate Shift based on this Wilayah
        populatePublicShifts(id);
    }
    window.selectCsWilayah = selectCsWilayah;

    function populatePublicShifts(wilayahId, selectedShift = null) {
        const container = document.getElementById('csPublicShiftContainer');
        const select = document.getElementById('cs_public_shift');
        if (!container || !select) return;

        if (!wilayahId) {
            container.classList.add('hidden');
            select.innerHTML = '<option value="">-- Tanpa Shift Khusus --</option>';
            return;
        }

        const assignments = (penugasanData || []).filter(p => String(p.wilayah_id) === String(wilayahId));
        select.innerHTML = '';

        const autoDetectedVal = getAutoShift();

        if (assignments && assignments.length > 0) {
            assignments.forEach(a => {
                const opt = document.createElement('option');
                opt.value = a.shift;
                opt.dataset.unitId = a.unit_id || '';
                opt.dataset.unitName = a.nama_unit || '';
                
                let icon = a.shift === 'Pagi' ? '🌅' : (a.shift === 'Siang' ? '☀️' : (a.shift === 'Sore' ? '🌇' : '🌙'));
                let jamText = (a.jam_mulai && a.jam_selesai) ? ` (${a.jam_mulai} - ${a.jam_selesai} WIB)` : '';
                let pjText = a.nama_unit ? ` ── PJ: ${a.nama_unit}` : '';

                opt.textContent = `${icon} Shift ${a.shift}${jamText}${pjText}`;
                if (selectedShift ? (a.shift === selectedShift) : (a.shift === autoDetectedVal)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        } else {
            // Fallback standard shifts if none registered
            const currentUnitName = document.getElementById('cs_unit_lokasi')?.value || 'Unit Terkait';
            const currentUnitId = document.getElementById('cs_unit_id')?.value || '';
            [
                { s: 'Pagi', icon: '🌅', jam: '05:00 - 12:00 WIB' },
                { s: 'Siang', icon: '☀️', jam: '12:00 - 15:00 WIB' },
                { s: 'Sore', icon: '🌇', jam: '15:00 - 18:00 WIB' },
                { s: 'Malam', icon: '🌙', jam: '18:00 - 05:00 WIB' },
            ].forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.s;
                opt.dataset.unitId = currentUnitId;
                opt.dataset.unitName = currentUnitName;
                opt.textContent = `${item.icon} Shift ${item.s} (${item.jam}) ── PJ: ${currentUnitName}`;
                if (selectedShift ? (item.s === selectedShift) : (item.s === autoDetectedVal)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        }

        container.classList.remove('hidden');
        onPublicShiftChange(select);
    }
    window.populatePublicShifts = populatePublicShifts;

    function onPublicShiftChange(selectEl) {
        if (!selectEl) return;
        const selectedOpt = selectEl.options[selectEl.selectedIndex];
        if (!selectedOpt) return;
        const targetUnitId = selectedOpt.dataset.unitId;
        const targetUnitName = selectedOpt.dataset.unitName;

        if (targetUnitId) {
            document.getElementById('cs_unit_id').value = targetUnitId;
        }
        const targetBadge = document.getElementById('csTargetUnitName');
        if (targetBadge) {
            targetBadge.textContent = targetUnitName || '-';
        }
    }
    window.onPublicShiftChange = onPublicShiftChange;

    // ==========================================
    // MODAL EDIT / TANGGAPI CS CASCADING LOGIC
    // ==========================================

    function openCsEditUnitDropdown() {
        const dd = document.getElementById('csEditUnitDropdownList');
        const icon = document.getElementById('csEditUnitIcon');
        if (dd) {
            dd.classList.remove('hidden');
            const items = document.querySelectorAll('.cs-edit-unit-item');
            items.forEach(item => item.style.display = 'flex');
            const noFound = document.getElementById('noCsEditUnitFound');
            if (noFound) noFound.classList.add('hidden');
        }
        if (icon) icon.classList.add('rotate-180');
    }
    window.openCsEditUnitDropdown = openCsEditUnitDropdown;

    function toggleCsEditUnitDropdown() {
        const dd = document.getElementById('csEditUnitDropdownList');
        if (dd && dd.classList.contains('hidden')) {
            openCsEditUnitDropdown();
        } else if (dd) {
            dd.classList.add('hidden');
            const icon = document.getElementById('csEditUnitIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
    window.toggleCsEditUnitDropdown = toggleCsEditUnitDropdown;

    function filterCsEditUnitOptions(query) {
        const dd = document.getElementById('csEditUnitDropdownList');
        const icon = document.getElementById('csEditUnitIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');

        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.cs-edit-unit-item');
        let found = 0;
        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
                found++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noCsEditUnitFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterCsEditUnitOptions = filterCsEditUnitOptions;

    function selectCsEditUnit(el) {
        const nama = el.dataset.nama || '';
        const id = el.dataset.id || '';
        document.getElementById('cs_edit_unit_lokasi').value = nama;
        document.getElementById('cs_edit_unit_search').value = nama;
        document.getElementById('cs_edit_unit_id').value = id;
        const dd = document.getElementById('csEditUnitDropdownList');
        const icon = document.getElementById('csEditUnitIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');

        // Reset cascading edit wilayah
        const wilIdEl = document.getElementById('cs_edit_wilayah_id');
        const wilSearchEl = document.getElementById('cs_edit_wilayah_search');
        if (wilIdEl) wilIdEl.value = '';
        if (wilSearchEl) {
            wilSearchEl.value = '';
            wilSearchEl.placeholder = nama ? ('Pilih area / spot di ' + nama + ' (Opsional)...') : '-- Bukan Wilayah Khusus / Umum --';
        }

        populateEditShifts('');
    }
    window.selectCsEditUnit = selectCsEditUnit;

    // Searchable Wilayah Picker Logic in Modal Edit / Tanggapi CS (Cascading)
    function openCsEditWilayahDropdown() {
        const dd = document.getElementById('csEditWilayahDropdownList');
        const icon = document.getElementById('csEditWilayahIcon');
        if (dd) {
            dd.classList.remove('hidden');
            filterCsEditWilayahOptions(document.getElementById('cs_edit_wilayah_search')?.value || '');
        }
        if (icon) icon.classList.add('rotate-180');
    }
    window.openCsEditWilayahDropdown = openCsEditWilayahDropdown;

    function toggleCsEditWilayahDropdown() {
        const dd = document.getElementById('csEditWilayahDropdownList');
        if (dd && dd.classList.contains('hidden')) {
            openCsEditWilayahDropdown();
        } else if (dd) {
            dd.classList.add('hidden');
            const icon = document.getElementById('csEditWilayahIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
    window.toggleCsEditWilayahDropdown = toggleCsEditWilayahDropdown;

    function filterCsEditWilayahOptions(query) {
        const dd = document.getElementById('csEditWilayahDropdownList');
        const icon = document.getElementById('csEditWilayahIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');

        const unitVal = (document.getElementById('cs_edit_unit_lokasi')?.value || '').toLowerCase().trim();
        const unitIdVal = document.getElementById('cs_edit_unit_id')?.value || '';
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.cs-edit-wilayah-item');
        let found = 0;

        items.forEach(item => {
            const id = item.dataset.id || '';
            const text = item.innerText.toLowerCase();
            const gedung = (item.dataset.lokasiGedung || '').toLowerCase();

            let matchUnit = !unitVal || !id;
            if (unitVal && id) {
                matchUnit = Boolean(gedung && (gedung.includes(unitVal) || unitVal.includes(gedung)));
            }

            const matchQuery = !query || text.includes(query);

            if (matchUnit && matchQuery) {
                item.style.display = 'flex';
                found++;
            } else {
                item.style.display = 'none';
            }
        });
        const noFound = document.getElementById('noCsEditWilayahFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterCsEditWilayahOptions = filterCsEditWilayahOptions;

    function selectCsEditWilayah(el) {
        const id = el.dataset.id || '';
        const name = el.dataset.name || '';
        document.getElementById('cs_edit_wilayah_id').value = id;
        document.getElementById('cs_edit_wilayah_search').value = name ? name : '';
        if (!id) {
            const unitVal = document.getElementById('cs_edit_unit_lokasi')?.value;
            document.getElementById('cs_edit_wilayah_search').placeholder = unitVal ? ('-- Bukan Wilayah Khusus di ' + unitVal + ' --') : '-- Bukan Wilayah Khusus / Umum --';
        }
        const dd = document.getElementById('csEditWilayahDropdownList');
        const icon = document.getElementById('csEditWilayahIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');

        populateEditShifts(id);
    }
    window.selectCsEditWilayah = selectCsEditWilayah;

    function populateEditShifts(wilayahId, selectedShift = null, fallbackUnitName = '', fallbackUnitId = '') {
        const select = document.getElementById('cs_edit_shift');
        if (!select) return;

        select.innerHTML = '';
        const assignments = (penugasanData || []).filter(p => String(p.wilayah_id) === String(wilayahId));
        const autoDetectedVal = getAutoShift();

        if (wilayahId && assignments && assignments.length > 0) {
            assignments.forEach(a => {
                const opt = document.createElement('option');
                opt.value = a.shift;
                opt.dataset.unitId = a.unit_id || '';
                opt.dataset.unitName = a.nama_unit || '';
                
                let icon = a.shift === 'Pagi' ? '🌅' : (a.shift === 'Siang' ? '☀️' : (a.shift === 'Sore' ? '🌇' : '🌙'));
                let jamText = (a.jam_mulai && a.jam_selesai) ? ` (${a.jam_mulai} - ${a.jam_selesai} WIB)` : '';
                let pjText = a.nama_unit ? ` ── PJ: ${a.nama_unit}` : '';

                opt.textContent = `${icon} Shift ${a.shift}${jamText}${pjText}`;
                if (selectedShift ? (a.shift === selectedShift) : (a.shift === autoDetectedVal)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        } else {
            const curName = fallbackUnitName || document.getElementById('cs_edit_unit_lokasi')?.value || 'Unit Terkait';
            const curId = fallbackUnitId || document.getElementById('cs_edit_unit_id')?.value || '';
            [
                { s: 'Pagi', icon: '🌅', jam: '05:00 - 12:00 WIB' },
                { s: 'Siang', icon: '☀️', jam: '12:00 - 15:00 WIB' },
                { s: 'Sore', icon: '🌇', jam: '15:00 - 18:00 WIB' },
                { s: 'Malam', icon: '🌙', jam: '18:00 - 05:00 WIB' },
            ].forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.s;
                opt.dataset.unitId = curId;
                opt.dataset.unitName = curName;
                opt.textContent = `${item.icon} Shift ${item.s} (${item.jam}) ── PJ: ${curName}`;
                if (selectedShift ? (item.s === selectedShift) : (item.s === autoDetectedVal)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        }
    }
    window.populateEditShifts = populateEditShifts;

    function onEditShiftChange(selectEl) {
        if (!selectEl) return;
        const selectedOpt = selectEl.options[selectEl.selectedIndex];
        if (!selectedOpt) return;
        const targetUnitId = selectedOpt.dataset.unitId;

        if (targetUnitId) {
            document.getElementById('cs_edit_unit_id').value = targetUnitId;
        }
    }
    window.onEditShiftChange = onEditShiftChange;

    // Open Modal Tanggapi CS
    function openModalTanggapiCs(report) {
        const form = document.getElementById('formTanggapiCs');
        if (form) {
            form.action = "<?= base_url('cs/report/update/') ?>" + report.id;
        }
        const namaEl = document.getElementById('cs_nama');
        if (namaEl) namaEl.value = report.nama_pengirim || '';
        const kontakEl = document.getElementById('cs_kontak');
        if (kontakEl) kontakEl.value = report.kontak_hp || '';

        // Set Searchable Unit in Modal
        const unitLokasiEl = document.getElementById('cs_edit_unit_lokasi');
        const unitSearchEl = document.getElementById('cs_edit_unit_search');
        const unitIdEl = document.getElementById('cs_edit_unit_id');
        if (unitLokasiEl) unitLokasiEl.value = report.unit_lokasi || '';
        if (unitSearchEl) unitSearchEl.value = report.unit_lokasi || '';
        if (unitIdEl) unitIdEl.value = report.unit_id || '';

        // Set Searchable Wilayah in Modal
        const wilIdEl = document.getElementById('cs_edit_wilayah_id');
        const wilSearchEl = document.getElementById('cs_edit_wilayah_search');
        if (wilIdEl) wilIdEl.value = report.wilayah_id || '';
        if (wilSearchEl) {
            wilSearchEl.value = report.nama_wilayah ? (report.nama_wilayah) : '';
            if (!report.wilayah_id) wilSearchEl.placeholder = report.unit_lokasi ? ('-- Pilih Area di ' + report.unit_lokasi + ' --') : '-- Bukan Wilayah Khusus / Umum --';
        }

        // Populate dynamic shifts for modal
        populateEditShifts(report.wilayah_id, report.shift, report.unit_lokasi, report.unit_id);

        const katEl = document.getElementById('cs_kategori');
        if (katEl) katEl.value = report.kategori || 'Kendala Kebersihan';
        const isiEl = document.getElementById('cs_isi');
        if (isiEl) isiEl.value = report.isi_laporan || '';
        const statEl = document.getElementById('cs_status');
        if (statEl) statEl.value = report.status || 'Baru';
        const tanggapanEl = document.getElementById('cs_tanggapan');
        if (tanggapanEl) tanggapanEl.value = report.tanggapan_admin || '';

        // Reset admin DataTransfer & new upload preview
        adminDataTransfer = new DataTransfer();
        adminFileNames = [];
        syncAdminRealInput();
        renderAdminPreviews();

        // Render existing photos in modal
        const fotosContainer = document.getElementById('modal_cs_fotos_container');
        if (fotosContainer) {
            fotosContainer.innerHTML = '';
        }
        var fotos = [];
        try {
            fotos = JSON.parse(report.foto_lampiran || '[]');
        } catch(e) {
            fotos = [];
        }

        // Show unit response in modal if available
        const unitBox = document.getElementById('modal_unit_response_box');
        const unitPenanggapLabel = document.getElementById('modal_unit_penanggap_label');
        const unitDateLabel = document.getElementById('modal_unit_tanggal_label');
        const unitContent = document.getElementById('modal_unit_tanggapan_text');
        const unitFotosContainer = document.getElementById('modal_unit_fotos_container');

        if (report.tanggapan_unit && report.tanggapan_unit.trim() !== '') {
            if (unitBox) unitBox.classList.remove('hidden');
            if (unitPenanggapLabel) unitPenanggapLabel.textContent = 'Tindak Lanjut Unit (' + (report.nama_penanggap_unit || 'Pengurus Unit') + ')';
            if (unitDateLabel) unitDateLabel.textContent = report.ditanggapi_unit_at ? (report.ditanggapi_unit_at.substring(0, 16) + ' WIB') : '';
            if (unitContent) unitContent.textContent = report.tanggapan_unit;
            
            if (unitFotosContainer) {
                unitFotosContainer.innerHTML = '';
                var uFotos = [];
                try {
                    uFotos = JSON.parse(report.foto_tindakan_unit || '[]');
                    if (!Array.isArray(uFotos)) uFotos = [];
                } catch(e) {
                    uFotos = [];
                }
                if (uFotos.length > 0) {
                    uFotos.forEach(function(uf) {
                        var ufUrl = (uf.indexOf('http://') === 0 || uf.indexOf('https://') === 0) ? uf : ("<?= base_url('uploads/cs/') ?>/" + uf);
                        var a = document.createElement('a');
                        a.href = ufUrl;
                        a.target = '_blank';
                        a.className = 'w-10 h-10 rounded-xl overflow-hidden border border-sky-300 hover:scale-105 transition shadow-2xs block flex-shrink-0';
                        a.innerHTML = '<img src="' + ufUrl + '" class="w-full h-full object-cover">';
                        unitFotosContainer.appendChild(a);
                    });
                }
            }
        } else {
            if (unitBox) unitBox.classList.add('hidden');
        }

        renderExistingFotosInModal(fotos);

        const modal = document.getElementById('modalTanggapiCs');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }
    window.openModalTanggapiCs = openModalTanggapiCs;

    function closeModalTanggapiCs() {
        const modal = document.getElementById('modalTanggapiCs');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    window.closeModalTanggapiCs = closeModalTanggapiCs;

    // Global Click Handler for Closing Dropdowns
    document.addEventListener('click', function(e) {
        const unitSearchInput = document.getElementById('cs_unit_search');
        const unitDd = document.getElementById('csUnitDropdownList');
        if (unitDd && unitSearchInput && !unitSearchInput.contains(e.target) && !unitDd.contains(e.target)) {
            unitDd.classList.add('hidden');
            const icon = document.getElementById('csUnitIcon');
            if (icon) icon.classList.remove('rotate-180');
        }

        const searchInput = document.getElementById('cs_wilayah_search');
        const dd = document.getElementById('csWilayahDropdownList');
        if (dd && searchInput && !searchInput.contains(e.target) && !dd.contains(e.target)) {
            dd.classList.add('hidden');
            const icon = document.getElementById('csWilayahIcon');
            if (icon) icon.classList.remove('rotate-180');
        }

        const editUnitSearchInput = document.getElementById('cs_edit_unit_search');
        const editUnitDd = document.getElementById('csEditUnitDropdownList');
        if (editUnitDd && editUnitSearchInput && !editUnitSearchInput.contains(e.target) && !editUnitDd.contains(e.target)) {
            editUnitDd.classList.add('hidden');
            const icon = document.getElementById('csEditUnitIcon');
            if (icon) icon.classList.remove('rotate-180');
        }

        const editWilSearchInput = document.getElementById('cs_edit_wilayah_search');
        const editWilDd = document.getElementById('csEditWilayahDropdownList');
        if (editWilDd && editWilSearchInput && !editWilSearchInput.contains(e.target) && !editWilDd.contains(e.target)) {
            editWilDd.classList.add('hidden');
            const icon = document.getElementById('csEditWilayahIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    });
</script>

</div>
<?= $this->endSection() ?>
