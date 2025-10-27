<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="produk" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?= esc($title ?? 'Semua Produk') ?></h2>
            <p class="text-muted">Pilih souvenir eksklusif Polinela favoritmu!</p>
        </div>

        <?php if (!empty($produk)): ?>
        <div id="produkCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <?php 
                // 6 produk per slide (3 atas + 3 bawah)
                $chunked = array_chunk($produk, 6);
                $first = true;
                foreach ($chunked as $group): 
                    $atas = array_slice($group, 0, 3);
                    $bawah = array_slice($group, 3);
                ?>
                    <div class="carousel-item <?= $first ? 'active' : '' ?>">

                        <!-- Baris Atas -->
                        <div class="row g-4 justify-content-center mb-4">
                            <?php foreach ($atas as $p): ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="card shadow-sm h-100 product-card">
                                        <img src="<?= base_url('uploads/' . esc($p['gambar'])) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($p['nama']) ?>" 
                                             style="height:240px; object-fit:cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?= esc($p['nama']) ?></h5>
                                            <p class="card-text text-muted small flex-grow-1"><?= esc($p['deskripsi']) ?></p>
                                            <p class="fw-bold mb-1">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                            <p class="text-muted small mb-3">
                                                Stok: <?= esc($p['stok']) ?> | <?= esc($p['kategori']) ?>
                                            </p>
                                            <form action="<?= base_url('cart/add') ?>" method="post" class="mt-auto">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-cart-plus"></i> Pesan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Baris Bawah -->
                        <div class="row g-4 justify-content-center">
                            <?php foreach ($bawah as $p): ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="card shadow-sm h-100 product-card">
                                        <img src="<?= base_url('uploads/' . esc($p['gambar'])) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($p['nama']) ?>" 
                                             style="height:240px; object-fit:cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?= esc($p['nama']) ?></h5>
                                            <p class="card-text text-muted small flex-grow-1"><?= esc($p['deskripsi']) ?></p>
                                            <p class="fw-bold mb-1">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                            <p class="text-muted small mb-3">
                                                Stok: <?= esc($p['stok']) ?> | <?= esc($p['kategori']) ?>
                                            </p>
                                            <form action="<?= base_url('cart/add') ?>" method="post" class="mt-auto">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-cart-plus"></i> Pesan
                                                </button>
                                            </form>
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

<?= $this->endSection() ?>