<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="account-orders" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4"><?= $title ?></h2>

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
                                <th>Kode Pesanan</th>
                                <th>Tanggal</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr data-bs-toggle="collapse" data-bs-target="#orderDetail-<?= $order['id'] ?>" aria-expanded="false" aria-controls="orderDetail-<?= $order['id'] ?>" style="cursor: pointer;">
                                        <td class="fw-medium"><?= esc($order['kode']) ?></td>
                                        <td><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                                        <td class="text-end"><?= number_to_currency($order['total_harga'], 'IDR') ?></td>
                                        <td class="text-center">
                                            <?php
                                                $statusClass = 'bg-secondary';
                                                if ($order['status'] === 'Baru') $statusClass = 'bg-info text-dark';
                                                if ($order['status'] === 'Proses') $statusClass = 'bg-warning text-dark';
                                                if ($order['status'] === 'Selesai') $statusClass = 'bg-success';
                                                if ($order['status'] === 'Dibatalkan') $statusClass = 'bg-danger';
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= esc($order['status']) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <?php if ($order['status'] === 'Baru'): ?>
                                                <a href="<?= base_url('account/cancel/' . $order['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Anda yakin ingin membatalkan pesanan ini?')">
                                                   Batalkan
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="orderDetail-<?= $order['id'] ?>">
                                        <td colspan="5">
                                            <div class="card card-body bg-light mt-2 p-3">
                                                <h6>Detail Item:</h6>
                                                <ul class="list-group list-group-flush">
                                                    <?php foreach ($order['items'] as $item): ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <?= esc($item['nama_produk']) ?> 
                                                                <span class="text-muted small">x <?= $item['quantity'] ?></span>
                                                            </div>
                                                            <span><?= number_to_currency($item['harga'] * $item['quantity'], 'IDR') ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Anda belum memiliki riwayat pesanan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
