<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        helper(['form']);
        if (session()->get('isLoggedIn')) {
            return session()->get('role') === 'admin' ? redirect()->to('/admin') : redirect()->to('/');
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        helper(['form']);
        $session = session();
        $request = service('request');
        $model = new UserModel();

        // Simple rate-limit (in-memory via session). Adjust limits as needed.
        $maxAttempts = 5;
        $lockoutSeconds = 300; // 5 minutes

        // Initialize attempt tracking
        $attempts = $session->get('login_attempts') ?? 0;
        $firstAttemptAt = $session->get('login_first_at') ?? null;

        // If locked out, check timeout
        if ($attempts >= $maxAttempts) {
            if ($firstAttemptAt && (time() - $firstAttemptAt) < $lockoutSeconds) {
                $remaining = $lockoutSeconds - (time() - $firstAttemptAt);
                $mins = floor($remaining / 60);
                $secs = $remaining % 60;
                $session->setFlashdata('error', "Terlalu banyak percobaan. Coba lagi dalam {$mins}m {$secs}s.");
                return redirect()->back()->withInput();
            } else {
                // reset counters after timeout
                $session->remove('login_attempts');
                $session->remove('login_first_at');
                $attempts = 0;
                $firstAttemptAt = null;
            }
        }

        // Validation rules
        $rules = [
            'username' => 'required|trim|min_length[3]|max_length[50]',
            'password' => 'required|min_length[3]|max_length[255]'
        ];

        if (! $this->validate($rules)) {
            // increment attempts
            $attempts++;
            $session->set('login_attempts', $attempts);
            if (! $firstAttemptAt) {
                $session->set('login_first_at', time());
            }
            $session->setFlashdata('error', 'Username dan password wajib diisi dengan benar.');
            return redirect()->back()->withInput();
        }

        // Get input (trimmed)
        $username = trim($request->getPost('username'));
        $password = $request->getPost('password');

        // Find user by username
        $user = $model->where('username', $username)->first();

        if (! $user) {
            // increment attempts
            $attempts++;
            $session->set('login_attempts', $attempts);
            if (! $firstAttemptAt) {
                $session->set('login_first_at', time());
            }
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->back()->withInput();
        }

        // Verify password (password in DB must be hashed with password_hash)
        if (! password_verify($password, $user['password'])) {
            // increment attempts
            $attempts++;
            $session->set('login_attempts', $attempts);
            if (! $firstAttemptAt) {
                $session->set('login_first_at', time());
            }

            // Optional: if using password_hash() with default, consider password_needs_rehash() for future
            $session->setFlashdata('error', 'Password salah.');
            return redirect()->back()->withInput();
        }

        // Role-based redirection
        $session->set([
            'id'          => $user['id'],
            'username'    => $user['username'],
            'nama_lengkap'=> $user['nama_lengkap'],
            'role'        => $user['role'],
            'isLoggedIn'  => true
        ]);

        // Login sukses -> reset attempt counters
        $session->remove('login_attempts');
        $session->remove('login_first_at');

        if ($user['role'] === 'admin') {
            $session->setFlashdata('success', 'Selamat datang Admin ' . $user['nama_lengkap'] . '! Anda berhasil login ke Dashboard Admin.');
            return redirect()->to('/admin');
        } elseif ($user['role'] === 'pembeli') {
            $session->setFlashdata('success', 'Selamat datang kembali, ' . $user['nama_lengkap'] . '! Login berhasil.');
            if (session()->get('redirect_url')) {
                $redirect_url = session()->get('redirect_url');
                session()->remove('redirect_url');
                return redirect()->to($redirect_url);
            }
            
            return redirect()->to('/');
        } else {
            // Jika role tidak dikenali, hancurkan session dan tolak akses dengan pesan debug
            $session->destroy();
            $role_ditemukan = $user['role'] ?? '[KOSONG]'; // Ambil role, atau tampilkan [KOSONG] jika tidak ada
            $session->setFlashdata('error', 'Login gagal. Role pengguna tidak dikenali: ' . $role_ditemukan);
            return redirect()->back()->withInput();
        }
    }

    public function register()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function registerProcess()
    {
        helper(['form']);
        $session = session();
        $model = new UserModel();

        $rules = [
            'nama'           => 'required|min_length[3]',
            'username'       => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password'       => 'required|min_length[6]',
            'password_confirm' => 'matches[password]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama'),
            'username'     => $this->request->getPost('username'),
            'password'     => $this->request->getPost('password'),
            'role'         => 'pembeli' // Set default role
        ];

        if ($model->save($data)) {
            $session->setFlashdata('success', 'Selamat! Registrasi berhasil. Silakan login dengan akun Anda.');
            return redirect()->to('/login');
        } else {
            $session->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        $session = session();
        $nama = $session->get('nama_lengkap');
        $role = $session->get('role');
        
        // Set pesan sesuai role
        if ($role === 'admin') {
            $session->setFlashdata('success', 'Admin ' . $nama . ' telah logout. Terima kasih!');
        } else {
            $session->setFlashdata('success', 'Anda telah logout. Terima kasih ' . $nama . ', sampai jumpa lagi!');
        }
        
        $session->remove(['id', 'username', 'nama_lengkap', 'role', 'isLoggedIn', 'email']);
        return redirect()->to('/');
    }
}
