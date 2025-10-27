<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container col-lg-8">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('blog') ?>">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($title) ?></li>
            </ol>
        </nav>

        <article class="blog-post">
            <h1 class="fw-bold mb-3"><?= esc($post['judul']) ?></h1>
            <p class="text-muted mb-4">
                <i class="bi bi-person-fill"></i> <?= esc($post['penulis']) ?> 
                <span class="mx-2">|</span> 
                <i class="bi bi-calendar-event"></i> <?= date('d F Y', strtotime($post['created_at'])) ?>
                <span class="mx-2">|</span> 
                <i class="bi bi-tag-fill"></i> <?= esc($post['kategori']) ?>
            </p>

            <?php if ($post['gambar']): ?>
                <img src="<?= base_url('uploads/' . esc($post['gambar'])) ?>" class="img-fluid rounded mb-4" alt="<?= esc($post['judul']) ?>">
            <?php endif; ?>

            <div class="post-content lh-lg">
                <?= $post['konten'] // Tampilkan konten HTML tanpa di-escape, pastikan konten disanitasi saat disimpan ?>
            </div>
        </article>

        <div class="mt-5">
            <a href="<?= base_url('blog') ?>" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Artikel</a>
        </div>

    </div>
</section>

<?= $this->endSection() ?>