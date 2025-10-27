<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/testimonial/update/' . $testimonial['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea class="form-control" id="content" name="content" rows="3"><?= esc($testimonial['content']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?= esc($testimonial['author']) ?>">
                </div>

                <div class="mb-3">
                    <label for="author_title" class="form-label">Jabatan Author</label>
                    <input type="text" class="form-control" id="author_title" name="author_title" value="<?= esc($testimonial['author_title']) ?>">
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    <?php if (!empty($testimonial['photo'])): ?>
                        <img src="<?= base_url('uploads/' . $testimonial['photo']) ?>" alt="Author Photo" class="img-thumbnail mt-2" width="100">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
