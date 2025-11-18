<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero py-5" style="min-height: 85vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white text-center text-lg-start mb-4 mb-lg-0" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-3"><?= esc($settings['home']['hero_title'] ?? 'Souvenir Eksklusif Polinela') ?></h1>
                <p class="lead mb-4">
                    <?= esc($settings['home']['hero_subtitle1'] ?? 'Selamat datang di Souvnela, pusat merchandise dan suvenir resmi Polinela. Kami mengundang Anda untuk menjelajahi koleksi yang tidak hanya unik, tetapi juga dibuat dengan kualitas premium.') ?>
                </p>
                <p class="lead mb-4">
                    <?= esc($settings['home']['hero_subtitle2'] ?? 'Setiap desain yang kami hadirkan adalah representasi dari semangat, kreativitas, dan sejarah Politeknik Negeri Lampung. Souvnela lebih dari sekadar toko, ini adalah perayaan identitas kampus. Baik untuk Anda para mahasiswa, alumni, dosen, atau siapa pun yang bangga menjadi bagian dari keluarga besar Polinela, temukan produk yang berbicara tentang perjalanan Anda di sini.') ?>
                </p>
                <a href="<?= base_url('produk') ?>" class="btn btn-warning btn-lg px-4 py-2 pulse-button"><?= esc($settings['home']['hero_button_text'] ?? 'Lihat Produk') ?></a>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <img src="<?= base_url('uploads/' . ($settings['home']['hero_image'] ?? 'oo.png')) ?>" class="img-fluid floating-image" alt="Souvenir Polinela">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features py-5">
    <div class="container text-center">
        <h2 class="mb-4" data-aos="fade-up"><?= esc($settings['home']['features_title'] ?? 'Kenapa Memilih Kami?') ?></h2>
        <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-box">
                    <div class="icon mb-3">
                        <?php if (!empty($settings['home']['feature1_image'])): ?>
                            <img src="<?= base_url('uploads/' . $settings['home']['feature1_image']) ?>" alt="Feature 1 Icon" width="50">
                        <?php else: ?>
                            <?= esc($settings['home']['feature1_icon'] ?? '🎁') ?>
                        <?php endif; ?>
                    </div>
                    <h5><?= esc($settings['home']['feature1_title'] ?? 'Kualitas Premium') ?></h5>
                    <p><?= esc($settings['home']['feature1_description'] ?? 'Souvenir terbuat dari bahan berkualitas terbaik untuk kepuasan Anda.') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box">
                    <div class="icon mb-3">
                        <?php if (!empty($settings['home']['feature2_image'])): ?>
                            <img src="<?= base_url('uploads/' . $settings['home']['feature2_image']) ?>" alt="Feature 2 Icon" width="50">
                        <?php else: ?>
                            <?= esc($settings['home']['feature2_icon'] ?? '⚡') ?>
                        <?php endif; ?>
                    </div>
                    <h5><?= esc($settings['home']['feature2_title'] ?? 'Proses Cepat') ?></h5>
                    <p><?= esc($settings['home']['feature2_description'] ?? 'Pesanan diproses dengan cepat agar segera sampai ke tangan Anda.') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box">
                    <div class="icon mb-3">
                        <?php if (!empty($settings['home']['feature3_image'])): ?>
                            <img src="<?= base_url('uploads/' . $settings['home']['feature3_image']) ?>" alt="Feature 3 Icon" width="50">
                        <?php else: ?>
                            <?= esc($settings['home']['feature3_icon'] ?? '💳') ?>
                        <?php endif; ?>
                    </div>
                    <h5><?= esc($settings['home']['feature3_title'] ?? 'Transaksi Mudah') ?></h5>
                    <p><?= esc($settings['home']['feature3_description'] ?? 'Metode pembayaran yang fleksibel dan aman digunakan.') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produk -->
<section id="produk" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4" data-aos="fade-up">Produk Unggulan</h2>
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php $delay = 0; ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="<?= $delay ?>">
                        <div class="card shadow-sm product-card">
                            <img src="<?= base_url('uploads/' . esc($product['gambar'])) ?>" class="card-img-top" alt="<?= esc($product['nama']) ?>" style="height: 240px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($product['nama']) ?></h5>
                                <p class="card-text">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                                <p class="card-text text-muted small"><?= esc(substr(strip_tags($product['deskripsi']), 0, 70)) ?>...</p>
                                        <form action="<?= base_url('cart/add') ?>" method="post" class="add-to-cart-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-cart-plus"></i> Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php $delay += 100; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada produk unggulan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center" data-aos="fade-up"><?= esc($settings['home']['about_title'] ?? 'Souvnela - Souvenir Eksklusif Polinela') ?></h2>
        <br>
                <p data-aos="fade-up" data-aos-delay="100">
                    <?= $settings['home']['about_description1'] ?? '<strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>. Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.' ?>
                </p>
                <p data-aos="fade-up" data-aos-delay="200">
                    <?= $settings['home']['about_description2'] ?? 'Dengan proses pemesanan yang mudah, produk berkualitas, dan layanan terpercaya, kami berkomitmen untuk memberikan pengalaman terbaik bagi seluruh pelanggan.' ?>
                </p>
                <ul class="list-unstyled" data-aos="fade-up" data-aos-delay="300">
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <?= esc($settings['home']['about_list1'] ?? 'Produk eksklusif dan original') ?>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <?= esc($settings['home']['about_list2'] ?? 'Bahan berkualitas premium') ?>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <?= esc($settings['home']['about_list3'] ?? 'Transaksi aman & cepat') ?>
                    </li>
                </ul>
    </div>
