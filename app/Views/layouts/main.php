<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Souvnela - Souvenir Polinela' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">Souvnela</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Beranda' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= ($title ?? '') == 'Produk' ? 'active' : '' ?>" href="<?= base_url('produk') ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Produk
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('produk#mug') ?>">Mug Polinela</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('produk#kaos') ?>">Kaos Polinela</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('produk#tumbler') ?>">Tumbler Polinela</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('produk') ?>">Semua Produk</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link <?= ($title ?? '') == 'Kontak' ? 'active' : '' ?>" href="<?= base_url('kontak') ?>">Kontak</a></li>
                <li class="nav-item"><a class="nav-link <?= ($title ?? '') == 'Blog' ? 'active' : '' ?>" href="<?= base_url('blog') ?>">Blog</a></li>
                <li class="nav-item"><a class="nav-link <?= ($title ?? '') == 'Tentang' ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang Kami</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('checkout') ?>" title="Keranjang">
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

<!-- MAIN CONTENT -->
<main>
    <?= $this->renderSection('content') ?>
</main>

<!-- Footer -->
<footer class="text-white pt-5" style="background-color:#002254;">
    <div class="container pb-4">
        <div class="row text-start">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Souvnela</h5>
                <p class="small">
                    <strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>.
                    Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.
                </p>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Lokasi</h5>
                <div class="ratio ratio-4x3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!..." style="border:0; min-height:200px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
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
                <h5 class="fw-bold mb-3">Media Sosial</h5>
                <div class="d-flex gap-3 fs-5 mt-3">
                    <a href="#" class="text-white social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="text-center py-3" style="background-color: #001a40;">
        <small>&copy; <?= date('Y'); ?> Souvnela - Souvenir Eksklusif Polinela. Proyek Mandiri.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
