<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherUsageModel extends Model
{
    protected $table            = 'voucher_usage';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'voucher_id',
        'user_id',
        'pesanan_id',
        'discount_amount',
        'used_at'
    ];

    protected $useTimestamps = false;

    /**
     * Check if user has used a specific voucher
     */
    public function hasUserUsedVoucher($userId, $voucherId)
    {
        return $this->where('user_id', $userId)
            ->where('voucher_id', $voucherId)
            ->countAllResults() > 0;
    }

    /**
     * Record voucher usage
     */
    public function recordUsage($voucherId, $userId, $pesananId, $discountAmount)
    {
        return $this->insert([
            'voucher_id' => $voucherId,
            'user_id' => $userId,
            'pesanan_id' => $pesananId,
            'discount_amount' => $discountAmount,
            'used_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get user voucher history
     */
    public function getUserVoucherHistory($userId)
    {
        return $this->select('voucher_usage.*, vouchers.code, vouchers.description')
            ->join('vouchers', 'vouchers.id = voucher_usage.voucher_id')
            ->where('voucher_usage.user_id', $userId)
            ->orderBy('voucher_usage.used_at', 'DESC')
            ->findAll();
    }
}
