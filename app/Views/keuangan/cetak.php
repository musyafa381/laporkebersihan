<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($buku['judul']) ?> — Cetak Laporan Keuangan</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ═══════════════════════════════════════════
           PRINT & PAGE SETUP
           ═══════════════════════════════════════════ */
        @page {
            size: A4;
            margin: 15mm 15mm 15mm 15mm;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            font-size: 9.5pt;
            color: #1e293b;
            line-height: 1.5;
            background: #f1f5f9;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
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

        .page-container {
            margin: 24px auto 40px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
        }

        .page {
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            padding: 16mm 15mm 16mm 15mm;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1 0 auto;
        }

        /* ═══════════════════════════════════════════
           HEADER KOP DOKUMEN (DUAL LOGO)
           ═══════════════════════════════════════════ */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2.5px solid #166534;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .kop-logo {
            height: 52px;
            width: auto;
            object-fit: contain;
        }
        .kop-text {
            flex: 1;
            text-align: center;
            padding: 0 14px;
        }
        .kop-text h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 13pt;
            font-weight: 800;
            color: #166534;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-text h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 11pt;
            font-weight: 700;
            color: #0f172a;
            margin-top: 1px;
        }
        .kop-text p {
            font-size: 8pt;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════════
           SECTION BANNER & TABLES
           ═══════════════════════════════════════════ */
        .section-banner {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 10.5pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .eval-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 12px;
        }
        .eval-table th, .eval-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            vertical-align: middle;
        }
        .eval-table th {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .td-center { text-align: center; }
        .td-right { text-align: right; }

        /* ═══════════════════════════════════════════
           SIGNATURE SECTION (TTD + STEMPEL)
           ═══════════════════════════════════════════ */
        .signature-page {
            margin-top: 24px;
            page-break-inside: avoid;
        }
        .signature-date {
            text-align: right;
            font-size: 8.5pt;
            font-weight: 600;
            color: #475569;
            margin-bottom: 16px;
        }
        .signature-main {
            text-align: center;
            margin-bottom: 30px;
        }
        .sig-title {
            font-size: 8.5pt;
            font-weight: 700;
            color: #334155;
            margin-bottom: 4px;
        }
        .sig-name {
            font-family: 'Outfit', sans-serif;
            font-size: 9.5pt;
            font-weight: 800;
            color: #0f172a;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-top: 4px;
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }
        .signature-box {
            flex: 1;
            text-align: center;
        }

        /* ═══════════════════════════════════════════
           FOOTER DOKUMEN
           ═══════════════════════════════════════════ */
        .page-footer-doc {
            margin-top: auto;
            padding-top: 8px;
            font-size: 8pt;
            color: #64748b;
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

        @media print {
            .control-bar { display: none !important; }
            body { background: #ffffff !important; }
            .page-container { margin: 0 !important; gap: 0 !important; }
            .page { width: 100% !important; min-height: auto !important; padding: 10mm 10mm 10mm 10mm !important; box-shadow: none !important; }
        }
    </style>
</head>
<body>

    <!-- STICKY CONTROL BAR -->
    <div class="control-bar">
        <div class="bar-title">
            <div class="bar-icon">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <div>
                <h3>Laporan Pertanggungjawaban (LPJ) Keuangan Kebersihan</h3>
                <p><?= esc($buku['judul']) ?> &bull; <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?></p>
            </div>
        </div>
        <div class="bar-actions">
            <a href="<?= base_url('keuangan/detail/' . $buku['id']) ?>" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn-print">
                <i class="fa-solid fa-print"></i> Cetak / Download PDF
            </button>
        </div>
    </div>

    <div class="page-container">
        <div class="page">
            <div class="page-content">
                
                <!-- HEADER KOP RESMI DENGAN DUAL LOGO -->
                <div class="kop-surat">
                    <img src="<?= base_url('assets/images/logo_yayasan.png') ?>" alt="Logo Yayasan" class="kop-logo" onerror="this.style.display='none'">
                    <div class="kop-text">
                        <h2>YAYASAN ASSALAFIYYAH MLANGI</h2>
                        <h3>KEBERSIHAN YAYASAN</h3>
                        <p><?= esc($settings['alamat_instansi'] ?? 'Jl. Assalafiyyah, Mlangi, Nogotirto, Gamping, Sleman, Yogyakarta 55292') ?></p>
                    </div>
                    <img src="<?= base_url('assets/images/logo_gemerlap.png') ?>" alt="Logo Gemerlap" class="kop-logo" onerror="this.style.display='none'">
                </div>

                <!-- SECTION TITLE BANNER -->
                <div class="section-banner">
                    <i class="fa-solid fa-calculator"></i>
                    Laporan Keuangan Kebersihan — Bulan <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
                </div>

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

                <!-- TOP HEADER INFO BOX (KODE, PERIODE, ANGGARAN) -->
                <table class="eval-table" style="margin-bottom: 12px; font-weight: bold;">
                    <tr>
                        <td width="15%" style="background: #f8fafc; text-align: center; font-size: 8pt; color: #475569;">KODE:</td>
                        <td width="20%" style="background: #ffffff; font-size: 8.5pt; text-align: center; font-family: monospace; color: #166534; font-weight: 800;"><?= esc($buku['kode_keuangan'] ?: 'KUG-' . $buku['tahun']) ?></td>
                        <td width="15%" style="background: #f8fafc; text-align: center; font-size: 8pt; color: #475569;">PERIODE:</td>
                        <td width="20%" style="background: #ffffff; font-size: 8.5pt; text-align: center; color: #0f172a; font-weight: 800;"><?= esc($buku['bulan'] . ' ' . $buku['tahun']) ?></td>
                        <td width="15%" style="background: #f8fafc; text-align: center; font-size: 8pt; color: #475569;">ANGGARAN:</td>
                        <td width="15%" style="background: #dbeafe; text-align: center; font-size: 9.5pt; color: #1e40af; font-weight: 800;">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></td>
                    </tr>
                </table>

                <!-- TABLE 1: ITEM PEMBELIAN / PENGELUARAN -->
                <div style="text-align: center; background: #166534; color: #ffffff; padding: 5px; margin-bottom: 6px; border-radius: 4px; font-weight: 800; font-size: 9pt; letter-spacing: 0.5px;">
                    LAPORAN KEUANGAN KEBERSIHAN (ITEM PEMBELIAN)
                </div>

                <table class="eval-table" style="margin-bottom: 12px;">
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
                                <td colspan="5" class="td-center" style="color: #94a3b8; font-style: italic; padding: 12px;">Belum ada item pengeluaran terisi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 800;">
                            <td colspan="2" class="td-right" style="background: #f8fafc; font-size: 8pt; text-transform: uppercase; letter-spacing: 0.5px;">JUMLAH SALDO</td>
                            <td class="td-right" style="background: #fef08a; color: #713f12; border: 1px solid #eab308;">Rp <?= number_format($totalPlafon, 0, ',', '.') ?></td>
                            <td class="td-right" style="background: #fecdd3; color: #881337; border: 1px solid #f43f5e;">Rp <?= number_format($totalTerserap, 0, ',', '.') ?></td>
                            <td class="td-right" style="background: #bbf7d0; color: #14532d; border: 1px solid #22c55e;">Rp <?= number_format($totalSaldoAkhir, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- SALDO SISA BULAN INI BANNER -->
                <table class="eval-table" style="margin-bottom: 12px; font-weight: 800;">
                    <tr>
                        <td width="35%" style="background: #dbeafe; text-align: center; font-size: 10.5pt; color: #1e40af; border: 1.5px solid #93c5fd;">
                            Rp <?= number_format($saldoSisaBulan, 0, ',', '.') ?>
                        </td>
                        <td width="65%" style="background: #ffffff; text-align: center; font-size: 8.5pt; letter-spacing: 0.5px; border: 1.5px solid #cbd5e1;">
                            SALDO SISA BULAN <?= strtoupper(esc($buku['bulan'])) ?>
                        </td>
                    </tr>
                </table>

                <!-- TABLE 2: INFORMASI DANA MASUK -->
                <div style="text-align: center; background: #1e40af; color: #ffffff; padding: 5px; margin-bottom: 6px; border-radius: 4px; font-weight: 800; font-size: 9pt; letter-spacing: 0.5px;">
                    INFORMASI DANA MASUK
                </div>

                <table class="eval-table" style="margin-bottom: 16px;">
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
                                <td colspan="4" class="td-center" style="color: #94a3b8; font-style: italic; padding: 12px;">Belum ada dana masuk terisi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 800;">
                            <td colspan="2" class="td-right" style="background: #f8fafc; font-size: 8pt; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL INFORMASI DANA MASUK</td>
                            <td class="td-right" style="background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd;">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></td>
                            <td style="background: #f8fafc;"></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- LEMBAR PENGESAHAN (TTD + STEMPEL RESMI) -->
                <div class="signature-page">
                    <div class="signature-date">
                        <?= esc($settings['kota_dokumen'] ?? 'Sleman') ?>, <?= date('d') ?> <?= esc($buku['bulan']) ?> <?= esc($buku['tahun']) ?>
                    </div>

                    <!-- 1. KETUA K3L (POSISI ATAS UTAMA) -->
                    <div class="signature-main" style="position: relative; display: inline-block; width: 100%; text-align: center; margin-bottom: 35px;">
                        <div class="sig-title"><?= esc($settings['jabatan_ketua'] ?? 'Ketua K3L') ?></div>
                        <div class="sig-space" style="height: 65px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <?php if (!empty($settings['ttd_ketua_img']) && file_exists(FCPATH . $settings['ttd_ketua_img'])): ?>
                                <img src="<?= base_url($settings['ttd_ketua_img']) ?>" alt="TTD Ketua" style="max-height: 60px; object-fit: contain;">
                            <?php endif; ?>

                            <?php if (!empty($settings['stempel_img']) && file_exists(FCPATH . $settings['stempel_img'])): ?>
                                <img src="<?= base_url($settings['stempel_img']) ?>" alt="Stempel" style="max-height: 70px; position: absolute; left: 52%; opacity: 0.85; pointer-events: none;">
                            <?php endif; ?>
                        </div>
                        <div class="sig-name"><?= esc($settings['nama_ketua_k3l'] ?? 'Bapak Afif Muzayyin') ?></div>
                    </div>

                    <!-- 2. KOORDINATOR & 3. BENDAHARA / SEKRETARIS -->
                    <div class="signature-row">
                        <div class="signature-box">
                            <div class="sig-title"><?= esc($settings['jabatan_koordinator'] ?? 'Koordinator Kebersihan') ?></div>
                            <div class="sig-space" style="height: 60px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($settings['ttd_koordinator_img']) && file_exists(FCPATH . $settings['ttd_koordinator_img'])): ?>
                                    <img src="<?= base_url($settings['ttd_koordinator_img']) ?>" alt="TTD Koordinator" style="max-height: 55px; object-fit: contain;">
                                <?php endif; ?>
                            </div>
                            <div class="sig-name"><?= esc($settings['nama_koordinator'] ?? 'Bapak Muhammad Ashar') ?></div>
                        </div>

                        <div class="signature-box">
                            <div class="sig-title"><?= esc($settings['jabatan_sekretaris'] ?? 'Sekretaris Kebersihan') ?></div>
                            <div class="sig-space" style="height: 60px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($settings['ttd_sekretaris_img']) && file_exists(FCPATH . $settings['ttd_sekretaris_img'])): ?>
                                    <img src="<?= base_url($settings['ttd_sekretaris_img']) ?>" alt="TTD Sekretaris" style="max-height: 55px; object-fit: contain;">
                                <?php endif; ?>
                            </div>
                            <div class="sig-name"><?= esc($settings['nama_sekretaris'] ?? 'Ahmad Musyafa') ?></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
