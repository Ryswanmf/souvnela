<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
    }

    public function produk()
    {
        return view('produk', ['title' => 'Produk']);
    }

    public function kontak()
    {
        return view('kontak/kontak.php', ['title' => 'Kontak']);
    }

    public function kirimPesan()
{
    $nama = $this->request->getPost('name');
    $email = $this->request->getPost('email');
    $subject = $this->request->getPost('subject');
    $message = $this->request->getPost('message');

    // sementara, tampilkan hasil
    return redirect()->to('/kontak')->with('success', "Pesan dari $nama berhasil dikirim!");
}


    public function blog()
    {
        return view('blog/blog.php');
    }

    public function blogDetail($id)
    {
        // sementara tampilkan dummy detail
        return view('blog/blog_detail', ['id' => $id]);
    }


    public function tentang()
    {
        return view('tentang/tentang.php', ['title' => 'Tentang Kami']);
    }

    public function checkout()
    {
        return view('checkout', ['title' => 'Checkout']);
    }

    public function login()
    {
        return view('login/login.php', ['title' => 'Login']);
    }
    public function register()
    {
        return view('login/register.php', ['title' => 'Register']);
    }

    public function mug()
    {
        return view('produk/mug.php', ['title' => 'Mug']);
    }
    
    public function kaos()
    {
        return view('produk/kaos.php', ['title' => 'Kaos']);
    }

    public function tumbler()
    {
        return view('produk/tumbler.php', ['title' => 'tumbler']);
    }
}
