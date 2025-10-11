<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengguna extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll(); // ambil semua data dari tabel users

        return view('admin/pengguna', compact('users'));
    }
}
