<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Navigation Back -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('sop') ?>" class="w-10 h-10 rounded-2xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center transition shadow-2xs" title="Kembali ke Daftar SOP">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="font-heading font-extrabold text-2xl text-slate-900">
                    <?= !empty($sop) ? 'Edit SOP / Kebijakan' : 'Tambah SOP / Kebijakan Baru' ?>
                </h1>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">Kelola regulasi resmi, tata tertib, dan program kebersihan yayasan.</p>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-card bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/90">
        <form action="<?= !empty($sop) ? base_url('sop/update/' . $sop['id']) : base_url('sop/store') ?>" method="POST" class="space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-heading text-emerald-600 text-xs"></i>
                        <span>Judul SOP / Peraturan <span class="text-rose-500">*</span></span>
                    </label>
                    <input type="text" id="sop_judul" name="judul" value="<?= esc($sop['judul'] ?? '') ?>" required placeholder="Misal: Kewajiban Kebersihan Kamar Asrama" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-teal-600 text-xs"></i>
                        <span>Kategori Regulasi</span>
                    </label>
                    <select id="sop_kategori" name="kategori" onchange="autoSelectCategoryIcon(this.value)" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php $currentKat = $sop['kategori'] ?? 'Peraturan'; ?>
                        <option value="Peraturan" <?= ($currentKat === 'Peraturan') ? 'selected' : '' ?>>⚖️ Peraturan</option>
                        <option value="Kebijakan" <?= ($currentKat === 'Kebijakan') ? 'selected' : '' ?>>🏛️ Kebijakan</option>
                        <option value="Program Utama" <?= ($currentKat === 'Program Utama') ? 'selected' : '' ?>>⭐ Program Utama</option>
                        <option value="Panduan" <?= ($currentKat === 'Panduan') ? 'selected' : '' ?>>📋 Panduan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-tag text-slate-400 text-xs"></i>
                        <span>Sub Judul / Keterangan Singkat</span>
                    </label>
                    <input type="text" id="sop_sub_judul" name="sub_judul" value="<?= esc($sop['sub_judul'] ?? '') ?>" placeholder="Misal: Standar Harian Santri" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-users text-purple-600 text-xs"></i>
                        <span>Target Sasaran</span>
                    </label>
                    <input type="text" id="sop_target" name="target_sasaran" value="<?= esc($sop['target_sasaran'] ?? 'Seluruh Santri & Warga') ?>" placeholder="Misal: Seluruh Santri Asrama" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-align-left text-slate-500 text-xs"></i>
                    <span>Deskripsi Ringkas SOP</span>
                </label>
                <textarea id="sop_deskripsi" name="deskripsi" rows="3" placeholder="Penjelasan umum mengenai SOP atau peraturan ini..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs leading-relaxed"><?= esc($sop['deskripsi'] ?? '') ?></textarea>
            </div>

            <!-- Dynamic Points Section -->
            <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200/80 pb-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-list-check text-emerald-600"></i>
                            <span>Poin-Poin Ketentuan / Prosedur Kerja</span>
                        </label>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Tambahkan butir-butir langkah atau aturan yang harus dijalankan.</p>
                    </div>
                    <button type="button" onclick="addPointInput()" class="px-3.5 py-2 rounded-xl bg-emerald-100 text-emerald-800 text-xs font-extrabold hover:bg-emerald-200 transition shadow-2xs flex items-center gap-1.5 self-start sm:self-auto">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Tambah Poin</span>
                    </button>
                </div>

                <div id="pointInputsContainer" class="space-y-3">
                    <?php 
                        $pointsList = [];
                        if (!empty($sop['poin_poin'])) {
                            $pointsList = json_decode($sop['poin_poin'], true) ?: [];
                        }
                        if (empty($pointsList)) {
                            $pointsList = ['', ''];
                        }
                    ?>
                    <?php foreach ($pointsList as $ptVal): ?>
                        <div class="flex items-center gap-2">
                            <input type="text" name="poin_list[]" value="<?= esc($ptVal) ?>" placeholder="Tuliskan butir ketentuan / langkah SOP..." class="flex-1 px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-2xs">
                            <button type="button" onclick="this.parentElement.remove()" class="w-9 h-9 rounded-2xl bg-slate-200 text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition flex-shrink-0" title="Hapus baris ini">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Icon (Otomatis)</span>
                        <i id="sop_icon_preview" class="fa-solid fa-scale-balanced text-emerald-600 text-xs"></i>
                    </label>
                    <input type="text" id="sop_icon" name="icon" value="<?= esc($sop['icon'] ?? 'fa-solid fa-scale-balanced') ?>" oninput="updateIconPreview(this.value)" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-down-1-9 text-slate-400 text-xs"></i>
                        <span>Urutan Tampil</span>
                    </label>
                    <input type="number" id="sop_order" name="sort_order" value="<?= esc($sop['sort_order'] ?? 0) ?>" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                        <span>Status Publikasi</span>
                    </label>
                    <select id="sop_status" name="status" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php $currentStatus = $sop['status'] ?? 'Aktif'; ?>
                        <option value="Aktif" <?= ($currentStatus === 'Aktif') ? 'selected' : '' ?>>🟢 Aktif (Tampil Publik)</option>
                        <option value="Nonaktif" <?= ($currentStatus === 'Nonaktif') ? 'selected' : '' ?>>⚪ Nonaktif (Draft)</option>
                    </select>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="<?= base_url('sop') ?>" class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-700 font-heading font-extrabold text-xs hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:shadow-lg transition">
                    <?= !empty($sop) ? 'Perbarui Data SOP' : 'Simpan Data SOP' ?>
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
        if (!container) return;
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <input type="text" name="poin_list[]" value="${value.replace(/"/g, '&quot;')}" placeholder="Tuliskan butir ketentuan / langkah SOP..." class="flex-1 px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-2xs">
            <button type="button" onclick="this.parentElement.remove()" class="w-9 h-9 rounded-2xl bg-slate-200 text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition flex-shrink-0" title="Hapus baris ini">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        `;
        container.appendChild(div);
    }

    const iconInput = document.getElementById('sop_icon');
    if (iconInput) {
        updateIconPreview(iconInput.value);
    }
</script>

<?= $this->endSection() ?>
