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
        html, body {
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }
        html {
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 #f1f5f9;
        }
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

        /* Modern Compact Unified Navbar Styling */
        .top-nav-btn {
            display: inline-flex;
            align-items: center;
            height: 38px;
            gap: 0.45rem;
            padding: 0 0.8rem;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
            transition: all 180ms cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            box-sizing: border-box;
        }
        .top-nav-btn.active {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.25);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .top-nav-btn:not(.active) {
            background: rgba(248, 250, 252, 0.95);
            color: #334155;
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .top-nav-btn:not(.active):hover {
            background: #f0fdf4;
            color: #047857;
            border-color: #a7f3d0;
            transform: translateY(-1px);
        }

        /* Top Nav Profile Button with Matching Unified Height & Styling */
        .top-nav-profile-btn {
            display: inline-flex;
            align-items: center;
            height: 38px;
            gap: 0.5rem;
            padding: 0 0.75rem 0 0.375rem;
            border-radius: 0.75rem;
            background: rgba(248, 250, 252, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #334155;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
            transition: all 180ms cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            cursor: pointer;
            box-sizing: border-box;
        }
        .top-nav-profile-btn:hover {
            background: #f0fdf4;
            border-color: #a7f3d0;
            color: #047857;
            transform: translateY(-1px);
        }
        .top-nav-avatar {
            width: 28px;
            height: 28px;
            min-width: 28px;
            min-height: 28px;
            border-radius: 0.5rem;
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: inherit;
            font-weight: 900;
            font-size: 0.75rem;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Top Nav Dropdown Panel with Smooth Animation & Safe Bridge */
        .nav-dropdown-wrapper {
            position: absolute;
            top: 100%;
            left: 0;
            padding-top: 0.35rem;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(5px) scale(0.97);
            transition: opacity 180ms cubic-bezier(0.16, 1, 0.3, 1),
                        transform 180ms cubic-bezier(0.16, 1, 0.3, 1),
                        visibility 180ms;
            z-index: 70;
        }
        .nav-dropdown-parent.is-open > .nav-dropdown-wrapper {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }
        .nav-dropdown-parent.is-open .nav-dropdown-chevron {
            transform: rotate(180deg);
        }
        @media (hover: hover) and (pointer: fine) {
            .nav-dropdown-parent:hover > .nav-dropdown-wrapper {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                transform: translateY(0) scale(1);
            }
            .nav-dropdown-parent:hover .nav-dropdown-chevron {
                transform: rotate(180deg);
            }
        }
        .nav-dropdown-wrapper.align-right {
            left: auto;
            right: 0;
        }

        /* Premium Brand Logo Styling */
        .brand-logo-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .brand-logo-btn:hover {
            background: rgba(240, 253, 244, 0.8);
        }

        /* Modern Custom Scrollbar for Smooth Touch & Desktop */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
            border: 2px solid #f1f5f9;
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
        
        /* Mobile Drawer Transition & Scroll Lock */
        body.drawer-open {
            overflow: hidden !important;
            position: fixed !important;
            width: 100% !important;
            touch-action: none !important;
        }

        #mobileDrawerContainer {
            position: fixed !important;
            inset: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: 99999999 !important;
        }

        #mobileDrawerBackdrop {
            touch-action: none;
            -webkit-tap-highlight-color: transparent;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        #mobileDrawer {
            touch-action: pan-y;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            max-height: 100vh;
            max-height: 100dvh;
            height: 100vh;
            height: 100dvh;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
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
        /* Ensure modal overlay covers 100% of viewport over all headers without causing 100vw horizontal overflow */
        .fixed.inset-0:not(.hidden):not(#mobileDrawerContainer) {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 1rem !important;
            z-index: 999999 !important;
        }
    </style>
</head>
<body class="text-slate-800 flex flex-col min-h-screen">

    <!-- Header Navigation -->
    <?php
        $uriStr = trim(uri_string(), '/');
        $isLoginActive      = (strpos($uriStr, 'login') !== false || strpos($uriStr, 'auth') !== false);
        $isHomeActive       = ($uriStr === '' || $uriStr === 'home' || $uriStr === 'index.php') && !$isLoginActive;
        $isAppActive        = ($uriStr === 'app' || $uriStr === 'app/index' || $uriStr === 'app/dashboard');
        $isAppLpjActive     = (strpos($uriStr, 'app/lpj') !== false);
        $isAppWilayahActive = (strpos($uriStr, 'app/lapor-wilayah') !== false || strpos($uriStr, 'app/wilayah-tugas') !== false);
        $isAppAlatActive    = (strpos($uriStr, 'app/pengajuan-alat') !== false);
        $isAppLaporActive   = (strpos($uriStr, 'app/laporan-kebersihan') !== false);

        $isBukuActive       = (strpos($uriStr, 'buku') !== false);
        $isKeuanganActive   = (strpos($uriStr, 'keuangan') !== false);
        $isAlatActive       = (strpos($uriStr, 'alat') !== false && strpos($uriStr, 'app/pengajuan-alat') === false);
        $isWilayahActive    = (strpos($uriStr, 'wilayah') !== false && strpos($uriStr, 'app/lapor-wilayah') === false && strpos($uriStr, 'app/wilayah-tugas') === false);
        $isPengaturanActive = (strpos($uriStr, 'pengaturan') !== false);
        $isProfilActive     = (strpos($uriStr, 'profil') !== false || strpos($uriStr, 'akun') !== false);
        $isCsActive         = (strpos($uriStr, 'cs') !== false && strpos($uriStr, 'app/laporan-kebersihan') === false);
        $isFaqActive        = (strpos($uriStr, 'faq') !== false || strpos($uriStr, 'bantuan') !== false);
        $isStrukturActive   = (strpos($uriStr, 'struktur') !== false);
        $isSopActive        = (strpos($uriStr, 'sop') !== false);
        $isProkerActive     = (strpos($uriStr, 'program-kerja') !== false || strpos($uriStr, 'proker') !== false);

        $isDrawerActive     = ($isPengaturanActive || $isProfilActive || $isStrukturActive || $isFaqActive || $isSopActive || $isCsActive || $isProkerActive || $isAppAlatActive || $isAppLaporActive);

        $isLoggedIn          = session()->get('isLoggedIn');
        $userRole            = session()->get('role');
        $isAuditor           = ($userRole === 'Auditor');
        $isAdmin             = ($userRole === 'Admin');
        $isUserAdminOrAuditor = $isLoggedIn && in_array($userRole, ['Admin', 'Auditor']);
        $isUserPengurusOrKader = $isLoggedIn && in_array($userRole, ['Pengurus', 'Kader']);

        // Query status notifikasi baru untuk CS dan Pengajuan Alat serta Nomor WA Hotline CS
        $db = \Config\Database::connect();
        $notifCsCount = 0;
        $notifAlatCount = 0;
        $hotlineWa = '081234567890';

        try {
            if ($db->tableExists('cs_reports')) {
                $notifCsCount = $db->table('cs_reports')->where('status', 'Baru')->countAllResults();
            }
            if ($db->tableExists('alat_pengajuan')) {
                $notifAlatCount = $db->table('alat_pengajuan')->where('status', 'Pending')->countAllResults();
            }
            if ($db->tableExists('tbl_pengaturan')) {
                $settingRow = $db->table('tbl_pengaturan')->where('setting_key', 'hotline_wa')->get()->getRowArray();
                if (!empty($settingRow['setting_value'])) {
                    $hotlineWa = trim($settingRow['setting_value']);
                }
            }
        } catch (\Throwable $e) {
            // Silently fallback if table issue
        }

        // Generate WhatsApp Hotline Direct Link
        $cleanWaNumber = preg_replace('/[^0-9]/', '', $hotlineWa);
        if (substr($cleanWaNumber, 0, 1) === '0') {
            $cleanWaNumber = '62' . substr($cleanWaNumber, 1);
        } elseif (substr($cleanWaNumber, 0, 2) !== '62') {
            $cleanWaNumber = '62' . $cleanWaNumber;
        }
        $waCsMessage = "Halo Admin Kebersihan K3L, saya ingin berkonsultasi / membutuhkan bantuan terkait kebersihan.";
        $waCsUrl = "https://api.whatsapp.com/send?phone=" . $cleanWaNumber . "&text=" . urlencode($waCsMessage);

        if ($isUserAdminOrAuditor) {
            // Mode 1: Admin & Auditor Grouped Navigation
            $navGroups = [
                [
                    'type'   => 'link',
                    'url'    => base_url('/'),
                    'icon'   => 'fa-solid fa-house',
                    'label'  => 'Beranda',
                    'active' => $isHomeActive,
                ],
                [
                    'type'     => 'dropdown',
                    'label'    => 'Operasional',
                    'icon'     => 'fa-solid fa-broom-ball',
                    'badge'    => $notifAlatCount,
                    'active'   => ($isWilayahActive || $isAlatActive || $isProkerActive),
                    'children' => [
                        [
                            'url'    => base_url('wilayah'),
                            'icon'   => 'fa-solid fa-map-location-dot',
                            'label'  => 'Pemetaan Wilayah',
                            'desc'   => 'Zona & pemetaan titik wilayah kebersihan',
                            'active' => $isWilayahActive,
                        ],
                        [
                            'url'    => base_url('alat'),
                            'icon'   => 'fa-solid fa-broom-ball',
                            'label'  => 'Alat Kebersihan',
                            'desc'   => 'Inventaris & persetujuan logistik',
                            'badge'  => $notifAlatCount,
                            'active' => $isAlatActive,
                        ],
                        [
                            'url'    => base_url('program-kerja'),
                            'icon'   => 'fa-solid fa-list-check',
                            'label'  => 'Program Kerja',
                            'desc'   => 'Agenda & target kerja tahunan',
                            'active' => $isProkerActive,
                        ],
                    ]
                ],
                [
                    'type'     => 'dropdown',
                    'label'    => 'Laporan & Keuangan',
                    'icon'     => 'fa-solid fa-chart-pie',
                    'active'   => ($isBukuActive || $isKeuanganActive),
                    'children' => [
                        [
                            'url'    => base_url('buku'),
                            'icon'   => 'fa-solid fa-book-bookmark',
                            'label'  => 'Daftar Buku LPJ',
                            'desc'   => 'Laporan pertanggungjawaban bulanan',
                            'active' => $isBukuActive,
                        ],
                        [
                            'url'    => base_url('keuangan'),
                            'icon'   => 'fa-solid fa-calculator',
                            'label'  => 'Laporan Keuangan',
                            'desc'   => 'Pembukuan pemasukan & belanja',
                            'active' => $isKeuanganActive,
                        ],
                    ]
                ],
                [
                    'type'     => 'dropdown',
                    'label'    => 'Pusat Informasi',
                    'icon'     => 'fa-solid fa-circle-info',
                    'badge'    => $notifCsCount,
                    'active'   => ($isStrukturActive || $isSopActive || $isFaqActive || $isCsActive),
                    'children' => [
                        [
                            'url'    => base_url('struktur'),
                            'icon'   => 'fa-solid fa-sitemap',
                            'label'  => 'Struktur Kebersihan',
                            'desc'   => 'Struktur organisasi tim kebersihan',
                            'active' => $isStrukturActive,
                        ],
                        [
                            'url'    => base_url('sop'),
                            'icon'   => 'fa-solid fa-file-shield',
                            'label'  => 'SOP & Kebijakan',
                            'desc'   => 'Standar operasional prosedur K3L',
                            'active' => $isSopActive,
                        ],
                        [
                            'url'    => base_url('faq'),
                            'icon'   => 'fa-solid fa-circle-question',
                            'label'  => 'FAQ & Panduan Alur',
                            'desc'   => 'Panduan alur modul & tanya jawab',
                            'active' => $isFaqActive,
                        ],
                        [
                            'url'    => base_url('cs'),
                            'icon'   => 'fa-solid fa-headset',
                            'label'  => 'Customer Service',
                            'desc'   => 'Aduan & keluhan kebersihan unit',
                            'badge'  => $notifCsCount,
                            'active' => $isCsActive,
                        ],
                    ]
                ]
            ];
        } elseif ($isUserPengurusOrKader) {
            // Mode 2: Pengurus & Kader Grouped Navigation
            $navGroups = [
                [
                    'type'   => 'link',
                    'url'    => base_url('/'),
                    'icon'   => 'fa-solid fa-house',
                    'label'  => 'Beranda',
                    'active' => $isHomeActive,
                ],
                [
                    'type'     => 'dropdown',
                    'label'    => 'Portal Unit',
                    'icon'     => 'fa-solid fa-gauge-high',
                    'active'   => ($isAppActive || $isAppLpjActive || $isAppWilayahActive || $isAppAlatActive || $isAppLaporActive),
                    'children' => [
                        [
                            'url'    => base_url('app'),
                            'icon'   => 'fa-solid fa-gauge-high',
                            'label'  => 'Dashboard Unit',
                            'desc'   => 'Ringkasan & status kebersihan unit',
                            'active' => $isAppActive,
                        ],
                        [
                            'url'    => base_url('app/lpj'),
                            'icon'   => 'fa-solid fa-pen-to-square',
                            'label'  => 'Isi LPJ Unit',
                            'desc'   => 'Pengisian laporan bulanan unit',
                            'active' => $isAppLpjActive,
                        ],
                        [
                            'url'    => base_url('app/lapor-wilayah'),
                            'icon'   => 'fa-solid fa-map-location-dot',
                            'label'  => 'Lapor Wilayah',
                            'desc'   => 'Laporan kondisi titik/zona wilayah',
                            'active' => $isAppWilayahActive,
                        ],
                        [
                            'url'    => base_url('app/pengajuan-alat'),
                            'icon'   => 'fa-solid fa-box-open',
                            'label'  => 'Pengajuan Alat',
                            'desc'   => 'Permohonan kebutuhan alat kebersihan',
                            'active' => $isAppAlatActive,
                        ],
                        [
                            'url'    => base_url('app/laporan-kebersihan'),
                            'icon'   => 'fa-solid fa-headset',
                            'label'  => 'Lapor CS / Keluhan',
                            'desc'   => 'Kirim aduan/keluhan ke Admin',
                            'active' => $isAppLaporActive,
                        ],
                    ]
                ],
                [
                    'type'     => 'dropdown',
                    'label'    => 'Pusat Informasi',
                    'icon'     => 'fa-solid fa-circle-info',
                    'active'   => ($isProkerActive || $isStrukturActive || $isSopActive || $isFaqActive),
                    'children' => [
                        [
                            'url'    => base_url('program-kerja'),
                            'icon'   => 'fa-solid fa-list-check',
                            'label'  => 'Program Kerja',
                            'desc'   => 'Agenda & target kerja K3L',
                            'active' => $isProkerActive,
                        ],
                        [
                            'url'    => base_url('struktur'),
                            'icon'   => 'fa-solid fa-sitemap',
                            'label'  => 'Struktur Kebersihan',
                            'desc'   => 'Struktur organisasi tim kebersihan',
                            'active' => $isStrukturActive,
                        ],
                        [
                            'url'    => base_url('sop'),
                            'icon'   => 'fa-solid fa-file-shield',
                            'label'  => 'SOP Kebersihan',
                            'desc'   => 'Standar operasional prosedur K3L',
                            'active' => $isSopActive,
                        ],
                        [
                            'url'    => base_url('faq'),
                            'icon'   => 'fa-solid fa-circle-question',
                            'label'  => 'FAQ & Panduan Alur',
                            'desc'   => 'Panduan alur sistem & tanya jawab',
                            'active' => $isFaqActive,
                        ],
                    ]
                ]
            ];
        } else {
            // Mode 3: Public General Visitors Menu
            $navGroups = [
                [
                    'type'   => 'link',
                    'url'    => base_url('/'),
                    'icon'   => 'fa-solid fa-house',
                    'label'  => 'Beranda',
                    'active' => $isHomeActive,
                ],
                [
                    'type'     => 'dropdown',
                    'label'    => 'Informasi & Regulasi',
                    'icon'     => 'fa-solid fa-circle-info',
                    'active'   => ($isProkerActive || $isStrukturActive || $isSopActive || $isFaqActive),
                    'children' => [
                        [
                            'url'    => base_url('program-kerja'),
                            'icon'   => 'fa-solid fa-list-check',
                            'label'  => 'Program Kerja',
                            'desc'   => 'Agenda & program kerja kebersihan',
                            'active' => $isProkerActive,
                        ],
                        [
                            'url'    => base_url('sop'),
                            'icon'   => 'fa-solid fa-file-shield',
                            'label'  => 'SOP Kebersihan',
                            'desc'   => 'Standar operasional prosedur',
                            'active' => $isSopActive,
                        ],
                        [
                            'url'    => base_url('struktur'),
                            'icon'   => 'fa-solid fa-sitemap',
                            'label'  => 'Struktur Kebersihan',
                            'desc'   => 'Bagan organisasi tim kebersihan',
                            'active' => $isStrukturActive,
                        ],
                        [
                            'url'    => base_url('faq'),
                            'icon'   => 'fa-solid fa-circle-question',
                            'label'  => 'FAQ & Panduan Alur',
                            'desc'   => 'Tanya jawab & alur pemakaian',
                            'active' => $isFaqActive,
                        ],
                    ]
                ],
                [
                    'type'   => 'link',
                    'url'    => base_url('cs'),
                    'icon'   => 'fa-solid fa-headset',
                    'label'  => 'Lapor CS',
                    'active' => $isCsActive,
                ],
            ];
        }
    ?>
    <header class="fixed top-0 left-0 right-0 z-40 w-full glass-card shadow-xs border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 gap-2.5">
                <!-- Logo & Brand Header -->
                <a href="<?= base_url('/') ?>" title="LAPOR KEBERSIHAN - Web Manajemen Kebersihan" class="brand-logo-btn group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-700 flex items-center justify-center text-white shadow-xs shadow-emerald-600/25 ring-1.5 ring-emerald-500/20 group-hover:shadow-md group-hover:shadow-emerald-600/35 group-hover:scale-105 transition-all duration-300 flex-shrink-0">
                        <i class="fa-solid fa-leaf text-xs drop-shadow-xs"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="flex items-center gap-1.5 leading-none">
                            <span class="font-heading font-black text-xs sm:text-sm tracking-tight text-slate-900 group-hover:text-emerald-800 transition">LAPOR</span>
                            <span class="font-heading font-black text-xs sm:text-sm tracking-tight bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 bg-clip-text text-transparent">KEBERSIHAN</span>
                        </div>
                        <div class="flex items-center gap-1 mt-0.5 leading-none">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-[9.5px] sm:text-[10px] text-slate-400 font-bold tracking-wide group-hover:text-emerald-700 transition whitespace-nowrap">Web Manajemen Kebersihan</p>
                        </div>
                    </div>
                </a>

                <!-- Desktop / Tablet Horizontal Navigation -->
                <div class="hidden lg:flex items-center gap-1.5">
                    <?php foreach ($navGroups as $group): 
                        $groupHasBadge = !empty($group['badge']) && (int)$group['badge'] > 0;
                    ?>
                        <?php if ($group['type'] === 'link'): ?>
                            <!-- Single Direct Link -->
                            <a href="<?= $group['url'] ?>" class="top-nav-btn <?= $group['active'] ? 'active font-heading' : '' ?>">
                                <i class="<?= $group['icon'] ?> text-xs flex-shrink-0 <?= $group['active'] ? 'text-white' : 'text-slate-400' ?>"></i>
                                <span><?= $group['label'] ?></span>
                                <?php if ($groupHasBadge): ?>
                                    <span class="ml-0.5 px-1.5 py-0.2 rounded-full bg-rose-500 text-white text-[9px] font-black animate-pulse">
                                        <?= $group['badge'] > 99 ? '99+' : $group['badge'] ?>
                                    </span>
                                <?php endif; ?>
                            </a>

                        <?php elseif ($group['type'] === 'dropdown'): ?>
                            <!-- Dropdown Group Button -->
                            <div class="relative nav-dropdown-parent">
                                <button type="button" class="top-nav-btn nav-dropdown-toggle <?= $group['active'] ? 'active font-heading' : '' ?>">
                                    <i class="<?= $group['icon'] ?> text-xs flex-shrink-0 <?= $group['active'] ? 'text-white' : 'text-slate-400' ?>"></i>
                                    <span><?= $group['label'] ?></span>
                                    <?php if ($groupHasBadge): ?>
                                        <span class="px-1.5 py-0.2 rounded-full bg-rose-500 text-white text-[9px] font-black animate-pulse">
                                            <?= $group['badge'] > 99 ? '99+' : $group['badge'] ?>
                                        </span>
                                    <?php endif; ?>
                                    <i class="fa-solid fa-chevron-down nav-dropdown-chevron text-[9px] transition-transform duration-200 <?= $group['active'] ? 'text-white/80' : 'text-slate-400' ?>"></i>
                                </button>

                                <!-- Dropdown Menu Floating Card -->
                                <div class="nav-dropdown-wrapper">
                                    <div class="min-w-[260px] bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200/90 p-1.5 space-y-0.5">
                                        <?php foreach ($group['children'] as $child): 
                                            $childHasBadge = !empty($child['badge']) && (int)$child['badge'] > 0;
                                        ?>
                                            <a href="<?= $child['url'] ?>" class="group/item flex items-center gap-2.5 p-2 rounded-xl transition duration-150 <?= $child['active'] ? 'bg-emerald-50 text-emerald-800 font-extrabold border border-emerald-200/60 shadow-xs' : 'text-slate-700 hover:bg-slate-100/80 hover:text-emerald-700' ?>">
                                                <div class="w-7 h-7 rounded-lg <?= $child['active'] ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 group-hover/item:bg-emerald-100 group-hover/item:text-emerald-700' ?> flex items-center justify-center text-xs flex-shrink-0">
                                                    <i class="<?= $child['icon'] ?>"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between gap-1">
                                                        <span class="text-xs font-heading <?= $child['active'] ? 'font-extrabold text-emerald-900' : 'font-bold text-slate-800' ?> truncate"><?= $child['label'] ?></span>
                                                        <?php if ($childHasBadge): ?>
                                                            <span class="px-1.5 py-0.2 rounded-full bg-rose-500 text-white text-[9px] font-black animate-pulse">
                                                                <?= $child['badge'] > 99 ? '99+' : $child['badge'] ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($child['desc'])): ?>
                                                        <p class="text-[10px] text-slate-400 font-medium truncate"><?= $child['desc'] ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- User Profile Dropdown / Login Action -->
                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="relative nav-dropdown-parent ml-0.5">
                            <button type="button" class="top-nav-profile-btn nav-dropdown-toggle">
                                <div class="top-nav-avatar">
                                    <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 1)) ?>
                                </div>
                                <div class="text-left hidden xl:flex flex-col justify-center leading-tight">
                                    <span class="font-heading font-extrabold text-[11px] text-slate-800 truncate max-w-[120px] leading-tight"><?= esc(session()->get('nama_lengkap')) ?></span>
                                    <span class="text-[9px] font-bold leading-tight mt-0.5 <?= session()->get('role') === 'Admin' ? 'text-emerald-700' : (session()->get('role') === 'Auditor' ? 'text-blue-700' : 'text-purple-700') ?>">
                                        <?= esc(session()->get('role')) ?>
                                    </span>
                                </div>
                                <i class="fa-solid fa-chevron-down nav-dropdown-chevron text-[9px] text-slate-400 transition-transform duration-200"></i>
                            </button>

                            <!-- User Profile Dropdown Card -->
                            <div class="nav-dropdown-wrapper align-right">
                                <div class="min-w-[240px] bg-white/95 backdrop-blur-xl border border-slate-200/90 rounded-2xl shadow-xl shadow-slate-900/10 p-1.5 space-y-0.5">
                                    <div class="p-2.5 bg-slate-50/90 rounded-xl border border-slate-100 mb-1">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold text-xs shadow-xs flex-shrink-0">
                                                <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 1)) ?>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-heading font-extrabold text-xs text-slate-900 truncate leading-tight"><?= esc(session()->get('nama_lengkap')) ?></p>
                                                <div class="flex items-center gap-1 mt-1 flex-wrap">
                                                    <span class="text-[9px] px-1.5 py-0.5 rounded-md font-extrabold uppercase tracking-wider <?= session()->get('role') === 'Admin' ? 'bg-emerald-100 text-emerald-800' : (session()->get('role') === 'Auditor' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') ?>">
                                                        <?= esc(session()->get('role')) ?>
                                                    </span>
                                                    <?php if (session()->get('role') === 'Auditor'): ?>
                                                        <span class="text-[9px] px-1.5 py-0.5 rounded-md font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                                            Read-Only
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if (session()->get('nama_unit')): ?>
                                                        <span class="text-[9px] px-1.5 py-0.5 rounded-md font-semibold bg-slate-200 text-slate-700 truncate max-w-[80px]">
                                                            <?= esc(session()->get('nama_unit')) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($isUserAdminOrAuditor): ?>
                                        <a href="<?= base_url('pengaturan') ?>" class="group/item flex items-center gap-2.5 p-2 rounded-xl transition duration-150 <?= $isPengaturanActive ? 'bg-emerald-50 text-emerald-800 font-extrabold border border-emerald-200/60 shadow-xs' : 'text-slate-700 hover:bg-slate-100/80 hover:text-emerald-700' ?>">
                                            <div class="w-7 h-7 rounded-lg <?= $isPengaturanActive ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 group-hover/item:bg-emerald-100 group-hover/item:text-emerald-700' ?> flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-sliders"></i>
                                            </div>
                                            <span class="text-xs font-heading <?= $isPengaturanActive ? 'font-extrabold text-emerald-900' : 'font-bold text-slate-800' ?> truncate">Master Pengaturan</span>
                                        </a>
                                        <a href="<?= base_url('profil') ?>" class="group/item flex items-center gap-2.5 p-2 rounded-xl transition duration-150 <?= $isProfilActive ? 'bg-emerald-50 text-emerald-800 font-extrabold border border-emerald-200/60 shadow-xs' : 'text-slate-700 hover:bg-slate-100/80 hover:text-emerald-700' ?>">
                                            <div class="w-7 h-7 rounded-lg <?= $isProfilActive ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 group-hover/item:bg-emerald-100 group-hover/item:text-emerald-700' ?> flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-user-gear"></i>
                                            </div>
                                            <span class="text-xs font-heading <?= $isProfilActive ? 'font-extrabold text-emerald-900' : 'font-bold text-slate-800' ?> truncate">Kelola Akun & Profil</span>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('app') ?>" class="group/item flex items-center gap-2.5 p-2 rounded-xl transition duration-150 <?= $isAppActive ? 'bg-emerald-50 text-emerald-800 font-extrabold border border-emerald-200/60 shadow-xs' : 'text-slate-700 hover:bg-slate-100/80 hover:text-emerald-700' ?>">
                                            <div class="w-7 h-7 rounded-lg <?= $isAppActive ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 group-hover/item:bg-emerald-100 group-hover/item:text-emerald-700' ?> flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-gauge-high"></i>
                                            </div>
                                            <span class="text-xs font-heading <?= $isAppActive ? 'font-extrabold text-emerald-900' : 'font-bold text-slate-800' ?> truncate">Dashboard Unit</span>
                                        </a>
                                    <?php endif; ?>

                                    <div class="border-t border-slate-100 my-0.5"></div>
                                    <a href="<?= base_url('logout') ?>" data-confirm-msg="Apakah Anda yakin ingin keluar/logout?" class="group/item flex items-center gap-2.5 p-2 rounded-xl transition duration-150 text-rose-600 hover:bg-rose-50/80 hover:text-rose-700">
                                        <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 group-hover/item:bg-rose-100 group-hover/item:text-rose-700 flex items-center justify-center text-xs flex-shrink-0">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </div>
                                        <span class="text-xs font-heading font-bold text-rose-600 group-hover/item:text-rose-700 truncate">Keluar / Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" title="Login Petugas / Pengurus" class="top-nav-btn bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/80 shadow-2xs ml-0.5">
                            <i class="fa-solid fa-right-to-bracket text-xs flex-shrink-0 text-emerald-600"></i>
                            <span>Masuk / Login</span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Hamburger Toggle Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button type="button" onclick="toggleMobileDrawer(true)" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 shadow-2xs flex items-center justify-center transition" aria-label="Buka Menu Navigasi">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Fixed Header Layout Spacer (Prevents Content Underflow) -->
    <div class="h-14 w-full flex-shrink-0" aria-hidden="true"></div>

    <!-- Mobile Off-Canvas Drawer Navigation -->
    <div id="mobileDrawerContainer" class="fixed inset-0 pointer-events-none transition-all hidden" style="z-index: 99999999 !important;">
        <!-- Backdrop -->
        <div id="mobileDrawerBackdrop" onclick="toggleMobileDrawer(false)" class="absolute inset-0 bg-slate-950/50 backdrop-blur-xs opacity-0 transition-opacity duration-300"></div>

        <!-- Drawer Content Body -->
        <div id="mobileDrawer" class="absolute top-0 right-0 w-[85vw] max-w-xs h-full bg-white shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-out pointer-events-auto overflow-y-auto">
            <div class="p-5 space-y-4">
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
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center font-heading font-black text-sm flex-shrink-0 shadow-2xs">
                            <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-heading font-extrabold text-xs text-slate-900 truncate"><?= esc(session()->get('nama_lengkap')) ?></div>
                            <span class="inline-block text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider mt-0.5 <?= session()->get('role') === 'Admin' ? 'bg-emerald-100 text-emerald-800' : (session()->get('role') === 'Auditor' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') ?>">
                                <?= esc(session()->get('role')) ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Drawer Categorized Links List -->
                <div class="space-y-4">
                    <?php foreach ($navGroups as $group): ?>
                        <?php if ($group['type'] === 'link'): ?>
                            <a href="<?= $group['url'] ?>" onclick="toggleMobileDrawer(false)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-heading font-bold transition <?= $group['active'] ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700' ?>">
                                <div class="flex items-center gap-2.5">
                                    <i class="<?= $group['icon'] ?> text-sm w-5 text-center <?= $group['active'] ? 'text-white' : 'text-slate-400' ?>"></i>
                                    <span><?= $group['label'] ?></span>
                                </div>
                                <?php if (!empty($group['badge']) && $group['badge'] > 0): ?>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?= $group['active'] ? 'bg-white text-emerald-800' : 'bg-rose-500 text-white' ?>">
                                        <?= $group['badge'] ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php elseif ($group['type'] === 'dropdown'): ?>
                            <div class="space-y-1">
                                <div class="px-3 pt-1 pb-1 flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                                    <span class="flex items-center gap-1.5">
                                        <i class="<?= $group['icon'] ?> text-[10px] text-emerald-600"></i>
                                        <?= $group['label'] ?>
                                    </span>
                                    <?php if (!empty($group['badge']) && $group['badge'] > 0): ?>
                                        <span class="px-1.5 py-0.2 rounded-full bg-rose-500 text-white text-[9px] font-black">
                                            <?= $group['badge'] ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php foreach ($group['children'] as $child): 
                                    $childHasBadge = !empty($child['badge']) && (int)$child['badge'] > 0;
                                ?>
                                    <a href="<?= $child['url'] ?>" onclick="toggleMobileDrawer(false)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition <?= $child['active'] ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700' ?>">
                                        <div class="flex items-center gap-2.5">
                                            <i class="<?= $child['icon'] ?> text-sm w-5 text-center <?= $child['active'] ? 'text-white' : 'text-slate-400' ?>"></i>
                                            <span><?= $child['label'] ?></span>
                                        </div>
                                        <?php if ($childHasBadge): ?>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?= $child['active'] ? 'bg-white text-emerald-800' : 'bg-rose-500 text-white' ?>">
                                                <?= $child['badge'] ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($isUserAdminOrAuditor): ?>
                        <!-- Admin Account Settings in Drawer -->
                        <div class="space-y-1 pt-1">
                            <div class="px-3 pt-1 pb-1 flex items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                                <i class="fa-solid fa-user-gear text-[10px] text-emerald-600"></i>
                                Pengaturan & Akun
                            </div>
                            <a href="<?= base_url('pengaturan') ?>" onclick="toggleMobileDrawer(false)" class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition <?= $isPengaturanActive ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700' ?>">
                                <i class="fa-solid fa-sliders text-sm w-5 text-center <?= $isPengaturanActive ? 'text-white' : 'text-slate-400' ?>"></i>
                                <span>Master Pengaturan</span>
                            </a>
                            <a href="<?= base_url('profil') ?>" onclick="toggleMobileDrawer(false)" class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition <?= $isProfilActive ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700' ?>">
                                <i class="fa-solid fa-user-gear text-sm w-5 text-center <?= $isProfilActive ? 'text-white' : 'text-slate-400' ?>"></i>
                                <span>Kelola Akun & Profil</span>
                            </a>
                        </div>
                    <?php endif; ?>
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
            var savedScrollY = 0;
            var isDrawerOpen = false;

            function toggleMobileDrawer(open) {
                var container = document.getElementById('mobileDrawerContainer');
                var drawer = document.getElementById('mobileDrawer');
                var backdrop = document.getElementById('mobileDrawerBackdrop');
                if (!container || !drawer || !backdrop) return;

                if (open) {
                    if (isDrawerOpen) return;
                    isDrawerOpen = true;
                    if (drawerCloseTimer) { clearTimeout(drawerCloseTimer); drawerCloseTimer = null; }

                    // Record scroll position before locking
                    savedScrollY = window.pageYOffset || document.documentElement.scrollTop || window.scrollY || 0;

                    container.classList.remove('hidden');
                    container.style.display = 'block';
                    container.style.pointerEvents = 'auto';

                    // Complete mobile & desktop body scroll lock
                    document.body.style.position = 'fixed';
                    document.body.style.top = '-' + savedScrollY + 'px';
                    document.body.style.left = '0';
                    document.body.style.right = '0';
                    document.body.style.width = '100%';
                    document.body.style.overflow = 'hidden';
                    document.body.classList.add('drawer-open', 'overflow-hidden');

                    requestAnimationFrame(function() {
                        backdrop.style.opacity = '1';
                        drawer.style.transform = 'translateX(0)';
                    });
                } else {
                    if (!isDrawerOpen && container.classList.contains('hidden')) return;
                    isDrawerOpen = false;

                    backdrop.style.opacity = '0';
                    drawer.style.transform = 'translateX(100%)';
                    container.style.pointerEvents = 'none';

                    // Unlock body scroll and restore previous scroll position accurately
                    var restoreY = savedScrollY;
                    document.body.style.position = '';
                    document.body.style.top = '';
                    document.body.style.left = '';
                    document.body.style.right = '';
                    document.body.style.width = '';
                    document.body.style.overflow = '';
                    document.body.classList.remove('drawer-open', 'overflow-hidden');
                    window.scrollTo(0, restoreY);

                    drawerCloseTimer = setTimeout(function() {
                        container.classList.add('hidden');
                        container.style.display = 'none';
                        drawerCloseTimer = null;
                        document.body.style.position = '';
                        document.body.style.top = '';
                        document.body.style.left = '';
                        document.body.style.right = '';
                        document.body.style.width = '';
                        document.body.style.overflow = '';
                        document.body.classList.remove('drawer-open', 'overflow-hidden');
                    }, 300);
                }
            }

            // Prevent touchmove gestures on the backdrop from scrolling background on iOS/Android
            document.addEventListener('DOMContentLoaded', function() {
                var backdrop = document.getElementById('mobileDrawerBackdrop');
                if (backdrop) {
                    backdrop.addEventListener('touchmove', function(e) {
                        e.preventDefault();
                    }, { passive: false });
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isDrawerOpen) {
                    toggleMobileDrawer(false);
                }
            });

            window.toggleMobileDrawer = toggleMobileDrawer;
        })();
    </script>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-24 md:py-8">
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
    <?php
        // Generate role-specific footer menu links
        $footerCol1 = [];
        $footerCol2 = [];
        $footerCol1Title = 'Navigasi Menu';
        $footerCol1Icon = 'fa-solid fa-compass';
        $footerCol2Title = 'Informasi & Layanan';
        $footerCol2Icon = 'fa-solid fa-layer-group';
        $footerCsUrl = base_url('cs');
        $footerCsLabel = 'Buka Layanan CS';
        $footerCsDesc = 'Butuh bantuan operasional atau ingin menyampaikan kendala kebersihan?';

        if ($isUserAdminOrAuditor) {
            $footerCol1Title = 'Operasional & Wilayah';
            $footerCol1Icon = 'fa-solid fa-broom-ball';
            $footerCol1 = [
                ['url' => base_url('/'), 'icon' => 'fa-solid fa-house', 'label' => 'Beranda Utama'],
                ['url' => base_url('wilayah'), 'icon' => 'fa-solid fa-map-location-dot', 'label' => 'Pemetaan Wilayah'],
                ['url' => base_url('alat'), 'icon' => 'fa-solid fa-broom-ball', 'label' => 'Alat Kebersihan'],
                ['url' => base_url('program-kerja'), 'icon' => 'fa-solid fa-list-check', 'label' => 'Program Kerja'],
            ];

            $footerCol2Title = 'Laporan & Regulasi';
            $footerCol2Icon = 'fa-solid fa-chart-pie';
            $footerCol2 = [
                ['url' => base_url('buku'), 'icon' => 'fa-solid fa-book-bookmark', 'label' => 'Daftar Buku LPJ'],
                ['url' => base_url('keuangan'), 'icon' => 'fa-solid fa-calculator', 'label' => 'Laporan Keuangan'],
                ['url' => base_url('sop'), 'icon' => 'fa-solid fa-file-shield', 'label' => 'SOP & Kebijakan'],
                ['url' => base_url('struktur'), 'icon' => 'fa-solid fa-sitemap', 'label' => 'Struktur Kebersihan'],
                ['url' => base_url('faq'), 'icon' => 'fa-solid fa-circle-question', 'label' => 'FAQ & Panduan Alur'],
                ['url' => base_url('cs'), 'icon' => 'fa-solid fa-headset', 'label' => 'Customer Service'],
            ];
            $footerCsUrl = base_url('cs');
            $footerCsLabel = 'Kelola Layanan CS';
            $footerCsDesc = 'Pantau dan tindak lanjuti laporan kendala serta pengajuan logistik unit.';
        } elseif ($isUserPengurusOrKader) {
            $footerCol1Title = 'Portal Unit & Lapor';
            $footerCol1Icon = 'fa-solid fa-gauge-high';
            $footerCol1 = [
                ['url' => base_url('/'), 'icon' => 'fa-solid fa-house', 'label' => 'Beranda Utama'],
                ['url' => base_url('app'), 'icon' => 'fa-solid fa-gauge-high', 'label' => 'Dashboard Unit'],
                ['url' => base_url('app/lpj'), 'icon' => 'fa-solid fa-pen-to-square', 'label' => 'Isi LPJ Unit'],
                ['url' => base_url('app/lapor-wilayah'), 'icon' => 'fa-solid fa-map-location-dot', 'label' => 'Lapor Wilayah'],
                ['url' => base_url('app/pengajuan-alat'), 'icon' => 'fa-solid fa-box-open', 'label' => 'Pengajuan Alat'],
                ['url' => base_url('app/laporan-kebersihan'), 'icon' => 'fa-solid fa-headset', 'label' => 'Lapor Kendala CS'],
            ];

            $footerCol2Title = 'Informasi & Panduan';
            $footerCol2Icon = 'fa-solid fa-circle-info';
            $footerCol2 = [
                ['url' => base_url('program-kerja'), 'icon' => 'fa-solid fa-list-check', 'label' => 'Program Kerja'],
                ['url' => base_url('sop'), 'icon' => 'fa-solid fa-file-shield', 'label' => 'SOP Kebersihan'],
                ['url' => base_url('struktur'), 'icon' => 'fa-solid fa-sitemap', 'label' => 'Struktur Kebersihan'],
                ['url' => base_url('faq'), 'icon' => 'fa-solid fa-circle-question', 'label' => 'FAQ & Panduan Alur'],
            ];
            $footerCsUrl = base_url('app/laporan-kebersihan');
            $footerCsLabel = 'Kirim Laporan CS';
            $footerCsDesc = 'Ada kendala kebersihan atau sarpras di unit Anda? Laporkan ke tim pengelola.';
        } else {
            // Mode Umum / Public Guest
            $footerCol1Title = 'Navigasi Publik';
            $footerCol1Icon = 'fa-solid fa-compass';
            $footerCol1 = [
                ['url' => base_url('/'), 'icon' => 'fa-solid fa-house', 'label' => 'Beranda Utama'],
                ['url' => base_url('cs'), 'icon' => 'fa-solid fa-headset', 'label' => 'Layanan CS Publik'],
                ['url' => base_url('login'), 'icon' => 'fa-solid fa-right-to-bracket', 'label' => 'Login Petugas'],
            ];

            $footerCol2Title = 'Informasi & Regulasi';
            $footerCol2Icon = 'fa-solid fa-circle-info';
            $footerCol2 = [
                ['url' => base_url('program-kerja'), 'icon' => 'fa-solid fa-list-check', 'label' => 'Program Kerja'],
                ['url' => base_url('sop'), 'icon' => 'fa-solid fa-file-shield', 'label' => 'SOP Kebersihan'],
                ['url' => base_url('struktur'), 'icon' => 'fa-solid fa-sitemap', 'label' => 'Struktur Kebersihan'],
                ['url' => base_url('faq'), 'icon' => 'fa-solid fa-circle-question', 'label' => 'FAQ & Panduan Alur'],
            ];
            $footerCsUrl = base_url('cs');
            $footerCsLabel = 'Buka Layanan CS';
            $footerCsDesc = 'Sampaikan aduan atau aspirasi terkait fasilitas dan kebersihan lingkungan yayasan.';
        }
    ?>
    <footer class="hidden md:block w-full border-t border-slate-200/80 bg-white/95 backdrop-blur-md pt-12 pb-8 mt-auto text-slate-600 relative overflow-hidden">
        <!-- Subtle Top Glow Line -->
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-emerald-500/40 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <!-- Top Section: Multi-Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10">
                
                <!-- Col 1: Brand & Bio (5 cols on lg) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-md shadow-emerald-600/25 ring-2 ring-emerald-500/20">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <span class="font-heading font-black text-base text-slate-900 tracking-tight block">
                                LAPOR <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">KEBERSIHAN</span>
                            </span>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Yayasan Assalafiyyah Mlangi</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                        Platform terpadu digitalisasi pemantauan mutu kebersihan, inspeksi wilayah, pengelolaan inventaris alat, serta pelaporan kinerja unit & kader secara transparan.
                    </p>

                    <div class="flex items-center gap-2 pt-1 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-[11px] font-bold shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Sistem Aktif & Terintegrasi</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200/80 text-[11px] font-bold">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span><?= esc($userRole ? 'Akses: ' . $userRole : 'Akses Publik / Umum') ?></span>
                        </span>
                    </div>
                </div>

                <!-- Col 2: Dynamic Role Navigasi Column 1 (2 cols on lg) -->
                <div class="lg:col-span-2 space-y-3">
                    <p class="text-xs font-heading font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="<?= esc($footerCol1Icon) ?> text-emerald-600 text-[11px]"></i>
                        <span><?= esc($footerCol1Title) ?></span>
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500">
                        <?php foreach ($footerCol1 as $item): ?>
                            <li>
                                <a href="<?= $item['url'] ?>" class="hover:text-emerald-700 hover:translate-x-1 transition-all duration-150 inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                                    <span><?= esc($item['label']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Col 3: Dynamic Role Navigasi Column 2 (2 cols on lg) -->
                <div class="lg:col-span-2 space-y-3">
                    <p class="text-xs font-heading font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="<?= esc($footerCol2Icon) ?> text-emerald-600 text-[11px]"></i>
                        <span><?= esc($footerCol2Title) ?></span>
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500">
                        <?php foreach ($footerCol2 as $item): ?>
                            <li>
                                <a href="<?= $item['url'] ?>" class="hover:text-emerald-700 hover:translate-x-1 transition-all duration-150 inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                                    <span><?= esc($item['label']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Col 4: Customer Service & Contact Card (3 cols on lg) -->
                <div class="lg:col-span-3 space-y-3">
                    <p class="text-xs font-heading font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-headset text-emerald-600 text-[11px]"></i>
                        <span>Bantuan & CS</span>
                    </p>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2.5 shadow-2xs">
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                            <?= esc($footerCsDesc) ?>
                        </p>
                        <a href="<?= $footerCsUrl ?>" class="w-full py-2 px-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs shadow-md shadow-emerald-600/20 hover:from-emerald-700 hover:to-teal-700 transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-headset text-xs"></i>
                            <span><?= esc($footerCsLabel) ?></span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Sub-Footer Bar -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2 text-center sm:text-left flex-wrap justify-center sm:justify-start">
                    <p>&copy; <?= date('Y') ?> <strong class="text-slate-800 font-bold">Yayasan Assalafiyyah Mlangi</strong>. Seluruh Hak Cipta Dilindungi.</p>
                </div>

                <div class="flex items-center gap-3 text-[11px]">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200/80 text-slate-600 font-bold">
                        <i class="fa-solid fa-code text-[10px] text-emerald-600"></i>
                        <span>Developed by <strong class="text-slate-800 font-extrabold">Musapang Company</strong></span>
                    </span>

                    <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 border border-slate-200/80 flex items-center justify-center transition shadow-2xs group" title="Kembali ke Atas">
                        <i class="fa-solid fa-arrow-up text-xs group-hover:-translate-y-0.5 transition-transform"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom App Bar Navigation (Hidden on Desktop, Visible on Mobile) -->
    <nav id="mobileBottomNav" class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-slate-200/90 shadow-[0_-4px_25px_rgba(0,0,0,0.08)] py-1.5 px-2">
        <div class="flex items-center justify-around max-w-md mx-auto">
            <?php if ($isUserAdminOrAuditor): ?>
                <!-- Admin / Auditor Mobile Bottom Tabs -->
                <a href="<?= base_url('/') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isHomeActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isHomeActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isHomeActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Beranda</span>
                </a>

                <a href="<?= base_url('wilayah') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isWilayahActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isWilayahActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isWilayahActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Wilayah</span>
                </a>

                <a href="<?= base_url('alat') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group relative <?= $isAlatActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs relative transition-all <?= $isAlatActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-broom-ball"></i>
                        <?php if ($notifAlatCount > 0): ?>
                            <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center animate-pulse shadow-2xs">
                                <?= $notifAlatCount > 9 ? '9+' : $notifAlatCount ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isAlatActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Alat</span>
                </a>

                <a href="<?= base_url('buku') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= ($isBukuActive || $isKeuanganActive) ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= ($isBukuActive || $isKeuanganActive) ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= ($isBukuActive || $isKeuanganActive) ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">LPJ</span>
                </a>

                <button type="button" onclick="toggleMobileDrawer(true)" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group relative <?= $isDrawerActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs relative transition-all <?= $isDrawerActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-bars"></i>
                        <?php if ($notifCsCount > 0): ?>
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-rose-500 ring-2 ring-white animate-pulse"></span>
                        <?php endif; ?>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isDrawerActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Menu</span>
                </button>

            <?php elseif ($isUserPengurusOrKader): ?>
                <!-- Pengurus / Kader Mobile Bottom Tabs -->
                <a href="<?= base_url('/') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isHomeActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isHomeActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isHomeActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Beranda</span>
                </a>

                <a href="<?= base_url('app') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isAppActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isAppActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-gauge-high"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isAppActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Dashboard</span>
                </a>

                <a href="<?= base_url('app/lpj') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isAppLpjActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isAppLpjActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isAppLpjActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Isi LPJ</span>
                </a>

                <a href="<?= base_url('app/lapor-wilayah') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isAppWilayahActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isAppWilayahActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isAppWilayahActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Lapor Area</span>
                </a>

                <button type="button" onclick="toggleMobileDrawer(true)" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isDrawerActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isDrawerActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isDrawerActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Menu</span>
                </button>

            <?php else: ?>
                <!-- Public / Guest Mobile Bottom Tabs -->
                <a href="<?= base_url('/') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isHomeActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isHomeActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isHomeActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Beranda</span>
                </a>

                <a href="<?= base_url('program-kerja') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isProkerActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isProkerActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isProkerActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Program</span>
                </a>

                <a href="<?= base_url('sop') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isSopActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isSopActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isSopActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">SOP</span>
                </a>

                <a href="<?= base_url('cs') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isCsActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isCsActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isCsActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Lapor CS</span>
                </a>

                <a href="<?= base_url('login') ?>" class="flex flex-col items-center justify-center flex-1 py-0.5 gap-0.5 text-center transition group <?= $isLoginActive ? 'text-emerald-800' : 'text-slate-400 hover:text-emerald-700' ?>">
                    <div class="w-10 h-7 rounded-full flex items-center justify-center text-xs transition-all <?= $isLoginActive ? 'bg-emerald-100 text-emerald-800 font-black shadow-2xs -translate-y-0.5' : 'text-slate-400 group-hover:bg-slate-100 group-hover:text-emerald-700' ?>">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </div>
                    <span class="text-[10px] leading-tight tracking-tight <?= $isLoginActive ? 'font-heading font-black text-emerald-800' : 'font-bold text-slate-400 group-hover:text-slate-600' ?>">Login</span>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Floating Fixed WhatsApp Customer Service (CS) Button (Non-Admin / Non-Auditor Only) -->
    <div id="floatingCsContainer">
        <?php if (!$isUserAdminOrAuditor): ?>
            <aside aria-label="Hotline WhatsApp CS Admin Kebersihan" class="fixed bottom-20 right-4 md:bottom-6 md:right-6 z-40 group flex items-center">
                <!-- Floating Tooltip Card (Desktop Only) -->
                <a href="<?= $waCsUrl ?>" target="_blank" rel="noopener noreferrer" data-no-spa="true" class="hidden md:flex items-center gap-2.5 mr-3 px-3.5 py-2 rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200/90 shadow-xl shadow-slate-900/10 opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300 pointer-events-none group-hover:pointer-events-auto">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100 animate-pulse flex-shrink-0"></span>
                    <div class="text-left leading-tight">
                        <span class="font-heading font-black text-xs text-slate-900 block">Chat CS Kebersihan</span>
                        <span class="text-[10px] text-emerald-700 font-extrabold flex items-center gap-1 mt-0.5">
                            <i class="fa-brands fa-whatsapp text-emerald-600 text-xs"></i>
                            <span>WhatsApp Admin Online</span>
                        </span>
                    </div>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400 ml-1"></i>
                </a>

                <!-- Main CS Person & WhatsApp Floating Avatar Button -->
                <a href="<?= $waCsUrl ?>" target="_blank" rel="noopener noreferrer" data-no-spa="true" title="Hubungi CS Admin Kebersihan via WhatsApp (<?= esc($hotlineWa) ?>)" class="relative w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-emerald-600 via-teal-600 to-emerald-500 text-white shadow-xl shadow-emerald-600/35 hover:shadow-2xl hover:shadow-emerald-600/50 flex items-center justify-center transition-all duration-300 transform group-hover:scale-105 active:scale-95 ring-4 ring-emerald-500/20 hover:ring-emerald-500/40">
                    <!-- Online Pulse Halo -->
                    <span class="absolute -top-0.5 -right-0.5 flex h-3.5 w-3.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-400 ring-2 ring-white"></span>
                    </span>

                    <!-- CS Person Agent Icon -->
                    <i class="fa-solid fa-headset text-xl sm:text-2xl drop-shadow-xs group-hover:rotate-6 transition-transform"></i>

                    <!-- WhatsApp Badge Corner Pill -->
                    <span class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-[#25D366] text-white flex items-center justify-center text-xs sm:text-sm shadow-md ring-2 ring-white">
                        <i class="fa-brands fa-whatsapp"></i>
                    </span>
                </a>
            </aside>
        <?php endif; ?>
    </div>

    <!-- Universal SPA Toast Container -->
    <div id="spaToastContainer" class="fixed bottom-24 right-6 md:bottom-24 md:right-6 z-[100] space-y-2 pointer-events-none"></div>

    <script>
        // Desktop / Header Dropdown Navigation Manager
        function initNavDropdowns() {
            const dropdownParents = document.querySelectorAll('.nav-dropdown-parent');

            dropdownParents.forEach(parent => {
                const toggleBtn = parent.querySelector('.nav-dropdown-toggle');
                if (!toggleBtn) return;

                // Event listener for clicking toggle button
                if (!toggleBtn.dataset.navToggleBound) {
                    toggleBtn.dataset.navToggleBound = 'true';
                    toggleBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        const wasOpen = parent.classList.contains('is-open');

                        // Close all other dropdowns immediately
                        dropdownParents.forEach(p => {
                            if (p !== parent) {
                                p.classList.remove('is-open');
                            }
                        });

                        if (wasOpen) {
                            parent.classList.remove('is-open');
                            toggleBtn.blur();
                        } else {
                            parent.classList.add('is-open');
                        }
                    });
                }

                // Event listener for hovering over parent: immediately close other open dropdowns
                if (!parent.dataset.navParentBound) {
                    parent.dataset.navParentBound = 'true';

                    parent.addEventListener('mouseenter', function() {
                        dropdownParents.forEach(p => {
                            if (p !== parent) {
                                p.classList.remove('is-open');
                            }
                        });
                    });

                    parent.addEventListener('mouseleave', function() {
                        parent.classList.remove('is-open');
                        if (document.activeElement && parent.contains(document.activeElement)) {
                            document.activeElement.blur();
                        }
                    });

                    // Automatically close dropdown and blur focus when any link inside is clicked
                    parent.querySelectorAll('a').forEach(link => {
                        link.addEventListener('click', function() {
                            parent.classList.remove('is-open');
                            if (document.activeElement) {
                                document.activeElement.blur();
                            }
                        });
                    });
                }
            });
        }
        window.initNavDropdowns = initNavDropdowns;

        // Global Listeners for outside click & Escape key
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-dropdown-parent')) {
                document.querySelectorAll('.nav-dropdown-parent.is-open').forEach(p => {
                    p.classList.remove('is-open');
                });
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.nav-dropdown-parent.is-open').forEach(p => {
                    p.classList.remove('is-open');
                });
                if (document.activeElement && document.activeElement.closest('.nav-dropdown-parent')) {
                    document.activeElement.blur();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            initNavDropdowns();
        });

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
                    if (typeof window.initNavDropdowns === 'function') {
                        window.initNavDropdowns();
                    }
                }

                // Update Mobile Drawer Navigation and Profile Synchronously
                const currentDrawer = document.getElementById('mobileDrawer');
                const newDrawer = newDoc.querySelector('#mobileDrawer');
                if (currentDrawer && newDrawer) {
                    currentDrawer.innerHTML = newDrawer.innerHTML;
                }

                // Update Mobile Bottom Navigation Bar Synchronously
                const currentBottomNav = document.getElementById('mobileBottomNav');
                const newBottomNav = newDoc.querySelector('#mobileBottomNav');
                if (currentBottomNav && newBottomNav) {
                    currentBottomNav.innerHTML = newBottomNav.innerHTML;
                }

                // Update Floating CS Widget Container Synchronously
                const currentCsContainer = document.getElementById('floatingCsContainer');
                const newCsContainer = newDoc.querySelector('#floatingCsContainer');
                if (currentCsContainer && newCsContainer) {
                    currentCsContainer.innerHTML = newCsContainer.innerHTML;
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
            if (hasOpenModal) {
                document.body.classList.add('overflow-hidden');
            } else if (!document.body.classList.contains('drawer-open')) {
                document.body.classList.remove('overflow-hidden');
                if (document.body.style.position !== 'fixed') {
                    document.body.style.overflow = '';
                    document.body.style.position = '';
                }
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
