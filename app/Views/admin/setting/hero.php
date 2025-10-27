<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/setting/update_hero') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <h5 class="mt-4">Hero Section</h5>
                <div class="mb-3">
                    <label for="hero_title" class="form-label">Judul Hero</label>
                    <input type="text" class="form-control" id="hero_title" name="hero_title" value="<?= esc($settings['hero_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="hero_subtitle1" class="form-label">Subjudul Hero 1</label>
                    <textarea class="form-control" id="hero_subtitle1" name="hero_subtitle1" rows="3"><?= esc($settings['hero_subtitle1'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="hero_subtitle2" class="form-label">Subjudul Hero 2</label>
                    <textarea class="form-control" id="hero_subtitle2" name="hero_subtitle2" rows="3"><?= esc($settings['hero_subtitle2'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="hero_button_text" class="form-label">Teks Tombol Hero</label>
                    <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" value="<?= esc($settings['hero_button_text'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="hero_image" class="form-label">Gambar Hero</label>
                    <input type="file" class="form-control" id="hero_image" name="hero_image">
                    <?php if (!empty($settings['hero_image'])): ?>
                        <img src="<?= base_url('uploads/' . $settings['hero_image']) ?>" alt="Hero Image" class="img-thumbnail mt-2" width="200">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
