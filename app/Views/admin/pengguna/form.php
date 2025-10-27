<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold"><?= $title ?></h4>
        <p class="text-muted">Ubah detail pengguna dan hak aksesnya</p>
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
            <input type="hidden" name="_method" value="POST">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" value="<?= esc($user['username'] ?? '') ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" class="form-control" value="<?= esc($user['nama_lengkap'] ?? '') ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="pembeli" <?= ($user['role'] ?? '') === 'pembeli' ? 'selected' : '' ?>>Pembeli</option>
                    <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('admin/pengguna') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
