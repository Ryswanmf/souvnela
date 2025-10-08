<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Souvnela - Souvenir Polinela' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">Souvnela</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Beranda' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= ($title ?? '') == 'Produk' ? 'active' : '' ?>" href="<?= base_url('produk') ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Produk
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('mug') ?>">Mug Polinela</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('kaos') ?>">Kaos Polinela</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('tumbler') ?>">Tumbler Polinela</a></li>
                        <li><hr class="dropdown-divider"></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link <?= ($title ?? '') == 'Kontak' ? 'active' : '' ?>" href="<?= base_url('kontak') ?>">Kontak</a></li>
                <li class="nav-item"><a class="nav-link <?= ($title ?? '') == 'Blog' ? 'active' : '' ?>" href="<?= base_url('blog') ?>">Blog</a></li>
                <li class="nav-item"><a class="nav-link <?= ($title ?? '') == 'Tentang' ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang Kami</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('checkout') ?>" title="Keranjang">
                        <i class="bi bi-cart3"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('login') ?>" title="Login">
                        <i class="bi bi-person-circle"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<main>
    <?= $this->renderSection('content') ?>
</main>
<!-- Floating WhatsApp Bubble -->
<style>
#wa-bubble {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 1050;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

#wa-bubble .wa-pill {
    background: #25D366;
    color: #fff;
    padding: 10px 16px;
    border-radius: 999px;
    box-shadow: 0 6px 18px rgba(37, 211, 102, 0.18);
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: transform .15s ease, box-shadow .15s ease;
}

#wa-bubble .wa-pill:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(37, 211, 102, 0.25);
}

#wa-bubble .wa-icon {
    width: 40px;
    height: 40px;
    background: #056E3D;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 480px) {
    #wa-bubble .wa-text {
        display: none;
    }
    #wa-bubble {
        right: 14px;
        bottom: 14px;
    }
}
</style>

<div id="wa-bubble">
    <a id="wa-link" class="wa-pill" href="#" target="_blank" rel="noopener noreferrer">
        <span class="wa-icon">
            <!-- WhatsApp icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.05 11.54a9 9 0 1 1-16.25-5.3L4 4l2.3.8A9 9 0 0 1 21 11.54z"></path>
                <path d="M12 17a5 5 0 0 0 5-5"></path>
            </svg>
        </span>
        <span class="wa-text">Pesan Sekarang</span>
    </a>
</div>

<script>
// Floating WhatsApp script (CodeIgniter 4 version)
document.addEventListener("DOMContentLoaded", function () {
    // === KONFIGURASI ===
    const phoneNumber = "6282183150556"; // Nomor WhatsApp kamu (format internasional tanpa + atau 0)
    const defaultMessage = "Halo Souvnela, saya tertarik dengan produk souvenir Polinela."; 

    // Bangun URL WhatsApp
    const encodedMsg = encodeURIComponent(defaultMessage);
    const waUrl = `https://wa.me/${phoneNumber}?text=${encodedMsg}`;
    
    // Set link ke tombol
    const waLink = document.getElementById("wa-link");
    if (waLink) waLink.href = waUrl;
});
</script>

<!-- Footer -->
<footer class="text-white pt-5" style="background-color:#002254;">
    <div class="container pb-4">
        <div class="row text-start">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Souvnela</h5>
                <p class="small">
                    <strong>Souvnela</strong> adalah platform pemesanan souvenir resmi dari <em>Politeknik Negeri Lampung</em>.
                    Kami hadir untuk menyediakan merchandise eksklusif yang mendukung rasa bangga dan identitas mahasiswa, dosen, dan alumni Polinela.
                </p>
            </div>
            
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Marketplace</h5>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Tokopedia_2022.svg" alt="Tokopedia" height="40"></a>
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Shopee.svg" alt="Shopee" height="40"></a>
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Tiktok_logo.svg" alt="TikTok" height="40"></a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Media Sosial</h5>
                <div class="d-flex gap-3 fs-5 mt-3">
                    <a href="#" class="text-white social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white social-icon"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="text-center py-3" style="background-color: #001a40;">
        <small>&copy; <?= date('Y'); ?> Souvnela - Souvenir Eksklusif Polinela. Proyek Mandiri.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
