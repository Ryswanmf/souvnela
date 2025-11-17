<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Manajemen Produk</h4>
        <a href="<?= base_url('admin/produk/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Produk</a>
    </div>

    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Unggulan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produk)): ?>
                        <?php foreach ($produk as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><img src="<?= base_url('uploads/'.$p['gambar']) ?>" width="60" class="rounded"></td>
                            <td><?= esc($p['nama']) ?></td>
                            <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                            <td><?= $p['stok'] ?></td>
                            <td>
                                <?php if ($p['stok'] > 5): ?>
                                    <span class="badge bg-success">Tersedia</span>
                                <?php elseif ($p['stok'] > 0): ?>
                                    <span class="badge bg-warning text-dark">Menipis</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($p['is_unggulan']): ?>
                                    <i class="bi bi-star-fill text-warning"></i>
                                <?php else: ?>
                                    <i class="bi bi-star text-muted"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/produk/toggleFeatured/'.$p['id']) ?>" 
                                   class="btn btn-sm btn-outline-secondary" 
                                   title="<?= $p['is_unggulan'] ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' ?>">
                                    <i class="bi bi-star"></i>
                                </a>
                                <a href="<?= base_url('admin/produk/edit/'.$p['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('admin/produk/hapus/'.$p['id']) ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center text-muted">Belum ada data produk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
