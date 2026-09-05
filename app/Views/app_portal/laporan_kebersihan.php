<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header (Struktur/LPJ Style) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-headset text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-headset"></i> Layanan Pengaduan Kebersihan Publik 24/7
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Customer Service & Lapor Kebersihan
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Silakan sampaikan kendala kebersihan, fasilitas rusak, atau pertanyaan seputar kebersihan pesantren. Tim K3L siap membantu.
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Grid & Form (Identical Layout to Public CS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Pengaduan Kendala Kebersihan -->
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-200/80 bg-white space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-emerald-600"></i> Form Lapor Kendala Kebersihan
                </h3>
                <span class="text-[10px] font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                    <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Akun Terverifikasi
                </span>
            </div>

            <!-- Multi-Step Progress Stepper -->
            <div class="mb-5 px-1 sm:px-2">
                <div class="flex items-start justify-between w-full">
                    <!-- Step 1 Trigger -->
                    <button type="button" onclick="goToPortalStep(1)" id="portalStepTab1" class="flex flex-col items-center group cursor-pointer focus:outline-none flex-shrink-0 z-10">
                        <div id="portalStepCircle1" class="w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 ring-4 ring-emerald-50 transition-all duration-300 scale-105">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span id="portalStepLabel1" class="mt-2 text-[11px] font-extrabold text-emerald-800 tracking-tight transition-colors whitespace-nowrap">1. Identitas & Unit</span>
                    </button>

                    <!-- Connector 1-2 -->
                    <div class="flex-1 h-1 bg-slate-200 mx-2 mt-[18px] rounded-full overflow-hidden self-start">
                        <div id="portalProgressLine1" class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-300" style="width: 0%;"></div>
                    </div>

                    <!-- Step 2 Trigger -->
                    <button type="button" onclick="goToPortalStep(2)" id="portalStepTab2" class="flex flex-col items-center group cursor-pointer focus:outline-none flex-shrink-0 z-10">
                        <div id="portalStepCircle2" class="w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm bg-slate-100 text-slate-500 border border-slate-300 ring-4 ring-white transition-all duration-300">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <span id="portalStepLabel2" class="mt-2 text-[11px] font-bold text-slate-500 tracking-tight transition-colors whitespace-nowrap">2. Detail & Foto</span>
                    </button>

                    <!-- Connector 2-3 -->
                    <div class="flex-1 h-1 bg-slate-200 mx-2 mt-[18px] rounded-full overflow-hidden self-start">
                        <div id="portalProgressLine2" class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-300" style="width: 0%;"></div>
                    </div>

                    <!-- Step 3 Trigger -->
                    <button type="button" onclick="goToPortalStep(3)" id="portalStepTab3" class="flex flex-col items-center group cursor-pointer focus:outline-none flex-shrink-0 z-10">
                        <div id="portalStepCircle3" class="w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm bg-slate-100 text-slate-500 border border-slate-300 ring-4 ring-white transition-all duration-300">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <span id="portalStepLabel3" class="mt-2 text-[11px] font-bold text-slate-500 tracking-tight transition-colors whitespace-nowrap">3. Konfirmasi</span>
                    </button>
                </div>
            </div>

            <form action="<?= base_url('cs/public/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4" id="formLaporCsPortal" onsubmit="return validatePortalFinalSubmit(event)">
                <!-- ========================================== -->
                <!-- 🔹 LANGKAH 1: IDENTITAS & LOKASI UNIT     -->
                <!-- ========================================== -->
                <div id="portalStep1" class="portal-step-pane space-y-4 animate-fadeIn">
                    <div class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-center gap-2.5 text-xs text-emerald-900 font-semibold">
                        <div class="w-7 h-7 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 text-xs shadow-xs">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <span>Pastikan data pengirim dan unit tertuju sudah sesuai untuk penanganan kendala kebersihan.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span>Nama Lengkap Pengirim <span class="text-rose-500">*</span></span>
                                <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                    <i class="fa-solid fa-lock text-[9px]"></i> Akun Login
                                </span>
                            </label>
                            <input type="text" id="portal_nama_pengirim" name="nama_pengirim" value="<?= esc($defaultNamaPengirim ?? session()->get('nama_lengkap') ?? $userUnit['pj_nama'] ?? '') ?>" readonly required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-100/90 text-slate-800 cursor-not-allowed shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span>Nomor WhatsApp / HP <span class="text-rose-500">*</span></span>
                                <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp text-[9px]"></i> Nomor Aktif
                                </span>
                            </label>
                            <input type="text" id="portal_kontak_hp" name="kontak_hp" value="<?= esc($defaultKontakHp ?? $userUnit['pj_kontak'] ?? '') ?>" placeholder="081234567890" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>

                    <?php
                        $userUnitId = session()->get('unit_id');
                        $preselectedUnitName = '';
                        if ($userUnitId && !empty($unitList)) {
                            foreach ($unitList as $u) {
                                if ((int)$u['id'] === (int)$userUnitId) {
                                    $preselectedUnitName = $u['nama_unit'];
                                    break;
                                }
                            }
                        }
                    ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Searchable Unit Picker in Portal Form -->
                        <div class="relative">
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span>1. Lokasi / Unit Tertuju <span class="text-rose-500">*</span></span>
                                <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                    <i class="fa-solid fa-magnifying-glass text-[9px]"></i> Bisa dicari
                                </span>
                            </label>
                            <input type="hidden" id="portal_unit_id" name="unit_id" value="<?= esc($userUnit['id'] ?? '') ?>">
                            <input type="hidden" id="portal_unit_lokasi" name="unit_lokasi" required value="<?= esc($userUnit['nama_unit'] ?? '') ?>">
                            <div class="relative">
                                <i class="fa-solid fa-building text-emerald-600 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs pointer-events-none"></i>
                                <input type="text" id="portal_unit_search" value="<?= esc($userUnit['nama_unit'] ?? '') ?>" placeholder="Pilih unit / asrama terkait..." autocomplete="off" required onfocus="openPortalUnitDropdown()" oninput="filterPortalUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                                <button type="button" onclick="togglePortalUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                    <i id="portalUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                                </button>
                            </div>
                            <!-- Dropdown List -->
                            <div id="portalUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                                <?php if (!empty($unitList)): ?>
                                    <?php foreach ($unitList as $u): ?>
                                        <div class="portal-unit-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['nama_unit']) ?>" onclick="selectPortalUnit(this)">
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
                                <div id="noPortalUnitFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                    Tidak ditemukan unit yang sesuai.
                                </div>
                            </div>
                        </div>
                        <!-- Searchable Wilayah Picker in Portal Form -->
                        <div class="relative">
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span>2. Wilayah Pemetaan</span>
                                <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                    <i class="fa-solid fa-filter text-[9px]"></i> Sesuai Unit
                                </span>
                            </label>
                            <input type="hidden" id="portal_wilayah_id" name="wilayah_id" value="">
                            <div class="relative">
                                <i class="fa-solid fa-map-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none"></i>
                                <input type="text" id="portal_wilayah_search" placeholder="Pilih unit terlebih dahulu..." autocomplete="off" onclick="openPortalWilayahDropdown()" onfocus="openPortalWilayahDropdown()" oninput="filterPortalWilayahOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                                <button type="button" onclick="togglePortalWilayahDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                    <i id="portalWilayahIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                                </button>
                            </div>
                            <!-- Dropdown List -->
                            <div id="portalWilayahDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                                <div class="portal-wilayah-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="" data-name="" data-lokasi-gedung="" onclick="selectPortalWilayah(this)">
                                    <div>
                                        <div class="font-extrabold text-xs text-slate-600 italic">-- Bukan Wilayah Khusus / Umum --</div>
                                        <div class="text-[10px] text-slate-400 font-medium">Laporan umum lingkungan unit (tanpa spot wilayah khusus)</div>
                                    </div>
                                </div>
                                <?php if (!empty($wilayahList)): ?>
                                    <?php foreach ($wilayahList as $w): ?>
                                        <div class="portal-wilayah-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $w['id'] ?>" data-name="<?= esc($w['nama_wilayah']) ?>" data-lokasi-gedung="<?= esc(strtolower($w['lokasi_gedung'] ?? '')) ?>" onclick="selectPortalWilayah(this)">
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
                                <div id="noPortalWilayahFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                                    Tidak ada spot wilayah pemetaan di unit ini.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Lanjut ke Langkah 2 -->
                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="button" onclick="nextPortalStep(1)" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 group cursor-pointer">
                            <span>Lanjut: Detail & Foto Bukti</span>
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 🔹 LANGKAH 2: DETAIL KENDALA & FOTO BUKTI -->
                <!-- ========================================== -->
                <div id="portalStep2" class="portal-step-pane space-y-4 hidden animate-fadeIn">
                    <!-- Dynamic Step 3: Shift Selection with Smart PJ Routing in Portal -->
                    <div id="portalShiftContainer" class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2.5 hidden animate-fadeIn">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-extrabold text-emerald-950 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-emerald-600"></i>
                                <span>Pilih Shift & Penanggung Jawab Terkait</span>
                            </label>
                            <span id="portalShiftAutoBadge" class="text-[10px] text-emerald-700 bg-white px-2.5 py-0.5 rounded-full border border-emerald-200 font-bold flex items-center gap-1 shadow-2xs">
                                <i class="fa-solid fa-wand-magic-sparkles text-[9px]"></i> Rekomendasi Waktu
                            </span>
                        </div>
                        <select id="portal_shift_select" name="shift" onchange="onPortalShiftChange(this)" class="w-full px-4 py-2.5 rounded-xl border border-emerald-300 text-xs font-bold bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                            <!-- Populated dynamically via JS -->
                        </select>
                        <div id="portalShiftInfoPj" class="text-[11px] text-emerald-900 font-semibold flex items-center gap-1.5 pt-0.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600 text-xs"></i>
                            <span>Laporan akan otomatis diteruskan ke Penanggung Jawab: <b id="portalTargetUnitName" class="text-emerald-950 underline font-extrabold">-</b></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Pengaduan <span class="text-rose-500">*</span></label>
                        <select id="portal_kategori" name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="Kendala Kebersihan">Kendala Kebersihan / Sampah Penuh</option>
                            <option value="Fasilitas Rusak">Fasilitas Tempat Kebersihan Rusak</option>
                            <option value="Pertanyaan/Konsultasi">Pertanyaan / Konsultasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Isi Pesan Laporan / Pengaduan <span class="text-rose-500">*</span></span>
                            <span class="text-[10px] text-slate-400 font-medium">Jelaskan sedetail mungkin</span>
                        </label>
                        <textarea id="portal_isi_laporan" name="isi_laporan" rows="4" placeholder="Jelaskan kendala kebersihan atau hal yang ingin disampaikan ke Admin K3L..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                    </div>

                    <!-- Multiple Photo Upload with Separate Camera & Gallery Buttons and Delete Feature -->
                    <div class="space-y-3 p-4 rounded-2xl bg-slate-50/90 border border-slate-200">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-camera-retro text-emerald-600"></i>
                                <span>Foto Bukti / Lokasi Kendala</span>
                            </label>
                            <span class="text-[10px] text-slate-500 font-medium">Bisa lebih dari 1 foto (Opsional)</span>
                        </div>

                        <!-- Hidden Inputs for Camera and Gallery -->
                        <input type="file" id="portalCameraInput" accept="image/*" capture="environment" class="hidden" onchange="handlePortalFiles(this.files)">
                        <input type="file" id="portalGalleryInput" accept="image/*" multiple class="hidden" onchange="handlePortalFiles(this.files)">
                        <!-- Real Form File Input Container managed by DataTransfer -->
                        <input type="file" id="portalRealInput" name="foto_files[]" multiple class="hidden">

                        <!-- Action Buttons: Kamera & Galeri -->
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" onclick="document.getElementById('portalCameraInput').click()" class="py-3 px-4 rounded-2xl bg-white hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-400 text-slate-700 hover:text-emerald-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2 cursor-pointer">
                                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <span>Buka Kamera</span>
                            </button>

                            <button type="button" onclick="document.getElementById('portalGalleryInput').click()" class="py-3 px-4 rounded-2xl bg-white hover:bg-teal-50/80 border border-slate-200 hover:border-teal-400 text-slate-700 hover:text-teal-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2 cursor-pointer">
                                <div class="w-7 h-7 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                                    <i class="fa-solid fa-images"></i>
                                </div>
                                <span>Pilih Galeri</span>
                            </button>
                        </div>

                        <!-- Live Thumbnail Preview Container with Delete Button -->
                        <div id="portalFotoPreviewContainer" class="flex flex-wrap gap-3 pt-2 hidden border-t border-slate-200/70"></div>
                    </div>

                    <!-- Tombol Navigasi Langkah 2 -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <button type="button" onclick="prevPortalStep(2)" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Kembali</span>
                        </button>
                        <button type="button" onclick="nextPortalStep(2)" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2 group cursor-pointer">
                            <span>Lanjut: Konfirmasi & Kirim</span>
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 🔹 LANGKAH 3: KONFIRMASI & KIRIM          -->
                <!-- ========================================== -->
                <div id="portalStep3" class="portal-step-pane space-y-4 hidden animate-fadeIn">
                    <!-- Review Summary Card -->
                    <div class="rounded-3xl bg-gradient-to-br from-emerald-50/80 via-teal-50/40 to-slate-50 p-5 border border-emerald-200/80 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-emerald-200/60 pb-3">
                            <h4 class="font-heading font-extrabold text-xs text-emerald-950 flex items-center gap-2 uppercase tracking-wider">
                                <i class="fa-solid fa-clipboard-check text-emerald-600 text-sm"></i>
                                <span>Ringkasan Data Pengaduan Anda</span>
                            </h4>
                            <button type="button" onclick="goToPortalStep(1)" class="text-[11px] text-emerald-700 hover:text-emerald-800 font-bold bg-white px-2.5 py-1 rounded-xl border border-emerald-200 shadow-2xs flex items-center gap-1 hover:shadow-xs transition">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit Data
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="bg-white/90 p-3 rounded-2xl border border-emerald-100 shadow-2xs space-y-1">
                                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-user text-emerald-600"></i> Pengirim Laporan
                                </span>
                                <div id="portalReviewPengirim" class="font-extrabold text-slate-900 text-xs">-</div>
                                <div id="portalReviewKontak" class="text-[11px] text-slate-500 font-semibold font-mono">-</div>
                            </div>

                            <div class="bg-white/90 p-3 rounded-2xl border border-emerald-100 shadow-2xs space-y-1">
                                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i> Lokasi & Shift
                                </span>
                                <div id="portalReviewLokasi" class="font-extrabold text-slate-900 text-xs">-</div>
                                <div id="portalReviewShiftPj" class="text-[11px] text-emerald-700 font-semibold">-</div>
                            </div>
                        </div>

                        <div class="bg-white/90 p-3.5 rounded-2xl border border-emerald-100 shadow-2xs space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-tag text-teal-600"></i> Kategori
                                </span>
                                <span id="portalReviewKategori" class="text-[10px] font-extrabold text-emerald-800 bg-emerald-100/80 px-2.5 py-0.5 rounded-full border border-emerald-200">-</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block mb-1">Isi Kendala / Pesan:</span>
                                <div id="portalReviewIsi" class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-700 font-medium whitespace-pre-wrap leading-relaxed italic">-</div>
                            </div>
                        </div>

                        <div id="portalReviewFotosWrapper" class="hidden bg-white/90 p-3.5 rounded-2xl border border-emerald-100 shadow-2xs space-y-2">
                            <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-images text-emerald-600"></i> Foto Bukti Terlampir (<span id="portalReviewFotoCount">0</span>)
                            </span>
                            <div id="portalReviewFotosContainer" class="flex flex-wrap gap-2.5 pt-1"></div>
                        </div>
                    </div>

                    <!-- Tombol Navigasi Langkah 3 / Submit -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <button type="button" onclick="prevPortalStep(3)" class="px-5 py-3.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Kembali</span>
                        </button>
                        <button type="submit" id="btnSubmitCsPortal" class="flex-1 sm:flex-none px-7 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-lg shadow-emerald-600/25 flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Pengaduan Ke Tim CS K3L</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Contacts Side Cards -->
        <div class="space-y-5">
            <div class="glass-card rounded-3xl p-6 shadow-xl border border-slate-200/80 bg-white space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-500/20">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="font-heading font-extrabold text-base text-slate-900">WhatsApp Live CS</h3>
                    <p class="text-xs text-slate-500 font-medium">Layanan respon instan via WA Pengurus K3L.</p>
                </div>
                <?php
                    $rawWa = $settings['hotline_wa'] ?? '081802787499';
                    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
                    if (str_starts_with($cleanWa, '0')) {
                        $cleanWa = '62' . substr($cleanWa, 1);
                    }
                ?>
                <a href="https://wa.me/<?= $cleanWa ?>?text=Halo%20Admin%20K3L,%20saya%20butuh%20bantuan" target="_blank" class="w-full py-3 rounded-2xl bg-emerald-600 text-white font-heading font-extrabold text-xs hover:bg-emerald-700 transition flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20">
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
                    <p class="text-xs text-slate-500 font-medium">Kantor Kebersihan Yayasan Assalafiyyah Mlangi.</p>
                </div>
                <span class="inline-block w-full py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-extrabold text-xs text-center border border-slate-200">
                    Jam Operasional: <?= esc($settings['jam_cs_buka'] ?? '06:00') ?> – <?= esc($settings['jam_cs_tutup'] ?? '21:00') ?> WIB
                </span>
            </div>
        </div>
    </div>

    <!-- Panel 1: Pengaduan & Kendala Masuk ke Unit Kami -->
    <?php if (!empty($userUnit) || session()->get('role') === 'Admin'): ?>
    <div id="sectionAduanUnit" class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="font-heading font-extrabold text-lg text-slate-900">
                            Pengaduan & Kendala Masuk ke Unit <?= esc($userUnit['nama_unit'] ?? 'Saya') ?>
                        </h3>
                        <span class="text-[11px] font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/90 shadow-2xs whitespace-nowrap">
                            <?= count($unitAssignedReports) ?> Aduan
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">Laporan kendala kebersihan dari warga/santri di area unit Anda. Silakan tindak lanjuti dan beri konfirmasi.</p>
                </div>
            </div>

            <div class="relative w-full sm:w-60">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" id="searchUnitAduanInput" onkeyup="filterUnitAduanTable()" placeholder="Cari aduan unit..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
            <table id="tableUnitAduan" class="w-full text-left text-xs font-semibold">
                <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th width="4%" class="py-3.5 px-3 text-center">NO</th>
                        <th width="14%" class="py-3.5 px-4">TANGGAL</th>
                        <th width="20%" class="py-3.5 px-4">PELAPOR & WILAYAH</th>
                        <th width="28%" class="py-3.5 px-4">ISI KELUHAN & BUKTI</th>
                        <th width="22%" class="py-3.5 px-4">RESPON & TINDAKAN UNIT</th>
                        <th width="12%" class="py-3.5 px-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php if (!empty($unitAssignedReports)): ?>
                        <?php foreach ($unitAssignedReports as $idx => $r): ?>
                            <?php 
                                $cleanHp = preg_replace('/[^0-9]/', '', $r['kontak_hp'] ?? '');
                                if (substr($cleanHp, 0, 1) === '0') $cleanHp = '62' . substr($cleanHp, 1);
                            ?>
                            <tr class="unit-aduan-row hover:bg-slate-50/90 transition-all">
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
                                    <div class="mt-1">
                                        <?php if ($r['status'] === 'Baru'): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-extrabold border border-blue-300 shadow-2xs">Baru</span>
                                        <?php elseif ($r['status'] === 'Diproses'): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 text-[10px] font-extrabold border border-amber-200 shadow-2xs">Diproses</span>
                                        <?php elseif ($r['status'] === 'Ditolak'): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-800 text-[10px] font-extrabold border border-rose-200 shadow-2xs">Ditolak</span>
                                        <?php else: ?>
                                            <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 text-[10px] font-extrabold border border-teal-200 shadow-2xs">Selesai</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900 text-xs"><?= esc($r['nama_pengirim']) ?></div>
                                    <?php if (!empty($r['kontak_hp'])): ?>
                                        <a href="https://wa.me/<?= $cleanHp ?>" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-mono text-[10px] font-bold border border-emerald-200/80 transition mt-1">
                                            <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                            <span><?= esc($r['kontak_hp']) ?></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php 
                                        $namaWilayah = !empty($r['nama_wilayah']) ? $r['nama_wilayah'] : '';
                                        $namaUnit = !empty($r['lokasi_gedung']) ? $r['lokasi_gedung'] : (!empty($r['unit_lokasi']) ? $r['unit_lokasi'] : '');
                                        $gabunganLokasi = $namaWilayah ? ($namaWilayah . ' - ' . $namaUnit) : $namaUnit;
                                    ?>
                                    <div class="mt-1.5 flex flex-col gap-1">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-teal-50 text-teal-800 border border-teal-200/80 text-[10px] font-extrabold shadow-2xs w-fit">
                                            <i class="fa-solid fa-map-location-dot text-teal-600 text-[10px]"></i>
                                            <span><?= esc($gabunganLokasi) ?></span>
                                        </div>
                                        <div class="flex items-center gap-1 flex-wrap">
                                            <?php if (!empty($r['luas_area'])): ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200/80 text-[10px] font-extrabold shadow-2xs" title="Ukuran / Luas Area">
                                                    <i class="fa-solid fa-ruler-combined text-teal-600 text-[9px]"></i>
                                                    <span><?= esc($r['luas_area']) ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (!empty($r['shift'])): ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200/80 text-[10px] font-extrabold shadow-2xs w-fit">
                                                    <i class="fa-regular fa-clock text-amber-600 text-[9px]"></i>
                                                    <span>Shift <?= esc($r['shift']) ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                        "<?= esc($r['isi_laporan']) ?>"
                                    </div>
                                    <?php 
                                        $inFotos = json_decode($r['foto_lampiran'] ?? '[]', true) ?: [];
                                    ?>
                                    <?php if (!empty($inFotos)): ?>
                                        <div class="mt-2 flex flex-wrap items-center gap-1.5">
                                            <?php foreach ($inFotos as $f): ?>
                                                <?php $fUrl = (strpos($f, 'http://') === 0 || strpos($f, 'https://') === 0) ? $f : base_url('uploads/cs/' . $f); ?>
                                                <a href="<?= $fUrl ?>" target="_blank" class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200 hover:border-emerald-500 shadow-2xs hover:scale-105 transition flex-shrink-0" title="Foto lampiran pelapor">
                                                    <img src="<?= $fUrl ?>" class="w-full h-full object-cover">
                                                </a>
                                            <?php endforeach; ?>
                                            <span class="text-[9px] font-extrabold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">
                                                <?= count($inFotos) ?> Foto
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if (!empty($r['tanggapan_unit'])): ?>
                                        <div class="p-2.5 rounded-2xl bg-sky-50 border border-sky-200 text-sky-950 text-xs font-medium space-y-1 shadow-2xs">
                                            <div class="font-extrabold text-sky-800 text-[10px] uppercase flex items-center justify-between">
                                                <span><i class="fa-solid fa-check text-sky-600"></i> Oleh: <?= esc($r['nama_penanggap_unit'] ?: 'Pengurus') ?></span>
                                                <?php if (!empty($r['ditanggapi_unit_at'])): ?>
                                                    <span class="font-mono text-[9px] text-sky-600 font-bold lowercase"><?= date('d M H:i', strtotime($r['ditanggapi_unit_at'])) ?> WIB</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-slate-700 leading-relaxed"><?= esc($r['tanggapan_unit']) ?></div>
                                            <?php 
                                                $uActFotos = json_decode($r['foto_tindakan_unit'] ?? '[]', true) ?: [];
                                            ?>
                                            <?php if (!empty($uActFotos)): ?>
                                                <div class="pt-1 flex flex-wrap gap-1">
                                                    <?php foreach ($uActFotos as $uaf): ?>
                                                        <?php $uafUrl = (strpos($uaf, 'http://') === 0 || strpos($uaf, 'https://') === 0) ? $uaf : base_url('uploads/cs/' . $uaf); ?>
                                                        <a href="<?= $uafUrl ?>" target="_blank" class="w-7 h-7 rounded overflow-hidden border border-sky-200">
                                                            <img src="<?= $uafUrl ?>" class="w-full h-full object-cover">
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-[11px] text-amber-700 bg-amber-50 border border-amber-200/80 p-2 rounded-xl flex items-center gap-1.5 font-bold">
                                            <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                                            <span>Belum ada tindakan / respon unit</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <button type="button" onclick="openModalTindakLanjutUnit(<?= htmlspecialchars(json_encode($r)) ?>)" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition flex items-center justify-center gap-1.5 mx-auto">
                                        <span><?= !empty($r['tanggapan_unit']) ? 'Edit Respon' : 'Tindak Lanjuti' ?></span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 italic font-medium">Tidak ada pengaduan kendala kebersihan masuk untuk unit ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer for Unit Aduan -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-unit-aduan">
            <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                <span id="page-info-unit-aduan">Menampilkan <?= !empty($unitAssignedReports) ? ('1 - ' . min(10, count($unitAssignedReports)) . ' dari ' . count($unitAssignedReports) . ' data') : '0 data' ?></span>
                <select id="pageSize-unit-aduan" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    <option value="5">5 / hal</option>
                    <option value="10" selected>10 / hal</option>
                    <option value="25">25 / hal</option>
                    <option value="50">50 / hal</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="page-buttons-unit-aduan"></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Riwayat Lapor Kendala Kebersihan Saya Table Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">
                        Riwayat Lapor Kendala Kebersihan Saya
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Status pengaduan & tanggapan admin Kebersihan atas laporan yang Anda kirimkan.</p>
                </div>
            </div>

            <div class="relative w-full sm:w-60">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" id="searchMyReportCSInput" onkeyup="filterMyReportCSTable()" placeholder="Cari lokasi / isi laporan..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-800/20 shadow-2xs">
            <table id="tableMyReportCS" class="w-full text-left text-xs font-semibold">
                <thead class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white font-heading font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th width="5%" class="py-3.5 px-3 text-center">NO</th>
                        <th width="15%" class="py-3.5 px-4">TANGGAL</th>
                        <th width="25%" class="py-3.5 px-4">LOKASI & KATEGORI</th>
                        <th width="35%" class="py-3.5 px-4">ISI LAPORAN PENGADUAN</th>
                        <th width="20%" class="py-3.5 px-4 text-center">STATUS & CATATAN ADMIN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php if (!empty($myReports)): ?>
                        <?php foreach ($myReports as $idx => $r): ?>
                            <tr class="my-report-cs-row hover:bg-slate-50/90 transition-all">
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
                                    <?php 
                                        $myNamaWilayah = !empty($r['nama_wilayah']) ? $r['nama_wilayah'] : '';
                                        $myNamaUnit = !empty($r['lokasi_gedung']) ? $r['lokasi_gedung'] : (!empty($r['unit_lokasi']) ? $r['unit_lokasi'] : '');
                                        $myGabunganLokasi = $myNamaWilayah ? ($myNamaWilayah . ' - ' . $myNamaUnit) : $myNamaUnit;
                                    ?>
                                    <div class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-emerald-600"></i>
                                        <span><?= esc($myGabunganLokasi) ?></span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 mt-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold border border-emerald-200/80 shadow-2xs">
                                            <i class="fa-solid fa-tag text-[9px]"></i>
                                            <?= esc($r['kategori']) ?>
                                        </span>
                                        <?php if (!empty($r['luas_area'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200/80 text-[10px] font-extrabold shadow-2xs" title="Ukuran / Luas Area">
                                                <i class="fa-solid fa-ruler-combined text-teal-600 text-[9px]"></i>
                                                <span><?= esc($r['luas_area']) ?></span>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($r['shift'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200/80 text-[10px] font-extrabold shadow-2xs">
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
                                        <div class="mt-2 flex flex-wrap items-center gap-1.5">
                                            <?php foreach ($fotos as $f): ?>
                                                <?php 
                                                    $imgUrl = (strpos($f, 'http://') === 0 || strpos($f, 'https://') === 0) ? $f : base_url('uploads/cs/' . $f);
                                                ?>
                                                <a href="<?= $imgUrl ?>" target="_blank" class="group relative block w-9 h-9 rounded-xl overflow-hidden border border-slate-200 hover:border-emerald-500 shadow-2xs hover:scale-105 transition flex-shrink-0" title="Klik untuk perbesar foto (Cloudinary)">
                                                    <img src="<?= $imgUrl ?>" alt="Bukti Laporan" class="w-full h-full object-cover">
                                                </a>
                                            <?php endforeach; ?>
                                            <span class="text-[9px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                                <?= count($fotos) ?> Foto
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <?php if ($r['status'] === 'Baru'): ?>
                                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-extrabold border border-blue-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-info text-blue-600 text-[10px]"></i>
                                            Baru
                                        </span>
                                    <?php elseif ($r['status'] === 'Diproses'): ?>
                                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                            Diproses
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200/90 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                            Selesai
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($r['tanggapan_admin'])): ?>
                                        <div class="mt-1.5 p-2 rounded-xl bg-emerald-50/80 border border-emerald-200/70 text-emerald-950 text-[10px] font-semibold text-left max-w-xs" title="<?= esc($r['tanggapan_admin']) ?>">
                                            Catatan Admin: "<?= esc($r['tanggapan_admin']) ?>"
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 italic font-medium">Belum ada riwayat pengaduan kendala kebersihan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-my-report-cs">
            <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                <span id="page-info-my-report-cs">Menampilkan <?= !empty($myReports) ? ('1 - ' . min(10, count($myReports)) . ' dari ' . count($myReports) . ' data') : '0 data' ?></span>
                <select id="pageSize-my-report-cs" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    <option value="5">5 / hal</option>
                    <option value="10" selected>10 / hal</option>
                    <option value="25">25 / hal</option>
                    <option value="50">50 / hal</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="page-buttons-my-report-cs"></div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- 📝 MODAL TINDAK LANJUT / RESPON UNIT TERKAIT ADUAN  -->
<!-- ==================================================== -->
<div id="modalTindakLanjutUnit" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-md hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl space-y-6 border border-slate-100 my-auto animate-in fade-in zoom-in duration-200">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-600/20 flex-shrink-0">
                    <i class="fa-solid fa-clipboard-check text-sm"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">
                        Tindak Lanjut & Respon Unit
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Beri tanggapan dan lampirkan bukti penanganan di unit Anda.</p>
                </div>
            </div>
            <button onclick="closeModalTindakLanjutUnit()" class="w-9 h-9 rounded-2xl bg-slate-100 text-slate-400 hover:text-slate-700 hover:bg-slate-200 flex items-center justify-center transition shadow-2xs">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Detail Keluhan Box -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
            <div class="flex items-center justify-between text-[11px] font-bold text-slate-500">
                <span id="modal_unit_pengirim_display">Pelapor: -</span>
                <span id="modal_unit_lokasi_display">Lokasi: -</span>
            </div>
            <div class="text-xs text-slate-800 font-medium leading-relaxed" id="modal_unit_laporan_display">
                "-"
            </div>
        </div>

        <!-- Form Respon Unit -->
        <form id="formTindakLanjutUnit" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-pen-to-square text-emerald-600 text-[10px]"></i>
                    <span>Tindakan & Klarifikasi dari Unit <span class="text-rose-500">*</span></span>
                </label>
                <textarea name="tanggapan_unit" id="unit_tanggapan_input" rows="3" required placeholder="Jelaskan tindakan yang telah / sedang dilakukan (contoh: Area sudah dibersihkan dan dipel oleh piket asrama jam 11:00)..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50/80 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
            </div>

            <!-- Upload Foto Bukti Tindakan Unit (Existing & Baru) -->
            <div class="space-y-3 p-3.5 rounded-2xl bg-slate-50/90 border border-slate-200">
                <div class="flex items-center justify-between">
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1">
                        <i class="fa-solid fa-camera text-emerald-600 text-[10px]"></i>
                        <span>Foto Bukti Pembersihan / Tindakan (Opsional)</span>
                    </label>
                    <span class="text-[10px] text-slate-400 font-medium">Bisa lebih dari 1 foto</span>
                </div>

                <!-- Existing Saved Photos in Modal -->
                <div id="unitExistingFotosSection" class="space-y-1.5 hidden">
                    <div id="unitExistingFotosContainer" class="flex flex-wrap gap-2.5"></div>
                </div>
                
                <input type="file" id="unitCameraInput" accept="image/*" capture="environment" class="hidden" onchange="handleUnitActionFiles(this.files)">
                <input type="file" id="unitGalleryInput" accept="image/*" multiple class="hidden" onchange="handleUnitActionFiles(this.files)">
                <input type="file" id="unitRealInput" name="foto_tindakan_files[]" multiple class="hidden">

                <div class="grid grid-cols-2 gap-2.5">
                    <button type="button" onclick="document.getElementById('unitCameraInput').click()" class="py-2.5 px-3 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-slate-700 hover:text-emerald-700 font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-camera text-emerald-600"></i>
                        <span>Ambil Kamera</span>
                    </button>
                    <button type="button" onclick="document.getElementById('unitGalleryInput').click()" class="py-2.5 px-3 rounded-xl bg-white hover:bg-teal-50 border border-slate-200 hover:border-teal-300 text-slate-700 hover:text-teal-700 font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-images text-teal-600"></i>
                        <span>Pilih Galeri</span>
                    </button>
                </div>
                <div id="unitActionFotoPreviewContainer" class="flex flex-wrap gap-2.5 pt-1.5 hidden"></div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-traffic-light text-emerald-600 text-[10px]"></i>
                    <span>Usulan Status</span>
                </label>
                <select name="status_usulan" id="unit_status_usulan" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-extrabold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="Selesai">🟢 Selesai (Sudah Tuntas / Bersih)</option>
                    <option value="Diproses">⏳ Diproses (Sedang Ditangani Lapangan)</option>
                </select>
            </div>

            <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-slate-100">
                <button type="button" onclick="closeModalTindakLanjutUnit()" class="px-5 py-2.5 rounded-2xl text-slate-600 hover:text-slate-800 text-xs font-bold hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:shadow-lg transition flex items-center gap-1.5">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Respon Unit</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var paginatorMyReportCS, paginatorUnitAduan;
    var portalDataTransfer = new DataTransfer();
    var portalFileNames = [];
    var unitActionDataTransfer = new DataTransfer();
    var currentUnitExistingFotos = [];

    function initCSReportPaginator() {
        if (typeof TablePaginator !== 'undefined') {
            if (document.getElementById('tableMyReportCS')) {
                paginatorMyReportCS = new TablePaginator('tableMyReportCS', 'page-info-my-report-cs', 'page-buttons-my-report-cs', 'pageSize-my-report-cs');
                paginatorMyReportCS.render();
            }
            if (document.getElementById('tableUnitAduan')) {
                paginatorUnitAduan = new TablePaginator('tableUnitAduan', 'page-info-unit-aduan', 'page-buttons-unit-aduan', 'pageSize-unit-aduan');
                paginatorUnitAduan.render();
            }
        }
    }
    window.initCSReportPaginator = initCSReportPaginator;
    window.rebindPageEvents = initCSReportPaginator;

    document.addEventListener('DOMContentLoaded', initCSReportPaginator);
    initCSReportPaginator();

    function filterUnitAduanTable() {
        const input = document.getElementById('searchUnitAduanInput');
        if (!input) return;
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#tableUnitAduan tbody tr.unit-aduan-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
        });

        if (paginatorUnitAduan) {
            paginatorUnitAduan.currentPage = 1;
            paginatorUnitAduan.render();
        }
    }
    window.filterUnitAduanTable = filterUnitAduanTable;

    function openModalTindakLanjutUnit(report) {
        const form = document.getElementById('formTindakLanjutUnit');
        if (form) {
            form.action = "<?= base_url('app/aduan-unit/tanggapi/') ?>" + report.id;
        }
        const pengirimEl = document.getElementById('modal_unit_pengirim_display');
        if (pengirimEl) pengirimEl.textContent = 'Pelapor: ' + (report.nama_pengirim || '-') + ' (' + (report.kontak_hp || '-') + ')';
        const lokasiEl = document.getElementById('modal_unit_lokasi_display');
        const namaGedung = report.lokasi_gedung || report.unit_lokasi || '-';
        const lokasiStr = (report.nama_wilayah ? (report.nama_wilayah + ' - ') : '') + namaGedung + (report.shift ? (' • Shift ' + report.shift) : '');
        if (lokasiEl) lokasiEl.textContent = 'Lokasi: ' + lokasiStr;
        const laporanEl = document.getElementById('modal_unit_laporan_display');
        if (laporanEl) laporanEl.textContent = '"' + (report.isi_laporan || '') + '"';

        const tanggapanInput = document.getElementById('unit_tanggapan_input');
        if (tanggapanInput) tanggapanInput.value = report.tanggapan_unit || '';

        const statusSelect = document.getElementById('unit_status_usulan');
        if (statusSelect) {
            statusSelect.value = (report.status === 'Selesai') ? 'Selesai' : 'Diproses';
        }

        // Render existing saved photos of unit response
        currentUnitExistingFotos = [];
        try {
            currentUnitExistingFotos = JSON.parse(report.foto_tindakan_unit || '[]');
            if (!Array.isArray(currentUnitExistingFotos)) currentUnitExistingFotos = [];
        } catch(e) {
            currentUnitExistingFotos = [];
        }
        renderUnitExistingFotos();

        // Reset new uploads
        unitActionDataTransfer = new DataTransfer();
        syncUnitActionRealInput();
        renderUnitActionPreviews();

        const modal = document.getElementById('modalTindakLanjutUnit');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalTindakLanjutUnit = openModalTindakLanjutUnit;

    function renderUnitExistingFotos() {
        const section = document.getElementById('unitExistingFotosSection');
        const container = document.getElementById('unitExistingFotosContainer');
        if (!section || !container) return;

        container.innerHTML = '';
        if (currentUnitExistingFotos.length === 0) {
            section.classList.add('hidden');
            return;
        }

        section.classList.remove('hidden');
        currentUnitExistingFotos.forEach((f, idx) => {
            const imgUrl = (f.indexOf('http://') === 0 || f.indexOf('https://') === 0) ? f : ('<?= base_url('uploads/cs/') ?>/' + f);
            const card = document.createElement('div');
            card.className = 'w-20 bg-white rounded-xl border border-slate-200 shadow-2xs p-1 flex flex-col gap-1 flex-shrink-0 relative group';
            card.innerHTML = `
                <div class="relative w-full h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-100">
                    <img src="${imgUrl}" class="w-full h-full object-cover">
                    <button type="button" onclick="removeExistingUnitFoto(${idx})" class="absolute top-0.5 right-0.5 w-5 h-5 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-[9px] shadow-md transition" title="Hapus foto ini">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <input type="hidden" name="existing_foto_tindakan[]" value="${f}">
                <span class="text-[9px] font-extrabold text-slate-500 text-center truncate">Foto ${idx + 1}</span>
            `;
            container.appendChild(card);
        });
    }
    window.renderUnitExistingFotos = renderUnitExistingFotos;

    function removeExistingUnitFoto(index) {
        currentUnitExistingFotos.splice(index, 1);
        renderUnitExistingFotos();
    }
    window.removeExistingUnitFoto = removeExistingUnitFoto;

    function closeModalTindakLanjutUnit() {
        const modal = document.getElementById('modalTindakLanjutUnit');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalTindakLanjutUnit = closeModalTindakLanjutUnit;

    function handleUnitActionFiles(files) {
        if (!files || files.length === 0) return;
        Array.from(files).forEach(file => {
            unitActionDataTransfer.items.add(file);
        });
        syncUnitActionRealInput();
        renderUnitActionPreviews();
    }
    window.handleUnitActionFiles = handleUnitActionFiles;

    function syncUnitActionRealInput() {
        const realInput = document.getElementById('unitRealInput');
        if (realInput) {
            realInput.files = unitActionDataTransfer.files;
        }
    }

    function renderUnitActionPreviews() {
        const container = document.getElementById('unitActionFotoPreviewContainer');
        if (!container) return;
        container.innerHTML = '';
        const files = unitActionDataTransfer.files;

        if (files.length === 0) {
            container.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.className = 'w-20 bg-white rounded-xl border border-slate-200 shadow-2xs p-1 flex flex-col gap-1 flex-shrink-0';
                card.innerHTML = `
                    <div class="relative w-full h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-100">
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <button type="button" onclick="removeUnitActionFile(${index})" class="absolute top-0.5 right-0.5 w-4 h-4 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-[8px] shadow transition" title="Hapus foto">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                `;
                container.appendChild(card);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeUnitActionFile(index) {
        const dt = new DataTransfer();
        const files = unitActionDataTransfer.files;
        for (let i = 0; i < files.length; i++) {
            if (i !== index) dt.items.add(files[i]);
        }
        unitActionDataTransfer = dt;
        syncUnitActionRealInput();
        renderUnitActionPreviews();
    }
    window.removeUnitActionFile = removeUnitActionFile;

    function filterMyReportCSTable() {
        const input = document.getElementById('searchMyReportCSInput');
        if (!input) return;
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#tableMyReportCS tbody tr.my-report-cs-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
        });

        if (paginatorMyReportCS) {
            paginatorMyReportCS.currentPage = 1;
            paginatorMyReportCS.render();
        }
    }
    window.filterMyReportCSTable = filterMyReportCSTable;

    function handlePortalFiles(files) {
        if (!files || files.length === 0) return;

        Array.from(files).forEach(file => {
            portalDataTransfer.items.add(file);
            // Default file name derived from original filename or label
            const defaultName = file.name.replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9_\-\s]/g, "");
            portalFileNames.push(defaultName || `bukti_${portalFileNames.length + 1}`);
        });

        syncPortalRealInput();
        renderPortalPreviews();
    }
    window.handlePortalFiles = handlePortalFiles;

    function removePortalFile(index) {
        const dt = new DataTransfer();
        const files = portalDataTransfer.files;
        const newNames = [];
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
                newNames.push(portalFileNames[i]);
            }
        }
        portalDataTransfer = dt;
        portalFileNames = newNames;
        syncPortalRealInput();
        renderPortalPreviews();
    }
    window.removePortalFile = removePortalFile;

    function syncPortalRealInput() {
        const realInput = document.getElementById('portalRealInput');
        if (realInput) {
            realInput.files = portalDataTransfer.files;
        }
    }
    window.syncPortalRealInput = syncPortalRealInput;

    function renderPortalPreviews() {
        const container = document.getElementById('portalFotoPreviewContainer');
        if (!container) return;

        container.innerHTML = '';
        const files = portalDataTransfer.files;

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
                        <button type="button" onclick="removePortalFile(${index})" class="absolute top-1 right-1 w-6 h-6 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-xs shadow-md transition" title="Hapus foto ini">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[9px] font-extrabold text-slate-500 uppercase tracking-wider">Nama Foto:</label>
                        <input type="text" name="foto_names[]" value="${portalFileNames[index] || ('bukti_' + (index + 1))}" onchange="portalFileNames[${index}] = this.value" placeholder="Nama gambar..." class="w-full px-2 py-1 text-[11px] font-bold rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs truncate">
                    </div>
                `;
                container.appendChild(card);
            };
            reader.readAsDataURL(file);
        });
    }
    window.renderPortalPreviews = renderPortalPreviews;

    // ==========================================
    // 🧙‍♂️ MULTI-STEP PORTAL CS REPORT WIZARD LOGIC
    // ==========================================
    var portalCurrentStep = 1;

    function goToPortalStep(targetStep) {
        if (targetStep === portalCurrentStep) return;

        // If user wants to skip forward, ensure prior steps are valid
        if (targetStep > portalCurrentStep) {
            if (portalCurrentStep === 1 && !validatePortalStep1()) return;
            if (portalCurrentStep === 2 && !validatePortalStep2()) return;
            if (portalCurrentStep === 1 && targetStep === 3) {
                if (!validatePortalStep1() || !validatePortalStep2()) return;
            }
        }

        // Hide all step containers
        const steps = [1, 2, 3];
        steps.forEach(s => {
            const el = document.getElementById('portalStep' + s);
            if (el) el.classList.add('hidden');
        });

        // Show target step container
        const targetEl = document.getElementById('portalStep' + targetStep);
        if (targetEl) {
            targetEl.classList.remove('hidden');
        }

        // If target is Step 3, refresh the live Review Summary
        if (targetStep === 3) {
            updatePortalReviewSummary();
        }

        // Update Stepper UI (Circles, Labels, Progress Bar)
        updatePortalStepperUI(targetStep);

        portalCurrentStep = targetStep;

        // Smooth scroll back to top of form card so mobile user isn't disoriented
        const formCard = document.getElementById('formLaporCsPortal');
        if (formCard) {
            const rect = formCard.getBoundingClientRect();
            if (rect.top < 50 || rect.top > window.innerHeight) {
                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
    window.goToPortalStep = goToPortalStep;

    function nextPortalStep(fromStep) {
        if (fromStep === 1) {
            if (!validatePortalStep1()) return;
            goToPortalStep(2);
        } else if (fromStep === 2) {
            if (!validatePortalStep2()) return;
            goToPortalStep(3);
        }
    }
    window.nextPortalStep = nextPortalStep;

    function prevPortalStep(fromStep) {
        if (fromStep > 1) {
            goToPortalStep(fromStep - 1);
        }
    }
    window.prevPortalStep = prevPortalStep;

    function validatePortalStep1() {
        const namaInput = document.getElementById('portal_nama_pengirim');
        const kontakInput = document.getElementById('portal_kontak_hp');
        const unitLokasiInput = document.getElementById('portal_unit_lokasi');
        const unitSearchInput = document.getElementById('portal_unit_search');

        if (!namaInput || !namaInput.value.trim()) {
            showPortalStepAlert('Nama Pengirim Wajib Diisi', 'Data nama pengirim tidak boleh kosong.');
            if (namaInput) namaInput.focus();
            return false;
        }

        if (!kontakInput || !kontakInput.value.trim()) {
            showPortalStepAlert('Nomor WhatsApp Wajib Diisi', 'Silakan isi nomor kontak PJ / Pengirim.');
            if (kontakInput) kontakInput.focus();
            return false;
        }

        if (!unitLokasiInput || !unitLokasiInput.value.trim() || !unitSearchInput || !unitSearchInput.value.trim()) {
            showPortalStepAlert('Lokasi / Unit Belum Dipilih', 'Silakan pilih unit/lokasi tertuju yang dilaporkan.');
            if (unitSearchInput) {
                unitSearchInput.focus();
                openPortalUnitDropdown();
            }
            return false;
        }

        return true;
    }

    function validatePortalStep2() {
        const isiInput = document.getElementById('portal_isi_laporan');

        if (!isiInput || !isiInput.value.trim()) {
            showPortalStepAlert('Isi Laporan Wajib Diisi', 'Silakan jelaskan kendala kebersihan yang ingin dilaporkan.');
            if (isiInput) isiInput.focus();
            return false;
        }

        if (isiInput.value.trim().length < 5) {
            showPortalStepAlert('Keterangan Terlalu Pendek', 'Mohon berikan penjelasan laporan minimal 5 karakter.');
            if (isiInput) isiInput.focus();
            return false;
        }

        return true;
    }

    function showPortalStepAlert(title, text) {
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

    function updatePortalStepperUI(activeStep) {
        const line1 = document.getElementById('portalProgressLine1');
        const line2 = document.getElementById('portalProgressLine2');
        if (line1) {
            line1.style.width = activeStep >= 2 ? '100%' : '0%';
        }
        if (line2) {
            line2.style.width = activeStep >= 3 ? '100%' : '0%';
        }

        for (let i = 1; i <= 3; i++) {
            const circle = document.getElementById('portalStepCircle' + i);
            const label = document.getElementById('portalStepLabel' + i);
            if (!circle || !label) continue;

            if (i < activeStep) {
                // Completed Step
                circle.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm bg-emerald-500 text-white shadow-md shadow-emerald-500/20 ring-4 ring-emerald-50 transition-all duration-300';
                circle.innerHTML = '<i class="fa-solid fa-check text-sm"></i>';
                label.className = 'mt-2 text-[11px] font-extrabold text-emerald-700 tracking-tight transition-colors whitespace-nowrap';
            } else if (i === activeStep) {
                // Active Step
                circle.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 ring-4 ring-emerald-100 transition-all duration-300 scale-105';
                if (i === 1) circle.innerHTML = '<i class="fa-solid fa-user text-sm"></i>';
                else if (i === 2) circle.innerHTML = '<i class="fa-solid fa-camera text-sm"></i>';
                else if (i === 3) circle.innerHTML = '<i class="fa-solid fa-paper-plane text-sm"></i>';
                label.className = 'mt-2 text-[11px] font-extrabold text-emerald-900 tracking-tight transition-colors whitespace-nowrap';
            } else {
                // Inactive / Upcoming Step
                circle.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm bg-slate-100 text-slate-500 border border-slate-300 ring-4 ring-white transition-all duration-300';
                if (i === 1) circle.innerHTML = '<i class="fa-solid fa-user text-sm"></i>';
                else if (i === 2) circle.innerHTML = '<i class="fa-solid fa-camera text-sm"></i>';
                else if (i === 3) circle.innerHTML = '<i class="fa-solid fa-paper-plane text-sm"></i>';
                label.className = 'mt-2 text-[11px] font-bold text-slate-500 tracking-tight transition-colors whitespace-nowrap';
            }
        }
    }

    function updatePortalReviewSummary() {
        const namaVal = document.getElementById('portal_nama_pengirim')?.value || '-';
        const kontakVal = document.getElementById('portal_kontak_hp')?.value || '-';
        const unitVal = document.getElementById('portal_unit_search')?.value || document.getElementById('portal_unit_lokasi')?.value || '-';
        const wilayahVal = document.getElementById('portal_wilayah_search')?.value;
        const shiftVal = document.getElementById('portal_shift_select')?.value;
        const targetPjVal = document.getElementById('portalTargetUnitName')?.textContent || '-';
        const kategoriVal = document.getElementById('portal_kategori')?.value || 'Kendala Kebersihan';
        const isiVal = document.getElementById('portal_isi_laporan')?.value || '-';

        // Set Pengirim
        const reviewPengirim = document.getElementById('portalReviewPengirim');
        if (reviewPengirim) reviewPengirim.textContent = namaVal;
        const reviewKontak = document.getElementById('portalReviewKontak');
        if (reviewKontak) reviewKontak.textContent = '📞 ' + kontakVal;

        // Set Lokasi & Shift
        const reviewLokasi = document.getElementById('portalReviewLokasi');
        if (reviewLokasi) {
            let locText = unitVal;
            if (wilayahVal && wilayahVal !== '-- Bukan Wilayah Khusus / Umum --') {
                locText += ' • ' + wilayahVal;
            }
            reviewLokasi.textContent = locText;
        }

        const reviewShiftPj = document.getElementById('portalReviewShiftPj');
        if (reviewShiftPj) {
            let shiftText = shiftVal ? ('Shift ' + shiftVal) : 'Shift Waktu Laporan';
            if (targetPjVal && targetPjVal !== '-') {
                shiftText += ' (PJ: ' + targetPjVal + ')';
            }
            reviewShiftPj.textContent = '⏱️ ' + shiftText;
        }

        // Set Kategori & Isi
        const reviewKategori = document.getElementById('portalReviewKategori');
        if (reviewKategori) reviewKategori.textContent = kategoriVal;
        const reviewIsi = document.getElementById('portalReviewIsi');
        if (reviewIsi) reviewIsi.textContent = isiVal;

        // Set Foto Preview Thumbnails in Summary
        const reviewFotosWrapper = document.getElementById('portalReviewFotosWrapper');
        const reviewFotosContainer = document.getElementById('portalReviewFotosContainer');
        const reviewFotoCount = document.getElementById('portalReviewFotoCount');
        const files = portalDataTransfer.files;

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
    window.updatePortalReviewSummary = updatePortalReviewSummary;

    function validatePortalFinalSubmit(e) {
        if (!validatePortalStep1()) {
            e.preventDefault();
            goToPortalStep(1);
            return false;
        }
        if (!validatePortalStep2()) {
            e.preventDefault();
            goToPortalStep(2);
            return false;
        }

        const submitBtn = document.getElementById('btnSubmitCsPortal');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i><span>Mengirim Pengaduan...</span>';
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        }

        return true;
    }
    window.validatePortalFinalSubmit = validatePortalFinalSubmit;

    var portalPenugasanData = <?= json_encode($penugasanList ?? []) ?>;
    var portalWilayahData   = <?= json_encode($wilayahList ?? []) ?>;
    var portalUnitData      = <?= json_encode($unitList ?? []) ?>;

    // Helper to calculate auto shift based on client time
    function getPortalAutoShift() {
        const hr = new Date().getHours();
        if (hr >= 5 && hr < 12) return 'Pagi';
        if (hr >= 12 && hr < 15) return 'Siang';
        if (hr >= 15 && hr < 18) return 'Sore';
        return 'Malam';
    }
    window.getPortalAutoShift = getPortalAutoShift;

    // Searchable Unit Picker Logic in Portal Form
    function openPortalUnitDropdown() {
        const dd = document.getElementById('portalUnitDropdownList');
        const icon = document.getElementById('portalUnitIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
        filterPortalUnitOptions(document.getElementById('portal_unit_search')?.value || '');
    }
    window.openPortalUnitDropdown = openPortalUnitDropdown;

    function togglePortalUnitDropdown() {
        const dd = document.getElementById('portalUnitDropdownList');
        const icon = document.getElementById('portalUnitIcon');
        if (dd) {
            dd.classList.toggle('hidden');
            if (icon) icon.classList.toggle('rotate-180', !dd.classList.contains('hidden'));
        }
    }
    window.togglePortalUnitDropdown = togglePortalUnitDropdown;

    function filterPortalUnitOptions(query) {
        openPortalUnitDropdown();
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.portal-unit-item');
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
        const noFound = document.getElementById('noPortalUnitFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterPortalUnitOptions = filterPortalUnitOptions;

    function selectPortalUnit(el) {
        const nama = el.dataset.nama || '';
        const id = el.dataset.id || '';
        document.getElementById('portal_unit_id').value = id;
        document.getElementById('portal_unit_lokasi').value = nama;
        document.getElementById('portal_unit_search').value = nama;
        const dd = document.getElementById('portalUnitDropdownList');
        const icon = document.getElementById('portalUnitIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');

        // Reset cascading wilayah
        const wilIdEl = document.getElementById('portal_wilayah_id');
        const wilSearchEl = document.getElementById('portal_wilayah_search');
        if (wilIdEl) wilIdEl.value = '';
        if (wilSearchEl) {
            wilSearchEl.value = '';
            wilSearchEl.placeholder = nama ? ('Pilih area / spot di ' + nama + ' (Opsional)...') : '-- Bukan Wilayah Khusus / Umum --';
        }

        populatePortalShifts('');
    }
    window.selectPortalUnit = selectPortalUnit;

    // Searchable Wilayah Picker Logic in Portal Form (Cascading)
    function openPortalWilayahDropdown() {
        const dd = document.getElementById('portalWilayahDropdownList');
        const icon = document.getElementById('portalWilayahIcon');
        if (dd) {
            dd.classList.remove('hidden');
            filterPortalWilayahOptions(document.getElementById('portal_wilayah_search')?.value || '');
        }
        if (icon) icon.classList.add('rotate-180');
    }
    window.openPortalWilayahDropdown = openPortalWilayahDropdown;

    function togglePortalWilayahDropdown() {
        const dd = document.getElementById('portalWilayahDropdownList');
        if (dd && dd.classList.contains('hidden')) {
            openPortalWilayahDropdown();
        } else if (dd) {
            dd.classList.add('hidden');
            const icon = document.getElementById('portalWilayahIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
    window.togglePortalWilayahDropdown = togglePortalWilayahDropdown;

    function filterPortalWilayahOptions(query) {
        const dd = document.getElementById('portalWilayahDropdownList');
        const icon = document.getElementById('portalWilayahIcon');
        if (dd) dd.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');

        const unitVal = (document.getElementById('portal_unit_lokasi')?.value || '').toLowerCase().trim();
        const unitIdVal = document.getElementById('portal_unit_id')?.value || '';
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.portal-wilayah-item');
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
        const noFound = document.getElementById('noPortalWilayahFound');
        if (noFound) noFound.classList.toggle('hidden', found > 0);
    }
    window.filterPortalWilayahOptions = filterPortalWilayahOptions;

    function selectPortalWilayah(el) {
        const id = el.dataset.id || '';
        const name = el.dataset.name || '';
        document.getElementById('portal_wilayah_id').value = id;
        document.getElementById('portal_wilayah_search').value = name ? name : '';
        if (!id) {
            const unitVal = document.getElementById('portal_unit_lokasi')?.value;
            document.getElementById('portal_wilayah_search').placeholder = unitVal ? ('-- Bukan Wilayah Khusus di ' + unitVal + ' --') : '-- Bukan Wilayah Khusus / Umum --';
        }
        const dd = document.getElementById('portalWilayahDropdownList');
        const icon = document.getElementById('portalWilayahIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');

        populatePortalShifts(id);
    }
    window.selectPortalWilayah = selectPortalWilayah;

    function populatePortalShifts(wilayahId, selectedShift = null) {
        const container = document.getElementById('portalShiftContainer');
        const select = document.getElementById('portal_shift_select');
        if (!container || !select) return;

        if (!wilayahId) {
            container.classList.add('hidden');
            select.innerHTML = '<option value="">-- Tanpa Shift Khusus --</option>';
            return;
        }

        const assignments = (portalPenugasanData || []).filter(p => String(p.wilayah_id) === String(wilayahId));
        select.innerHTML = '';

        const autoDetectedVal = getPortalAutoShift();

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
            const currentUnitName = document.getElementById('portal_unit_lokasi')?.value || 'Unit Terkait';
            const currentUnitId = document.getElementById('portal_unit_id')?.value || '';
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
        onPortalShiftChange(select);
    }
    window.populatePortalShifts = populatePortalShifts;

    function onPortalShiftChange(selectEl) {
        if (!selectEl) return;
        const selectedOpt = selectEl.options[selectEl.selectedIndex];
        if (!selectedOpt) return;
        const targetUnitId = selectedOpt.dataset.unitId;
        const targetUnitName = selectedOpt.dataset.unitName;

        if (targetUnitId) {
            document.getElementById('portal_unit_id').value = targetUnitId;
        }
        const targetBadge = document.getElementById('portalTargetUnitName');
        if (targetBadge) {
            targetBadge.textContent = targetUnitName || '-';
        }
    }
    window.onPortalShiftChange = onPortalShiftChange;

    document.addEventListener('click', function(e) {
        const unitSearchInput = document.getElementById('portal_unit_search');
        const unitDd = document.getElementById('portalUnitDropdownList');
        if (unitDd && unitSearchInput && !unitSearchInput.contains(e.target) && !unitDd.contains(e.target)) {
            unitDd.classList.add('hidden');
            const icon = document.getElementById('portalUnitIcon');
            if (icon) icon.classList.remove('rotate-180');
        }

        const searchInput = document.getElementById('portal_wilayah_search');
        const dd = document.getElementById('portalWilayahDropdownList');
        if (dd && searchInput && !searchInput.contains(e.target) && !dd.contains(e.target)) {
            dd.classList.add('hidden');
            const icon = document.getElementById('portalWilayahIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    });
</script>
<?= $this->endSection() ?>
