<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Pengguna extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/pengguna/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna Baru',
            'action' => base_url('admin/pengguna/store'),
            'user' => [] // Empty user for the form
        ];

        return view('admin/pengguna/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'username'     => 'required|min_length[3]|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'role'         => 'required|in_list[admin,pembeli]',
            'nomor_telepon' => 'permit_empty|min_length[10]|max_length[20]',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'tanggal_lahir' => 'permit_empty|valid_date',
            'alamat' => 'permit_empty|string',
        ];

        // Only validate foto_profil if a file is uploaded
        if ($this->request->getFile('foto_profil') && $this->request->getFile('foto_profil')->isValid()) {
            $rules['foto_profil'] = 'is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto_profil,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'password'     => $this->request->getPost('password'), // Hashing is handled by the model
            'role'         => $this->request->getPost('role'),
            'nomor_telepon' => $this->request->getPost('nomor_telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $fotoProfil = $this->request->getFile('foto_profil');
        if ($fotoProfil && $fotoProfil->isValid() && !$fotoProfil->hasMoved()) {
            $newName = $fotoProfil->getRandomName();
            if ($fotoProfil->move(FCPATH . 'uploads', $newName)) {
                $data['foto_profil'] = $newName;
            } else {
                // Handle move failure
                return redirect()->back()->withInput()->with('errors', ['foto_profil' => 'Gagal mengupload foto profil.']);
            }
        }

        $this->userModel->save($data);

        return redirect()->to('admin/pengguna')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengguna',
            'action' => base_url('admin/pengguna/update/' . $id),
            'user' => $this->userModel->find($id)
        ];

        return view('admin/pengguna/form', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        // Dynamic validation rules
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'role'         => 'required|in_list[admin,pembeli]',
            'username'     => 'required|min_length[3]|is_unique[users.username,id,' . $id . ']',
            'email'        => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'nomor_telepon' => 'permit_empty|min_length[10]|max_length[20]',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'tanggal_lahir' => 'permit_empty|valid_date',
            'alamat' => 'permit_empty|string',
        ];

        // Only validate foto_profil if a file is uploaded
        if ($this->request->getFile('foto_profil') && $this->request->getFile('foto_profil')->isValid()) {
            $rules['foto_profil'] = 'is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto_profil,2048]';
        }

        // Password validation is optional
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'role'         => $this->request->getPost('role'),
            'nomor_telepon' => $this->request->getPost('nomor_telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        // Only add password to data if it's being changed
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        $fotoProfil = $this->request->getFile('foto_profil');
        if ($fotoProfil && $fotoProfil->isValid() && !$fotoProfil->hasMoved()) {
            if ($user['foto_profil'] && file_exists(FCPATH . 'uploads/' . $user['foto_profil'])) {
                unlink(FCPATH . 'uploads/' . $user['foto_profil']);
            }
            $newName = $fotoProfil->getRandomName();
            if ($fotoProfil->move(FCPATH . 'uploads', $newName)) {
                $data['foto_profil'] = $newName;
            } else {
                // Handle move failure
                return redirect()->back()->withInput()->with('errors', ['foto_profil' => 'Gagal mengupload foto profil.']);
            }
        }


        $this->userModel->update($id, $data);

        return redirect()->to('admin/pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('admin/pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
}