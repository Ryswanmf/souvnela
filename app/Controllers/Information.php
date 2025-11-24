<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InfoPageModel;

class Information extends BaseController
{
    protected $infoPageModel;

    public function __construct()
    {
        $this->infoPageModel = new InfoPageModel();
    }

    private function _renderPage($slug)
    {
        $page = $this->infoPageModel->where('slug', $slug)->first();

        if (!$page) {
            // Or show a 404 page
            return redirect()->to('/')->with('error', 'Halaman tidak ditemukan.');
        }

        $data = [
            'title' => $page['title'],
            'content' => $page['content'],
        ];

        return view('informasi/page', $data);
    }

    public function konfirmasiPembayaran()
    {
        return $this->_renderPage('konfirmasi-pembayaran');
    }

    public function pembayaranPengiriman()
    {
        return $this->_renderPage('pembayaran-pengiriman');
    }

    public function syaratKetentuan()
    {
        return $this->_renderPage('syarat-ketentuan');
    }

    public function kebijakanPrivasi()
    {
        return $this->_renderPage('kebijakan-privasi');
    }
}
