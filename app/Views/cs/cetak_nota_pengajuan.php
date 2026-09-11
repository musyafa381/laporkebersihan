<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Bukti Serah Terima Alat') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-6 px-4">

    <!-- Top Action Bar (Print / Back) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="<?= session('role') === 'admin' ? base_url('cs') : base_url('app/pengajuan-alat') ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 transition shadow-xs">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-extrabold text-xs transition shadow-md shadow-emerald-600/20">
            <i class="fa-solid fa-print"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Official Document Sheet -->
    <div class="max-w-3xl mx-auto bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-slate-200 print-page space-y-6">
        
        <!-- Header / Kop Dokumen -->
        <div class="border-b-2 border-slate-900 pb-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center text-2xl font-black shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-broom-ball"></i>
                </div>
                <div>
                    <h2 class="font-heading font-black text-lg sm:text-xl text-slate-900 leading-tight uppercase tracking-tight">
                        <?= esc($settings['nama_instansi'] ?? 'PONDOK PESANTREN ASSALAFIYYAH MLANGI') ?>
                    </h2>
                    <p class="text-xs font-bold text-emerald-700 tracking-wide font-heading">Divisi Logistik & Gudang</p>
                    <p class="text-[10.5px] text-slate-500 mt-0.5">
                        <?= esc($settings['alamat_instansi'] ?? 'Mlangi, Nogotirto, Gamping, Sleman, D.I. Yogyakarta') ?> &bull; Telp/WA: <?= esc($settings['hotline_wa'] ?? '0895320276800') ?>
                    </p>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <span class="inline-block px-3 py-1 rounded-lg text-xs font-black font-mono bg-slate-100 text-slate-800 border border-slate-300">
                    <?= esc($p['kode_pengajuan'] ?? 'REQ-000') ?>
                </span>
                <p class="text-[10px] text-slate-500 mt-1">Status: <strong class="uppercase font-extrabold <?= $p['status'] === 'Disetujui' || $p['status'] === 'Selesai' ? 'text-emerald-700' : ($p['status'] === 'Pending' ? 'text-amber-700' : 'text-rose-700') ?>"><?= esc($p['status']) ?></strong></p>
            </div>
        </div>

        <!-- Document Title Banner -->
        <div class="text-center space-y-1 py-1">
            <h1 class="font-heading font-black text-base sm:text-lg text-slate-900 uppercase tracking-wide">
                BUKTI SERAH TERIMA & PENGAJUAN PERALATAN KEBERSIHAN
            </h1>
            <p class="text-xs text-slate-500 font-semibold">Lampiran resmi permohonan logistik dan pendistribusian alat kerja kebersihan</p>
        </div>

        <!-- Information Metadata Grid -->
        <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-semibold w-24">Nama Pemohon:</span>
                    <span class="font-extrabold text-slate-900"><?= esc($p['nama_lengkap'] ?: 'Pengurus') ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-semibold w-24">Unit / Instansi:</span>
                    <span class="font-bold text-slate-800"><?= esc($p['nama_unit'] ?: 'Unit Pesantren') ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-semibold w-24">Kontak HP/WA:</span>
                    <span class="font-mono text-slate-700"><?= esc($p['no_hp'] ?: '-') ?></span>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-semibold w-28">Tgl Pengajuan:</span>
                    <span class="font-bold text-slate-800"><?= date('d F Y H:i', strtotime($p['created_at'])) ?> WIB</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-semibold w-28">Diverifikasi Oleh:</span>
                    <span class="font-bold text-slate-800"><?= !empty($p['nama_admin']) && !in_array(strtolower($p['nama_admin']), ['admin', 'admin gudang', 'admin k3l']) ? esc($p['nama_admin']) : 'Ahmad Fakhri Maulana' ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-semibold w-28">Tgl Verifikasi:</span>
                    <span class="font-mono text-slate-700"><?= !empty($p['disetujui_pada']) ? date('d F Y H:i', strtotime($p['disetujui_pada'])) . ' WIB' : '-' ?></span>
                </div>
            </div>
        </div>

        <!-- Alasan Keperluan -->
        <div>
            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 mb-1">Keperluan / Keterangan Permohonan:</h4>
            <div class="p-3 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-700 italic leading-relaxed">
                "<?= esc($p['alasan_keperluan']) ?>"
            </div>
        </div>

        <!-- Table of Items -->
        <div>
            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 mb-2">Daftar Peralatan Yang Diminta & Realisasi:</h4>
            <div class="overflow-hidden rounded-2xl border border-slate-300">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-100 text-slate-800 font-heading font-black text-[10px] uppercase border-b border-slate-300">
                        <tr>
                            <th class="py-2.5 px-3 text-center border-r border-slate-300" width="5%">No</th>
                            <th class="py-2.5 px-3 border-r border-slate-300" width="18%">Kode Alat</th>
                            <th class="py-2.5 px-3 border-r border-slate-300" width="35%">Nama Peralatan & Kategori</th>
                            <th class="py-2.5 px-3 text-center border-r border-slate-300" width="14%">Permintaan</th>
                            <th class="py-2.5 px-3 text-center border-r border-slate-300 bg-emerald-50 text-emerald-950 font-black" width="14%">Disetujui</th>
                            <th class="py-2.5 px-3 text-center" width="14%">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php if (!empty($p['items'])): ?>
                            <?php foreach ($p['items'] as $idx => $it): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="py-2.5 px-3 text-center font-bold text-slate-500 border-r border-slate-200"><?= $idx + 1 ?></td>
                                    <td class="py-2.5 px-3 font-mono text-[11px] font-bold text-slate-600 border-r border-slate-200"><?= esc($it['kode_alat'] ?: '-') ?></td>
                                    <td class="py-2.5 px-3 border-r border-slate-200">
                                        <div class="font-extrabold text-slate-900"><?= esc($it['nama_alat'] ?? 'Alat Kebersihan') ?></div>
                                        <div class="text-[10px] text-slate-400 font-semibold"><?= esc($it['kategori'] ?? 'Umum') ?> &bull; Satuan: <?= esc($it['satuan'] ?? 'Unit') ?></div>
                                    </td>
                                    <td class="py-2.5 px-3 text-center font-bold text-slate-700 border-r border-slate-200">
                                        <?= (int)$it['jumlah_minta'] ?> <?= esc($it['satuan'] ?? 'Unit') ?>
                                    </td>
                                    <td class="py-2.5 px-3 text-center font-extrabold text-emerald-800 bg-emerald-50/50 border-r border-slate-200">
                                        <?= $it['jumlah_setuju'] !== null ? (int)$it['jumlah_setuju'] . ' ' . esc($it['satuan'] ?? 'Unit') : '-' ?>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block text-[10px] font-extrabold uppercase <?= $it['status_item'] === 'Disetujui' ? 'text-emerald-700' : ($it['status_item'] === 'Sebagian' ? 'text-blue-700' : ($it['status_item'] === 'Pending' ? 'text-amber-700' : 'text-rose-700')) ?>">
                                            <?= esc($it['status_item'] ?? 'Pending') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($p['catatan_admin'])): ?>
            <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/90 text-xs">
                <span class="font-extrabold text-amber-950 uppercase tracking-wide text-[11px] block mb-0.5">Catatan Divisi Logistik:</span>
                <p class="text-amber-900 font-medium leading-relaxed">"<?= esc($p['catatan_admin']) ?>"</p>
            </div>
        <?php endif; ?>

        <!-- Signatures (Tanda Tangan Serah Terima Fisik) -->
        <div class="pt-6 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="text-slate-500 font-semibold mb-16">Pihak Pemohon / Pengambil Barang,</p>
                <div class="border-b border-slate-400 w-48 mx-auto mb-1.5"></div>
                <p class="font-bold text-slate-900">( <?= esc($p['nama_lengkap'] ?: 'Pengurus Unit') ?> )</p>
                <p class="text-[10px] text-slate-500">Unit: <?= esc($p['nama_unit'] ?: '-') ?></p>
            </div>
            <div>
                <p class="text-slate-500 font-semibold mb-16">Petugas Divisi Logistik & Gudang,</p>
                <div class="border-b border-slate-400 w-48 mx-auto mb-1.5"></div>
                <p class="font-bold text-slate-900">( <?= !empty($p['nama_admin']) && !in_array(strtolower($p['nama_admin']), ['admin', 'admin gudang', 'admin k3l']) ? esc($p['nama_admin']) : 'Ahmad Fakhri Maulana' ?> )</p>
                <p class="text-[10px] text-slate-500">Divisi Logistik & Gudang</p>
            </div>
        </div>

    </div>

</body>
</html>
