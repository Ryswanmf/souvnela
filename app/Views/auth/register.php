<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Souvnela</title>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            width: 100%;
            max-width: 400px;
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
    </style>
</head>
<body>
    <div class="card shadow-lg p-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Buat Akun Baru</h3>
            <p class="text-muted small">Daftar untuk mulai berbelanja di Souvnela</p>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        <?php 
        $errors = session()->getFlashdata('errors');
        if($errors): ?>
            <div class="alert alert-danger">
                <p class="fw-bold mb-1">Gagal mendaftar:</p>
                <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Register -->
        <form action="<?= base_url('registerProcess') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" value="<?= old('nama') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" value="<?= old('username') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="form-label fw-semibold">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
        </form>

        <div class="text-center mt-3">
            <p class="text-muted small mb-1">Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></p>
            <a href="<?= base_url('/') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Kembali ke halaman utama
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>