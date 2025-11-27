
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Politeknik Negeri Lampung' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/bundle.min.css') ?>">
</head>
<body>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('/') ?>">
            <img src="<?= base_url('uploads/logo.png') ?>" alt="Souvnela Logo" height="40" class="me-2" onerror="this.style.display='none'">
            Souvnela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item ">
                    <a class="nav-link <?= ($title ?? '') == 'Beranda' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Produk' ? 'active' : '' ?>" href="<?= base_url('produk') ?>">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Kontak' ? 'active' : '' ?>" href="<?= base_url('kontak') ?>">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Blog' ? 'active' : '' ?>" href="<?= base_url('blog') ?>">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Tentang' ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang Kami</a>
                </li>
                
                <!-- Search Form -->
               <li class="nav-item mt-2">
                    <form action="<?= base_url('produk/search') ?>" method="get" class="d-flex" role="search">
                        <div class="input-group input-group-sm">
                            <input type="text"
                                class="form-control"
                                name="q"
                                placeholder="Cari Produk"
                                value="<?= esc($_GET['q'] ?? '') ?>"
                                style="width: 200px;">
                            <button class="btn btn-outline-primary btn-sm" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                
                <!-- Wishlist Icon -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= base_url('wishlist') ?>" title="Wishlist">
                        <i class="bi bi-heart fs-5"></i>
                        <?php if (isset($navbarData['wishlistCount']) && $navbarData['wishlistCount'] > 0): ?>
                        <span class="position-absolute translate-middle badge rounded-circle bg-danger wishlist-badge">
                            <?= $navbarData['wishlistCount'] > 99 ? '99+' : $navbarData['wishlistCount'] ?>
                            <span class="visually-hidden">wishlist items</span>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= base_url('cart') ?>" title="Keranjang">
                        <i class="bi bi-cart3 fs-5"></i>
                        <?php if (isset($navbarData['cartTotalItems']) && $navbarData['cartTotalItems'] > 0): ?>
                        <span class="position-absolute translate-middle badge rounded-circle bg-danger cart-badge">
                            <?= $navbarData['cartTotalItems'] > 99 ? '99+' : $navbarData['cartTotalItems'] ?>
                            <span class="visually-hidden">items in cart</span>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Orders Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('orders') ?>" title="Pesanan Saya">
                            <i class="bi bi-bag-check fs-5"></i>
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?= esc(session()->get('nama_lengkap')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if (session()->get('role') === 'admin'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('admin') ?>">Dashboard Admin</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profil Saya</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('account') ?>">Pesanan Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>" title="Login">
                            <i class="bi bi-person-circle"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<!-- MAIN CONTENT -->
<main>
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <!-- Flash Messages as Toasts -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="toast align-items-center text-bg-success border-0 shadow-lg show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Berhasil!</strong><br>
                                <small class="text-white-50"><?= session()->getFlashdata('success') ?></small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="toast align-items-center text-bg-danger border-0 shadow-lg show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Oops!</strong><br>
                                <small class="text-white-50"><?= session()->getFlashdata('error') ?></small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="toast align-items-center text-bg-warning border-0 shadow-lg show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Perhatian!</strong><br>
                                <small class="text-dark-50"><?= session()->getFlashdata('warning') ?></small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('info')): ?>
            <div class="toast align-items-center text-bg-info border-0 shadow-lg show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Info!</strong><br>
                                <small class="text-white-50"><?= session()->getFlashdata('info') ?></small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->renderSection('content') ?>
</main>


<!-- Footer -->
<footer class="text-white pt-5" style="background-color:#002254;">
    <div class="container pb-4">
        <div class="row text-start">
            <!-- Column 1: About -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-shop me-2"></i>Souvnela
                </h5>
                <p class="small">
                    <?= $settings['home']['footer_description'] ?? '<strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>. Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.' ?>
                </p>
                <!-- Social Media Icons -->
                <div class="d-flex gap-3 fs-5 mt-3">
                    <a href="<?= esc($settings['general']['facebook_link'] ?? '#') ?>" class="text-white social-icon" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="<?= esc($settings['general']['instagram_link'] ?? '#') ?>" class="text-white social-icon" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="<?= esc($settings['general']['youtube_link'] ?? '#') ?>" class="text-white social-icon" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="<?= esc($settings['general']['tiktok_social_link'] ?? '#') ?>" class="text-white social-icon" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
            </div>
            
            <!-- Column 2: Information -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2"></i>Informasi
                </h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('konfirmasi-pembayaran') ?>" class="text-white text-decoration-none footer-link">Konfirmasi Pembayaran</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('pembayaran-pengiriman') ?>" class="text-white text-decoration-none footer-link">Pembayaran & Pengiriman</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('syarat-ketentuan') ?>" class="text-white text-decoration-none footer-link">Syarat & Ketentuan</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('kebijakan-privasi') ?>" class="text-white text-decoration-none footer-link">Kebijakan Privasi</a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Location -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Lokasi Kami
                </h5>
                <div class="mb-3">
                    <p class="small mb-2">
                        <i class="bi bi-building me-2"></i>
                        <strong>Politeknik Negeri Lampung</strong>
                    </p>
                    <p class="small mb-2">
                        <i class="bi bi-pin-map me-2"></i>
                        Jl. Soekarno Hatta No.10, Rajabasa, Bandar Lampung
                    </p>
                    <p class="small mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        (0721) 787309
                    </p>
                </div>
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm" style="max-height: 200px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.233393349332!2d105.242879314765!3d-5.380172996095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db05f772c729%3A0x112d2d40e1e2b3c!2sPoliteknik%20Negeri%20Lampung!5e0!3m2!1sen!2sid" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="text-center py-3" style="background-color: #001a40;">
        <small>
            <i class="bi bi-c-circle me-1"></i>
            <?= esc($settings['general']['copyright_text'] ?? date('Y') . ' Souvnela - Souvenir Eksklusif Polinela. Proyek Mandiri.') ?>
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.settings = <?= isset($settings) ? json_encode($settings) : '{}' ?>;
        window.base_url = "<?= base_url('/') ?>";
    </script>
<script src="<?= base_url('assets/js/bundle.min.js') ?>"></script>

<style>
@keyframes cartBounce {
    0%, 100% {
        transform: scale(1);
    }
    25% {
        transform: scale(1.3) rotate(-10deg);
    }
    50% {
        transform: scale(1.1) rotate(10deg);
    }
    75% {
        transform: scale(1.2) rotate(-5deg);
    }
}
</style>
</body>
</html>

