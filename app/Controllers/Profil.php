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
        $usersList = $this->userModel
            ->select('users.*, master_unit.nama_unit')
            ->join('master_unit', 'master_unit.id = users.unit_id', 'left')
            ->orderBy('users.id', 'ASC')
            ->findAll();

        $unitsList = $this->unitModel->findAll();

        $data = [
            'title'     => 'Kelola Akun & Profil Pengguna',
            'usersList' => $usersList,
            'unitsList' => $unitsList,
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
            return $this->respondJsonOrRedirect('Username, password, dan nama lengkap wajib diisi.', false);
        }

        // Check if username already exists
        $exist = $this->userModel->where('username', $username)->first();
        if ($exist) {
            return $this->respondJsonOrRedirect("Username '{$username}' sudah digunakan. Gunakan username lain.", false);
        }

        $data = [
            'username'     => $username,
            'password'     => password_hash($password, PASSWORD_DEFAULT),
            'nama_lengkap' => $nama,
            'role'         => $role,
            'unit_id'      => $unitId,
        ];

        $this->userModel->insert($data);
        return $this->respondJsonOrRedirect("Berhasil mendaftarkan akun baru untuk '{$nama}' (Role: {$role})!");
    }

    public function updateUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->respondJsonOrRedirect('Akun pengguna tidak ditemukan.', false);
        }

        $username = trim($this->request->getPost('username') ?? '');
        $nama     = trim($this->request->getPost('nama_lengkap') ?? '');
        $role     = $this->request->getPost('role') ?: $user['role'];
        $unitId   = $this->request->getPost('unit_id') ?: null;
        $pass     = trim($this->request->getPost('password') ?? '');

        if (empty($nama) || empty($username)) {
            return $this->respondJsonOrRedirect('Nama lengkap dan username tidak boleh kosong.', false);
        }

        // Check if username already exists for other users
        $exist = $this->userModel->where('username', $username)->where('id !=', $id)->first();
        if ($exist) {
            return $this->respondJsonOrRedirect("Username '{$username}' sudah digunakan oleh akun lain. Gunakan username lain.", false);
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

        return $this->respondJsonOrRedirect("Berhasil memperbarui data akun '{$username}'!");
    }

    public function deleteUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->respondJsonOrRedirect('Akun pengguna tidak ditemukan.', false, base_url('profil'));
        }

        // Prevent deleting own logged in account
        if (session()->get('userId') == $id) {
            return $this->respondJsonOrRedirect('Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.', false, base_url('profil'));
        }

        $this->userModel->delete($id);
        return $this->respondJsonOrRedirect("Berhasil menghapus akun '{$user['username']}'.", true, base_url('profil'));
    }
}
