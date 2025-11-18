<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('blog') ?>">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($post['judul']) ?></li>
            </ol>
        </nav>

        <div class="row">
            <!-- Artikel Utama -->
            <div class="col-lg-8">
                <article class="blog-post card shadow-sm border-0">
                    <!-- Gambar Featured -->
                    <?php if ($post['gambar']): ?>
                        <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" 
                             class="card-img-top" 
                             alt="<?= esc($post['judul']) ?>"
                             style="max-height: 400px; object-fit: cover;">
                    <?php endif; ?>

                    <div class="card-body p-4">
                        <!-- Kategori Badge -->
                        <div class="mb-3">
                            <span class="badge bg-primary fs-6">
                                <i class="bi bi-tag-fill me-1"></i><?= esc($post['kategori']) ?>
                            </span>
                        </div>

                        <!-- Judul -->
                        <h1 class="fw-bold mb-3"><?= esc($post['judul']) ?></h1>

                        <!-- Meta Info -->
                        <div class="d-flex flex-wrap gap-3 text-muted mb-4 pb-3 border-bottom">
                            <div>
                                <i class="bi bi-person-fill me-1"></i><?= esc($post['penulis']) ?>
                            </div>
                            <div>
                                <i class="bi bi-calendar-event me-1"></i><?= date('d F Y', strtotime($post['created_at'])) ?>
                            </div>
                            <div>
                                <i class="bi bi-clock me-1"></i><?= ceil(str_word_count(strip_tags($post['konten'])) / 200) ?> min baca
                            </div>
                        </div>

                        <!-- Konten Artikel -->
                        <div class="post-content lh-lg" style="text-align: justify;">
                            <?= $post['konten'] ?>
                        </div>

                        <!-- Share & Action -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <div>
                                <a href="<?= base_url('blog') ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Blog
                                </a>
                            </div>
                            <div>
                                <span class="text-muted me-2">Bagikan:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= urlencode($post['judul']) ?>" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-info me-1">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text=<?= urlencode($post['judul'] . ' - ' . current_url()) ?>" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Info Penulis -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="bi bi-person-circle me-2"></i>Tentang Penulis
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                 style="width: 60px; height: 60px; font-size: 24px;">
                                <?= strtoupper(substr($post['penulis'], 0, 1)) ?>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?= esc($post['penulis']) ?></h6>
                                <small class="text-muted">Content Writer</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Artikel Terkait -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="bi bi-grid-3x3 me-2"></i>Artikel Lainnya
                        </h5>
                        <div class="text-center text-muted py-3">
                            <p class="mb-2">Lihat artikel lainnya di kategori <strong><?= esc($post['kategori']) ?></strong></p>
                            <a href="<?= base_url('blog') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>Lihat Semua Artikel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.breadcrumb-item a {
    text-decoration: none;
}
.breadcrumb-item a:hover {
    text-decoration: underline;
}
.post-content img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
}
.post-content h1, 
.post-content h2, 
.post-content h3 {
    margin-top: 30px;
    margin-bottom: 15px;
}
.post-content p {
    margin-bottom: 15px;
}
.post-content ul, 
.post-content ol {
    margin-bottom: 15px;
    padding-left: 30px;
}
</style>

<?= $this->endSection() ?>