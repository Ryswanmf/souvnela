<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
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
        'rating',
        'title',
        'comment',
        'is_verified_purchase',
        'helpful_count',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'produk_id' => 'required|integer',
        'user_id'   => 'required|integer',
        'rating'    => 'required|integer|in_list[1,2,3,4,5]',
        'comment'   => 'required|min_length[10]'
    ];

    protected $validationMessages = [
        'rating' => [
            'in_list' => 'Rating harus antara 1-5'
        ],
        'comment' => [
            'min_length' => 'Ulasan minimal 10 karakter'
        ]
    ];

    public function getReviewsWithUsers($produk_id, $limit = 10, $offset = 0)
    {
        return $this->select('reviews.*, users.nama as user_name')
            ->join('users', 'users.id = reviews.user_id')
            ->where('reviews.produk_id', $produk_id)
            ->where('reviews.status', 'approved')
            ->orderBy('reviews.created_at', 'DESC')
            ->findAll($limit, $offset);
    }

    public function getAverageRating($produk_id)
    {
        $result = $this->select('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->where('produk_id', $produk_id)
            ->where('status', 'approved')
            ->first();
        
        return [
            'average' => round($result['avg_rating'] ?? 0, 1),
            'total' => $result['total_reviews'] ?? 0
        ];
    }

    public function getRatingDistribution($produk_id)
    {
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->where('produk_id', $produk_id)
                ->where('rating', $i)
                ->where('status', 'approved')
                ->countAllResults();
            $distribution[$i] = $count;
        }
        return $distribution;
    }

    public function hasUserReviewed($produk_id, $user_id)
    {
        return $this->where('produk_id', $produk_id)
            ->where('user_id', $user_id)
            ->first() !== null;
    }
}
