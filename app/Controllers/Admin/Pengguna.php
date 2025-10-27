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
        $data = [
            'role' => $this->request->getPost('role')
        ];

        $this->userModel->update($id, $data);

        return redirect()->to('admin/pengguna')->with('success', 'Peran pengguna berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('admin/pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
}