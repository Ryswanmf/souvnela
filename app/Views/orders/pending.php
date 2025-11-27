<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="bi bi-clock text-warning" style="font-size: 4rem;"></i>
                        </div>

                        <h2 class="mb-3">Menunggu Pembayaran</h2>
                        <p class="text-muted mb-4">Pesanan Anda telah dibuat. Silakan selesaikan pembayaran untuk melanjutkan.</p>

                        <div class="bg-light rounded p-3 mb-4">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <small class="text-muted">No. Pesanan</small>
                                    <h5 class="mb-0">#<?= $order['id'] ?></h5>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">Total Bayar</small>
                                    <h5 class="mb-0 text-warning">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></h5>
                                </div>
                            </div>
                            <div class="mt-3">
                                <small><i class="bi bi-info-circle"></i> Status: <strong>Menunggu Pembayaran</strong></small>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Pesanan akan otomatis dibatalkan jika pembayaran tidak dilakukan dalam 24 jam.
                        </div>

                        <div class="mt-4">
                            <a href="<?= base_url('orders/detail/' . $order['id']) ?>" class="btn btn-primary me-2">
                                <i class="bi bi-receipt"></i> Lihat Detail & Bayar
                            </a>
                            <a href="<?= base_url('orders') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-list"></i> Pesanan Saya
                            </a>
                        </div>

                        <div class="mt-4">
                            <a href="<?= base_url('produk') ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
