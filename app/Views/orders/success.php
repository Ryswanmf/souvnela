<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="order-success" class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-4 text-center">
                    <div class="card-body p-5">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="bi bi-check-lg text-success display-3"></i>
                            </div>
                        </div>
                        
                        <h2 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h2>
                        <p class="text-muted mb-4">Terima kasih, pesanan Anda telah kami terima.</p>

                        <!-- Order Details Summary -->
                        <div class="card bg-light border-0 mb-4 text-start">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted small">No. Pesanan</span>
                                    <span class="fw-bold">#<?= $order['id'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Total Bayar</span>
                                    <span class="fw-bold text-primary fs-5">Rp <?= number_format($order['final_amount'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info d-flex align-items-center text-start" role="alert">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div>
                                Pesanan Anda sedang diproses. Anda dapat melacak status pengiriman di menu <strong>Pesanan Saya</strong>.
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                            <a href="<?= base_url('orders/detail/' . $order['id']) ?>" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-receipt me-2"></i>Detail Pesanan
                            </a>
                            <a href="<?= base_url('orders/invoice/' . $order['id']) ?>" class="btn btn-info px-4 py-2 fw-semibold shadow-sm" target="_blank">
                                <i class="bi bi-printer me-2"></i>Cetak Invoice
                            </a>
                            <a href="<?= base_url('orders') ?>" class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                                <i class="bi bi-list-ul me-2"></i>Riwayat Pesanan
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?= base_url('produk') ?>" class="text-decoration-none text-muted small">
                                <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
