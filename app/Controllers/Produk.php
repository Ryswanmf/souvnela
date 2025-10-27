<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();

        $data = [
            'title' => 'Daftar Produk Souvnela',
            'produk' => $model->orderBy('id', 'DESC')->findAll(),
        ];

        return view('produk/index.php', $data);
    }
}
