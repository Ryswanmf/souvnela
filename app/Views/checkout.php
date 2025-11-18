<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="checkout" class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Checkout</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('place-order') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <!-- Form Checkout -->
                <div class="col-lg-8">
                    <!-- Informasi Kontak -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-person-circle me-2"></i>Informasi Kontak
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= esc(old('nama_lengkap', session()->get('nama_lengkap'))) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= esc(old('email', session()->get('email'))) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="telepon" name="telepon" value="<?= esc(old('telepon')) ?>" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Jl. Nama Jalan No. XX" required><?= esc(old('alamat')) ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kota" name="kota" value="<?= esc(old('kota')) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?= esc(old('provinsi')) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="kode_pos" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="<?= esc(old('kode_pos')) ?>" placeholder="12345" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-credit-card me-2"></i>Metode Pembayaran
                            </h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="transfer_bank" value="transfer_bank" checked>
                                <label class="form-check-label" for="transfer_bank">
                                    <strong>Transfer Bank</strong>
                                    <p class="mb-0 text-muted small">Transfer ke rekening bank yang tersedia</p>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="cod" value="cod">
                                <label class="form-check-label" for="cod">
                                    <strong>COD (Cash on Delivery)</strong>
                                    <p class="mb-0 text-muted small">Bayar saat barang diterima</p>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="ewallet" value="ewallet">
                                <label class="form-check-label" for="ewallet">
                                    <strong>E-Wallet</strong>
                                    <p class="mb-0 text-muted small">Gopay, OVO, DANA, dll</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Pesanan -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-chat-left-text me-2"></i>Catatan Pesanan (Opsional)
                            </h5>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Catatan untuk penjual, misalnya warna, ukuran, atau instruksi khusus"><?= esc(old('catatan')) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Ringkasan Pesanan</h5>
                            
                            <!-- List Produk -->
                            <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($cart as $item): ?>
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                        <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 small"><?= esc($item['nama']) ?></h6>
                                            <small class="text-muted"><?= $item['quantity'] ?> x <?= number_to_currency($item['harga'], 'IDR') ?></small>
                                        </div>
                                        <span class="fw-medium"><?= number_to_currency($item['harga'] * $item['quantity'], 'IDR') ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Subtotal -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span><?= number_to_currency($total, 'IDR') ?></span>
                            </div>

                            <!-- Ongkir -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkos Kirim</span>
                                <span class="text-muted">Gratis</span>
                            </div>

                            <hr>

                            <!-- Total -->
                            <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mb-4">
                                <span>Total</span>
                                <span class="text-primary"><?= number_to_currency($total, 'IDR') ?></span>
                            </div>

                            <!-- Tombol Checkout -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="bi bi-bag-check me-2"></i>Konfirmasi Pesanan
                            </button>
                            <a href="<?= base_url('cart') ?>" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>Pembayaran aman & terpercaya
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?= $this->endSection() ?>
