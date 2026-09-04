<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem LPJ Kebersihan - Gemerlap') ?></title>
    <!-- Favicon / Web Logo Icon -->
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.svg') ?>" type="image/svg+xml">
    <!-- Google Fonts & Tailwind CDN & FontAwesome & SweetAlert2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        /* Ultra Smooth Navbar Expansion Animation */
        .nav-item-btn {
            display: inline-flex;
            align-items: center;
            gap: 0;
            padding: 0.6rem 0.85rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
            transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item-btn.active {
            gap: 0.5rem;
            padding: 0.6rem 1rem;
        }
        .nav-item-btn:hover {
            gap: 0.5rem;
            padding-left: 0.95rem;
            padding-right: 0.95rem;
        }
        .nav-item-label {
            display: inline-block;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            white-space: nowrap;
            transform: translateX(-8px);
            transition: max-width 400ms cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 300ms ease-out,
                        transform 400ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item-btn:hover .nav-item-label,
        .nav-item-btn.active .nav-item-label {
            max-width: 280px;
            opacity: 1;
            transform: translateX(0);
        }

        /* Premium Brand Logo Styling */
        .brand-logo-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 1.25rem;
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .brand-logo-btn:hover {
            background: rgba(240, 253, 244, 0.8);
        }

        /* Dynamic Badge Visibility: Dot on Icon in Default Mode, Pill on Right when Expanded/Hover/Active */
        .nav-icon-badge {
            transition: opacity 250ms ease, transform 250ms ease;
        }
        .nav-text-badge {
            display: inline-flex;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            margin-left: 0;
            padding: 0;
            transform: scale(0.6);
            transition: max-width 400ms cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 300ms ease,
                        margin-left 300ms ease,
                        padding 300ms ease,
                        transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item-btn:hover .nav-icon-badge,
        .nav-item-btn.active .nav-icon-badge {
            opacity: 0;
            transform: scale(0.4);
            pointer-events: none;
        }
        .nav-item-btn:hover .nav-text-badge,
        .nav-item-btn.active .nav-text-badge {
            max-width: 100px;
            opacity: 1;
            margin-left: 0.375rem;
            padding-left: 0.375rem;
            padding-right: 0.375rem;
            transform: scale(1);
        }

        /* Modern Custom Scrollbar for Smooth Touch & Desktop */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mobile Responsive Table Container Auto-Scroll */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Mobile Drawer Transition */
        #mobileDrawer {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        }
        #mobileDrawerBackdrop {
            transition: opacity 0.3s ease;
        }
    </style>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-container {
            z-index: 10000000 !important;
        }
        .swal2-popup.glass-card {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(20px) !important;
        }
        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #10b981, #14b8a6) !important;
            height: 5px !important;
            border-radius: 9999px !important;
        }
        body.overflow-hidden {
            overflow: hidden !important;
        }
        /* Ensure modal overlay covers 100% of viewport over all headers */
        .fixed.inset-0:not(.hidden):not(#mobileDrawerContainer) {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 1rem !important;
            z-index: 999999 !important;
        }

        #mobileDrawerContainer {
            z-index: 1000000 !important;
        }
    </style>
