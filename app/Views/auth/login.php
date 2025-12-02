<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Souvnela</title>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 123, 255, 0.2), rgba(0, 123, 255, 0.2)), url('<?= base_url('assets/images/polinela.jpg') ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            animation: moveBg 30s linear infinite;
        }
        .card {
            border: none;
            border-radius: 1rem;
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .btn-primary {
            background-color: #0049b7;
            border: none;
        }
        .btn-primary:hover {
            background-color: #003b95;
        }
        .input-group-text {
            background-color: #e9ecef;
        }

        @keyframes moveBg {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }
    </style>
</head>
<body>
    <div class="card shadow-lg p-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Login Akun</h3>
            <p class="text-muted small">Masuk ke akun Souvnela Anda</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert" style="border-left: 4px solid #dc3545;">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3" style="color: #dc3545;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Error!</h6>
                        <p class="mb-0"><?= session()->getFlashdata('error') ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" style="border-left: 4px solid #28a745;">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle-fill fs-4 me-3" style="color: #28a745;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Sukses!</h6>
                        <p class="mb-0"><?= session()->getFlashdata('success') ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?= base_url('loginProcess') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autocomplete="username">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Masuk</button>
        </form>

        <div class="text-center mt-3">
            <p class="text-muted small mb-1">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a></p>
            <a href="<?= base_url('/') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Kembali ke halaman utama
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto dismiss alerts after 5 seconds with bounce animation
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Add bounce animation
                alert.style.animation = 'bounceIn 0.6s ease-out';
                
                setTimeout(function() {
                    // Add fade-out animation before closing
                    alert.style.animation = 'fadeOutUp 0.5s ease-out';
                    setTimeout(function() {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 500);
                }, 5000); // 5 seconds
            });
        });
    </script>
    
    <style>
    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
            opacity: 1;
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
        }
    }
    
    @keyframes fadeOutUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-20px);
            opacity: 0;
        }
    }
    
    .alert {
        animation: bounceIn 0.6s ease-out;
    }
    </style>
</body>
</html>