<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><?= $title ?></h4>
        <a href="<?= base_url('admin/voucher/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Voucher
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Diskon</th>
                            <th>Min. Belanja</th>
                            <th>Berlaku</th>
                            <th>Digunakan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($vouchers)): ?>
                            <?php foreach ($vouchers as $voucher): ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary"><?= esc($voucher['code']) ?></span>
                                        <div class="small text-muted"><?= esc($voucher['description']) ?></div>
                                    </td>
                                    <td>
                                        <?php if ($voucher['discount_type'] === 'percentage'): ?>
                                            <span class="badge bg-info text-dark"><?= $voucher['discount_value'] ?>%</span>
                                            <?php if ($voucher['max_discount'] > 0): ?>
                                                <div class="small text-muted">Max: <?= number_to_currency($voucher['max_discount'], 'IDR') ?></div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-success"><?= number_to_currency($voucher['discount_value'], 'IDR') ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= number_to_currency($voucher['min_purchase'], 'IDR') ?></td>
                                    <td>
                                        <div class="small">
                                            <?= date('d/m/y', strtotime($voucher['valid_from'])) ?> - 
                                            <?= date('d/m/y', strtotime($voucher['valid_until'])) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $voucher['used_count'] ?> / 
                                        <?= $voucher['usage_limit'] > 0 ? $voucher['usage_limit'] : '∞' ?>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('admin/voucher/toggleStatus/' . $voucher['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn badge <?= $voucher['is_active'] ? 'bg-success' : 'bg-secondary' ?> border-0">
                                                <?= $voucher['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('admin/voucher/edit/' . $voucher['id']) ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/voucher/delete/' . $voucher['id']) ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Yakin ingin menghapus voucher ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada voucher.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
