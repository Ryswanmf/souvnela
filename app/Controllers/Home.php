<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\ProdukModel;
use App\Models\TestimonialModel;

class Home extends BaseController
{
    public function index(): string
    {
        $produkModel = new ProdukModel();
        $blogModel = new BlogModel();
        $testimonialModel = new TestimonialModel();

        $data['title'] = 'Beranda';
        $data['products'] = $produkModel->findAll();
        $data['posts'] = $blogModel->findAll();
        $data['testimonials'] = $testimonialModel->findAll();

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

    public function tentang(): string
    {
        $data['title'] = 'Tentang Kami';
        return view('tentang/tentang', $data);
    }
}
