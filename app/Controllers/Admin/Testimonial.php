<?php

namespace App\Controllers\Admin;

use App\Models\TestimonialModel;
use App\Controllers\BaseController;

class Testimonial extends BaseController
{
    protected $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->testimonialModel;

        if ($keyword) {
            $builder->like('content', $keyword)
                    ->orLike('author', $keyword)
                    ->orLike('author_title', $keyword);
        }

        $data = [
            'title' => 'Daftar Testimoni',
            'testimonials' => $builder->paginate(10, 'testimonials'),
            'pager' => $this->testimonialModel->pager,
            'keyword' => $keyword
        ];

        return view('admin/testimonial/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Testimoni'
        ];

        return view('admin/testimonial/create', $data);
    }

    public function store()
    {
        $data = [
            'content' => $this->request->getPost('content'),
            'author' => $this->request->getPost('author'),
            'author_title' => $this->request->getPost('author_title'),
        ];

        $photo = $this->request->getFile('photo');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(ROOTPATH . 'public/uploads', $newName);
            $data['photo'] = $newName;
        }

        $this->testimonialModel->insert($data);

        return redirect()->to('admin/testimonial')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Testimoni',
            'testimonial' => $this->testimonialModel->find($id)
        ];

        return view('admin/testimonial/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'content' => $this->request->getPost('content'),
            'author' => $this->request->getPost('author'),
            'author_title' => $this->request->getPost('author_title'),
        ];

        $photo = $this->request->getFile('photo');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $testimonial = $this->testimonialModel->find($id);
            if ($testimonial && !empty($testimonial['photo'])) {
                $oldImagePath = ROOTPATH . 'public/uploads/' . $testimonial['photo'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newName = $photo->getRandomName();
            $photo->move(ROOTPATH . 'public/uploads', $newName);
            $data['photo'] = $newName;
        }

        $this->testimonialModel->update($id, $data);

        return redirect()->to('admin/testimonial')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function delete($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        if ($testimonial && !empty($testimonial['photo'])) {
            $oldImagePath = ROOTPATH . 'public/uploads/' . $testimonial['photo'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $this->testimonialModel->delete($id);

        return redirect()->to('admin/testimonial')->with('success', 'Testimoni berhasil dihapus.');
    }
}
