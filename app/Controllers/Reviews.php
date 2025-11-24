<?php

namespace App\Controllers;

use App\Models\ReviewsModel;
use App\Models\ProdukModel;

class Reviews extends BaseController
{
    public function add($produkId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk memberikan review.');
        }

        $reviewsModel = new ReviewsModel();
        $userId = session()->get('id');

        // Check if user can review
        if (!$reviewsModel->canUserReview($userId, $produkId)) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review atau belum membeli produk ini.');
        }

        $produkModel = new ProdukModel();
        $produk = $produkModel->find($produkId);

        $data = [
            'title' => 'Tulis Review - ' . $produk['nama'],
            'produk' => $produk,
        ];

        return view('reviews/add', $data);
    }

    public function submit()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk memberikan review.');
        }

        $reviewsModel = new ReviewsModel();
        $userId = session()->get('id');
        $produkId = $this->request->getPost('produk_id');

        // Validation
        $rules = [
            'rating' => 'required|in_list[1,2,3,4,5]',
            'review' => 'required|min_length[10]|max_length[1000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if user can review
        if (!$reviewsModel->canUserReview($userId, $produkId)) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review atau belum membeli produk ini.');
        }

        // Handle photo upload
        $photos = [];
        $photoFiles = $this->request->getFiles();
        
        if (!empty($photoFiles['photos'])) {
            foreach ($photoFiles['photos'] as $photo) {
                if ($photo->isValid() && !$photo->hasMoved()) {
                    $newName = $photo->getRandomName();
                    $photo->move(FCPATH . 'uploads/reviews', $newName);
                    $photos[] = $newName;
                }
            }
        }

        // Save review
        $data = [
            'produk_id' => $produkId,
            'user_id' => $userId,
            'rating' => $this->request->getPost('rating'),
            'review' => $this->request->getPost('review'),
            'photos' => !empty($photos) ? json_encode($photos) : null,
            'is_verified_purchase' => true,
            'status' => 'approved', // Auto-approve, or set to 'pending' for moderation
        ];

        if ($reviewsModel->insert($data)) {
            // Update product rating
            $reviewsModel->updateProductRating($produkId);
            
            return redirect()->to('produk/detail/' . $produkId)->with('success', 'Review berhasil ditambahkan. Terima kasih!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan review. Silakan coba lagi.');
    }

    public function markHelpful($reviewId)
    {
        if (!session()->get('isLoggedIn')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu.'
                ]);
            }
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $userId = session()->get('id');

        // Check if already marked
        $existing = $db->table('review_helpful')
                       ->where('review_id', $reviewId)
                       ->where('user_id', $userId)
                       ->get()
                       ->getRow();

        if ($existing) {
            // Remove helpful mark
            $db->table('review_helpful')
               ->where('review_id', $reviewId)
               ->where('user_id', $userId)
               ->delete();

            // Decrease count
            $db->table('reviews')
               ->set('helpful_count', 'helpful_count - 1', FALSE)
               ->where('id', $reviewId)
               ->update();

            $message = 'Marked as not helpful';
            $isHelpful = false;
        } else {
            // Add helpful mark
            $db->table('review_helpful')->insert([
                'review_id' => $reviewId,
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Increase count
            $db->table('reviews')
               ->set('helpful_count', 'helpful_count + 1', FALSE)
               ->where('id', $reviewId)
               ->update();

            $message = 'Marked as helpful';
            $isHelpful = true;
        }

        // Get updated count
        $review = $db->table('reviews')->where('id', $reviewId)->get()->getRow();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'isHelpful' => $isHelpful,
                'helpfulCount' => $review->helpful_count
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
