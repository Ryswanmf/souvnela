<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold"><?= $title ?></h4>
        <p class="text-muted">Tulis dan publikasikan artikel baru</p>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <p class="fw-bold">Gagal menyimpan, mohon periksa isian Anda:</p>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <?php if (isset($post['id'])): ?>
                <input type="hidden" name="_method" value="POST">
            <?php endif; ?>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Artikel</label>
                <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul', $post['judul'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten</label>
                <textarea name="konten" id="konten" class="form-control" rows="10" required><?= old('konten', $post['konten'] ?? '') ?></textarea>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?= old('kategori', $post['kategori'] ?? 'Tips') ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" name="penulis" id="penulis" class="form-control" value="<?= old('penulis', $post['penulis'] ?? 'Admin') ?>" required>
                </div>
            </div>

            <div class="mt-3">
                <label for="gambar" class="form-label">Gambar Utama</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
                <?php if (isset($post['gambar']) && $post['gambar']): ?>
                    <div class="mt-2">
                        <small>Gambar saat ini:</small>
                        <img src="<?= base_url('uploads/' . $post['gambar']) ?>" width="150" class="rounded">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                <a href="<?= base_url('admin/blog') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
