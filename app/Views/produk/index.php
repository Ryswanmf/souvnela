<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Produk Page -->
<section id="produk" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Daftar Produk Souvnela</h2>
            <p class="text-muted">Pilih souvenir eksklusif Polinela favoritmu!</p>
        </div>

        <div class="row g-4">
            <!-- Produk Mug -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 product-card">
                    <img src="<?= base_url('assets/images/mug.png') ?>" class="card-img-top" alt="Mug Polinela Eksklusif">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Mug Polinela</h5>
                        <p class="card-text text-muted small">Mug keramik eksklusif dengan logo Polinela.</p>
                        <p class="fw-bold mb-3">Rp 50.000</p>
                        <a href="#" class="btn btn-primary mt-auto">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Produk Kaos -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 product-card">
                    <img src="<?= base_url('assets/images/kaos.png') ?>" class="card-img-top" alt="Kaos Polinela Eksklusif">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Kaos Polinela</h5>
                        <p class="card-text text-muted small">Kaos cotton combed 30s dengan desain modern.</p>
                        <p class="fw-bold mb-3">Rp 100.000</p>
                        <a href="#" class="btn btn-primary mt-auto">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Produk Tumbler -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 product-card">
                    <img src="<?= base_url('assets/images/tumbler.png') ?>" class="card-img-top" alt="Tumbler Polinela Eksklusif">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tumbler Polinela</h5>
                        <p class="card-text text-muted small">Tumbler stainless steel tahan lama dan stylish.</p>
                        <p class="fw-bold mb-3">Rp 75.000</p>
                        <a href="#" class="btn btn-primary mt-auto">Pesan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambahan produk lainnya -->
        <div class="row g-4 mt-4">
            <!-- Produk Topi -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 product-card">
                    <img src="<?= base_url('assets/images/topi.png') ?>" class="card-img-top" alt="Topi Polinela Eksklusif">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Topi Polinela</h5>
                        <p class="card-text text-muted small">Topi keren dengan bordir logo Polinela.</p>
                        <p class="fw-bold mb-3">Rp 60.000</p>
                        <a href="#" class="btn btn-primary mt-auto">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Produk Tote Bag -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 product-card">
                    <img src="<?= base_url('assets/images/totebag.png') ?>" class="card-img-top" alt="Tote Bag Polinela Eksklusif">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tote Bag Polinela</h5>
                        <p class="card-text text-muted small">Tote bag eco-friendly untuk kebutuhan sehari-hari.</p>
                        <p class="fw-bold mb-3">Rp 40.000</p>
                        <a href="#" class="btn btn-primary mt-auto">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Produk Lanyard -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 product-card">
                    <img src="<?= base_url('assets/images/lanyard.png') ?>" class="card-img-top" alt="Lanyard Polinela Eksklusif">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Lanyard Polinela</h5>
                        <p class="card-text text-muted small">Lanyard dengan desain unik untuk ID card kampusmu.</p>
                        <p class="fw-bold mb-3">Rp 25.000</p>
                        <a href="#" class="btn btn-primary mt-auto">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
