<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/produk', 'Home::produk');

//kontak
$routes->get('/kontak', 'Home::kontak');
$routes->post('/kontak/kirim', 'Home::kirimPesan');

//blog
$routes->get('/blog', 'Home::blog');
$routes->get('/blog/detail/(:num)', 'Home::blogDetail/$1');

$routes->get('/tentang', 'Home::tentang');
$routes->get('/checkout', 'Home::checkout');
$routes->get('/login', 'Home::login');
$routes->get('/register', 'Home::register');

$routes->get('/mug', 'Home::mug');
$routes->get('/kaos', 'Home::kaos');
$routes->get('/tumbler', 'Home::tumbler');

