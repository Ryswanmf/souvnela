<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="checkout" class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Checkout</h2>

        <div class="row g-5">
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Pesanan</h5>
                        <?php foreach ($cart as $item): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0"><?= esc($item['nama']) ?></h6>
                                    <small class="text-muted">Jumlah: <?= $item['quantity'] ?></small>
                                </div>
                                <span class="fw-medium"><?= number_to_currency($item['harga'] * $item['quantity'], 'IDR') ?></span>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                        <div class="d-flex justify-content-between align-items-center fw-bold fs-5">
                            <span>Total</span>
                            <span><?= number_to_currency($total, 'IDR') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Alamat Pengiriman</h5>
                        <p>
                            <strong><?= esc(session()->get('nama_lengkap')) ?></strong><br>
                            (Informasi alamat dan kontak akan diambil dari profil pengguna jika ada. Untuk saat ini, kita anggap pesanan akan diambil di tempat.)
                        </p>
                        <hr>
                        <form action="<?= base_url('place-order') ?>" method="post">
                            <?= csrf_field() ?>
                            <p class="text-muted small">Dengan mengklik tombol di bawah, Anda menyetujui untuk menyelesaikan pesanan ini.</p>
                            <button type="submit" class="btn btn-primary w-100">Konfirmasi Pesanan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
