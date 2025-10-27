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
            <form action="<?= base_url('admin/setting/update_general') ?>" method="post">
                <?= csrf_field() ?>

                <h5 class="mt-4">Pengaturan Umum</h5>
                <div class="mb-3">
                    <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                    <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="<?= esc($settings['whatsapp_number'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="whatsapp_message" class="form-label">Pesan Default WhatsApp</label>
                    <textarea class="form-control" id="whatsapp_message" name="whatsapp_message" rows="3"><?= esc($settings['whatsapp_message'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="copyright_text" class="form-label">Teks Hak Cipta</label>
                    <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="<?= esc($settings['copyright_text'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
