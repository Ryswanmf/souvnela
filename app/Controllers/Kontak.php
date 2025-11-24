<?php

namespace App\Controllers;

use App\Models\KontakModel;

class Kontak extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kontak Kami'
        ];
        return view('kontak/kontak', $data);
    }

    public function kirim()
    {
        $kontakModel = new KontakModel();

        $data = [
            'nama' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subjek' => $this->request->getPost('subject'),
            'pesan' => $this->request->getPost('message')
        ];

        $kontakModel->save($data);

        return redirect()->to('/kontak')->with('success', 'Pesan Anda telah berhasil dikirim.');
    }
}
