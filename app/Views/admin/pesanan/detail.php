<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-receipt-cutoff me-2"></i><?= esc($title) ?></h4>
        <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Order Info -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="card-title fw-bold">Pesanan #<?= esc($order['id']) ?></h5>
                            <p class="card-subtitle text-muted">Tanggal: <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div>
                            <?php 
                                $badgeClass = $historyModel->getStatusBadgeClass($order['status']);
                                $statusLabel = $historyModel->getStatusLabel($order['status']);
                            ?>
                            <span class="badge <?= $badgeClass ?> fs-6"><?= $statusLabel ?></span>
                        </div>
                    </div>
                    
                    <hr>

                    <!-- Customer & Shipping -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3"><i class="bi bi-person"></i> Info Pelanggan</h6>
                            <p class="mb-1"><strong><?= esc($order['nama_penerima']) ?></strong></p>
                            <p class="mb-1"><i class="bi bi-envelope"></i> <?= esc($order['email']) ?></p>
                            <p class="mb-0"><i class="bi bi-telephone"></i> <?= esc($order['no_telepon']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3"><i class="bi bi-truck"></i> Info Pengiriman</h6>
                            <p class="mb-1"><strong>Alamat:</strong> <?= esc($order['alamat_lengkap']) ?></p>
                            <?php if (!empty($order['tracking_number'])): ?>
                                <p class="mb-0"><strong>No. Resi:</strong> <?= esc($order['tracking_number']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Map -->
                    <?php if (!empty($order['latitude']) && !empty($order['longitude'])): ?>
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill"></i> Lokasi Peta</h6>
                        <div id="map" style="height: 300px; width: 100%;" class="border rounded"></div>
                    </div>
                    <?php endif; ?>

                    <hr class="my-4">

                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3"><i class="bi bi-box-seam"></i> Rincian Produk</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= !empty($item['gambar']) ? base_url('uploads/' . esc($item['gambar'])) : base_url('assets/images/default-product.png') ?>" 
                                                     alt="<?= esc($item['nama_produk']) ?>" 
                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                     class="rounded me-2">
                                                <span><?= esc($item['nama_produk']) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center"><?= $item['jumlah'] ?></td>
                                        <td class="text-end">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                        <td class="text-end fw-bold">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Total -->
                    <div class="row justify-content-end mt-3">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Subtotal
                                    <span>Rp <?= number_format($order['subtotal'], 0, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Ongkir
                                    <span>Rp <?= number_format($order['ongkir'], 0, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-danger">
                                    Diskon
                                    <span>- Rp <?= number_format($order['diskon'], 0, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold fs-5">
                                    TOTAL
                                    <span class="text-primary">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status & History -->
        <div class="col-lg-4">
            <!-- Update Status Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0"><i class="bi bi-pencil-square"></i> Update Status Pesanan</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/pesanan/updateStatus/'.$order['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Nomor Resi (jika dikirim)</label>
                            <input type="text" name="tracking_number" id="tracking_number" class="form-control" value="<?= esc($order['tracking_number']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Order History -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="fw-bold mb-0"><i class="bi bi-clock-history"></i> Riwayat Status</h6>
                </div>
                <div class="card-body">
                     <?php if (!empty($statusHistory)): ?>
                        <div class="timeline">
                            <?php foreach ($statusHistory as $history): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker">
                                         <span class="badge <?= $historyModel->getStatusBadgeClass($history['status']) ?> rounded-circle p-2">
                                            <i class="bi <?= $historyModel->getStatusIcon($history['status']) ?>"></i>
                                        </span>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1"><?= $historyModel->getStatusLabel($history['status']) ?></h6>
                                        <p class="text-muted small mb-1">
                                            <?= date('d M Y, H:i', strtotime($history['created_at'])) ?>
                                        </p>
                                        <?php if (!empty($history['notes'])): ?>
                                            <p class="small mb-0 text-secondary"><?= esc($history['notes']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">Belum ada riwayat.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($order['latitude']) && !empty($order['longitude'])): ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = <?= $order['latitude'] ?>;
        const lng = <?= $order['longitude'] ?>;

        const map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('Lokasi Pengiriman').openPopup();
    });
</script>
<?php endif; ?>

<style>
.timeline { position: relative; padding-left: 20px; }
.timeline-item { position: relative; padding-bottom: 20px; }
.timeline-item:not(:last-child):before { content: ''; position: absolute; left: -11px; top: 28px; height: calc(100% - 10px); width: 2px; background: #dee2e6; }
.timeline-marker { position: absolute; left: -30px; top: 0; }
.timeline-marker .badge { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; }
.timeline-content { padding-left: 15px; }
</style>

<?= $this->endSection() ?>