<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="fw-bold mb-4">
        <i class="bi bi-people me-2"></i>Daftar Pengguna
    </h4>

    <div class="card border-0 shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
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
                                <td><?= esc($u['username'] ?? '-') ?></td>
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
                                    <a href="<?= base_url('admin/users/edit/' . ($u['id'] ?? 0)) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('admin/users/hapus/' . ($u['id'] ?? 0)) ?>" 
                                       onclick="return confirm('Hapus pengguna ini?')" 
                                       class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
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
