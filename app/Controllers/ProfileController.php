<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat halaman ini.');
        }

        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Aksi tidak diizinkan.');
        }

        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$this->request->is('post')) {
            return redirect()->to('profile');
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'tanggal_lahir' => 'permit_empty|valid_date',
            'alamat' => 'permit_empty|string',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'nomor_telepon' => 'permit_empty|min_length[10]|max_length[20]',
            'foto_profil' => 'is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto_profil,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'id' => $userId,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'nomor_telepon' => $this->request->getPost('nomor_telepon'),
        ];

        $fotoProfil = $this->request->getFile('foto_profil');

        if ($fotoProfil->isValid() && !$fotoProfil->hasMoved()) {
            // Hapus foto lama jika ada
            if ($user['foto_profil'] && file_exists('uploads/' . $user['foto_profil'])) {
                unlink('uploads/' . $user['foto_profil']);
            }

            $newName = $fotoProfil->getRandomName();
            $fotoProfil->move('uploads', $newName);
            $data['foto_profil'] = $newName;
        }

        if ($this->userModel->save($data)) {
            // Update session data
            session()->set([
                'nama_lengkap' => $data['nama_lengkap'],
                'email' => $data['email'],
            ]);
            return redirect()->to('profile')->with('success', 'Profil berhasil diperbarui.');
        } else {
            return redirect()->to('profile')->with('error', 'Gagal memperbarui profil.');
        }
    }
}
