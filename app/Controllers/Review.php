<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\ProdukModel;
use App\Models\PesananItemModel;

class Review extends BaseController
{
    protected $reviewModel;
    protected $produkModel;
    protected $pesananItemsModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->produkModel = new ProdukModel();
        $this->pesananItemsModel = new PesananItemModel();
    }

    public function add($produk_id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user_id = session()->get('user_id');

        // Check if already reviewed
        if ($this->reviewModel->hasUserReviewed($produk_id, $user_id)) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini');
        }

        if ($this->request->getMethod() == 'post') {
            $data = [
                'produk_id' => $produk_id,
                'user_id' => $user_id,
                'rating' => $this->request->getPost('rating'),
                'title' => $this->request->getPost('title'),
                'comment' => $this->request->getPost('comment'),
                'is_verified_purchase' => $this->checkVerifiedPurchase($user_id, $produk_id),
                'status' => 'pending'
            ];

            if ($this->reviewModel->insert($data)) {
                // Update produk rating
                $this->updateProdukRating($produk_id);
                
                return redirect()->to('/produk/detail/' . $produk_id)
                    ->with('success', 'Terima kasih! Ulasan Anda akan ditampilkan setelah diverifikasi');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan ulasan');
        }

        $data['produk'] = $this->produkModel->find($produk_id);
        $data['title'] = 'Tulis Ulasan';
        return view('review/add', $data);
    }

    private function checkVerifiedPurchase($user_id, $produk_id)
    {
        $purchase = $this->pesananItemsModel
            ->select('pesanan_items.*')
            ->join('pesanan', 'pesanan.id = pesanan_items.pesanan_id')
            ->where('pesanan.user_id', $user_id)
            ->where('pesanan_items.produk_id', $produk_id)
            ->where('pesanan.status', 'completed')
            ->first();

        return $purchase !== null;
    }

    private function updateProdukRating($produk_id)
    {
        $stats = $this->reviewModel->getAverageRating($produk_id);
        
        $this->produkModel->update($produk_id, [
            'rating_avg' => $stats['average'],
            'rating_count' => $stats['total']
        ]);
    }

    public function helpful($review_id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Login required'
            ]);
        }

        $this->reviewModel->set('helpful_count', 'helpful_count + 1', false)
            ->where('id', $review_id)
            ->update();

        $review = $this->reviewModel->find($review_id);

        return $this->response->setJSON([
            'success' => true,
            'count' => $review['helpful_count']
        ]);
    }
}
