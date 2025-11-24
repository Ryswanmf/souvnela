<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherModel extends Model
{
    protected $table            = 'vouchers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Validate voucher code
     */
    public function validateVoucher($code, $totalAmount, $userId = null)
    {
        $voucher = $this->where('code', strtoupper($code))
            ->where('is_active', true)
            ->first();

        if (!$voucher) {
            return ['valid' => false, 'message' => 'Kode voucher tidak valid'];
        }

        // Check if voucher is within valid date range
        $now = date('Y-m-d H:i:s');
        
        if ($voucher['valid_from'] && $voucher['valid_from'] > $now) {
            return ['valid' => false, 'message' => 'Voucher belum dapat digunakan'];
        }

        if ($voucher['valid_until'] && $voucher['valid_until'] < $now) {
            return ['valid' => false, 'message' => 'Voucher sudah kadaluarsa'];
        }

        // Check usage limit
        if ($voucher['usage_limit'] && $voucher['used_count'] >= $voucher['usage_limit']) {
            return ['valid' => false, 'message' => 'Voucher sudah habis digunakan'];
        }

        // Check minimum purchase
        if ($totalAmount < $voucher['min_purchase']) {
            return [
                'valid' => false, 
                'message' => 'Minimum pembelian Rp ' . number_format($voucher['min_purchase'], 0, ',', '.')
            ];
        }

        // Check if user already used this voucher
        if ($userId) {
            $usageModel = new VoucherUsageModel();
            $hasUsed = $usageModel->hasUserUsedVoucher($userId, $voucher['id']);
            
            if ($hasUsed) {
                return ['valid' => false, 'message' => 'Anda sudah menggunakan voucher ini'];
            }
        }

        // Calculate discount
        $discount = $this->calculateDiscount($voucher, $totalAmount);

        return [
            'valid' => true,
            'voucher' => $voucher,
            'discount' => $discount,
            'final_amount' => $totalAmount - $discount
        ];
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($voucher, $totalAmount)
    {
        $discount = 0;

        if ($voucher['discount_type'] === 'percentage') {
            $discount = ($totalAmount * $voucher['discount_value']) / 100;
            
            // Apply max discount if set
            if ($voucher['max_discount'] && $discount > $voucher['max_discount']) {
                $discount = $voucher['max_discount'];
            }
        } else {
            // Fixed discount
            $discount = $voucher['discount_value'];
        }

        // Discount cannot exceed total amount
        if ($discount > $totalAmount) {
            $discount = $totalAmount;
        }

        return $discount;
    }

    /**
     * Increment voucher usage count
     */
    public function incrementUsage($voucherId)
    {
        $this->set('used_count', 'used_count + 1', false)
            ->where('id', $voucherId)
            ->update();
    }

    /**
     * Get active vouchers
     */
    public function getActiveVouchers()
    {
        $now = date('Y-m-d H:i:s');
        
        return $this->where('is_active', true)
            ->groupStart()
                ->where('valid_until >=', $now)
                ->orWhere('valid_until', null)
            ->groupEnd()
            ->groupStart()
                ->where('usage_limit >', 'used_count', false)
                ->orWhere('usage_limit', null)
            ->groupEnd()
            ->findAll();
    }
}
