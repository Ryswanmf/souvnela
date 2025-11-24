<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InfoPageModel;

class InfoPageController extends BaseController
{
    protected $infoPageModel;

    public function __construct()
    {
        $this->infoPageModel = new InfoPageModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Halaman Informasi',
            'pages' => $this->infoPageModel->findAll(),
        ];

        return view('admin/info_pages/index', $data);
    }

    public function edit($id)
    {
        $page = $this->infoPageModel->find($id);

        if (!$page) {
            return redirect()->to('admin/info-pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Halaman: ' . $page['title'],
            'page' => $page,
        ];

        return view('admin/info_pages/edit', $data);
    }

    public function update($id)
    {
        $page = $this->infoPageModel->find($id);

        if (!$page) {
            return redirect()->to('admin/info-pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $rules = [
            'title'   => 'required|min_length[3]|max_length[255]',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
        ];

        if ($this->infoPageModel->update($id, $data)) {
            return redirect()->to('admin/info-pages')->with('success', 'Halaman berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui halaman.');
        }
    }
}
