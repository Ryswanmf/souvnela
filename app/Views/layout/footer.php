<!-- Footer -->
<footer class="text-white pt-5" style="background-color:#002254;">
    <div class="container pb-4">
        <div class="row text-start">
            <!-- Column 1: About -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-shop me-2"></i>Souvnela
                </h5>
                <p class="small">
                    <?= $settings['home']['footer_description'] ?? '<strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>. Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.' ?>
                </p>
                <!-- Social Media Icons -->
                <div class="d-flex gap-3 fs-5 mt-3">
                    <a href="<?= esc($settings['general']['facebook_link'] ?? '#') ?>" class="text-white social-icon" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="<?= esc($settings['general']['instagram_link'] ?? '#') ?>" class="text-white social-icon" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="<?= esc($settings['general']['youtube_link'] ?? '#') ?>" class="text-white social-icon" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="<?= esc($settings['general']['tiktok_social_link'] ?? '#') ?>" class="text-white social-icon" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Information -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2"></i>Informasi
                </h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('konfirmasi-pembayaran') ?>" class="text-white text-decoration-none footer-link">Konfirmasi Pembayaran</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('pembayaran-pengiriman') ?>" class="text-white text-decoration-none footer-link">Pembayaran & Pengiriman</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('syarat-ketentuan') ?>" class="text-white text-decoration-none footer-link">Syarat & Ketentuan</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chevron-right me-1"></i>
                        <a href="<?= base_url('kebijakan-privasi') ?>" class="text-white text-decoration-none footer-link">Kebijakan Privasi</a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Location -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Lokasi Kami
                </h5>
                <div class="mb-3">
                    <p class="small mb-2">
                        <i class="bi bi-building me-2"></i>
                        <strong>Politeknik Negeri Lampung</strong>
                    </p>
                    <p class="small mb-2">
                        <i class="bi bi-pin-map me-2"></i>
                        Jl. Soekarno Hatta No.10, Rajabasa, Bandar Lampung
                    </p>
                    <p class="small mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        (0721) 787309
                    </p>
                </div>
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm" style="max-height: 200px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.233393349332!2d105.242879314765!3d-5.380172996095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db05f772c729%3A0x112d2d40e1e2b3c!2sPoliteknik%20Negeri%20Lampung!5e0!3m2!1sen!2sid"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="text-center py-3" style="background-color: #001a40;">
        <small>
            <i class="bi bi-c-circle me-1"></i>
            <?= esc($settings['general']['copyright_text'] ?? date('Y') . ' Souvnela - Souvenir Eksklusif Polinela. Proyek Mandiri.') ?>
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>