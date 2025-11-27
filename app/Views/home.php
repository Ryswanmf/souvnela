<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero py-5" style="min-height: 85vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3"><?= esc($settings['hero_title'] ?? 'Souvenir Eksklusif Polinela') ?></h1>
                <p class="lead mb-4">
                    <?= esc($settings['hero_subtitle1'] ?? 'Selamat datang di Souvnela, pusat merchandise dan suvenir resmi Polinela. Kami mengundang Anda untuk menjelajahi koleksi yang tidak hanya unik, tetapi juga dibuat dengan kualitas premium.') ?>
                </p>
                <p class="lead mb-4">
                    <?= esc($settings['hero_subtitle2'] ?? 'Setiap desain yang kami hadirkan adalah representasi dari semangat, kreativitas, dan sejarah Politeknik Negeri Lampung. Souvnela lebih dari sekadar toko, ini adalah perayaan identitas kampus. Baik untuk Anda para mahasiswa, alumni, dosen, atau siapa pun yang bangga menjadi bagian dari keluarga besar Polinela, temukan produk yang berbicara tentang perjalanan Anda di sini.') ?>
                </p>
                <a href="<?= base_url('produk') ?>" class="btn btn-warning btn-lg px-4 py-2 pulse-button"><?= esc($settings['hero_button_text'] ?? 'Lihat Produk') ?></a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('uploads/' . ($settings['hero_image'] ?? 'oo.png')) ?>" class="img-fluid floating-image" alt="Souvenir Polinela">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features py-5">
    <div class="container text-center">
        <h2 class="mb-4"><?= esc($settings['features_title'] ?? 'Kenapa Memilih Kami?') ?></h2>
        <div class="row">
            <div class="col-md-4">
                <div class="icon mb-3">
                    <?php if (!empty($settings['feature1_image'])): ?>
                        <img src="<?= base_url('uploads/' . $settings['feature1_image']) ?>" alt="Feature 1 Icon" width="50">
                    <?php else: ?>
                        <?= esc($settings['feature1_icon'] ?? '🎁') ?>
                    <?php endif; ?>
                </div>
                <h5><?= esc($settings['feature1_title'] ?? 'Kualitas Premium') ?></h5>
                <p><?= esc($settings['feature1_description'] ?? 'Souvenir terbuat dari bahan berkualitas terbaik untuk kepuasan Anda.') ?></p>
            </div>
            <div class="col-md-4">
                <div class="icon mb-3">
                    <?php if (!empty($settings['feature2_image'])): ?>
                        <img src="<?= base_url('uploads/' . $settings['feature2_image']) ?>" alt="Feature 2 Icon" width="50">
                    <?php else: ?>
                        <?= esc($settings['feature2_icon'] ?? '⚡') ?>
                    <?php endif; ?>
                </div>
                <h5><?= esc($settings['feature2_title'] ?? 'Proses Cepat') ?></h5>
                <p><?= esc($settings['feature2_description'] ?? 'Pesanan diproses dengan cepat agar segera sampai ke tangan Anda.') ?></p>
            </div>
            <div class="col-md-4">
                <div class="icon mb-3">
                    <?php if (!empty($settings['feature3_image'])): ?>
                        <img src="<?= base_url('uploads/' . $settings['feature3_image']) ?>" alt="Feature 3 Icon" width="50">
                    <?php else: ?>
                        <?= esc($settings['feature3_icon'] ?? '💳') ?>
                    <?php endif; ?>
                </div>
                <h5><?= esc($settings['feature3_title'] ?? 'Transaksi Mudah') ?></h5>
                <p><?= esc($settings['feature3_description'] ?? 'Metode pembayaran yang fleksibel dan aman digunakan.') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Produk -->
