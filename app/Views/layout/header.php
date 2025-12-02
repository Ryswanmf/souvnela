<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">Souvnela</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('produk') ?>">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('kontak') ?>">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('blog') ?>">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('tentang') ?>">Tentang Kami</a>
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
                        <?php
                        if (session()->get('isLoggedIn')) {
                            $wishlistModel = new \App\Models\WishlistModel();
                            $totalWishlist = $wishlistModel->where('user_id', session()->get('id'))->countAllResults();
                            if ($totalWishlist > 0):
                        ?>
                        <span class="position-absolute translate-middle badge rounded-circle bg-danger wishlist-badge">
                            <?= $totalWishlist > 99 ? '99+' : $totalWishlist ?>
                            <span class="visually-hidden">wishlist items</span>
                        </span>
                        <?php
                            endif;
                        }
                        ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= base_url('cart') ?>" title="Keranjang">
                        <i class="bi bi-cart3 fs-5"></i>
                        <?php
                        $cart = session()->get('cart') ?? [];
                        $totalItems = 0;
                        foreach ($cart as $item) {
                            $totalItems += ($item['quantity'] ?? $item['jumlah'] ?? 0); // Use 0 as fallback for count
                        }
                        if ($totalItems > 0):
                        ?>
                        <span class="position-absolute translate-middle badge rounded-circle bg-danger cart-badge">
                            <?= $totalItems > 99 ? '99+' : $totalItems ?>
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
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
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