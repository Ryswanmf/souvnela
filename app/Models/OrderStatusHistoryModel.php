<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderStatusHistoryModel extends Model
{
    protected $table            = 'order_status_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pesanan_id', 'status', 'notes', 'created_by'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    // Get status history for an order
    public function getOrderHistory($pesananId)
    {
        return $this->where('pesanan_id', $pesananId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    // Add status to history
    public function addStatus($pesananId, $status, $notes = null, $createdBy = null)
    {
        return $this->insert([
            'pesanan_id' => $pesananId,
            'status' => $status,
            'notes' => $notes,
            'created_by' => $createdBy,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // Get status labels
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

    // Get status badge class
    public function getStatusBadgeClass($status)
    {
        $classes = [
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'shipped' => 'bg-primary',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-danger'
        ];
        
        return $classes[$status] ?? 'bg-secondary';
    }

    // Get status icon
    public function getStatusIcon($status)
    {
        $icons = [
            'pending' => 'bi-clock-history',
            'processing' => 'bi-gear',
            'shipped' => 'bi-truck',
            'delivered' => 'bi-check-circle',
            'cancelled' => 'bi-x-circle'
        ];
        
        return $icons[$status] ?? 'bi-circle';
    }
}
