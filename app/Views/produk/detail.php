<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="produk-detail" class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/produk') ?>">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($produk['nama']) ?></li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Gambar Produk -->
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <img src="<?= base_url('uploads/' . esc($produk['gambar'])) ?>" 
                         class="card-img-top" 
                         alt="<?= esc($produk['nama']) ?>"
                         style="width: 100%; height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="fw-bold mb-3"><?= esc($produk['nama']) ?></h2>
                        
                        <!-- Kategori -->
                        <div class="mb-3">
                            <span class="badge bg-primary">
                                <i class="bi bi-tag"></i> <?= esc($produk['kategori']) ?>
                            </span>
                        </div>

                        <!-- Harga -->
                        <div class="mb-4">
                            <h3 class="text-primary fw-bold">
                                Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                            </h3>
                        </div>

                        <!-- Stok -->
                        <div class="mb-4">
                            <h6 class="text-muted">
                                <i class="bi bi-box"></i> Stok Tersedia: 
                                <span class="fw-bold text-dark"><?= esc($produk['stok']) ?> Unit</span>
                            </h6>
                        </div>

                        <hr>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-card-text me-2"></i>Deskripsi Produk
                            </h5>
                            <p class="text-muted" style="text-align: justify;">
                                <?= nl2br(esc($produk['deskripsi'])) ?>
                            </p>
                        </div>

                        <hr>

                        <!-- Form Pemesanan -->
                        <form action="<?= base_url('cart/add') ?>" method="post" class="add-to-cart-form">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $produk['id'] ?>">
                            
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label fw-bold">Jumlah</label>
                                    <input type="number" 
                                           class="form-control form-control-lg" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="1" 
                                           min="1" 
                                           max="<?= $produk['stok'] ?>"
                                           required>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                                        </button>
                                        <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary btn-lg">
                                            <i class="bi bi-arrow-left me-2"></i>Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Info Tambahan -->
                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Pastikan stok tersedia sebelum melakukan pemesanan. Untuk pemesanan dalam jumlah besar, silakan hubungi customer service kami.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terkait (Optional) -->
        <div class="mt-5">
            <h4 class="fw-bold mb-4">
                <i class="bi bi-grid-3x3 me-2"></i>Produk Terkait
            </h4>
            <div class="text-center text-muted py-4">
                <p>Lihat produk lainnya di kategori <strong><?= esc($produk['kategori']) ?></strong></p>
                <a href="<?= base_url('produk?kategori=' . urlencode($produk['kategori'])) ?>" class="btn btn-outline-primary">
                    <i class="bi bi-eye me-2"></i>Lihat Kategori Ini
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.breadcrumb-item a {
    text-decoration: none;
}
.breadcrumb-item a:hover {
    text-decoration: underline;
}
</style>

<?= $this->endSection() ?>
