<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Souvenir Eksklusif Polinela</h1>
                <p class="lead mb-4">
                    Selamat datang di Souvnela, pusat merchandise dan suvenir resmi Polinela. Kami mengundang Anda untuk menjelajahi koleksi yang tidak hanya unik, tetapi juga dibuat dengan kualitas premium.
                </p>
                <p class="lead mb-4">
                    Setiap desain yang kami hadirkan adalah representasi dari semangat, kreativitas, dan sejarah Politeknik Negeri Lampung.
                    Souvnela lebih dari sekadar toko, ini adalah perayaan identitas kampus. Baik untuk Anda para mahasiswa, alumni, dosen, atau siapa pun yang bangga menjadi bagian dari keluarga besar Polinela, temukan produk yang berbicara tentang perjalanan Anda di sini.
                </p>
                <a href="#produk" class="btn btn-warning btn-lg px-4 py-2">Lihat Produk</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('assets/images/oo.png') ?>" class="img-fluid" alt="Souvenir Polinela">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features py-5">
    <div class="container text-center">
        <h2 class="mb-4">Kenapa Memilih Kami?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="icon mb-3">🎁</div>
                <h5>Kualitas Premium</h5>
                <p>Souvenir terbuat dari bahan berkualitas terbaik untuk kepuasan Anda.</p>
            </div>
            <div class="col-md-4">
                <div class="icon mb-3">⚡</div>
                <h5>Proses Cepat</h5>
                <p>Pesanan diproses dengan cepat agar segera sampai ke tangan Anda.</p>
            </div>
            <div class="col-md-4">
                <div class="icon mb-3">💳</div>
                <h5>Transaksi Mudah</h5>
                <p>Metode pembayaran yang fleksibel dan aman digunakan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Produk -->
<section id="produk" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Produk Unggulan</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm product-card">
                    <img src="<?= base_url('assets/images/mug.png') ?>" class="card-img-top" alt="Mug Polinela Eksklusif">
                    <div class="card-body">
                        <h5 class="card-title">Mug Polinela</h5>
                        <p class="card-text">Rp 50.000</p>
                        <a href="#" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm product-card">
                    <img src="<?= base_url('assets/images/kaos.png') ?>" class="card-img-top" alt="Kaos Polinela Eksklusif">
                    <div class="card-body">
                        <h5 class="card-title">Kaos Polinela</h5>
                        <p class="card-text">Rp 100.000</p>
                        <a href="#" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm product-card">
                    <img src="<?= base_url('assets/images/tumbler.png') ?>" class="card-img-top" alt="Tumbler Polinela Eksklusif">
                    <div class="card-body">
                        <h5 class="card-title">Tumbler Polinela</h5>
                        <p class="card-text">Rp 75.000</p>
                        <a href="#" class="btn btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center">Souvnela - Souvenir Eksklusif Polinela</h2>
        <br>
                <p>
                    <strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>.
                    Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.
                </p>
                <p>
                    Dengan proses pemesanan yang mudah, produk berkualitas, dan layanan terpercaya, kami berkomitmen
                    untuk memberikan pengalaman terbaik bagi seluruh pelanggan.
                </p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Produk eksklusif dan original</li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Bahan berkualitas premium</li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Transaksi aman & cepat</li>
                </ul>
    </div>
</section>

<!-- Blog -->
<section id="blog" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Blog</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= base_url('assets/images/1.jpg') ?>" class="card-img-top" alt="Blog 1">
                    <div class="card-body">
                        <h5 class="card-title">Tips Memilih Souvenir Kampus</h5>
                        <p class="card-text">Panduan lengkap memilih souvenir yang tepat untuk mahasiswa dan dosen.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= base_url('assets/images/2.jpg') ?>" class="card-img-top" alt="Blog 2">
                    <div class="card-body">
                        <h5 class="card-title">Trend Merchandise Kampus 2025</h5>
                        <p class="card-text">Cari tahu tren terbaru merchandise eksklusif di kalangan mahasiswa.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= base_url('assets/images/3.jpg') ?>" class="card-img-top" alt="Blog 3">
                    <div class="card-body">
                        <h5 class="card-title">Kenapa Pilih Souvenir Resmi?</h5>
                        <p class="card-text">Alasan mengapa membeli souvenir resmi kampus lebih bernilai.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kontak Kami -->
<section id="kontak" class="py-5">
    <div class="container">
        <div class="h2 text-center">Kontak</div>
        <div class="row">
            <!-- Form -->
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
                        <h5 class="fw-bold mb-4">Hubungi Kami.</h5>
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
</section>

<?= $this->endSection() ?>
