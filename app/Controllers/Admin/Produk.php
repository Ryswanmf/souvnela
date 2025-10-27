<?php

namespace App\Controllers\Admin;

use App\Models\ProdukModel;
use App\Controllers\BaseController;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Produk',
            'produk' => $this->produkModel->findAll()
        ];

        return view('admin/produk/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk Baru',
            'action' => base_url('admin/produk/store'),
            'produk' => []
        ];

        return view('admin/produk/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'deskripsi' => 'required|min_length[10]',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads', $namaGambar);

        $this->produkModel->save([
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'kategori' => $this->request->getPost('kategori'),
            'gambar' => $namaGambar
        ]);

        return redirect()->to('admin/produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Produk',
            'action' => base_url('admin/produk/update/' . $id),
            'produk' => $this->produkModel->find($id)
        ];

        return view('admin/produk/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'deskripsi' => 'required|min_length[10]',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori' => 'required'
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid()) {
            $rules['gambar'] = 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'kategori' => $this->request->getPost('kategori')
        ];

        if ($gambar->isValid()) {
            $produk = $this->produkModel->find($id);
            if ($produk['gambar'] && file_exists('uploads/' . $produk['gambar'])) {
                unlink('uploads/' . $produk['gambar']);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $this->produkModel->update($id, $data);

        return redirect()->to('admin/produk')->with('success', 'Produk berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $produk = $this->produkModel->find($id);
        if ($produk['gambar'] && file_exists('uploads/' . $produk['gambar'])) {
            unlink('uploads/' . $produk['gambar']);
        }
        $this->produkModel->delete($id);
        return redirect()->to('admin/produk')->with('success', 'Produk berhasil dihapus.');
    }
}
