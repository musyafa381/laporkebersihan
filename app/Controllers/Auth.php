<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // If already logged in, redirect to welcome homepage
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Login Sistem LPJ & Inventaris K3L',
        ];
        return view('auth/login', $data);
    }

    public function processLogin()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $password = trim($this->request->getPost('password') ?? '');

        if (empty($username) || empty($password)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Username dan password wajib diisi.']);
            }
            return redirect()->to('/login')->with('error', 'Username dan password wajib diisi.')->withInput();
        }

        $userModel = new UserModel();
        $user      = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Username atau password tidak cocok.']);
            }
            return redirect()->to('/login')->with('error', 'Username atau password tidak cocok.')->withInput();
        }

        // Set session
        $session = session();
        $session->set([
            'userId'       => $user['id'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role'         => $user['role'],
            'unit_id'      => $user['unit_id'],
            'isLoggedIn'   => true,
        ]);

        $redirectTarget = base_url('/');

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Login Berhasil! Selamat datang di Website Kebersihan.',
                'redirect' => $redirectTarget
            ]);
        }

        return redirect()->to($redirectTarget);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Anda telah berhasil keluar dari akun.',
                'redirect' => base_url('/')
            ]);
        }

        return redirect()->to('/')->with('success', 'Anda telah berhasil keluar (logout) dari akun.');
    }
}
