<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewsModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'produk_id', 
        'user_id', 
        'pesanan_id', 
        'rating', 
        'review', 
        'photos',
        'is_verified_purchase',
        'helpful_count',
        'status'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get reviews for a product
    public function getProductReviews($produkId, $status = 'approved', $limit = null)
    {
        $builder = $this->select('reviews.*, users.nama_lengkap as user_name')
                        ->join('users', 'users.id = reviews.user_id')
                        ->where('reviews.produk_id', $produkId)
                        ->where('reviews.status', $status)
                        ->orderBy('reviews.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    // Get rating summary
    public function getRatingSummary($produkId)
    {
        $reviews = $this->where('produk_id', $produkId)
                        ->where('status', 'approved')
                        ->findAll();
        
        $summary = [
            'total' => count($reviews),
            'average' => 0,
            'distribution' => [
                5 => 0,
                4 => 0,
                3 => 0,
                2 => 0,
                1 => 0,
            ]
        ];
        
        if (empty($reviews)) {
            return $summary;
        }
        
        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review['rating'];
            $summary['distribution'][$review['rating']]++;
        }
        
        $summary['average'] = round($totalRating / $summary['total'], 2);
        
        return $summary;
    }

    // Check if user can review
    public function canUserReview($userId, $produkId)
    {
        // Check if already reviewed
        $existingReview = $this->where('user_id', $userId)
                              ->where('produk_id', $produkId)
                              ->first();
        
        if ($existingReview) {
            return false;
        }
        
        // Check if user purchased this product
        $db = \Config\Database::connect();
        $purchased = $db->table('pesanan')
                        ->select('pesanan.id')
                        ->join('pesanan_items', 'pesanan_items.pesanan_id = pesanan.id')
                        ->where('pesanan.user_id', $userId)
                        ->where('pesanan_items.produk_id', $produkId)
                        ->groupStart()
                            ->where('pesanan.status', 'delivered')
                            ->orWhere('pesanan.status', 'completed')
                            ->orWhere('pesanan.status', 'selesai')
                            ->orWhere('pesanan.status', 'diterima')
                        ->groupEnd()
                        ->get()
                        ->getRow();
        
        return !empty($purchased);
    }

    // Update product rating after review
    public function updateProductRating($produkId)
    {
        $summary = $this->getRatingSummary($produkId);
        
        $produkModel = new ProdukModel();
        $produkModel->update($produkId, [
            'average_rating' => $summary['average'],
            'total_reviews' => $summary['total']
        ]);
    }

    // Get user's review for product
    public function getUserReview($userId, $produkId)
    {
        return $this->where('user_id', $userId)
                    ->where('produk_id', $produkId)
                    ->first();
    }
}
