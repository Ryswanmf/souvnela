<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold"><?= $title ?></h4>
        <p class="text-muted"><?= !empty($user['id']) ? 'Ubah detail pengguna dan hak aksesnya' : 'Isi detail untuk pengguna baru' ?></p>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <p class="fw-bold">Gagal menyimpan:</p>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form action="<?= $action ?>" method="post">
            <?= csrf_field() ?>
            
            <?php if (!empty($user['id'])): ?>
                <input type="hidden" name="_method" value="POST"> <!-- Should be PUT, but HTML forms only support GET/POST -->
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap', $user['nama_lengkap'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?= old('username', $user['username'] ?? '') ?>" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= old('email', $user['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" <?= empty($user['id']) ? 'required' : '' ?>>
                <?php if (!empty($user['id'])): ?>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="pembeli" <?= old('role', $user['role'] ?? '') === 'pembeli' ? 'selected' : '' ?>>Pembeli</option>
                    <option value="admin" <?= old('role', $user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><?= !empty($user['id']) ? 'Simpan Perubahan' : 'Simpan Pengguna' ?></button>
                <a href="<?= base_url('admin/pengguna') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
