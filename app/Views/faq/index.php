<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header (Frosted Glass Theme) -->
    <div class="relative overflow-hidden rounded-[32px] p-6 sm:p-10 shadow-[0_20px_50px_rgba(6,78,59,0.22)] border border-white/25 bg-gradient-to-br from-emerald-950/90 via-teal-900/85 to-slate-950/90 backdrop-blur-2xl text-white">
        <!-- Ambient Glowing Circles -->
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-emerald-200 text-xs font-extrabold uppercase tracking-wider border border-white/20">
                    <i class="fa-solid fa-book-open-reader text-emerald-400"></i> Pusat Bantuan & Panduan Sistem
                </span>
                <h1 class="text-2xl sm:text-4xl font-heading font-black tracking-tight leading-tight text-white drop-shadow-md">
                    Pusat Bantuan & FAQ
                </h1>
                <p class="text-slate-200 text-xs sm:text-sm leading-relaxed font-medium">
                    Panduan alur kerja operasional menu untuk pengurus & kader, prosedur kebersihan, dan jawaban atas pertanyaan umum.
                </p>
            </div>

            <?php if ($isAdmin): ?>
            <div class="flex-shrink-0 flex flex-wrap items-center gap-2.5">
                <button type="button" onclick="openModalTambahFaq()" class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs sm:text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group active:scale-95">
                    <div class="w-6 h-6 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <span>Tambah FAQ</span>
                </button>
                <button type="button" onclick="openModalTambahAlur()" class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs sm:text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group active:scale-95">
                    <div class="w-6 h-6 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-diagram-project text-xs"></i>
                    </div>
                    <span>Tambah Alur</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php 
        $tabParam = service('request')->getGet('tab') ?? ($_GET['tab'] ?? '');
        $activeTab = ($isAdmin && in_array($tabParam, ['faq_kelola', 'alur_kelola'])) ? $tabParam : 'panduan_alur';
    ?>

    <!-- Navigation Tabs & Search Row (Glassmorphic Bar) -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-3">
        <!-- Navigation Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            <button type="button" onclick="switchFaqTab('tab_panduan_alur')" id="btn_tab_panduan_alur" class="px-4 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition-all duration-200 shadow-2xs flex items-center gap-2 <?= $activeTab === 'panduan_alur' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'glass-card text-slate-700 hover:bg-white border border-white/80' ?>">
                <i class="fa-solid fa-route <?= $activeTab === 'panduan_alur' ? 'text-white' : 'text-emerald-600' ?>"></i>
                <span>Panduan Alur Menu</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold <?= $activeTab === 'panduan_alur' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' ?>"><?= count($alurList) ?></span>
            </button>

            <button type="button" onclick="switchFaqTab('tab_faq_list')" id="btn_tab_faq_list" class="px-4 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition-all duration-200 shadow-2xs flex items-center gap-2 <?= $activeTab === 'faq_list' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'glass-card text-slate-700 hover:bg-white border border-white/80' ?>">
                <i class="fa-solid fa-circle-question <?= $activeTab === 'faq_list' ? 'text-white' : 'text-emerald-600' ?>"></i>
                <span>Tanya Jawab FAQ</span>
                <span class="tab-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold <?= $activeTab === 'faq_list' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' ?>"><?= count($faqList) ?></span>
            </button>

            <?php if ($isAdmin): ?>
            <button type="button" onclick="switchFaqTab('tab_admin_kelola')" id="btn_tab_admin_kelola" class="px-4 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition-all duration-200 shadow-2xs flex items-center gap-2 <?= ($activeTab === 'faq_kelola' || $activeTab === 'alur_kelola') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'glass-card text-slate-700 hover:bg-white border border-white/80' ?>">
                <i class="fa-solid fa-sliders <?= ($activeTab === 'faq_kelola' || $activeTab === 'alur_kelola') ? 'text-white' : 'text-emerald-600' ?>"></i>
                <span>Kelola Konten</span>
            </button>
            <?php endif; ?>
        </div>

        <!-- Search Input -->
        <div class="relative w-full sm:w-72">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" id="faqGlobalSearch" onkeyup="filterFaqAndAlur()" placeholder="Cari alur / pertanyaan FAQ..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl border border-white/80 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white/80 backdrop-blur-md focus:bg-white transition shadow-2xs">
        </div>
    </div>

    <!-- ======================================================================= -->
    <!-- TAB 1: PANDUAN ALUR OPERASIONAL MENU (Card-Card Panduan Khusus & Umum)   -->
    <!-- ======================================================================= -->
    <div id="tab_panduan_alur" class="<?= $activeTab === 'panduan_alur' ? '' : 'hidden' ?> space-y-6 animate-fadeIn">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-emerald-50/60 border border-emerald-100 p-4 rounded-2xl">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm shadow-md shadow-emerald-600/20 flex-shrink-0">
                    <i class="fa-solid fa-diagram-project"></i>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-sm text-slate-900">Alur & Langkah Kerja Operasional</h3>
                    <p class="text-xs text-slate-500 font-medium">Panduan visual step-by-step untuk mempermudah Pengurus, Kader, dan Petugas dalam menjalankan tugas sistem.</p>
                </div>
            </div>
            <span class="text-xs font-bold text-emerald-800 bg-emerald-100/90 px-3 py-1 rounded-full border border-emerald-200 self-start sm:self-auto">
                <i class="fa-solid fa-check-double mr-1 text-emerald-600"></i> Terintegrasi Multi-Role
            </span>
        </div>

        <!-- Grid Cards Alur (Visual Flow Pathway) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="alurContainer">
            <?php if (!empty($alurList)): ?>
                <?php foreach ($alurList as $alur): ?>
                    <?php 
                        $badgeBg    = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        $iconBg     = 'from-emerald-600 to-teal-500 text-white shadow-emerald-500/20';
                        $stepDotBg  = 'bg-emerald-600 text-white shadow-emerald-500/25';
                        $lineColor  = 'border-emerald-200';
                        $btnHover   = 'hover:bg-emerald-600 hover:border-emerald-600';
                        
                        if ($alur['badge_color'] === 'teal') {
                            $badgeBg    = 'bg-teal-50 text-teal-700 border-teal-200';
                            $iconBg     = 'from-teal-600 to-emerald-500 text-white shadow-teal-500/20';
                            $stepDotBg  = 'bg-teal-600 text-white shadow-teal-500/25';
                            $lineColor  = 'border-teal-200';
                            $btnHover   = 'hover:bg-teal-600 hover:border-teal-600';
                        } elseif ($alur['badge_color'] === 'blue') {
                            $badgeBg    = 'bg-blue-50 text-blue-700 border-blue-200';
                            $iconBg     = 'from-blue-600 to-cyan-500 text-white shadow-blue-500/20';
                            $stepDotBg  = 'bg-blue-600 text-white shadow-blue-500/25';
                            $lineColor  = 'border-blue-200';
                            $btnHover   = 'hover:bg-blue-600 hover:border-blue-600';
                        } elseif ($alur['badge_color'] === 'amber') {
                            $badgeBg    = 'bg-amber-50 text-amber-800 border-amber-200';
                            $iconBg     = 'from-amber-500 to-rose-500 text-white shadow-amber-500/20';
                            $stepDotBg  = 'bg-amber-600 text-white shadow-amber-500/25';
                            $lineColor  = 'border-amber-200';
                            $btnHover   = 'hover:bg-amber-600 hover:border-amber-600';
                        } elseif ($alur['badge_color'] === 'purple') {
                            $badgeBg    = 'bg-purple-50 text-purple-700 border-purple-200';
                            $iconBg     = 'from-purple-600 to-indigo-500 text-white shadow-purple-500/20';
                            $stepDotBg  = 'bg-purple-600 text-white shadow-purple-500/25';
                            $lineColor  = 'border-purple-200';
                            $btnHover   = 'hover:bg-purple-600 hover:border-purple-600';
                        }
                        $steps = json_decode($alur['steps'] ?? '[]', true) ?: [];
                        $totalSteps = count($steps);
                    ?>
                    <div class="alur-card glass-card bg-white rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 flex flex-col justify-between hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                        <!-- Top Accent Line -->
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r <?= $iconBg ?>"></div>

                        <div class="space-y-5">
                            <!-- Card Header -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr <?= $iconBg ?> flex items-center justify-center text-xl shadow-lg flex-shrink-0 group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                                    <i class="<?= esc($alur['icon'] ?: 'fa-solid fa-route') ?>"></i>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold border <?= $badgeBg ?> shadow-2xs">
                                        <i class="fa-solid fa-user-tag text-[9px]"></i>
                                        <?= esc($alur['target_role'] ?: 'All') ?>
                                    </span>
                                    <span class="text-[10px] font-extrabold text-slate-400">
                                        <?= $totalSteps ?> Tahapan Alur
                                    </span>
                                    <?php if ($isAdmin): ?>
                                    <div class="flex items-center gap-1.5 pt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button type="button" onclick="openModalEditAlur(<?= htmlspecialchars(json_encode($alur)) ?>)" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 flex items-center justify-center text-xs transition shadow-2xs" title="Edit Alur">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <a href="<?= base_url('faq/alur/delete/' . $alur['id']) ?>" data-confirm-msg="Hapus card alur '<?= esc($alur['judul_alur']) ?>'?" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center text-xs transition shadow-2xs" title="Hapus Alur">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Title & Summary -->
                            <div>
                                <h4 class="font-heading font-extrabold text-base text-slate-900 leading-snug alur-title group-hover:text-emerald-800 transition-colors">
                                    <?= esc($alur['judul_alur']) ?>
                                </h4>
                                <?php if (!empty($alur['ringkasan'])): ?>
                                <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed alur-desc">
                                    <?= esc($alur['ringkasan']) ?>
                                </p>
                                <?php endif; ?>
                            </div>

                            <!-- Visual Step-by-Step Flow Pathway (Connected Vertical Line) -->
                            <div class="pt-3 border-t border-slate-100">
                                <div class="relative pl-7 space-y-4">
                                    <?php foreach ($steps as $stIdx => $st): 
                                        $isLast = ($stIdx === $totalSteps - 1);
                                    ?>
                                        <div class="relative">
                                            <!-- Connected Line -->
                                            <?php if (!$isLast): ?>
                                            <div class="absolute -left-5 top-5 bottom-0 w-0.5 border-l-2 border-dashed <?= $lineColor ?> h-[calc(100%+0.75rem)]"></div>
                                            <?php endif; ?>

                                            <!-- Number Circle Badge -->
                                            <div class="absolute -left-7 top-0.5 w-5 h-5 rounded-full <?= $stepDotBg ?> font-heading font-black text-[10px] flex items-center justify-center shadow-md">
                                                <?= $stIdx + 1 ?>
                                            </div>

                                            <div class="space-y-0.5">
                                                <span class="font-extrabold text-slate-900 text-xs block leading-tight">
                                                    <?= esc($st['title'] ?? '') ?>
                                                </span>
                                                <?php if (!empty($st['desc'])): ?>
                                                <span class="text-[11px] text-slate-500 font-medium block leading-snug">
                                                    <?= esc($st['desc']) ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button / Link to Menu -->
                        <div class="pt-5 mt-4 border-t border-slate-100">
                            <?php if (!empty($alur['link_menu'])): ?>
                            <a href="<?= base_url($alur['link_menu']) ?>" class="w-full py-2.5 px-4 rounded-2xl bg-slate-50 <?= $btnHover ?> text-slate-700 hover:text-white font-heading font-extrabold text-xs transition-all duration-200 border border-slate-200/80 flex items-center justify-between group/btn shadow-2xs">
                                <span>Buka Menu Terkait</span>
                                <i class="fa-solid fa-arrow-right text-[11px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                            <?php else: ?>
                            <div class="w-full py-2 px-3 rounded-xl bg-slate-50 text-slate-400 text-[11px] font-semibold text-center italic">
                                Panduan Prosedural Umum
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-12 text-center text-slate-400 glass-card rounded-3xl p-8 bg-white border border-slate-200">
                    <i class="fa-solid fa-diagram-project text-4xl text-slate-300 mb-2"></i>
                    <p class="font-bold text-xs">Belum ada card panduan alur yang ditambahkan.</p>
                </div>
            <?php endif; ?>
        </div>
        <div id="noAlurFound" class="py-12 text-center text-slate-400 glass-card rounded-3xl p-8 bg-white border border-slate-200 hidden">
            <i class="fa-solid fa-magnifying-glass text-4xl text-slate-300 mb-2"></i>
            <p class="font-bold text-xs">Tidak ditemukan card alur yang cocok dengan pencarian.</p>
        </div>
    </div>

    <!-- ======================================================================= -->
    <!-- TAB 2: TANYA JAWAB FAQ (Accordion & Kategori Filter)                    -->
    <!-- ======================================================================= -->
    <div id="tab_faq_list" class="hidden space-y-6 animate-fadeIn">
        <!-- Category Pill Filters -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2" id="faqCategoryFilterContainer">
            <?php foreach ($categories as $cIdx => $cat): ?>
            <button type="button" onclick="filterFaqByCategory('<?= esc($cat) ?>', this)" class="faq-category-btn px-4 py-2 rounded-2xl text-xs font-heading font-extrabold transition shadow-2xs whitespace-nowrap <?= $cIdx === 0 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' ?>" data-cat="<?= esc($cat) ?>">
                <?= esc($cat) ?>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- FAQ Accordion List -->
        <div class="space-y-3" id="faqAccordionContainer">
            <?php if (!empty($faqList)): ?>
                <?php foreach ($faqList as $idx => $faq): ?>
                <div class="faq-item glass-card bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-md shadow-slate-100 overflow-hidden transition-all duration-200" data-kategori="<?= esc($faq['kategori']) ?>">
                    <button type="button" onclick="toggleFaqAccordion(<?= $faq['id'] ?>)" class="w-full px-5 py-4 sm:px-6 sm:py-4.5 text-left flex items-center justify-between gap-4 hover:bg-slate-50/80 transition group">
                        <div class="flex items-center gap-3.5 flex-1">
                            <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xs font-heading font-black shadow-2xs flex-shrink-0 group-hover:scale-105 transition">
                                Q
                            </span>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <?= esc($faq['kategori'] ?: 'Umum') ?>
                                    </span>
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                        <i class="fa-solid fa-users text-[9px] mr-1"></i><?= esc($faq['target_role'] ?: 'All') ?>
                                    </span>
                                </div>
                                <h4 class="font-heading font-extrabold text-sm sm:text-base text-slate-900 group-hover:text-emerald-700 transition leading-snug faq-question">
                                    <?= esc($faq['pertanyaan']) ?>
                                </h4>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-emerald-100 text-slate-400 group-hover:text-emerald-700 flex items-center justify-center text-xs transition flex-shrink-0">
                            <i id="faq-chevron-<?= $faq['id'] ?>" class="fa-solid fa-chevron-down transition-transform duration-200"></i>
                        </div>
                    </button>

                    <!-- Accordion Body -->
                    <div id="faq-body-<?= $faq['id'] ?>" class="hidden px-5 sm:px-6 pb-5 pt-1 text-slate-600 text-xs sm:text-sm font-medium leading-relaxed border-t border-slate-100 bg-slate-50/40 faq-answer">
                        <div class="p-4 rounded-2xl bg-white border border-slate-100 text-slate-700 space-y-2 mt-2">
                            <?= nl2br(esc($faq['jawaban'])) ?>
                        </div>
                        <?php if ($isAdmin): ?>
                        <div class="flex items-center justify-end gap-2 pt-3">
                            <button type="button" onclick="openModalEditFaq(<?= htmlspecialchars(json_encode($faq)) ?>)" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 text-xs font-bold transition flex items-center gap-1.5">
                                <i class="fa-solid fa-pen text-[10px]"></i> Edit FAQ
                            </button>
                            <a href="<?= base_url('faq/delete/' . $faq['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus FAQ ini?" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-700 text-xs font-bold transition flex items-center gap-1.5">
                                <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="py-12 text-center text-slate-400 glass-card rounded-3xl p-8 bg-white border border-slate-200">
                    <i class="fa-solid fa-circle-question text-4xl text-slate-300 mb-2"></i>
                    <p class="font-bold text-xs">Belum ada item FAQ yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
        <div id="noFaqFound" class="py-12 text-center text-slate-400 glass-card rounded-3xl p-8 bg-white border border-slate-200 hidden">
            <i class="fa-solid fa-magnifying-glass text-4xl text-slate-300 mb-2"></i>
            <p class="font-bold text-xs">Tidak ditemukan FAQ yang sesuai dengan pencarian atau filter.</p>
        </div>

        <!-- Help Desk Banner Card -->
        <div class="glass-card bg-gradient-to-r from-teal-900 via-emerald-800 to-teal-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-teal-600/30 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center sm:text-left">
                <h4 class="font-heading font-extrabold text-lg sm:text-xl">Masih belum menemukan jawaban yang Anda cari?</h4>
                <p class="text-xs sm:text-sm text-emerald-200/90">Tim Customer Service & Kebersihan siap membantu menindaklanjuti kebutuhan atau pertanyaan Anda.</p>
            </div>
            <a href="<?= base_url('cs') ?>" class="px-6 py-3 rounded-2xl bg-white text-emerald-900 font-heading font-extrabold text-xs hover:bg-emerald-50 transition shadow-lg flex items-center gap-2 flex-shrink-0">
                <i class="fa-solid fa-headset text-emerald-600"></i>
                <span>Hubungi Layanan CS</span>
            </a>
        </div>
    </div>

    <!-- ======================================================================= -->
    <!-- TAB 3: ADMIN KELOLA FAQ & ALUR (Admin Only Management)                  -->
    <!-- ======================================================================= -->
    <?php if ($isAdmin): ?>
    <div id="tab_admin_kelola" class="<?= ($activeTab === 'faq_kelola' || $activeTab === 'alur_kelola') ? '' : 'hidden' ?> space-y-6 animate-fadeIn">
        <!-- Sub-Tabs Admin -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
            <button type="button" onclick="switchAdminSubTab('sub_faq_kelola')" id="btn_sub_faq" class="px-4 py-2 rounded-xl text-xs font-heading font-extrabold transition <?= $activeTab === 'alur_kelola' ? 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' : 'bg-emerald-600 text-white shadow-sm' ?>">
                <i class="fa-solid fa-list-check mr-1.5"></i> Tabel Manajemen FAQ
            </button>
            <button type="button" onclick="switchAdminSubTab('sub_alur_kelola')" id="btn_sub_alur" class="px-4 py-2 rounded-xl text-xs font-heading font-extrabold transition <?= $activeTab === 'alur_kelola' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' ?>">
                <i class="fa-solid fa-diagram-project mr-1.5"></i> Tabel Manajemen Card Alur
            </button>
        </div>

        <!-- SUB TAB 1: Tabel Kelola FAQ -->
        <div id="sub_faq_kelola" class="<?= $activeTab === 'alur_kelola' ? 'hidden' : '' ?> space-y-4">
            <div class="glass-card bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h3 class="font-heading font-extrabold text-base text-slate-900">Daftar Tanya Jawab FAQ (<?= count($faqList) ?>)</h3>
                        <p class="text-xs text-slate-500 font-medium">Kelola pertanyaan, jawaban, kategori, dan target hak akses.</p>
                    </div>
                    <button type="button" onclick="openModalTambahFaq()" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah FAQ Baru
                    </button>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px]">
                            <tr>
                                <th class="py-3 px-3 text-center" width="5%">URUT</th>
                                <th class="py-3 px-4" width="20%">KATEGORI</th>
                                <th class="py-3 px-4" width="35%">PERTANYAAN</th>
                                <th class="py-3 px-4 text-center" width="15%">TARGET ROLE</th>
                                <th class="py-3 px-4 text-center" width="10%">STATUS</th>
                                <th class="py-3 px-3 text-center" width="15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($faqList)): ?>
                                <?php foreach ($faqList as $f): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $f['urutan'] ?></td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-[11px] border border-slate-200">
                                            <?= esc($f['kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-900"><?= esc($f['pertanyaan']) ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <?= esc($f['target_role']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold <?= $f['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' ?>">
                                            <?= esc($f['status']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" onclick="openModalEditFaq(<?= htmlspecialchars(json_encode($f)) ?>)" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 flex items-center justify-center transition" title="Edit">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <a href="<?= base_url('faq/delete/' . $f['id']) ?>" data-confirm-msg="Hapus FAQ '<?= esc($f['pertanyaan']) ?>'?" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 font-bold">Belum ada data FAQ.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SUB TAB 2: Tabel Kelola Card Panduan Alur -->
        <div id="sub_alur_kelola" class="<?= $activeTab === 'alur_kelola' ? '' : 'hidden' ?> space-y-4">
            <div class="glass-card bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h3 class="font-heading font-extrabold text-base text-slate-900">Daftar Card Panduan Alur (<?= count($alurList) ?>)</h3>
                        <p class="text-xs text-slate-500 font-medium">Kelola kartu alur kerja interaktif untuk setiap modul menu.</p>
                    </div>
                    <button type="button" onclick="openModalTambahAlur()" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Card Alur
                    </button>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px]">
                            <tr>
                                <th class="py-3 px-3 text-center" width="5%">URUT</th>
                                <th class="py-3 px-4" width="25%">JUDUL ALUR</th>
                                <th class="py-3 px-4" width="20%">LINK MENU</th>
                                <th class="py-3 px-4 text-center" width="15%">TARGET ROLE</th>
                                <th class="py-3 px-4 text-center" width="15%">JUMLAH LANGKAH</th>
                                <th class="py-3 px-3 text-center" width="20%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($alurList)): ?>
                                <?php foreach ($alurList as $al): ?>
                                <?php $stCount = count(json_decode($al['steps'] ?? '[]', true) ?: []); ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3 text-center font-extrabold text-slate-400"><?= $al['urutan'] ?></td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="<?= esc($al['icon'] ?: 'fa-solid fa-route') ?>"></i>
                                            </span>
                                            <div>
                                                <div class="font-extrabold text-slate-900"><?= esc($al['judul_alur']) ?></div>
                                                <div class="text-[10px] text-slate-400 truncate max-w-xs"><?= esc($al['ringkasan']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-mono text-[11px] text-emerald-800 font-bold">
                                        <?= esc($al['link_menu'] ?: '-') ?>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <?= esc($al['target_role']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-slate-700">
                                        <?= $stCount ?> Langkah
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" onclick="openModalEditAlur(<?= htmlspecialchars(json_encode($al)) ?>)" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 flex items-center justify-center transition" title="Edit">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <a href="<?= base_url('faq/alur/delete/' . $al['id']) ?>" data-confirm-msg="Hapus Card Alur '<?= esc($al['judul_alur']) ?>'?" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 font-bold">Belum ada Card Panduan Alur.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- =========================================================================== -->
<!-- PRESET DATALIST UNTUK LINK MENU                                            -->
<!-- =========================================================================== -->
<datalist id="menuLinkPresets">
    <option value="app/lapor-wilayah">Lapor Wilayah & Checklist Shift (Mobile Portal)</option>
    <option value="app/pengajuan-alat">Pengajuan Alat Kebersihan (Mobile Portal)</option>
    <option value="app/lpj">Pengisian LPJ Unit Kebersihan (Mobile Portal)</option>
    <option value="app/laporan-kebersihan">Lapor CS & Aduan Unit (Mobile Portal)</option>
    <option value="buku">Daftar Buku LPJ Bulanan (Admin & Auditor)</option>
    <option value="keuangan">Laporan Keuangan & Kas (Admin & Auditor)</option>
    <option value="alat">Inventaris & Gudang Alat (Admin & Auditor)</option>
    <option value="wilayah">Pemetaan & Master Wilayah (Admin & Auditor)</option>
    <option value="program-kerja">Program Kerja Asrama & Kader (Semua Role)</option>
    <option value="sop">Standar Operasional Prosedur / SOP (Semua Role)</option>
    <option value="struktur">Struktur Organisasi K3L (Semua Role)</option>
    <option value="cs">Layanan Pengaduan CS (Publik & Umum)</option>
    <option value="profil">Kelola Akun & Profil Pengguna</option>
</datalist>

<!-- =========================================================================== -->
<!-- MODAL TAMBAH & EDIT FAQ (Admin)                                             -->
<!-- =========================================================================== -->
<?php if ($isAdmin): ?>
<!-- Modal Tambah FAQ -->
<div id="modalTambahFaq" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 p-6 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">Tambah Item FAQ</h3>
                    <p class="text-xs text-slate-500 font-medium">Buat pertanyaan dan jawaban baru untuk pusat bantuan.</p>
                </div>
            </div>
            <button onclick="closeModalTambahFaq()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form action="<?= base_url('faq/store') ?>" method="POST">
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pertanyaan FAQ</label>
                    <input type="text" name="pertanyaan" placeholder="Misal: Bagaimana cara mengajukan sapu baru?" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                        <input type="text" name="kategori" list="kategoriList" placeholder="Pilih/Ketik kategori..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <datalist id="kategoriList">
                            <option value="Umum">
                            <option value="Operasional & Wilayah">
                            <option value="Inventaris & Alat">
                            <option value="Buku LPJ">
                            <option value="SOP & Regulasi">
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Target Audiens</label>
                        <select name="target_role" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="All">Semua Role & Publik</option>
                            <option value="Publik">Publik / Umum Saja</option>
                            <option value="Pengurus">Pengurus & Kader</option>
                            <option value="Auditor">Auditor</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jawaban Lengkap</label>
                    <textarea name="jawaban" rows="4" placeholder="Tuliskan jawaban penjelasan yang jelas dan mudah dipahami..." required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                        <input type="number" name="urutan" value="1" min="1" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="p-4 px-6 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-2">
                <button type="button" onclick="closeModalTambahFaq()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-200/60 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan FAQ</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit FAQ -->
<div id="modalEditFaq" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 p-6 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">Edit Item FAQ</h3>
                    <p class="text-xs text-slate-500 font-medium">Perbarui rincian pertanyaan dan jawaban FAQ.</p>
                </div>
            </div>
            <button onclick="closeModalEditFaq()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form id="formEditFaq" action="" method="POST">
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pertanyaan FAQ</label>
                    <input type="text" id="edit_pertanyaan" name="pertanyaan" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                        <input type="text" id="edit_kategori" name="kategori" list="kategoriList" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Target Audiens</label>
                        <select id="edit_target_role" name="target_role" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="All">Semua Role & Publik</option>
                            <option value="Publik">Publik / Umum Saja</option>
                            <option value="Pengurus">Pengurus & Kader</option>
                            <option value="Auditor">Auditor</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jawaban Lengkap</label>
                    <textarea id="edit_jawaban" name="jawaban" rows="4" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                        <input type="number" id="edit_urutan" name="urutan" min="1" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="edit_status" name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="p-4 px-6 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-2">
                <button type="button" onclick="closeModalEditFaq()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-200/60 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================== -->
<!-- MODAL TAMBAH & EDIT CARD PANDUAN ALUR (ULTRA-PREMIUM REDESIGN)               -->
<!-- =========================================================================== -->
<!-- Modal Tambah Alur -->
<div id="modalTambahAlur" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[90vh]">
        <!-- Sticky Header -->
        <div class="flex items-center justify-between border-b border-slate-100 p-6 pb-4 bg-white z-10 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">Tambah Card Panduan Alur</h3>
                    <p class="text-xs text-slate-500 font-medium">Buat kartu alur kerja step-by-step interaktif untuk modul menu.</p>
                </div>
            </div>
            <button onclick="closeModalTambahAlur()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Body (Single Smooth Scrollable Container) -->
        <form action="<?= base_url('faq/alur/store') ?>" method="POST" class="flex flex-col flex-1 overflow-hidden">
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <!-- Section 1: Data Pokok Alur -->
                <div class="space-y-3 bg-slate-50/80 p-4 sm:p-5 rounded-2xl border border-slate-200/80">
                    <span class="block text-[11px] font-extrabold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i> Informasi Pokok Alur
                    </span>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Judul Alur</label>
                        <input type="text" name="judul_alur" placeholder="Misal: Alur Lapor Wilayah & Checklist Shift" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Singkat</label>
                        <input type="text" name="ringkasan" placeholder="Penjelasan singkat alur ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <!-- Section 2: Visual, Ikon & Hak Akses -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Icon with Live Preview -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Ikon FontAwesome</label>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm border border-emerald-200 flex-shrink-0" id="add_icon_preview">
                                <i class="fa-solid fa-route"></i>
                            </div>
                            <input type="text" id="add_alur_icon_input" name="icon" value="fa-solid fa-route" placeholder="fa-solid fa-route" oninput="updateIconPreview('add_alur_icon_input', 'add_icon_preview')" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>

                    <!-- Warna Aksen -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Warna Aksen</label>
                        <select name="badge_color" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="emerald">🟢 Emerald Green</option>
                            <option value="teal">🩵 Teal Cyan</option>
                            <option value="blue">🔵 Blue Sky</option>
                            <option value="amber">🟠 Amber Warm</option>
                            <option value="purple">🟣 Purple Indigo</option>
                        </select>
                    </div>

                    <!-- Target Role -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Target Hak Akses</label>
                        <select name="target_role" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="Pengurus" selected>Pengurus & Kader</option>
                            <option value="All">Semua Role & Publik</option>
                            <option value="Publik">Publik Saja</option>
                            <option value="Auditor">Auditor</option>
                        </select>
                    </div>
                </div>

                <!-- Section 3: Link Menu Preset & Urutan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Link Menu Terkait</span>
                            <span class="text-[10px] text-slate-400 font-normal lowercase">Pilih preset atau ketik URL</span>
                        </label>
                        <input type="text" name="link_menu" list="menuLinkPresets" placeholder="Pilih rute menu (misal: app/lapor-wilayah)..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-mono font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Kartu</label>
                        <input type="number" name="urutan" value="1" min="1" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <!-- Section 4: Steps Builder (Langkah-Langkah Alur) -->
                <div class="space-y-3 pt-3 border-t border-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-list-ol"></i>
                            </span>
                            <h4 class="font-heading font-extrabold text-xs text-slate-800 uppercase tracking-wider">Tahapan Langkah Kerja (Steps)</h4>
                        </div>
                        <button type="button" onclick="addStepField('add_steps_container')" class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-extrabold transition flex items-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-plus text-[10px]"></i> Tambah Langkah
                        </button>
                    </div>

                    <!-- Steps List Container (No Nested Scrollbar!) -->
                    <div id="add_steps_container" class="space-y-3">
                        <div class="step-row flex items-start gap-3 bg-slate-50/90 p-3 sm:p-4 rounded-2xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition group">
                            <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white text-xs font-black flex items-center justify-center flex-shrink-0 mt-0.5 shadow-md shadow-emerald-500/20">
                                1
                            </div>
                            <div class="flex-1 space-y-2">
                                <input type="text" name="steps[0][title]" placeholder="Judul langkah 1 (misal: Buka Menu Lapor Wilayah)..." required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition">
                                <input type="text" name="steps[0][desc]" placeholder="Instruksi / catatan panduan untuk langkah ini..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-[11px] font-medium bg-white focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <button type="button" onclick="this.closest('.step-row').remove(); reindexStepRows('add_steps_container')" class="w-7 h-7 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center text-xs transition" title="Hapus Langkah">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="addStepField('add_steps_container')" class="w-full py-2.5 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/50 text-slate-500 hover:text-emerald-700 text-xs font-extrabold transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus-circle text-xs"></i>
                        <span>Tambah Langkah Baru</span>
                    </button>
                </div>
            </div>

            <!-- Sticky Footer Actions -->
            <div class="p-4 px-6 border-t border-slate-100 bg-slate-50/80 flex justify-end gap-2.5 z-10 flex-shrink-0">
                <button type="button" onclick="closeModalTambahAlur()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-200/60 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Card Alur</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Alur -->
<div id="modalEditAlur" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[90vh]">
        <!-- Sticky Header -->
        <div class="flex items-center justify-between border-b border-slate-100 p-6 pb-4 bg-white z-10 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">Edit Card Panduan Alur</h3>
                    <p class="text-xs text-slate-500 font-medium">Perbarui rincian tahapan langkah dan konfigurasi kartu alur.</p>
                </div>
            </div>
            <button onclick="closeModalEditAlur()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Body (Single Smooth Scrollable Container) -->
        <form id="formEditAlur" action="" method="POST" class="flex flex-col flex-1 overflow-hidden">
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <!-- Section 1: Data Pokok Alur -->
                <div class="space-y-3 bg-slate-50/80 p-4 sm:p-5 rounded-2xl border border-slate-200/80">
                    <span class="block text-[11px] font-extrabold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i> Informasi Pokok Alur
                    </span>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Judul Alur</label>
                        <input type="text" id="edit_judul_alur" name="judul_alur" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Singkat</label>
                        <input type="text" id="edit_ringkasan" name="ringkasan" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <!-- Section 2: Visual, Ikon & Hak Akses -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Icon with Live Preview -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Ikon FontAwesome</label>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm border border-emerald-200 flex-shrink-0" id="edit_icon_preview">
                                <i class="fa-solid fa-route"></i>
                            </div>
                            <input type="text" id="edit_alur_icon" name="icon" oninput="updateIconPreview('edit_alur_icon', 'edit_icon_preview')" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        </div>
                    </div>

                    <!-- Warna Aksen -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Warna Aksen</label>
                        <select id="edit_alur_badge_color" name="badge_color" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="emerald">🟢 Emerald Green</option>
                            <option value="teal">🩵 Teal Cyan</option>
                            <option value="blue">🔵 Blue Sky</option>
                            <option value="amber">🟠 Amber Warm</option>
                            <option value="purple">🟣 Purple Indigo</option>
                        </select>
                    </div>

                    <!-- Target Role -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Target Hak Akses</label>
                        <select id="edit_alur_target_role" name="target_role" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <option value="Pengurus">Pengurus & Kader</option>
                            <option value="All">Semua Role & Publik</option>
                            <option value="Publik">Publik Saja</option>
                            <option value="Auditor">Auditor</option>
                        </select>
                    </div>
                </div>

                <!-- Section 3: Link Menu Preset & Urutan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Link Menu Terkait</span>
                            <span class="text-[10px] text-slate-400 font-normal lowercase">Pilih preset atau ketik URL</span>
                        </label>
                        <input type="text" id="edit_link_menu" name="link_menu" list="menuLinkPresets" placeholder="Pilih rute menu (misal: app/lapor-wilayah)..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-mono font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Kartu</label>
                        <input type="number" id="edit_alur_urutan" name="urutan" min="1" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>
                </div>

                <!-- Section 4: Steps Builder (Langkah-Langkah Alur) -->
                <div class="space-y-3 pt-3 border-t border-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-list-ol"></i>
                            </span>
                            <h4 class="font-heading font-extrabold text-xs text-slate-800 uppercase tracking-wider">Tahapan Langkah Kerja (Steps)</h4>
                        </div>
                        <button type="button" onclick="addStepField('edit_steps_container')" class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-extrabold transition flex items-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-plus text-[10px]"></i> Tambah Langkah
                        </button>
                    </div>

                    <!-- Steps List Container (No Nested Scrollbar!) -->
                    <div id="edit_steps_container" class="space-y-3"></div>

                    <button type="button" onclick="addStepField('edit_steps_container')" class="w-full py-2.5 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/50 text-slate-500 hover:text-emerald-700 text-xs font-extrabold transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus-circle text-xs"></i>
                        <span>Tambah Langkah Baru</span>
                    </button>
                </div>
            </div>

            <!-- Sticky Footer Actions -->
            <div class="p-4 px-6 border-t border-slate-100 bg-slate-50/80 flex justify-end gap-2.5 z-10 flex-shrink-0">
                <button type="button" onclick="closeModalEditAlur()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-200/60 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
    var currentCategoryFilter = 'Semua';

    // Switch Main Tabs
    function switchFaqTab(tabId) {
        document.getElementById('tab_panduan_alur')?.classList.toggle('hidden', tabId !== 'tab_panduan_alur');
        document.getElementById('tab_faq_list')?.classList.toggle('hidden', tabId !== 'tab_faq_list');
        document.getElementById('tab_admin_kelola')?.classList.toggle('hidden', tabId !== 'tab_admin_kelola');

        const buttons = [
            { el: document.getElementById('btn_tab_panduan_alur'), id: 'tab_panduan_alur' },
            { el: document.getElementById('btn_tab_faq_list'), id: 'tab_faq_list' },
            { el: document.getElementById('btn_tab_admin_kelola'), id: 'tab_admin_kelola' }
        ];

        buttons.forEach(b => {
            if (!b.el) return;
            const isActive = (b.id === tabId);
            const icon = b.el.querySelector('i');
            const badge = b.el.querySelector('.tab-badge');

            if (isActive) {
                b.el.className = "px-4 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition-all duration-200 shadow-2xs flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20";
                if (icon) icon.className = icon.className.replace('text-emerald-600', 'text-white');
                if (badge) badge.className = "tab-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white";
            } else {
                b.el.className = "px-4 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition-all duration-200 shadow-2xs flex items-center gap-2 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/90";
                if (icon) icon.className = icon.className.replace('text-white', 'text-emerald-600');
                if (badge) badge.className = "tab-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600";
            }
        });

        try {
            const url = new URL(window.location.href);
            let tabParam = 'panduan_alur';
            if (tabId === 'tab_faq_list') tabParam = 'faq_list';
            if (tabId === 'tab_admin_kelola') tabParam = 'faq_kelola';
            url.searchParams.set('tab', tabParam);
            window.history.replaceState(null, '', url.toString());
        } catch (e) {}
    }
    window.switchFaqTab = switchFaqTab;

    // Switch Admin Sub Tabs
    function switchAdminSubTab(subId) {
        document.getElementById('sub_faq_kelola')?.classList.toggle('hidden', subId !== 'sub_faq_kelola');
        document.getElementById('sub_alur_kelola')?.classList.toggle('hidden', subId !== 'sub_alur_kelola');

        const btnFaq = document.getElementById('btn_sub_faq');
        const btnAlur = document.getElementById('btn_sub_alur');

        if (btnFaq) btnFaq.className = (subId === 'sub_faq_kelola') ? "px-4 py-2 rounded-xl text-xs font-heading font-extrabold transition bg-emerald-600 text-white shadow-sm" : "px-4 py-2 rounded-xl text-xs font-heading font-extrabold transition bg-white text-slate-700 hover:bg-slate-50 border border-slate-200";
        if (btnAlur) btnAlur.className = (subId === 'sub_alur_kelola') ? "px-4 py-2 rounded-xl text-xs font-heading font-extrabold transition bg-emerald-600 text-white shadow-sm" : "px-4 py-2 rounded-xl text-xs font-heading font-extrabold transition bg-white text-slate-700 hover:bg-slate-50 border border-slate-200";

        try {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', subId === 'sub_alur_kelola' ? 'alur_kelola' : 'faq_kelola');
            window.history.replaceState(null, '', url.toString());
        } catch (e) {}
    }
    window.switchAdminSubTab = switchAdminSubTab;

    // Toggle Accordion Item
    function toggleFaqAccordion(id) {
        const body = document.getElementById('faq-body-' + id);
        const icon = document.getElementById('faq-chevron-' + id);
        if (!body) return;

        const isHidden = body.classList.contains('hidden');
        body.classList.toggle('hidden', !isHidden);
        if (icon) {
            icon.classList.toggle('rotate-180', isHidden);
        }
    }
    window.toggleFaqAccordion = toggleFaqAccordion;

    // Category Filter for FAQ
    function filterFaqByCategory(category, btnElem) {
        currentCategoryFilter = category;
        const buttons = document.querySelectorAll('.faq-category-btn');
        buttons.forEach(b => {
            b.className = "faq-category-btn px-4 py-2 rounded-2xl text-xs font-heading font-extrabold transition shadow-2xs whitespace-nowrap bg-white text-slate-600 hover:bg-slate-50 border border-slate-200";
        });
        if (btnElem) {
            btnElem.className = "faq-category-btn px-4 py-2 rounded-2xl text-xs font-heading font-extrabold transition shadow-2xs whitespace-nowrap bg-emerald-600 text-white shadow-md shadow-emerald-600/20";
        }
        filterFaqAndAlur();
    }
    window.filterFaqByCategory = filterFaqByCategory;

    // Global Search Filter for both FAQ and Alur Cards
    function filterFaqAndAlur() {
        const searchInput = document.getElementById('faqGlobalSearch');
        const query = (searchInput?.value || '').toLowerCase().trim();

        // 1. Filter FAQ Items
        const faqItems = document.querySelectorAll('.faq-item');
        let visibleFaqCount = 0;
        faqItems.forEach(item => {
            const cat = item.getAttribute('data-kategori') || '';
            const question = item.querySelector('.faq-question')?.innerText.toLowerCase() || '';
            const answer = item.querySelector('.faq-answer')?.innerText.toLowerCase() || '';

            const matchCat = (currentCategoryFilter === 'Semua' || cat === currentCategoryFilter);
            const matchSearch = (!query || question.includes(query) || answer.includes(query) || cat.toLowerCase().includes(query));

            if (matchCat && matchSearch) {
                item.style.display = '';
                visibleFaqCount++;
            } else {
                item.style.display = 'none';
            }
        });
        document.getElementById('noFaqFound')?.classList.toggle('hidden', visibleFaqCount > 0);

        // 2. Filter Alur Cards
        const alurCards = document.querySelectorAll('.alur-card');
        let visibleAlurCount = 0;
        alurCards.forEach(card => {
            const title = card.querySelector('.alur-title')?.innerText.toLowerCase() || '';
            const desc = card.querySelector('.alur-desc')?.innerText.toLowerCase() || '';
            const steps = card.innerText.toLowerCase();

            const matchSearch = (!query || title.includes(query) || desc.includes(query) || steps.includes(query));

            if (matchSearch) {
                card.style.display = '';
                visibleAlurCount++;
            } else {
                card.style.display = 'none';
            }
        });
        document.getElementById('noAlurFound')?.classList.toggle('hidden', visibleAlurCount > 0);
    }
    window.filterFaqAndAlur = filterFaqAndAlur;

    // Live Icon Preview Helper
    function updateIconPreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        if (input && preview) {
            const iconClass = (input.value || '').trim() || 'fa-solid fa-route';
            preview.innerHTML = `<i class="${escapeHtml(iconClass)}"></i>`;
        }
    }
    window.updateIconPreview = updateIconPreview;

    // Modal Handlers FAQ
    function openModalTambahFaq() {
        document.getElementById('modalTambahFaq')?.classList.remove('hidden');
    }
    function closeModalTambahFaq() {
        document.getElementById('modalTambahFaq')?.classList.add('hidden');
    }
    function openModalEditFaq(faq) {
        const form = document.getElementById('formEditFaq');
        if (form) form.action = "<?= base_url('faq/update') ?>/" + faq.id;
        document.getElementById('edit_pertanyaan').value = faq.pertanyaan || '';
        document.getElementById('edit_kategori').value = faq.kategori || 'Umum';
        document.getElementById('edit_target_role').value = faq.target_role || 'All';
        document.getElementById('edit_jawaban').value = faq.jawaban || '';
        document.getElementById('edit_urutan').value = faq.urutan || 1;
        document.getElementById('edit_status').value = faq.status || 'Aktif';
        document.getElementById('modalEditFaq')?.classList.remove('hidden');
    }
    function closeModalEditFaq() {
        document.getElementById('modalEditFaq')?.classList.add('hidden');
    }

    // Modal Handlers Alur
    function openModalTambahAlur() {
        document.getElementById('modalTambahAlur')?.classList.remove('hidden');
        updateIconPreview('add_alur_icon_input', 'add_icon_preview');
    }
    function closeModalTambahAlur() {
        document.getElementById('modalTambahAlur')?.classList.add('hidden');
    }
    function openModalEditAlur(alur) {
        const form = document.getElementById('formEditAlur');
        if (form) form.action = "<?= base_url('faq/alur/update') ?>/" + alur.id;
        document.getElementById('edit_judul_alur').value = alur.judul_alur || '';
        document.getElementById('edit_ringkasan').value = alur.ringkasan || '';
        document.getElementById('edit_alur_icon').value = alur.icon || 'fa-solid fa-route';
        document.getElementById('edit_alur_badge_color').value = alur.badge_color || 'emerald';
        document.getElementById('edit_alur_target_role').value = alur.target_role || 'Pengurus';
        document.getElementById('edit_link_menu').value = alur.link_menu || '';
        document.getElementById('edit_alur_urutan').value = alur.urutan || 1;

        updateIconPreview('edit_alur_icon', 'edit_icon_preview');

        // Populate steps in edit modal
        const container = document.getElementById('edit_steps_container');
        if (container) {
            container.innerHTML = '';
            let steps = [];
            try {
                steps = typeof alur.steps === 'string' ? JSON.parse(alur.steps) : (alur.steps || []);
            } catch(e) { steps = []; }

            if (steps.length === 0) {
                steps = [{title: '', desc: ''}];
            }

            steps.forEach((st, idx) => {
                renderStepRow(container, idx, st.title, st.desc);
            });
        }

        document.getElementById('modalEditAlur')?.classList.remove('hidden');
    }
    function closeModalEditAlur() {
        document.getElementById('modalEditAlur')?.classList.add('hidden');
    }

    // Steps Row Helper
    function addStepField(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const currentCount = container.querySelectorAll('.step-row').length;
        renderStepRow(container, currentCount, '', '');
    }

    function renderStepRow(container, index, titleVal = '', descVal = '') {
        const row = document.createElement('div');
        row.className = "step-row flex items-start gap-3 bg-slate-50/90 p-3 sm:p-4 rounded-2xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition group";
        row.innerHTML = `
            <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white text-xs font-black flex items-center justify-center flex-shrink-0 mt-0.5 shadow-md shadow-emerald-500/20">
                ${index + 1}
            </div>
            <div class="flex-1 space-y-2">
                <input type="text" name="steps[${index}][title]" value="${escapeHtml(titleVal)}" placeholder="Judul langkah ${index + 1} (misal: Buka Menu Lapor Wilayah)..." required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                <input type="text" name="steps[${index}][desc]" value="${escapeHtml(descVal)}" placeholder="Instruksi / catatan panduan untuk langkah ini..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-[11px] font-medium bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>
            <button type="button" onclick="this.closest('.step-row').remove(); reindexStepRows('${container.id}')" class="w-7 h-7 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center text-xs transition" title="Hapus Langkah">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        `;
        container.appendChild(row);
    }

    function reindexStepRows(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const rows = container.querySelectorAll('.step-row');
        rows.forEach((row, i) => {
            const badge = row.querySelector('.w-7');
            if (badge) badge.innerText = i + 1;
            const titleInput = row.querySelector('input[name*="[title]"]');
            const descInput = row.querySelector('input[name*="[desc]"]');
            if (titleInput) {
                titleInput.name = `steps[${i}][title]`;
                titleInput.placeholder = `Judul langkah ${i + 1}...`;
            }
            if (descInput) {
                descInput.name = `steps[${i}][desc]`;
            }
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
</script>
<?= $this->endSection() ?>
