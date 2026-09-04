<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 pb-12">
    <!-- Breadcrumb & Header Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-200/80 bg-white relative overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 relative z-10">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 flex-wrap">
                    <a href="<?= base_url('wilayah') ?>" class="hover:text-emerald-600 transition flex items-center gap-1">
                        <i class="fa-solid fa-map-location-dot text-emerald-600"></i>
                        <span>Pemetaan Wilayah</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                    <span class="text-slate-700"><?= esc($wilayah['nama_wilayah']) ?></span>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                        <?= esc($wilayah['nama_wilayah']) ?>
                    </h1>
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-heading font-extrabold border border-emerald-200/80 shadow-2xs">
                        <?= esc($wilayah['kode_wilayah'] ?: 'WIL-' . $wilayah['id']) ?>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200">
                        <?= esc($wilayah['kategori_area']) ?>
                    </span>
                </div>

                <div class="flex items-center gap-4 text-xs text-slate-500 font-medium flex-wrap pt-1">
                    <?php if (!empty($wilayah['lokasi_gedung'])): ?>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-rose-500"></i> <?= esc($wilayah['lokasi_gedung']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($wilayah['luas_area'])): ?>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-ruler-combined text-teal-600"></i> <?= esc($wilayah['luas_area']) ?></span>
                    <?php endif; ?>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-600"></i> Status: <strong><?= esc($wilayah['status']) ?></strong></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 flex-wrap self-start lg:self-center">
                <a href="<?= base_url('wilayah') ?>" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-extrabold text-xs transition shadow-2xs">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
                <?php if (session()->get('role') === 'Admin'): ?>
                    <button type="button" onclick="openModalEditWilayah()" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                        <span>Edit Data</span>
                    </button>
                    <a href="<?= base_url('wilayah/delete/' . $wilayah['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus wilayah '<?= esc($wilayah['nama_wilayah']) ?>' beserta seluruh foto dan jadwal penugasan?" class="px-4 py-2.5 rounded-2xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-1.5">
                        <i class="fa-solid fa-trash text-xs"></i>
                        <span>Hapus</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($wilayah['deskripsi'])): ?>
            <div class="mt-4 p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 text-xs text-slate-600 leading-relaxed font-medium">
                <strong class="text-slate-800 font-bold block mb-0.5"><i class="fa-solid fa-circle-info text-emerald-600 mr-1"></i> Deskripsi & Petunjuk Wilayah:</strong>
                <?= nl2br(esc($wilayah['deskripsi'])) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 1: Galeri Multi-Foto Master Wilayah (Cloudinary Paten) -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-images text-emerald-600"></i> Foto Master Wilayah
                </h2>
                <p class="text-xs text-slate-500 font-medium">Foto identitas visual dan kondisi fisik wilayah. Tidak harus diganti setiap hari.</p>
            </div>

            <?php if (session()->get('role') === 'Admin'): ?>
                <button type="button" onclick="openModalUploadFoto()" class="px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-200 font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-emerald-600"></i>
                    <span>Tambah Foto Master</span>
                </button>
            <?php endif; ?>
        </div>

        <?php if (!empty($fotos)): ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <?php foreach ($fotos as $f): ?>
                    <div class="relative group rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs aspect-video">
                        <img src="<?= esc($f['foto_url']) ?>" alt="Foto Wilayah" class="w-full h-full object-cover group-hover:scale-105 transition duration-300 cursor-pointer" onclick="openLightbox('<?= esc($f['foto_url']) ?>')">
                        
                        <?php if ($f['is_primary']): ?>
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg bg-emerald-600 text-white text-[9px] font-extrabold shadow-sm">
                                <i class="fa-solid fa-star text-[8px]"></i> Foto Utama
                            </span>
                        <?php endif; ?>

                        <?php if (session()->get('role') === 'Admin'): ?>
                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-2">
                                <?php if (!$f['is_primary']): ?>
                                    <a href="<?= base_url('wilayah/set-primary-foto/' . $f['id']) ?>" class="w-8 h-8 rounded-xl bg-white text-emerald-700 hover:bg-emerald-50 flex items-center justify-center text-xs shadow-md transition" title="Jadikan Foto Utama">
                                        <i class="fa-solid fa-star"></i>
                                    </a>
                                <?php endif; ?>
                                <button type="button" onclick="openLightbox('<?= esc($f['foto_url']) ?>')" class="w-8 h-8 rounded-xl bg-white text-slate-700 hover:bg-slate-50 flex items-center justify-center text-xs shadow-md transition" title="Lihat Penuh">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                                <a href="<?= base_url('wilayah/delete-foto/' . $f['id']) ?>" data-confirm-msg="Hapus foto master wilayah ini?" class="w-8 h-8 rounded-xl bg-white text-rose-600 hover:bg-rose-50 flex items-center justify-center text-xs shadow-md transition" title="Hapus Foto">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200 space-y-2">
                <i class="fa-solid fa-image text-3xl text-slate-300"></i>
                <p class="text-xs text-slate-500 font-semibold">Belum ada foto master yang diunggah untuk wilayah ini.</p>
                <?php if (session()->get('role') === 'Admin'): ?>
                    <button type="button" onclick="openModalUploadFoto()" class="text-xs text-emerald-600 font-extrabold hover:underline">Unggah Foto Sekarang &rarr;</button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 2: Penugasan Unit & Shift (Jobdesk Shift) -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> Jadwal Penugasan Shift Unit Pengampu
                </h2>
                <p class="text-xs text-slate-500 font-medium">Pengaturan unit yang bertanggung jawab menjaga kebersihan area per shift (Pagi / Siang / Sore / Malam).</p>
            </div>

            <?php if (session()->get('role') === 'Admin'): ?>
                <button type="button" onclick="openModalTambahPenugasan()" class="px-4 py-2 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Shift Unit</span>
                </button>
            <?php endif; ?>
        </div>

        <?php if (!empty($penugasan)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php foreach ($penugasan as $p): ?>
                    <?php
                        $shiftBadge = 'bg-amber-500 text-white';
                        $shiftIcon  = 'fa-sun';
                        if ($p['shift'] === 'Siang') {
                            $shiftBadge = 'bg-orange-500 text-white';
                            $shiftIcon  = 'fa-sun';
                        } elseif ($p['shift'] === 'Sore') {
                            $shiftBadge = 'bg-blue-600 text-white';
                            $shiftIcon  = 'fa-cloud-sun';
                        } elseif ($p['shift'] === 'Malam') {
                            $shiftBadge = 'bg-purple-600 text-white';
                            $shiftIcon  = 'fa-moon';
                        }
                    ?>
                    <div class="glass-card rounded-3xl border border-slate-200/90 bg-white p-5 shadow-lg shadow-slate-200/40 hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between space-y-4 group">
                        
                        <!-- Top Header: Shift Pill & Time Badge -->
                        <div class="flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-heading font-extrabold <?= $shiftBadge ?> shadow-xs">
                                <i class="fa-solid <?= $shiftIcon ?>"></i>
                                <span>Shift <?= esc($p['shift']) ?></span>
                            </span>

                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-heading font-extrabold text-[11px] shadow-2xs">
                                <i class="fa-regular fa-clock text-slate-400"></i>
                                <span><?= esc($p['jam_mulai']) ?> – <?= esc($p['jam_selesai']) ?> WIB</span>
                            </span>
                        </div>

                        <!-- Unit Info Block -->
                        <div class="space-y-3">
                            <div>
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Unit Penanggung Jawab</span>
                                <div class="flex items-start gap-2.5 mt-1.5">
                                    <div class="w-9 h-9 rounded-2xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center flex-shrink-0 text-sm shadow-2xs mt-0.5">
                                        <i class="fa-solid fa-sitemap"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-heading font-extrabold text-sm text-slate-900 leading-snug group-hover:text-emerald-700 transition">
                                            <?= esc($p['nama_unit'] ?: 'Unit Belum Diatur') ?>
                                        </h4>
                                        <?php if (!empty($p['tipe_unit'])): ?>
                                            <span class="inline-block px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200/60 text-[10px] font-bold mt-1 shadow-2xs">
                                                <?= esc($p['tipe_unit']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- PJ Info -->
                            <?php if (!empty($p['pj_nama'])): ?>
                                <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 font-medium flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <i class="fa-solid fa-user-tie text-emerald-600 text-xs"></i>
                                        <span class="font-bold text-slate-800 truncate"><?= esc($p['pj_nama']) ?></span>
                                    </div>
                                    <?php if (!empty($p['pj_kontak'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $p['pj_kontak']) ?>" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-800 flex items-center gap-1 flex-shrink-0">
                                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                            <span><?= esc($p['pj_kontak']) ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($p['keterangan'])): ?>
                                <div class="text-[11px] text-slate-600 bg-amber-50/60 p-2.5 rounded-2xl border border-amber-200/70 leading-relaxed font-medium">
                                    <strong class="text-amber-900 font-bold block mb-0.5"><i class="fa-solid fa-note-sticky text-amber-500 mr-1"></i> Petunjuk Khusus:</strong>
                                    <?= esc($p['keterangan']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Footer: Active Days & Action Buttons (Edit + Delete) -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-600">
                                <i class="fa-solid fa-calendar-day text-emerald-600"></i>
                                <span><?= esc($p['hari_aktif'] ?: 'Setiap Hari') ?></span>
                            </span>

                            <?php if (session()->get('role') === 'Admin'): ?>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" onclick="openModalEditPenugasan(<?= htmlspecialchars(json_encode($p)) ?>)" class="px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-heading font-extrabold text-[11px] transition shadow-2xs flex items-center gap-1.5" title="Edit Shift">
                                        <i class="fa-solid fa-pen-to-square text-amber-600 text-[11px]"></i>
                                        <span>Edit</span>
                                    </button>
                                    <a href="<?= base_url('wilayah/penugasan/delete/' . $p['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus penugasan shift <?= esc($p['shift']) ?> untuk unit '<?= esc($p['nama_unit']) ?>'?" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-heading font-extrabold text-[11px] transition shadow-2xs flex items-center gap-1.5" title="Hapus Penugasan">
                                        <i class="fa-solid fa-trash text-rose-500 text-[10px]"></i>
                                        <span>Hapus</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-6 text-center bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-500 font-semibold">
                Belum ada penugasan shift unit untuk wilayah ini. Silakan tambahkan unit yang bertugas (Pagi/Sore).
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 3: Riwayat Laporan Harian Kebersihan Wilayah Ini -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-check text-emerald-600"></i> Riwayat Laporan Harian Kebersihan
                </h2>
                <p class="text-xs text-slate-500 font-medium">Log laporan hasil kebersihan yang telah dikirim oleh unit pelaksana tugas.</p>
            </div>

            <span class="text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/80 self-start sm:self-auto">
                <?= count($laporanList) ?> Laporan Terakhir
            </span>
        </div>

        <?php if (!empty($laporanList)): ?>
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">TANGGAL & SHIFT</th>
                            <th class="py-3 px-4">UNIT PELAKSANA</th>
                            <th class="py-3 px-3 text-center">NILAI CAPAIAN</th>
                            <th class="py-3 px-4">BUKTI FOTO HARIAN</th>
                            <th class="py-3 px-4">CATATAN PEMBERSIHAN</th>
                            <th class="py-3 px-3 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php foreach ($laporanList as $lap): ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                    <div><?= date('d M Y', strtotime($lap['tanggal_lapor'])) ?></div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-extrabold <?= $lap['shift'] === 'Pagi' ? 'bg-amber-50 text-amber-800' : 'bg-blue-50 text-blue-800' ?>">
                                            Shift <?= esc($lap['shift']) ?>
                                        </span>
                                        <?php if (!empty($lap['jam_lapor'])): ?>
                                            <span class="text-[10px] text-slate-400 font-semibold">Pk <?= esc($lap['jam_lapor']) ?> WIB</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-sitemap text-emerald-600 text-xs"></i>
                                        <span><?= esc($lap['nama_unit'] ?: 'Unit') ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">Oleh: <?= esc($lap['nama_pelapor'] ?: 'Petugas Unit') ?></div>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <?php
                                        $skor = (int)$lap['nilai_kebersihan'];
                                        $badgeBg = $skor >= 80 ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($skor >= 60 ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200');
                                    ?>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-heading font-extrabold border <?= $badgeBg ?> shadow-2xs">
                                        <span><?= $skor ?>%</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <?php if (!empty($lap['foto_bukti_url'])): ?>
                                        <div class="relative group w-16 h-12 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 cursor-pointer shadow-2xs" onclick="openLightbox('<?= esc($lap['foto_bukti_url']) ?>')">
                                            <img src="<?= esc($lap['foto_bukti_url']) ?>" alt="Bukti Bersih" class="w-full h-full object-cover group-hover:scale-110 transition">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[10px]">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-600 font-medium">
                                    <?= esc($lap['catatan'] ?: '-') ?>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-extrabold <?= $lap['status_verifikasi'] === 'Sudah Bersih' ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-800' ?>">
                                        <i class="fa-solid <?= $lap['status_verifikasi'] === 'Sudah Bersih' ? 'fa-check' : 'fa-triangle-exclamation' ?>"></i>
                                        <span><?= esc($lap['status_verifikasi']) ?></span>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-6 text-center bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-500 font-semibold">
                Belum ada laporan kebersihan yang masuk untuk wilayah ini.
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 4: Laporan & Keluhan CS Terkait Wilayah Ini -->
    <?php if (!empty($csReports)): ?>
        <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg border border-amber-200/80 flex-shrink-0">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h2 class="font-heading font-extrabold text-lg text-slate-900 leading-tight">
                            Laporan / Pengaduan CS Terkait Wilayah Ini
                        </h2>
                        <p class="text-xs text-slate-500 font-medium">Daftar masukan atau keluhan santri & masyarakat terkait kebersihan area ini.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="relative w-full sm:w-60">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input type="text" id="searchCsDetailInput" onkeyup="filterCsDetailTable()" placeholder="Cari pelapor / isi keluhan..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-extrabold text-amber-800 bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200/80 whitespace-nowrap">
                            <?= count($csReports) ?> Laporan CS
                        </span>
                        <a href="<?= base_url('cs') ?>" class="px-3.5 py-2 rounded-2xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-200/80 text-xs font-heading font-extrabold transition flex items-center justify-center gap-1.5 shadow-2xs whitespace-nowrap">
                            <span>Buka Inbox CS</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
                <table id="tableCsWilayahDetail" class="w-full text-left text-xs font-semibold">
                    <thead class="bg-slate-100 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th width="4%" class="py-3 px-3 text-center">NO</th>
                            <th width="16%" class="py-3 px-4">TANGGAL & WAKTU</th>
                            <th width="20%" class="py-3 px-4">PENGIRIM & KONTAK</th>
                            <th width="35%" class="py-3 px-4">ISI LAPORAN & CATATAN ADMIN</th>
                            <th width="12%" class="py-3 px-4 text-center">FOTO BUKTI CS</th>
                            <th width="13%" class="py-3 px-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php foreach ($csReports as $idx => $cs): ?>
                            <?php
                                $cleanHp = preg_replace('/[^0-9]/', '', $cs['kontak_hp'] ?? '');
                                if (substr($cleanHp, 0, 1) === '0') {
                                    $cleanHp = '62' . substr($cleanHp, 1);
                                }
                                $fotos = json_decode($cs['foto_lampiran'] ?? '[]', true) ?: [];
                            ?>
                            <tr class="cs-detail-row hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-3 text-center font-bold text-slate-400"><?= $idx + 1 ?></td>
                                <td class="py-3.5 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar-days text-slate-400 text-xs"></i>
                                        <span><?= date('d M Y', strtotime($cs['created_at'])) ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5 flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        <span><?= date('H:i', strtotime($cs['created_at'])) ?> WIB</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-heading font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-user text-emerald-600 text-[10px]"></i>
                                        <span><?= esc($cs['nama_pengirim']) ?></span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 mt-1">
                                        <?php if (!empty($cs['kategori'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-bold border border-emerald-200/70">
                                                <i class="fa-solid fa-tag text-[8px]"></i>
                                                <?= esc($cs['kategori']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($cs['kontak_hp'])): ?>
                                            <a href="https://wa.me/<?= $cleanHp ?>?text=Halo%20<?= urlencode($cs['nama_pengirim']) ?>,%20terkait%20laporan%20kebersihan%20di%20<?= urlencode($wilayah['nama_wilayah']) ?>" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100/70 hover:bg-emerald-200 text-emerald-800 text-[10px] font-mono font-bold transition shadow-2xs" title="Chat WhatsApp">
                                                <i class="fa-brands fa-whatsapp text-emerald-600 text-[10px]"></i>
                                                <span><?= esc($cs['kontak_hp']) ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-xs font-medium leading-relaxed shadow-2xs">
                                        "<?= esc($cs['isi_laporan']) ?>"
                                    </div>
                                    <?php if (!empty($cs['tanggapan_admin'])): ?>
                                        <div class="mt-2 p-2.5 rounded-xl bg-emerald-50/90 border border-emerald-200 text-emerald-950 text-[11px] font-semibold space-y-0.5 shadow-2xs">
                                            <div class="text-[10px] font-extrabold text-emerald-800 flex items-center gap-1 uppercase tracking-wider">
                                                <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i> Tanggapan / Tindak Lanjut Admin:
                                            </div>
                                            <p class="pl-3.5 text-slate-700 font-medium leading-relaxed">
                                                <?= esc($cs['tanggapan_admin']) ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($fotos)): ?>
                                        <div class="flex flex-wrap items-center justify-center gap-1.5">
                                            <?php foreach ($fotos as $f): ?>
                                                <?php 
                                                    $imgUrl = (strpos($f, 'http://') === 0 || strpos($f, 'https://') === 0) ? $f : base_url('uploads/cs/' . $f);
                                                ?>
                                                <div class="group relative w-12 h-12 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 cursor-pointer shadow-2xs hover:border-emerald-500 transition" onclick="openLightbox('<?= esc($imgUrl) ?>')" title="Klik untuk perbesar">
                                                    <img src="<?= esc($imgUrl) ?>" alt="Bukti Kendala" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[10px]">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="inline-block mt-1 text-[9px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                            <?= count($fotos) ?> Foto
                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic font-medium">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <?php if ($cs['status'] === 'Baru'): ?>
                                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 text-xs font-extrabold border border-emerald-300 inline-flex items-center gap-1.5 shadow-2xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                                            Baru
                                        </span>
                                    <?php elseif ($cs['status'] === 'Diproses'): ?>
                                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-200 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-hourglass-half text-amber-600 text-[10px]"></i>
                                            Diproses
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-extrabold border border-slate-200 inline-flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                            Selesai
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-cs-wilayah">
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span id="page-info-cs-wilayah">Menampilkan 0 data</span>
                    <select id="pageSize-cs-wilayah" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                        <option value="5" selected>5 / hal</option>
                        <option value="10">10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </div>
                <div class="flex items-center gap-1.5" id="page-buttons-cs-wilayah"></div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Upload Foto Master Wilayah -->
<div id="modalUploadFoto" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up text-emerald-600"></i> Unggah Foto Master Wilayah
            </h3>
            <button onclick="closeModalUploadFoto()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('wilayah/upload-foto/' . $wilayah['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Foto (Bisa > 1 File)</label>
                <input type="file" name="foto_wilayah[]" multiple accept="image/*" required class="w-full px-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition shadow-2xs cursor-pointer">
                <p class="text-[11px] text-slate-400 font-medium mt-1">Foto akan diunggah dan disimpan di Cloudinary.</p>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalUploadFoto()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Unggah Foto</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Shift Penugasan Unit -->
<div id="modalTambahPenugasan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-teal-600"></i> Plotting Penugasan Shift Unit
            </h3>
            <button onclick="closeModalTambahPenugasan()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('wilayah/penugasan/store/' . $wilayah['id']) ?>" method="POST" class="space-y-4">
            <!-- Searchable Unit Picker for Plotting Shift -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Pilih Unit Penanggung Jawab <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="tambah_penugasan_unit_id" name="unit_id" required value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="tambah_penugasan_unit_search" placeholder="Cari nama unit, tipe asrama/sekolah..." autocomplete="off" onfocus="openPenugasanUnitDropdown()" oninput="filterPenugasanUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                    <button type="button" onclick="togglePenugasanUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="penugasanUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="penugasanUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <?php foreach ($unitsList as $un): ?>
                        <div class="penugasan-unit-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $un['id'] ?>" data-name="<?= esc($un['nama_unit']) ?> (<?= esc($un['tipe']) ?>)" onclick="selectPenugasanUnit(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($un['nama_unit']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold border border-emerald-200/60"><?= esc($un['tipe']) ?></span>
                                    <?php if (!empty($un['pj_nama'])): ?>
                                        <span>&bull;</span>
                                        <span>PJ: <?= esc($un['pj_nama']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noPenugasanUnitFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan unit kebersihan yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Shift Kerja</label>
                    <select name="shift" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Pagi">🌅 Shift Pagi</option>
                        <option value="Siang">☀️ Shift Siang</option>
                        <option value="Sore">🌇 Shift Sore</option>
                        <option value="Malam">🌙 Shift Malam</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Hari Aktif / Frekuensi</label>
                    <select name="hari_aktif" onchange="toggleCustomDays(this, 'custom_days_tambah_penugasan')" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Setiap Hari">Setiap Hari (Senin s/d Ahad)</option>
                        <option value="Senin - Jumat">Senin - Jumat (Hari Sekolah/Kerja)</option>
                        <option value="Sabtu & Ahad">Sabtu & Ahad (Weekend)</option>
                        <option value="Jumat Bersih">Jumat Bersih (Seminggu Sekali)</option>
                        <option value="Ahad Bersih">Ahad Bersih (Seminggu Sekali)</option>
                        <option value="Custom">Pilih Hari Tertentu (Kustom)...</option>
                    </select>
                </div>
            </div>

            <div id="custom_days_tambah_penugasan" class="hidden p-3 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="text-[10px] font-bold text-slate-500 uppercase">Centang hari aktif jadwal tugas ini:</div>
                <div class="grid grid-cols-4 sm:grid-cols-7 gap-1.5 text-xs font-extrabold text-slate-700">
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Senin" class="rounded text-emerald-600"> Sen</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Selasa" class="rounded text-emerald-600"> Sel</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Rabu" class="rounded text-emerald-600"> Rab</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Kamis" class="rounded text-emerald-600"> Kam</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Jumat" class="rounded text-emerald-600"> Jum</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Sabtu" class="rounded text-emerald-600"> Sab</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Ahad" class="rounded text-emerald-600"> Ahd</label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="06:00" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="07:30" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan / Jobdesk Khusus (Opsional)</label>
                <input type="text" name="keterangan" placeholder="Contoh: Fokus penyapuan lapangan dan pembersihan parit luar" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahPenugasan()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 text-white text-xs font-extrabold hover:from-teal-700 hover:to-emerald-700 shadow-md shadow-teal-600/20 transition">Simpan Shift</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Shift Penugasan Unit -->
<div id="modalEditPenugasan" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Edit Penugasan Shift Unit
            </h3>
            <button onclick="closeModalEditPenugasan()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formEditPenugasan" action="" method="POST" class="space-y-4">
            <!-- Searchable Unit Picker for Edit Shift -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Pilih Unit Penanggung Jawab <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                        Bisa dicari
                    </span>
                </label>
                <input type="hidden" id="edit_penugasan_unit_id" name="unit_id" required value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="edit_penugasan_unit_search" placeholder="Cari nama unit, tipe asrama/sekolah..." autocomplete="off" onfocus="openEditPenugasanUnitDropdown(); this.select();" oninput="filterEditPenugasanUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                    <button type="button" onclick="toggleEditPenugasanUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="editPenugasanUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="editPenugasanUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <?php foreach ($unitsList as $un): ?>
                        <div class="edit-penugasan-unit-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $un['id'] ?>" data-name="<?= esc($un['nama_unit']) ?> (<?= esc($un['tipe']) ?>)" onclick="selectEditPenugasanUnit(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($un['nama_unit']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold border border-emerald-200/60"><?= esc($un['tipe']) ?></span>
                                    <?php if (!empty($un['pj_nama'])): ?>
                                        <span>&bull;</span>
                                        <span>PJ: <?= esc($un['pj_nama']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noEditPenugasanUnitFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan unit kebersihan yang sesuai.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Shift Kerja</label>
                    <select name="shift" id="edit_penugasan_shift" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Pagi">🌅 Shift Pagi</option>
                        <option value="Siang">☀️ Shift Siang</option>
                        <option value="Sore">🌇 Shift Sore</option>
                        <option value="Malam">🌙 Shift Malam</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Hari Aktif / Frekuensi</label>
                    <select name="hari_aktif" id="edit_penugasan_hari" onchange="toggleCustomDays(this, 'custom_days_edit_penugasan')" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <option value="Setiap Hari">Setiap Hari (Senin s/d Ahad)</option>
                        <option value="Senin - Jumat">Senin - Jumat (Hari Sekolah/Kerja)</option>
                        <option value="Sabtu & Ahad">Sabtu & Ahad (Weekend)</option>
                        <option value="Jumat Bersih">Jumat Bersih (Seminggu Sekali)</option>
                        <option value="Ahad Bersih">Ahad Bersih (Seminggu Sekali)</option>
                        <option value="Custom">Pilih Hari Tertentu (Kustom)...</option>
                    </select>
                </div>
            </div>

            <div id="custom_days_edit_penugasan" class="hidden p-3 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="text-[10px] font-bold text-slate-500 uppercase">Centang hari aktif jadwal tugas ini:</div>
                <div class="grid grid-cols-4 sm:grid-cols-7 gap-1.5 text-xs font-extrabold text-slate-700">
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Senin" class="edit-hari-cb rounded text-emerald-600"> Sen</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Selasa" class="edit-hari-cb rounded text-emerald-600"> Sel</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Rabu" class="edit-hari-cb rounded text-emerald-600"> Rab</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Kamis" class="edit-hari-cb rounded text-emerald-600"> Kam</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Jumat" class="edit-hari-cb rounded text-emerald-600"> Jum</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Sabtu" class="edit-hari-cb rounded text-emerald-600"> Sab</label>
                    <label class="flex items-center gap-1 cursor-pointer"><input type="checkbox" name="hari_custom[]" value="Ahad" class="edit-hari-cb rounded text-emerald-600"> Ahd</label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="edit_penugasan_jam_mulai" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="edit_penugasan_jam_selesai" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan / Jobdesk Khusus (Opsional)</label>
                <input type="text" name="keterangan" id="edit_penugasan_keterangan" placeholder="Contoh: Fokus penyapuan lapangan dan pembersihan parit luar" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEditPenugasan()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-extrabold hover:from-amber-600 hover:to-amber-700 shadow-md shadow-amber-500/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Data Wilayah -->
<div id="modalEditWilayah" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg sm:text-xl text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Edit Data Wilayah Kebersihan
            </h3>
            <button onclick="closeModalEditWilayah()" class="w-9 h-9 rounded-2xl bg-slate-100 text-slate-400 hover:text-slate-700 hover:bg-slate-200 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="<?= base_url('wilayah/update/' . $wilayah['id']) ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Wilayah <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_wilayah" value="<?= esc($wilayah['nama_wilayah']) ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Area</label>
                    <select name="kategori_area" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <?php
                            $kats = ['Lapangan & Outdoor', 'Tempat Ibadah & Selasar', 'Gedung Sekolah & Kelas', 'Asrama & Kamar Mandi', 'Dapur & Kantin', 'Jalan & Saluran Air', 'Lainnya'];
                            foreach ($kats as $k):
                        ?>
                            <option value="<?= $k ?>" <?= $wilayah['kategori_area'] === $k ? 'selected' : '' ?>><?= $k ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kode Wilayah</label>
                    <input type="text" name="kode_wilayah" value="<?= esc($wilayah['kode_wilayah']) ?>" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="relative">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Lokasi Komplek</span>
                        <span class="text-[10px] text-emerald-600 font-bold lowercase bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 flex items-center gap-1">
                           Bisa dicari
                        </span>
                    </label>
                    <input type="hidden" id="edit_wilayah_lokasi_gedung" name="lokasi_gedung" value="<?= esc($wilayah['lokasi_gedung'] ?? '') ?>">
                    <div class="relative">
                        <i class="fa-solid fa-building text-emerald-600 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs pointer-events-none"></i>
                        <input type="text" id="edit_wilayah_lokasi_search" value="<?= esc($wilayah['lokasi_gedung'] ?? '') ?>" placeholder="Cari komplek / unit / gedung..." autocomplete="off" onfocus="openEditWilayahLokasiDropdown(); this.select();" oninput="filterEditWilayahLokasiOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer placeholder-slate-400">
                        <button type="button" onclick="toggleEditWilayahLokasiDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                            <i id="editWilayahLokasiIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                        </button>
                    </div>
                    <!-- Dropdown List -->
                    <div id="editWilayahLokasiDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-56 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                        <div class="edit-wilayah-lokasi-item px-4 py-2 hover:bg-slate-50 transition flex items-center justify-between cursor-pointer text-slate-400 italic text-xs font-medium" data-nama="" onclick="selectEditWilayahLokasi(this)">
                            <span>-- Tanpa Gedung Khusus / Umum --</span>
                        </div>
                        <?php if (!empty($unitsList)): ?>
                            <?php foreach ($unitsList as $u): ?>
                                <div class="edit-wilayah-lokasi-item px-4 py-2.5 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-nama="<?= esc($u['nama_unit']) ?>" onclick="selectEditWilayahLokasi(this)">
                                    <div>
                                        <div class="font-extrabold text-xs text-slate-900"><?= esc($u['nama_unit']) ?></div>
                                        <div class="text-[10px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                                            <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-bold border border-slate-200/60"><?= esc($u['tipe']) ?></span>
                                            <?php if (!empty($u['kode_unit'])): ?>
                                                <span>&bull;</span>
                                                <span class="font-mono text-slate-400"><?= esc($u['kode_unit']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-300 group-hover:text-emerald-600"><i class="fa-solid fa-check text-[10px]"></i></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div id="noEditWilayahLokasiFound" class="px-4 py-3 text-center text-slate-400 text-xs italic font-medium hidden">
                            Tidak ditemukan unit yang sesuai.
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Luas Area</label>
                    <input type="text" name="luas_area" value="<?= esc($wilayah['luas_area']) ?>" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi & Batasan Area</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs"><?= esc($wilayah['deskripsi']) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Wilayah</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="Aktif" <?= $wilayah['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Perbaikan" <?= $wilayah['status'] === 'Perbaikan' ? 'selected' : '' ?>>Sedang Renovasi / Perbaikan</option>
                    <option value="Non-Aktif" <?= $wilayah['status'] === 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEditWilayah()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Lightbox Modal Preview Foto Penuh -->
<div id="lightboxModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden flex items-center justify-center p-4 cursor-pointer" onclick="closeLightbox()">
    <div class="max-w-4xl max-h-[90vh] relative" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="Preview Foto" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain mx-auto">
        <button onclick="closeLightbox()" class="absolute -top-3 -right-3 w-9 h-9 rounded-full bg-white text-slate-800 flex items-center justify-center shadow-lg text-sm font-bold">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>

<script>
    function openModalUploadFoto() {
        const modal = document.getElementById('modalUploadFoto');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalUploadFoto = openModalUploadFoto;

    function closeModalUploadFoto() {
        const modal = document.getElementById('modalUploadFoto');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalUploadFoto = closeModalUploadFoto;

    function openModalTambahPenugasan() {
        const modal = document.getElementById('modalTambahPenugasan');
        if (modal) {
            // Reset input values
            const hiddenId = document.getElementById('tambah_penugasan_unit_id');
            const searchInput = document.getElementById('tambah_penugasan_unit_search');
            if (hiddenId) hiddenId.value = '';
            if (searchInput) searchInput.value = '';
            filterPenugasanUnitOptions('');
            closePenugasanUnitDropdown();
            modal.classList.remove('hidden');
        }
    }
    window.openModalTambahPenugasan = openModalTambahPenugasan;

    function closeModalTambahPenugasan() {
        const modal = document.getElementById('modalTambahPenugasan');
        if (modal) {
            closePenugasanUnitDropdown();
            modal.classList.add('hidden');
        }
    }
    window.closeModalTambahPenugasan = closeModalTambahPenugasan;

    function toggleCustomDays(selectEl, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        if (selectEl.value === 'Custom') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
    window.toggleCustomDays = toggleCustomDays;

    // Searchable Penugasan Unit Picker Logic (Tambah)
    function openPenugasanUnitDropdown() {
        const list = document.getElementById('penugasanUnitDropdownList');
        const icon = document.getElementById('penugasanUnitIcon');
        if (list) list.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    }
    window.openPenugasanUnitDropdown = openPenugasanUnitDropdown;

    function closePenugasanUnitDropdown() {
        const list = document.getElementById('penugasanUnitDropdownList');
        const icon = document.getElementById('penugasanUnitIcon');
        if (list) list.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.closePenugasanUnitDropdown = closePenugasanUnitDropdown;

    function togglePenugasanUnitDropdown() {
        const list = document.getElementById('penugasanUnitDropdownList');
        if (list && list.classList.contains('hidden')) {
            openPenugasanUnitDropdown();
        } else {
            closePenugasanUnitDropdown();
        }
    }
    window.togglePenugasanUnitDropdown = togglePenugasanUnitDropdown;

    function filterPenugasanUnitOptions(query) {
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.penugasan-unit-item');
        let visibleCount = 0;

        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noFound = document.getElementById('noPenugasanUnitFound');
        if (noFound) {
            if (visibleCount === 0) {
                noFound.classList.remove('hidden');
            } else {
                noFound.classList.add('hidden');
            }
        }
    }
    window.filterPenugasanUnitOptions = filterPenugasanUnitOptions;

    function selectPenugasanUnit(el) {
        const id = el.getAttribute('data-id') || '';
        const name = el.getAttribute('data-name') || '';

        const hiddenInput = document.getElementById('tambah_penugasan_unit_id');
        const searchInput = document.getElementById('tambah_penugasan_unit_search');

        if (hiddenInput) hiddenInput.value = id;
        if (searchInput) searchInput.value = name;

        closePenugasanUnitDropdown();
    }
    window.selectPenugasanUnit = selectPenugasanUnit;

    // Searchable Penugasan Unit Picker Logic (Edit)
    function openModalEditPenugasan(item) {
        const form = document.getElementById('formEditPenugasan');
        if (form) form.action = '<?= base_url('wilayah/penugasan/update') ?>/' + item.id;

        const hiddenId = document.getElementById('edit_penugasan_unit_id');
        const searchInput = document.getElementById('edit_penugasan_unit_search');
        if (hiddenId) hiddenId.value = item.unit_id || '';
        if (searchInput) searchInput.value = item.nama_unit ? (item.nama_unit + (item.tipe_unit ? ' (' + item.tipe_unit + ')' : '')) : '';

        const shiftEl = document.getElementById('edit_penugasan_shift');
        if (shiftEl) shiftEl.value = item.shift || 'Pagi';

        const hariEl = document.getElementById('edit_penugasan_hari');
        const customBox = document.getElementById('custom_days_edit_penugasan');
        const standardOptions = ['Setiap Hari', 'Senin - Jumat', 'Sabtu & Ahad', 'Jumat Bersih', 'Ahad Bersih'];
        
        if (hariEl) {
            const hVal = item.hari_aktif || 'Setiap Hari';
            if (standardOptions.includes(hVal)) {
                hariEl.value = hVal;
                if (customBox) customBox.classList.add('hidden');
            } else {
                hariEl.value = 'Custom';
                if (customBox) {
                    customBox.classList.remove('hidden');
                    const cbs = customBox.querySelectorAll('.edit-hari-cb');
                    cbs.forEach(cb => {
                        cb.checked = hVal.toLowerCase().includes(cb.value.toLowerCase());
                    });
                }
            }
        }

        const jamMulaiEl = document.getElementById('edit_penugasan_jam_mulai');
        if (jamMulaiEl) jamMulaiEl.value = item.jam_mulai || '06:00';

        const jamSelesaiEl = document.getElementById('edit_penugasan_jam_selesai');
        if (jamSelesaiEl) jamSelesaiEl.value = item.jam_selesai || '07:30';

        const ketEl = document.getElementById('edit_penugasan_keterangan');
        if (ketEl) ketEl.value = item.keterangan || '';

        closeEditPenugasanUnitDropdown();
        filterEditPenugasanUnitOptions('');

        const modal = document.getElementById('modalEditPenugasan');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalEditPenugasan = openModalEditPenugasan;

    function closeModalEditPenugasan() {
        const modal = document.getElementById('modalEditPenugasan');
        if (modal) {
            closeEditPenugasanUnitDropdown();
            modal.classList.add('hidden');
        }
    }
    window.closeModalEditPenugasan = closeModalEditPenugasan;

    function openEditPenugasanUnitDropdown() {
        const list = document.getElementById('editPenugasanUnitDropdownList');
        const icon = document.getElementById('editPenugasanUnitIcon');
        if (list) {
            list.classList.remove('hidden');
            const items = document.querySelectorAll('.edit-penugasan-unit-item');
            items.forEach(item => item.style.display = 'flex');
            const noFound = document.getElementById('noEditPenugasanUnitFound');
            if (noFound) noFound.classList.add('hidden');
        }
        if (icon) icon.classList.add('rotate-180');
    }
    window.openEditPenugasanUnitDropdown = openEditPenugasanUnitDropdown;

    function closeEditPenugasanUnitDropdown() {
        const list = document.getElementById('editPenugasanUnitDropdownList');
        const icon = document.getElementById('editPenugasanUnitIcon');
        if (list) list.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.closeEditPenugasanUnitDropdown = closeEditPenugasanUnitDropdown;

    function toggleEditPenugasanUnitDropdown() {
        const list = document.getElementById('editPenugasanUnitDropdownList');
        if (list && list.classList.contains('hidden')) {
            openEditPenugasanUnitDropdown();
        } else {
            closeEditPenugasanUnitDropdown();
        }
    }
    window.toggleEditPenugasanUnitDropdown = toggleEditPenugasanUnitDropdown;

    function filterEditPenugasanUnitOptions(query) {
        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.edit-penugasan-unit-item');
        let visibleCount = 0;

        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noFound = document.getElementById('noEditPenugasanUnitFound');
        if (noFound) {
            if (visibleCount === 0) {
                noFound.classList.remove('hidden');
            } else {
                noFound.classList.add('hidden');
            }
        }
    }
    window.filterEditPenugasanUnitOptions = filterEditPenugasanUnitOptions;

    function selectEditPenugasanUnit(el) {
        const id = el.getAttribute('data-id') || '';
        const name = el.getAttribute('data-name') || '';

        const hiddenInput = document.getElementById('edit_penugasan_unit_id');
        const searchInput = document.getElementById('edit_penugasan_unit_search');

        if (hiddenInput) hiddenInput.value = id;
        if (searchInput) searchInput.value = name;

        closeEditPenugasanUnitDropdown();
    }
    window.selectEditPenugasanUnit = selectEditPenugasanUnit;

    // Searchable Lokasi Wilayah Dropdown in Edit Modal
    function openEditWilayahLokasiDropdown() {
        const dd = document.getElementById('editWilayahLokasiDropdownList');
        const icon = document.getElementById('editWilayahLokasiIcon');
        if (dd) {
            dd.classList.remove('hidden');
            // Tampilkan SEMUA pilihan secara lengkap saat dibuka
            const items = document.querySelectorAll('.edit-wilayah-lokasi-item');
            items.forEach(item => item.style.display = 'flex');
            const noFound = document.getElementById('noEditWilayahLokasiFound');
            if (noFound) noFound.classList.add('hidden');
        }
        if (icon) icon.classList.add('rotate-180');
    }
    window.openEditWilayahLokasiDropdown = openEditWilayahLokasiDropdown;

    function closeEditWilayahLokasiDropdown() {
        const dd = document.getElementById('editWilayahLokasiDropdownList');
        const icon = document.getElementById('editWilayahLokasiIcon');
        if (dd) dd.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
    window.closeEditWilayahLokasiDropdown = closeEditWilayahLokasiDropdown;

    function toggleEditWilayahLokasiDropdown() {
        const dd = document.getElementById('editWilayahLokasiDropdownList');
        if (dd && dd.classList.contains('hidden')) {
            openEditWilayahLokasiDropdown();
        } else if (dd) {
            closeEditWilayahLokasiDropdown();
        }
    }
    window.toggleEditWilayahLokasiDropdown = toggleEditWilayahLokasiDropdown;

    function filterEditWilayahLokasiOptions(query) {
        const hiddenInput = document.getElementById('edit_wilayah_lokasi_gedung');
        if (hiddenInput) hiddenInput.value = query;

        query = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.edit-wilayah-lokasi-item');
        let visibleCount = 0;

        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            const nama = (item.getAttribute('data-nama') || '').toLowerCase();
            if (!query || text.includes(query) || nama.includes(query) || item.getAttribute('data-nama') === '') {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noFound = document.getElementById('noEditWilayahLokasiFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0);
        }
    }
    window.filterEditWilayahLokasiOptions = filterEditWilayahLokasiOptions;

    function selectEditWilayahLokasi(el) {
        const nama = el.getAttribute('data-nama') || '';
        const hiddenInput = document.getElementById('edit_wilayah_lokasi_gedung');
        const searchInput = document.getElementById('edit_wilayah_lokasi_search');

        if (hiddenInput) hiddenInput.value = nama;
        if (searchInput) searchInput.value = nama;

        closeEditWilayahLokasiDropdown();
    }
    window.selectEditWilayahLokasi = selectEditWilayahLokasi;

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('penugasanUnitDropdownList');
        const searchInput = document.getElementById('tambah_penugasan_unit_search');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!dropdown.contains(e.target) && e.target !== searchInput && !e.target.closest('#penugasanUnitIcon')) {
                closePenugasanUnitDropdown();
            }
        }

        const editDropdown = document.getElementById('editPenugasanUnitDropdownList');
        const editSearchInput = document.getElementById('edit_penugasan_unit_search');
        if (editDropdown && !editDropdown.classList.contains('hidden')) {
            if (!editDropdown.contains(e.target) && e.target !== editSearchInput && !e.target.closest('#editPenugasanUnitIcon')) {
                closeEditPenugasanUnitDropdown();
            }
        }

        const lokasiDropdown = document.getElementById('editWilayahLokasiDropdownList');
        const lokasiSearchInput = document.getElementById('edit_wilayah_lokasi_search');
        if (lokasiDropdown && !lokasiDropdown.classList.contains('hidden')) {
            if (!lokasiDropdown.contains(e.target) && e.target !== lokasiSearchInput && !e.target.closest('#editWilayahLokasiIcon')) {
                closeEditWilayahLokasiDropdown();
            }
        }
    });

    function openModalEditWilayah() {
        const modal = document.getElementById('modalEditWilayah');
        if (modal) modal.classList.remove('hidden');
    }
    window.openModalEditWilayah = openModalEditWilayah;

    function closeModalEditWilayah() {
        const modal = document.getElementById('modalEditWilayah');
        if (modal) modal.classList.add('hidden');
    }
    window.closeModalEditWilayah = closeModalEditWilayah;

    function openLightbox(url) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        if (modal && img) {
            img.src = url;
            modal.classList.remove('hidden');
        }
    }
    window.openLightbox = openLightbox;

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        if (modal) modal.classList.add('hidden');
    }
    window.closeLightbox = closeLightbox;

    // CS Wilayah Detail Paginator & Filter
    var paginatorCsWilayah;
    function initCsWilayahPaginator() {
        if (document.getElementById('tableCsWilayahDetail') && typeof TablePaginator !== 'undefined') {
            paginatorCsWilayah = new TablePaginator('tableCsWilayahDetail', 'page-info-cs-wilayah', 'page-buttons-cs-wilayah', 'pageSize-cs-wilayah');
            paginatorCsWilayah.render();
        }
    }

    function filterCsDetailTable() {
        const input = document.getElementById('searchCsDetailInput');
        const query = (input ? input.value : '').toLowerCase().trim();
        const rows = document.querySelectorAll('#tableCsWilayahDetail tbody tr');

        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                delete r.dataset.searchFiltered;
            } else {
                r.dataset.searchFiltered = 'false';
            }
        });

        if (paginatorCsWilayah) {
            paginatorCsWilayah.currentPage = 1;
            paginatorCsWilayah.render();
        }
    }
    window.filterCsDetailTable = filterCsDetailTable;

    document.addEventListener('DOMContentLoaded', function() {
        initCsWilayahPaginator();
    });
</script>
<?= $this->endSection() ?>
