<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($buku['judul']) ?> — Cetak LPJ</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ═══════════════════════════════════════════
           PRINT & PAGE SETUP
           ═══════════════════════════════════════════ */
        @page {
            size: A4;
            margin: 18mm 15mm 18mm 15mm;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.55;
            background: #f1f5f9;
        }

        .page {
            background: #fff;
            max-width: 210mm;
            margin: 0 auto;
            padding: 18mm 15mm 20mm 15mm;
            position: relative;
            min-height: 297mm;
            display: flex;
            flex-direction: column;
        }
        .page-content {
            flex: 1 0 auto;
        }
        .page-break { page-break-after: always; }
        .page-break:last-child { page-break-after: avoid; }

        /* ═══════════════════════════════════════════
           PAGE NUMBER & RUNNING FOOTER
           ═══════════════════════════════════════════ */
        .page-footer-doc {
            margin-top: auto;
            padding-top: 10px;
            font-size: 8.5pt;
            color: #334155;
            display: flex;
            align-items: center;
            font-style: italic;
            border-top: 1px solid #e2e8f0;
            width: 100%;
        }
        .page-footer-doc .page-num {
            font-style: normal;
            font-weight: 700;
            margin-right: 6px;
            color: #1e293b;
        }

        /* ═══════════════════════════════════════════
           CONTROL BAR (WEB PREVIEW ONLY)
           ═══════════════════════════════════════════ */
        .control-bar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            color: #fff;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 4px 20px rgba(6, 78, 59, 0.35);
        }
        .control-bar .bar-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .control-bar .bar-title .bar-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .control-bar .bar-title h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 14px;
            margin: 0;
        }
        .control-bar .bar-title p {
            font-size: 11px;
            opacity: 0.7;
            margin: 0;
        }
        .control-bar .bar-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .btn-back {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 9px 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: rgba(255,255,255,0.2);
        }
        .btn-print {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            color: #fff;
            padding: 9px 20px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            transition: all 0.2s;
        }
        .btn-print:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5);
        }

        /* ═══════════════════════════════════════════
           COVER PAGE
           ═══════════════════════════════════════════ */
        .cover {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 240mm;
            text-align: center;
            padding: 12mm 15mm 8mm 15mm;
            box-sizing: border-box;
        }
        .cover-ornament {
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #166534, #15803d, #166534, transparent);
            margin: 14px auto;
        }
        .cover-ornament-thin {
            width: 50%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #16a34a, transparent);
            margin: 6px auto;
        }
        .cover-header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 12px;
        }
        .cover-logo-img {
            height: 60px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
        }
        .cover-logo {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.3);
        }
        .cover-org {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 14pt;
            color: #166534;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .cover-sub-org {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 9.5pt;
            color: #15803d;
            letter-spacing: 1.5px;
        }
        .cover-main-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 20pt;
            color: #1e293b;
            margin-top: 28px;
            line-height: 1.3;
        }
        .cover-subtitle {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 15pt;
            color: #334155;
            margin-top: 4px;
        }
        .cover-period {
            margin-top: 24px;
            padding: 10px 36px;
            border: 2px solid #166534;
            border-radius: 14px;
            display: inline-block;
        }
        .cover-period-text {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 15pt;
            color: #166534;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .cover-footer {
            margin-top: auto;
            padding-top: 15px;
            font-size: 8.5pt;
            color: #64748b;
        }

        /* ═══════════════════════════════════════════
           SECTION HEADERS
           ═══════════════════════════════════════════ */
        .section-banner {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 13pt;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-banner i {
            font-size: 14px;
            opacity: 0.8;
        }
        .sub-banner {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-left: 4px solid #16a34a;
            color: #166534;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 11pt;
            margin-top: 20px;
            margin-bottom: 12px;
        }

        /* ═══════════════════════════════════════════
           TABLES
           ═══════════════════════════════════════════ */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 9.5pt;
        }
        table, th, td {
            border: 1px solid #cbd5e1;
        }
        th {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            font-weight: 700;
            text-align: center;
            padding: 8px 10px;
            font-size: 9pt;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        td {
            padding: 7px 10px;
            vertical-align: top;
            color: #334155;
        }
        tr:nth-child(even) td {
            background: #f8fafc;
        }
        .td-center { text-align: center; }
        .td-right { text-align: right; }
        .td-bold { font-weight: 700; color: #1e293b; }

        /* ═══════════════════════════════════════════
           KALENDER AGENDA (PREMIUM PRINT TABLE)
           ═══════════════════════════════════════════ */
        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 0;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            border: 1.5px solid #cbd5e1;
        }
        .calendar-table th, 
        .calendar-table td {
            border: 1px solid #e2e8f0;
            padding: 0;
        }
        .calendar-table th {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            text-align: center;
            padding: 8px 4px;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            width: 14.285%;
        }
        .calendar-table th.minggu { background: linear-gradient(135deg, #991b1b, #b91c1c); color: #fff; }
        .calendar-table th.sabtu { background: linear-gradient(135deg, #047857, #059669); color: #fff; }
        
        .cal-cell {
            height: 96px;
            max-height: 110px;
            padding: 5px 6px;
            vertical-align: top;
            background: #fff;
            position: relative;
            overflow: hidden;
        }
        .cal-cell.empty {
            background: #f8fafc;
            border-color: #e2e8f0;
        }
        .cal-cell-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .cal-date-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 9pt;
            width: 20px;
            height: 20px;
            border-radius: 6px;
            color: #334155;
            background: #f1f5f9;
        }
        .cal-cell.is-sunday .cal-date-badge {
            background: #fee2e2;
            color: #b91c1c;
        }
        .cal-cell.is-saturday .cal-date-badge {
            background: #dcfce7;
            color: #15803d;
        }
        .cal-cell.has-event {
            background: #fafcfb;
        }
        .cal-event-list {
            display: flex;
            flex-direction: column;
            gap: 2.5px;
        }
        .cal-event {
            font-size: 6.8pt;
            padding: 2.5px 5px;
            border-radius: 4px;
            font-weight: 700;
            line-height: 1.25;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
            border-left-width: 3px;
            border-left-style: solid;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        /* Specific Category Styling */
        .cal-event.pj       { background: #ecfeff; color: #0891b2; border-left-color: #06b6d4; }
        .cal-event.sowan    { background: #f0fdf4; color: #15803d; border-left-color: #10b981; }
        .cal-event.kader    { background: #fff1f2; color: #be123c; border-left-color: #f43f5e; }
        .cal-event.evaluasi { background: #faf5ff; color: #7e22ce; border-left-color: #a855f7; }
        .cal-event.rapat    { background: #fefce8; color: #a16207; border-left-color: #eab308; }
        .cal-event.sidak    { background: #fff7ed; color: #c2410c; border-left-color: #f97316; }
        .cal-event.pengurus { background: #eff6ff; color: #1d4ed8; border-left-color: #3b82f6; }
        .cal-event.default  { background: #f1f5f9; color: #334155; border-left-color: #64748b; }

        /* Koordinasi Card Table */
        .koordinasi-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .koordinasi-card-header {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            padding: 10px 16px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 10.5pt;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .koordinasi-card-header .badge {
            background: rgba(255,255,255,0.2);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: 600;
        }
        .koordinasi-card table {
            margin: 0;
        }
        .koordinasi-card table, .koordinasi-card th, .koordinasi-card td {
            border-color: #e2e8f0;
        }
        .koordinasi-card th {
            background: #f0fdf4;
            color: #166534;
            text-transform: none;
            font-size: 8.5pt;
            padding: 6px 10px;
        }
        .koordinasi-card td {
            font-size: 9.5pt;
        }
        .koordinasi-side-layout {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 4px 2px;
        }
        .koordinasi-side-foto {
            flex-shrink: 0;
            width: 192px; /* 16:9 with height 108px */
            max-width: 32%;
        }
        .koordinasi-side-foto img {
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
            display: block;
        }
        .koordinasi-side-materi {
            flex-grow: 1;
            white-space: pre-line;
            line-height: 1.6;
            color: #334155;
            font-size: 9.5pt;
        }
        .foto-container {
            text-align: center;
            padding: 10px;
        }
        .foto-container img {
            aspect-ratio: 16 / 9;
            max-width: 220px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        /* Unit Evaluasi */
        .unit-section {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .unit-header {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            padding: 10px 16px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 11pt;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .unit-header .unit-type-badge {
            background: rgba(255,255,255,0.2);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: 600;
        }
        .unit-body {
            padding: 14px 16px;
        }
        .eval-label {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 9.5pt;
            color: #166534;
            padding: 6px 12px;
            background: #f0fdf4;
            border-left: 3px solid #16a34a;
            border-radius: 0 6px 6px 0;
            margin-bottom: 8px;
            margin-top: 12px;
        }
        .eval-label:first-child {
            margin-top: 0;
        }
        .eval-list {
            padding-left: 20px;
            margin-bottom: 6px;
        }
        .eval-list li {
            margin-bottom: 3px;
            color: #475569;
            line-height: 1.5;
        }
        .eval-table {
            margin-top: 4px;
        }
        .eval-table th {
            background: #f0fdf4;
            color: #166534;
            text-transform: none;
            font-size: 8.5pt;
            padding: 6px 10px;
        }

        /* ═══════════════════════════════════════════
           PENGESAHAN / SIGNATURE PAGE
           ═══════════════════════════════════════════ */
        .signature-page {
            padding-top: 30mm;
        }
        .signature-date {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 40px;
            color: #334155;
        }
        .signature-main {
            text-align: center;
            margin-bottom: 80px;
        }
        .signature-main .sig-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 11pt;
            color: #1e293b;
        }
        .signature-main .sig-space {
            height: 70px;
        }
        .signature-main .sig-name {
            font-weight: 800;
            text-decoration: underline;
            font-size: 11pt;
            color: #1e293b;
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-box .sig-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 10pt;
            color: #1e293b;
        }
        .signature-box .sig-space {
            height: 70px;
        }
        .signature-box .sig-name {
            font-weight: 800;
            text-decoration: underline;
            font-size: 10pt;
            color: #1e293b;
        }

        /* ═══════════════════════════════════════════
           PRINT OVERRIDES
           ═══════════════════════════════════════════ */
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; margin: 0 !important; padding: 0 !important; }
            .page {
                max-width: none !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
                height: auto !important;
                box-shadow: none !important;
                page-break-after: always !important;
                break-after: page !important;
            }
            .page:last-child {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }
            .cover-page {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                max-height: 258mm !important;
                overflow: hidden !important;
            }
            .cover {
                min-height: auto !important;
                height: 100% !important;
                max-height: 258mm !important;
                padding: 6mm 10mm 0 10mm !important;
                overflow: hidden !important;
            }
            .cover-main-title {
                margin-top: 18px !important;
            }
            .cover-period {
                margin-top: 18px !important;
            }
            .cover-ornament {
                margin: 10px auto !important;
            }
            .section-banner,
            th,
            .koordinasi-card-header,
            .unit-header,
            .eval-label,
            .sub-banner,
            .cover-logo,
            .cover-period,
            .calendar-table,
            .calendar-table th,
            .calendar-table td,
            .cal-cell,
            .cal-event {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .calendar-table {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            .cal-cell {
                height: 88px !important;
                max-height: 98px !important;
                padding: 3px 4px !important;
            }
            tr:nth-child(even) td {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Web preview shadow */
        @media screen {
            .page {
                box-shadow: 0 2px 30px rgba(0,0,0,0.1);
                margin-top: 20px;
                margin-bottom: 20px;
                border-radius: 4px;
            }
        }
    </style>
</head>
<body>

    <!-- ══════════════════════════════════════════════
         CONTROL BAR (Web Preview Only)
         ══════════════════════════════════════════════ -->
    <div class="control-bar no-print">
        <div class="bar-title">
            <div class="bar-icon"><i class="fa-solid fa-print"></i></div>
            <div>
                <h3><?= esc($buku['judul']) ?></h3>
                <p>LPJ Kebersihan — <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?></p>
            </div>
        </div>
        <div class="bar-actions">
            <a href="<?= base_url('buku/detail/' . $buku['id']) ?>" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn-print">
                <i class="fa-solid fa-print"></i> Cetak / Download PDF
            </button>
        </div>
    </div>

    <?php
    // ═══════════════════════════════════════════
    // HELPER: Indonesian month translation map
    // ═══════════════════════════════════════════
    $bulanMap = [
        'Januari'   => 1, 'Februari'  => 2, 'Maret'     => 3,
        'April'     => 4, 'Mei'       => 5, 'Juni'      => 6,
        'Juli'      => 7, 'Agustus'   => 8, 'September' => 9,
        'Oktober'   => 10,'November'  => 11,'Desember'  => 12,
    ];
    $monthNum = $bulanMap[$buku['bulan']] ?? 1;
    $yearNum  = (int)$buku['tahun'];
    ?>

    <?php
    // Page counter variable (starts from 1 after cover)
    $pageNumber = 1;
    ?>

    <!-- ══════════════════════════════════════════════
         1. SAMPUL (COVER PAGE)
         ══════════════════════════════════════════════ -->
    <div class="page cover-page page-break">
        <div class="cover">
            <!-- Organization Header with Dual Logos -->
            <div class="cover-header">
                <img src="<?= base_url('assets/images/logo_yayasan.png') ?>" alt="Logo Yayasan Assalafiyyah" class="cover-logo-img" style="height: 68px;">
                <img src="<?= base_url('assets/images/logo_gemerlap.png') ?>" alt="Logo Gemerlap" class="cover-logo-img" style="height: 60px;">
            </div>
            <div class="cover-org">KEBERSIHAN YAYASAN ASSALAFIYYAH</div>
            <div class="cover-sub-org">Buku Manajemen Kebersihan Yayasan Assalafiyyah</div>

            <div class="cover-ornament"></div>

            <!-- Main Title -->
            <div class="cover-main-title">LEMBAR<br>LAPORAN PERTANGGUNGJAWABAN</div>
            <div class="cover-subtitle">( LPJ )</div>

            <div class="cover-ornament-thin"></div>

            <div style="margin-top: 30px; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 13pt; color: #334155;">
                KEBERSIHAN YAYASAN ASSALAFIYYAH MLANGI
            </div>

            <!-- Period Badge -->
            <div class="cover-period">
                <div class="cover-period-text"><?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?></div>
            </div>

            <div class="cover-ornament" style="margin-top: 50px;"></div>

            <!-- Footer -->
            <div class="cover-footer">
                Dokumen Resmi — Dicetak dari Sistem LPJ Kebersihan Digital
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         2. KALENDER AGENDA
         ══════════════════════════════════════════════ -->
    <div class="page page-break">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-calendar-check"></i>
                Kalender Kegiatan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

        <?php
        $firstDayTimestamp = strtotime(sprintf('%04d-%02d-01', $yearNum, $monthNum));
        $daysInMonth       = (int)date('t', $firstDayTimestamp);
        $startDayOfWeek    = (int)date('w', $firstDayTimestamp); // 0=Minggu..6=Sabtu

        // Build agenda map by day
        $agendaByDay = [];
        foreach ($proker as $p) {
            $pDay = (int)date('j', strtotime($p['tanggal']));
            $agendaByDay[$pDay][] = $p;
        }

        $dayNames = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
        ?>

        <!-- Legend Badges -->
        <div style="display: flex; flex-wrap: wrap; gap: 10px 16px; margin-bottom: 12px; font-size: 7.5pt; font-weight: 700; background: #f8fafc; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 5px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 3px; background: #06b6d4;"></span>
                <span>Koordinasi PJ</span>
            </div>
            <div style="display: flex; align-items: center; gap: 5px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 3px; background: #10b981;"></span>
                <span>Koordinasi Sowan</span>
            </div>
            <div style="display: flex; align-items: center; gap: 5px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 3px; background: #f43f5e;"></span>
                <span>Koordinasi Kader</span>
            </div>
            <div style="display: flex; align-items: center; gap: 5px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 3px; background: #3b82f6;"></span>
                <span>Koordinasi Pengurus / Lainnya</span>
            </div>
        </div>

        <table class="calendar-table">
            <thead>
                <tr>
                    <?php foreach ($dayNames as $di => $dn): ?>
                        <th class="<?= $di === 0 ? 'minggu' : ($di === 6 ? 'sabtu' : '') ?>"><?= $dn ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentDay = 1;
                $started = false;
                $finished = false;

                while ($currentDay <= $daysInMonth || !$finished):
                ?>
                    <tr>
                        <?php for ($col = 0; $col < 7; $col++): ?>
                            <?php 
                            if (!$started && $col === $startDayOfWeek) {
                                $started = true;
                            }

                            if ($started && $currentDay <= $daysInMonth) {
                                $d = $currentDay;
                                $dayAgendas = $agendaByDay[$d] ?? [];
                                $hasEvents = !empty($dayAgendas);
                                $isSunday = ($col === 0);
                                $isSaturday = ($col === 6);
                                $cellExtraClass = ($isSunday ? ' is-sunday' : '') . ($isSaturday ? ' is-saturday' : '') . ($hasEvents ? ' has-event' : '');
                            ?>
                                <td class="cal-cell<?= $cellExtraClass ?>">
                                    <div class="cal-cell-header">
                                        <span class="cal-date-badge"><?= $d ?></span>
                                    </div>
                                    <div class="cal-event-list">
                                        <?php foreach ($dayAgendas as $ag):
                                            $badgeText = !empty($ag['kategori_badge']) ? $ag['kategori_badge'] : $ag['kegiatan'];
                                            $eventClass = 'default';
                                            
                                            if (stripos($badgeText, 'PJ') !== false) {
                                                $eventClass = 'pj';
                                            } elseif (stripos($badgeText, 'Sowan') !== false) {
                                                $eventClass = 'sowan';
                                            } elseif (stripos($badgeText, 'Kader') !== false) {
                                                $eventClass = 'kader';
                                            } elseif (stripos($badgeText, 'Evaluasi') !== false || stripos($badgeText, 'Monev') !== false) {
                                                $eventClass = 'evaluasi';
                                            } elseif (stripos($badgeText, 'Rapat') !== false) {
                                                $eventClass = 'rapat';
                                            } elseif (stripos($badgeText, 'Sidak') !== false || stripos($badgeText, 'Cek') !== false || stripos($badgeText, 'Tinjau') !== false) {
                                                $eventClass = 'sidak';
                                            } elseif (stripos($badgeText, 'Pengurus') !== false || stripos($badgeText, 'TPS') !== false || stripos($badgeText, 'Lainnya') !== false) {
                                                $eventClass = 'pengurus';
                                            }
                                        ?>
                                            <span class="cal-event <?= $eventClass ?>" title="<?= esc($ag['kegiatan']) ?> (<?= esc($badgeText) ?>)">
                                                <?= esc(mb_strimwidth($ag['kegiatan'], 0, 26, '…')) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            <?php
                                $currentDay++;
                            } else {
                            ?>
                                <td class="cal-cell empty"></td>
                            <?php
                            }
                            ?>
                        <?php endfor; ?>
                    </tr>
                <?php
                    if ($currentDay > $daysInMonth) {
                        $finished = true;
                    }
                endwhile;
                ?>
            </tbody>
        </table>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         3. TABEL AGENDA (PROGRAM KERJA)
         ══════════════════════════════════════════════ -->
    <div class="page page-break">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-calendar-days"></i>
                Rancangan Program Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="7%">No</th>
                        <th width="20%">Tanggal</th>
                        <th width="15%">Kategori</th>
                        <th width="30%">Kegiatan</th>
                        <th width="28%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($proker)): ?>
                        <?php foreach ($proker as $idx => $p): ?>
                            <tr>
                                <td class="td-center"><?= $idx + 1 ?></td>
                                <td><?= date('d F Y', strtotime($p['tanggal'])) ?></td>
                                <td class="td-center">
                                    <span style="font-weight: 700; font-size: 8.5pt;">
                                        <?= esc($p['kategori_badge'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="td-bold"><?= esc($p['kegiatan']) ?></td>
                                <td><?= esc($p['keterangan'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="td-center" style="color: #94a3b8; font-style: italic; padding: 20px;">Belum ada data proker.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         4. TABEL HASIL KOORDINASI
         ══════════════════════════════════════════════ -->
    <div class="page page-break">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-handshake"></i>
                Hasil Koordinasi Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

            <?php if (!empty($koordinasi)): ?>
                <?php foreach ($koordinasi as $idx => $k): ?>
                    <div class="koordinasi-card">
                        <div class="koordinasi-card-header">
                            <span><?= $idx + 1 ?>.</span>
                            <?php if (!empty($k['jenis'])): ?>
                                <span class="badge"><?= esc($k['jenis']) ?></span>
                            <?php endif; ?>
                            <span><?= esc($k['kegiatan']) ?></span>
                        </div>
                        <table>
                            <tr>
                                <th width="15%">Kegiatan</th>
                                <td width="35%"><?= esc($k['kegiatan']) ?></td>
                                <th width="15%">Bersama</th>
                                <td width="35%"><?= esc($k['bersama'] ?? '-') ?></td>
                            </tr>
                            <?php
                                // Format Hari / Tanggal with Indonesian Day Name
                                $rawDate = $k['hari_tanggal'] ?? '';
                                $displayHariTanggal = $rawDate;
                                if (!empty($rawDate)) {
                                    $time = strtotime($rawDate);
                                    if ($time !== false) {
                                        $daftarHari = [
                                            'Sunday'    => 'Minggu',
                                            'Monday'    => 'Senin',
                                            'Tuesday'   => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday'  => 'Kamis',
                                            'Friday'    => 'Jumat',
                                            'Saturday'  => 'Sabtu'
                                        ];
                                        $dayEng = date('l', $time);
                                        $dayIndo = $daftarHari[$dayEng] ?? $dayEng;
                                        
                                        // Check if string already contains day name
                                        $hasDay = false;
                                        foreach ($daftarHari as $dh) {
                                            if (stripos($rawDate, $dh) !== false) {
                                                $hasDay = true;
                                                break;
                                            }
                                        }
                                        if (!$hasDay) {
                                            $displayHariTanggal = $dayIndo . ', ' . date('d M Y', $time);
                                        }
                                    }
                                }
                            ?>
                            <tr>
                                <th width="15%">Hari / Tanggal</th>
                                <td width="35%"><?= esc($displayHariTanggal ?: '-') ?></td>
                                <th width="15%">Tempat</th>
                                <td width="35%"><?= esc($k['tempat'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align: left;">Hasil / Materi Koordinasi</th>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding: 10px 14px;">
                                    <?php if (!empty($k['foto'])): ?>
                                        <div class="koordinasi-side-layout">
                                            <div class="koordinasi-side-foto">
                                                <img src="<?= image_url($k['foto'], 'uploads') ?>" alt="Foto Dokumentasi">
                                            </div>
                                            <div class="koordinasi-side-materi">
                                                <?= esc($k['hasil_materi'] ?? '-') ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div style="white-space: pre-line; line-height: 1.6;">
                                            <?= esc($k['hasil_materi'] ?? '-') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 30px 0;">Belum ada data hasil koordinasi.</p>
            <?php endif; ?>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         5. TARGET — CAPAIAN — EVALUASI PUSAT
         ══════════════════════════════════════════════ -->
    <div class="page page-break">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-bullseye"></i>
                Target, Capaian & Evaluasi Pusat — <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

            <!-- Target Utama -->
            <div class="sub-banner">
                <i class="fa-solid fa-bullseye" style="margin-right: 6px;"></i>
                Target Utama Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

            <?php if (!empty($targets)): ?>
                <ol class="eval-list">
                    <?php foreach ($targets as $tg): ?>
                        <li style="font-weight: 600; color: #1e293b;"><?= esc($tg['target_text']) ?></li>
                    <?php endforeach; ?>
                </ol>
            <?php else: ?>
                <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 15px 0;">Belum ada target yang diinputkan.</p>
            <?php endif; ?>

            <!-- Capaian Utama -->
            <div class="sub-banner" style="margin-top: 25px;">
                <i class="fa-solid fa-trophy" style="margin-right: 6px;"></i>
                Capaian Utama Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

            <?php if (!empty($capaianList)): ?>
                <ol class="eval-list">
                    <?php foreach ($capaianList as $cp): ?>
                        <li style="font-weight: 600; color: #1e293b;"><?= esc($cp['capaian_text']) ?></li>
                    <?php endforeach; ?>
                </ol>
            <?php else: ?>
                <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 15px 0;">Belum ada capaian yang diinputkan.</p>
            <?php endif; ?>

            <!-- Evaluasi Utama -->
            <div class="sub-banner" style="margin-top: 25px;">
                <i class="fa-solid fa-clipboard-check" style="margin-right: 6px;"></i>
                Evaluasi Utama Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>

            <?php if (!empty($evaluasiBulananList)): ?>
                <ol class="eval-list">
                    <?php foreach ($evaluasiBulananList as $evB): ?>
                        <li style="font-weight: 600; color: #1e293b;"><?= esc($evB['evaluasi_text']) ?></li>
                    <?php endforeach; ?>
                </ol>
            <?php else: ?>
                <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 15px 0;">Belum ada evaluasi yang diinputkan.</p>
            <?php endif; ?>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         6. TARGET — CAPAIAN — EVALUASI UNIT
         ══════════════════════════════════════════════ -->
    <div class="page page-break">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-building-user"></i>
                Lembar Pertanggungjawaban Asrama & Sekolah
            </div>

            <?php
            $hasAnyUnit = false;
            if (!empty($units)):
                foreach ($units as $unit):
                    $hasAnyUnit = true;
                    $ev = $evaluasiMap[$unit['id']] ?? null;

                    // Parse JSON data
                    $capaianRows = [];
                    $rawCap = $ev['capaian_text'] ?? '';
                    $decCap = json_decode($rawCap, true);
                    if (is_array($decCap)) {
                        $capaianRows = $decCap;
                    } elseif (trim($rawCap)) {
                        foreach (explode("\n", $rawCap) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $capaianRows[] = $cl;
                        }
                    }

                    $masalahRows = [];
                    $rawMas = $ev['permasalahan_text'] ?? '';
                    $decMas = json_decode($rawMas, true);
                    if (is_array($decMas)) {
                        $masalahRows = $decMas;
                    } elseif (trim($rawMas)) {
                        foreach (explode("\n", $rawMas) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $masalahRows[] = ['masalah' => $cl, 'tindakan' => ''];
                        }
                    }

                    $targetRows = [];
                    $rawTgt = $ev['target_text'] ?? '';
                    $decTgt = json_decode($rawTgt, true);
                    if (is_array($decTgt)) {
                        $targetRows = $decTgt;
                    } elseif (trim($rawTgt)) {
                        foreach (explode("\n", $rawTgt) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $targetRows[] = ['target' => $cl, 'tindakan' => ''];
                        }
                    }

                    $usulanRows = [];
                    $rawUsl = $ev['usulan_text'] ?? '';
                    $decUsl = json_decode($rawUsl, true);
                    if (is_array($decUsl)) {
                        $usulanRows = $decUsl;
                    } elseif (trim($rawUsl)) {
                        foreach (explode("\n", $rawUsl) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $usulanRows[] = $cl;
                        }
                    }

                    $hasContent = !empty($capaianRows) || !empty($masalahRows) || !empty($targetRows) || !empty($usulanRows);
            ?>
                <div class="unit-section">
                    <div class="unit-header">
                        <span class="unit-type-badge"><?= esc($unit['tipe'] ?? $unit['kategori'] ?? 'Unit') ?></span>
                        <span><?= esc($unit['nama_unit']) ?></span>
                    </div>
                    <div class="unit-body">

                        <?php if ($hasContent): ?>
                            <!-- 1. Capaian -->
                            <?php if (!empty($capaianRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-chart-line" style="margin-right: 6px; font-size: 9pt;"></i> Capaian Realisasi Bulan Ini</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="95%" style="background: #f0fdf4; color: #166534; text-align: left; padding-left: 12px;">Poin Capaian Realisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($capaianRows as $ci => $c): ?>
                                            <tr>
                                                <td class="td-center"><?= $ci + 1 ?></td>
                                                <td style="padding-left: 12px;"><?= esc(is_string($c) ? $c : (is_array($c) ? ($c['capaian'] ?? '') : '')) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <!-- 2. Permasalahan & Tindakan -->
                            <?php if (!empty($masalahRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px; font-size: 9pt;"></i> Permasalahan & Tindakan</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="47%" style="background: #f0fdf4; color: #166534;">Permasalahan</th>
                                            <th width="48%" style="background: #f0fdf4; color: #166534;">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($masalahRows as $mi => $m): ?>
                                            <tr>
                                                <td class="td-center"><?= $mi + 1 ?></td>
                                                <td><?= esc(is_array($m) ? ($m['masalah'] ?? '') : $m) ?></td>
                                                <td><?= esc(is_array($m) ? ($m['tindakan'] ?? '') : '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <!-- 3. Target & Rencana Tindakan -->
                            <?php if (!empty($targetRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-bullseye" style="margin-right: 6px; font-size: 9pt;"></i> Target Bulan Depan & Rencana Tindakan</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="47%" style="background: #f0fdf4; color: #166534;">Target</th>
                                            <th width="48%" style="background: #f0fdf4; color: #166534;">Rencana Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($targetRows as $ti => $t): ?>
                                            <tr>
                                                <td class="td-center"><?= $ti + 1 ?></td>
                                                <td><?= esc(is_array($t) ? ($t['target'] ?? '') : $t) ?></td>
                                                <td><?= esc(is_array($t) ? ($t['tindakan'] ?? '') : '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <!-- 4. Usulan / Rekomendasi -->
                            <?php if (!empty($usulanRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-lightbulb" style="margin-right: 6px; font-size: 9pt;"></i> Usulan / Rekomendasi</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="95%" style="background: #f0fdf4; color: #166534; text-align: left; padding-left: 12px;">Poin Usulan / Rekomendasi Fasilitas & Kebersihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usulanRows as $ui => $u): ?>
                                            <tr>
                                                <td class="td-center"><?= $ui + 1 ?></td>
                                                <td style="padding-left: 12px;"><?= esc(is_string($u) ? $u : (is_array($u) ? ($u['usulan'] ?? '') : '')) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        <?php else: ?>
                            <p style="color: #94a3b8; font-style: italic; font-size: 9pt; padding: 6px 0;">Belum ada data evaluasi yang terisi untuk unit ini.</p>
                        <?php endif; ?>

                    </div>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>

            <?php if (!$hasAnyUnit): ?>
                <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 30px 0;">Belum ada data evaluasi unit yang terisi.</p>
            <?php endif; ?>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         7. TARGET — CAPAIAN — EVALUASI KADER
         ══════════════════════════════════════════════ -->
    <div class="page page-break">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-users-gear"></i>
                Lembar Laporan Kader GEMERLAP & Satgas Kebersihan
            </div>

            <?php
            $hasAnyKader = false;
            if (!empty($kaderUnits)):
                foreach ($kaderUnits as $kUnit):
                    $hasAnyKader = true;
                    $ev = $evaluasiMap[$kUnit['id']] ?? null;

                    // Parse JSON data
                    $capaianRows = [];
                    $rawCap = $ev['capaian_text'] ?? '';
                    $decCap = json_decode($rawCap, true);
                    if (is_array($decCap)) {
                        $capaianRows = $decCap;
                    } elseif (trim($rawCap)) {
                        foreach (explode("\n", $rawCap) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $capaianRows[] = $cl;
                        }
                    }

                    $masalahRows = [];
                    $rawMas = $ev['permasalahan_text'] ?? '';
                    $decMas = json_decode($rawMas, true);
                    if (is_array($decMas)) {
                        $masalahRows = $decMas;
                    } elseif (trim($rawMas)) {
                        foreach (explode("\n", $rawMas) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $masalahRows[] = ['masalah' => $cl, 'tindakan' => ''];
                        }
                    }

                    $targetRows = [];
                    $rawTgt = $ev['target_text'] ?? '';
                    $decTgt = json_decode($rawTgt, true);
                    if (is_array($decTgt)) {
                        $targetRows = $decTgt;
                    } elseif (trim($rawTgt)) {
                        foreach (explode("\n", $rawTgt) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $targetRows[] = ['target' => $cl, 'tindakan' => ''];
                        }
                    }

                    $usulanRows = [];
                    $rawUsl = $ev['usulan_text'] ?? '';
                    $decUsl = json_decode($rawUsl, true);
                    if (is_array($decUsl)) {
                        $usulanRows = $decUsl;
                    } elseif (trim($rawUsl)) {
                        foreach (explode("\n", $rawUsl) as $l) {
                            $cl = trim(preg_replace('/^\d+\.\s*/', '', $l));
                            if ($cl !== '') $usulanRows[] = $cl;
                        }
                    }

                    $hasContent = !empty($capaianRows) || !empty($masalahRows) || !empty($targetRows) || !empty($usulanRows);
            ?>
                <div class="unit-section">
                    <div class="unit-header">
                        <span class="unit-type-badge"><?= esc($kUnit['tipe'] ?? 'Kader') ?></span>
                        <span><?= esc($kUnit['nama_unit']) ?></span>
                    </div>
                    <div class="unit-body">

                        <?php if ($hasContent): ?>
                            <!-- 1. Capaian -->
                            <?php if (!empty($capaianRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-chart-line" style="margin-right: 6px; font-size: 9pt;"></i> Capaian Realisasi Bulan Ini</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="95%" style="background: #f0fdf4; color: #166534; text-align: left; padding-left: 12px;">Poin Capaian Realisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($capaianRows as $ci => $c): ?>
                                            <tr>
                                                <td class="td-center"><?= $ci + 1 ?></td>
                                                <td style="padding-left: 12px;"><?= esc(is_string($c) ? $c : (is_array($c) ? ($c['capaian'] ?? '') : '')) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <!-- 2. Permasalahan & Tindakan -->
                            <?php if (!empty($masalahRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px; font-size: 9pt;"></i> Permasalahan & Tindakan</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="47%" style="background: #f0fdf4; color: #166534;">Permasalahan</th>
                                            <th width="48%" style="background: #f0fdf4; color: #166534;">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($masalahRows as $mi => $m): ?>
                                            <tr>
                                                <td class="td-center"><?= $mi + 1 ?></td>
                                                <td><?= esc(is_array($m) ? ($m['masalah'] ?? '') : $m) ?></td>
                                                <td><?= esc(is_array($m) ? ($m['tindakan'] ?? '') : '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <!-- 3. Target & Rencana Tindakan -->
                            <?php if (!empty($targetRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-bullseye" style="margin-right: 6px; font-size: 9pt;"></i> Target Bulan Depan & Rencana Tindakan</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="47%" style="background: #f0fdf4; color: #166534;">Target</th>
                                            <th width="48%" style="background: #f0fdf4; color: #166534;">Rencana Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($targetRows as $ti => $t): ?>
                                            <tr>
                                                <td class="td-center"><?= $ti + 1 ?></td>
                                                <td><?= esc(is_array($t) ? ($t['target'] ?? '') : $t) ?></td>
                                                <td><?= esc(is_array($t) ? ($t['tindakan'] ?? '') : '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <!-- 4. Usulan / Rekomendasi -->
                            <?php if (!empty($usulanRows)): ?>
                                <div class="eval-label"><i class="fa-solid fa-lightbulb" style="margin-right: 6px; font-size: 9pt;"></i> Usulan / Rekomendasi</div>
                                <table class="eval-table">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="background: #f0fdf4; color: #166534;">No</th>
                                            <th width="95%" style="background: #f0fdf4; color: #166534; text-align: left; padding-left: 12px;">Poin Usulan / Rekomendasi Fasilitas & Kebersihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usulanRows as $ui => $u): ?>
                                            <tr>
                                                <td class="td-center"><?= $ui + 1 ?></td>
                                                <td style="padding-left: 12px;"><?= esc(is_string($u) ? $u : (is_array($u) ? ($u['usulan'] ?? '') : '')) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        <?php else: ?>
                            <p style="color: #94a3b8; font-style: italic; font-size: 9pt; padding: 6px 0;">Belum ada data evaluasi yang terisi untuk unit kader ini.</p>
                        <?php endif; ?>

                    </div>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>

            <?php if (!$hasAnyKader): ?>
                <p style="text-align: center; color: #94a3b8; font-style: italic; padding: 30px 0;">Belum ada data unit kader yang terdaftar.</p>
            <?php endif; ?>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         8. LAPORAN KEUANGAN
         ══════════════════════════════════════════════ -->
    <?php if (!empty($importedKeuangan)): ?>
        <?php
        $totalPlafon   = 0;
        $totalTerserap = 0;
        foreach ($keuanganPembelian as $kp) {
            $totalPlafon   += (float)$kp['plafon'];
            $totalTerserap += (float)$kp['terserap'];
        }
        $totalSaldoAkhir = $totalPlafon - $totalTerserap;

        $totalDanaMasuk = 0;
        foreach ($keuanganMasuk as $km) {
            $totalDanaMasuk += (float)$km['nominal'];
        }

        $saldoSisaBulan = $totalDanaMasuk - $totalTerserap;
        ?>
        <div class="page page-break">
            <div class="page-content">
                <div class="section-banner">
                    <i class="fa-solid fa-calculator"></i>
                    Laporan Keuangan Kebersihan
                </div>

                <!-- Top Header Info Box (Matching Excel Layout) -->
                <table class="eval-table" style="margin-bottom: 14px; font-weight: bold;">
                    <tr>
                        <td width="15%" style="background: #f8fafc; text-align: center; font-size: 8.5pt; color: #475569;">KODE:</td>
                        <td width="20%" style="background: #ffffff; font-size: 9pt; text-align: center; font-family: monospace; color: #166534; font-weight: 800;"><?= esc($importedKeuangan['kode_keuangan'] ?: 'KUG-' . $importedKeuangan['tahun']) ?></td>
                        <td width="15%" style="background: #f8fafc; text-align: center; font-size: 8.5pt; color: #475569;">PERIODE:</td>
                        <td width="20%" style="background: #ffffff; font-size: 9pt; text-align: center; color: #0f172a; font-weight: 800;"><?= esc($importedKeuangan['bulan'] . ' ' . $importedKeuangan['tahun']) ?></td>
                        <td width="15%" style="background: #f8fafc; text-align: center; font-size: 8pt; color: #475569;">JUMLAH ANGGARAN:</td>
                        <td width="15%" style="background: #dbeafe; text-align: center; font-size: 10pt; color: #1e40af; font-weight: 800;">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></td>
                    </tr>
                </table>

                <!-- Table 1: Item Pembelian -->
                <div style="text-align: center; background: #166534; color: #ffffff; padding: 6px; margin-bottom: 8px; border-radius: 4px; font-weight: 800; font-size: 9.5pt; letter-spacing: 0.5px;">
                    LAPORAN KEUANGAN KEBERSIHAN (ITEM PEMBELIAN)
                </div>

                <table class="eval-table" style="margin-bottom: 14px;">
                    <thead>
                        <tr>
                            <th width="5%" class="td-center" style="background: #f1f5f9; color: #1e293b;">NO</th>
                            <th width="47%" style="background: #f1f5f9; color: #1e293b;">ITEM PEMBELIAN</th>
                            <th width="16%" class="td-right" style="background: #f1f5f9; color: #1e293b;">PLAFON</th>
                            <th width="16%" class="td-right" style="background: #f1f5f9; color: #1e293b;">TERSERAP</th>
                            <th width="16%" class="td-right" style="background: #f1f5f9; color: #1e293b;">SALDO AKHIR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($keuanganPembelian)): ?>
                            <?php foreach ($keuanganPembelian as $idx => $kp):
                                $sAkhir = (float)$kp['plafon'] - (float)$kp['terserap'];
                            ?>
                                <tr>
                                    <td class="td-center" style="font-weight: bold; color: #64748b;"><?= $idx + 1 ?></td>
                                    <td style="font-weight: 600; text-transform: uppercase;"><?= esc($kp['item_pembelian']) ?></td>
                                    <td class="td-right" style="font-weight: 600; color: #92400e;">Rp <?= number_format($kp['plafon'], 0, ',', '.') ?></td>
                                    <td class="td-right" style="font-weight: 600; color: #9f1239;">Rp <?= number_format($kp['terserap'], 0, ',', '.') ?></td>
                                    <td class="td-right" style="font-weight: 700; color: #166534;">Rp <?= number_format($sAkhir, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="td-center" style="color: #94a3b8; font-style: italic; padding: 15px;">Belum ada item pengeluaran terisi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 800;">
                            <td colspan="2" class="td-right" style="background: #f8fafc; font-size: 8.5pt; text-transform: uppercase; letter-spacing: 0.5px;">JUMLAH SALDO</td>
                            <td class="td-right" style="background: #fef08a; color: #713f12; border: 1px solid #eab308;">Rp <?= number_format($totalPlafon, 0, ',', '.') ?></td>
                            <td class="td-right" style="background: #fecdd3; color: #881337; border: 1px solid #f43f5e;">Rp <?= number_format($totalTerserap, 0, ',', '.') ?></td>
                            <td class="td-right" style="background: #bbf7d0; color: #14532d; border: 1px solid #22c55e;">Rp <?= number_format($totalSaldoAkhir, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Saldo Sisa Banner Row -->
                <table class="eval-table" style="margin-bottom: 16px; font-weight: 800;">
                    <tr>
                        <td width="35%" style="background: #dbeafe; text-align: center; font-size: 11pt; color: #1e40af; border: 1.5px solid #93c5fd;">
                            Rp <?= number_format($saldoSisaBulan, 0, ',', '.') ?>
                        </td>
                        <td width="65%" style="background: #ffffff; text-align: center; font-size: 9pt; letter-spacing: 0.5px; border: 1.5px solid #cbd5e1;">
                            SALDO SISA BULAN <?= strtoupper(esc($importedKeuangan['bulan'])) ?>
                        </td>
                    </tr>
                </table>

                <!-- Table 2: Informasi Dana Masuk -->
                <div style="text-align: center; background: #1e40af; color: #ffffff; padding: 6px; margin-bottom: 8px; border-radius: 4px; font-weight: 800; font-size: 9.5pt; letter-spacing: 0.5px;">
                    INFORMASI DANA MASUK
                </div>

                <table class="eval-table">
                    <thead>
                        <tr>
                            <th width="5%" class="td-center" style="background: #eff6ff; color: #1e40af;">NO</th>
                            <th width="35%" style="background: #eff6ff; color: #1e40af;">SUMBER DANA</th>
                            <th width="16%" class="td-right" style="background: #eff6ff; color: #1e40af;">NOMINAL</th>
                            <th width="44%" style="background: #eff6ff; color: #1e40af;">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($keuanganMasuk)): ?>
                            <?php foreach ($keuanganMasuk as $idx => $km): ?>
                                <tr>
                                    <td class="td-center" style="font-weight: bold; color: #64748b;"><?= $idx + 1 ?></td>
                                    <td style="font-weight: 600; text-transform: uppercase;"><?= esc($km['sumber_dana']) ?></td>
                                    <td class="td-right" style="font-weight: 700; color: #1e40af;">Rp <?= number_format($km['nominal'], 0, ',', '.') ?></td>
                                    <td style="color: #475569;"><?= esc($km['keterangan']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="td-center" style="color: #94a3b8; font-style: italic; padding: 15px;">Belum ada dana masuk terisi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 800;">
                            <td colspan="2" class="td-right" style="background: #f8fafc; font-size: 8.5pt; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL INFORMASI DANA MASUK</td>
                            <td class="td-right" style="background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd;">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></td>
                            <td style="background: #f8fafc;"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="page-footer-doc">
                <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════
         9. LEMBAR PENGESAHAN (TANDA TANGAN)
         ══════════════════════════════════════════════ -->
    <div class="page">
        <div class="page-content">
            <div class="section-banner">
                <i class="fa-solid fa-file-signature"></i>
                Lembar Pengesahan
            </div>

            <div class="signature-page">
                <div class="signature-date">
                    <?= esc($settings['kota_dokumen'] ?? 'Sleman') ?>, <?= date('d') ?> <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
                </div>

                <!-- 1. KETUA K3L (POSISI ATAS UTAMA) -->
                <div class="signature-main" style="position: relative; display: inline-block; width: 100%; text-align: center; margin-bottom: 50px;">
                    <div class="sig-title"><?= esc($settings['jabatan_ketua'] ?? 'Ketua K3L') ?></div>
                    <div class="sig-space" style="height: 75px; display: flex; items-center; justify-content: center; align-items: center; position: relative;">
                        <?php if (!empty($settings['ttd_ketua_img']) && has_valid_image($settings['ttd_ketua_img'])): ?>
                            <img src="<?= image_url($settings['ttd_ketua_img'], 'uploads/settings') ?>" alt="TTD Ketua" style="max-height: 70px; object-contain: contain;">
                        <?php endif; ?>

                        <?php if (!empty($settings['stempel_img']) && has_valid_image($settings['stempel_img'])): ?>
                            <img src="<?= image_url($settings['stempel_img'], 'uploads/settings') ?>" alt="Stempel" style="max-height: 80px; position: absolute; left: 52%; opacity: 0.85; pointer-events: none;">
                        <?php endif; ?>
                    </div>
                    <div class="sig-name"><?= esc($settings['nama_ketua_k3l'] ?? 'Bapak Afif Muzayyin') ?></div>
                </div>

                <!-- 2. KOORDINATOR KEBERSIHAN & 3. SEKRETARIS (BARIS BAWAH) -->
                <div class="signature-row">
                    <div class="signature-box">
                        <div class="sig-title"><?= esc($settings['jabatan_koordinator'] ?? 'Koordinator Kebersihan') ?></div>
                        <div class="sig-space" style="height: 70px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($settings['ttd_koordinator_img']) && has_valid_image($settings['ttd_koordinator_img'])): ?>
                                <img src="<?= image_url($settings['ttd_koordinator_img'], 'uploads/settings') ?>" alt="TTD Koordinator" style="max-height: 65px; object-contain: contain;">
                            <?php endif; ?>
                        </div>
                        <div class="sig-name"><?= esc($settings['nama_koordinator'] ?? 'Bapak Muhammad Ashar') ?></div>
                    </div>

                    <div class="signature-box">
                        <div class="sig-title"><?= esc($settings['jabatan_sekretaris'] ?? 'Sekretaris Kebersihan') ?></div>
                        <div class="sig-space" style="height: 70px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($settings['ttd_sekretaris_img']) && has_valid_image($settings['ttd_sekretaris_img'])): ?>
                                <img src="<?= image_url($settings['ttd_sekretaris_img'], 'uploads/settings') ?>" alt="TTD Sekretaris" style="max-height: 65px; object-contain: contain;">
                            <?php endif; ?>
                        </div>
                        <div class="sig-name"><?= esc($settings['nama_sekretaris'] ?? 'Ahmad Musyafa') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-footer-doc">
            <span class="page-num"><?= $pageNumber++ ?> |</span> Laporan Pertanggungjawaban Kebersihan Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
        </div>
    </div>

</body>
</html>
