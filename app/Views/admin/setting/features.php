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
            <form action="<?= base_url('admin/setting/update_features') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <h5 class="mt-4">Features Section</h5>
                <div class="mb-3">
                    <label for="features_title" class="form-label">Judul Fitur</label>
                    <input type="text" class="form-control" id="features_title" name="features_title" value="<?= esc($settings['features_title'] ?? '') ?>">
                </div>
                <div class="row">
                    <div class="col-md-4">

                        <div class="mb-3">
                            <label for="feature1_image" class="form-label">Ikon Fitur 1 (Gambar)</label>
                            <input type="file" class="form-control" id="feature1_image" name="feature1_image">
                            <?php if (!empty($settings['feature1_image'])): ?>
                                <img src="<?= base_url('uploads/' . $settings['feature1_image']) ?>" alt="Feature 1 Image" class="img-thumbnail mt-2" width="50">
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="feature1_title" class="form-label">Judul Fitur 1</label>
                            <input type="text" class="form-control" id="feature1_title" name="feature1_title" value="<?= esc($settings['feature1_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature1_description" class="form-label">Deskripsi Fitur 1</label>
                            <textarea class="form-control" id="feature1_description" name="feature1_description" rows="3"><?= esc($settings['feature1_description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="mb-3">
                            <label for="feature2_image" class="form-label">Ikon Fitur 2 (Gambar)</label>
                            <input type="file" class="form-control" id="feature2_image" name="feature2_image">
                            <?php if (!empty($settings['feature2_image'])): ?>
                                <img src="<?= base_url('uploads/' . $settings['feature2_image']) ?>" alt="Feature 2 Image" class="img-thumbnail mt-2" width="50">
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="feature2_title" class="form-label">Judul Fitur 2</label>
                            <input type="text" class="form-control" id="feature2_title" name="feature2_title" value="<?= esc($settings['feature2_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature2_description" class="form-label">Deskripsi Fitur 2</label>
                            <textarea class="form-control" id="feature2_description" name="feature2_description" rows="3"><?= esc($settings['feature2_description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="mb-3">
                            <label for="feature3_image" class="form-label">Ikon Fitur 3 (Gambar)</label>
                            <input type="file" class="form-control" id="feature3_image" name="feature3_image">
                            <?php if (!empty($settings['feature3_image'])): ?>
                                <img src="<?= base_url('uploads/' . $settings['feature3_image']) ?>" alt="Feature 3 Image" class="img-thumbnail mt-2" width="50">
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="feature3_title" class="form-label">Judul Fitur 3</label>
                            <input type="text" class="form-control" id="feature3_title" name="feature3_title" value="<?= esc($settings['feature3_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature3_description" class="form-label">Deskripsi Fitur 3</label>
                            <textarea class="form-control" id="feature3_description" name="feature3_description" rows="3"><?= esc($settings['feature3_description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
