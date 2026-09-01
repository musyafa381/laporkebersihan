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
                <h1 class="font-heading font-extrabold text-2xl text-slate-900">
                    <?= !empty($proker) ? 'Edit Program Kerja' : 'Tambah Program Kerja Baru' ?>
                </h1>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">Daftarkan rencana & realisasi agenda kegiatan kebersihan asrama/unit.</p>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-card bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/90">
        <form action="<?= !empty($proker) ? base_url('program-kerja/update/' . $proker['id']) : base_url('program-kerja/store') ?>" method="POST" class="space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Searchable Unit Picker -->
                <div class="relative">
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-house-chimney text-emerald-600 text-xs"></i>
                            <span>Pilih Asrama / Unit Pelaksana <span class="text-rose-500">*</span></span>
                        </span>
                        <span class="text-[10px] text-slate-400 font-semibold lowercase">Bisa dicari</span>
                    </label>

                    <!-- Hidden Input for Form Submission -->
                    <?php 
                        $selectedUnit = $proker['unit_id'] ?? $userUnitId;
                        $selectedUnitName = '';
                        $defaultPj = '';

                        foreach ($allUnits as $u) {
                            if ((int)$u['id'] === (int)$selectedUnit) {
                                $selectedUnitName = $u['nama_unit'] . ' (' . $u['tipe'] . ')';
                                $defaultPj = $u['pj_nama'] ?? '';
                                break;
                            }
                        }
                        if (empty($selectedUnitName) && !empty($allUnits)) {
                            $selectedUnit = $allUnits[0]['id'];
                            $selectedUnitName = $allUnits[0]['nama_unit'] . ' (' . $allUnits[0]['tipe'] . ')';
                            $defaultPj = $allUnits[0]['pj_nama'] ?? '';
                        }
                    ?>
                    <input type="hidden" id="proker_unit_id" name="unit_id" value="<?= esc($selectedUnit) ?>" required>

                    <!-- Searchable Input Trigger -->
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" id="unit_search_input" value="<?= esc($selectedUnitName) ?>" placeholder="Ketik nama asrama / unit untuk mencari..." autocomplete="off" onfocus="openUnitDropdown()" oninput="filterUnitOptions(this.value)" class="w-full pl-9 pr-8 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                        <button type="button" onclick="toggleUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                            <i id="unitDropdownIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                        </button>
                    </div>

                    <!-- Dropdown Options List -->
                    <div id="unitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-60 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                        <?php foreach ($allUnits as $u): ?>
                            <?php 
                                $isDisabled = (!$isAdminOrAuditor && $userUnitId && (int)$u['id'] !== (int)$userUnitId);
                                $unitFullName = $u['nama_unit'] . ' (' . $u['tipe'] . ')';
                            ?>
                            <div class="unit-option-item px-4 py-2.5 hover:bg-emerald-50/80 transition flex items-center justify-between cursor-pointer <?= $isDisabled ? 'opacity-40 pointer-events-none bg-slate-50' : '' ?>" data-id="<?= $u['id'] ?>" data-name="<?= esc($unitFullName) ?>" data-pj="<?= esc($u['pj_nama'] ?? '') ?>" onclick="selectUnitOption(this)">
                                <div class="space-y-0.5">
                                    <div class="font-extrabold text-xs text-slate-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-house-chimney text-emerald-600 text-[10px]"></i>
                                        <span><?= esc($u['nama_unit']) ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-2">
                                        <span class="px-1.5 py-0.2 rounded bg-slate-100"><?= esc($u['tipe']) ?></span>
                                        <?php if (!empty($u['pj_nama'])): ?>
                                            <span>PJ: <?= esc($u['pj_nama']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($isDisabled): ?>
                                    <span class="text-[10px] text-slate-400 font-mono"><i class="fa-solid fa-lock"></i> Terkunci</span>
                                <?php elseif ((int)$selectedUnit === (int)$u['id']): ?>
                                    <span class="text-emerald-600 text-xs check-indicator"><i class="fa-solid fa-check"></i></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <div id="noUnitFound" class="px-4 py-6 text-center text-slate-400 text-xs italic font-medium hidden">
                            Tidak ditemukan unit yang sesuai.
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-check text-teal-600 text-xs"></i>
                        <span>Penanggung Jawab (Otomatis dari Unit)</span>
                    </label>
                    <input type="text" id="proker_pj" name="penanggung_jawab" value="<?= esc(!empty($proker['penanggung_jawab']) ? $proker['penanggung_jawab'] : $defaultPj) ?>" placeholder="Nama Penanggung Jawab Unit..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-heading text-slate-400 text-xs"></i>
                        <span>Nama Program Kerja <span class="text-rose-500">*</span></span>
                    </label>
                    <input type="text" id="proker_nama" name="nama_program" value="<?= esc($proker['nama_program'] ?? '') ?>" required placeholder="Misal: Sidak Kebersihan Kamar Mingguan" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs">
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-tag text-purple-600 text-xs"></i>
                        <span>Sub Kegiatan / Kategori Ringkas</span>
                    </label>
                    <input type="text" id="proker_sub" name="sub_kegiatan" value="<?= esc($proker['sub_kegiatan'] ?? '') ?>" placeholder="Misal: Standar Harian Asrama Santri" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-emerald-600 text-xs"></i>
                        <span>Tanggal Dimulai <span class="text-rose-500">*</span></span>
                    </label>
                    <input type="date" id="proker_tgl_mulai" name="tgl_mulai" value="<?= esc($proker['tgl_mulai'] ?? date('Y-m-d')) ?>" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-clock-rotate-left text-amber-500 text-xs"></i>
                        <span>Periode / Frekuensi</span>
                    </label>
                    <select id="proker_periode" name="periode_frekuensi" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php $currentPeriode = $proker['periode_frekuensi'] ?? 'Mingguan'; ?>
                        <option value="Harian" <?= ($currentPeriode === 'Harian') ? 'selected' : '' ?>>Harian (Setiap Hari)</option>
                        <option value="Mingguan" <?= ($currentPeriode === 'Mingguan') ? 'selected' : '' ?>>Mingguan</option>
                        <option value="Bulanan" <?= ($currentPeriode === 'Bulanan') ? 'selected' : '' ?>>Bulanan</option>
                        <option value="Insidental" <?= ($currentPeriode === 'Insidental') ? 'selected' : '' ?>>Insidental / Kondisional</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-traffic-light text-teal-600 text-xs"></i>
                        <span>Status Pelaksanaan</span>
                    </label>
                    <select id="proker_status" name="status" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php $currentStatus = $proker['status'] ?? 'Sedang Berjalan'; ?>
                        <option value="Terlaksana Rutin" <?= ($currentStatus === 'Terlaksana Rutin') ? 'selected' : '' ?>>🟢 Terlaksana Rutin</option>
                        <option value="Sedang Berjalan" <?= ($currentStatus === 'Sedang Berjalan') ? 'selected' : '' ?>>🟡 Sedang Berjalan</option>
                        <option value="Terencana" <?= ($currentStatus === 'Terencana') ? 'selected' : '' ?>>🔵 Terencana</option>
                        <option value="Selesai" <?= ($currentStatus === 'Selesai') ? 'selected' : '' ?>>⚪ Selesai</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-bullseye text-emerald-600 text-xs"></i>
                    <span>Tujuan & Latar Belakang Program</span>
                </label>
                <textarea id="proker_tujuan" name="tujuan_program" rows="3" placeholder="Apa tujuan utama dilaksanakannya program kebersihan ini..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs leading-relaxed"><?= esc($proker['tujuan_program'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-gears text-teal-600 text-xs"></i>
                    <span>Mekanisme Kerja / Langkah Operasional Pelaksanaan</span>
                </label>
                <textarea id="proker_mekanisme" name="mekanisme_kerja" rows="4" placeholder="Bagaimana cara kerja, alur teknis, atau langkah-langkah pelaksanaan program ini..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs leading-relaxed"><?= esc($proker['mekanisme_kerja'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-flag-checkered text-amber-500 text-xs"></i>
                    <span>Target & Indikator Keberhasilan</span>
                </label>
                <input type="text" id="proker_target" name="target_indikator" value="<?= esc($proker['target_indikator'] ?? '') ?>" placeholder="Misal: 100% kamar bebas sampah plastik dan wangi..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="<?= base_url('program-kerja') ?>" class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-700 font-heading font-extrabold text-xs hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 hover:shadow-lg transition">
                    <?= !empty($proker) ? 'Perbarui Program Kerja' : 'Simpan Program Kerja' ?>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function openUnitDropdown() {
        const list = document.getElementById('unitDropdownList');
        const icon = document.getElementById('unitDropdownIcon');
        if (list) list.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }

    function closeUnitDropdown() {
        const list = document.getElementById('unitDropdownList');
        const icon = document.getElementById('unitDropdownIcon');
        if (list) list.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }

    function toggleUnitDropdown() {
        const list = document.getElementById('unitDropdownList');
        if (list && list.classList.contains('hidden')) {
            openUnitDropdown();
        } else {
            closeUnitDropdown();
        }
    }

    function filterUnitOptions(keyword) {
        openUnitDropdown();
        const search = (keyword || '').toLowerCase().trim();
        const items = document.querySelectorAll('.unit-option-item');
        let visibleCount = 0;

        items.forEach(item => {
            const name = (item.getAttribute('data-name') || '').toLowerCase();
            const pj   = (item.getAttribute('data-pj') || '').toLowerCase();
            if (!search || name.includes(search) || pj.includes(search)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noFound = document.getElementById('noUnitFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function selectUnitOption(elem) {
        const unitId   = elem.getAttribute('data-id');
        const unitName = elem.getAttribute('data-name');
        const unitPj   = elem.getAttribute('data-pj') || '';

        // Set form values
        document.getElementById('proker_unit_id').value = unitId;
        document.getElementById('unit_search_input').value = unitName;
        
        // Auto-fill PJ from selected unit
        const pjInput = document.getElementById('proker_pj');
        if (pjInput) {
            pjInput.value = unitPj;
        }

        // Update visual checkmark
        document.querySelectorAll('.unit-option-item').forEach(el => {
            const check = el.querySelector('.check-indicator');
            if (check) check.remove();
        });

        const checkSpan = document.createElement('span');
        checkSpan.className = 'text-emerald-600 text-xs check-indicator';
        checkSpan.innerHTML = '<i class="fa-solid fa-check"></i>';
        elem.appendChild(checkSpan);

        closeUnitDropdown();
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        const container = document.getElementById('unit_search_input')?.closest('.relative');
        if (container && !container.contains(e.target)) {
            closeUnitDropdown();
        }
    });
</script>

<?= $this->endSection() ?>
