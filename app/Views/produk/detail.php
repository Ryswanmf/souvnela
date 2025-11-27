<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('produk') ?>">Produk</a></li>
                <li class="breadcrumb-item active"><?= esc($produk['nama']) ?></li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm position-relative">
                    <!-- Wishlist Heart Icon -->
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php 
                        $wishlistModel = new \App\Models\WishlistModel();
                        $isInWishlist = $wishlistModel->isInWishlist(session()->get('id'), $produk['id']);
                        ?>
                        <button class="btn position-absolute top-0 end-0 m-3 wishlist-btn" 
                                onclick="toggleWishlist(this, <?= $produk['id'] ?>)"
                                style="z-index: 10; background: rgba(255,255,255,0.95); border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                            <i class="bi <?= $isInWishlist ? 'bi-heart-fill' : 'bi-heart' ?> fs-3 text-danger"></i>
                        </button>
                    <?php endif; ?>
                    
                    <img src="<?= base_url('uploads/' . esc($produk['gambar'])) ?>"
                         class="card-img-top rounded"
                         alt="<?= esc($produk['nama']) ?>"
                         style="width: 100%; height: 450px; object-fit: cover;">
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <span class="badge bg-primary mb-2">
                                <i class="bi bi-tag-fill"></i> <?= esc($produk['kategori']) ?>
                            </span>
                        </div>
                        
                        <h2 class="fw-bold mb-3"><?= esc($produk['nama']) ?></h2>
                        
                        <!-- Rating Section -->
                        <?php if (isset($produk['average_rating']) && $produk['total_reviews'] > 0): ?>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="stars me-2">
                                    <?php 
                                    $rating = round($produk['average_rating'] * 2) / 2;
                                    for ($i = 1; $i <= 5; $i++): 
                                        if ($i <= $rating): ?>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        <?php elseif ($i - 0.5 == $rating): ?>
                                            <i class="bi bi-star-half text-warning"></i>
                                        <?php else: ?>
                                            <i class="bi bi-star text-warning"></i>
                                        <?php endif;
                                    endfor; ?>
                                </div>
                                <span class="fw-bold me-2"><?= number_format($produk['average_rating'], 1) ?></span>
                                <span class="text-muted">(<?= $produk['total_reviews'] ?> ulasan)</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <h3 class="text-primary fw-bold mb-0">
                                Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                            </h3>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-box-seam text-muted me-2"></i>
                                <span class="text-muted">Stok:</span>
                                <span class="ms-2 fw-bold <?= $produk['stok'] > 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= $produk['stok'] > 0 ? $produk['stok'] . ' tersedia' : 'Habis' ?>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
                            <p class="text-muted"><?= nl2br(esc($produk['deskripsi'])) ?></p>
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
                                           <?= $produk['stok'] <= 0 ? 'disabled' : '' ?>
                                           required>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" 
                                                class="btn btn-primary btn-lg flex-fill"
                                                <?= $produk['stok'] <= 0 ? 'disabled' : '' ?>>
                                            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                                        </button>
                                        <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary btn-lg">
                                            <i class="bi bi-arrow-left me-2"></i>Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php if ($produk['stok'] <= 0): ?>
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Maaf, produk ini sedang habis. Silakan cek produk lainnya.
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-star me-2"></i>Ulasan Produk 
                                <?php if (isset($reviews) && count($reviews) > 0): ?>
                                    (<?= count($reviews) ?>)
                                <?php endif; ?>
                            </h5>
                            <?php if (session()->get('isLoggedIn') && isset($canReview) && $canReview): ?>
                                <a href="#reviewForm" class="btn btn-primary">
                                    <i class="bi bi-pencil me-2"></i>Tulis Ulasan
                                </a>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($reviews) && count($reviews) > 0): ?>
                            <!-- Reviews List -->
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2"><?= esc($review['user_name']) ?></strong>
                                                <?php if ($review['is_verified_purchase']): ?>
                                                    <span class="badge bg-success" style="font-size: 0.7rem;">
                                                        <i class="bi bi-patch-check"></i> Verified Purchase
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="stars mb-1">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?> text-warning"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <small class="text-muted"><?= date('d M Y', strtotime($review['created_at'])) ?></small>
                                    </div>
                                    
                                    <p class="mb-2"><?= nl2br(esc($review['review_text'])) ?></p>
                                    
                                    <?php if (!empty($review['photos'])): ?>
                                        <div class="review-photos mb-2">
                                            <?php 
                                            $photos = is_string($review['photos']) ? json_decode($review['photos'], true) : $review['photos'];
                                            if (is_array($photos)):
                                                foreach ($photos as $photo): ?>
                                                    <img src="<?= base_url('uploads/reviews/' . esc($photo)) ?>"
                                                         alt="Review photo"
                                                         class="rounded me-2 mb-2"
                                                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                                         onclick="window.open(this.src, '_blank')">
                                                <?php endforeach;
                                            endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-secondary helpful-btn" 
                                                data-review-id="<?= $review['id'] ?>"
                                                <?= !session()->get('isLoggedIn') ? 'disabled' : '' ?>>
                                            <i class="bi bi-hand-thumbs-up"></i>
                                            Helpful <?= $review['helpful_count'] > 0 ? '(' . $review['helpful_count'] . ')' : '' ?>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-chat-quote text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">Belum ada ulasan untuk produk ini.</p>
                                <?php if (session()->get('isLoggedIn') && isset($canReview) && $canReview): ?>
                                    <p class="text-muted">Jadilah yang pertama memberikan ulasan!</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Review Form -->
                        <?php if (session()->get('isLoggedIn') && isset($canReview) && $canReview): ?>
                            <div id="reviewForm" class="border-top pt-4 mt-4">
                                <h6 class="fw-bold mb-3">Tulis Ulasan Anda</h6>
                                <form action="<?= base_url('reviews/submit') ?>" method="post" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="produk_id" value="<?= $produk['id'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                                        <div class="star-rating">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                                                <label for="star<?= $i ?>"><i class="bi bi-star-fill"></i></label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="review_text" class="form-label fw-bold">Ulasan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" 
                                                  id="review_text" 
                                                  name="review_text" 
                                                  rows="4" 
                                                  placeholder="Bagikan pengalaman Anda dengan produk ini..."
                                                  required></textarea>
                                        <small class="text-muted">Minimal 10 karakter</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="photos" class="form-label fw-bold">Foto (Opsional)</label>
                                        <input type="file" 
                                               class="form-control" 
                                               id="photos" 
                                               name="photos[]" 
                                               accept="image/*"
                                               multiple>
                                        <small class="text-muted">Maksimal 5 foto, masing-masing 2MB</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        <?php elseif (!session()->get('isLoggedIn')): ?>
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle me-2"></i>
                                Silakan <a href="<?= base_url('login') ?>">login</a> untuk memberikan ulasan.
                            </div>
                        <?php elseif (session()->get('isLoggedIn') && isset($canReview) && !$canReview): ?>
                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Anda hanya dapat memberikan ulasan setelah membeli produk ini.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Tambahan</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-truck text-primary fs-4 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Pengiriman</h6>
                                        <p class="text-muted small mb-0">Gratis ongkir untuk pembelian minimal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Kualitas Terjamin</h6>
                                        <p class="text-muted small mb-0">Produk resmi Politeknik Negeri Lampung</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-headset text-info fs-4 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Customer Support</h6>
                                        <p class="text-muted small mb-0">Siap membantu Anda 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Star Rating for Review Form */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    font-size: 2rem;
    color: #ddd;
    transition: color 0.2s;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}

.review-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
</style>

<script>
// Helpful button
document.querySelectorAll('.helpful-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const reviewId = this.dataset.reviewId;
        
        fetch('<?= base_url('reviews/helpful/') ?>' + reviewId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal memberikan vote');
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
