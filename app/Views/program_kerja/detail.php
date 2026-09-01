<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Navigation Back -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('program-kerja') ?>" class="w-10 h-10 rounded-2xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center transition shadow-2xs" title="Kembali ke Daftar Program Kerja">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <span class="px-3 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-extrabold uppercase tracking-wider border border-emerald-200">
                    <?php if ($proker['kader_type'] === 'GEMERLAP'): ?>
                        ✨ Buku Kader GEMERLAP
                    <?php elseif ($proker['kader_type'] === 'Satgas'): ?>
                        🛡️ Buku Satgas Terpadu
                    <?php else: ?>
                        🏢 Proker Unit <?= esc($proker['unit_tipe'] ?? 'Asrama') ?>
                    <?php endif; ?>
                </span>
                <h1 class="font-heading font-extrabold text-2xl text-slate-900 mt-1">
                    <?= esc($proker['nama_program']) ?>
                </h1>
                <?php if (!empty($proker['sub_kegiatan'])): ?>
                    <p class="text-xs text-slate-500 font-bold mt-0.5"><?= esc($proker['sub_kegiatan']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <?php if ($canEdit): ?>
                <a href="<?= base_url('program-kerja/edit/' . $proker['id']) ?>" class="px-4 py-2.5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-heading font-extrabold text-xs border border-emerald-200 transition shadow-2xs flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Program</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="glass-card bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/90 space-y-6">
        
        <!-- Meta Summary Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Unit Pelaksana</span>
                <div class="font-heading font-extrabold text-sm text-slate-900 mt-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-house-chimney text-emerald-600 text-xs"></i>
                    <span><?= esc($proker['nama_unit'] ?? 'Buku Terpadu') ?></span>
                </div>
            </div>

            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Mulai Dilaksanakan</span>
                <div class="font-mono font-bold text-sm text-slate-800 mt-1 flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                    <span><?= $proker['tgl_mulai'] ? date('d M Y', strtotime($proker['tgl_mulai'])) : '-' ?></span>
                </div>
            </div>

            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Frekuensi Pelaksanaan</span>
                <div class="font-bold text-sm text-slate-800 mt-1">
                    <?= esc($proker['periode_frekuensi'] ?? 'Mingguan') ?>
                </div>
            </div>

            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Status Proker</span>
                <?php 
                    $statusBadge = match($proker['status']) {
                        'Terlaksana Rutin' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                        'Sedang Berjalan'  => 'bg-amber-50 text-amber-800 border-amber-200',
                        'Terencana'        => 'bg-teal-50 text-teal-800 border-teal-200',
                        default            => 'bg-slate-100 text-slate-700 border-slate-200',
                    };
                ?>
                <div class="mt-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold border <?= $statusBadge ?>">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        <?= esc($proker['status']) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Section 1: Tujuan Program -->
        <div class="space-y-2">
            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <span>Tujuan & Latar Belakang Program</span>
            </h3>
            <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line">
                <?= esc($proker['tujuan_program'] ?: 'Belum ada rincian tujuan.') ?>
            </div>
        </div>

        <!-- Section 2: Mekanisme & Alur Operasional Kerja -->
        <div class="space-y-2">
            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-gears"></i>
                </div>
                <span>Mekanisme Kerja & Alur Operasional Pelaksanaan</span>
            </h3>
            <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line font-mono sm:font-sans">
                <?= esc($proker['mekanisme_kerja'] ?: 'Belum ada rincian alur operasional kerja.') ?>
            </div>
        </div>

        <!-- Section 3: Target & Indikator Capaian -->
        <div class="space-y-2">
            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-flag-checkered"></i>
                </div>
                <span>Target & Indikator Keberhasilan</span>
            </h3>
            <div class="p-4 rounded-2xl bg-slate-50/90 border border-slate-200 text-xs font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-check-double text-emerald-600"></i>
                <span><?= esc($proker['target_indikator'] ?: 'Terpeliharanya kebersihan dan kerapian lingkungan secara berkala.') ?></span>
            </div>
        </div>

        <!-- Section 4: Galeri Foto Dokumentasi Kegiatan (Rasio 16:9) -->
        <div class="space-y-4 pt-2 border-t border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-camera-retro"></i>
                    </div>
                    <span>Foto Dokumentasi Kegiatan (Rasio 16:9)</span>
                </h3>
                <span class="text-[11px] text-slate-400 font-semibold">Format 16:9 Landscape • Maks. 3MB per foto</span>
            </div>

            <?php 
                $rawFoto = json_decode($proker['foto_dokumentasi'] ?? '[]', true) ?: [];
                $fotoList = [];
                foreach ($rawFoto as $item) {
                    if (is_array($item)) {
                        $fotoList[] = $item;
                    } elseif (is_string($item)) {
                        $fotoList[] = [
                            'file'    => $item,
                            'caption' => 'Dokumentasi Program'
                        ];
                    }
                }
            ?>

            <!-- Upload Photo Dropzone / Button (If authorized to edit) -->
            <?php if ($canEdit): ?>
                <form action="<?= base_url('program-kerja/upload-foto/' . $proker['id']) ?>" method="POST" enctype="multipart/form-data" class="p-5 rounded-3xl bg-slate-50 border border-dashed border-slate-300 hover:border-emerald-400 transition-all space-y-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg flex-shrink-0 shadow-2xs">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div>
                                <div class="font-heading font-extrabold text-xs text-slate-900">Unggah Foto Dokumentasi Baru</div>
                                <div class="text-[11px] text-slate-500 font-medium">Beri judul/nama keterangan pada setiap foto yang Anda pilih (Maks. 3MB per file).</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="file" id="prokerFotoInput" name="foto_files[]" multiple accept="image/*" class="hidden" onchange="handleProkerFileSelect(this)">
                            <button type="button" onclick="document.getElementById('prokerFotoInput').click()" class="flex-1 sm:flex-none px-4 py-2.5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-heading font-extrabold text-xs border border-slate-200 transition shadow-2xs flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus text-emerald-600"></i>
                                <span>Pilih Foto</span>
                            </button>
                            <button type="submit" id="btnSubmitFoto" class="flex-1 sm:flex-none px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" disabled>
                                <i class="fa-solid fa-upload"></i>
                                <span>Simpan Foto</span>
                            </button>
                        </div>
                    </div>

                    <!-- Selected Files Thumbnail Preview with Caption Inputs -->
                    <div id="selectedPhotoPreview" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-3 border-t border-slate-200/70"></div>
                </form>
            <?php endif; ?>

            <!-- Photo Gallery Grid (16:9 Responsive) -->
            <?php if (!empty($fotoList)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                    <?php foreach ($fotoList as $idx => $fObj): 
                        $fFileName = $fObj['file'] ?? '';
                        $fCaption  = $fObj['caption'] ?? ('Foto #' . ($idx + 1));
                        $imgUrl    = base_url('uploads/proker/' . $fFileName);
                    ?>
                        <div class="rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-md shadow-slate-200/50 flex flex-col justify-between group hover:shadow-xl transition-all duration-300">
                            <!-- 16:9 Image Preview Container -->
                            <div class="relative aspect-video bg-slate-900 overflow-hidden select-none">
                                <img src="<?= $imgUrl ?>" alt="<?= esc($fCaption) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                
                                <!-- Top Badges & Actions Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-between p-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-extrabold text-white bg-slate-900/80 px-2.5 py-0.5 rounded-lg backdrop-blur-xs">
                                            #<?= $idx + 1 ?>
                                        </span>
                                        <?php if ($canEdit): ?>
                                            <a href="<?= base_url('program-kerja/delete-foto/' . $proker['id'] . '/' . $fFileName) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus foto '<?= esc($fCaption) ?>'?" class="w-8 h-8 rounded-xl bg-rose-600/90 hover:bg-rose-600 text-white flex items-center justify-center text-xs shadow-lg transition backdrop-blur-xs" title="Hapus Foto">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex justify-end">
                                        <a href="<?= $imgUrl ?>" target="_blank" class="px-3 py-1 bg-white/95 hover:bg-white text-slate-900 text-[11px] font-extrabold rounded-xl shadow-md transition flex items-center gap-1.5 backdrop-blur-xs">
                                            <i class="fa-solid fa-up-right-and-down-left-from-center text-[10px]"></i>
                                            <span>Perbesar</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo Label / Name Footer -->
                            <div class="p-3.5 bg-slate-50/80 border-t border-slate-100 flex items-center gap-2">
                                <i class="fa-solid fa-tag text-emerald-600 text-xs flex-shrink-0"></i>
                                <span class="text-xs font-heading font-extrabold text-slate-800 truncate" title="<?= esc($fCaption) ?>">
                                    <?= esc($fCaption) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 rounded-3xl bg-slate-50/70 border border-slate-200/70 text-center space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                        <i class="fa-regular fa-images"></i>
                    </div>
                    <div class="font-heading font-extrabold text-xs text-slate-700">Belum Ada Foto Dokumentasi</div>
                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">Unggah foto dokumentasi kegiatan atau kondisi kebersihan di lapangan untuk melengkapi rincian program kerja ini.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer Meta & PJ -->
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 text-slate-600 font-semibold">
                <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <span>Penanggung Jawab: <strong class="text-slate-900"><?= esc($proker['penanggung_jawab'] ?: ($proker['pj_nama'] ?? 'PJ Unit')) ?></strong></span>
            </div>
            <div class="text-slate-400 font-mono text-[11px]">
                Sumber Input: <?= esc($proker['sumber_input'] ?? 'Manual') ?> | ID: #PROKER-<?= $proker['id'] ?>
            </div>
        </div>

    </div>

</div>

<script>
    function handleProkerFileSelect(input) {
        const previewContainer = document.getElementById('selectedPhotoPreview');
        const submitBtn = document.getElementById('btnSubmitFoto');
        if (!previewContainer || !submitBtn) return;

        const files = Array.from(input.files || []);
        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            previewContainer.innerHTML = '';
            submitBtn.disabled = true;
            return;
        }

        const maxBytes = 3 * 1024 * 1024; // 3MB
        let valid = true;
        previewContainer.innerHTML = '';

        files.forEach((file, index) => {
            if (file.size > maxBytes) {
                alert(`File "${file.name}" melebihi batas 3MB (${(file.size / (1024*1024)).toFixed(2)} MB). Mohon gunakan foto dengan ukuran maksimal 3MB.`);
                valid = false;
            }

            const cleanDefaultName = file.name.replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9_\-\s]/g, " ");

            const card = document.createElement('div');
            card.className = 'rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-2xs space-y-2 p-2.5 flex flex-col justify-between';

            // 16:9 Image Preview
            const imgBox = document.createElement('div');
            imgBox.className = 'relative rounded-xl overflow-hidden aspect-video bg-slate-900';

            const img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            img.src = URL.createObjectURL(file);

            const badge = document.createElement('div');
            badge.className = 'absolute bottom-1.5 left-1.5 px-2 py-0.5 rounded-md bg-slate-900/80 text-white text-[9px] font-extrabold backdrop-blur-xs';
            badge.innerText = `${(file.size / (1024*1024)).toFixed(1)} MB`;

            imgBox.appendChild(img);
            imgBox.appendChild(badge);

            // Caption / Name Input
            const captionBox = document.createElement('div');
            captionBox.className = 'space-y-1';

            const label = document.createElement('label');
            label.className = 'block text-[10px] font-extrabold text-slate-600 uppercase tracking-wider flex items-center gap-1';
            label.innerHTML = '<i class="fa-solid fa-pen text-[9px] text-emerald-600"></i> Nama / Keterangan Foto #' + (index + 1);

            const inputCaption = document.createElement('input');
            inputCaption.type = 'text';
            inputCaption.name = 'foto_captions[]';
            inputCaption.value = cleanDefaultName;
            inputCaption.placeholder = 'Misal: Kondisi Halaman Sebelum Kerja Bakti';
            inputCaption.className = 'w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs';

            captionBox.appendChild(label);
            captionBox.appendChild(inputCaption);

            card.appendChild(imgBox);
            card.appendChild(captionBox);
            previewContainer.appendChild(card);
        });

        if (valid && files.length > 0) {
            previewContainer.classList.remove('hidden');
            submitBtn.disabled = false;
        } else {
            input.value = '';
            previewContainer.classList.add('hidden');
            previewContainer.innerHTML = '';
            submitBtn.disabled = true;
        }
    }
</script>

<?= $this->endSection() ?>
