<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 sm:space-y-8">

    <!-- Hero Header Banner (Gradient Emerald) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-6 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-book-bookmark text-[160px] sm:text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
            <div class="space-y-2 max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-[11px] sm:text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-shield-halved"></i> Panduan & Regulasi Resmi
                </span>
                <h1 class="text-2xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    SOP & Kebijakan Kebersihan
                </h1>
                <p class="text-emerald-100/90 text-xs sm:text-base leading-relaxed">
                    Kumpulan standar operasional prosedur, peraturan ketertiban lingkungan, kebijakan resmi, serta program-program utama kebersihan Yayasan Assalafiyyah Mlangi.
                </p>
            </div>

            <?php if ($isAdminOrAuditor): ?>
                <div class="flex-shrink-0 flex items-center gap-3">
                    <a href="<?= base_url('sop/create') ?>" class="w-full sm:w-auto px-5 sm:px-6 py-3 sm:py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-xs sm:text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </div>
                        <span>Tambah SOP / Kebijakan</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter Pills & Search Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <!-- Kategori Filters -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?= base_url('sop') ?>" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border <?= empty($currentKategori) ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-layer-group mr-1.5"></i> Semua (<?= $stats['total'] ?>)
            </a>
            <a href="<?= base_url('sop?kategori=Peraturan') ?>" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border <?= $currentKategori === 'Peraturan' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-scale-balanced mr-1.5 text-rose-500"></i> Peraturan (<?= $stats['peraturan'] ?>)
            </a>
            <a href="<?= base_url('sop?kategori=Kebijakan') ?>" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border <?= $currentKategori === 'Kebijakan' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-building-shield mr-1.5 text-teal-600"></i> Kebijakan (<?= $stats['kebijakan'] ?>)
            </a>
            <a href="<?= base_url('sop?kategori=' . urlencode('Program Utama')) ?>" class="px-4 py-2 rounded-2xl text-xs font-extrabold transition border <?= $currentKategori === 'Program Utama' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-transparent shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-sparkles mr-1.5 text-amber-500"></i> Program Utama (<?= $stats['program'] ?>)
            </a>
        </div>

        <!-- Search Form -->
        <form action="<?= base_url('sop') ?>" method="GET" class="relative max-w-md w-full">
            <?php if (!empty($currentKategori)): ?>
                <input type="hidden" name="kategori" value="<?= esc($currentKategori) ?>">
            <?php endif; ?>
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="q" value="<?= esc($searchKeyword ?? '') ?>" placeholder="Cari SOP, aturan, atau program..." class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-200 bg-white text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs placeholder-slate-400">
        </form>
    </div>

    <!-- SOP Cards Grid (3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($sopList)): ?>
            <?php foreach ($sopList as $s): 
                $points = json_decode($s['poin_poin'] ?? '[]', true) ?: [];
                $badgeClass = match($s['kategori']) {
                    'Peraturan'     => 'bg-rose-50 text-rose-700 border-rose-200',
                    'Kebijakan'     => 'bg-teal-50 text-teal-700 border-teal-200',
                    'Program Utama' => 'bg-amber-50 text-amber-800 border-amber-200',
                    default         => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                };
                $iconClass = match($s['kategori']) {
                    'Peraturan'     => 'from-rose-500 to-red-600',
                    'Kebijakan'     => 'from-teal-500 to-emerald-600',
                    'Program Utama' => 'from-amber-500 to-orange-600',
                    default         => 'from-emerald-600 to-teal-600',
                };
            ?>
                <div class="glass-card rounded-3xl p-6 shadow-xl border border-slate-200/90 bg-white flex flex-col justify-between hover:shadow-2xl hover:border-emerald-400 transition-all duration-300 group space-y-4">
                    <div class="space-y-3.5">
                        <!-- Top Badges & Category Header -->
                        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border <?= $badgeClass ?>">
                                <?= esc($s['kategori']) ?>
                            </span>

                            <div class="flex items-center gap-1.5">
                                <?php if ($isAdminOrAuditor): ?>
                                    <?php if ($s['status'] === 'Nonaktif'): ?>
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Draft / Nonaktif</span>
                                    <?php endif; ?>
                                    <a href="<?= base_url('sop/edit/' . $s['id']) ?>" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 transition flex items-center justify-center text-xs shadow-2xs" title="Edit SOP">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="<?= base_url('sop/delete/' . $s['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus data SOP ini?" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition flex items-center justify-center text-xs shadow-2xs" title="Hapus SOP">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Title and Icon -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr <?= $iconClass ?> text-white flex items-center justify-center text-base shadow-md flex-shrink-0 group-hover:scale-105 transition">
                                <?php 
                                    $renderIcon = $s['icon'];
                                    if (empty($renderIcon) || $renderIcon === 'fa-solid fa-sparkles') {
                                        $renderIcon = match($s['kategori']) {
                                            'Peraturan'     => 'fa-solid fa-scale-balanced',
                                            'Kebijakan'     => 'fa-solid fa-building-shield',
                                            'Program Utama' => 'fa-solid fa-star',
                                            'Panduan'       => 'fa-solid fa-clipboard-list',
                                            default         => 'fa-solid fa-file-shield'
                                        };
                                    }
                                ?>
                                <i class="<?= esc($renderIcon) ?>"></i>
                            </div>
                            <div class="space-y-0.5 flex-1">
                                <h3 class="font-heading font-extrabold text-base text-slate-900 group-hover:text-emerald-700 transition leading-snug">
                                    <?= esc($s['judul']) ?>
                                </h3>
                                <?php if (!empty($s['sub_judul'])): ?>
                                    <p class="text-[11px] font-bold text-slate-500"><?= esc($s['sub_judul']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Description -->
                        <?php if (!empty($s['deskripsi'])): ?>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                <?= esc($s['deskripsi']) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Points / Actionable Items -->
                        <?php if (!empty($points)): ?>
                            <div class="p-3.5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-2">
                                <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-emerald-600"></i> Ketentuan & Prosedur:
                                </div>
                                <ul class="space-y-1.5">
                                    <?php foreach ($points as $pIdx => $p): ?>
                                        <li class="text-[11.5px] text-slate-700 font-medium leading-normal flex items-start gap-2">
                                            <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-800 text-[9px] font-extrabold flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <?= $pIdx + 1 ?>
                                            </span>
                                            <span class="flex-1"><?= esc($p) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Target Sasaran Footer -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                        <span class="text-slate-400 font-medium flex items-center gap-1.5">
                            <i class="fa-solid fa-users text-slate-400"></i> Sasaran:
                        </span>
                        <span class="font-extrabold text-slate-700 bg-slate-100 px-2.5 py-0.5 rounded-full">
                            <?= esc($s['target_sasaran'] ?? 'Umum') ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full py-16 text-center space-y-3 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-file-circle-question"></i>
                </div>
                <h4 class="font-heading font-extrabold text-base text-slate-700">Belum ada SOP / Peraturan ditemukan</h4>
                <p class="text-xs text-slate-400">Coba ubah kata kunci pencarian atau filter kategori di atas.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php if ($isAdminOrAuditor): ?>
<!-- ================================================= -->
<!-- 📝 MODAL TAMBAH / EDIT SOP & KEBIJAKAN KEBERSIHAN -->
<!-- ================================================= -->
<div id="modalSop" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="glass-card bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative my-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div>
                    <h3 id="modalSopTitle" class="font-heading font-extrabold text-lg text-slate-900">Tambah SOP Kebersihan</h3>
                    <p class="text-xs text-slate-500 font-semibold">Atur regulasi, kebijakan, dan program kebersihan yayasan.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalSop()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formSop" action="<?= base_url('sop/store') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Judul SOP / Peraturan</label>
                    <input type="text" id="sop_judul" name="judul" required placeholder="Misal: Kewajiban Kebersihan Kamar Asrama" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                    <select id="sop_kategori" name="kategori" onchange="autoSelectCategoryIcon(this.value)" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Peraturan">⚖️ Peraturan</option>
                        <option value="Kebijakan">🏛️ Kebijakan</option>
                        <option value="Program Utama">✨ Program Utama</option>
                        <option value="Panduan">📋 Panduan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Sub Judul / Keterangan Singkat</label>
                    <input type="text" id="sop_sub_judul" name="sub_judul" placeholder="Misal: Standar Harian Santri" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Target Sasaran</label>
                    <input type="text" id="sop_target" name="target_sasaran" placeholder="Misal: Seluruh Santri & Warga" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Ringkas</label>
                <textarea id="sop_deskripsi" name="deskripsi" rows="2" placeholder="Penjelasan umum mengenai SOP atau peraturan ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs leading-relaxed"></textarea>
            </div>

            <!-- Dynamic List of Action Points / Ketentuan -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider">
                        <i class="fa-solid fa-list-check text-emerald-600 mr-1"></i> Poin-Poin Ketentuan / Prosedur
                    </label>
                    <button type="button" onclick="addPointInput()" class="px-2.5 py-1 rounded-xl bg-emerald-100 text-emerald-800 text-[10px] font-extrabold hover:bg-emerald-200 transition">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Poin
                    </button>
                </div>
                <div id="pointInputsContainer" class="space-y-2">
                    <!-- Points inputs dynamically appended here -->
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Icon (Otomatis)</span>
                        <i id="sop_icon_preview" class="fa-solid fa-scale-balanced text-emerald-600 text-xs"></i>
                    </label>
                    <input type="text" id="sop_icon" name="icon" value="fa-solid fa-scale-balanced" oninput="updateIconPreview(this.value)" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                    <input type="number" id="sop_order" name="sort_order" value="0" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
                    <select id="sop_status" name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Aktif">🟢 Aktif (Tampil Publik)</option>
                        <option value="Nonaktif">⚪ Nonaktif (Draft)</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalSop()" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-600 font-heading font-extrabold text-xs hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">
                    Simpan Data SOP
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const categoryIconMap = {
        'Peraturan': 'fa-solid fa-scale-balanced',
        'Kebijakan': 'fa-solid fa-building-shield',
        'Program Utama': 'fa-solid fa-star',
        'Panduan': 'fa-solid fa-clipboard-list'
    };

    function autoSelectCategoryIcon(kategori) {
        const iconInput = document.getElementById('sop_icon');
        if (categoryIconMap[kategori]) {
            iconInput.value = categoryIconMap[kategori];
            updateIconPreview(categoryIconMap[kategori]);
        }
    }

    function updateIconPreview(iconClass) {
        const preview = document.getElementById('sop_icon_preview');
        if (preview) {
            preview.className = (iconClass || 'fa-solid fa-file-shield') + ' text-emerald-600 text-xs';
        }
    }

    function addPointInput(value = '') {
        const container = document.getElementById('pointInputsContainer');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <input type="text" name="poin_list[]" value="${value.replace(/"/g, '&quot;')}" placeholder="Tuliskan butir ketentuan / langkah SOP..." class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-2xs">
            <button type="button" onclick="this.parentElement.remove()" class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition flex-shrink-0" title="Hapus baris ini">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function openModalAddSop() {
        document.getElementById('modalSopTitle').textContent = 'Tambah SOP / Kebijakan Baru';
        const form = document.getElementById('formSop');
        form.action = '<?= base_url('sop/store') ?>';
        form.reset();
        
        document.getElementById('sop_kategori').value = 'Peraturan';
        autoSelectCategoryIcon('Peraturan');

        document.getElementById('pointInputsContainer').innerHTML = '';
        addPointInput();
        addPointInput();

        document.getElementById('modalSop').classList.remove('hidden');
    }

    function openModalEditSop(data) {
        document.getElementById('modalSopTitle').textContent = 'Edit SOP / Kebijakan';
        const form = document.getElementById('formSop');
        form.action = '<?= base_url('sop/update/') ?>' + data.id;

        document.getElementById('sop_judul').value = data.judul || '';
        document.getElementById('sop_kategori').value = data.kategori || 'Peraturan';
        document.getElementById('sop_sub_judul').value = data.sub_judul || '';
        document.getElementById('sop_target').value = data.target_sasaran || '';
        document.getElementById('sop_deskripsi').value = data.deskripsi || '';
        
        const currentIcon = data.icon || (categoryIconMap[data.kategori] || 'fa-solid fa-file-shield');
        document.getElementById('sop_icon').value = currentIcon;
        updateIconPreview(currentIcon);

        document.getElementById('sop_order').value = data.sort_order || 0;
        document.getElementById('sop_status').value = data.status || 'Aktif';

        const container = document.getElementById('pointInputsContainer');
        container.innerHTML = '';

        let points = [];
        try {
            points = JSON.parse(data.poin_poin || '[]');
        } catch(e) {
            points = [];
        }

        if (Array.isArray(points) && points.length > 0) {
            points.forEach(pt => addPointInput(pt));
        } else {
            addPointInput();
        }

        document.getElementById('modalSop').classList.remove('hidden');
    }

    function closeModalSop() {
        document.getElementById('modalSop').classList.add('hidden');
    }

    // Modal dismiss on overlay click
    document.getElementById('modalSop')?.addEventListener('click', function(e) {
        if (e.target === this) closeModalSop();
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>
