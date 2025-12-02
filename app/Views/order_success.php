<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="order-success" class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-4 text-center">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <div class="icon-box mx-auto bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="bi bi-check-lg text-success display-3"></i>
                            </div>
                        </div>
                        
                        <h2 class="fw-bold text-dark mb-3">Pesanan Berhasil!</h2>
                        
                        <p class="text-muted mb-4 fs-5">
                            Terima kasih telah berbelanja di <strong>Souvnela</strong>.
                        </p>

                        <div class="alert alert-light border-start border-success border-4 text-start shadow-sm mb-4">
                            <h6 class="alert-heading fw-bold mb-1"><i class="bi bi-info-circle me-2 text-success"></i>Status Pesanan</h6>
                            <p class="mb-0 small text-muted">
                                Pesanan Anda sedang diproses oleh sistem kami. Silakan cek email Anda atau menu <strong>Pesanan Saya</strong> untuk memantau status pengiriman.
                            </p>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="<?= base_url('orders') ?>" class="btn btn-outline-primary px-4 py-2 fw-semibold">
                                <i class="bi bi-bag-check me-2"></i>Lihat Pesanan Saya
                            </a>
                            <a href="<?= base_url('/') ?>" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-house-door me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-3 text-muted small">
                        Butuh bantuan? <a href="<?= base_url('kontak') ?>" class="text-decoration-none fw-bold">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bg-success-subtle {
        background-color: #d1e7dd !important;
    }
    /* Animation for success icon */
    .icon-box i {
        animation: scaleUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        transform: scale(0);
    }
    @keyframes scaleUp {
        to { transform: scale(1); }
    }
</style>

<?= $this->endSection() ?>