</section>

<!-- Blog -->
<section id="blog" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4" data-aos="fade-up">Blog</h2>
        <div class="row g-4">
            <?php if (!empty($posts)): ?>
                <?php $delay = 0; ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4" data-aos="flip-left" data-aos-delay="<?= $delay ?>">
                        <div class="card shadow-sm h-100 blog-card-hover">
                            <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" class="card-img-top" alt="<?= esc($post['judul']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($post['judul']) ?></h5>
                                <p class="card-text"><?= esc(substr(strip_tags($post['konten']), 0, 100)) ?>...</p>
                                <a href="<?= base_url('blog/detail/' . $post['id']) ?>" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php $delay += 100; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada artikel.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .carousel-control-prev,
    .carousel-control-next {
        opacity: 1 !important;
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 20px;
        height: 20px;
    }
    .features .col-md-4 .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
    }
    .features .col-md-4 .card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
</style>

<!-- Testimonials -->
<section id="testimonials" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4" data-aos="fade-up">Testimoni</h2>
        <div id="testimonialCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false" data-aos="zoom-in" data-aos-delay="100">
            <div class="carousel-inner">
                <?php if (!empty($testimonials)): ?>
                    <?php foreach ($testimonials as $i => $testimonial): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <div class="testimonial-item text-center">
                                <?php if (!empty($testimonial['photo'])): ?>
                                    <img src="<?= base_url('uploads/' . $testimonial['photo']) ?>" alt="Author Photo" class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                                <?php endif; ?>
                                <p class="fs-5 fst-italic">"<?= esc($testimonial['content']) ?>"</p>
                                <h5 class="fw-bold mt-3"><?= esc($testimonial['author']) ?></h5>
                                <p class="text-muted"><?= esc($testimonial['author_title']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <div class="testimonial-item text-center">
                            <p class="fs-5 fst-italic">Belum ada testimoni.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Kontak Kami -->
<section id="kontak" class="py-5">
    <div class="container">
        <div class="h2 text-center" data-aos="fade-up"><?= esc($settings['home']['contact_title'] ?? 'Kontak') ?></div>
        <div class="row">
            <!-- Form -->
            <div class="row g-4">
            <!-- Form -->
            <div class="col-lg-6" data-aos="fade-right">
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
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card shadow-sm border-0 text-white" style="background-color: #0d6efd;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Hubungi Kami.</h5>
                        <p class="mb-3">
                            Kami siap membantu Anda. Jika Anda memiliki pertanyaan, saran, atau masukan terkait produk Souvnela, jangan ragu untuk menghubungi kami melalui informasi kontak di bawah ini.
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <strong>Alamat:</strong> <?= esc($settings['home']['contact_address'] ?? 'Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141') ?>
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <strong>Telepon:</strong> <?= esc($settings['home']['contact_phone'] ?? '+62 812 3456 7890') ?>
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <strong>Instagram:</strong> <?= esc($settings['home']['contact_instagram'] ?? 'souvnela') ?>
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-tiktok me-2"></i>
                            <strong>TikTok:</strong> <?= esc($settings['home']['contact_tiktok'] ?? '@souvnela') ?>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-globe me-2"></i>
                            <strong>Email:</strong> <?= esc($settings['home']['contact_email'] ?? 'souvnela@gmail.com') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
</script>

<style>
/* Floating Animation for Hero Image */
@keyframes floating {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

.floating-image {
    animation: floating 3s ease-in-out infinite;
}

/* Pulse Button Animation */
@keyframes pulse-btn {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
    }
    70% {
        box-shadow: 0 0 0 15px rgba(255, 193, 7, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
    }
}

.pulse-button {
    animation: pulse-btn 2s infinite;
}

.pulse-button:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Feature Box Hover */
.feature-box {
    padding: 20px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.feature-box:hover {
    background-color: rgba(13, 110, 253, 0.05);
    transform: translateY(-10px);
}

.feature-box .icon {
    font-size: 3rem;
    transition: transform 0.3s ease;
}

.feature-box:hover .icon {
    transform: scale(1.2) rotate(5deg);
}

/* Blog Card Hover */
.blog-card-hover {
    transition: all 0.3s ease;
}

.blog-card-hover:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

/* Testimonial fade animation */
.carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity 0.6s ease-in-out;
}

.carousel-fade .carousel-item.active {
    opacity: 1;
}

/* Contact Form Input Animation */
.form-control:focus {
    transform: scale(1.02);
    transition: transform 0.2s ease;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}
</style>

<?= $this->endSection() ?>