<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();
        $kategori = $this->request->getGet('kategori');

        if ($kategori && $kategori !== 'semua') {
            $produk = $model->where('kategori', $kategori)->orderBy('id', 'DESC')->findAll();
        } else {
            $produk = $model->orderBy('id', 'DESC')->findAll();
        }

        // Ambil semua kategori unik
        $allProduk = $model->findAll();
        $kategoris = array_unique(array_column($allProduk, 'kategori'));

        $data = [
            'title' => 'Daftar Produk Souvnela',
            'produk' => $produk,
            'kategoris' => $kategoris,
            'selected_kategori' => $kategori ?? 'semua',
        ];

        return view('produk/index.php', $data);
    }

    public function detail($id)
    {
        $model = new ProdukModel();
        $produk = $model->find($id);

        if (!$produk) {
            return redirect()->to('/produk')->with('error', 'Produk tidak ditemukan');
        }

        $data = [
            'title' => esc($produk['nama']) . ' - Detail Produk',
            'produk' => $produk,
        ];

        return view('produk/detail.php', $data);
    }
}
