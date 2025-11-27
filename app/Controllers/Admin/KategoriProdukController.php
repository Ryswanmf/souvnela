<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriProdukModel;

class KategoriProdukController extends BaseController
{
    protected $kategoriProdukModel;

    public function __construct()
    {
        $this->kategoriProdukModel = new KategoriProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Kategori Produk',
            'kategori' => $this->kategoriProdukModel->findAll()
        ];

        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Baru',
            'action' => base_url('admin/kategori/store'),
            'kategori_item' => []
        ];

        return view('admin/kategori/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama_kategori' => 'required|min_length[3]|is_unique[kategori_produk.nama_kategori]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriProdukModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        // Clear category cache
        cache()->delete('kategori_list');

        return redirect()->to('admin/kategori')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kategori',
            'action' => base_url('admin/kategori/update/' . $id),
            'kategori_item' => $this->kategoriProdukModel->find($id)
        ];

        return view('admin/kategori/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_kategori' => 'required|min_length[3]|is_unique[kategori_produk.nama_kategori,id,' . $id . ']'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriProdukModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        // Clear category cache
        cache()->delete('kategori_list');

        return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Optional: Check if the category is being used by any product before deleting.
        // For now, we'll just delete it.
        $this->kategoriProdukModel->delete($id);

        // Clear category cache
        cache()->delete('kategori_list');

        return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}