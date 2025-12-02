<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="tentang" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?= esc($settings['about_title'] ?? 'Tentang Kami') ?></h2>
            <p class="lead text-muted">Souvnela lahir dari semangat untuk menciptakan souvenir yang bukan hanya sekadar barang, tapi juga cerita dan kebanggaan. 
                Kami adalah tim yang berdedikasi untuk menjaga kenangan Polinela tetap hidup melalui produk-produk eksklusif. Temukan kisah kami di sini.</p>
        </div>

        <div class="row align-items-center g-4">
            <!-- Gambar -->
            <div class="col-lg-6">
                <img src="<?= base_url('assets/images/' . ($settings['about_image'] ?? 'logobiru.png')) ?>" class="img-fluid rounded shadow" alt="Tim Souvnela">
            </div>

            <!-- Deskripsi -->
            <div class="col-lg-6">
                <h3 class="fw-bold"><?= esc($settings['about_title'] ?? 'Souvnela - Souvenir Polinela') ?></h3>
                <p>
                    <?= $settings['about_description1'] ?? '<strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>. Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.' ?>
                </p>
                <p>
                    <?= $settings['about_description2'] ?? 'Dengan proses pemesanan yang mudah, produk berkualitas, dan layanan terpercaya, kami berkomitmen untuk memberikan pengalaman terbaik bagi seluruh pelanggan.' ?>
                </p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> <?= esc($settings['about_list1'] ?? 'Produk eksklusif dan original') ?></li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> <?= esc($settings['about_list2'] ?? 'Bahan berkualitas premium') ?></li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> <?= esc($settings['about_list3'] ?? 'Transaksi aman & cepat') ?></li>
                </ul>
            </div>
        </div>

        <!-- Visi Misi -->
        <div class="row mt-5 g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column align-items-start">
                        <h4 class="fw-bold mb-3"><i class="bi bi-eye me-2"></i>Visi</h4>
                        <p>
                            <?= esc($settings['visi'] ?? 'Menjadi platform souvenir kampus yang inovatif, terpercaya, dan mampu memperkuat kebanggaan seluruh sivitas akademika Polinela.') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column align-items-start">
                        <h4 class="fw-bold mb-3"><i class="bi bi-flag me-2"></i>Misi</h4>
                        <div>
                            <?= $settings['misi'] ?? '<ul><li>Menyediakan produk berkualitas tinggi dengan desain eksklusif.</li><li>Mendukung kegiatan kampus dengan souvenir resmi Polinela.</li><li>Memberikan pelayanan yang cepat, ramah, dan aman.</li><li>Menghadirkan inovasi dalam setiap koleksi souvenir.</li></ul>' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
