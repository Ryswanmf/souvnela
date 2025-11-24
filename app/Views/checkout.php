<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="checkout" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4">
            <i class="fas fa-shopping-cart text-primary"></i> Checkout
        </h2>

        <form action="<?= base_url('place-order') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <!-- Left Column: Shipping & Payment Info -->
                <div class="col-lg-7">
                    <!-- Shipping Address -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_penerima" 
                                       value="<?= esc(session()->get('nama_lengkap')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="no_telepon" 
                                       placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" 
                                       value="<?= esc(session()->get('email')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat_lengkap" rows="3" 
                                          placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Catatan (Opsional)</label>
                                <textarea class="form-control" name="catatan" rows="2" 
                                          placeholder="Catatan untuk penjual..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-tag"></i> Kode Voucher</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($voucherCode): ?>
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Voucher <?= esc($voucherCode) ?></strong> diterapkan!
                                        <br>
                                        <small>Diskon: Rp <?= number_format($discount, 0, ',', '.') ?></small>
                                    </div>
                                    <a href="<?= base_url('cart/remove-voucher') ?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"></i> Hapus
                                    </a>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('cart/apply-voucher') ?>" method="post" class="mb-3">
                                    <?= csrf_field() ?>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="voucher_code" 
                                               placeholder="Masukkan kode voucher" required>
                                        <button class="btn btn-success" type="submit">
                                            <i class="fas fa-check"></i> Terapkan
                                        </button>
                                    </div>
                                </form>

                                <?php if (!empty($vouchers)): ?>
                                    <div class="available-vouchers">
                                        <p class="text-muted mb-2"><small>Voucher tersedia:</small></p>
                                        <div class="row g-2">
                                            <?php foreach ($vouchers as $voucher): ?>
                                                <div class="col-md-6">
                                                    <div class="card border-success">
                                                        <div class="card-body p-2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <strong class="text-success"><?= esc($voucher['code']) ?></strong>
                                                                    <br>
                                                                    <small class="text-muted">
                                                                        <?php if ($voucher['discount_type'] === 'percentage'): ?>
                                                                            Diskon <?= $voucher['discount_value'] ?>%
                                                                        <?php else: ?>
                                                                            Diskon Rp <?= number_format($voucher['discount_value'], 0, ',', '.') ?>
                                                                        <?php endif; ?>
                                                                    </small>
                                                                </div>
                                                                <button type="button" class="btn btn-sm btn-outline-success copy-voucher" 
                                                                        data-code="<?= esc($voucher['code']) ?>">
                                                                    <i class="fas fa-copy"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt"></i> Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <!-- Cart Items -->
                            <div class="order-items mb-3" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($cart as $item): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="<?= base_url('uploads/produk/' . $item['gambar']) ?>" 
                                             alt="<?= esc($item['nama']) ?>" 
                                             class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 small"><?= esc($item['nama']) ?></h6>
                                            <small class="text-muted"><?= $item['quantity'] ?> x Rp <?= number_format($item['harga'], 0, ',', '.') ?></small>
                                        </div>
                                        <div class="text-end">
                                            <strong>Rp <?= number_format($item['harga'] * $item['quantity'], 0, ',', '.') ?></strong>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                <?php endforeach; ?>
                            </div>

                            <!-- Price Summary -->
                            <div class="price-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                                </div>
                                
                                <?php if ($discount > 0): ?>
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span><i class="fas fa-tag"></i> Diskon Voucher</span>
                                        <span>- Rp <?= number_format($discount, 0, ',', '.') ?></span>
                                    </div>
                                <?php endif; ?>

                                <hr>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Total Pembayaran</h5>
                                    <h4 class="mb-0 text-primary">Rp <?= number_format($total - $discount, 0, ',', '.') ?></h4>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                    <i class="fas fa-lock"></i> Proses Pembayaran
                                </button>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt"></i> Pembayaran aman dengan Midtrans
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-body text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Dengan melakukan pemesanan, Anda menyetujui 
                                <a href="#">syarat dan ketentuan</a> kami.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
// Copy voucher code
document.querySelectorAll('.copy-voucher').forEach(btn => {
    btn.addEventListener('click', function() {
        const code = this.dataset.code;
        const input = document.querySelector('input[name="voucher_code"]');
        input.value = code;
        
        // Show feedback
        const icon = this.querySelector('i');
        icon.className = 'fas fa-check';
        setTimeout(() => {
            icon.className = 'fas fa-copy';
        }, 1500);
    });
});
</script>

<?= $this->endSection() ?>
