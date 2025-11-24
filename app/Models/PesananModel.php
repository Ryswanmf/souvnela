<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'nama_penerima',
        'pelanggan',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'no_telepon',
        'email',
        'catatan',
        'subtotal',
        'ongkir',
        'discount_amount',
        'total_harga',
        'final_amount',
        'status',
        'payment_status',
        'shipping_method',
        'voucher_id',
        'voucher_code',
        'snap_token',
        'transaction_id',
        'tracking_number',
        'shipped_at',
        'delivered_at',
        'paid_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get orders by user
    public function getOrdersByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Get order with items
    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);
        if (!$order) return null;
        
        $itemsModel = new \App\Models\PesananItemModel();
        $order['items'] = $itemsModel->getOrderItems($orderId);
        
        return $order;
    }

    // Update order status
    public function updateOrderStatus($orderId, $status, $notes = null, $userId = null)
    {
        $data = ['status' => $status];

        if ($status === 'shipped') {
            $data['shipped_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'delivered') {
            $data['delivered_at'] = date('Y-m-d H:i:s');
        }
        
        $this->update($orderId, $data);

        // Add to history
        $historyModel = new \App\Models\OrderStatusHistoryModel();
        $historyModel->addStatus($orderId, $status, $notes, $userId);

        return true;
    }

    // Get order status label
    public function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Sedang Dikirim',
            'delivered' => 'Terkirim',
            'cancelled' => 'Dibatalkan'
        ];
        
        return $labels[$status] ?? $status;
    }
}
