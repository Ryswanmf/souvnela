<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KontakModel; // Import model

class Kontak extends BaseController
{
    public function index()
    {
        $model = new KontakModel();
        $data = [
            'kontak' => $model->findAll(),
            'pageTitle' => 'Pesan Masuk'
        ];

        return view('admin/kontak', $data);
    }

    public function hapus($id)
    {
        $model = new KontakModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->to('/admin/kontak')->with('success', 'Pesan berhasil dihapus.');
        }
        return redirect()->to('/admin/kontak')->with('error', 'Pesan tidak ditemukan.');
    }
}
