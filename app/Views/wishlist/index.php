<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="wishlist" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold"><i class="bi bi-heart-fill text-danger"></i> My Wishlist</h2>
            <p class="text-muted">Produk yang kamu simpan untuk dibeli nanti</p>
        </div>

        <?php if (!empty($wishlist)): ?>
        <div class="row g-4">
            <?php foreach ($wishlist as $item): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-sm h-100 product-card position-relative">
                        <!-- Remove from Wishlist Button -->
                        <button class="btn btn-sm position-absolute top-0 end-0 m-1 remove-wishlist-btn"
                                onclick="removeFromWishlist(<?= $item['id'] ?>)"
                                style="z-index: 10; background: rgba(255,255,255,0.95); border: none; width: 30px; height: 30px; padding: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <i class="bi bi-x text-danger" style="font-size: 0.9rem;"></i>
                        </button>

                        <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>"
                             class="card-img-top"
                             alt="<?= esc($item['nama']) ?>"
                             style="height:200px; object-fit:cover;">

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title mb-2" style="font-size: 0.9rem; line-height: 1.3;">
                                <?= esc($item['nama']) ?>
                            </h6>
                            <p class="fw-bold mb-2 text-primary" style="font-size: 1.1rem;">
                                Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                            </p>
                            <p class="text-muted mb-2" style="font-size: 0.8rem;">
                                <i class="bi bi-box"></i> Stok: <?= esc($item['stok']) ?> |
                                <i class="bi bi-tag"></i> <?= esc($item['kategori']) ?>
                            </p>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="<?= base_url('produk/detail/' . $item['produk_id']) ?>"
                                   class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                                <form action="<?= base_url('cart/add') ?>" method="post" class="flex-fill add-to-cart-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $item['produk_id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-cart-plus"></i> Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-heart" style="font-size: 4rem; color: #ddd;"></i>
                </div>
                <h4 class="text-muted mb-3">Wishlist Kosong</h4>
                <p class="text-muted mb-4">Belum ada produk yang kamu simpan ke wishlist.</p>
                <a href="<?= base_url('produk') ?>" class="btn btn-primary">
                    <i class="bi bi-shop"></i> Jelajahi Produk
                </a>
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
.remove-wishlist-btn:hover {
    background: rgba(220, 53, 69, 0.1) !important;
}
</style>

<script>
function removeFromWishlist(wishlistId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini dari wishlist?')) {
        window.location.href = '<?= base_url('wishlist/remove/') ?>' + wishlistId;
    }
}

// Add to cart animation (reuse from product pages)
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.add-to-cart-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i> Menambah...';
            button.disabled = true;

            // Re-enable after 2 seconds if no redirect happens
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        });
    });
});
</script>

<?= $this->endSection() ?>
