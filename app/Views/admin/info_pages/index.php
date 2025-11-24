<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="fw-bold mb-4"><i class="bi bi-file-earmark-text me-2"></i><?= esc($title) ?></h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Halaman</th>
                        <th>Terakhir Diperbarui</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= $page['id'] ?></td>
                            <td><?= esc($page['title']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($page['updated_at'])) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/info-pages/edit/'.$page['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted">Tidak ada halaman informasi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
