<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="fw-bold mb-4">
        <i class="bi bi-people me-2"></i>Daftar Pengguna
    </h4>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <a href="<?= base_url('admin/pengguna/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna Baru
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Foto</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users) && is_array($users)): ?>
                        <?php foreach ($users as $i => $u): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>
                                    <img src="<?= !empty($u['foto_profil']) ? base_url('uploads/' . $u['foto_profil']) : base_url('assets/images/default-avatar.png') ?>" 
                                         alt="Foto Profil" 
                                         class="img-fluid rounded-circle" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong><?= esc($u['nama_lengkap'] ?? '-') ?></strong><br>
                                    <small class="text-muted">@<?= esc($u['username'] ?? '-') ?></small>
                                </td>
                                <td><?= esc($u['email'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-<?= ($u['role'] ?? '') === 'admin' ? 'primary' : 'secondary' ?>">
                                        <?= ucfirst($u['role'] ?? 'User') ?>
                                    </span>
                                </td>
                                <td>
                                    <?= !empty($u['created_at']) ? date('d M Y', strtotime($u['created_at'])) : '-' ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/pengguna/edit/' . ($u['id'] ?? 0)) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pengguna/hapus/' . ($u['id'] ?? 0)) ?>" 
                                       onclick="return confirm('Hapus pengguna ini?')" 
                                       class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-exclamation-circle me-1"></i>Belum ada pengguna.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
