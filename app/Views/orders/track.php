<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <i class="bi bi-truck" style="font-size: 3rem;"></i>
                        <h3 class="mt-3 mb-0">Lacak Pesanan</h3>
                        <p class="mb-0">Order #<?= $order['id'] ?></p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Order Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Penerima:</p>
                                <p class="fw-bold"><?= esc($order['nama_penerima']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Status Saat Ini:</p>
                                <?php 
                                $pesananModel = new \App\Models\PesananModel();
                                $statusLabel = $pesananModel->getStatusLabel($order['status'] ?? 'pending');
                                $badgeClass = $historyModel->getStatusBadgeClass($order['status'] ?? 'pending');
                                $icon = $historyModel->getStatusIcon($order['status'] ?? 'pending');
                                ?>
                                <span class="badge <?= $badgeClass ?> py-2 px-3">
                                    <i class="bi <?= $icon ?>"></i> <?= $statusLabel ?>
                                </span>
                            </div>
                        </div>

                        <?php if (!empty($order['tracking_number'])): ?>
                            <div class="alert alert-info text-center mb-4">
                                <h5 class="mb-2"><i class="bi bi-box-seam"></i> Nomor Resi</h5>
                                <h4 class="fw-bold text-primary mb-0"><?= esc($order['tracking_number']) ?></h4>
                            </div>
                        <?php endif; ?>

                        <!-- Tracking Timeline -->
                        <div class="tracking-timeline">
                            <?php if (!empty($statusHistory)): ?>
                                <?php foreach ($statusHistory as $index => $history): ?>
                                    <?php 
                                    $isLast = ($index === count($statusHistory) - 1);
                                    $statusLabel = $historyModel->getStatusLabel($history['status']);
                                    $icon = $historyModel->getStatusIcon($history['status']);
                                    $badgeClass = $historyModel->getStatusBadgeClass($history['status']);
                                    ?>
                                    <div class="tracking-item <?= $isLast ? 'active' : 'completed' ?>">
                                        <div class="tracking-icon">
                                            <span class="badge <?= $badgeClass ?> rounded-circle">
                                                <i class="bi <?= $icon ?> fs-4"></i>
                                            </span>
                                        </div>
                                        <div class="tracking-content">
                                            <div class="tracking-date">
                                                <?= date('d M Y', strtotime($history['created_at'])) ?>
                                                <span class="text-muted">• <?= date('H:i', strtotime($history['created_at'])) ?> WIB</span>
                                            </div>
                                            <div class="tracking-title"><?= $statusLabel ?></div>
                                            <?php if (!empty($history['notes'])): ?>
                                                <div class="tracking-description">
                                                    <?= esc($history['notes']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-clock-history text-muted" style="font-size: 4rem;"></i>
                                    <h5 class="mt-3 text-muted">Belum ada riwayat tracking</h5>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="text-center mt-4 pt-4 border-top">
                            <a href="<?= base_url('orders') ?>" class="btn btn-outline-primary me-2">
                                <i class="bi bi-list-ul"></i> Lihat Semua Pesanan
                            </a>
                            <?php if (session()->get('isLoggedIn')): ?>
                                <a href="<?= base_url('orders/detail/' . $order['id']) ?>" class="btn btn-primary">
                                    <i class="bi bi-receipt"></i> Detail Pesanan
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Need Help Section -->
                <div class="text-center mt-4">
                    <p class="text-muted">Butuh bantuan dengan pesanan Anda?</p>
                    <a href="<?= base_url('kontak') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-headset"></i> Hubungi Customer Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.tracking-timeline {
    position: relative;
    padding: 20px 0;
}

.tracking-item {
    position: relative;
    padding-left: 80px;
    padding-bottom: 40px;
    min-height: 100px;
}

.tracking-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: 28px;
    top: 60px;
    height: calc(100% - 40px);
    width: 3px;
    background: #dee2e6;
}

.tracking-item.completed:not(:last-child):before {
    background: linear-gradient(180deg, #198754 0%, #dee2e6 100%);
}

.tracking-item.active:not(:last-child):before {
    background: linear-gradient(180deg, #0d6efd 0%, #dee2e6 100%);
}

.tracking-icon {
    position: absolute;
    left: 0;
    top: 5px;
}

.tracking-icon .badge {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.tracking-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

.tracking-item.active .tracking-content {
    border-color: #0d6efd;
    background: #f8f9ff;
    box-shadow: 0 4px 12px rgba(13,110,253,0.1);
}

.tracking-item.completed .tracking-content {
    border-color: #198754;
    opacity: 0.8;
}

.tracking-date {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.tracking-title {
    font-size: 1.1rem;
    font-weight: bold;
    color: #212529;
    margin-bottom: 5px;
}

.tracking-description {
    font-size: 0.9rem;
    color: #6c757d;
    margin-top: 8px;
}

.tracking-item:hover .tracking-content {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>

<?= $this->endSection() ?>
