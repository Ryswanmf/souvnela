<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="blog" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Blog & Artikel</h2>
            <p class="text-muted">Dapatkan informasi terkini dan inspirasi dari Souvnela. Kami sajikan artikel menarik tentang tren souvenir, liputan event, 
                                dan semua aktivitas Polinela yang tidak boleh Anda lewatkan.</p>
        </div>

        <div class="row g-4">
            <!-- Artikel 1 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= base_url('assets/images/blog1.jpg') ?>" class="card-img-top" alt="Event Polinela">
                    <div class="card-body">
                        <h5 class="card-title">Launching Souvenir Baru</h5>
                        <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> 15 September 2025</p>
                        <p class="card-text">Souvnela resmi meluncurkan koleksi souvenir terbaru yang eksklusif untuk mahasiswa Polinela.</p>
                        <a href="<?= base_url('blog/detail/1') ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Artikel 2 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= base_url('assets/images/blog2.jpg') ?>" class="card-img-top" alt="Merchandise Polinela">
                    <div class="card-body">
                        <h5 class="card-title">Tips Memilih Merchandise</h5>
                        <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> 10 September 2025</p>
                        <p class="card-text">Bagaimana memilih merchandise kampus yang berkualitas dan sesuai dengan kebutuhanmu?</p>
                        <a href="<?= base_url('blog/detail/2') ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Artikel 3 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= base_url('assets/images/blog3.jpg') ?>" class="card-img-top" alt="Event Kampus">
                    <div class="card-body">
                        <h5 class="card-title">Souvenir di Acara Kampus</h5>
                        <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> 5 September 2025</p>
                        <p class="card-text">Souvenir menjadi bagian penting dalam setiap event kampus. Simak bagaimana Souvnela mendukung acara Polinela.</p>
                        <a href="<?= base_url('blog/detail/3') ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= base_url('assets/images/blog1.jpg') ?>" class="card-img-top" alt="Event Polinela">
                    <div class="card-body">
                        <h5 class="card-title">Launching Souvenir Baru</h5>
                        <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> 15 September 2025</p>
                        <p class="card-text">Souvnela resmi meluncurkan koleksi souvenir terbaru yang eksklusif untuk mahasiswa Polinela.</p>
                        <a href="<?= base_url('blog/detail/4') ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Artikel 2 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= base_url('assets/images/blog2.jpg') ?>" class="card-img-top" alt="Merchandise Polinela">
                    <div class="card-body">
                        <h5 class="card-title">Tips Memilih Merchandise</h5>
                        <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> 10 September 2025</p>
                        <p class="card-text">Bagaimana memilih merchandise kampus yang berkualitas dan sesuai dengan kebutuhanmu?</p>
                        <a href="<?= base_url('blog/detail/5') ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Artikel 3 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <img src="<?= base_url('assets/images/blog3.jpg') ?>" class="card-img-top" alt="Event Kampus">
                    <div class="card-body">
                        <h5 class="card-title">Souvenir di Acara Kampus</h5>
                        <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> 5 September 2025</p>
                        <p class="card-text">Souvenir menjadi bagian penting dalam setiap event kampus. Simak bagaimana Souvnela mendukung acara Polinela.</p>
                        <a href="<?= base_url('blog/detail/6') ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
