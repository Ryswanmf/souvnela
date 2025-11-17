<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-journal-text me-2"></i>Manajemen Blog</h4>
        <a href="<?= base_url('admin/blog/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tulis Artikel</a>
    </div>

    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal Dibuat</th>
                        <th>Penulis</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($blog)): ?>
                        <?php foreach ($blog as $i => $b): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($b['judul']) ?></td>
                            <td><?= esc($b['kategori']) ?></td>
                            <td><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                            <td><?= esc($b['penulis']) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/blog/edit/'.$b['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('admin/blog/hapus/'.$b['id']) ?>" onclick="return confirm('Hapus artikel ini?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">Belum ada artikel.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
