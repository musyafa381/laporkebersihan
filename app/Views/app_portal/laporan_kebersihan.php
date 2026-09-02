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
                    <i class="fa-solid fa-shield-halved mr-1"></i> Terverifikasi Anti-SPAM
                </span>
            </div>

            <form action="<?= base_url('cs/public/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi / Unit Terkait</label>
                        <input type="text" name="unit_lokasi" placeholder="Misal: Asrama Kitab Putra" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Wilayah Pemetaan (Opsional)</span>
                            <span class="text-[10px] text-slate-400 font-semibold lowercase">Opsional</span>
                        </label>
                        <select name="wilayah_id" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="">-- Bukan Wilayah Khusus / Umum --</option>
                            <?php if (!empty($wilayahList)): ?>
                                <?php foreach ($wilayahList as $w): ?>
                                    <option value="<?= $w['id'] ?>"><?= esc($w['nama_wilayah']) ?> (<?= esc($w['kategori_area']) ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
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
                    <textarea name="isi_laporan" rows="4" placeholder="Jelaskan kendala kebersihan atau hal yang ingin disampaikan ke Admin K3L..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
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
                    <input type="file" id="portalCameraInput" accept="image/*" capture="environment" class="hidden" onchange="handlePortalFiles(this.files)">
                    <input type="file" id="portalGalleryInput" accept="image/*" multiple class="hidden" onchange="handlePortalFiles(this.files)">
                    <!-- Real Form File Input Container managed by DataTransfer -->
                    <input type="file" id="portalRealInput" name="foto_files[]" multiple class="hidden">

                    <!-- Action Buttons: Kamera & Galeri -->
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" onclick="document.getElementById('portalCameraInput').click()" class="py-3 px-4 rounded-2xl bg-white hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-400 text-slate-700 hover:text-emerald-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <span>Buka Kamera</span>
                        </button>

                        <button type="button" onclick="document.getElementById('portalGalleryInput').click()" class="py-3 px-4 rounded-2xl bg-white hover:bg-teal-50/80 border border-slate-200 hover:border-teal-400 text-slate-700 hover:text-teal-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                                <i class="fa-solid fa-images"></i>
                            </div>
                            <span>Pilih Galeri</span>
                        </button>
                    </div>

                    <!-- Live Thumbnail Preview Container with Delete Button -->
                    <div id="portalFotoPreviewContainer" class="flex flex-wrap gap-3 pt-2 hidden border-t border-slate-200/70"></div>
                </div>

                <!-- Anti-SPAM Security Verification Code -->
                <div class="p-4 rounded-2xl bg-slate-100/90 border border-slate-200 space-y-2">
                    <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        <i class="fa-solid fa-robot text-emerald-600 mr-1"></i> Verifikasi Keamanan Anti-SPAM
                    </label>
                    <div class="flex items-center gap-3">
                        <div class="px-4 py-2 rounded-xl bg-white border border-slate-300 font-mono font-extrabold text-sm text-emerald-800 shadow-inner">
                            Berapa <?= esc($captcha_num1 ?? 5) ?> + <?= esc($captcha_num2 ?? 3) ?> = ?
                        </div>
                        <input type="number" name="captcha_user" placeholder="Jawaban..." required class="w-32 px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-center bg-white focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    </div>
                    <p class="text-[10px] text-slate-500 font-medium">Jawab pertanyaan penjumlahan matematika sederhana di atas untuk membuktikan Anda bukan bot spam.</p>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pengaduan Ke Tim CS K3L</span>
                </button>
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
                                    <div class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-emerald-600"></i>
                                        <span><?= esc($r['unit_lokasi']) ?></span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 mt-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold border border-emerald-200/80 shadow-2xs">
                                            <i class="fa-solid fa-tag text-[9px]"></i>
                                            <?= esc($r['kategori']) ?>
                                        </span>
                                        <?php if (!empty($r['nama_wilayah'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200/80 text-[10px] font-extrabold shadow-2xs">
                                                <i class="fa-solid fa-map-location-dot text-teal-600 text-[9px]"></i>
                                                <span><?= esc($r['nama_wilayah']) ?></span>
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
                <span id="page-info-my-report-cs">Menampilkan 0 data</span>
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

<script>
    var paginatorMyReportCS;
    var portalDataTransfer = new DataTransfer();
    var portalFileNames = [];

    function initCSReportPaginator() {
        if (document.getElementById('tableMyReportCS') && typeof TablePaginator !== 'undefined') {
            paginatorMyReportCS = new TablePaginator('tableMyReportCS', 'page-info-my-report-cs', 'page-buttons-my-report-cs', 'pageSize-my-report-cs');
            paginatorMyReportCS.render();
        }
    }
    window.initCSReportPaginator = initCSReportPaginator;
    window.rebindPageEvents = initCSReportPaginator;

    document.addEventListener('DOMContentLoaded', initCSReportPaginator);
    initCSReportPaginator();

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
</script>
<?= $this->endSection() ?>
