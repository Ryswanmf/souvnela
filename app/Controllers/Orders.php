<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\OrderStatusHistoryModel;

class Orders extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat pesanan.');
        }

        $pesananModel = new PesananModel();
        $userId = session()->get('id');

        $orders = $pesananModel->getOrdersByUser($userId);

        $data = [
            'title' => 'Pesanan Saya',
            'orders' => $orders,
        ];

        return view('orders/index', $data);
    }

    public function detail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat detail pesanan.');
        }

        $pesananModel = new PesananModel();
        $historyModel = new OrderStatusHistoryModel();
        
        $order = $pesananModel->getOrderWithItems($id);
        
        if (!$order || $order['user_id'] != session()->get('id')) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $statusHistory = $historyModel->getOrderHistory($id);

        $data = [
            'title' => 'Detail Pesanan #' . $order['id'],
            'order' => $order,
            'statusHistory' => $statusHistory,
            'historyModel' => $historyModel,
        ];

        return view('orders/detail', $data);
    }

    public function track($id)
    {
        $pesananModel = new PesananModel();
        $historyModel = new OrderStatusHistoryModel();
        
        $order = $pesananModel->find($id);
        
        if (!$order) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan.');
        }

        $statusHistory = $historyModel->getOrderHistory($id);

        $data = [
            'title' => 'Lacak Pesanan #' . $order['id'],
            'order' => $order,
            'statusHistory' => $statusHistory,
            'historyModel' => $historyModel,
        ];

        return view('orders/track', $data);
    }

    public function success($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pesananModel = new PesananModel();
        $order = $pesananModel->getOrderWithItems($id);
        
        if (!$order || $order['user_id'] != session()->get('id')) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $data = [
            'title' => 'Pembayaran Berhasil',
            'order' => $order
        ];

        return view('orders/success', $data);
    }

    public function pending($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pesananModel = new PesananModel();
        $order = $pesananModel->getOrderWithItems($id);
        
        if (!$order || $order['user_id'] != session()->get('id')) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $data = [
            'title' => 'Menunggu Pembayaran',
            'order' => $order
        ];

        return view('orders/pending', $data);
    }
}
