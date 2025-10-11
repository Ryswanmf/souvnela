<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Blog extends BaseController
{
    public function index()
    {
        $blog = [
            ['id' => 1, 'judul' => 'Tren Fashion 2025', 'kategori' => 'Fashion', 'tanggal' => '2025-10-10', 'penulis' => 'Admin'],
            ['id' => 2, 'judul' => 'Cara Merawat Baju Custom', 'kategori' => 'Tips', 'tanggal' => '2025-10-08', 'penulis' => 'Admin'],
        ];

        return view('admin/blog', compact('blog'));
    }
}
