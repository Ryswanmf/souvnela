<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="produk" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold"><?= esc($title ?? 'Semua Produk') ?></h2>
            <p class="text-muted">Pilih souvenir eksklusif Polinela favoritmu!</p>
        </div>

        <!-- Filter Kategori -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label class="form-label mb-0 fw-bold">
                                    <i class="bi bi-funnel me-2"></i>Filter Kategori:
                                </label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="kategoriFilter" onchange="window.location.href=this.value">
                                    <option value="<?= base_url('produk') ?>" <?= $selected_kategori === 'semua' ? 'selected' : '' ?>>
                                        Semua Produk
                                    </option>
                                    <?php if (!empty($kategoris)): ?>
                                        <?php foreach ($kategoris as $kat): ?>
                                            <?php if (!empty($kat)): ?>
                                                <option value="<?= base_url('produk?kategori=' . urlencode($kat)) ?>" 
                                                        <?= $selected_kategori === $kat ? 'selected' : '' ?>>
                                                    <?= esc($kat) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
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
                                    <div class="card shadow-sm h-100 product-card">
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
                                    <div class="card shadow-sm h-100 product-card">
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

            <!-- Navigasi Carousel -->
            <?php if (count($chunked) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#produkCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#produkCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Berikutnya</span>
                </button>

                <!-- Indicators -->
                <div class="carousel-indicators position-relative mt-4" style="position: relative; bottom: 0;">
                    <?php foreach ($chunked as $index => $chunk): ?>
                        <button type="button" 
                                data-bs-target="#produkCarousel" 
                                data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>"
                                aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                                aria-label="Slide <?= $index + 1 ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-box" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Tidak ada produk ditemukan</h5>
                <p>Silakan pilih kategori lain atau lihat semua produk</p>
                <a href="<?= base_url('produk') ?>" class="btn btn-primary">Lihat Semua Produk</a>
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
.carousel-indicators button {
    background-color: #002254;
}
</style>

<?= $this->endSection() ?>