<section id="produk" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Produk Unggulan</h2>
        <?php if (!empty($products)): ?>
        <!-- Optimized Product Grid - Faster Loading -->
        <div class="row g-3 justify-content-center">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="card shadow-sm h-100 product-card position-relative">
                        <!-- Wishlist Heart Icon -->
                        <?php if (session()->get('isLoggedIn')): ?>
                            <?php $isInWishlist = in_array($product['id'], $wishlist); ?>
                            <button class="btn btn-sm position-absolute top-0 end-0 m-1 wishlist-btn"
                                    onclick="toggleWishlist(this, <?= $product['id'] ?>)"
                                    style="z-index: 10; background: rgba(255,255,255,0.95); border: none; width: 30px; height: 30px; padding: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="bi <?= $isInWishlist ? 'bi-heart-fill' : 'bi-heart' ?> text-danger" style="font-size: 0.9rem;"></i>
                            </button>
                        <?php endif; ?>

                        <img src="<?= base_url('uploads/' . esc($product['gambar'])) ?>"
                             class="card-img-top"
                             alt="<?= esc($product['nama']) ?>"
                             loading="lazy"
                             style="height:200px; object-fit:cover;">
                        <div class="card-body d-flex flex-column p-2">
                            <h6 class="card-title small mb-1" style="font-size: 0.85rem; line-height: 1.3;"><?= esc($product['nama']) ?></h6>
                            <p class="fw-bold mb-1" style="font-size: 0.9rem;">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                            <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                <i class="bi bi-box"></i> <?= esc($product['stok']) ?> | <i class="bi bi-tag"></i> <?= esc($product['kategori']) ?>
                            </p>
                            <div class="d-flex gap-1 mt-auto">
                                <a href="<?= base_url('produk/detail/' . $product['id']) ?>" class="btn btn-outline-primary btn-sm flex-fill" style="font-size: 0.7rem;">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                                <form action="<?= base_url('cart/add') ?>" method="post" class="flex-fill add-to-cart-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm w-100" style="font-size: 0.7rem;">
                                        <i class="bi bi-cart-plus"></i> Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Products Link -->
        <div class="text-center mt-4">
            <a href="<?= base_url('produk') ?>" class="btn btn-primary">Lihat Semua Produk</a>
        </div>

        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-box"></i> Belum ada produk unggulan.
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center"><?= esc($settings['about_title'] ?? 'Souvnela - Souvenir Eksklusif Polinela') ?></h2>
        <br>
                <p>
                    <?= $settings['about_description1'] ?? '<strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>. Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.' ?>
                </p>
                <p>
                    <?= $settings['about_description2'] ?? 'Dengan proses pemesanan yang mudah, produk berkualitas, dan layanan terpercaya, kami berkomitmen untuk memberikan pengalaman terbaik bagi seluruh pelanggan.' ?>
                </p>
                <ul class="list-unstyled">
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <?= esc($settings['about_list1'] ?? 'Produk eksklusif dan original') ?>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <?= esc($settings['about_list2'] ?? 'Bahan berkualitas premium') ?>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <?= esc($settings['about_list3'] ?? 'Transaksi aman & cepat') ?>
                    </li>
                </ul>
    </div>
</section>

<!-- Blog -->
<section id="blog" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Blog</h2>
        <div class="row g-4">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" class="card-img-top" alt="<?= esc($post['judul']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($post['judul']) ?></h5>
                                <p class="card-text"><?= esc(substr(strip_tags($post['konten']), 0, 100)) ?>...</p>
                                <a href="<?= base_url('blog/detail/' . $post['id']) ?>" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
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
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
</style>

<!-- Testimonials -->
<section id="testimonials" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Testimoni</h2>
        <div id="testimonialCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
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
        <div class="h2 text-center"><?= esc($settings['contact_title'] ?? 'Kontak') ?></div>
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
                            <strong>Alamat:</strong> <?= esc($settings['contact_address'] ?? 'Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141') ?>
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <strong>Telepon:</strong> <?= esc($settings['contact_phone'] ?? '+62 812 3456 7890') ?>
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <strong>Instagram:</strong> <?= esc($settings['contact_instagram'] ?? 'souvnela') ?>
                        </p>
                        <p class="mb-3">
                            <i class="bi bi-tiktok me-2"></i>
                            <strong>TikTok:</strong> <?= esc($settings['contact_tiktok'] ?? '@souvnela') ?>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-globe me-2"></i>
                            <strong>Email:</strong> <?= esc($settings['contact_email'] ?? 'souvnela@gmail.com') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Optimized Styles - Removed heavy animations -->
<style>
/* Simplified animations for better performance */
.product-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}
</style>

<?= $this->endSection() ?>