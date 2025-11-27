<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="bi bi-bag-check me-2"></i>Pesanan Saya
                </h2>
                <p class="text-muted">Daftar semua pesanan Anda</p>
            </div>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="row g-4">
                <?php foreach ($orders as $order): ?>
                    <div class="col-12">
                        <div class="card shadow-sm hover-shadow">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Order Info -->
                                    <div class="col-md-3">
                                        <h6 class="fw-bold mb-1">Order #<?= $order['id'] ?></h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar"></i> 
                                            <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                                        </small>
                                    </div>

                                    <!-- Customer Info -->
                                    <div class="col-md-3">
                                        <small class="text-muted d-block">Penerima:</small>
                                        <strong><?= esc($order['nama_penerima']) ?></strong>
                                    </div>

                                    <!-- Total -->
                                    <div class="col-md-2">
                                        <small class="text-muted d-block">Total:</small>
                                        <strong class="text-primary">
                                            Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                                        </strong>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2">
                                        <?php 
                                        $pesananModel = new \App\Models\PesananModel();
                                        $statusLabel = $pesananModel->getStatusLabel($order['status'] ?? 'pending');
                                        $historyModel = new \App\Models\OrderStatusHistoryModel();
                                        $badgeClass = $historyModel->getStatusBadgeClass($order['status'] ?? 'pending');
                                        $icon = $historyModel->getStatusIcon($order['status'] ?? 'pending');
                                        ?>
                                        <span class="badge <?= $badgeClass ?> w-100 py-2">
                                            <i class="bi <?= $icon ?>"></i> <?= $statusLabel ?>
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="col-md-2 text-end">
                                        <a href="<?= base_url('orders/detail/' . $order['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </div>
                                </div>

                                <!-- Tracking Number if shipped -->
                                <?php if (isset($order['status']) && $order['status'] === 'shipped' && !empty($order['tracking_number'])): ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="alert alert-info mb-0 py-2">
                                                <i class="bi bi-truck"></i>
                                                <strong>Nomor Resi:</strong> <?= esc($order['tracking_number']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-bag-x text-muted" style="font-size: 5rem;"></i>
                            <h4 class="mt-3">Belum Ada Pesanan</h4>
                            <p class="text-muted">Anda belum memiliki pesanan apapun.</p>
                            <a href="<?= base_url('produk') ?>" class="btn btn-primary">
                                <i class="bi bi-shop me-2"></i>Belanja Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<?= $this->endSection() ?>
