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
    <!-- Hero Banner / Page Header (Frosted Glass Theme) -->
    <div class="relative overflow-hidden rounded-[32px] p-6 sm:p-9 shadow-[0_20px_50px_rgba(6,78,59,0.22)] border border-white/25 bg-gradient-to-br from-emerald-950/90 via-teal-900/85 to-slate-950/90 backdrop-blur-2xl text-white">
        <!-- Ambient Background Glows -->
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-6">
            <div class="space-y-2 max-w-3xl">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-extrabold uppercase tracking-wider border border-white/20">
                    <i class="fa-solid fa-headset text-emerald-400"></i> Layanan Pengaduan 24/7
                </div>
                <h1 class="text-xl sm:text-3xl md:text-4xl font-heading font-black tracking-tight leading-tight text-white drop-shadow-md">
                    Customer Service & Lapor Kendala
                </h1>
                <p class="text-slate-200 text-xs sm:text-sm leading-relaxed max-w-2xl font-medium">
                    Sampaikan kendala kebersihan atau pertanyaan seputar kebersihan pesantren. Tim siap menindaklanjuti.
                </p>
            </div>
        </div>
    </div>

    <!-- Public Contact Grid & Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6 items-start relative">
        <!-- Form Pengaduan Publik (Anti-SPAM CAPTCHA) -->
        <div class="lg:col-span-2 glass-card rounded-[32px] p-5 sm:p-8 shadow-[0_12px_40px_rgba(0,0,0,0.06)] border border-white/80 bg-white/80 backdrop-blur-2xl space-y-5 relative z-30">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between gap-2">
                <h2 class="font-heading font-extrabold text-sm sm:text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-emerald-600 text-xs sm:text-sm"></i> 
                    <span>Form Lapor Kendala</span>
                </h2>
                <span class="text-[9px] sm:text-[10px] font-bold text-emerald-800 bg-emerald-50 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full border border-emerald-200 flex items-center gap-1 flex-shrink-0">
                    <i class="fa-solid fa-shield-halved text-[9px]"></i> 
                    <span>Anti-SPAM</span>
                </span>
            </div>

            <!-- Multi-Step Progress Stepper -->
            <div class="mb-3 sm:mb-5 px-1 sm:px-2">
                <div class="flex items-start justify-between w-full">
                    <!-- Step 1 Trigger -->
                    <button type="button" onclick="goToCsStep(1)" id="stepTab1" class="flex flex-col items-center group cursor-pointer focus:outline-none flex-1 max-w-[100px] z-10">
                        <div id="stepCircle1" class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center font-extrabold text-xs sm:text-sm bg-emerald-600 text-white shadow-md shadow-emerald-600/30 ring-2 sm:ring-4 ring-emerald-100 transition-all duration-300 scale-105">
                            <i class="fa-solid fa-user text-xs sm:text-sm"></i>
                        </div>
                        <span id="stepLabel1" class="mt-1.5 sm:mt-2 text-[10px] sm:text-[11px] font-extrabold text-emerald-900 tracking-tight transition-colors text-center leading-tight">1. Identitas</span>
                    </button>

                    <!-- Connector 1-2 -->
                    <div class="flex-1 h-1 bg-slate-200 mx-1 sm:mx-2 mt-4 sm:mt-[18px] rounded-full overflow-hidden self-start">
                        <div id="csProgressLine1" class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-300" style="width: 0%;"></div>
                    </div>

                    <!-- Step 2 Trigger -->
                    <button type="button" onclick="goToCsStep(2)" id="stepTab2" class="flex flex-col items-center group cursor-pointer focus:outline-none flex-1 max-w-[100px] z-10">
                        <div id="stepCircle2" class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center font-bold text-xs sm:text-sm bg-slate-100 text-slate-400 border border-slate-200 ring-2 sm:ring-4 ring-white transition-all duration-300">
                            <i class="fa-solid fa-camera text-xs sm:text-sm"></i>
                        </div>
                        <span id="stepLabel2" class="mt-1.5 sm:mt-2 text-[10px] sm:text-[11px] font-medium text-slate-400 tracking-tight transition-colors text-center leading-tight">2. Detail Foto</span>
                    </button>

                    <!-- Connector 2-3 -->
                    <div class="flex-1 h-1 bg-slate-200 mx-1 sm:mx-2 mt-4 sm:mt-[18px] rounded-full overflow-hidden self-start">
                        <div id="csProgressLine2" class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-300" style="width: 0%;"></div>
                    </div>

                    <!-- Step 3 Trigger -->
                    <button type="button" onclick="goToCsStep(3)" id="stepTab3" class="flex flex-col items-center group cursor-pointer focus:outline-none flex-1 max-w-[100px] z-10">
                        <div id="stepCircle3" class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center font-bold text-xs sm:text-sm bg-slate-100 text-slate-400 border border-slate-200 ring-2 sm:ring-4 ring-white transition-all duration-300">
                            <i class="fa-solid fa-paper-plane text-xs sm:text-sm"></i>
                        </div>
                        <span id="stepLabel3" class="mt-1.5 sm:mt-2 text-[10px] sm:text-[11px] font-medium text-slate-400 tracking-tight transition-colors text-center leading-tight">3. Kirim</span>
                    </button>
                </div>
            </div>

            <form action="<?= base_url('cs/public/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 allow-auditor" id="formLaporCsPublic" onsubmit="return validateCsFinalSubmit(event)">
                <?php $isLoggedIn = (bool)session()->get('isLoggedIn'); ?>

                <!-- ========================================== -->
                <!-- 🔹 LANGKAH 1: IDENTITAS & LOKASI UNIT     -->
                <!-- ========================================== -->
                <div id="csStep1" class="cs-step-pane space-y-3.5 sm:space-y-4 animate-fadeIn">
                    <div class="p-2.5 sm:p-3 rounded-xl bg-emerald-50/70 border border-emerald-100 flex items-center gap-2 text-xs text-emerald-900 font-medium">
                        <i class="fa-solid fa-circle-info text-emerald-600 text-xs flex-shrink-0"></i>
                        <span class="text-[11px] sm:text-xs">Lengkapi data diri dan tentukan lokasi kendala kebersihan.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between flex-wrap gap-1">
                                <span>Nama Pengirim <span class="text-rose-500">*</span></span>
                                <?php if ($isLoggedIn): ?>
                                    <span class="text-[9px] sm:text-[10px] text-emerald-700 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60 flex items-center gap-0.5">
                                        <i class="fa-solid fa-lock text-[8px]"></i> Akun Login
                                    </span>
                                <?php endif; ?>
                            </label>
                            <input type="text" id="cs_nama_pengirim" name="nama_pengirim" value="<?= esc($defaultNamaPengirim ?? session()->get('nama_lengkap') ?? $userUnit['pj_nama'] ?? '') ?>" <?= $isLoggedIn ? 'readonly' : '' ?> placeholder="Misal: Santri / Warga / Kader" required class="w-full px-3.5 py-2.5 rounded-xl sm:rounded-2xl border border-slate-200 text-xs font-bold <?= $isLoggedIn ? 'bg-slate-100/90 text-slate-800 cursor-not-allowed' : 'bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500' ?> transition shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between flex-wrap gap-1">
                                <span>WhatsApp / HP <span class="text-rose-500">*</span></span>
                                <span class="text-[9px] sm:text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60 flex items-center gap-0.5">
                                    <i class="fa-brands fa-whatsapp text-[8px]"></i> Nomor Aktif
                                </span>
                            </label>
                            <input type="text" id="cs_kontak_hp" name="kontak_hp" value="<?= esc($defaultKontakHp ?? $userUnit['pj_kontak'] ?? '') ?>" placeholder="081234567890" required class="w-full px-3.5 py-2.5 rounded-xl sm:rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <!-- Searchable Unit Picker in CS Form -->
                        <div class="relative z-40">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between flex-wrap gap-1">
                                <span>1. Lokasi / Unit <span class="text-rose-500">*</span></span>
                                <span class="text-[9px] sm:text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60 flex items-center gap-0.5">
                                    <i class="fa-solid fa-magnifying-glass text-[8px]"></i> Cari Unit
                                </span>
                            </label>
                            <input type="hidden" id="cs_unit_id" name="unit_id" value="">
                            <input type="hidden" id="cs_unit_lokasi" name="unit_lokasi" required value="">
                            <div class="relative">
                                <i class="fa-solid fa-building text-emerald-600 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs pointer-events-none"></i>
                                <input type="text" id="cs_unit_search" placeholder="Pilih unit / asrama terkait..." autocomplete="off" required onfocus="openCsUnitDropdown()" oninput="filterCsUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-xl sm:rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                                <button type="button" onclick="toggleCsUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                    <i id="csUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                                </button>
                            </div>
                            <!-- Dropdown List -->
                            <div id="csUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200/90 ring-1 ring-slate-900/10 max-h-56 overflow-y-auto z-[100] hidden divide-y divide-slate-100">
                                <?php if (!empty($unitList)): ?>
                                    <?php foreach ($unitList as $u): ?>
                                        <div class="cs-unit-item px-3.5 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['nama_unit']) ?>" onclick="selectCsUnit(this)">
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
                        <div class="relative z-30">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between flex-wrap gap-1">
                                <span>2. Wilayah / Spot Area</span>
                                <span class="text-[9px] sm:text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60 flex items-center gap-0.5">
                                    <i class="fa-solid fa-filter text-[8px]"></i> Opsional
                                </span>
                            </label>
                            <input type="hidden" id="cs_wilayah_id" name="wilayah_id" value="">
                            <div class="relative">
                                <i class="fa-solid fa-map-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                                <input type="text" id="cs_wilayah_search" placeholder="Pilih unit terlebih dahulu..." autocomplete="off" onclick="openCsWilayahDropdown()" onfocus="openCsWilayahDropdown()" oninput="filterCsWilayahOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-xl sm:rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                                <button type="button" onclick="toggleCsWilayahDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                    <i id="csWilayahIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                                </button>
                            </div>
                            <!-- Dropdown List -->
                            <div id="csWilayahDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200/90 ring-1 ring-slate-900/10 max-h-56 overflow-y-auto z-[100] hidden divide-y divide-slate-100">
                                <div class="cs-wilayah-item px-3.5 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="" data-name="" data-lokasi-gedung="" onclick="selectCsWilayah(this)">
                                    <div>
                                        <div class="font-extrabold text-xs text-slate-600 italic">-- Bukan Wilayah Khusus / Umum --</div>
                                        <div class="text-[10px] text-slate-400 font-medium">Laporan umum lingkungan unit (tanpa spot wilayah khusus)</div>
                                    </div>
                                </div>
                                <?php if (!empty($wilayahList)): ?>
                                    <?php foreach ($wilayahList as $w): ?>
                                        <div class="cs-wilayah-item px-3.5 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $w['id'] ?>" data-name="<?= esc($w['nama_wilayah']) ?>" data-lokasi-gedung="<?= esc(strtolower($w['lokasi_gedung'] ?? '')) ?>" onclick="selectCsWilayah(this)">
                                            <div>
                                                <div class="font-extrabold text-xs text-slate-900"><?= esc($w['nama_wilayah']) ?></div>
                                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5 flex-wrap">
                                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 font-bold border border-emerald-200/60"><?= esc($w['kategori_area']) ?></span>
                                                    <?php if (!empty($w['luas_area'])): ?>
                                                        <span class="text-slate-300">&bull;</span>
                                                        <span class="inline-flex items-center gap-0.5 text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-200/60 font-bold" title="Ukuran / Luas Area">
                                                            <i class="fa-solid fa-ruler-combined text-[9px] text-teal-600"></i> <?= esc($w['luas_area']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($w['lokasi_gedung'])): ?>
                                                        <span class="text-slate-300">&bull;</span>
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

                    <!-- Tombol Lanjut ke Langkah 2 -->
                    <div class="pt-3 sm:pt-4 border-t border-slate-100 flex justify-end">
                        <button type="button" onclick="nextCsStep(1)" class="w-full sm:w-auto px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 group cursor-pointer active:scale-[0.98]">
                            <span>Lanjut: Detail & Foto Bukti</span>
                            <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 🔹 LANGKAH 2: DETAIL KENDALA & FOTO BUKTI -->
                <!-- ========================================== -->
                <div id="csStep2" class="cs-step-pane space-y-3.5 sm:space-y-4 hidden animate-fadeIn">
                    <!-- Dynamic Shift Selection with Smart PJ Routing -->
                    <div id="csPublicShiftContainer" class="p-3 sm:p-3.5 rounded-xl sm:rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2 hidden animate-fadeIn">
                        <div class="flex items-center justify-between gap-1 flex-wrap">
                            <label class="block text-xs font-extrabold text-emerald-950 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-emerald-600 text-xs"></i>
                                <span>Pilih Shift & PJ Terkait</span>
                            </label>
                            <span id="csShiftAutoBadge" class="text-[9px] sm:text-[10px] text-emerald-700 bg-white px-2 py-0.5 rounded-full border border-emerald-200 font-bold flex items-center gap-1 shadow-2xs">
                                <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> Rekomendasi
                            </span>
                        </div>
                        <select id="cs_public_shift" name="shift" onchange="onPublicShiftChange(this)" class="w-full px-3 py-2 rounded-xl border border-emerald-300 text-xs font-bold bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                            <!-- Populated dynamically via JS -->
                        </select>
                        <div id="csShiftInfoPj" class="text-[11px] text-emerald-900 font-medium flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600 text-xs flex-shrink-0"></i>
                            <span>Diteruskan ke PJ: <b id="csTargetUnitName" class="text-emerald-950 underline font-extrabold">-</b></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Kendala <span class="text-rose-500">*</span></label>
                        <select id="cs_kategori" name="kategori" class="w-full px-3.5 py-2.5 rounded-xl sm:rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                            <option value="Kendala Kebersihan">Kendala Kebersihan / Sampah Penuh</option>
                            <option value="Fasilitas Rusak">Fasilitas Tempat Kebersihan Rusak</option>
                            <option value="Pertanyaan/Konsultasi">Pertanyaan / Konsultasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center justify-between flex-wrap gap-1">
                            <span>Isi Pesan / Keluhan <span class="text-rose-500">*</span></span>
                            <span class="text-[10px] text-slate-400 font-medium">Jelaskan detail</span>
                        </label>
                        <textarea id="cs_isi_laporan" name="isi_laporan" rows="4" placeholder="Jelaskan kendala kebersihan atau hal yang ingin disampaikan ke Tim Kebersihan..." required class="w-full px-3.5 py-2.5 rounded-xl sm:rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                    </div>

                    <!-- Multiple Photo Upload with Separate Camera & Gallery Buttons and Delete Feature -->
                    <div class="space-y-2.5 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-50/90 border border-slate-200">
                        <div class="flex items-center justify-between gap-1 flex-wrap">
                            <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-camera-retro text-emerald-600 text-xs"></i>
                                <span>Foto Bukti Kendala</span>
                            </label>
                            <span class="text-[10px] text-slate-500 font-medium">Bisa > 1 foto (Opsional)</span>
                        </div>

                        <!-- Hidden Inputs for Camera and Gallery -->
                        <input type="file" id="publicCameraInput" accept="image/*" capture="environment" class="hidden" onchange="handlePublicFiles(this.files)">
                        <input type="file" id="publicGalleryInput" accept="image/*" multiple class="hidden" onchange="handlePublicFiles(this.files)">
                        <!-- Real Form File Input Container managed by DataTransfer -->
                        <input type="file" id="publicRealInput" name="foto_files[]" multiple class="hidden">

                        <!-- Action Buttons: Kamera & Galeri -->
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <button type="button" onclick="document.getElementById('publicCameraInput').click()" class="py-2.5 sm:py-3 px-3 rounded-xl sm:rounded-2xl bg-white hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-400 text-slate-700 hover:text-emerald-700 font-heading font-bold text-xs transition shadow-2xs flex items-center justify-center gap-2 cursor-pointer active:scale-[0.98]">
                                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg sm:rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 text-xs">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <span>Buka Kamera</span>
                            </button>

                            <button type="button" onclick="document.getElementById('publicGalleryInput').click()" class="py-2.5 sm:py-3 px-3 rounded-xl sm:rounded-2xl bg-white hover:bg-teal-50/80 border border-slate-200 hover:border-teal-400 text-slate-700 hover:text-teal-700 font-heading font-bold text-xs transition shadow-2xs flex items-center justify-center gap-2 cursor-pointer active:scale-[0.98]">
                                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg sm:rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center flex-shrink-0 text-xs">
                                    <i class="fa-solid fa-images"></i>
                                </div>
                                <span>Pilih Galeri</span>
                            </button>
                        </div>

                        <!-- Live Thumbnail Preview Container with Delete Button -->
                        <div id="publicFotoPreviewContainer" class="flex flex-wrap gap-2 pt-2 hidden border-t border-slate-200/70"></div>
                    </div>

                    <!-- Tombol Navigasi Langkah 2 -->
                    <div class="pt-3 sm:pt-4 border-t border-slate-100 flex items-center justify-between gap-2 sm:gap-3">
                        <button type="button" onclick="prevCsStep(2)" class="px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs transition flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-arrow-left text-[11px]"></i>
                            <span>Kembali</span>
                        </button>
                        <button type="button" onclick="nextCsStep(2)" class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2 group cursor-pointer active:scale-[0.98]">
                            <span>Lanjut: Konfirmasi</span>
                            <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 🔹 LANGKAH 3: KONFIRMASI & VERIFIKASI      -->
                <!-- ========================================== -->
                <div id="csStep3" class="cs-step-pane space-y-3.5 sm:space-y-4 hidden animate-fadeIn">
                    <!-- Review Summary Card -->
                    <div class="rounded-2xl sm:rounded-3xl bg-gradient-to-br from-emerald-50/80 via-teal-50/40 to-slate-50 p-3.5 sm:p-5 border border-emerald-200/80 shadow-xs space-y-3 sm:space-y-4">
                        <div class="flex items-center justify-between border-b border-emerald-200/60 pb-2.5">
                            <h3 class="font-heading font-extrabold text-xs text-emerald-950 flex items-center gap-1.5 uppercase tracking-wider">
                                <i class="fa-solid fa-clipboard-check text-emerald-600 text-xs sm:text-sm"></i>
                                <span>Ringkasan Pengaduan</span>
                            </h3>
                            <button type="button" onclick="goToCsStep(1)" class="text-[10px] sm:text-[11px] text-emerald-700 hover:text-emerald-800 font-bold bg-white px-2 py-0.5 sm:py-1 rounded-lg sm:rounded-xl border border-emerald-200 shadow-2xs flex items-center gap-1 hover:shadow-xs transition">
                                <i class="fa-solid fa-pen-to-square text-[9px]"></i> Ubah
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 text-xs">
                            <div class="bg-white/90 p-2.5 sm:p-3 rounded-xl sm:rounded-2xl border border-emerald-100 shadow-2xs space-y-0.5 sm:space-y-1">
                                <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-user text-emerald-600"></i> Pengirim
                                </span>
                                <div id="reviewPengirim" class="font-bold text-slate-900 text-xs">-</div>
                                <div id="reviewKontak" class="text-[11px] text-slate-500 font-semibold font-mono">-</div>
                            </div>

                            <div class="bg-white/90 p-2.5 sm:p-3 rounded-xl sm:rounded-2xl border border-emerald-100 shadow-2xs space-y-0.5 sm:space-y-1">
                                <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i> Lokasi & Shift
                                </span>
                                <div id="reviewLokasi" class="font-bold text-slate-900 text-xs">-</div>
                                <div id="reviewShiftPj" class="text-[11px] text-emerald-700 font-semibold">-</div>
                            </div>
                        </div>

                        <div class="bg-white/90 p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-emerald-100 shadow-2xs space-y-1.5 sm:space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-tag text-teal-600"></i> Kategori
                                </span>
                                <span id="reviewKategori" class="text-[9px] sm:text-[10px] font-extrabold text-emerald-800 bg-emerald-100/80 px-2 py-0.5 rounded-full border border-emerald-200">-</span>
                            </div>
                            <div>
                                <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Isi Kendala / Pesan:</span>
                                <div id="reviewIsi" class="p-2.5 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-700 font-normal whitespace-pre-wrap leading-relaxed italic">-</div>
                            </div>
                        </div>

                        <div id="reviewFotosWrapper" class="hidden bg-white/90 p-3 rounded-xl sm:rounded-2xl border border-emerald-100 shadow-2xs space-y-1.5">
                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-images text-emerald-600"></i> Foto Terlampir (<span id="reviewFotoCount">0</span>)
                            </span>
                            <div id="reviewFotosContainer" class="flex flex-wrap gap-2 pt-0.5"></div>
                        </div>
                    </div>

                    <!-- Anti-SPAM Security Verification Code -->
                    <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-100/90 border border-slate-200 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span>Verifikasi Anti-SPAM <span class="text-rose-500">*</span></span>
                        </label>
                        <div class="flex items-center gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
                            <div class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl bg-white border border-slate-300 font-mono font-bold text-xs sm:text-sm text-emerald-800 shadow-inner whitespace-nowrap">
                                <?= esc($captcha_num1) ?> + <?= esc($captcha_num2) ?> = ?
                            </div>
                            <input type="number" id="cs_captcha_user" name="captcha_user" placeholder="Jawaban..." required class="flex-1 sm:w-32 px-3 py-2 sm:py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        </div>
                        <p class="text-[10px] text-slate-500 font-normal leading-tight">Jawab penjumlahan di atas untuk memverifikasi laporan.</p>
                    </div>

                    <!-- Tombol Navigasi Langkah 3 / Submit -->
                    <div class="pt-3 sm:pt-4 border-t border-slate-100 flex items-center justify-between gap-2 sm:gap-3">
                        <button type="button" onclick="prevCsStep(3)" class="px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs transition flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-arrow-left text-[11px]"></i>
                            <span>Kembali</span>
                        </button>
                        <button type="submit" id="btnSubmitCsPublic" class="flex-1 sm:flex-none px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-lg shadow-emerald-600/25 flex items-center justify-center gap-2 allow-auditor cursor-pointer active:scale-[0.98]">
                            <i class="fa-solid fa-paper-plane text-[11px]"></i>
                            <span>Kirim Pengaduan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info & Hotline WhatsApp (Glassmorphism Cards) -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Hotline WhatsApp Card -->
            <?php 
                $csWaNum = !empty($hotlineWa) ? $hotlineWa : '081234567890';
                $cleanWa = preg_replace('/[^0-9]/', '', $csWaNum);
                if (substr($cleanWa, 0, 1) === '0') $cleanWa = '62' . substr($cleanWa, 1);
                elseif (substr($cleanWa, 0, 2) !== '62') $cleanWa = '62' . $cleanWa;
                $directWaUrl = "https://api.whatsapp.com/send?phone=" . $cleanWa . "&text=" . urlencode("Halo Admin Kebersihan, saya ingin berkonsultasi / membutuhkan bantuan terkait kebersihan.");
            ?>
            <div class="glass-card rounded-[28px] p-5 sm:p-6 shadow-[0_10px_30px_rgba(0,0,0,0.05)] border border-white/80 bg-white/75 backdrop-blur-2xl space-y-4 relative overflow-hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-600/25 ring-2 ring-emerald-100 flex-shrink-0">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-sm text-slate-900 leading-tight">Hotline WhatsApp CS</h3>
                        <p class="text-[11px] text-slate-500 font-medium leading-tight mt-0.5">Kontak langsung via chat</p>
                    </div>
                </div>

                <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-100/90 text-xs text-emerald-950 font-semibold space-y-1">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 font-normal">Nomor Resmi:</span>
                        <span class="font-bold text-emerald-800 font-mono"><?= esc($csWaNum) ?></span>
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 font-normal">Waktu Respon:</span>
                        <span class="font-bold text-emerald-800">07:00 - 21:00 WIB</span>
                    </div>
                </div>

                <a href="<?= $directWaUrl ?>" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Chat WhatsApp Admin</span>
                </a>
            </div>

            <!-- Alur Penanganan Cepat Card -->
            <div class="glass-card rounded-[28px] p-5 sm:p-6 shadow-[0_10px_30px_rgba(0,0,0,0.05)] border border-white/80 bg-white/75 backdrop-blur-2xl space-y-3.5">
                <h4 class="font-heading font-extrabold text-xs text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-route text-emerald-600"></i>
                    <span>Alur Penanganan Laporan</span>
                </h4>

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 font-extrabold text-[10px] flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                        <p class="text-slate-600 text-[11px] leading-relaxed"><strong class="text-slate-800">Kirim Form:</strong> Isi data dan foto kondisi kebersihan.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-teal-100 text-teal-700 font-extrabold text-[10px] flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                        <p class="text-slate-600 text-[11px] leading-relaxed"><strong class="text-slate-800">Verifikasi Tim:</strong> Admin menerima dan menugaskan petugas.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-700 font-extrabold text-[10px] flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                        <p class="text-slate-600 text-[11px] leading-relaxed"><strong class="text-slate-800">Tindak Lanjut:</strong> Area dibersihkan & status diperbarui.</p>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <a href="<?= base_url('faq') ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                        <i class="fa-solid fa-circle-question text-[11px]"></i>
                        <span>Lihat Panduan & FAQ Lengkap &rarr;</span>
                    </a>
                </div>
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

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                <table id="tableCsReports" class="w-full min-w-[720px] text-left text-[11px]">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="3%" class="py-2.5 px-2.5 text-center">#</th>
                            <th width="10%" class="py-2.5 px-3">Tanggal</th>
                            <th width="17%" class="py-2.5 px-3">Pengirim</th>
                            <th width="15%" class="py-2.5 px-3">Lokasi</th>
                            <th width="<?= $isAdmin ? '30%' : '38%' ?>" class="py-2.5 px-3">Laporan</th>
                            <th width="8%" class="py-2.5 px-3 text-center">Status</th>
                            <?php if ($isAdmin): ?>
                                <th width="10%" class="py-2.5 px-2.5 text-center">Aksi</th>
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
                                <tr class="cs-report-row hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-2.5 text-center font-bold text-slate-400"><?= $idx + 1 ?></td>
                                    <td class="py-3 px-3 text-slate-600 whitespace-nowrap">
                                        <div class="font-bold"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                                        <div class="text-[10px] text-slate-400 font-mono"><?= date('H:i', strtotime($r['created_at'])) ?> WIB</div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                                <?= strtoupper(substr($r['nama_pengirim'] ?? 'U', 0, 1)) ?>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-slate-900 truncate"><?= esc($r['nama_pengirim']) ?></div>
                                                <?php if (!empty($r['kontak_hp'])): ?>
                                                    <a href="https://wa.me/<?= $cleanHp ?>?text=Halo%20<?= urlencode($r['nama_pengirim']) ?>,%20terkait%20laporan%20kebersihan%20Anda" target="_blank" class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 font-mono text-[10px] font-bold transition">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                        <?= esc($r['kontak_hp']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-[10px] text-slate-400 italic">No HP</span>
                                                <?php endif; ?>
                                                <?php if (!empty($r['ip_address'])): ?>
                                                    <div class="text-[9px] text-slate-400 font-mono" title="IP: <?= esc($r['ip_address']) ?>">
                                                        <i class="fa-solid fa-network-wired text-[8px]"></i> <?= esc($r['ip_address']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <?php 
                                            $csWil = !empty($r['nama_wilayah']) ? $r['nama_wilayah'] : '';
                                            $csUnit = !empty($r['lokasi_gedung']) ? $r['lokasi_gedung'] : (!empty($r['unit_lokasi']) ? $r['unit_lokasi'] : '');
                                            $csLokasi = $csWil ? ($csWil . ' – ' . $csUnit) : $csUnit;
                                        ?>
                                        <div class="font-bold text-slate-800 text-[11px] leading-snug">
                                            <i class="fa-solid fa-location-dot text-emerald-600 text-[9px]"></i>
                                            <?= esc($csLokasi) ?>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-1 mt-1">
                                            <span class="px-1.5 py-px rounded bg-emerald-50 text-emerald-800 text-[9px] font-bold border border-emerald-200/70"><?= esc($r['kategori']) ?></span>
                                            <?php if (!empty($r['luas_area'])): ?>
                                                <span class="px-1.5 py-px rounded bg-teal-50 text-teal-800 text-[9px] font-bold border border-teal-200/70" title="Luas Area">
                                                    <i class="fa-solid fa-ruler-combined text-[8px]"></i> <?= esc($r['luas_area']) ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (!empty($r['shift'])): ?>
                                                <span class="px-1.5 py-px rounded bg-amber-50 text-amber-800 text-[9px] font-bold border border-amber-200/70">
                                                    <i class="fa-regular fa-clock text-[8px]"></i> Shift <?= esc($r['shift']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/70 text-slate-700 text-[11px] leading-relaxed">
                                            "<?= esc($r['isi_laporan']) ?>"
                                        </div>

                                        <?php 
                                            $fotos = json_decode($r['foto_lampiran'] ?? '[]', true) ?: [];
                                        ?>
                                        <?php if (!empty($fotos)): ?>
                                            <div class="mt-1.5 flex flex-wrap items-center gap-1">
                                                <?php foreach ($fotos as $f): ?>
                                                    <?php 
                                                        $imgUrl = (strpos($f, 'http://') === 0 || strpos($f, 'https://') === 0) ? $f : base_url('uploads/cs/' . $f);
                                                    ?>
                                                    <a href="<?= $imgUrl ?>" target="_blank" onclick="event.stopPropagation();" class="group relative block w-8 h-8 rounded-lg overflow-hidden border border-slate-200 hover:border-emerald-500 hover:scale-110 transition flex-shrink-0">
                                                        <img src="<?= $imgUrl ?>" alt="Bukti" class="w-full h-full object-cover">
                                                    </a>
                                                <?php endforeach; ?>
                                                <span class="text-[9px] font-bold text-slate-500"><?= count($fotos) ?> foto</span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($r['tanggapan_unit'])): ?>
                                            <div class="mt-1.5 p-2 rounded-xl bg-sky-50 border border-sky-200/80 text-[10px] space-y-0.5">
                                                <div class="font-bold text-sky-800 flex items-center justify-between">
                                                    <span><i class="fa-solid fa-building-user text-sky-600 text-[9px]"></i> Unit (<?= esc($r['nama_penanggap_unit'] ?: 'Pengurus') ?>)</span>
                                                    <?php if (!empty($r['ditanggapi_unit_at'])): ?>
                                                        <span class="font-mono text-[9px] text-sky-500"><?= date('d M H:i', strtotime($r['ditanggapi_unit_at'])) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-slate-700 leading-snug pl-3"><?= esc($r['tanggapan_unit']) ?></div>
                                                <?php 
                                                    $unitFotos = json_decode($r['foto_tindakan_unit'] ?? '[]', true) ?: [];
                                                ?>
                                                <?php if (!empty($unitFotos)): ?>
                                                    <div class="pl-3 pt-0.5 flex flex-wrap items-center gap-1">
                                                        <?php foreach ($unitFotos as $uf): ?>
                                                            <?php $ufUrl = (strpos($uf, 'http://') === 0 || strpos($uf, 'https://') === 0) ? $uf : base_url('uploads/cs/' . $uf); ?>
                                                            <a href="<?= $ufUrl ?>" target="_blank" onclick="event.stopPropagation();" class="w-7 h-7 rounded-md overflow-hidden border border-sky-200 hover:scale-110 transition" title="Foto unit">
                                                                <img src="<?= $ufUrl ?>" class="w-full h-full object-cover">
                                                            </a>
                                                        <?php endforeach; ?>
                                                        <span class="text-[9px] text-sky-600 font-bold"><?= count($unitFotos) ?> foto</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($r['tanggapan_admin'])): ?>
                                            <div class="mt-1.5 p-2 rounded-xl bg-emerald-50 border border-emerald-200/80 text-[10px] space-y-0.5">
                                                <div class="font-bold text-emerald-800 flex items-center justify-between">
                                                    <span><i class="fa-solid fa-circle-check text-emerald-600 text-[9px]"></i> Admin</span>
                                                    <?php if (!empty($r['updated_at'])): ?>
                                                        <span class="font-mono text-[9px] text-emerald-500"><?= date('d M H:i', strtotime($r['updated_at'])) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-slate-700 leading-snug pl-3"><?= esc($r['tanggapan_admin']) ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-3 text-center whitespace-nowrap">
                                        <?php if ($r['status'] === 'Baru'): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span> Baru
                                            </span>
                                        <?php elseif ($r['status'] === 'Diproses'): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-hourglass-half text-[8px]"></i> Proses
                                            </span>
                                        <?php elseif ($r['status'] === 'Ditolak'): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-800 text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-ban text-[8px]"></i> Ditolak
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-check text-[8px]"></i> Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($isAdmin): ?>
                                        <td class="py-3 px-2.5 text-center">
                                            <?php 
                                                // Prepare WhatsApp Messages & Clean Phone Numbers
                                                $cleanHp = preg_replace('/[^0-9]/', '', $r['kontak_hp'] ?? '');
                                                if (substr($cleanHp, 0, 1) === '0') {
                                                    $cleanHp = '62' . substr($cleanHp, 1);
                                                }

                                                $cleanHpPj = preg_replace('/[^0-9]/', '', $r['pj_kontak'] ?? '');
                                                if (substr($cleanHpPj, 0, 1) === '0') {
                                                    $cleanHpPj = '62' . substr($cleanHpPj, 1);
                                                }

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

                                                $targetUnit = !empty($r['pj_unit_nama']) ? $r['pj_unit_nama'] : ($r['unit_lokasi'] ?? 'Unit');
                                                $targetPjNama = !empty($r['pj_nama']) ? $r['pj_nama'] : 'PJ Kebersihan';

                                                $pesanPj = "Assalamu'alaikum Wr. Wb. Pengurus " . $targetUnit . " (" . $targetPjNama . "),\n\n"
                                                    . "🚨 *Pemberitahuan Pengaduan Kebersihan Masuk:*\n"
                                                    . "Pelapor: " . ($r['nama_pengirim'] ?? 'Warga/Santri') . " (" . ($r['kontak_hp'] ?? '-') . ")\n"
                                                    . "Lokasi: " . ($r['unit_lokasi'] ?? '-') . (!empty($r['nama_wilayah']) ? ' - ' . $r['nama_wilayah'] : '') . (!empty($r['shift']) ? ' (Shift ' . $r['shift'] . ')' : '') . "\n"
                                                    . "Unit Bertanggung Jawab (Shift " . ($r['shift'] ?? '-') . "): " . $targetUnit . "\n"
                                                    . "Isi Pengaduan: \"" . ($r['isi_laporan'] ?? '-') . "\"\n"
                                                    . "Tanggal: " . date('d M Y H:i', strtotime($r['created_at'])) . " WIB\n\n"
                                                    . "Mohon untuk segera dicek, ditindaklanjuti, dan isi respon melalui Portal Kebersihan: https://laporkebersihan.online/app/lapor-wilayah\n\nTerima kasih.\n_Admin Kebersihan Assalafiyyah_";
                                                $waPjUrl = !empty($cleanHpPj) ? "https://api.whatsapp.com/send?phone=" . $cleanHpPj . "&text=" . urlencode($pesanPj) : '';
                                            ?>
                                            <div class="flex items-center justify-center gap-1 flex-wrap">
                                                <button type="button" onclick="openModalTanggapiCs(<?= htmlspecialchars(json_encode($r)) ?>)" class="px-2 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] shadow-sm transition-all flex items-center gap-1" title="Tanggapi">
                                                    <i class="fa-solid fa-pen-to-square text-[9px]"></i> Tanggapi
                                                </button>

                                                <?php if (!empty($waPelaporUrl)): ?>
                                                    <a href="<?= $waPelaporUrl ?>" target="_blank" class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200 flex items-center justify-center transition" title="WA Pelapor">
                                                        <i class="fa-brands fa-whatsapp text-xs"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if (!empty($waPjUrl)): ?>
                                                    <a href="<?= $waPjUrl ?>" target="_blank" class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 flex items-center justify-center transition" title="WA PJ Unit">
                                                        <i class="fa-solid fa-share-nodes text-[10px]"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="<?= base_url('cs/report/delete/' . $r['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus laporan ini?" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 flex items-center justify-center transition" title="Hapus">
                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-400 italic text-xs">Belum ada laporan pengaduan masuk.</td>
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

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 shadow-2xs">
                <table id="tablePengajuanAlat" class="w-full min-w-[760px] text-left text-xs font-semibold">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="13%" class="py-3 px-4">TANGGAL</th>
                            <th width="18%" class="py-3 px-4">PEMOHON</th>
                            <th width="20%" class="py-3 px-4">PERALATAN</th>
                            <th width="<?= $isAdmin ? '24%' : '34%' ?>" class="py-3 px-4">ALASAN & CATATAN</th>
                            <th width="11%" class="py-3 px-4 text-center">STATUS</th>
                            <?php if ($isAdmin): ?>
                                <th width="10%" class="py-3 px-3 text-center">PROSES</th>
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
                                            <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5 flex-wrap">
                                                <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 font-bold border border-emerald-200/60"><?= esc($w['kategori_area']) ?></span>
                                                <?php if (!empty($w['luas_area'])): ?>
                                                    <span class="text-slate-300">&bull;</span>
                                                    <span class="inline-flex items-center gap-0.5 text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-200/60 font-bold" title="Ukuran / Luas Area">
                                                        <i class="fa-solid fa-ruler-combined text-[9px] text-teal-600"></i> <?= esc($w['luas_area']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!empty($w['lokasi_gedung'])): ?>
                                                    <span class="text-slate-300">&bull;</span>
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

                <!-- WhatsApp Forwarding Quick Actions in Modal -->
                <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200/90 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold text-emerald-950 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                            <span>Aksi Cepat WhatsApp</span>
                        </span>
                        <span class="text-[9.5px] text-emerald-700 font-bold bg-white px-2 py-0.5 rounded-full border border-emerald-200">1-Klik Otomatis</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <a id="modal_btn_wa_pj" href="#" target="_blank" class="py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs transition shadow-sm flex items-center justify-center gap-2" title="Teruskan Pengaduan ke PJ Unit">
                            <i class="fa-solid fa-share-nodes text-xs"></i>
                            <span>Teruskan ke WA PJ Unit</span>
                        </a>
                        <a id="modal_btn_wa_pelapor" href="#" target="_blank" class="py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs transition shadow-sm flex items-center justify-center gap-2" title="Kirim Update ke Pelapor">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Kirim Update ke Pelapor</span>
                        </a>
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
                card.className = 'w-28 sm:w-32 bg-white rounded-xl sm:rounded-2xl border border-slate-200 shadow-2xs p-1.5 sm:p-2 flex flex-col gap-1 sm:gap-1.5 flex-shrink-0';
                card.innerHTML = `
                    <div class="relative w-full h-20 sm:h-24 rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute top-1 left-1 w-4 h-4 sm:w-5 sm:h-5 bg-emerald-700/90 text-white rounded-full text-[9px] sm:text-[10px] flex items-center justify-center font-bold shadow-xs">
                            ${index + 1}
                        </span>
                        <button type="button" onclick="removePublicFile(${index})" class="absolute top-1 right-1 w-5 h-5 sm:w-6 sm:h-6 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-[10px] sm:text-xs shadow-md transition" title="Hapus foto ini">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="space-y-0.5 sm:space-y-1">
                        <label class="block text-[8px] sm:text-[9px] font-bold text-slate-500 uppercase tracking-wider">Nama Foto:</label>
                        <input type="text" name="foto_names[]" value="${publicFileNames[index] || ('bukti_' + (index + 1))}" onchange="publicFileNames[${index}] = this.value" placeholder="Nama gambar..." class="w-full px-1.5 py-0.5 sm:py-1 text-[10px] sm:text-[11px] font-semibold rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs truncate">
                    </div>
                `;
                container.appendChild(card);
            };
            reader.readAsDataURL(file);
        });
    }
    window.renderPublicPreviews = renderPublicPreviews;

    // ==========================================
    // 🧙‍♂️ MULTI-STEP CS REPORT FORM WIZARD LOGIC
    // ==========================================
    var csCurrentStep = 1;

    function goToCsStep(targetStep) {
        if (targetStep === csCurrentStep) return;

        // If user wants to skip forward, ensure prior steps are valid
        if (targetStep > csCurrentStep) {
            if (csCurrentStep === 1 && !validateCsStep1()) return;
            if (csCurrentStep === 2 && !validateCsStep2()) return;
            if (csCurrentStep === 1 && targetStep === 3) {
                if (!validateCsStep1() || !validateCsStep2()) return;
            }
        }

        // Hide all step containers
        const steps = [1, 2, 3];
        steps.forEach(s => {
            const el = document.getElementById('csStep' + s);
            if (el) el.classList.add('hidden');
        });

        // Show target step container
        const targetEl = document.getElementById('csStep' + targetStep);
        if (targetEl) {
            targetEl.classList.remove('hidden');
        }

        // If target is Step 3, refresh the live Review Summary
        if (targetStep === 3) {
            updateCsReviewSummary();
        }

        // Update Stepper UI (Circles, Labels, Progress Bar)
        updateCsStepperUI(targetStep);

        csCurrentStep = targetStep;

        // Smooth scroll back to top of form card so mobile user isn't disoriented
        const formCard = document.getElementById('formLaporCsPublic');
        if (formCard) {
            const rect = formCard.getBoundingClientRect();
            if (rect.top < 50 || rect.top > window.innerHeight) {
                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
    window.goToCsStep = goToCsStep;

    function nextCsStep(fromStep) {
        if (fromStep === 1) {
            if (!validateCsStep1()) return;
            goToCsStep(2);
        } else if (fromStep === 2) {
            if (!validateCsStep2()) return;
            goToCsStep(3);
        }
    }
    window.nextCsStep = nextCsStep;

    function prevCsStep(fromStep) {
        if (fromStep > 1) {
            goToCsStep(fromStep - 1);
        }
    }
    window.prevCsStep = prevCsStep;

    function validateCsStep1() {
        const namaInput = document.getElementById('cs_nama_pengirim');
        const kontakInput = document.getElementById('cs_kontak_hp');
        const unitLokasiInput = document.getElementById('cs_unit_lokasi');
        const unitSearchInput = document.getElementById('cs_unit_search');

        if (!namaInput || !namaInput.value.trim()) {
            showCsStepAlert('Nama Pengirim Wajib Diisi', 'Silakan masukkan nama lengkap atau panggilan Anda.');
            if (namaInput) namaInput.focus();
            return false;
        }

        if (!kontakInput || !kontakInput.value.trim()) {
            showCsStepAlert('Nomor WhatsApp Wajib Diisi', 'Silakan masukkan nomor WA/HP yang bisa dihubungi.');
            if (kontakInput) kontakInput.focus();
            return false;
        }

        if (!unitLokasiInput || !unitLokasiInput.value.trim() || !unitSearchInput || !unitSearchInput.value.trim()) {
            showCsStepAlert('Lokasi / Unit Belum Dipilih', 'Silakan klik dan pilih unit/asrama terkait pada kolom Unit.');
            if (unitSearchInput) {
                unitSearchInput.focus();
                openCsUnitDropdown();
            }
            return false;
        }

        return true;
    }

    function validateCsStep2() {
        const isiInput = document.getElementById('cs_isi_laporan');

        if (!isiInput || !isiInput.value.trim()) {
            showCsStepAlert('Isi Laporan Wajib Diisi', 'Silakan jelaskan kendala kebersihan atau keluhan yang ingin disampaikan.');
            if (isiInput) isiInput.focus();
            return false;
        }

        if (isiInput.value.trim().length < 5) {
            showCsStepAlert('Keterangan Terlalu Pendek', 'Mohon berikan penjelasan laporan minimal 5 karakter agar tim dapat memahami kendala.');
            if (isiInput) isiInput.focus();
            return false;
        }

        return true;
    }

    function showCsStepAlert(title, text) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center text-center pt-2 pb-1">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-200 text-amber-500 flex items-center justify-center text-2xl shadow-sm ring-8 ring-amber-500/10 mb-3.5">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <h3 class="font-heading font-extrabold text-slate-900 text-base sm:text-lg tracking-tight leading-snug mb-1.5">
                            ${title}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-[280px]">
                            ${text}
                        </p>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: '<span class="flex items-center justify-center gap-2"><i class="fa-solid fa-check text-xs"></i><span>Baik, Saya Lengkapi</span></span>',
                buttonsStyling: false,
                backdrop: 'rgba(15, 23, 42, 0.6)',
                customClass: {
                    popup: 'rounded-3xl p-6 glass-card shadow-2xl border border-slate-200/90 font-sans max-w-sm w-[90vw]',
                    confirmButton: 'w-full py-3 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-emerald-600/25 hover:from-emerald-700 hover:to-teal-700 transition active:scale-[0.98] cursor-pointer mt-3',
                    htmlContainer: '!m-0 !p-0'
                }
            });
        } else {
            alert(title + ': ' + text);
        }
    }

    function updateCsStepperUI(activeStep) {
        const line1 = document.getElementById('csProgressLine1');
        const line2 = document.getElementById('csProgressLine2');
        if (line1) {
            line1.style.width = activeStep >= 2 ? '100%' : '0%';
        }
        if (line2) {
            line2.style.width = activeStep >= 3 ? '100%' : '0%';
        }

        for (let i = 1; i <= 3; i++) {
            const circle = document.getElementById('stepCircle' + i);
            const label = document.getElementById('stepLabel' + i);
            if (!circle || !label) continue;

            if (i < activeStep) {
                // Completed Step
                circle.className = 'w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center font-extrabold text-xs sm:text-sm bg-emerald-500 text-white shadow-md shadow-emerald-500/20 ring-2 sm:ring-4 ring-emerald-50 transition-all duration-300';
                circle.innerHTML = '<i class="fa-solid fa-check text-xs sm:text-sm"></i>';
                label.className = 'mt-1.5 sm:mt-2 text-[10px] sm:text-[11px] font-bold text-emerald-700 tracking-tight transition-colors text-center leading-tight';
            } else if (i === activeStep) {
                // Active Step
                circle.className = 'w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center font-extrabold text-xs sm:text-sm bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 ring-2 sm:ring-4 ring-emerald-100 transition-all duration-300 scale-105';
                if (i === 1) circle.innerHTML = '<i class="fa-solid fa-user text-xs sm:text-sm"></i>';
                else if (i === 2) circle.innerHTML = '<i class="fa-solid fa-camera text-xs sm:text-sm"></i>';
                else if (i === 3) circle.innerHTML = '<i class="fa-solid fa-paper-plane text-xs sm:text-sm"></i>';
                label.className = 'mt-1.5 sm:mt-2 text-[10px] sm:text-[11px] font-extrabold text-emerald-900 tracking-tight transition-colors text-center leading-tight';
            } else {
                // Inactive / Upcoming Step
                circle.className = 'w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center font-bold text-xs sm:text-sm bg-slate-100 text-slate-400 border border-slate-200 ring-2 sm:ring-4 ring-white transition-all duration-300';
                if (i === 1) circle.innerHTML = '<i class="fa-solid fa-user text-xs sm:text-sm"></i>';
                else if (i === 2) circle.innerHTML = '<i class="fa-solid fa-camera text-xs sm:text-sm"></i>';
                else if (i === 3) circle.innerHTML = '<i class="fa-solid fa-paper-plane text-xs sm:text-sm"></i>';
                label.className = 'mt-1.5 sm:mt-2 text-[10px] sm:text-[11px] font-medium text-slate-400 tracking-tight transition-colors text-center leading-tight';
            }
        }
    }

    function updateCsReviewSummary() {
        const namaVal = document.getElementById('cs_nama_pengirim')?.value || '-';
        const kontakVal = document.getElementById('cs_kontak_hp')?.value || '-';
        const unitVal = document.getElementById('cs_unit_search')?.value || document.getElementById('cs_unit_lokasi')?.value || '-';
        const wilayahVal = document.getElementById('cs_wilayah_search')?.value;
        const shiftVal = document.getElementById('cs_public_shift')?.value;
        const targetPjVal = document.getElementById('csTargetUnitName')?.textContent || '-';
        const kategoriVal = document.getElementById('cs_kategori')?.value || 'Kendala Kebersihan';
        const isiVal = document.getElementById('cs_isi_laporan')?.value || '-';

        // Set Pengirim
        const reviewPengirim = document.getElementById('reviewPengirim');
        if (reviewPengirim) reviewPengirim.textContent = namaVal;
        const reviewKontak = document.getElementById('reviewKontak');
        if (reviewKontak) reviewKontak.textContent = '📞 ' + kontakVal;

        // Set Lokasi & Shift
        const reviewLokasi = document.getElementById('reviewLokasi');
        if (reviewLokasi) {
            let locText = unitVal;
            if (wilayahVal && wilayahVal !== '-- Bukan Wilayah Khusus / Umum --') {
                locText += ' • ' + wilayahVal;
            }
            reviewLokasi.textContent = locText;
        }

        const reviewShiftPj = document.getElementById('reviewShiftPj');
        if (reviewShiftPj) {
            let shiftText = shiftVal ? ('Shift ' + shiftVal) : 'Shift Waktu Laporan';
            if (targetPjVal && targetPjVal !== '-') {
                shiftText += ' (PJ: ' + targetPjVal + ')';
            }
            reviewShiftPj.textContent = '⏱️ ' + shiftText;
        }

        // Set Kategori & Isi
        const reviewKategori = document.getElementById('reviewKategori');
        if (reviewKategori) reviewKategori.textContent = kategoriVal;
        const reviewIsi = document.getElementById('reviewIsi');
        if (reviewIsi) reviewIsi.textContent = isiVal;

        // Set Foto Preview Thumbnails in Summary
        const reviewFotosWrapper = document.getElementById('reviewFotosWrapper');
        const reviewFotosContainer = document.getElementById('reviewFotosContainer');
        const reviewFotoCount = document.getElementById('reviewFotoCount');
        const files = publicDataTransfer.files;

        if (reviewFotosWrapper && reviewFotosContainer) {
            if (files && files.length > 0) {
                reviewFotosWrapper.classList.remove('hidden');
                if (reviewFotoCount) reviewFotoCount.textContent = files.length;
                reviewFotosContainer.innerHTML = '';

                Array.from(files).forEach((file, idx) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const thumb = document.createElement('div');
                        thumb.className = 'w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border border-emerald-200 shadow-2xs relative group';
                        thumb.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <span class="absolute bottom-0 right-0 bg-slate-900/70 text-white text-[9px] px-1 font-bold rounded-tl">${idx + 1}</span>
                        `;
                        reviewFotosContainer.appendChild(thumb);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                reviewFotosWrapper.classList.add('hidden');
                if (reviewFotoCount) reviewFotoCount.textContent = '0';
                reviewFotosContainer.innerHTML = '';
            }
        }
    }
    window.updateCsReviewSummary = updateCsReviewSummary;

    function validateCsFinalSubmit(e) {
        if (!validateCsStep1()) {
            e.preventDefault();
            goToCsStep(1);
            return false;
        }
        if (!validateCsStep2()) {
            e.preventDefault();
            goToCsStep(2);
            return false;
        }

        const captchaInput = document.getElementById('cs_captcha_user');
        if (captchaInput && (!captchaInput.value || captchaInput.value.trim() === '')) {
            e.preventDefault();
            showCsStepAlert('Verifikasi Anti-SPAM Wajib Diisi', 'Silakan jawab pertanyaan matematika di Langkah 3.');
            captchaInput.focus();
            return false;
        }

        const submitBtn = document.getElementById('btnSubmitCsPublic');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i><span>Mengirim Pengaduan...</span>';
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        }

        return true;
    }
    window.validateCsFinalSubmit = validateCsFinalSubmit;

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
    // PUBLIC CS FORM CASCADING LOGIC
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

    var currentModalReport = null;

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
                opt.dataset.pjNama = a.pj_nama || '';
                opt.dataset.pjKontak = a.pj_kontak || '';
                
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
            const uObj = (unitData || []).find(u => String(u.id) === String(curId));
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
                opt.dataset.pjNama = uObj?.pj_nama || '';
                opt.dataset.pjKontak = uObj?.pj_kontak || '';
                opt.textContent = `${item.icon} Shift ${item.s} (${item.jam}) ── PJ: ${curName}`;
                if (selectedShift ? (item.s === selectedShift) : (item.s === autoDetectedVal)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        }

        if (currentModalReport) {
            updateModalWaButtons(currentModalReport, select.value);
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

        if (currentModalReport) {
            updateModalWaButtons(currentModalReport, selectEl.value);
        }
    }
    window.onEditShiftChange = onEditShiftChange;

    function updateModalWaButtons(report, selectedShift) {
        if (!report) return;

        const currentWilayahId = document.getElementById('cs_edit_wilayah_id')?.value || report.wilayah_id;
        const currentUnitLokasi = document.getElementById('cs_edit_unit_lokasi')?.value || report.unit_lokasi || 'Unit Terkait';
        const currentUnitId = document.getElementById('cs_edit_unit_id')?.value || report.unit_id;

        let targetUnitId = currentUnitId;
        let targetUnitName = currentUnitLokasi;
        let targetPjNama = report.pj_nama || 'PJ Kebersihan';
        let targetPjKontak = report.pj_kontak || '';

        // Check assigned PJ from penugasanData based on currentWilayahId and selectedShift
        if (currentWilayahId && selectedShift && penugasanData && penugasanData.length > 0) {
            const assignment = penugasanData.find(p => String(p.wilayah_id) === String(currentWilayahId) && String(p.shift).toLowerCase() === String(selectedShift).toLowerCase());
            if (assignment && assignment.unit_id) {
                targetUnitId = assignment.unit_id;
                targetUnitName = assignment.nama_unit || targetUnitName;
                if (assignment.pj_nama) targetPjNama = assignment.pj_nama;
                if (assignment.pj_kontak) targetPjKontak = assignment.pj_kontak;
            }
        }

        // Also check in unitData if pj_kontak is still missing or to get fresh unit details
        if (targetUnitId && unitData && unitData.length > 0) {
            const u = unitData.find(item => String(item.id) === String(targetUnitId));
            if (u) {
                if (!targetUnitName || targetUnitName === 'Unit Terkait') targetUnitName = u.nama_unit;
                if (u.pj_nama) targetPjNama = u.pj_nama;
                if (u.pj_kontak) targetPjKontak = u.pj_kontak;
            }
        }

        if (targetUnitId) {
            const editUnitIdInput = document.getElementById('cs_edit_unit_id');
            if (editUnitIdInput) editUnitIdInput.value = targetUnitId;
        }

        // 1. Build WA URL for PJ Unit responsible for this shift
        let pjPhone = (targetPjKontak || '').replace(/[^0-9]/g, '');
        if (pjPhone.startsWith('0')) pjPhone = '62' + pjPhone.slice(1);
        const waPjBtn = document.getElementById('modal_btn_wa_pj');
        if (waPjBtn) {
            if (pjPhone) {
                const locText = (report.unit_lokasi || '-') + (report.nama_wilayah ? (' - ' + report.nama_wilayah) : '') + (selectedShift ? (' (Shift ' + selectedShift + ')') : '');
                let msgPj = "Assalamu'alaikum Wr. Wb. Pengurus " + targetUnitName + " (" + targetPjNama + "),\n\n"
                    + "🚨 *Pemberitahuan Pengaduan Kebersihan Masuk:*\n"
                    + "Pelapor: " + (report.nama_pengirim || 'Warga/Santri') + " (" + (report.kontak_hp || '-') + ")\n"
                    + "Lokasi: " + locText + "\n"
                    + "Unit Bertanggung Jawab (Shift " + (selectedShift || '-') + "): " + targetUnitName + "\n"
                    + "Isi Pengaduan: \"" + (report.isi_laporan || '-') + "\"\n"
                    + "Tanggal: " + (report.created_at || '') + " WIB\n\n"
                    + "Mohon untuk segera dicek, ditindaklanjuti, dan konfirmasi melalui Portal Kebersihan: https://laporkebersihan.online/app/lapor-wilayah\n\nTerima kasih.\n_Admin Kebersihan Assalafiyyah_";
                waPjBtn.href = "https://api.whatsapp.com/send?phone=" + pjPhone + "&text=" + encodeURIComponent(msgPj);
                waPjBtn.classList.remove('opacity-50', 'pointer-events-none');
                waPjBtn.title = "Teruskan pengaduan ke WhatsApp PJ " + targetUnitName + " (" + targetPjNama + ")";
                waPjBtn.innerHTML = `<i class="fa-solid fa-share-nodes text-xs"></i><span>Teruskan ke WA PJ (${targetUnitName.length > 18 ? targetUnitName.substring(0, 16) + '...' : targetUnitName})</span>`;
            } else {
                waPjBtn.classList.add('opacity-50', 'pointer-events-none');
                waPjBtn.href = "#";
                waPjBtn.title = "Nomor WhatsApp PJ Unit (" + targetUnitName + ") belum tersedia";
                waPjBtn.innerHTML = `<i class="fa-solid fa-share-nodes text-xs"></i><span>WA PJ (${targetUnitName.length > 18 ? targetUnitName.substring(0, 16) + '...' : targetUnitName}) Belum Ada</span>`;
            }
        }

        // 2. Build WA URL for Pelapor
        let pelaporPhone = (report.kontak_hp || '').replace(/[^0-9]/g, '');
        if (pelaporPhone.startsWith('0')) pelaporPhone = '62' + pelaporPhone.slice(1);
        const waPelaporBtn = document.getElementById('modal_btn_wa_pelapor');
        if (waPelaporBtn) {
            if (pelaporPhone) {
                const currentStatus = document.getElementById('cs_status')?.value || report.status || 'Diproses';
                const currentTanggapan = document.getElementById('cs_tanggapan')?.value || report.tanggapan_admin || '';
                let msgPelapor = "Assalamualaikum Wr Wb Kak " + (report.nama_pengirim || '') + ", terima kasih telah melapor ke CS Kebersihan Yayasan.\n\n"
                    + "📌 *Laporan Anda:*\n"
                    + "Lokasi: " + (report.unit_lokasi || '-') + (report.nama_wilayah ? (' - ' + report.nama_wilayah) : '') + (selectedShift ? (' (Shift ' + selectedShift + ')') : '') + "\n"
                    + "Keluhan: \"" + (report.isi_laporan || '-') + "\"\n\n"
                    + "📊 *Status Terbaru:* " + currentStatus + "\n";
                if (currentTanggapan) {
                    msgPelapor += "💬 *Tanggapan Admin:* " + currentTanggapan + "\n";
                }
                msgPelapor += "\nTerima kasih atas kerja samanya dalam menjaga kebersihan pesantren.\n_Admin Kebersihan Assalafiyyah_";
                waPelaporBtn.href = "https://api.whatsapp.com/send?phone=" + pelaporPhone + "&text=" + encodeURIComponent(msgPelapor);
                waPelaporBtn.classList.remove('opacity-50', 'pointer-events-none');
                waPelaporBtn.title = "Kirim WhatsApp ke pelapor (" + (report.nama_pengirim || '') + ")";
            } else {
                waPelaporBtn.classList.add('opacity-50', 'pointer-events-none');
                waPelaporBtn.href = "#";
                waPelaporBtn.title = "Nomor WhatsApp Pelapor tidak tersedia";
            }
        }
    }
    window.updateModalWaButtons = updateModalWaButtons;

    // Open Modal Tanggapi CS
    function openModalTanggapiCs(report) {
        currentModalReport = report;
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

        // Update WhatsApp action buttons based on shift and assigned PJ unit
        const currentShiftVal = document.getElementById('cs_edit_shift')?.value || report.shift;
        updateModalWaButtons(report, currentShiftVal);

        const modal = document.getElementById('modalTanggapiCs');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }
    window.openModalTanggapiCs = openModalTanggapiCs;

    function closeModalTanggapiCs() {
        currentModalReport = null;
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
