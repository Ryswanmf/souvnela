<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Kontak extends BaseController
{
    public function index()
    {
        $kontak = [
            ['id' => 1, 'nama' => 'Andi', 'email' => 'andi@gmail.com', 'subjek' => 'Kerjasama', 'pesan' => 'Apakah bisa cetak baju dalam jumlah besar?', 'tanggal' => '2025-10-10'],
            ['id' => 2, 'nama' => 'Budi', 'email' => 'budi@gmail.com', 'subjek' => 'Keluhan', 'pesan' => 'Pesanan saya belum sampai.', 'tanggal' => '2025-10-09'],
        ];

        return view('admin/kontak', compact('kontak'));
    }
}
