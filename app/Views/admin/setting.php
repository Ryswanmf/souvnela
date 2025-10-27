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
            <form action="<?= base_url('admin/setting/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <h5 class="mt-4">Hero Section</h5>
                <div class="mb-3">
                    <label for="hero_title" class="form-label">Judul Hero</label>
                    <input type="text" class="form-control" id="hero_title" name="hero_title" value="<?= esc($home_settings['hero_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="hero_subtitle1" class="form-label">Subjudul Hero 1</label>
                    <textarea class="form-control" id="hero_subtitle1" name="hero_subtitle1" rows="3"><?= esc($home_settings['hero_subtitle1'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="hero_subtitle2" class="form-label">Subjudul Hero 2</label>
                    <textarea class="form-control" id="hero_subtitle2" name="hero_subtitle2" rows="3"><?= esc($home_settings['hero_subtitle2'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="hero_button_text" class="form-label">Teks Tombol Hero</label>
                    <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" value="<?= esc($home_settings['hero_button_text'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="hero_image" class="form-label">Gambar Hero</label>
                    <input type="file" class="form-control" id="hero_image" name="hero_image">
                    <?php if (!empty($home_settings['hero_image'])): ?>
                        <img src="<?= base_url('uploads/' . $home_settings['hero_image']) ?>" alt="Hero Image" class="img-thumbnail mt-2" width="200">
                    <?php endif; ?>
                </div>

                <hr>

                <h5 class="mt-4">Features Section</h5>
                <div class="mb-3">
                    <label for="features_title" class="form-label">Judul Fitur</label>
                    <input type="text" class="form-control" id="features_title" name="features_title" value="<?= esc($home_settings['features_title'] ?? '') ?>">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="feature1_icon" class="form-label">Ikon Fitur 1</label>
                            <input type="text" class="form-control" id="feature1_icon" name="feature1_icon" value="<?= esc($home_settings['feature1_icon'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature1_title" class="form-label">Judul Fitur 1</label>
                            <input type="text" class="form-control" id="feature1_title" name="feature1_title" value="<?= esc($home_settings['feature1_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature1_description" class="form-label">Deskripsi Fitur 1</label>
                            <textarea class="form-control" id="feature1_description" name="feature1_description" rows="3"><?= esc($home_settings['feature1_description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="feature2_icon" class="form-label">Ikon Fitur 2</label>
                            <input type="text" class="form-control" id="feature2_icon" name="feature2_icon" value="<?= esc($home_settings['feature2_icon'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature2_title" class="form-label">Judul Fitur 2</label>
                            <input type="text" class="form-control" id="feature2_title" name="feature2_title" value="<?= esc($home_settings['feature2_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature2_description" class="form-label">Deskripsi Fitur 2</label>
                            <textarea class="form-control" id="feature2_description" name="feature2_description" rows="3"><?= esc($home_settings['feature2_description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="feature3_icon" class="form-label">Ikon Fitur 3</label>
                            <input type="text" class="form-control" id="feature3_icon" name="feature3_icon" value="<?= esc($home_settings['feature3_icon'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature3_title" class="form-label">Judul Fitur 3</label>
                            <input type="text" class="form-control" id="feature3_title" name="feature3_title" value="<?= esc($home_settings['feature3_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="feature3_description" class="form-label">Deskripsi Fitur 3</label>
                            <textarea class="form-control" id="feature3_description" name="feature3_description" rows="3"><?= esc($home_settings['feature3_description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <h5 class="mt-4">Tentang Section</h5>
                <div class="mb-3">
                    <label for="about_title" class="form-label">Judul Tentang</label>
                    <input type="text" class="form-control" id="about_title" name="about_title" value="<?= esc($home_settings['about_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="about_description1" class="form-label">Deskripsi Tentang 1</label>
                    <textarea class="form-control" id="about_description1" name="about_description1" rows="3"><?= esc($home_settings['about_description1'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="about_description2" class="form-label">Deskripsi Tentang 2</label>
                    <textarea class="form-control" id="about_description2" name="about_description2" rows="3"><?= esc($home_settings['about_description2'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="about_list1" class="form-label">List Tentang 1</label>
                    <input type="text" class="form-control" id="about_list1" name="about_list1" value="<?= esc($home_settings['about_list1'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="about_list2" class="form-label">List Tentang 2</label>
                    <input type="text" class="form-control" id="about_list2" name="about_list2" value="<?= esc($home_settings['about_list2'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="about_list3" class="form-label">List Tentang 3</label>
                    <input type="text" class="form-control" id="about_list3" name="about_list3" value="<?= esc($home_settings['about_list3'] ?? '') ?>">
                </div>

                <hr>

                <h5 class="mt-4">Kontak Section</h5>
                <div class="mb-3">
                    <label for="contact_title" class="form-label">Judul Kontak</label>
                    <input type="text" class="form-control" id="contact_title" name="contact_title" value="<?= esc($home_settings['contact_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="contact_address" name="contact_address" rows="3"><?= esc($home_settings['contact_address'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="contact_phone" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?= esc($home_settings['contact_phone'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_instagram" class="form-label">Instagram</label>
                    <input type="text" class="form-control" id="contact_instagram" name="contact_instagram" value="<?= esc($home_settings['contact_instagram'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_tiktok" class="form-label">TikTok</label>
                    <input type="text" class="form-control" id="contact_tiktok" name="contact_tiktok" value="<?= esc($home_settings['contact_tiktok'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="contact_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= esc($home_settings['contact_email'] ?? '') ?>">
                </div>

                <hr>

                <h5 class="mt-4">Pengaturan Umum</h5>
                <div class="mb-3">
                    <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                    <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="<?= esc($general_settings['whatsapp_number'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="whatsapp_message" class="form-label">Pesan Default WhatsApp</label>
                    <textarea class="form-control" id="whatsapp_message" name="whatsapp_message" rows="3"><?= esc($general_settings['whatsapp_message'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
