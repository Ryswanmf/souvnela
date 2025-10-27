<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="blog" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?= esc($title) ?></h2>
            <p class="text-muted">Dapatkan informasi terkini dan inspirasi dari Souvnela. Kami sajikan artikel menarik tentang tren souvenir, liputan event, 
                                dan semua aktivitas Polinela yang tidak boleh Anda lewatkan.</p>
        </div>

        <div class="row g-4">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" class="card-img-top" alt="<?= esc($post['judul']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= esc($post['judul']) ?></h5>
                                <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> <?= date('d M Y', strtotime($post['created_at'])) ?></p>
                                <p class="card-text flex-grow-1"><?= esc(substr(strip_tags($post['konten']), 0, 100)) ?>...</p>
                                <a href="<?= base_url('blog/detail/' . $post['id']) ?>" class="btn btn-primary btn-sm mt-auto">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-journal-x fs-1"></i>
                        <h4 class="mt-3">Belum Ada Artikel</h4>
                        <p>Tidak ada artikel yang dipublikasikan saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>