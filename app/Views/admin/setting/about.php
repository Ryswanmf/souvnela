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
            <form action="<?= base_url('admin/setting/update_about') ?>" method="post">
                <?= csrf_field() ?>

                <h5 class="mt-4">Tentang Section</h5>
                <div class="mb-3">
                    <label for="about_title" class="form-label">Judul Tentang</label>
                    <input type="text" class="form-control" id="about_title" name="about_title" value="<?= esc($settings['about_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="about_description1" class="form-label">Deskripsi Tentang 1</label>
                    <textarea class="form-control" id="about_description1" name="about_description1" rows="3"><?= esc($settings['about_description1'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="about_description2" class="form-label">Deskripsi Tentang 2</label>
                    <textarea class="form-control" id="about_description2" name="about_description2" rows="3"><?= esc($settings['about_description2'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="about_list1" class="form-label">List Tentang 1</label>
                    <input type="text" class="form-control" id="about_list1" name="about_list1" value="<?= esc($settings['about_list1'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="about_list2" class="form-label">List Tentang 2</label>
                    <input type="text" class="form-control" id="about_list2" name="about_list2" value="<?= esc($settings['about_list2'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="about_list3" class="form-label">List Tentang 3</label>
                    <input type="text" class="form-control" id="about_list3" name="about_list3" value="<?= esc($settings['about_list3'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="footer_description" class="form-label">Deskripsi Footer</label>
                    <textarea class="form-control" id="footer_description" name="footer_description" rows="3"><?= esc($settings['footer_description'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
