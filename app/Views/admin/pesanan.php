<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2"></i>Daftar Pesanan</h4>

    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pesanan)): ?>
                        <?php foreach ($pesanan as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($p['kode']) ?></td>
                            <td><?= esc($p['pelanggan']) ?></td>
                            <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                            <td>Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($p['status'] == 'Selesai'): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php elseif ($p['status'] == 'Proses'): ?>
                                    <span class="badge bg-warning text-dark">Proses</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= esc($p['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/pesanan/detail/'.$p['id']) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada pesanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
