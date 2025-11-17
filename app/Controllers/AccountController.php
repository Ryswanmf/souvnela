<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\PesananItemModel;
use App\Controllers\BaseController;

class AccountController extends BaseController
{
    protected $pesananModel;
    protected $pesananItemModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->pesananItemModel = new PesananItemModel();
        helper(['form', 'number']);
    }

    /**
     * Displays the user's order history.
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat halaman ini.');
        }

        $customerName = session()->get('nama_lengkap');
        $orders = $this->pesananModel->where('pelanggan', $customerName)->orderBy('created_at', 'DESC')->findAll();

        // Fetch items for each order
        foreach ($orders as &$order) { // Use & to modify the original array
            $order['items'] = $this->pesananItemModel->where('pesanan_id', $order['id'])->findAll();
        }

        $data = [
            'title' => 'Riwayat Pesanan Saya',
            'orders' => $orders
        ];

        return view('account/orders', $data);
    }

    /**
     * Cancels an order if it belongs to the current user and is still new.
     */
    public function cancelOrder($orderId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Aksi tidak diizinkan.');
        }

        $customerName = session()->get('nama_lengkap');
        $order = $this->pesananModel->find($orderId);

        // Verify the order exists, belongs to the user, and is cancellable
        if (!$order) {
            return redirect()->to('/account')->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order['pelanggan'] !== $customerName) {
            return redirect()->to('/account')->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if ($order['status'] !== 'Baru') {
            return redirect()->to('/account')->with('error', 'Pesanan ini tidak dapat dibatalkan lagi.');
        }

        // Update the status to 'Dibatalkan'
        $this->pesananModel->update($orderId, ['status' => 'Dibatalkan']);

        // Note: Stock is not automatically restored. This would require a more complex schema.

        return redirect()->to('/account')->with('success', 'Pesanan dengan kode ' . esc($order['kode']) . ' telah berhasil dibatalkan.');
    }
}