<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Hero Banner / Page Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white p-8 sm:p-10 shadow-2xl shadow-emerald-900/20 border border-emerald-600/30">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-user-shield text-[240px]"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-bold uppercase tracking-wider border border-emerald-400/30">
                    <i class="fa-solid fa-user-shield"></i> Manajemen Hak Akses & Multi-Role System
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                    Kelola Akun & Profil Pengguna
                </h1>
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                    Admin dapat mendaftarkan akun untuk Pengurus, Kader, dan Auditor. Pendaftaran akun secara mandiri ditutup untuk keamanan.
                </p>
            </div>

            <?php if (session()->get('role') === 'Admin'): ?>
            <div class="flex-shrink-0">
                <button type="button" onclick="openModalTambahUser()" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white text-emerald-900 font-heading font-bold text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <span>Daftarkan Akun Baru</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php 
        $userRole = session()->get('role');
        $isAdmin = ($userRole === 'Admin');
        $tabParam = service('request')->getGet('tab') ?? ($_GET['tab'] ?? '');
        $activeTab = ($isAdmin && $tabParam === 'kelola_users') ? 'kelola_users' : 'profil_saya';
    ?>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2 overflow-x-auto">
        <button type="button" onclick="switchProfilTab('tab_profil_saya')" id="btn_tab_profil_saya" class="px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2 <?= $activeTab === 'profil_saya' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' ?>">
            <i class="fa-solid fa-user-gear"></i>
            <span>Profil & Keamanan Saya</span>
        </button>

        <?php if ($isAdmin): ?>
        <button type="button" onclick="switchProfilTab('tab_kelola_users')" id="btn_tab_kelola_users" class="px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2 <?= $activeTab === 'kelola_users' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' ?>">
            <i class="fa-solid fa-users-gear"></i>
            <span>Manajemen Pengguna Sistem (<?= count($usersList) ?>)</span>
        </button>
        <?php endif; ?>
    </div>

    <!-- TAB 1: PROFIL & KEAMANAN SAYA (Semua Role: Admin, Auditor, Pengurus, Kader) -->
    <div id="tab_profil_saya" class="<?= $activeTab === 'profil_saya' ? '' : 'hidden' ?> space-y-6 animate-fadeIn">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Card 1: Informasi Profil Akun -->
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
                <div class="flex items-center gap-3.5 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-xl font-heading font-black shadow-lg shadow-emerald-500/20 flex-shrink-0">
                        <?= esc(substr($currentUser['nama_lengkap'] ?? session()->get('nama_lengkap') ?? 'U', 0, 1)) ?>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-slate-900">
                            Informasi Akun Saya
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Perbarui data nama lengkap atau username akun login Anda.</p>
                    </div>
                </div>

                <form action="<?= base_url('profil/update-me') ?>" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= esc($currentUser['nama_lengkap'] ?? session()->get('nama_lengkap')) ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Username (ID Login)</label>
                        <input type="text" name="username" value="<?= esc($currentUser['username'] ?? session()->get('username')) ?>" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-mono font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-1">
                        <div>
                            <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Role Hak Akses</label>
                            <div class="px-3.5 py-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-xs font-extrabold text-slate-700 flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                <span><?= esc(session()->get('role')) ?></span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Unit Kerja / Instansi</label>
                            <div class="px-3.5 py-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 truncate" title="<?= esc($currentUserUnit['nama_unit'] ?? 'Pengurus Pusat') ?>">
                                <i class="fa-solid fa-building text-teal-600 mr-1"></i>
                                <span><?= esc($currentUserUnit['nama_unit'] ?? 'Pengurus Pusat') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 px-5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-extrabold text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan Profil</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card 2: Form Ganti Password Mandiri -->
            <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
                <div class="flex items-center gap-3.5 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center text-xl shadow-lg shadow-amber-500/20 flex-shrink-0">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-slate-900">
                            Ganti Password Akun
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Ubah kata sandi login akun Anda secara mandiri.</p>
                    </div>
                </div>

                <form action="<?= base_url('profil/change-password') ?>" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Password Saat Ini (Lama)</label>
                        <div class="relative">
                            <input type="password" id="self_old_password" name="old_password" placeholder="Masukkan password lama..." required class="w-full px-4 py-2.5 pr-10 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <button type="button" onclick="togglePasswordVisibility('self_old_password', 'icon_self_old_pwd')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i id="icon_self_old_pwd" class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru (Min. 4 Karakter)</label>
                        <div class="relative">
                            <input type="password" id="self_new_password" name="new_password" minlength="4" placeholder="Masukkan password baru..." required class="w-full px-4 py-2.5 pr-10 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <button type="button" onclick="togglePasswordVisibility('self_new_password', 'icon_self_new_pwd')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i id="icon_self_new_pwd" class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="self_confirm_password" name="confirm_password" minlength="4" placeholder="Ulangi password baru..." required class="w-full px-4 py-2.5 pr-10 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                            <button type="button" onclick="togglePasswordVisibility('self_confirm_password', 'icon_self_confirm_pwd')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i id="icon_self_confirm_pwd" class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 px-5 rounded-2xl bg-gradient-to-r from-amber-600 to-rose-600 text-white font-heading font-extrabold text-xs hover:from-amber-700 hover:to-rose-700 transition shadow-md shadow-amber-600/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Perbarui Password Sekarang</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TAB 2: MANAJEMEN PENGGUNA (Admin Only) -->
    <div id="tab_kelola_users" class="<?= $activeTab === 'kelola_users' ? '' : 'hidden' ?> space-y-6 animate-fadeIn">
    <!-- Table Accounts List -->
    <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-xl shadow-slate-200/40 border border-slate-200/80 bg-white space-y-5">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center text-sm shadow-2xs">
                    <i class="fa-solid fa-users-gear"></i>
                </span>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-heading font-extrabold text-lg text-slate-900">
                            Daftar Akun Pengguna Terdaftar
                        </h3>
                        <span class="text-xs font-extrabold text-slate-600 bg-slate-100 border border-slate-200/60 px-2.5 py-0.5 rounded-full">
                            <?= count($usersList) ?> Akun
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">Kelola akun, role hak akses, dan tautan unit kerja pengurus.</p>
                </div>
            </div>

            <!-- Search Input for Users -->
            <div class="relative w-full sm:w-72">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" id="searchUserInput" onkeyup="filterUserTable()" placeholder="Cari nama / username / role / unit..." class="w-full pl-9 pr-4 py-2 rounded-2xl border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition shadow-2xs">
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
            <table class="w-full text-left text-xs font-semibold" id="tableUserAccounts">
                <thead class="bg-slate-100/90 text-slate-700 font-heading font-extrabold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th width="4%" class="py-3.5 px-3 text-center">NO</th>
                        <th width="18%" class="py-3.5 px-4">USERNAME</th>
                        <th width="28%" class="py-3.5 px-4">NAMA LENGKAP</th>
                        <th width="16%" class="py-3.5 px-4 text-center">ROLE AKSES</th>
                        <th width="<?= (session()->get('role') === 'Admin') ? '24%' : '34%' ?>" class="py-3.5 px-4">UNIT / INSTANSI</th>
                        <?php if (session()->get('role') === 'Admin'): ?>
                            <th width="10%" class="py-3.5 px-3 text-center">AKSI</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php if (!empty($usersList)): ?>
                        <?php foreach ($usersList as $idx => $u): ?>
                            <tr class="user-row hover:bg-slate-50/90 transition-all">
                                <td class="py-3.5 px-3 text-center font-extrabold text-slate-400"><?= $idx + 1 ?></td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 font-mono font-extrabold border border-emerald-200/90 text-[11px] shadow-2xs">
                                        <i class="fa-solid fa-at text-[10px] text-emerald-600"></i>
                                        <?= esc($u['username']) ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center font-heading font-extrabold text-xs shadow-2xs uppercase flex-shrink-0
                                            <?= $u['role'] === 'Admin' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200/80' : '' ?>
                                            <?= $u['role'] === 'Auditor' ? 'bg-blue-100 text-blue-700 border border-blue-200/80' : '' ?>
                                            <?= $u['role'] === 'Pengurus' ? 'bg-purple-100 text-purple-700 border border-purple-200/80' : '' ?>
                                            <?= ($u['role'] !== 'Admin' && $u['role'] !== 'Auditor' && $u['role'] !== 'Pengurus') ? 'bg-teal-100 text-teal-700 border border-teal-200/80' : '' ?>">
                                            <?= esc(substr($u['nama_lengkap'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-xs tracking-tight"><?= esc($u['nama_lengkap']) ?></div>
                                            <div class="text-[10px] text-slate-400 font-medium">Terdaftar Sistem K3L</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <?php if ($u['role'] === 'Admin'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200/90 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Admin
                                        </span>
                                    <?php elseif ($u['role'] === 'Auditor'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-extrabold border border-blue-200/90 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Auditor
                                        </span>
                                    <?php elseif ($u['role'] === 'Pengurus'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-extrabold border border-purple-200/90 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            Pengurus
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-extrabold border border-teal-200/90 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                            Kader
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200/70">
                                        <i class="fa-solid fa-building-user text-slate-400 text-[11px]"></i>
                                        <span><?= esc($u['nama_unit'] ?: 'Gudang / Pusat K3L') ?></span>
                                    </div>
                                </td>
                                <?php if (session()->get('role') === 'Admin'): ?>
                                <td class="py-3.5 px-3 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button" onclick="openModalEditUser(<?= htmlspecialchars(json_encode($u)) ?>)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 border border-slate-200/70 flex items-center justify-center transition hover:scale-105 shadow-2xs" title="Edit Akun">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        <?php 
                                            $currentLoggedUserId = (int)(session()->get('userId') ?? session()->get('user_id') ?? 0);
                                        ?>
                                        <?php if ((int)$u['id'] !== $currentLoggedUserId): ?>
                                            <a href="<?= base_url('profil/delete/' . $u['id']) ?>" data-confirm-msg="Apakah Anda yakin ingin menghapus akun pengguna '<?= esc($u['nama_lengkap']) ?>'?" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/70 flex items-center justify-center transition hover:scale-105 shadow-2xs" title="Hapus Akun">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/70 flex items-center justify-center text-xs shadow-2xs cursor-default" title="Akun Anda Sedang Aktif (Tidak dapat menghapus akun sendiri)">
                                                <i class="fa-solid fa-shield-halved text-xs"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fa-solid fa-users-slash"></i>
                                </div>
                                <span class="font-bold text-xs">Belum ada akun pengguna yang terdaftar.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-3 border-t border-slate-100 px-1" id="pagination-container-user">
            <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                <span id="page-info-user">Menampilkan 0 data</span>
                <select id="pageSize-user" class="ml-2 px-2.5 py-1 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs">
                    <option value="5">5 / hal</option>
                    <option value="10" selected>10 / hal</option>
                    <option value="25">25 / hal</option>
                    <option value="50">50 / hal</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="page-buttons-user"></div>
        </div>
    </div>
</div>

<!-- Modal Tambah User Baru (Admin Only) -->
<div id="modalTambahUser" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-emerald-600"></i> Daftarkan Akun Pengguna Baru
            </h3>
            <button onclick="closeModalTambahUser()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('profil/store') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Pengguna</label>
                <input type="text" name="nama_lengkap" placeholder="Misal: Kang Ahmad / Ibu Halimah" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Username Login</label>
                    <input type="text" name="username" placeholder="ahmad123" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" id="add_password" name="password" placeholder="••••••••" required class="w-full pl-4 pr-10 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <button type="button" onclick="togglePasswordVisibility('add_password', 'toggle_add_pwd_icon')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs focus:outline-none transition" title="Lihat/Sembunyikan Sandi">
                            <i id="toggle_add_pwd_icon" class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Role Akses</label>
                <select name="role" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="Admin">Admin (Full Control)</option>
                    <option value="Auditor">Auditor (Read-Only)</option>
                    <option value="Pengurus" selected>Pengurus Unit (Mobile Frontend)</option>
                    <option value="Kader">Kader Kebersihan (Mobile Frontend)</option>
                </select>
            </div>

            <!-- Searchable Unit Picker for Modal Tambah User -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Tautkan Unit / Instansi (Opsional)</span>
                    <span class="text-[10px] text-slate-400 font-semibold lowercase">Bisa dicari</span>
                </label>
                <input type="hidden" id="add_user_unit_id" name="unit_id" value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="add_user_unit_search" placeholder="Cari asrama / unit / sekolah..." autocomplete="off" onfocus="openAddUserUnitDropdown()" oninput="filterAddUserUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                    <button type="button" onclick="toggleAddUserUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="addUserUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="addUserUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <div class="add-user-unit-item px-4 py-2 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer font-bold text-xs text-slate-500" data-id="" data-name="-- Tidak Ditautkan / Pusat K3L --" onclick="selectAddUserUnit(this)">
                        <span>-- Tidak Ditautkan / Pusat K3L --</span>
                    </div>
                    <?php foreach ($unitsList as $un): ?>
                        <div class="add-user-unit-item px-4 py-2 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $un['id'] ?>" data-name="<?= esc($un['nama_unit']) ?> (<?= esc($un['tipe']) ?>)" onclick="selectAddUserUnit(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($un['nama_unit']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold"><?= esc($un['tipe']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noAddUserUnitFound" class="px-4 py-4 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan unit yang sesuai.
                    </div>
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalTambahUser()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Daftarkan Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="modalEditUser" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-emerald-600"></i> Edit Akun Pengguna
            </h3>
            <button onclick="closeModalEditUser()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="formEditUser" action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Pengguna</label>
                <input type="text" id="edit_nama_lengkap" name="nama_lengkap" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Username Login</label>
                    <input type="text" id="edit_username" name="username" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Password</label>
                    <div class="relative">
                        <input type="password" id="edit_password" name="password" placeholder="Kosongkan jika tetap" class="w-full pl-4 pr-10 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                        <button type="button" onclick="togglePasswordVisibility('edit_password', 'toggle_edit_pwd_icon')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs focus:outline-none transition" title="Lihat/Sembunyikan Sandi">
                            <i id="toggle_edit_pwd_icon" class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Role Akses</label>
                <select id="edit_role" name="role" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="Admin">Admin (Full Control)</option>
                    <option value="Auditor">Auditor (Read-Only)</option>
                    <option value="Pengurus">Pengurus Unit (Mobile Frontend)</option>
                    <option value="Kader">Kader Kebersihan (Mobile Frontend)</option>
                </select>
            </div>

            <!-- Searchable Unit Picker for Modal Edit User -->
            <div class="relative">
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Tautkan Unit / Instansi</span>
                    <span class="text-[10px] text-slate-400 font-semibold lowercase">Bisa dicari</span>
                </label>
                <input type="hidden" id="edit_user_unit_id" name="unit_id" value="">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" id="edit_user_unit_search" placeholder="Cari asrama / unit / sekolah..." autocomplete="off" onfocus="openEditUserUnitDropdown()" oninput="filterEditUserUnitOptions(this.value)" class="w-full pl-9 pr-8 py-2.5 rounded-2xl border border-slate-200 text-xs font-bold bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition shadow-2xs cursor-pointer">
                    <button type="button" onclick="toggleEditUserUnitDropdown()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i id="editUserUnitIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>
                <!-- Dropdown List -->
                <div id="editUserUnitDropdownList" class="absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl shadow-2xl border border-slate-200 max-h-52 overflow-y-auto z-50 hidden divide-y divide-slate-100">
                    <div class="edit-user-unit-item px-4 py-2 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer font-bold text-xs text-slate-500" data-id="" data-name="-- Tidak Ditautkan / Pusat K3L --" onclick="selectEditUserUnit(this)">
                        <span>-- Tidak Ditautkan / Pusat K3L --</span>
                    </div>
                    <?php foreach ($unitsList as $un): ?>
                        <div class="edit-user-unit-item px-4 py-2 hover:bg-emerald-50 transition flex items-center justify-between cursor-pointer" data-id="<?= $un['id'] ?>" data-name="<?= esc($un['nama_unit']) ?> (<?= esc($un['tipe']) ?>)" onclick="selectEditUserUnit(this)">
                            <div>
                                <div class="font-extrabold text-xs text-slate-800"><?= esc($un['nama_unit']) ?></div>
                                <div class="text-[10px] text-slate-500 font-semibold"><?= esc($un['tipe']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div id="noEditUserUnitFound" class="px-4 py-4 text-center text-slate-400 text-xs italic font-medium hidden">
                        Tidak ditemukan unit yang sesuai.
                    </div>
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModalEditUser()" class="px-5 py-2.5 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-extrabold hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    var paginatorUser;

    function initUserPaginator() {
        if (typeof TablePaginator !== 'undefined' && document.getElementById('tableUserAccounts')) {
            if (!paginatorUser) {
                paginatorUser = new TablePaginator('tableUserAccounts', 'page-info-user', 'page-buttons-user', 'pageSize-user');
            }
            paginatorUser.render();
        }
    }
    window.initUserPaginator = initUserPaginator;
    window.rebindPageEvents = initUserPaginator;

    document.addEventListener('DOMContentLoaded', function() {
        initUserPaginator();
        const initialTab = "<?= $activeTab ?>";
        if (initialTab === 'kelola_users') {
            switchProfilTab('tab_kelola_users');
        }
    });

    function filterUserTable() {
        const input = document.getElementById('searchUserInput');
        if (!input) return;
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#tableUserAccounts tbody tr.user-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.dataset.searchFiltered = text.includes(filter) ? 'true' : 'false';
        });

        if (paginatorUser) {
            paginatorUser.currentPage = 1;
            paginatorUser.render();
        }
    }
    window.filterUserTable = filterUserTable;

    function openModalTambahUser() {
        const modal = document.getElementById('modalTambahUser');
        if (modal) modal.classList.remove('hidden');
        document.getElementById('add_user_unit_id').value = '';
        document.getElementById('add_user_unit_search').value = '';
        const pwdAdd = document.getElementById('add_password');
        if (pwdAdd) { pwdAdd.value = ''; pwdAdd.type = 'password'; }
        const iconAdd = document.getElementById('toggle_add_pwd_icon');
        if (iconAdd) { iconAdd.className = 'fa-solid fa-eye text-xs'; }
        closeAddUserUnitDropdown();
    }
    window.openModalTambahUser = openModalTambahUser;

    function closeModalTambahUser() {
        const modal = document.getElementById('modalTambahUser');
        if (modal) modal.classList.add('hidden');
        closeAddUserUnitDropdown();
    }
    window.closeModalTambahUser = closeModalTambahUser;

    // Searchable Unit in Modal Tambah
    function openAddUserUnitDropdown() {
        document.getElementById('addUserUnitDropdownList')?.classList.remove('hidden');
        document.getElementById('addUserUnitIcon')?.classList.add('rotate-180');
    }
    function closeAddUserUnitDropdown() {
        document.getElementById('addUserUnitDropdownList')?.classList.add('hidden');
        document.getElementById('addUserUnitIcon')?.classList.remove('rotate-180');
    }
    function toggleAddUserUnitDropdown() {
        const list = document.getElementById('addUserUnitDropdownList');
        if (list?.classList.contains('hidden')) openAddUserUnitDropdown();
        else closeAddUserUnitDropdown();
    }
    function filterAddUserUnitOptions(keyword) {
        openAddUserUnitDropdown();
        const search = (keyword || '').toLowerCase().trim();
        const items = document.querySelectorAll('.add-user-unit-item');
        let count = 0;
        items.forEach(it => {
            const name = (it.getAttribute('data-name') || '').toLowerCase();
            if (!search || name.includes(search)) {
                it.style.display = 'flex';
                count++;
            } else {
                it.style.display = 'none';
            }
        });
        document.getElementById('noAddUserUnitFound')?.classList.toggle('hidden', count > 0);
    }
    function selectAddUserUnit(elem) {
        const id = elem.getAttribute('data-id');
        const name = elem.getAttribute('data-name');
        document.getElementById('add_user_unit_id').value = id;
        document.getElementById('add_user_unit_search').value = (id === '') ? '' : name;
        closeAddUserUnitDropdown();
    }

    // Searchable Unit in Modal Edit
    function openEditUserUnitDropdown() {
        document.getElementById('editUserUnitDropdownList')?.classList.remove('hidden');
        document.getElementById('editUserUnitIcon')?.classList.add('rotate-180');
    }
    function closeEditUserUnitDropdown() {
        document.getElementById('editUserUnitDropdownList')?.classList.add('hidden');
        document.getElementById('editUserUnitIcon')?.classList.remove('rotate-180');
    }
    function toggleEditUserUnitDropdown() {
        const list = document.getElementById('editUserUnitDropdownList');
        if (list?.classList.contains('hidden')) openEditUserUnitDropdown();
        else closeEditUserUnitDropdown();
    }
    function filterEditUserUnitOptions(keyword) {
        openEditUserUnitDropdown();
        const search = (keyword || '').toLowerCase().trim();
        const items = document.querySelectorAll('.edit-user-unit-item');
        let count = 0;
        items.forEach(it => {
            const name = (it.getAttribute('data-name') || '').toLowerCase();
            if (!search || name.includes(search)) {
                it.style.display = 'flex';
                count++;
            } else {
                it.style.display = 'none';
            }
        });
        document.getElementById('noEditUserUnitFound')?.classList.toggle('hidden', count > 0);
    }
    function selectEditUserUnit(elem) {
        const id = elem.getAttribute('data-id');
        const name = elem.getAttribute('data-name');
        document.getElementById('edit_user_unit_id').value = id;
        document.getElementById('edit_user_unit_search').value = (id === '') ? '' : name;
        closeEditUserUnitDropdown();
    }

    function openModalEditUser(user) {
        const form = document.getElementById('formEditUser');
        if (form) form.action = "<?= base_url('profil/update') ?>/" + user.id;
        const namaEl = document.getElementById('edit_nama_lengkap');
        if (namaEl) namaEl.value = user.nama_lengkap || '';
        const userEl = document.getElementById('edit_username');
        if (userEl) userEl.value = user.username || '';
        const roleEl = document.getElementById('edit_role');
        if (roleEl) roleEl.value = user.role || 'Pengurus';
        
        // Populate searchable unit in edit modal
        const unitIdEl = document.getElementById('edit_user_unit_id');
        const unitSearchEl = document.getElementById('edit_user_unit_search');
        if (unitIdEl) unitIdEl.value = user.unit_id || '';
        if (unitSearchEl) {
            unitSearchEl.value = user.nama_unit ? (user.nama_unit + (user.unit_tipe ? ' (' + user.unit_tipe + ')' : '')) : '';
        }
        closeEditUserUnitDropdown();

        const modal = document.getElementById('modalEditUser');
        if (modal) modal.classList.remove('hidden');
        const pwdEdit = document.getElementById('edit_password');
        if (pwdEdit) { pwdEdit.value = ''; pwdEdit.type = 'password'; }
        const iconEdit = document.getElementById('toggle_edit_pwd_icon');
        if (iconEdit) { iconEdit.className = 'fa-solid fa-eye text-xs'; }
    }
    window.openModalEditUser = openModalEditUser;

    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input || !icon) return;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    window.togglePasswordVisibility = togglePasswordVisibility;

    function closeModalEditUser() {
        const modal = document.getElementById('modalEditUser');
        if (modal) modal.classList.add('hidden');
        closeEditUserUnitDropdown();
    }
    window.closeModalEditUser = closeModalEditUser;

    function switchProfilTab(tabId) {
        const isUsers = (tabId === 'tab_kelola_users');
        const tabProfil = document.getElementById('tab_profil_saya');
        const tabUsers = document.getElementById('tab_kelola_users');
        
        if (tabProfil) tabProfil.classList.toggle('hidden', isUsers);
        if (tabUsers) tabUsers.classList.toggle('hidden', !isUsers);
        
        const btnProfil = document.getElementById('btn_tab_profil_saya');
        const btnUsers = document.getElementById('btn_tab_kelola_users');
        
        if (!isUsers) {
            if (btnProfil) {
                btnProfil.className = "px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20";
            }
            if (btnUsers) {
                btnUsers.className = "px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200";
            }
        } else {
            if (btnProfil) {
                btnProfil.className = "px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200";
            }
            if (btnUsers) {
                btnUsers.className = "px-5 py-2.5 rounded-2xl font-heading font-extrabold text-xs transition shadow-2xs flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20";
            }
            // Ensure table paginator renders smoothly upon tab activation
            initUserPaginator();
        }

        // Update URL query string without page reload
        try {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('tab', isUsers ? 'kelola_users' : 'profil_saya');
            window.history.replaceState(null, '', currentUrl.toString());
        } catch(e) {}
    }
    window.switchProfilTab = switchProfilTab;

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        const addContainer = document.getElementById('add_user_unit_search')?.closest('.relative');
        if (addContainer && !addContainer.contains(e.target)) {
            closeAddUserUnitDropdown();
        }
        const editContainer = document.getElementById('edit_user_unit_search')?.closest('.relative');
        if (editContainer && !editContainer.contains(e.target)) {
            closeEditUserUnitDropdown();
        }
    });
</script>
<?= $this->endSection() ?>

