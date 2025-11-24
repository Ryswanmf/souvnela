<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\ProdukModel;
use App\Models\TestimonialModel;
use App\Models\HomeSettingModel;
use App\Models\WishlistModel;

class Home extends BaseController
{
    public function index(): string
    {
        $produkModel = new ProdukModel();
        $blogModel = new BlogModel();
        $testimonialModel = new TestimonialModel();
        $wishlistModel = new WishlistModel();

        $data['title'] = 'Beranda';
        $data['products'] = $produkModel->where('is_unggulan', 1)->findAll();
        $data['posts'] = $blogModel->findAll();
        $data['testimonials'] = $testimonialModel->findAll();
        $data['wishlist'] = [];

        if (session()->get('isLoggedIn')) {
            $wishlistItems = $wishlistModel->where('user_id', session()->get('id'))->findAll();
            $data['wishlist'] = array_column($wishlistItems, 'produk_id');
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
        $data['title'] = 'Tentang Kami';
        $data['settings'] = $homeSettingModel->first();
        return view('tentang/tentang', $data);
    }
}
