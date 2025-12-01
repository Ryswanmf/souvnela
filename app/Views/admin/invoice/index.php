<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-receipt me-2"></i>Data Invoice</h4>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="" method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="<?= esc($startDate) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="<?= esc($endDate) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Pesanan</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= $status == 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="shipped" <?= $status == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $status == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                        <option value="cancelled" <?= $status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($invoices)): ?>
                            <?php foreach ($invoices as $invoice): ?>
                                <tr>
                                    <td class="fw-bold text-primary">#INV-<?= str_pad($invoice['id'], 6, '0', STR_PAD_LEFT) ?></td>
                                    <td><?= date('d M Y', strtotime($invoice['created_at'])) ?></td>
                                    <td>
                                        <div><?= esc($invoice['nama_penerima']) ?></div>
                                        <small class="text-muted"><?= esc($invoice['nama_user'] ?? 'Guest') ?></small>
                                    </td>
                                    <td class="fw-bold">Rp <?= number_format($invoice['total_harga'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php 
                                        $payStatus = $invoice['payment_status'];
                                        $badgeColor = ($payStatus == 'settlement' || $payStatus == 'capture') ? 'success' : (($payStatus == 'pending') ? 'warning' : 'danger');
                                        ?>
                                        <span class="badge bg-<?= $badgeColor ?>"><?= strtoupper($payStatus) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?= strtoupper($invoice['status']) ?></span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('admin/pesanan/invoice/' . $invoice['id']) ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Cetak Invoice">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <a href="<?= base_url('admin/pesanan/detail/' . $invoice['id']) ?>" class="btn btn-sm btn-outline-info" title="Detail Pesanan">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Data invoice tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                <?= $pager->links('invoices', 'default_full') ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
