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
        $categories = $model->select('kategori')->distinct()->findAll();
        $kategoriList = array_column($categories, 'kategori');
        sort($kategoriList);

        // Filter products by category if selected
        if (!empty($kategori)) {
            $produk = $model->where('kategori', $kategori)->orderBy('id', 'DESC')->findAll();
            $title = 'Produk Kategori: ' . $kategori;
        } else {
            $produk = $model->orderBy('id', 'DESC')->findAll();
            $title = 'Semua Produk';
        }

        $data = [
            'title' => $title,
            'produk' => $produk,
            'kategoriList' => $kategoriList,
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
        $produk = $model->find($id);
        
        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan');
        }
        
        // Load reviews
        $reviewModel = new \App\Models\ReviewsModel();
        $reviews = $reviewModel->getProductReviews($id);
        
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
