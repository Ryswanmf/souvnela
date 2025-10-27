<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Dilakukan sebelum permintaan ke controller.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Periksa apakah pengguna belum login atau peran (role) bukan 'admin'
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            // Arahkan ke halaman login dengan pesan error
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin.');
        }
    }

    /**
     * Dilakukan setelah respon dikirim dari controller.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan yang dilakukan setelah permintaan (jika tidak diperlukan)
    }
}