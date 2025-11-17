<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="order-success" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h2 class="fw-bold mt-4">Pesanan Anda Berhasil Dibuat!</h2>
                <p class="text-muted fs-5">
                    Terima kasih telah berbelanja di Souvnela.
                </p>
                <p>
                    Pesanan Anda sedang kami proses. Anda akan menerima notifikasi lebih lanjut mengenai status pesanan Anda. 
                    (Fitur notifikasi saat ini belum diimplementasikan).
                </p>
                <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>