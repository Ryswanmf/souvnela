<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Berikan Ulasan Produk</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Product Info -->
                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                            <img src="<?= !empty($produk['gambar']) ? base_url('uploads/' . $produk['gambar']) : base_url('assets/images/default-product.png') ?>" 
                                 alt="<?= esc($produk['nama']) ?>" 
                                 class="rounded me-3" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-1"><?= esc($produk['nama']) ?></h6>
                                <small class="text-muted"><?= esc($produk['kategori']) ?></small>
                            </div>
                        </div>

                        <form action="<?= base_url('reviews/submit') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $produk['id'] ?>">
                            
                            <!-- Rating -->
                            <div class="mb-4 text-center">
                                <label class="form-label d-block fw-bold mb-2">Bagaimana kualitas produk ini?</label>
                                <div class="rating-input d-inline-block">
                                    <input type="radio" name="rating" id="star5" value="5" required checked>
                                    <label for="star5" title="Sangat Bagus"><i class="bi bi-star-fill"></i></label>
                                    
                                    <input type="radio" name="rating" id="star4" value="4">
                                    <label for="star4" title="Bagus"><i class="bi bi-star-fill"></i></label>
                                    
                                    <input type="radio" name="rating" id="star3" value="3">
                                    <label for="star3" title="Cukup"><i class="bi bi-star-fill"></i></label>
                                    
                                    <input type="radio" name="rating" id="star2" value="2">
                                    <label for="star2" title="Kurang"><i class="bi bi-star-fill"></i></label>
                                    
                                    <input type="radio" name="rating" id="star1" value="1">
                                    <label for="star1" title="Sangat Kurang"><i class="bi bi-star-fill"></i></label>
                                </div>
                            </div>

                            <!-- Review Text -->
                            <div class="mb-3">
                                <label for="review" class="form-label fw-bold">Ulasan Anda</label>
                                <textarea name="review" id="review" rows="4" class="form-control" placeholder="Ceritakan pengalaman Anda menggunakan produk ini..." required></textarea>
                            </div>

                            <!-- Photo Upload (Optional) -->
                            <div class="mb-4">
                                <label for="photo" class="form-label fw-bold">Foto Produk (Opsional)</label>
                                <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2 fw-bold">Kirim Ulasan</button>
                                <a href="<?= base_url('orders') ?>" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .rating-input {
        direction: rtl; /* Right to left for star filling effect */
    }
    .rating-input input {
        display: none;
    }
    .rating-input label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
        padding: 0 5px;
    }
    .rating-input label:hover,
    .rating-input label:hover ~ label,
    .rating-input input:checked ~ label {
        color: #ffc107; /* Gold color */
    }
</style>

<?= $this->endSection() ?>
