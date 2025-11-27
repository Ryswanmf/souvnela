<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table            = 'wishlist';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'produk_id'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get wishlist with product details
    public function getWishlistByUser($userId)
    {
        return $this->select('wishlist.*, produk.*')
                    ->join('produk', 'produk.id = wishlist.produk_id')
                    ->where('wishlist.user_id', $userId)
                    ->orderBy('wishlist.created_at', 'DESC')
                    ->findAll();
    }

    // Check if product is in wishlist
    public function isInWishlist($userId, $produkId)
    {
        return $this->where('user_id', $userId)
                    ->where('produk_id', $produkId)
                    ->countAllResults() > 0;
    }

    // Toggle wishlist
    public function toggleWishlist($userId, $produkId)
    {
        $existing = $this->where('user_id', $userId)
                         ->where('produk_id', $produkId)
                         ->first();

        if ($existing) {
            // Remove from wishlist
            $this->delete($existing['id']);
            return false; // Removed
        } else {
            // Add to wishlist
            $this->insert([
                'user_id' => $userId,
                'produk_id' => $produkId
            ]);
            return true; // Added
        }
    }
}
