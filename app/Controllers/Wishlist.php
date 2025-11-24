<?php

namespace App\Controllers;

use App\Models\WishlistModel;
use App\Models\ProdukModel;

class Wishlist extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat wishlist.');
        }

        $wishlistModel = new WishlistModel();
        $userId = session()->get('id');

        $wishlist = $wishlistModel->getWishlistByUser($userId);

        $data = [
            'title' => 'My Wishlist',
            'wishlist' => $wishlist,
        ];

        return view('wishlist/index', $data);
    }

    public function toggle()
    {
        if (!session()->get('isLoggedIn')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu.',
                    'redirect' => '/login'
                ]);
            }
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $wishlistModel = new WishlistModel();
        $produkModel = new ProdukModel();
        
        $userId = session()->get('id');
        $produkId = $this->request->getPost('produk_id');

        $produk = $produkModel->find($produkId);
        if (!$produk) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.'
                ]);
            }
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $isAdded = $wishlistModel->toggleWishlist($userId, $produkId);

        // Count total wishlist items
        $totalWishlist = $wishlistModel->where('user_id', $userId)->countAllResults();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'isAdded' => $isAdded,
                'message' => $isAdded ? 'Produk ditambahkan ke wishlist!' : 'Produk dihapus dari wishlist!',
                'totalWishlist' => $totalWishlist
            ]);
        }

        $message = $isAdded ? 'Produk ditambahkan ke wishlist!' : 'Produk dihapus dari wishlist!';
        return redirect()->back()->with('success', $message);
    }

    public function remove($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $wishlistModel = new WishlistModel();
        $userId = session()->get('id');

        $item = $wishlistModel->where('id', $id)
                              ->where('user_id', $userId)
                              ->first();

        if ($item) {
            $wishlistModel->delete($id);
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari wishlist.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }
}
