<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\PesananItemModel;
use App\Models\OrderStatusHistoryModel;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $itemModel;
    protected $statusHistoryModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->itemModel = new PesananItemModel();
        $this->statusHistoryModel = new OrderStatusHistoryModel();
    }

    public function index()
    {
        // Filter by status if provided
        $status = $this->request->getGet('status');
        
        if ($status) {
            $orders = $this->pesananModel
                ->where('status', $status)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } else {
            $orders = $this->pesananModel
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        $data = [
            'orders' => $orders,
            'pageTitle' => 'Kelola Pesanan'
        ];

        return view('admin/pesanan/index', $data);
    }

    public function detail($id)
    {
        $order = $this->pesananModel->find($id);

        if (!$order) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Get order items
        $order['items'] = $this->itemModel->getOrderItems($id);
        
        // Get status history
        $statusHistory = $this->statusHistoryModel->getOrderHistory($id);

        $data = [
            'title' => 'Detail Pesanan #' . $order['id'],
            'order' => $order,
            'statusHistory' => $statusHistory,
            'historyModel' => $this->statusHistoryModel
        ];

        return view('admin/pesanan/detail', $data);
    }

    public function updateStatus($id)
    {
        $order = $this->pesananModel->find($id);
        
        if (!$order) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');
        $trackingNumber = $this->request->getPost('tracking_number');
        $notes = $this->request->getPost('notes');

        // Validate status
        $allowedStatus = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($newStatus, $allowedStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Update order
        $updateData = ['status' => $newStatus];
        
        if ($trackingNumber) {
            $updateData['tracking_number'] = $trackingNumber;
        }
        
        if ($newStatus === 'shipped' && empty($order['shipped_at'])) {
            $updateData['shipped_at'] = date('Y-m-d H:i:s');
        }
        
        if ($newStatus === 'delivered' && empty($order['delivered_at'])) {
            $updateData['delivered_at'] = date('Y-m-d H:i:s');
        }

        $this->pesananModel->update($id, $updateData);

        // Add status history
        $this->statusHistoryModel->addStatus(
            $id, 
            $newStatus, 
            $notes, 
            session()->get('admin_id')
        );

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal mengupdate status.');
        }

        return redirect()->to('admin/pesanan/detail/' . $id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $order = $this->pesananModel->find($id);
        
        if (!$order) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Only allow delete for cancelled orders
        if ($order['status'] !== 'cancelled') {
            return redirect()->to('admin/pesanan')->with('error', 'Hanya pesanan yang dibatalkan yang bisa dihapus.');
        }

        $this->pesananModel->delete($id);

        return redirect()->to('admin/pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function invoice($id)
    {
        $order = $this->pesananModel->find($id);
        
        if (!$order) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $order['items'] = $this->itemModel->getOrderItems($id);

        // Fetch Store Settings
        $settingModel = new \App\Models\SettingModel();
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
            'store_logo' => $storeData['store_logo'] ?? null,
            'store_website' => base_url()
        ];

        return view('invoice/print', $data);
    }
}

