<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();

        // Get kategori filter from query string
        $kategori = $this->request->getGet('kategori');

        // Get all unique categories for dropdown (optimized query)
        if (!$kategoriList = cache('kategori_list')) {
            $categories = $model->select('kategori')->distinct()->findAll();
            $kategoriList = array_column($categories, 'kategori');
            sort($kategoriList);
            cache()->save('kategori_list', $kategoriList, 3600);
        }

        // Filter products by category if selected
        if (!empty($kategori)) {
            if (!$produk = cache('produk_kategori_' . $kategori)) {
                $produk = $model->where('kategori', $kategori)->orderBy('id', 'DESC')->findAll();
                cache()->save('produk_kategori_' . $kategori, $produk, 3600);
            }
            $title = 'Produk Kategori: ' . $kategori;
        } else {
            if (!$produk = cache('semua_produk')) {
                $produk = $model->orderBy('id', 'DESC')->findAll();
                cache()->save('semua_produk', $produk, 3600);
            }
            $title = 'Semua Produk';
        }

        // Get user's wishlist items in one query (fix N+1 problem)
        $wishlistItems = [];
        if (session()->get('isLoggedIn')) {
            $wishlistModel = new \App\Models\WishlistModel();
            $userWishlist = $wishlistModel->where('user_id', session()->get('id'))->findAll();
            $wishlistItems = array_column($userWishlist, 'produk_id');
        }

        $data = [
            'title' => $title,
            'produk' => $produk,
            'kategoriList' => $kategoriList,
            'wishlistItems' => $wishlistItems,
        ];

        return view('produk/index', $data);
    }
    
    public function search()
    {
        $model = new ProdukModel();
        $keyword = $this->request->getGet('q');

        // Get all unique categories for dropdown (optimized query)
        $categories = $model->select('kategori')->distinct()->findAll();
        $kategoriList = array_column($categories, 'kategori');
        sort($kategoriList);

        if (!empty($keyword)) {
            $produk = $model->like('nama', $keyword)
                            ->orLike('deskripsi', $keyword)
                            ->orLike('kategori', $keyword)
                            ->orderBy('id', 'DESC')
                            ->findAll();
            $title = 'Hasil Pencarian: "' . $keyword . '"';
        } else {
            $produk = $model->orderBy('id', 'DESC')->findAll();
            $title = 'Semua Produk';
        }

        $data = [
            'title' => $title,
            'produk' => $produk,
            'kategoriList' => $kategoriList,
            'keyword' => $keyword,
        ];

        return view('produk/index', $data);
    }
    
    public function detail($id)
    {
        $model = new ProdukModel();
        
        if (!$produk = cache('produk_' . $id)) {
            $produk = $model->find($id);
            cache()->save('produk_' . $id, $produk, 3600);
        }
        
        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan');
        }
        
        // Load reviews
        $reviewModel = new \App\Models\ReviewsModel();
        if (!$reviews = cache('reviews_' . $id)) {
            $reviews = $reviewModel->getProductReviews($id);
            cache()->save('reviews_' . $id, $reviews, 3600);
        }
        
        // Check if user can review (must have purchased)
        $canReview = false;
        if (session()->get('isLoggedIn')) {
            $canReview = $reviewModel->canUserReview(session()->get('id'), $id);
        }
        
        $data = [
            'title' => $produk['nama'],
            'produk' => $produk,
            'reviews' => $reviews,
            'canReview' => $canReview
        ];
        
        return view('produk/detail', $data);
    }
}
