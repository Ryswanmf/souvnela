<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\OrderStatusHistoryModel;
use App\Models\ReviewsModel;

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
        $reviewsModel = new ReviewsModel(); // Load ReviewsModel
        
        $order = $pesananModel->getOrderWithItems($id);
        
        if (!$order || $order['user_id'] != session()->get('id')) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $statusHistory = $historyModel->getOrderHistory($id);
        $userId = session()->get('id');

        // Check for reviews on each item if order is delivered
        if ($order['status'] === 'delivered' && !empty($order['items'])) {
            foreach ($order['items'] as $key => $item) {
                $review = $reviewsModel->where([
                    'user_id' => $userId,
                    'produk_id' => $item['produk_id'],
                    'pesanan_id' => $id // Optional: link review to specific order
                ])->first();
                $order['items'][$key]['user_review'] = $review;
            }
        }

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

    public function invoice($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pesananModel = new PesananModel();
        $settingModel = new \App\Models\SettingModel();
        
        // Get order with items
        $order = $pesananModel->getOrderWithItems($id);

        // Security check: Ensure order belongs to logged-in user
        if (!$order || $order['user_id'] != session()->get('id')) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Fetch Store Settings
        $settings = $settingModel->findAll();
        $storeData = [];
        foreach ($settings as $setting) {
            $storeData[$setting['key']] = $setting['value'];
        }

        $data = [
            'order' => $order,
            'store_name' => $storeData['store_name'] ?? 'Souvnela',
            'store_address' => $storeData['store_address'] ?? null,
            'store_phone' => $storeData['store_phone'] ?? null,
            'store_logo' => $storeData['store_logo'] ?? null, // Assuming logo filename is stored
            'store_website' => base_url()
        ];

        return view('invoice/print', $data);
    }
}
