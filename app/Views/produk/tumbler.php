<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="produk" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?= esc($title) ?> Polinela</h2>
            <p class="text-muted">
                Temukan berbagai pilihan souvenir eksklusif dari <strong>Souvnela</strong> yang dirancang dengan kualitas terbaik dan desain elegan. 
                Cocok untuk acara kampus, kenang-kenangan, maupun hadiah spesial dari Politeknik Negeri Lampung.
            </p>
        </div>

        <div class="row g-4">
            <?php if (!empty($produk)): ?>
                <?php foreach ($produk as $p): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card shadow-sm border-0 h-100">
                            <img src="<?= base_url('uploads/' . esc($p['gambar'])) ?>" class="card-img-top" alt="<?= esc($p['nama']) ?>" style="height:240px; object-fit:cover;">
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="fw-bold"><?= esc($p['nama']) ?></h5>
                                <p class="text-muted small flex-grow-1"><?= esc($p['deskripsi']) ?></p>
                                <p class="fw-bold text-primary">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
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
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-box-seam fs-1"></i>
                        <h4 class="mt-3">Belum Ada Produk</h4>
                        <p>Tidak ada produk dalam kategori ini saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>