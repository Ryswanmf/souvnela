<?php

namespace App\Controllers\Admin;

use App\Models\BlogModel;
use App\Controllers\BaseController;

class Blog extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Blog',
            'blog' => $this->blogModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/blog/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tulis Artikel Baru',
            'action' => base_url('admin/blog/store'),
            'post' => []
        ];

        return view('admin/blog/form', $data);
    }

    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[10]',
            'konten' => 'required|min_length[50]',
            'kategori' => 'required',
            'penulis' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads', $namaGambar);

        $this->blogModel->save([
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis' => $this->request->getPost('penulis'),
            'tanggal' => date('Y-m-d H:i:s'),
            'gambar' => $namaGambar
        ]);

        return redirect()->to('admin/blog')->with('success', 'Artikel berhasil dipublikasikan!');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Artikel',
            'action' => base_url('admin/blog/update/' . $id),
            'post' => $this->blogModel->find($id)
        ];

        return view('admin/blog/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'judul' => 'required|min_length[10]',
            'konten' => 'required|min_length[50]',
            'kategori' => 'required',
            'penulis' => 'required'
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid()) {
            $rules['gambar'] = 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis' => $this->request->getPost('penulis')
        ];

        if ($gambar->isValid()) {
            $post = $this->blogModel->find($id);
            if ($post['gambar'] && file_exists(FCPATH . 'uploads/' . $post['gambar'])) {
                unlink(FCPATH . 'uploads/' . $post['gambar']);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $this->blogModel->update($id, $data);

        return redirect()->to('admin/blog')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $post = $this->blogModel->find($id);
        if ($post['gambar'] && file_exists(FCPATH . 'uploads/' . $post['gambar'])) {
            unlink(FCPATH . 'uploads/' . $post['gambar']);
        }
        $this->blogModel->delete($id);
        return redirect()->to('admin/blog')->with('success', 'Artikel berhasil dihapus.');
    }
}