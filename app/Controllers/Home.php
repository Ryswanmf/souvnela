<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\ProdukModel;
use App\Models\TestimonialModel;
use App\Models\HomeSettingModel;
use App\Models\GeneralSettingModel;
use App\Models\WishlistModel;

class Home extends BaseController
{
    public function index(): string
    {
        $produkModel = new ProdukModel();
        $blogModel = new BlogModel();
        $testimonialModel = new TestimonialModel();
        $wishlistModel = new WishlistModel();
        $homeSettingModel = new HomeSettingModel();
        $generalSettingModel = new GeneralSettingModel();

        $data['title'] = 'Beranda';

        // Optimized caching with longer TTL (24 hours instead of 1 hour)
        if (!$data['products'] = cache('featured_products')) {
            // Use select to get only needed fields and limit to 6 for faster loading
            $data['products'] = $produkModel->select('id, nama, harga, gambar, stok, kategori')
                                           ->where('is_unggulan', 1)
                                           ->limit(6)
                                           ->findAll();
            cache()->save('featured_products', $data['products'], 86400); // 24 hours
        }

        if (!$data['posts'] = cache('blog_posts')) {
            // Limit blog posts to 3 for home page
            $data['posts'] = $blogModel->select('id, judul, konten, gambar')
                                      ->limit(3)
                                      ->findAll();
            cache()->save('blog_posts', $data['posts'], 86400);
        }

        if (!$data['testimonials'] = cache('testimonials')) {
            $data['testimonials'] = $testimonialModel->findAll();
            cache()->save('testimonials', $data['testimonials'], 86400);
        }

        // Load settings
        if (!$homeSettings = cache('home_settings')) {
            $homeSettings = $homeSettingModel->first();
            cache()->save('home_settings', $homeSettings, 86400);
        }

        if (!$generalSettings = cache('general_settings')) {
            $generalSettings = $generalSettingModel->first();
            cache()->save('general_settings', $generalSettings, 86400);
        }

        $data['settings'] = [
            'home' => $homeSettings,
            'general' => $generalSettings
        ];

        $data['wishlist'] = [];

        if (session()->get('isLoggedIn')) {
            // Cache wishlist for logged-in users (1 hour)
            $userId = session()->get('id');
            $cacheKey = 'wishlist_' . $userId;
            if (!$data['wishlist'] = cache($cacheKey)) {
                $wishlistItems = $wishlistModel->select('produk_id')
                                              ->where('user_id', $userId)
                                              ->findAll();
                $data['wishlist'] = array_column($wishlistItems, 'produk_id');
                cache()->save($cacheKey, $data['wishlist'], 3600);
            }
        }

        return view('home', $data);
    }

    public function kontak(): string
    {
        $data['title'] = 'Kontak';
        return view('kontak/kontak', $data);
    }

    public function blog(): string
    {
        $blogModel = new BlogModel();
        $data['title'] = 'Blog';
        $data['posts'] = $blogModel->findAll();
        return view('blog/blog', $data);
    }

    public function blogDetail($id): string
    {
        $blogModel = new BlogModel();
        $post = $blogModel->find($id);

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['title'] = $post['judul'];
        $data['post'] = $post;
        return view('blog/blog_detail', $data);
    }

    public function tentang(): string
    {
        $homeSettingModel = new HomeSettingModel();
        $generalSettingModel = new GeneralSettingModel();
        $data['title'] = 'Tentang Kami';

        if (!$homeSettings = cache('home_settings')) {
            $homeSettings = $homeSettingModel->first();
            cache()->save('home_settings', $homeSettings, 3600);
        }

        if (!$generalSettings = cache('general_settings')) {
            $generalSettings = $generalSettingModel->first();
            cache()->save('general_settings', $generalSettings, 3600);
        }

        $data['settings'] = [
            'home' => $homeSettings,
            'general' => $generalSettings
        ];

        return view('tentang/tentang', $data);
    }
}
