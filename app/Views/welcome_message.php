

✕ [API Error: Model stream ended with empty response text.]<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Souvnela - Souvenir Polinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Souvnela</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('/') ?>">Beranda</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#produk" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Produk
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#mug">Mug Polinela</a></li>
                        <li><a class="dropdown-item" href="#kaos">Kaos Polinela</a></li>
                        <li><a class="dropdown-item" href="#tumbler">Tumbler Polinela</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('produk') ?>">Semua Produk</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('kontak') ?>">Kontak</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('blog') ?>">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('tentang') ?>">Tentang Kami</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cart') ?>" title="Keranjang">
                        <i class="bi bi-cart3"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('login') ?>" title="Login">
                        <i class="bi bi-person-circle"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Souvenir Eksklusif Polinela</h1>
                <p class="lead mb-4">"Tunjukkan identitas kampusmu dengan bangga! Souvnela menghadirkan koleksi merchandise dan suvenir eksklusif yang dirancang khusus untukmu."</p>
                <a href="#produk" class="btn btn-warning btn-lg px-4 py-2">Lihat Produk</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('assets/images/oo.png') ?>" class="img-fluid" alt="Souvenir Polinela">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features py-5">
    <div class="container text-center">
        <h2 class="mb-4">Kenapa Memilih Kami?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="icon mb-3">🎁</div>
                <h5>Kualitas Premium</h5>
                <p>Souvenir terbuat dari bahan berkualitas terbaik untuk kepuasan Anda.</p>
            </div>
            <div class="col-md-4">
                <div class="icon mb-3">⚡</div>
                <h5>Proses Cepat</h5>
                <p>Pesanan diproses dengan cepat agar segera sampai ke tangan Anda.</p>
            </div>
            <div class="col-md-4">
                <div class="icon mb-3">💳</div>
                <h5>Transaksi Mudah</h5>
                <p>Metode pembayaran yang fleksibel dan aman digunakan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Produk -->
<section id="produk" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Produk Unggulan</h2>
        <div class="row g-4">
            <div class="col-md-4" id="mug">
                <div class="card shadow-sm product-card">
                    <img src="<?= base_url('assets/images/mug.png') ?>" class="card-img-top" alt="Mug Polinela Eksklusif">
                    <div class="card-body">
                        <h5 class="card-title">Mug Polinela</h5>
                        <p class="card-text">Rp 50.000</p>
                        <a href="<?= base_url('produk') ?>" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="kaos">
                <div class="card shadow-sm product-card">
                    <img src="<?= base_url('assets/images/kaos.png') ?>" class="card-img-top" alt="Kaos Polinela Eksklusif">
                    <div class="card-body">
                        <h5 class="card-title">Kaos Polinela</h5>
                        <p class="card-text">Rp 100.000</p>
                        <a href="<?= base_url('produk') ?>" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="tumbler">
                <div class="card shadow-sm product-card">
                    <img src="<?= base_url('assets/images/tumbler.png') ?>" class="card-img-top" alt="Tumbler Polinela Eksklusif">
                    <div class="card-body">
                        <h5 class="card-title">Tumbler Polinela</h5>
                        <p class="card-text">Rp 75.000</p>
                        <a href="<?= base_url('produk') ?>" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-5">
    <div class="container text-center">
        <h2>Tentang Kami</h2>
        <p class="lead">Souvnela adalah platform pemesanan souvenir resmi di Politeknik Negeri Lampung. Kami hadir untuk memudahkan mahasiswa, dosen, dan tamu dalam memperoleh merchandise eksklusif kampus.</p>
    </div>
</section>

<!-- Footer -->
<footer class="text-white pt-5" style="background-color:#002254;">
    <div class="container pb-4">
        <div class="row text-start">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Souvnela</h5>
                <p class="small">Platform pemesanan souvenir eksklusif Politeknik Negeri Lampung. Mudah, cepat, dan terpercaya.</p>
                <div class="d-flex gap-3 fs-5 mt-3">
                    <a href="#" class="text-white social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Link Penting</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none footer-link">Konfirmasi Pembayaran</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none footer-link">Pembayaran & Pengiriman</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none footer-link">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-white text-decoration-none footer-link">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Marketplace</h5>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Tokopedia_2022.svg" alt="Tokopedia" height="40"></a>
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Shopee.svg" alt="Shopee" height="40"></a>
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Tiktok_logo.svg" alt="TikTok" height="40"></a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Lokasi</h5>
                <div class="ratio ratio-4x3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.233393349332!2d105.242879314765!3d-5.380172996095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db05f772c729%3A0x112d2d40e1e2b3c!2sPoliteknik%20Negeri%20Lampung!5e0!3m2!1sen!2sid" style="border:0; min-height:200px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="text-center py-3" style="background-color: #001a40;">
        <small><?= esc($settings['general']['copyright_text'] ?? ('&copy; ' . date('Y') . ' Souvnela - Souvenir Eksklusif Polinela. Proyek Mandiri.')) ?></small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const settings = <?= isset($settings) ? json_encode($settings) : '{}' ?>;
</script>
<script src="<?= base_url('assets/js/whatsapp.js') ?>"></script>
</body>
</html>
