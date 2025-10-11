<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="fw-bold mb-4"><i class="bi bi-envelope me-2"></i>Pesan Kontak</h4>

    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kontak)): ?>
                        <?php foreach ($kontak as $i => $k): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($k['nama']) ?></td>
                            <td><?= esc($k['email']) ?></td>
                            <td><?= esc($k['subjek']) ?></td>
                            <td><?= esc($k['pesan']) ?></td>
                            <td><?= date('d M Y', strtotime($k['tanggal'])) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/kontak/hapus/'.$k['id']) ?>" onclick="return confirm('Hapus pesan ini?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada pesan masuk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
