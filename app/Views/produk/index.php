<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="produk" class="py-5 bg-light">

        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body py-3">
                        <form action="<?= base_url('produk/search') ?>" method="get">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       name="q"
                                       placeholder="Cari produk..."
                                       value="<?= esc($keyword ?? '') ?>"
                                       required>
                                <button class="btn btn-primary px-3" type="submit">
                                    <i class="bi bi-search me-1"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Kategori Dropdown -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="<?= base_url('produk') ?>" method="get" id="filterForm">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <label for="kategori" class="form-label fw-bold">
                                        <i class="bi bi-funnel"></i> Filter Kategori:
                                    </label>
                                    <select name="kategori" id="kategori" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Kategori</option>
                                        <?php if (!empty($kategoriList)): ?>
                                            <?php foreach ($kategoriList as $kat): ?>
                                                <option value="<?= esc($kat) ?>" <?= (isset($_GET['kategori']) && $_GET['kategori'] == $kat) ? 'selected' : '' ?>>
                                                    <?= esc($kat) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <?php if (isset($_GET['kategori']) && !empty($_GET['kategori'])): ?>
                                        <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary w-100">
                                            <i class="bi bi-x-circle"></i> Reset
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($produk)): ?>
        <div id="produkCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <?php 
                // 10 produk per slide (5 atas + 5 bawah)
                $chunked = array_chunk($produk, 10);
                $first = true;
                foreach ($chunked as $group): 
                    $atas = array_slice($group, 0, 5);
                    $bawah = array_slice($group, 5);
                ?>
                    <div class="carousel-item <?= $first ? 'active' : '' ?>">

                        <!-- Baris Atas -->
                        <div class="row g-3 justify-content-center mb-3">
                            <?php foreach ($atas as $p): ?>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="card shadow-sm h-100 product-card position-relative">
                                        <!-- Wishlist Heart Icon -->
                                        <?php if (session()->get('isLoggedIn')): ?>
                                            <?php 
                                            $wishlistModel = new \App\Models\WishlistModel();
                                            $isInWishlist = $wishlistModel->isInWishlist(session()->get('id'), $p['id']);
                                            ?>
                                            <button class="btn btn-sm position-absolute top-0 end-0 m-1 wishlist-btn" 
                                                    onclick="toggleWishlist(this, <?= $p['id'] ?>)"
                                                    style="z-index: 10; background: rgba(255,255,255,0.95); border: none; width: 30px; height: 30px; padding: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                <i class="bi <?= $isInWishlist ? 'bi-heart-fill' : 'bi-heart' ?> text-danger" style="font-size: 0.9rem;"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <img src="<?= base_url('uploads/' . esc($p['gambar'])) ?>"
                                             class="card-img-top"
                                             alt="<?= esc($p['nama']) ?>"
                                             style="height:150px; object-fit:cover;">
                                        <div class="card-body d-flex flex-column p-2">
                                            <h6 class="card-title small mb-1" style="font-size: 0.85rem;"><?= esc($p['nama']) ?></h6>
                                            <p class="fw-bold mb-1" style="font-size: 0.9rem;">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                            <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-box"></i> <?= esc($p['stok']) ?> | <i class="bi bi-tag"></i> <?= esc($p['kategori']) ?>
                                            </p>
                                            <div class="d-flex gap-1 mt-auto">
                                                <a href="<?= base_url('produk/detail/' . $p['id']) ?>" class="btn btn-outline-primary btn-sm flex-fill" style="font-size: 0.7rem;">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                                <form action="<?= base_url('cart/add') ?>" method="post" class="flex-fill add-to-cart-form">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100" style="font-size: 0.7rem;">
                                                        <i class="bi bi-cart-plus"></i> Pesan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Baris Bawah -->
                        <div class="row g-3 justify-content-center">
                            <?php foreach ($bawah as $p): ?>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="card shadow-sm h-100 product-card position-relative">
                                        <!-- Wishlist Heart Icon -->
                                        <?php if (session()->get('isLoggedIn')): ?>
                                            <?php 
                                            $wishlistModel = new \App\Models\WishlistModel();
                                            $isInWishlist = $wishlistModel->isInWishlist(session()->get('id'), $p['id']);
                                            ?>
                                            <button class="btn btn-sm position-absolute top-0 end-0 m-1 wishlist-btn" 
                                                    onclick="toggleWishlist(this, <?= $p['id'] ?>)"
                                                    style="z-index: 10; background: rgba(255,255,255,0.95); border: none; width: 30px; height: 30px; padding: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                <i class="bi <?= $isInWishlist ? 'bi-heart-fill' : 'bi-heart' ?> text-danger" style="font-size: 0.9rem;"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <img src="<?= base_url('uploads/' . esc($p['gambar'])) ?>"
                                             class="card-img-top"
                                             alt="<?= esc($p['nama']) ?>"
                                             style="height:150px; object-fit:cover;">
                                        <div class="card-body d-flex flex-column p-2">
                                            <h6 class="card-title small mb-1" style="font-size: 0.85rem;"><?= esc($p['nama']) ?></h6>
                                            <p class="fw-bold mb-1" style="font-size: 0.9rem;">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                            <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-box"></i> <?= esc($p['stok']) ?> | <i class="bi bi-tag"></i> <?= esc($p['kategori']) ?>
                                            </p>
                                            <div class="d-flex gap-1 mt-auto">
                                                <a href="<?= base_url('produk/detail/' . $p['id']) ?>" class="btn btn-outline-primary btn-sm flex-fill" style="font-size: 0.7rem;">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                                <form action="<?= base_url('cart/add') ?>" method="post" class="flex-fill add-to-cart-form">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100" style="font-size: 0.7rem;">
                                                        <i class="bi bi-cart-plus"></i> Pesan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php 
                $first = false;
                endforeach; 
                ?>
            </div>

            <!-- Navigasi -->
            <button class="carousel-control-prev" type="button" data-bs-target="#produkCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#produkCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Berikutnya</span>
            </button>
        </div>

        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-box"></i> Belum ada produk.
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-size: 50%, 50%;
}
.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}
</style>

<?= $this->endSection() ?>            <div class="text-center text-muted py-5">
