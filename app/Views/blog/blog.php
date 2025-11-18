<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="blog" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?= esc($title) ?></h2>
            <p class="text-muted">Dapatkan informasi terkini dan inspirasi dari Souvnela. Kami sajikan artikel menarik tentang tren souvenir, liputan event, 
                                dan semua aktivitas Polinela yang tidak boleh Anda lewatkan.</p>
        </div>

        <?php if (!empty($posts)): ?>
        <div id="blogCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                // 6 blog per slide (3 atas + 3 bawah)
                $chunked = array_chunk($posts, 6);
                $first = true;
                foreach ($chunked as $group): 
                    $atas = array_slice($group, 0, 3);
                    $bawah = array_slice($group, 3);
                ?>
                    <div class="carousel-item <?= $first ? 'active' : '' ?>">
                        <!-- Baris Atas -->
                        <div class="row g-4 mb-4">
                            <?php foreach ($atas as $post): ?>
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0 h-100 blog-card">
                                        <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($post['judul']) ?>" 
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <span class="badge bg-primary mb-2 align-self-start">
                                                <i class="bi bi-tag"></i> <?= esc($post['kategori']) ?>
                                            </span>
                                            <h5 class="card-title"><?= esc($post['judul']) ?></h5>
                                            <p class="text-muted small mb-2">
                                                <i class="bi bi-person me-1"></i><?= esc($post['penulis']) ?> 
                                                <span class="mx-1">|</span> 
                                                <i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($post['created_at'])) ?>
                                            </p>
                                            <p class="card-text flex-grow-1 text-muted">
                                                <?= esc(substr(strip_tags($post['konten']), 0, 100)) ?>...
                                            </p>
                                            <a href="<?= base_url('blog/detail/' . $post['id']) ?>" class="btn btn-primary btn-sm mt-auto">
                                                <i class="bi bi-book me-1"></i>Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Baris Bawah -->
                        <?php if (!empty($bawah)): ?>
                        <div class="row g-4">
                            <?php foreach ($bawah as $post): ?>
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0 h-100 blog-card">
                                        <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($post['judul']) ?>" 
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <span class="badge bg-primary mb-2 align-self-start">
                                                <i class="bi bi-tag"></i> <?= esc($post['kategori']) ?>
                                            </span>
                                            <h5 class="card-title"><?= esc($post['judul']) ?></h5>
                                            <p class="text-muted small mb-2">
                                                <i class="bi bi-person me-1"></i><?= esc($post['penulis']) ?> 
                                                <span class="mx-1">|</span> 
                                                <i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($post['created_at'])) ?>
                                            </p>
                                            <p class="card-text flex-grow-1 text-muted">
                                                <?= esc(substr(strip_tags($post['konten']), 0, 100)) ?>...
                                            </p>
                                            <a href="<?= base_url('blog/detail/' . $post['id']) ?>" class="btn btn-primary btn-sm mt-auto">
                                                <i class="bi bi-book me-1"></i>Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php 
                $first = false;
                endforeach; 
                ?>
            </div>

            <!-- Navigasi Carousel -->
            <?php if (count($chunked) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#blogCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#blogCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Berikutnya</span>
                </button>

                <!-- Indicators -->
                <div class="carousel-indicators position-relative mt-4" style="position: relative; bottom: 0;">
                    <?php foreach ($chunked as $index => $chunk): ?>
                        <button type="button" 
                                data-bs-target="#blogCarousel" 
                                data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>"
                                aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                                aria-label="Slide <?= $index + 1 ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-journal-x" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Belum Ada Artikel</h4>
                <p>Tidak ada artikel yang dipublikasikan saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-size: 50%, 50%;
}
.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}
.carousel-indicators button {
    background-color: #002254;
}
</style>

<?= $this->endSection() ?>