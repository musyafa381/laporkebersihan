<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MasterUnitModel;

class Profil extends BaseController
{
    protected $userModel;
    protected $unitModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->unitModel = new MasterUnitModel();
    }

    private function respondJsonOrRedirect($message, $success = true, $redirectUrl = null)
    {
        if ($this->request->isAJAX()) {
            $jsonData = ['status' => $success ? 'success' : 'error', 'message' => $message];
            if ($redirectUrl) {
                $jsonData['redirect'] = $redirectUrl;
            }
            return $this->response->setJSON($jsonData);
        }

        $target = $redirectUrl ?: ($this->request->getServer('HTTP_REFERER') ?: base_url('profil'));
        return redirect()->to($target)->with($success ? 'success' : 'error', $message);
    }

    public function index()
    {
        $session = session();
        $currentUserId = $session->get('userId') ?? $session->get('user_id');
        $currentUser = $currentUserId ? $this->userModel->find($currentUserId) : null;
        
        $currentUnitId = $currentUser['unit_id'] ?? $session->get('unit_id');
        $currentUserUnit = $currentUnitId ? $this->unitModel->find($currentUnitId) : null;

        $usersList = $this->userModel
            ->select('users.*, master_unit.nama_unit')
            ->join('master_unit', 'master_unit.id = users.unit_id', 'left')
            ->orderBy('users.id', 'ASC')
            ->findAll();

        $unitsList = $this->unitModel->findAll();

        $data = [
            'title'           => 'Kelola Akun & Profil Pengguna',
            'currentUser'     => $currentUser,
            'currentUserUnit' => $currentUserUnit,
            'usersList'       => $usersList,
            'unitsList'       => $unitsList,
        ];
        return view('profil/index', $data);
    }

    public function storeUser()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $password = trim($this->request->getPost('password') ?? '');
        $nama     = trim($this->request->getPost('nama_lengkap') ?? '');
        $role     = $this->request->getPost('role') ?: 'Pengurus';
        $unitId   = $this->request->getPost('unit_id') ?: null;

        if (empty($username) || empty($password) || empty($nama)) {
            return $this->respondJsonOrRedirect('Username, password, dan nama lengkap wajib diisi.', false, base_url('profil?tab=kelola_users'));
        }

        // Check if username already exists
        $exist = $this->userModel->where('username', $username)->first();
        if ($exist) {
            return $this->respondJsonOrRedirect("Username '{$username}' sudah digunakan. Gunakan username lain.", false, base_url('profil?tab=kelola_users'));
        }

        $data = [
            'username'     => $username,
            'password'     => password_hash($password, PASSWORD_DEFAULT),
            'nama_lengkap' => $nama,
            'role'         => $role,
            'unit_id'      => $unitId,
        ];

        $this->userModel->insert($data);
        return $this->respondJsonOrRedirect("Berhasil mendaftarkan akun baru untuk '{$nama}' (Role: {$role})!", true, base_url('profil?tab=kelola_users'));
    }

    public function updateUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->respondJsonOrRedirect('Akun pengguna tidak ditemukan.', false, base_url('profil?tab=kelola_users'));
        }

        $username = trim($this->request->getPost('username') ?? '');
        $nama     = trim($this->request->getPost('nama_lengkap') ?? '');
        $role     = $this->request->getPost('role') ?: $user['role'];
        $unitId   = $this->request->getPost('unit_id') ?: null;
        $pass     = trim($this->request->getPost('password') ?? '');

        if (empty($nama) || empty($username)) {
            return $this->respondJsonOrRedirect('Nama lengkap dan username tidak boleh kosong.', false, base_url('profil?tab=kelola_users'));
        }

        // Check if username already exists for other users
        $exist = $this->userModel->where('username', $username)->where('id !=', $id)->first();
        if ($exist) {
            return $this->respondJsonOrRedirect("Username '{$username}' sudah digunakan oleh akun lain. Gunakan username lain.", false, base_url('profil?tab=kelola_users'));
        }

        $data = [
            'username'     => $username,
            'nama_lengkap' => $nama,
            'role'         => $role,
            'unit_id'      => $unitId,
        ];

        if (!empty($pass)) {
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        // Update session if editing currently logged in user
        if (session()->get('userId') == $id) {
            session()->set([
                'username'     => $username,
                'nama_lengkap' => $nama,
                'role'         => $role,
                'unit_id'      => $unitId,
            ]);
        }

        return $this->respondJsonOrRedirect("Berhasil memperbarui data akun '{$username}'!", true, base_url('profil?tab=kelola_users'));
    }

    public function deleteUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->respondJsonOrRedirect('Akun pengguna tidak ditemukan.', false, base_url('profil?tab=kelola_users'));
        }

        // Prevent deleting own logged in account
        $currentLoggedUserId = session()->get('userId') ?? session()->get('user_id');
        if ($currentLoggedUserId && (int)$currentLoggedUserId === (int)$id) {
            return $this->respondJsonOrRedirect('Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.', false, base_url('profil?tab=kelola_users'));
        }

        $this->userModel->delete($id);
        return $this->respondJsonOrRedirect("Berhasil menghapus akun '{$user['username']}'.", true, base_url('profil?tab=kelola_users'));
    }

    public function updateMyProfile()
    {
        $session = session();
        $currentUserId = $session->get('userId') ?? $session->get('user_id');
        if (!$currentUserId) {
            return $this->respondJsonOrRedirect('Sesi login telah berakhir. Silakan login kembali.', false, base_url('login'));
        }

        $user = $this->userModel->find($currentUserId);
        if (!$user) {
            return $this->respondJsonOrRedirect('Akun pengguna tidak ditemukan.', false, base_url('profil?tab=profil_saya'));
        }

        $nama     = trim($this->request->getPost('nama_lengkap') ?? '');
        $username = trim($this->request->getPost('username') ?? '');

        if (empty($nama) || empty($username)) {
            return $this->respondJsonOrRedirect('Nama lengkap dan username tidak boleh kosong.', false, base_url('profil?tab=profil_saya'));
        }

        // Check unique username
        $exist = $this->userModel->where('username', $username)->where('id !=', $currentUserId)->first();
        if ($exist) {
            return $this->respondJsonOrRedirect("Username '{$username}' sudah digunakan akun lain. Silakan pilih username lain.", false, base_url('profil?tab=profil_saya'));
        }

        $this->userModel->update($currentUserId, [
            'nama_lengkap' => $nama,
            'username'     => $username,
        ]);

        $session->set([
            'nama_lengkap' => $nama,
            'username'     => $username,
        ]);

        return $this->respondJsonOrRedirect('Profil Anda berhasil diperbarui!', true, base_url('profil?tab=profil_saya'));
    }

    public function changeMyPassword()
    {
        $session = session();
        $currentUserId = $session->get('userId') ?? $session->get('user_id');
        if (!$currentUserId) {
            return $this->respondJsonOrRedirect('Sesi login telah berakhir. Silakan login kembali.', false, base_url('login'));
        }

        $user = $this->userModel->find($currentUserId);
        if (!$user) {
            return $this->respondJsonOrRedirect('Akun pengguna tidak ditemukan.', false, base_url('profil?tab=profil_saya'));
        }

        $oldPass     = trim($this->request->getPost('old_password') ?? '');
        $newPass     = trim($this->request->getPost('new_password') ?? '');
        $confirmPass = trim($this->request->getPost('confirm_password') ?? '');

        if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
            return $this->respondJsonOrRedirect('Seluruh kolom password wajib diisi.', false, base_url('profil?tab=profil_saya'));
        }

        if (!password_verify($oldPass, $user['password'])) {
            return $this->respondJsonOrRedirect('Password saat ini (lama) yang Anda masukkan salah.', false, base_url('profil?tab=profil_saya'));
        }

        if (strlen($newPass) < 4) {
            return $this->respondJsonOrRedirect('Password baru minimal 4 karakter demi keamanan akun Anda.', false, base_url('profil?tab=profil_saya'));
        }

        if ($newPass !== $confirmPass) {
            return $this->respondJsonOrRedirect('Konfirmasi password baru tidak cocok. Pastikan keduanya sama persis.', false, base_url('profil?tab=profil_saya'));
        }

        $this->userModel->update($currentUserId, [
            'password' => password_hash($newPass, PASSWORD_DEFAULT),
        ]);

        return $this->respondJsonOrRedirect('Password akun Anda berhasil diperbarui! Silakan gunakan password baru untuk login berikutnya.', true, base_url('profil?tab=profil_saya'));
    }
}
