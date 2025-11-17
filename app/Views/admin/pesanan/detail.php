<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-receipt-cutoff me-2"></i><?= esc($title) ?></h4>
        <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Item Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?= esc($item['nama_produk']) ?></td>
                                        <td class="text-center"><?= $item['quantity'] ?></td>
                                        <td class="text-end"><?= number_to_currency($item['harga'], 'IDR') ?></td>
                                        <td class="text-end fw-medium"><?= number_to_currency($item['harga'] * $item['quantity'], 'IDR') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ringkasan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Kode Pesanan:</span>
                            <strong><?= esc($pesanan['kode']) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Pelanggan:</span>
                            <strong><?= esc($pesanan['pelanggan']) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Tanggal:</span>
                            <strong><?= date('d M Y, H:i', strtotime($pesanan['created_at'])) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Status:</span>
                            <strong>
                                <?php
                                    $statusClass = 'bg-secondary';
                                    if ($pesanan['status'] === 'Baru') $statusClass = 'bg-info text-dark';
                                    if ($pesanan['status'] === 'Proses') $statusClass = 'bg-warning text-dark';
                                    if ($pesanan['status'] === 'Selesai') $statusClass = 'bg-success';
                                    if ($pesanan['status'] === 'Dibatalkan') $statusClass = 'bg-danger';
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= esc($pesanan['status']) ?></span>
                            </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center fs-5 fw-bold">
                            <span>Total:</span>
                            <span><?= number_to_currency($pesanan['total'], 'IDR') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
