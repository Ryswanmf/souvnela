<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Produk extends BaseController
{
    public function index()
    {
        $produk = [
            ['id' => 1, 'nama' => 'Kaos Polos', 'harga' => 80000, 'stok' => 10, 'gambar' => 'kaos.jpg'],
            ['id' => 2, 'nama' => 'Sweater Hoodie', 'harga' => 150000, 'stok' => 4, 'gambar' => 'hoodie.jpg'],
            ['id' => 3, 'nama' => 'Topi Custom', 'harga' => 60000, 'stok' => 0, 'gambar' => 'topi.jpg'],
        ];

        return view('admin/produk', compact('produk'));
    }
}
