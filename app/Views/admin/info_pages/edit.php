<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-pencil-square me-2"></i><?= esc($title) ?></h4>
        <a href="<?= base_url('admin/info-pages') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <p class="fw-bold">Gagal menyimpan:</p>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form action="<?= base_url('admin/info-pages/update/'.$page['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="title" class="form-label">Judul Halaman</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= old('title', $page['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea id="content" name="content" class="form-control" rows="15"><?= old('content', $page['content']) ?></textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
