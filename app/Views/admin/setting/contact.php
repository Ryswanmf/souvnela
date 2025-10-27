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
            <form action="<?= base_url('admin/setting/update_contact') ?>" method="post">
                <?= csrf_field() ?>

                <h5 class="mt-4">Kontak Section</h5>
                <div class="mb-3">
                    <label for="contact_title" class="form-label">Judul Kontak</label>
                    <input type="text" class="form-control" id="contact_title" name="contact_title" value="<?= esc($settings['contact_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="contact_address" name="contact_address" rows="3"><?= esc($settings['contact_address'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="contact_phone" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?= esc($settings['contact_phone'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_instagram" class="form-label">Instagram</label>
                    <input type="text" class="form-control" id="contact_instagram" name="contact_instagram" value="<?= esc($settings['contact_instagram'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_tiktok" class="form-label">TikTok</label>
                    <input type="text" class="form-control" id="contact_tiktok" name="contact_tiktok" value="<?= esc($settings['contact_tiktok'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= esc($settings['contact_email'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
