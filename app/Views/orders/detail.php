<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="<?= base_url('orders') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Pesanan
            </a>
        </div>

        <div class="row g-4">
            <!-- Order Info -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt"></i> Detail Pesanan #<?= $order['id'] ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Pemesanan:</strong></p>
                                <p class="text-muted"><?= date('d F Y, H:i', strtotime($order['created_at'])) ?> WIB</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong></p>
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
                            <div class="alert alert-info">
                                <i class="bi bi-truck"></i>
                                <strong>Nomor Resi:</strong> <?= esc($order['tracking_number']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Pay Now Button -->
                        <?php if ($order['payment_status'] === 'pending' && !empty($order['snap_token'])): ?>
                        <div class="d-grid gap-2 mt-4">
                            <button id="pay-button" class="btn btn-primary btn-lg">
                                <i class="bi bi-credit-card-fill me-2"></i>Bayar Sekarang
                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- Shipping Address -->
                        <div class="border-top pt-3 mt-3">
                            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt"></i> Alamat Pengiriman</h6>
                            <p class="mb-1"><strong><?= esc($order['nama_penerima']) ?></strong></p>
                            <p class="mb-1"><?= esc($order['alamat_lengkap']) ?></p>
                            <p class="mb-1"><i class="bi bi-telephone"></i> <?= esc($order['no_telepon']) ?></p>
                            <p class="mb-0"><i class="bi bi-envelope"></i> <?= esc($order['email']) ?></p>
                            <?php if (!empty($order['catatan'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted"><strong>Catatan:</strong> <?= esc($order['catatan']) ?></small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Order Items -->
                        <div class="border-top pt-3 mt-3">
                            <h6 class="fw-bold mb-3"><i class="bi bi-box-seam"></i> Produk yang Dipesan</h6>
                            <?php if (!empty($order['items'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="table-light">
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
                                                            <img src="<?= !empty($item['gambar']) ? '/uploads/' . esc($item['gambar']) : '/assets/images/default-product.png' ?>" 
                                                                 alt="<?= esc($item['nama_produk']) ?>" 
                                                                 style="width: 50px; height: 50px; object-fit: cover;"
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
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                                                <td class="text-end fw-bold text-primary fs-5">
                                                    Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Tracking Timeline -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history"></i> Tracking Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($statusHistory)): ?>
                            <div class="timeline">
                                <?php foreach ($statusHistory as $index => $history): ?>
                                    <?php 
                                    $isLast = ($index === count($statusHistory) - 1);
                                    $statusLabel = $historyModel->getStatusLabel($history['status']);
                                    $icon = $historyModel->getStatusIcon($history['status']);
                                    $badgeClass = $historyModel->getStatusBadgeClass($history['status']);
                                    ?>
                                    <div class="timeline-item <?= $isLast ? 'active' : '' ?>">
                                        <div class="timeline-marker">
                                            <span class="badge <?= $badgeClass ?> rounded-circle p-2">
                                                <i class="bi <?= $icon ?>"></i>
                                            </span>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="fw-bold mb-1"><?= $statusLabel ?></h6>
                                            <p class="text-muted small mb-1">
                                                <?= date('d M Y, H:i', strtotime($history['created_at'])) ?> WIB
                                            </p>
                                            <?php if (!empty($history['notes'])): ?>
                                                <p class="small mb-0 text-secondary">
                                                    <i class="bi bi-chat-left-text"></i> <?= esc($history['notes']) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-clock text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Belum ada riwayat status</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="card shadow-sm mt-3">
                    <div class="card-body text-center">
                        <i class="bi bi-headset text-primary" style="font-size: 3rem;"></i>
                        <h6 class="mt-3 fw-bold">Butuh Bantuan?</h6>
                        <p class="text-muted small">Hubungi customer support kami</p>
                        <a href="<?= base_url('kontak') ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-chat-dots"></i> Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    padding: 0;
}

.timeline-item {
    position: relative;
    padding-left: 45px;
    padding-bottom: 30px;
}

.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: 16px;
    top: 35px;
    height: calc(100% - 15px);
    width: 2px;
    background: #dee2e6;
}

.timeline-item.active:not(:last-child):before {
    background: linear-gradient(180deg, #0d6efd 0%, #dee2e6 100%);
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
}

.timeline-marker .badge {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #dee2e6;
}

.timeline-item.active .timeline-content {
    background: #e7f1ff;
    border-left-color: #0d6efd;
}
</style>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>
<script type="text/javascript">
    <?php if ($order['payment_status'] === 'pending' && !empty($order['snap_token'])): ?>
    document.getElementById('pay-button').onclick = function(){
        snap.pay('<?= $order['snap_token'] ?>', {
            onSuccess: function(result){
                window.location.href = '<?= base_url('orders/success/' . $order['id']) ?>';
            },
            onPending: function(result){
                window.location.href = '<?= base_url('orders/pending/' . $order['id']) ?>';
            },
            onError: function(result){
                alert("Pembayaran gagal!"); console.log(result);
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
