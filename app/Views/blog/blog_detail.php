<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold">Detail Blog #<?= $id ?></h2>
        <p class="text-muted">Artikel detail dari blog ID <?= $id ?> akan ditampilkan di sini.</p>
        <a href="<?= base_url('blog') ?>" class="btn btn-secondary">Kembali ke Blog</a>
    </div>
</section>

<?= $this->endSection() ?>
