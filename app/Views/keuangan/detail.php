<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Top Action & Navigation Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="<?= base_url('keuangan') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white text-slate-700 font-extrabold text-xs hover:bg-slate-50 border border-slate-200/90 shadow-2xs transition group w-fit">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Daftar Buku Keuangan</span>
        </a>

        <a href="<?= base_url('keuangan/cetak/' . $buku['id']) ?>" target="_blank" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
            <i class="fa-solid fa-print"></i>
            <span>Cetak / Export PDF Keuangan</span>
        </a>
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

    <!-- Header Banner Keuangan -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-5 border-b border-slate-100">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fa-solid fa-calculator text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight"><?= esc($buku['judul']) ?></h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Periode Laporan: <b><?= esc($buku['bulan'] . ' ' . $buku['tahun']) ?></b></p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="px-4 py-2.5 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-right">
                    <span class="block text-[10px] font-extrabold uppercase tracking-wider text-emerald-600">KODE KEUANGAN</span>
                    <span class="font-heading font-extrabold text-sm"><i class="fa-solid fa-barcode mr-1 text-emerald-500"></i><?= esc($buku['kode_keuangan'] ?: 'KUG-' . $buku['tahun']) ?></span>
                </div>

                <div class="px-5 py-2.5 rounded-2xl bg-slate-100/90 border border-slate-200/80 text-right">
                    <span class="block text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">BULAN</span>
                    <span class="font-heading font-extrabold text-slate-800 text-sm"><?= esc($buku['bulan'] . ' ' . $buku['tahun']) ?></span>
                </div>

                <div class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/20 text-right">
                    <span class="block text-[10px] font-extrabold uppercase tracking-wider text-blue-100">JUMLAH ANGGARAN (DANA MASUK)</span>
                    <span id="bannerJumlahAnggaran" class="font-heading font-extrabold text-base">Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <!-- Summary Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200/70 space-y-1">
                <span class="text-[10px] font-extrabold text-amber-800 uppercase tracking-wider block">Total Plafon Anggaran</span>
                <p id="cardTotalPlafon" class="font-heading font-extrabold text-amber-900 text-lg">Rp <?= number_format($totalPlafon, 0, ',', '.') ?></p>
            </div>
            <div class="p-4 rounded-2xl bg-rose-50/80 border border-rose-200/70 space-y-1">
                <span class="text-[10px] font-extrabold text-rose-800 uppercase tracking-wider block">Total Realisasi Terserap</span>
                <p id="cardTotalTerserap" class="font-heading font-extrabold text-rose-900 text-lg">Rp <?= number_format($totalTerserap, 0, ',', '.') ?></p>
            </div>
            <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/70 space-y-1">
                <span class="text-[10px] font-extrabold text-emerald-800 uppercase tracking-wider block">Saldo Sisa Akhir <?= esc($buku['bulan']) ?></span>
                <p id="cardSaldoSisa" class="font-heading font-extrabold text-emerald-900 text-lg">Rp <?= number_format($saldoSisaBulan, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <!-- 1. TABEL LAPORAN KEUANGAN KEBERSIHAN (ITEM PEMBELIAN / PENGELUARAN) -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h4 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-emerald-600"></i> LAPORAN KEUANGAN KEBERSIHAN (ITEM PEMBELIAN)
                </h4>
                <p class="text-xs text-slate-500 font-medium">Daftar alokasi plafon, terserap, dan saldo akhir per item pengeluaran.</p>
            </div>
        </div>

        <form action="<?= base_url('keuangan/store-pembelian/' . $buku['id']) ?>" method="POST" class="space-y-4">
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="38%" class="py-3 px-4">ITEM PEMBELIAN</th>
                            <th width="22%" class="py-3 px-4 text-right">PLAFON (Rp)</th>
                            <th width="22%" class="py-3 px-4 text-right">TERSERAP (Rp)</th>
                            <th width="20%" class="py-3 px-4 text-right">SALDO AKHIR (Rp)</th>
                            <th width="6%" class="py-3 px-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="keuanganPembelianContainer" class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($keuanganPembelian)): ?>
                            <?php foreach ($keuanganPembelian as $idx => $kp): 
                                $sAkhir = (float)$kp['plafon'] - (float)$kp['terserap'];
                            ?>
                                <tr id="kp_row_<?= $idx ?>" class="kp-row hover:bg-slate-50/80 transition-all">
                                    <td class="num-badge-kp py-2.5 px-3 text-center font-extrabold text-slate-500"><?= $idx + 1 ?></td>
                                    <td class="py-2.5 px-3">
                                        <input type="text" name="item_pembelian[]" value="<?= esc($kp['item_pembelian']) ?>" placeholder="Nama item pembelian / koordinasi..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                                    </td>
                                    <td class="py-2.5 px-3">
                                        <input type="text" name="plafon[]" value="<?= number_format($kp['plafon'], 0, ',', '.') ?>" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="kp-plafon w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                                    </td>
                                    <td class="py-2.5 px-3">
                                        <input type="text" name="terserap[]" value="<?= number_format($kp['terserap'], 0, ',', '.') ?>" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="kp-terserap w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                                    </td>
                                    <td class="py-2.5 px-4 text-right font-extrabold text-slate-800 kp-saldo">
                                        Rp <?= number_format($sAkhir, 0, ',', '.') ?>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <button type="button" onclick="removeKpRow(this)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs mx-auto" title="Hapus Baris">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="bg-slate-100/90 font-heading font-extrabold text-xs text-slate-900 border-t-2 border-slate-200">
                        <tr>
                            <td colspan="2" class="py-3.5 px-4 uppercase text-right tracking-wider">JUMLAH SALDO</td>
                            <td id="totalPlafonCell" class="py-3.5 px-4 text-right bg-amber-100/80 text-amber-900 border-x border-amber-200">
                                Rp <?= number_format($totalPlafon, 0, ',', '.') ?>
                            </td>
                            <td id="totalTerserapCell" class="py-3.5 px-4 text-right bg-rose-100/80 text-rose-900 border-r border-rose-200">
                                Rp <?= number_format($totalTerserap, 0, ',', '.') ?>
                            </td>
                            <td id="totalSaldoCell" class="py-3.5 px-4 text-right bg-emerald-100/80 text-emerald-900 border-r border-emerald-200">
                                Rp <?= number_format($totalSaldoAkhir, 0, ',', '.') ?>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                <button type="button" onclick="addKpRow()" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 font-heading font-extrabold text-xs hover:bg-emerald-100 transition shadow-2xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Tambah Baris Item Pembelian</span>
                </button>

                <button type="submit" class="w-full sm:w-auto px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Laporan Item Pembelian</span>
                </button>
            </div>
        </form>
    </div>

    <!-- SALDO SISA BULAN BANNER -->
    <div class="rounded-3xl p-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-wallet text-lg"></i>
            </div>
            <div>
                <h5 class="font-heading font-extrabold text-base tracking-tight">SALDO SISA BULAN <?= strtoupper(esc($buku['bulan'])) ?></h5>
                <p class="text-xs text-blue-100 font-medium">Formula: Total Dana Masuk (Anggaran) − Total Realisasi Terserap</p>
            </div>
        </div>
        <div class="text-right">
            <span id="saldoSisaBulanBanner" class="font-heading font-extrabold text-2xl text-white tracking-wide">
                Rp <?= number_format($saldoSisaBulan, 0, ',', '.') ?>
            </span>
        </div>
    </div>

    <!-- 2. TABEL INFORMASI DANA MASUK -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h4 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-piggy-bank text-emerald-600"></i> INFORMASI DANA MASUK
                </h4>
                <p class="text-xs text-slate-500 font-medium">Daftar sumber penerimaan anggaran & kas untuk kebersihan.</p>
            </div>
        </div>

        <form action="<?= base_url('keuangan/store-masuk/' . $buku['id']) ?>" method="POST" class="space-y-4">
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="35%" class="py-3 px-4">SUMBER DANA</th>
                            <th width="15%" class="py-3 px-4 text-right">NOMINAL (Rp)</th>
                            <th width="40%" class="py-3 px-4">KETERANGAN</th>
                            <th width="6%" class="py-3 px-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="keuanganMasukContainer" class="divide-y divide-slate-100 bg-white">
                        <?php if (!empty($keuanganMasuk)): ?>
                            <?php foreach ($keuanganMasuk as $idx => $km): ?>
                                <tr id="km_row_<?= $idx ?>" class="km-row hover:bg-slate-50/80 transition-all">
                                    <td class="num-badge-km py-2.5 px-3 text-center font-extrabold text-slate-500"><?= $idx + 1 ?></td>
                                    <td class="py-2.5 px-3">
                                        <input type="text" name="sumber_dana[]" value="<?= esc($km['sumber_dana']) ?>" placeholder="Misal: Subsidi Yayasan / Saldo Sisa Bulan Lalu..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                                    </td>
                                    <td class="py-2.5 px-3">
                                        <input type="text" name="nominal[]" value="<?= number_format($km['nominal'], 0, ',', '.') ?>" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="km-nominal w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                                    </td>
                                    <td class="py-2.5 px-3">
                                        <input type="text" name="keterangan[]" value="<?= esc($km['keterangan']) ?>" placeholder="Keterangan tambahan (opsional)..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <button type="button" onclick="removeKmRow(this)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs mx-auto" title="Hapus Baris">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="bg-slate-100/90 font-heading font-extrabold text-xs text-slate-900 border-t-2 border-slate-200">
                        <tr>
                            <td colspan="2" class="py-3.5 px-4 uppercase text-right tracking-wider">TOTAL INFORMASI DANA MASUK</td>
                            <td id="totalMasukCell" class="py-3.5 px-4 text-right bg-blue-100/80 text-blue-900 border-x border-blue-200">
                                Rp <?= number_format($totalDanaMasuk, 0, ',', '.') ?>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                <button type="button" onclick="addKmRow()" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 font-heading font-extrabold text-xs hover:bg-emerald-100 transition shadow-2xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Tambah Baris Dana Masuk</span>
                </button>

                <button type="submit" class="w-full sm:w-auto px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Informasi Dana Masuk</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function formatRupiahInput(el) {
        let val = el.value.replace(/[^\d]/g, '');
        if (val) {
            el.value = parseInt(val, 10).toLocaleString('id-ID');
        } else {
            el.value = '';
        }
    }

    function parseRupiah(valStr) {
        if (!valStr) return 0;
        const clean = valStr.toString().replace(/[^\d]/g, '');
        return clean ? parseInt(clean, 10) : 0;
    }

    function updateKeuanganTotals() {
        let totalPlafon = 0;
        let totalTerserap = 0;

        document.querySelectorAll('.kp-row').forEach(row => {
            const plafonInp = row.querySelector('.kp-plafon');
            const terserapInp = row.querySelector('.kp-terserap');
            const saldoTd = row.querySelector('.kp-saldo');

            const plafon = parseRupiah(plafonInp ? plafonInp.value : 0);
            const terserap = parseRupiah(terserapInp ? terserapInp.value : 0);
            const saldo = plafon - terserap;

            if (saldoTd) saldoTd.textContent = 'Rp ' + saldo.toLocaleString('id-ID');

            totalPlafon += plafon;
            totalTerserap += terserap;
        });

        const totalSaldoAkhir = totalPlafon - totalTerserap;

        let totalDanaMasuk = 0;
        document.querySelectorAll('.km-row').forEach(row => {
            const nomInp = row.querySelector('.km-nominal');
            totalDanaMasuk += parseRupiah(nomInp ? nomInp.value : 0);
        });

        const saldoSisaBulan = totalDanaMasuk - totalTerserap;

        const totalPlafonCell = document.getElementById('totalPlafonCell');
        if (totalPlafonCell) totalPlafonCell.textContent = 'Rp ' + totalPlafon.toLocaleString('id-ID');

        const totalTerserapCell = document.getElementById('totalTerserapCell');
        if (totalTerserapCell) totalTerserapCell.textContent = 'Rp ' + totalTerserap.toLocaleString('id-ID');

        const totalSaldoCell = document.getElementById('totalSaldoCell');
        if (totalSaldoCell) totalSaldoCell.textContent = 'Rp ' + totalSaldoAkhir.toLocaleString('id-ID');

        const totalMasukCell = document.getElementById('totalMasukCell');
        if (totalMasukCell) totalMasukCell.textContent = 'Rp ' + totalDanaMasuk.toLocaleString('id-ID');

        const bannerJumlahAnggaran = document.getElementById('bannerJumlahAnggaran');
        if (bannerJumlahAnggaran) bannerJumlahAnggaran.textContent = 'Rp ' + totalDanaMasuk.toLocaleString('id-ID');

        const cardTotalPlafon = document.getElementById('cardTotalPlafon');
        if (cardTotalPlafon) cardTotalPlafon.textContent = 'Rp ' + totalPlafon.toLocaleString('id-ID');

        const cardTotalTerserap = document.getElementById('cardTotalTerserap');
        if (cardTotalTerserap) cardTotalTerserap.textContent = 'Rp ' + totalTerserap.toLocaleString('id-ID');

        const cardSaldoSisa = document.getElementById('cardSaldoSisa');
        if (cardSaldoSisa) cardSaldoSisa.textContent = 'Rp ' + saldoSisaBulan.toLocaleString('id-ID');

        const saldoSisaBulanBanner = document.getElementById('saldoSisaBulanBanner');
        if (saldoSisaBulanBanner) saldoSisaBulanBanner.textContent = 'Rp ' + saldoSisaBulan.toLocaleString('id-ID');
    }

    function addKpRow() {
        const container = document.getElementById('keuanganPembelianContainer');
        if (!container) return;
        const count = container.querySelectorAll('.kp-row').length + 1;
        const html = `
            <tr class="kp-row hover:bg-slate-50/80 transition-all">
                <td class="num-badge-kp py-2.5 px-3 text-center font-extrabold text-slate-500">${count}</td>
                <td class="py-2.5 px-3">
                    <input type="text" name="item_pembelian[]" placeholder="Nama item pembelian / koordinasi..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="plafon[]" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="kp-plafon w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="terserap[]" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="kp-terserap w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-4 text-right font-extrabold text-slate-800 kp-saldo">Rp 0</td>
                <td class="py-2.5 px-3 text-center">
                    <button type="button" onclick="removeKpRow(this)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs mx-auto" title="Hapus Baris">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexKpBadges();
        updateKeuanganTotals();
    }

    function removeKpRow(btn) {
        const row = btn.closest('.kp-row');
        if (row) {
            row.remove();
            reindexKpBadges();
            updateKeuanganTotals();
        }
    }

    function reindexKpBadges() {
        document.querySelectorAll('.kp-row').forEach((row, idx) => {
            const badge = row.querySelector('.num-badge-kp');
            if (badge) badge.textContent = idx + 1;
        });
    }

    function addKmRow() {
        const container = document.getElementById('keuanganMasukContainer');
        if (!container) return;
        const count = container.querySelectorAll('.km-row').length + 1;
        const html = `
            <tr class="km-row hover:bg-slate-50/80 transition-all">
                <td class="num-badge-km py-2.5 px-3 text-center font-extrabold text-slate-500">${count}</td>
                <td class="py-2.5 px-3">
                    <input type="text" name="sumber_dana[]" placeholder="Misal: Subsidi Yayasan / Saldo Sisa Bulan Lalu..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="nominal[]" placeholder="0" oninput="formatRupiahInput(this); updateKeuanganTotals();" class="km-nominal w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3">
                    <input type="text" name="keterangan[]" placeholder="Keterangan tambahan (opsional)..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/50 focus:bg-white transition shadow-2xs">
                </td>
                <td class="py-2.5 px-3 text-center">
                    <button type="button" onclick="removeKmRow(this)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition shadow-2xs mx-auto" title="Hapus Baris">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', html);
        reindexKmBadges();
        updateKeuanganTotals();
    }

    function removeKmRow(btn) {
        const row = btn.closest('.km-row');
        if (row) {
            row.remove();
            reindexKmBadges();
            updateKeuanganTotals();
        }
    }

    function reindexKmBadges() {
        document.querySelectorAll('.km-row').forEach((row, idx) => {
            const badge = row.querySelector('.num-badge-km');
            if (badge) badge.textContent = idx + 1;
        });
    }
</script>

<?= $this->endSection() ?>