</head>
<body class="text-slate-800 flex flex-col min-h-screen">

    <!-- Header Navigation -->
    <?php
        $uriStr = uri_string();
        $isHomeActive       = ($uriStr === '' || $uriStr === '/' || $uriStr === 'home');
        $isAppActive        = (strpos($uriStr, 'app') !== false && strpos($uriStr, 'app/') === false);
        $isAppLpjActive     = (strpos($uriStr, 'app/lpj') !== false);
        $isAppWilayahActive = (strpos($uriStr, 'app/lapor-wilayah') !== false);
        $isAppAlatActive    = (strpos($uriStr, 'app/pengajuan-alat') !== false);
        $isAppLaporActive   = (strpos($uriStr, 'app/laporan-kebersihan') !== false);

        $isBukuActive       = (strpos($uriStr, 'buku') !== false);
        $isKeuanganActive   = (strpos($uriStr, 'keuangan') !== false);
        $isAlatActive       = (strpos($uriStr, 'alat') !== false);
        $isWilayahActive    = (strpos($uriStr, 'wilayah') !== false);
        $isPengaturanActive = (strpos($uriStr, 'pengaturan') !== false);
        $isProfilActive     = (strpos($uriStr, 'profil') !== false || strpos($uriStr, 'akun') !== false);
        $isCsActive         = (strpos($uriStr, 'cs') !== false || strpos($uriStr, 'bantuan') !== false);
        $isStrukturActive   = (strpos($uriStr, 'struktur') !== false);
        $isSopActive        = (strpos($uriStr, 'sop') !== false);
        $isProkerActive     = (strpos($uriStr, 'program-kerja') !== false);

        $isLoggedIn          = session()->get('isLoggedIn');
        $userRole            = session()->get('role');
        $isAuditor           = ($userRole === 'Auditor');
        $isAdmin             = ($userRole === 'Admin');
        $isUserAdminOrAuditor = $isLoggedIn && in_array($userRole, ['Admin', 'Auditor']);
        $isUserPengurusOrKader = $isLoggedIn && in_array($userRole, ['Pengurus', 'Kader']);

        // Query status notifikasi baru untuk CS dan Pengajuan Alat
        $db = \Config\Database::connect();
        $notifCsCount = 0;
        $notifAlatCount = 0;

        try {
            if ($db->tableExists('cs_reports')) {
                $notifCsCount = $db->table('cs_reports')->where('status', 'Baru')->countAllResults();
            }
            if ($db->tableExists('alat_pengajuan')) {
                $notifAlatCount = $db->table('alat_pengajuan')->where('status', 'Pending')->countAllResults();
            }
        } catch (\Throwable $e) {
            // Silently fallback if table issue
        }

        if ($isUserAdminOrAuditor) {
            // Mode 1: Admin & Auditor Full Dashboard Menu
            $navItems = [
                [
                    'url'    => base_url('/'),
                    'icon'   => 'fa-solid fa-house',
                    'label'  => 'Beranda',
                    'active' => $isHomeActive,
                ],
                [
                    'url'    => base_url('buku'),
                    'icon'   => 'fa-solid fa-book-bookmark',
                    'label'  => 'Daftar Buku LPJ',
                    'active' => $isBukuActive,
                ],
                [
                    'url'    => base_url('keuangan'),
                    'icon'   => 'fa-solid fa-calculator',
                    'label'  => 'Laporan Keuangan',
                    'active' => $isKeuanganActive,
                ],
                [
                    'url'    => base_url('alat'),
                    'icon'   => 'fa-solid fa-broom-ball',
                    'label'  => 'Alat Kebersihan',
                    'badge'  => $notifAlatCount,
                    'active' => $isAlatActive,
                ],
                [
                    'url'    => base_url('wilayah'),
                    'icon'   => 'fa-solid fa-map-location-dot',
                    'label'  => 'Pemetaan Wilayah',
                    'active' => $isWilayahActive,
                ],
                [
                    'url'    => base_url('program-kerja'),
                    'icon'   => 'fa-solid fa-list-check',
                    'label'  => 'Program Kerja',
                    'active' => $isProkerActive,
                ],
                [
                    'url'    => base_url('struktur'),
                    'icon'   => 'fa-solid fa-sitemap',
                    'label'  => 'Struktur Kebersihan',
                    'active' => $isStrukturActive,
                ],
                [
                    'url'    => base_url('sop'),
                    'icon'   => 'fa-solid fa-file-shield',
                    'label'  => 'SOP & Kebijakan',
                    'active' => $isSopActive,
                ],
                [
                    'url'    => base_url('pengaturan'),
                    'icon'   => 'fa-solid fa-sliders',
                    'label'  => 'Pengaturan',
                    'active' => $isPengaturanActive,
                ],
                [
                    'url'    => base_url('profil'),
                    'icon'   => 'fa-solid fa-user-gear',
                    'label'  => 'Akun & Profil',
                    'active' => $isProfilActive,
                ],
                [
                    'url'    => base_url('cs'),
                    'icon'   => 'fa-solid fa-headset',
                    'label'  => 'Customer Service',
                    'badge'  => $notifCsCount,
                    'active' => $isCsActive,
                ],
            ];
        } elseif ($isUserPengurusOrKader) {
            // Mode 2: Pengurus & Kader Dashboard Menu
            $navItems = [
                [
                    'url'    => base_url('/'),
                    'icon'   => 'fa-solid fa-house',
                    'label'  => 'Beranda',
                    'active' => $isHomeActive,
                ],
                [
                    'url'    => base_url('app'),
                    'icon'   => 'fa-solid fa-gauge-high',
                    'label'  => 'Dashboard Unit',
                    'active' => $isAppActive,
                ],
                [
                    'url'    => base_url('app/lpj'),
                    'icon'   => 'fa-solid fa-pen-to-square',
                    'label'  => 'Isi LPJ Unit',
                    'active' => $isAppLpjActive,
                ],
                [
                    'url'    => base_url('app/lapor-wilayah'),
                    'icon'   => 'fa-solid fa-map-location-dot',
                    'label'  => 'Lapor Wilayah',
                    'active' => $isAppWilayahActive,
                ],
                [
                    'url'    => base_url('program-kerja'),
                    'icon'   => 'fa-solid fa-list-check',
                    'label'  => 'Program Kerja',
                    'active' => $isProkerActive,
                ],
                [
                    'url'    => base_url('app/pengajuan-alat'),
                    'icon'   => 'fa-solid fa-box-open',
                    'label'  => 'Pengajuan Alat',
                    'active' => $isAppAlatActive,
                ],
                [
                    'url'    => base_url('app/laporan-kebersihan'),
                    'icon'   => 'fa-solid fa-headset',
                    'label'  => 'Lapor CS',
                    'active' => $isAppLaporActive,
                ],
                [
                    'url'    => base_url('struktur'),
                    'icon'   => 'fa-solid fa-sitemap',
                    'label'  => 'Struktur Kebersihan',
                    'active' => $isStrukturActive,
                ],
                [
                    'url'    => base_url('sop'),
                    'icon'   => 'fa-solid fa-file-shield',
                    'label'  => 'SOP Kebersihan',
                    'active' => $isSopActive,
                ],
            ];
        } else {
            // Mode 3: Public General Visitors Menu
            $navItems = [
                [
                    'url'    => base_url('/'),
                    'icon'   => 'fa-solid fa-house',
                    'label'  => 'Beranda',
                    'active' => $isHomeActive,
                ],
                [
                    'url'    => base_url('program-kerja'),
                    'icon'   => 'fa-solid fa-list-check',
                    'label'  => 'Program Kerja',
                    'active' => $isProkerActive,
                ],
                [
                    'url'    => base_url('sop'),
                    'icon'   => 'fa-solid fa-file-shield',
                    'label'  => 'SOP Kebersihan',
                    'active' => $isSopActive,
                ],
                [
                    'url'    => base_url('struktur'),
                    'icon'   => 'fa-solid fa-sitemap',
                    'label'  => 'Struktur Kebersihan',
                    'active' => $isStrukturActive,
                ],
                [
                    'url'    => base_url('cs'),
                    'icon'   => 'fa-solid fa-headset',
                    'label'  => 'Lapor Kebersihan (CS)',
                    'active' => $isCsActive,
                ],
            ];
        }
    ?>
    <header class="sticky top-0 z-30 glass-card shadow-sm border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-3">
                <!-- Logo & Brand Header -->
                <a href="<?= base_url('/') ?>" title="LAPOR KEBERSIHAN - Web Manajemen Kebersihan" class="brand-logo-btn group">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-700 flex items-center justify-center text-white shadow-md shadow-emerald-600/25 ring-2 ring-emerald-500/20 group-hover:shadow-lg group-hover:shadow-emerald-600/35 group-hover:scale-105 group-hover:rotate-2 transition-all duration-300 flex-shrink-0">
                        <i class="fa-solid fa-leaf text-base sm:text-lg drop-shadow-xs"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="flex items-center gap-1.5 leading-none">
                            <span class="font-heading font-black text-sm sm:text-base tracking-tight text-slate-900 group-hover:text-emerald-800 transition">LAPOR</span>
                            <span class="font-heading font-black text-sm sm:text-base tracking-tight bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 bg-clip-text text-transparent">KEBERSIHAN</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-1 leading-none">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 font-bold tracking-wide group-hover:text-emerald-700 transition whitespace-nowrap">Web Manajemen Kebersihan</p>
                        </div>
                    </div>
                </a>

                <!-- Desktop / Tablet Horizontal Navigation -->
                <div class="hidden lg:flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0">
                    <?php foreach ($navItems as $item): 
                        $hasBadge = !empty($item['badge']) && (int)$item['badge'] > 0;
                    ?>
                        <?php if ($item['active']): ?>
                            <a href="<?= $item['url'] ?>" class="nav-item-btn active bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading shadow-md shadow-emerald-600/25 border border-emerald-500/30 relative">
                                <span class="relative inline-flex items-center">
                                    <i class="<?= $item['icon'] ?> text-sm flex-shrink-0"></i>
                                    <?php if ($hasBadge): ?>
                                        <span class="nav-icon-badge absolute -top-2 -right-2 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center border border-white shadow-xs animate-pulse">
                                            <?= $item['badge'] > 99 ? '99+' : $item['badge'] ?>
                                        </span>
                                    <?php endif; ?>
                                </span>
                                <span class="nav-item-label"><?= $item['label'] ?></span>
                                <?php if ($hasBadge): ?>
                                    <span class="nav-text-badge py-0.5 rounded-full bg-white text-rose-600 text-[10px] font-black shadow-xs">
                                        <?= $item['badge'] ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <a href="<?= $item['url'] ?>" title="<?= $item['label'] . ($hasBadge ? ' (' . $item['badge'] . ' Menunggu Tindakan)' : '') ?>" class="nav-item-btn bg-slate-100/90 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200/80 shadow-2xs relative">
                                <span class="relative inline-flex items-center">
                                    <i class="<?= $item['icon'] ?> text-sm flex-shrink-0 text-slate-600 hover:text-emerald-600"></i>
                                    <?php if ($hasBadge): ?>
                                        <span class="nav-icon-badge absolute -top-2 -right-2 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center border border-white shadow-xs animate-pulse">
                                            <?= $item['badge'] > 99 ? '99+' : $item['badge'] ?>
                                        </span>
                                    <?php endif; ?>
                                </span>
                                <span class="nav-item-label"><?= $item['label'] ?></span>
                                <?php if ($hasBadge): ?>
                                    <span class="nav-text-badge py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black">
                                        <?= $item['badge'] ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="nav-item-btn bg-slate-100/90 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200/80 shadow-2xs cursor-default ml-1" title="<?= esc(session()->get('nama_lengkap')) ?> (<?= esc(session()->get('role')) ?>)">
                            <i class="fa-solid fa-user-circle text-sm flex-shrink-0 <?= session()->get('role') === 'Admin' ? 'text-emerald-600' : (session()->get('role') === 'Auditor' ? 'text-blue-600' : 'text-purple-600') ?>"></i>
                            <div class="nav-item-label inline-flex items-center gap-1.5">
                                <span class="font-extrabold text-xs text-slate-800 whitespace-nowrap"><?= esc(session()->get('nama_lengkap')) ?></span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider <?= session()->get('role') === 'Admin' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : (session()->get('role') === 'Auditor' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-purple-100 text-purple-800 border border-purple-200') ?>">
                                    <?= esc(session()->get('role')) ?>
                                </span>
                            </div>
                        </div>
                        <a href="<?= base_url('logout') ?>" data-confirm-msg="Apakah Anda yakin ingin keluar/logout?" title="Logout" class="nav-item-btn bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200/80 shadow-2xs ml-1">
                            <i class="fa-solid fa-right-from-bracket text-sm flex-shrink-0 text-rose-600"></i>
                            <span class="nav-item-label">Logout</span>
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" title="Login Sistem" class="nav-item-btn bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/80 shadow-2xs ml-1">
                            <i class="fa-solid fa-right-to-bracket text-sm flex-shrink-0 text-emerald-600"></i>
                            <span class="nav-item-label">Login</span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Hamburger Toggle Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <span class="text-[11px] font-bold px-2 py-1 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 max-w-[120px] truncate">
                            <?= esc(session()->get('nama_lengkap')) ?>
                        </span>
                    <?php endif; ?>
                    <button type="button" onclick="toggleMobileDrawer(true)" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 shadow-2xs flex items-center justify-center transition" aria-label="Buka Menu Navigasi">
                        <i class="fa-solid fa-bars text-base"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Off-Canvas Drawer Navigation -->
    <div id="mobileDrawerContainer" class="fixed inset-0 pointer-events-none transition-all hidden" style="z-index: 99999999 !important;">
        <!-- Backdrop -->
        <div id="mobileDrawerBackdrop" onclick="toggleMobileDrawer(false)" class="absolute inset-0 bg-slate-950/50 backdrop-blur-xs opacity-0 transition-opacity duration-300"></div>

        <!-- Drawer Content Body -->
        <div id="mobileDrawer" class="absolute top-0 right-0 w-[85vw] max-w-xs h-full bg-white shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-out pointer-events-auto overflow-y-auto">
            <div class="p-5 sm:p-6 space-y-5">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/20">
                            <i class="fa-solid fa-leaf text-sm"></i>
                        </div>
                        <div>
                            <span class="font-heading font-extrabold text-sm text-slate-900 block leading-tight">Menu Navigasi</span>
                            <span class="text-[10px] text-emerald-600 font-semibold">Sistem K3L Kebersihan</span>
                        </div>
                    </div>
                    <button type="button" onclick="toggleMobileDrawer(false)" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- User Profile Card in Drawer if Logged In -->
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-user-circle"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-heading font-extrabold text-xs text-slate-900 truncate"><?= esc(session()->get('nama_lengkap')) ?></div>
                            <span class="inline-block text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider mt-0.5 <?= session()->get('role') === 'Admin' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' ?>">
                                <?= esc(session()->get('role')) ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Drawer Links List -->
                <div class="space-y-1">
                    <?php foreach ($navItems as $item): 
                        $hasBadge = !empty($item['badge']) && (int)$item['badge'] > 0;
                    ?>
                        <a href="<?= $item['url'] ?>" onclick="toggleMobileDrawer(false)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-heading font-bold transition <?= $item['active'] ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700' ?>">
                            <div class="flex items-center gap-2.5">
                                <i class="<?= $item['icon'] ?> text-sm w-5 text-center <?= $item['active'] ? 'text-white' : 'text-slate-400' ?>"></i>
                                <span><?= $item['label'] ?></span>
                            </div>
                            <?php if ($hasBadge): ?>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?= $item['active'] ? 'bg-white text-emerald-800' : 'bg-rose-500 text-white' ?>">
                                    <?= $item['badge'] ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Drawer Footer Auth Action -->
            <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('logout') ?>" onclick="toggleMobileDrawer(false)" data-confirm-msg="Apakah Anda yakin ingin keluar/logout?" class="w-full py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-heading font-extrabold text-xs border border-rose-200 transition shadow-2xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar / Logout</span>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" onclick="toggleMobileDrawer(false)" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk / Login Sistem</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var drawerCloseTimer = null;

            function toggleMobileDrawer(open) {
                var container = document.getElementById('mobileDrawerContainer');
                var drawer = document.getElementById('mobileDrawer');
                var backdrop = document.getElementById('mobileDrawerBackdrop');
                if (!container || !drawer || !backdrop) return;

                if (open) {
                    if (drawerCloseTimer) { clearTimeout(drawerCloseTimer); drawerCloseTimer = null; }

                    container.classList.remove('hidden');
                    container.style.display = 'block';
                    container.style.pointerEvents = 'auto';
                    document.body.classList.add('overflow-hidden');

                    requestAnimationFrame(function() {
                        backdrop.style.opacity = '1';
                        drawer.style.transform = 'translateX(0)';
                    });
                } else {
                    backdrop.style.opacity = '0';
                    drawer.style.transform = 'translateX(100%)';
                    container.style.pointerEvents = 'none';
                    document.body.classList.remove('overflow-hidden');
                    document.body.style.overflow = '';
                    document.body.style.position = '';

                    drawerCloseTimer = setTimeout(function() {
                        container.classList.add('hidden');
                        container.style.display = 'none';
                        drawerCloseTimer = null;
                        document.body.classList.remove('overflow-hidden');
                        document.body.style.overflow = '';
                        document.body.style.position = '';
                    }, 300);
                }
            }

            window.toggleMobileDrawer = toggleMobileDrawer;
        })();
    </script>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if ($isAuditor): ?>
            <!-- Auditor Read-Only Notification Banner -->
            <div class="mb-6 p-4 rounded-2xl bg-blue-50/90 border border-blue-200 text-blue-900 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm shadow-2xs flex-shrink-0">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <div>
                        <div class="font-heading font-extrabold text-xs text-blue-950 uppercase tracking-wider">Mode Akses: Auditor (Hanya Melihat / Read-Only)</div>
                        <p class="text-xs text-blue-700 font-medium mt-0.5">Anda memiliki hak akses penuh untuk meninjau seluruh data, laporan, dan mencetak dokumen PDF. Operasi tambah, ubah, dan hapus dinonaktifkan.</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-extrabold border border-blue-200">
                    <i class="fa-solid fa-shield-halved text-blue-600"></i> Read-Only
                </span>
            </div>
            <style>
                /* Auto-hide or disable modifying buttons for Auditor */
                body.role-auditor form:not(.allow-auditor) button[type="submit"]:not(.allow-auditor),
                body.role-auditor .btn-crud-action:not(.allow-auditor),
                body.role-auditor a[href*="/delete/"]:not(.allow-auditor),
                body.role-auditor a[href*="/delete-"]:not(.allow-auditor),
                body.role-auditor a[href*="/set-primary-foto/"]:not(.allow-auditor),
                body.role-auditor a[href*="program-kerja/create"]:not(.allow-auditor),
                body.role-auditor a[href*="program-kerja/edit"]:not(.allow-auditor),
                body.role-auditor a[href*="sop/create"]:not(.allow-auditor),
                body.role-auditor a[href*="sop/edit"]:not(.allow-auditor),
                body.role-auditor button[onclick*="openModal"]:not(.allow-auditor),
                body.role-auditor button[onclick*="openAdd"]:not(.allow-auditor),
                body.role-auditor button[onclick*="addKpRow"]:not(.allow-auditor),
                body.role-auditor button[onclick*="addKmRow"]:not(.allow-auditor),
                body.role-auditor button[onclick*="remove"]:not(.allow-auditor) {
                    display: none !important;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.body.classList.add('role-auditor');
                    // Disable all form inputs except search, filter, and allowed-for-auditor forms (like CS Lapor Kendala)
                    document.querySelectorAll('form').forEach(f => {
                        const isSearchOrFilter = f.id === 'searchForm' || f.classList.contains('filter-form') || (f.method && f.method.toUpperCase() === 'GET');
                        const isAllowedForAuditor = f.classList.contains('allow-auditor') || f.id === 'formLaporCsPublic' || (f.action && f.action.includes('cs/public/store'));
                        if (!isSearchOrFilter && !isAllowedForAuditor) {
                            f.querySelectorAll('input:not([type="search"]):not([id*="Search"]):not([id*="search"]), select:not([id*="Filter"]):not([id*="PerPage"]):not([id*="pageSize"]), textarea').forEach(el => {
                                el.setAttribute('readonly', 'readonly');
                                el.setAttribute('disabled', 'disabled');
                            });
                        }
                    });
                });
            </script>
        <?php endif; ?>

        <!-- Flash Alert Messages -->
        <?php if (session()->getFlashdata('msg_success') || session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="text-sm font-medium"><?= session()->getFlashdata('msg_success') ?: session()->getFlashdata('success') ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('msg_error') || session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="text-sm font-medium"><?= session()->getFlashdata('msg_error') ?: session()->getFlashdata('error') ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-slate-500">
            <p>&copy; <?= date('Y') ?> <b>Kebersihan Yayasan Assalafiyyah Mlangi</b>. System Manajemen.</p>
        </div>
    </footer>

    <!-- Universal SPA Toast Container -->
    <div id="spaToastContainer" class="fixed bottom-6 right-6 z-[100] space-y-2 pointer-events-none"></div>

    <script>
        // Universal Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('spaToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-2xl text-xs font-extrabold transition-all duration-300 transform translate-y-4 opacity-0 ${
                type === 'success'
                    ? 'bg-slate-900 text-emerald-400 border border-emerald-500/30'
                    : 'bg-slate-900 text-rose-400 border border-rose-500/30'
            }`;
            toast.innerHTML = `
                <i class="fa-solid ${type === 'success' ? 'fa-circle-check text-emerald-400' : 'fa-circle-exclamation text-rose-400'} text-base"></i>
                <span class="text-white">${message}</span>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Universal Modal & Swal Cleanup System
        function closeAllModalsAndOverlays() {
            if (typeof Swal !== 'undefined') {
                try { Swal.close(); } catch(e){}
            }
            document.querySelectorAll('.swal2-container').forEach(el => el.remove());
            document.querySelectorAll('.fixed.inset-0:not(.hidden)').forEach(m => m.classList.add('hidden'));
            document.body.classList.remove('swal2-shown', 'swal2-height-auto', 'overflow-hidden');
        }
        window.closeAllModalsAndOverlays = closeAllModalsAndOverlays;

        // Universal SPA Navigation Router (Zero Full Page Reloads)
        async function navigateToURL(url, pushState = true) {
            try {
                closeAllModalsAndOverlays();

                const currentMain = document.querySelector('main');
                if (currentMain) {
                    currentMain.style.opacity = '0.5';
                    currentMain.style.transition = 'opacity 150ms ease';
                }

                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const htmlText = await response.text();
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(htmlText, 'text/html');

                const newMain = newDoc.querySelector('main');
                const newTitle = newDoc.querySelector('title');
                const newHeaderNav = newDoc.querySelector('header');

                if (newTitle && newTitle.innerText && !newTitle.innerText.includes('403') && !newTitle.innerText.includes('Forbidden')) {
                    document.title = newTitle.innerText;
                } else if (newMain) {
                    const pageH1 = newMain.querySelector('h1, h2');
                    if (pageH1 && pageH1.innerText) {
                        document.title = pageH1.innerText.trim() + ' - Sistem LPJ Kebersihan';
                    }
                }

                if (currentMain && newMain) {
                    currentMain.innerHTML = newMain.innerHTML;
                    currentMain.style.opacity = '1';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

                // Update active state in Header Navigation
                const currentHeaderNav = document.querySelector('header');
                if (currentHeaderNav && newHeaderNav) {
                    currentHeaderNav.innerHTML = newHeaderNav.innerHTML;
                }

                // Update Mobile Drawer Navigation and Profile Synchronously
                const currentDrawer = document.getElementById('mobileDrawer');
                const newDrawer = newDoc.querySelector('#mobileDrawer');
                if (currentDrawer && newDrawer) {
                    currentDrawer.innerHTML = newDrawer.innerHTML;
                }

                // Automatically close mobile sidebar on navigation
                if (typeof toggleMobileDrawer === 'function') {
                    toggleMobileDrawer(false);
                }

                if (window.location.href !== url) {
                    if (pushState) {
                        history.pushState({ url: url }, '', url);
                    } else {
                        history.replaceState({ url: url }, '', url);
                    }
                }

                // Reset page event rebinders
                window.rebindPageEvents = null;

                // Execute inline scripts inside newly loaded main content
                if (newMain) {
                    const scripts = newMain.querySelectorAll('script');
                    scripts.forEach(s => {
                        try {
                            const newScript = document.createElement('script');
                            if (s.src) {
                                newScript.src = s.src;
                            } else {
                                newScript.textContent = s.textContent;
                            }
                            document.body.appendChild(newScript).remove();
                        } catch (sErr) {
                            console.error('Error executing SPA page script:', sErr);
                        }
                    });
                }

                if (typeof window.rebindPageEvents === 'function') {
                    try {
                        window.rebindPageEvents();
                    } catch (rErr) {
                        console.error('Error in rebindPageEvents:', rErr);
                    }
                }
                if (typeof window.initAutoResizeTextareas === 'function') {
                    try {
                        window.initAutoResizeTextareas();
                    } catch (tErr) {
                        console.error('Error in initAutoResizeTextareas:', tErr);
                    }
                }
            } catch (err) {
                console.error('SPA Navigation error:', err);
                window.location.href = url;
            }
        }

        window.navigateToURL = navigateToURL;

        // Global Event Listener for SPA Link Navigation
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
            if (link.getAttribute('target') === '_blank' || link.getAttribute('download') !== null) return;
            if (link.getAttribute('data-no-spa') === 'true' || href.includes('/logout') || href.includes('/cetak') || href.includes('/delete/') || href.includes('/delete-foto/') || href.includes('/unlink/') || href.includes('/backup')) return;

            // Check if link is an internal application URL
            const urlObj = new URL(link.href, window.location.origin);
            if (urlObj.origin === window.location.origin) {
                e.preventDefault();
                navigateToURL(link.href, true);
            }
        });

        // Handle Browser Back and Forward Buttons (SPA PopState)
        window.addEventListener('popstate', function() {
            navigateToURL(window.location.href, false);
        });

        // Dynamic View Refresh without Page Reload
        async function refreshPageDOM() {
            await navigateToURL(window.location.href, false);
        }

        // Global Event Listener for Forms
        document.addEventListener('submit', async function(e) {
            const form = e.target;
            if (form.getAttribute('data-no-ajax') === 'true') return;

            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            let oldBtnHtml = '';
            if (submitBtn) {
                oldBtnHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Menyimpan...';
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                let res;
                const contentType = response.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    res = await response.json();
                } else {
                    if (response.ok) {
                        res = { status: 'success', message: 'Data berhasil disimpan!', redirect: response.url || window.location.href };
                    } else {
                        res = { status: 'error', message: 'Gagal memproses formulir.' };
                    }
                }

                if (res.status === 'success') {
                    showToast(res.message || 'Data berhasil disimpan!', 'success');
                    document.querySelectorAll('.fixed.inset-0:not(.hidden)').forEach(m => m.classList.add('hidden'));
                    
                    let targetUrl = res.redirect || window.location.href;
                    // Prevent accidental jump to root home page when working on subpages
                    try {
                        const currentPath = window.location.pathname.replace(/\/+$/, '');
                        const targetObj = new URL(targetUrl, window.location.origin);
                        const targetPath = targetObj.pathname.replace(/\/+$/, '');
                        if (currentPath !== '' && targetPath === '') {
                            targetUrl = window.location.href;
                        }
                    } catch (e) {}

                    await navigateToURL(targetUrl, false);
                } else {
                    showToast(res.message || 'Terjadi kesalahan.', 'error');

                    // Jika ada pembaruan CAPTCHA matematika dari server
                    if (res.new_captcha) {
                        const captchaBox = form.querySelector('.font-mono.font-extrabold');
                        if (captchaBox && res.new_captcha.prompt) {
                            captchaBox.textContent = res.new_captcha.prompt;
                        }
                        const captchaInput = form.querySelector('input[name="captcha_user"]');
                        if (captchaInput) {
                            captchaInput.value = '';
                            captchaInput.focus();
                        }
                    }
                }
            } catch (err) {
                console.error('Form AJAX submit error:', err);
                // Safe reload current page on error, DO NOT re-submit the form to avoid duplicate data!
                await refreshPageDOM();
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = oldBtnHtml;
                }
            }
        });

        // SweetAlert2 Theme Customization
        const SwalCustom = Swal.mixin({
            allowOutsideClick: true,
            allowEscapeKey: true,
            customClass: {
                popup: 'rounded-[32px] p-7 glass-card shadow-2xl border border-slate-200/90 font-sans',
                title: 'font-heading font-extrabold text-slate-900 text-lg',
                htmlContainer: 'text-xs text-slate-600 font-semibold leading-relaxed mt-2',
                confirmButton: 'py-2.5 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all mx-1.5 cursor-pointer',
                cancelButton: 'py-2.5 px-5 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 font-heading font-bold text-xs transition-all mx-1.5 cursor-pointer'
            },
            buttonsStyling: false
        });
        window.SwalCustom = SwalCustom;

        // Single Global Event Listener for ALL Delete Action Links (with SweetAlert2)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href') || '';
            const isDeleteAction = href.includes('/delete/') || href.includes('/delete-foto/') || href.includes('/unlink/') || link.classList.contains('ajax-delete');

            if (isDeleteAction && !link.getAttribute('data-no-ajax')) {
                e.preventDefault();
                e.stopImmediatePropagation();

                const confirmMsg = link.getAttribute('data-confirm-msg') || 'Apakah Anda yakin ingin menghapus data ini?';

                if (typeof Swal !== 'undefined') {
                    SwalCustom.fire({
                        title: 'Konfirmasi Tindakan',
                        text: confirmMsg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa-solid fa-check mr-1.5"></i> Ya, Lanjutkan',
                        cancelButtonText: 'Batal',
                        iconColor: '#f43f5e',
                        reverseButtons: true,
                        focusCancel: true
                    }).then(async (result) => {
                        if (!result.isConfirmed) {
                            // User clicked Batal or clicked outside - cleanly exit with no action
                            return;
                        }

                        try {
                            const response = await fetch(href, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            });
                            
                            let res;
                            const contentType = response.headers.get('content-type') || '';
                            if (contentType.includes('application/json')) {
                                res = await response.json();
                            } else {
                                if (response.ok) {
                                    res = { status: 'success', message: 'Tindakan berhasil diproses!' };
                                } else {
                                    res = { status: 'error', message: 'Gagal memproses tindakan.' };
                                }
                            }

                            if (res.status === 'success') {
                                showToast(res.message || 'Tindakan berhasil diproses!', 'success');
                                const targetUrl = res.redirect || window.location.href;
                                await navigateToURL(targetUrl, false);
                            } else {
                                showToast(res.message || 'Gagal memproses data.', 'error');
                            }
                        } catch (err) {
                            console.error('Delete AJAX error:', err);
                            await refreshPageDOM();
                        }
                    });
                } else {
                    if (confirm(confirmMsg)) {
                        window.location.href = href;
                    }
                }
            }
        });

        // Global Handler for Logout Links (with SweetAlert2 Confirmation)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href') || '';
            const isLogoutAction = href.includes('/logout');

            if (isLogoutAction) {
                e.preventDefault();
                e.stopImmediatePropagation();

                const confirmMsg = link.getAttribute('data-confirm-msg') || 'Apakah Anda yakin ingin keluar dari akun Anda?';

                if (typeof Swal !== 'undefined') {
                    SwalCustom.fire({
                        title: 'Konfirmasi Logout',
                        text: confirmMsg,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa-solid fa-right-from-bracket mr-1.5"></i> Ya, Keluar',
                        cancelButtonText: 'Batal',
                        iconColor: '#10b981',
                        reverseButtons: true,
                        focusCancel: true
                    }).then(async (result) => {
                        if (!result.isConfirmed) {
                            // User clicked Batal - exit cleanly
                            return;
                        }

                        closeAllModalsAndOverlays();
                        try {
                            const response = await fetch(href, {
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });
                            let res;
                            const contentType = response.headers.get('content-type') || '';
                            if (contentType.includes('application/json')) {
                                res = await response.json();
                            } else {
                                res = { status: 'success', message: 'Anda telah keluar dari akun.', redirect: '<?= base_url('login') ?>' };
                            }

                            showToast(res.message || 'Anda telah keluar dari akun.', 'success');
                            const targetUrl = res.redirect || '<?= base_url('login') ?>';
                            setTimeout(() => {
                                window.location.href = targetUrl;
                            }, 300);
                        } catch (err) {
                            console.error('Logout error:', err);
                            window.location.href = '<?= base_url('login') ?>';
                        }
                    });
                } else {
                    if (confirm(confirmMsg)) {
                        window.location.href = href;
                    }
                }
            }
        });

        // Global Auto-resizing Textarea Helper
        function autoResizeTextarea(textarea) {
            if (!textarea) return;
            textarea.style.height = 'auto';
            const scHeight = textarea.scrollHeight;
            if (scHeight > 0) {
                textarea.style.height = (scHeight + 4) + 'px';
            }
        }

        document.addEventListener('input', function(e) {
            if (e.target && e.target.tagName === 'TEXTAREA') {
                autoResizeTextarea(e.target);
            }
        });

        document.addEventListener('focusin', function(e) {
            if (e.target && e.target.tagName === 'TEXTAREA') {
                autoResizeTextarea(e.target);
            }
        });

        function initAutoResizeTextareas() {
            document.querySelectorAll('textarea').forEach(el => {
                el.style.overflowY = 'hidden';
                el.style.resize = 'none';
                autoResizeTextarea(el);
            });
        }

        document.addEventListener('DOMContentLoaded', initAutoResizeTextareas);
        window.autoResizeTextarea = autoResizeTextarea;
        window.initAutoResizeTextareas = initAutoResizeTextareas;

        // Lightweight Modal Helper (Locks Body Scroll when modal is open)
        function checkModalState() {
            const hasOpenModal = document.querySelector('.fixed.inset-0:not(#mobileDrawerContainer):not(.hidden)');
            const drawerContainer = document.getElementById('mobileDrawerContainer');
            const isDrawerOpen = drawerContainer && !drawerContainer.classList.contains('hidden') && drawerContainer.style.display !== 'none';
            if (hasOpenModal || isDrawerOpen) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
                document.body.style.overflow = '';
                document.body.style.position = '';
            }
        }

        // Global delegate listener for modal backdrop clicks & body scroll lock
        document.addEventListener('click', function(e) {
            const activeModal = e.target.closest('.fixed.inset-0:not(#mobileDrawerContainer):not(.hidden)');
            if (activeModal && e.target === activeModal) {
                activeModal.classList.add('hidden');
            }
            setTimeout(checkModalState, 50);
        });

        // Ensure clean initial scroll state on load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.remove('overflow-hidden');
            document.body.style.overflow = '';
            document.body.style.position = '';
        });

        // ==========================================
        // 🌟 GLOBAL TABLE PAGINATOR COMPONENT
        // ==========================================
        class TablePaginator {
            constructor(tableId, infoId, buttonsId, selectId, options = {}) {
                this.table = document.getElementById(tableId);
                this.infoEl = document.getElementById(infoId);
                this.buttonsEl = document.getElementById(buttonsId);
                this.selectEl = document.getElementById(selectId);
                this.options = options;
                this.currentPage = 1;
                this.pageSize = this.selectEl ? parseInt(this.selectEl.value) : (options.defaultSize || 10);

                if (this.selectEl) {
                    this.selectEl.addEventListener('change', () => {
                        this.pageSize = parseInt(this.selectEl.value);
                        this.currentPage = 1;
                        this.render();
                    });
                }
            }

            render() {
                if (!this.table) return;
                const allRows = Array.from(this.table.querySelectorAll('tbody tr'));
                const emptyRow = allRows.find(r => r.cells.length === 1 && r.cells[0].hasAttribute('colspan'));

                const visibleRows = allRows.filter(r => r !== emptyRow && r.dataset.searchFiltered !== 'false');
                const totalItems = visibleRows.length;

                if (totalItems === 0) {
                    allRows.forEach(r => {
                        if (r !== emptyRow) r.style.display = 'none';
                    });
                    if (emptyRow) emptyRow.style.display = '';
                    if (this.infoEl) this.infoEl.innerText = 'Menampilkan 0 data';
                    if (this.buttonsEl) this.buttonsEl.innerHTML = '';
                    return;
                }

                if (emptyRow) emptyRow.style.display = 'none';

                const totalPages = Math.ceil(totalItems / this.pageSize) || 1;
                if (this.currentPage > totalPages) this.currentPage = totalPages;
                if (this.currentPage < 1) this.currentPage = 1;

                const startIndex = (this.currentPage - 1) * this.pageSize;
                const endIndex = Math.min(startIndex + this.pageSize, totalItems);

                allRows.forEach(row => {
                    if (row === emptyRow) return;
                    if (row.dataset.searchFiltered === 'false') {
                        row.style.display = 'none';
                    } else {
                        const itemIndex = visibleRows.indexOf(row);
                        if (itemIndex >= startIndex && itemIndex < endIndex) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });

                if (this.infoEl) {
                    this.infoEl.innerText = `Menampilkan ${startIndex + 1} - ${endIndex} dari ${totalItems} data`;
                }

                this.renderButtons(totalPages);
            }

            renderButtons(totalPages) {
                if (!this.buttonsEl) return;
                this.buttonsEl.innerHTML = '';

                if (totalPages <= 1) return;

                const prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.disabled = this.currentPage === 1;
                prevBtn.className = `w-8 h-8 rounded-xl border text-xs font-bold transition flex items-center justify-center ${this.currentPage === 1 ? 'border-slate-200 text-slate-300 cursor-not-allowed bg-slate-50' : 'border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 bg-white shadow-2xs'}`;
                prevBtn.innerHTML = `<i class="fa-solid fa-chevron-left text-[10px]"></i>`;
                prevBtn.onclick = () => {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.render();
                    }
                };
                this.buttonsEl.appendChild(prevBtn);

                for (let i = 1; i <= totalPages; i++) {
                    if (i === 1 || i === totalPages || (i >= this.currentPage - 1 && i <= this.currentPage + 1)) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        const isActive = i === this.currentPage;
                        btn.className = `w-8 h-8 rounded-xl border text-xs font-extrabold transition flex items-center justify-center ${isActive ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-emerald-600 shadow-xs' : 'border-slate-200 text-slate-700 hover:bg-slate-100 bg-white shadow-2xs'}`;
                        btn.innerText = i;
                        btn.onclick = () => {
                            this.currentPage = i;
                            this.render();
                        };
                        this.buttonsEl.appendChild(btn);
                    } else if (
                        (i === 2 && this.currentPage > 3) ||
                        (i === totalPages - 1 && this.currentPage < totalPages - 2)
                    ) {
                        const dots = document.createElement('span');
                        dots.className = 'w-6 text-center text-slate-400 text-xs font-bold';
                        dots.innerText = '...';
                        this.buttonsEl.appendChild(dots);
                    }
                }

                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.disabled = this.currentPage === totalPages;
                nextBtn.className = `w-8 h-8 rounded-xl border text-xs font-bold transition flex items-center justify-center ${this.currentPage === totalPages ? 'border-slate-200 text-slate-300 cursor-not-allowed bg-slate-50' : 'border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 bg-white shadow-2xs'}`;
                nextBtn.innerHTML = `<i class="fa-solid fa-chevron-right text-[10px]"></i>`;
                nextBtn.onclick = () => {
                    if (this.currentPage < totalPages) {
                        this.currentPage++;
                        this.render();
                    }
                };
                this.buttonsEl.appendChild(nextBtn);
            }
        }
        window.TablePaginator = TablePaginator;
    </script>

</body>
</html>
