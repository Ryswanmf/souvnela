
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
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
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
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Produk' ? 'active' : '' ?>" href="<?= base_url('produk') ?>">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Kontak' ? 'active' : '' ?>" href="<?= base_url('kontak') ?>">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Blog' ? 'active' : '' ?>" href="<?= base_url('blog') ?>">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($title ?? '') == 'Tentang' ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= base_url('cart') ?>" title="Keranjang">
                        <i class="bi bi-cart3 fs-5"></i>
                        <?php 
                        $cart = session()->get('cart') ?? [];
                        $totalItems = 0;
                        foreach ($cart as $item) {
                            $totalItems += $item['quantity'];
                        }
                        if ($totalItems > 0): 
                        ?>
                        <span class="position-absolute translate-middle badge rounded-circle bg-danger cart-badge">
                            <?= $totalItems > 99 ? '99+' : $totalItems ?>
                            <span class="visually-hidden">items in cart</span>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?= esc(session()->get('nama_lengkap')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('account') ?>">Pesanan Saya</a></li>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('admin') ?>">Dashboard Admin</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>" title="Login">
                            <i class="bi bi-person-circle"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<!-- MAIN CONTENT -->
<main>
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" style="border-left: 4px solid #28a745;">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle-fill fs-3 me-3" style="color: #28a745;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Berhasil!</h6>
                        <p class="mb-0"><?= session()->getFlashdata('success') ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert" style="border-left: 4px solid #dc3545;">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3" style="color: #dc3545;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Oops!</h6>
                        <p class="mb-0"><?= session()->getFlashdata('error') ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?= $this->renderSection('content') ?>
</main>


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
<script>
    const settings = <?= isset($settings) ? json_encode($settings) : '{}' ?>;
    
    // Auto dismiss alerts after 5 seconds with slide animation
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Add slide-in animation
            alert.style.animation = 'slideInDown 0.5s ease-out';
            
            setTimeout(function() {
                // Add slide-out animation before closing
                alert.style.animation = 'slideOutUp 0.5s ease-out';
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 500);
            }, 5000); // 5 seconds
        });

        // Handle Add to Cart with Animation
        document.querySelectorAll('.add-to-cart-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const button = this.querySelector('button[type="submit"]');
                const productCard = this.closest('.product-card, .card');
                const productImage = productCard ? productCard.querySelector('img') : null;
                
                // Disable button
                button.disabled = true;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="bi bi-hourglass-split"></i> Menambahkan...';
                
                fetch('<?= base_url('cart/add') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Fly to cart animation
                        if (productImage) {
                            flyToCart(productImage);
                        }
                        
                        // Update cart badge
                        updateCartBadge(data.totalItems);
                        
                        // Show success message
                        showNotification('success', data.message);
                        
                        // Reset button after animation
                        setTimeout(function() {
                            button.disabled = false;
                            button.innerHTML = originalText;
                        }, 1000);
                    } else {
                        button.disabled = false;
                        button.innerHTML = originalText;
                        
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            showNotification('error', data.message);
                        }
                    }
                })
                .catch(error => {
                    button.disabled = false;
                    button.innerHTML = originalText;
                    showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        });
    });

    function flyToCart(productImage) {
        const cart = document.querySelector('.bi-cart3');
        if (!cart || !productImage) return;
        
        // Clone the image
        const flyingImg = productImage.cloneNode();
        flyingImg.style.cssText = `
            position: fixed;
            z-index: 9999;
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        `;
        
        // Get positions
        const imgRect = productImage.getBoundingClientRect();
        const cartRect = cart.getBoundingClientRect();
        
        flyingImg.style.left = imgRect.left + 'px';
        flyingImg.style.top = imgRect.top + 'px';
        
        document.body.appendChild(flyingImg);
        
        // Animate
        setTimeout(function() {
            flyingImg.style.transition = 'all 0.8s cubic-bezier(0.5, 0, 0.5, 1)';
            flyingImg.style.left = cartRect.left + 'px';
            flyingImg.style.top = cartRect.top + 'px';
            flyingImg.style.width = '20px';
            flyingImg.style.height = '20px';
            flyingImg.style.opacity = '0';
        }, 10);
        
        // Remove after animation
        setTimeout(function() {
            flyingImg.remove();
            // Bounce cart icon
            cart.style.animation = 'cartBounce 0.5s ease';
            setTimeout(() => cart.style.animation = '', 500);
        }, 800);
    }

    function updateCartBadge(totalItems) {
        let badge = document.querySelector('.cart-badge');
        const cartLink = document.querySelector('.bi-cart3').closest('a');
        
        if (totalItems > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'position-absolute translate-middle badge rounded-circle bg-danger cart-badge';
                badge.innerHTML = '<span class="visually-hidden">items in cart</span>';
                cartLink.appendChild(badge);
            }
            badge.childNodes[0].textContent = totalItems > 99 ? '99+' : totalItems;
            
            // Bounce animation
            badge.style.animation = 'none';
            setTimeout(() => badge.style.animation = 'bounce 0.5s ease', 10);
        }
    }

    function showNotification(type, message) {
        const container = document.querySelector('main > .container:first-child') || document.querySelector('main');
        const alertDiv = document.createElement('div');
        alertDiv.className = `container mt-3`;
        
        const iconClass = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        const bgColor = type === 'success' ? '#28a745' : '#dc3545';
        const heading = type === 'success' ? 'Berhasil!' : 'Oops!';
        
        alertDiv.innerHTML = `
            <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show shadow-sm border-0" role="alert" style="border-left: 4px solid ${bgColor}; animation: bounceIn 0.6s ease-out;">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi ${iconClass} fs-3 me-3" style="color: ${bgColor};"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">${heading}</h6>
                        <p class="mb-0">${message}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto remove
        setTimeout(function() {
            alertDiv.querySelector('.alert').style.animation = 'fadeOutUp 0.5s ease-out';
            setTimeout(() => alertDiv.remove(), 500);
        }, 3000);
    }
</script>

<style>
@keyframes slideInDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideOutUp {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(-100%);
        opacity: 0;
    }
}

@keyframes cartBounce {
    0%, 100% {
        transform: scale(1);
    }
    25% {
        transform: scale(1.3) rotate(-10deg);
    }
    50% {
        transform: scale(1.1) rotate(10deg);
    }
    75% {
        transform: scale(1.2) rotate(-5deg);
    }
}

.alert {
    animation: slideInDown 0.5s ease-out;
}
</style>
</body>
</html>