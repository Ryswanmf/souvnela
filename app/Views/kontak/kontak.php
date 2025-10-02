<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="kontak" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Kontak Kami</h2>
            <p class="text-muted">Terima kasih telah mengunjungi Souvnela! Jika Anda memiliki pertanyaan tentang produk souvenir eksklusif Polinela, 
                                status pesanan, atau ingin memberikan masukan, silakan isi formulir kontak ini. 
                                Kami berkomitmen untuk memberikan pelayanan terbaik dan akan segera menghubungi Anda.</p>
        </div>

        <div class="row g-4">
            <!-- Form -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Form Kontak Kami</h5>
                        <form action="<?= base_url('kontak/kirim') ?>" method="post">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="Nama" required>
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="subject" placeholder="Judul" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 text-white" style="background-color: #0d6efd;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Kontak Kami</h5>
                        <p class="mb-3">
                            Kami siap membantu Anda. Jika Anda memiliki pertanyaan, saran, atau masukan terkait produk Souvnela, jangan ragu untuk menghubungi kami melalui informasi kontak di bawah ini.
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <strong>Alamat:</strong> Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <strong>Telepon:</strong> +62 812 3456 7890
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <strong>Instagram:</strong> souvnela
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-tiktok me-2"></i>
                            <strong>TikTok:</strong> @souvnela
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-globe me-2"></i>
                            <strong>Email:</strong> souvnela@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
