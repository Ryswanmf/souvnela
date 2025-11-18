<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================
// FRONTEND ROUTES
// ==========================
$routes->get('/', 'Home::index');
$routes->get('produk', 'Produk::index');
$routes->get('produk/detail/(:num)', 'Produk::detail/$1');
$routes->get('kontak', 'Home::kontak');
$routes->post('kontak/kirim', 'Home::kirimPesan');
$routes->get('blog', 'Home::blog');
$routes->get('blog/detail/(:num)', 'Home::blogDetail/$1');
$routes->get('tentang', 'Home::tentang');
$routes->get('checkout', 'Cart::checkout');

$routes->get('mug', 'Home::mug');
$routes->get('kaos', 'Home::kaos');
$routes->get('tumbler', 'Home::tumbler');

// Cart Routes
$routes->post('cart/add', 'Cart::add');
$routes->get('cart', 'Cart::index');
$routes->post('cart/update', 'Cart::update');
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->post('place-order', 'Cart::placeOrder');
$routes->get('order-success', 'Cart::success');

// ==========================
// AUTH ROUTES
// ==========================
$routes->get('login', 'Auth::login');                   // alias agar bisa /login
$routes->post('loginProcess', 'Auth::loginProcess');   // POST login
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register'); // Menampilkan form
$routes->post('registerProcess', 'Auth::registerProcess'); // Memproses form

// ==========================
// ACCOUNT ROUTES
// ==========================
$routes->get('account', 'AccountController::index');
$routes->get('account/cancel/(:num)', 'AccountController::cancelOrder/$1');

// ==========================
// ADMIN ROUTES
// ==========================
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('produk', 'Produk::index');
    $routes->get('produk/create', 'Produk::create');
    $routes->post('produk/store', 'Produk::store');
    $routes->get('produk/edit/(:num)', 'Produk::edit/$1');
    $routes->post('produk/update/(:num)', 'Produk::update/$1');
    $routes->get('produk/toggleFeatured/(:num)', 'Produk::toggleFeatured/$1');
    $routes->get('produk/hapus/(:num)', 'Produk::hapus/$1');
    $routes->get('pesanan', 'Pesanan::index');
    $routes->post('pesanan/updateStatus/(:num)', 'Pesanan::updateStatus/$1');
    $routes->get('blog', 'Blog::index');
    $routes->get('blog/create', 'Blog::create');
    $routes->post('blog/store', 'Blog::store');
    $routes->get('blog/edit/(:num)', 'Blog::edit/$1');
    $routes->post('blog/update/(:num)', 'Blog::update/$1');
    $routes->get('blog/hapus/(:num)', 'Blog::hapus/$1');

    // Kategori Produk Routes
    $routes->get('kategori', 'KategoriProdukController::index');
    $routes->get('kategori/create', 'KategoriProdukController::create');
    $routes->post('kategori/store', 'KategoriProdukController::store');
    $routes->get('kategori/edit/(:num)', 'KategoriProdukController::edit/$1');
    $routes->post('kategori/update/(:num)', 'KategoriProdukController::update/$1');
    $routes->get('kategori/delete/(:num)', 'KategoriProdukController::delete/$1');

    $routes->get('pengguna', 'Pengguna::index');
    $routes->get('pengguna/edit/(:num)', 'Pengguna::edit/$1');
    $routes->post('pengguna/update/(:num)', 'Pengguna::update/$1');
    $routes->get('pengguna/hapus/(:num)', 'Pengguna::hapus/$1');
    $routes->get('kontak', 'Kontak::index');
    $routes->get('kontak/hapus/(:num)', 'Kontak::hapus/$1');
    $routes->get('setting/hero', 'Setting::hero');
    $routes->post('setting/update_hero', 'Setting::update_hero');
    $routes->get('setting/features', 'Setting::features');
    $routes->post('setting/update_features', 'Setting::update_features');
    $routes->get('setting/about', 'Setting::about');
    $routes->post('setting/update_about', 'Setting::update_about');
    $routes->get('setting/contact', 'Setting::contact');
    $routes->post('setting/update_contact', 'Setting::update_contact');
    $routes->get('setting/general', 'Setting::general');
    $routes->post('setting/update_general', 'Setting::update_general');

    $routes->get('testimonial', 'Testimonial::index');
    $routes->get('testimonial/create', 'Testimonial::create');
    $routes->post('testimonial/store', 'Testimonial::store');
    $routes->get('testimonial/edit/(:num)', 'Testimonial::edit/$1');
    $routes->post('testimonial/update/(:num)', 'Testimonial::update/$1');
    $routes->get('testimonial/delete/(:num)', 'Testimonial::delete/$1');
});







$routes->get('(:any)', 'Home::index');
