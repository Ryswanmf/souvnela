<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel; // Import model

class Pesanan extends BaseController
{
    public function index()
    {
        $model = new PesananModel();
        $data = [
            'pesanan' => $model->orderBy('created_at', 'DESC')->findAll(), 
            'pageTitle' => 'Daftar Pesanan'
        ];

        return view('admin/pesanan', $data);
    }

    public function detail($id)
    {
        $model = new PesananModel();
        $pesanan = $model->find($id);

        if (!$pesanan) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        // TODO: Buat view untuk detail pesanan jika diperlukan
        // Untuk sekarang, kita bisa tampilkan data mentah atau redirect.
        echo "<h1>Detail Pesanan: {$pesanan['kode_pesanan']}</h1>";
        echo "<pre>";
        print_r($pesanan);
        echo "</pre>";
    }
}
