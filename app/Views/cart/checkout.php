<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <h1 class="text-center mb-4">
                <i class="fas fa-shopping-bag text-primary me-2"></i>
                Checkout Pesanan
            </h1>
        </div>
    </div>

    <div class="row">
        <!-- Form Pengiriman -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-truck me-2"></i>Informasi Pengiriman
                    </h5>
                </div>
                <div class="card-body">
                    <form id="checkoutForm">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap *</label>
                                <input type="text" class="form-control" name="nama_penerima" required value="<?= esc(session()->get('nama_lengkap')) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Telepon *</label>
                                <input type="tel" class="form-control" name="no_telepon" required placeholder="Contoh: 08123456789">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" class="form-control" name="email" required value="<?= esc(session()->get('email')) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap *</label>
                            <textarea class="form-control" name="alamat_lengkap" id="alamat" rows="3" required placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kota/Kabupaten *</label>
                                <input type="text" class="form-control" name="kota" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kode Pos *</label>
                                <input type="text" class="form-control" name="kode_pos" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="2" placeholder="Pesan khusus untuk penjual..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Metode Pengiriman *</label>
                            <select class="form-select" name="shipping_method" id="shippingMethod" required>
                                <option value="">Pilih Metode Pengiriman</option>
                                <option value="JNE Reguler" data-cost="10000">JNE Reguler (2-3 hari) - Rp 10.000</option>
                                <option value="J&T Express" data-cost="12000">J&T Express (1-2 hari) - Rp 12.000</option>
                                <option value="SiCepat" data-cost="11000">SiCepat (2-3 hari) - Rp 11.000</option>
                            </select>
                        </div>

                        <!-- Voucher Section -->
                        <div class="mb-3 pt-3 border-top">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-ticket-alt me-1"></i>Kode Voucher
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="voucherCode" placeholder="Punya kode diskon?">
                                <button type="button" class="btn btn-outline-primary" onclick="applyVoucher()">Gunakan</button>
                            </div>
                            <div id="voucherMessage" class="mt-2"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="col-lg-5">
            <div class="card shadow-sm sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($cart)): ?>
                        <div class="order-items mb-3" style="max-height: 300px; overflow-y: auto;">
                            <?php foreach ($cart as $item): ?>
                                <div class="d-flex align-items-center border-bottom py-3">
                                    <?php
                                    $imgSrc = base_url('uploads/produk/' . $item['gambar']);
                                    ?>
                                    <img src="<?= $imgSrc ?>" alt="<?= esc($item['nama']) ?>" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold"><?= esc($item['nama']) ?></h6>
                                        <small class="text-muted"><?= $item['quantity'] ?> x Rp <?= number_format($item['harga'], 0, ',', '.') ?></small>
                                    </div>
                                    <div class="text-end">
                                        <strong class="text-primary">Rp <?= number_format($item['harga'] * $item['quantity'], 0, ',', '.') ?></strong>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="bg-light p-3 rounded mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <strong id="subtotal">Rp <?= number_format($total, 0, ',', '.') ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir</span>
                            <strong id="shippingCost">Rp 0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="discountRow" style="display: none;">
                            <span class="text-success">Diskon Voucher</span>
                            <strong class="text-success" id="discountAmount">- Rp 0</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Total Bayar</h5>
                            <h4 class="mb-0 text-primary" id="grandTotal">Rp <?= number_format($total, 0, ',', '.') ?></h4>
                        </div>
                    </div>

                    <input type="hidden" id="subtotalValue" value="<?= $total ?>">
                    <input type="hidden" id="shippingValue" value="0">
                    <input type="hidden" id="discountValue" value="0">
                    <input type="hidden" id="voucherId" value="">

                    <button type="button" class="btn btn-primary w-100 mt-3 py-3 fw-bold shadow-sm" onclick="processCheckout()">
                        <i class="fas fa-lock me-2"></i>Bayar Sekarang
                    </button>

                    <div class="text-center mt-3 pt-3 border-top">
                        <small class="text-muted d-block mb-2">Didukung oleh:</small>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Midtrans.png/1200px-Midtrans.png" alt="Midtrans" style="height: 25px; opacity: 0.8;">
                        <p class="text-muted small mt-2 mb-0"><i class="fas fa-shield-alt text-success"></i> Pembayaran Aman & Terenkripsi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php 
    // Ensure Client Key is available
    $clientKey = getenv('MIDTRANS_CLIENT_KEY') ?: ''; // Fallback or blank
?>

<?php if ($clientKey): ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<?php else: ?>
    <script>console.error("MIDTRANS_CLIENT_KEY is missing. Please check your .env file.");</script>
<?php endif; ?>

<script>
    // 1. Update Shipping Cost
    document.getElementById('shippingMethod').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        // Default to 0 if no cost found
        const shippingCost = parseInt(selectedOption.dataset.cost) || 0;

        document.getElementById('shippingValue').value = shippingCost;
        document.getElementById('shippingCost').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');

        calculateTotal();
    });

    // 2. Calculate Grand Total
    function calculateTotal() {
        const subtotal = parseInt(document.getElementById('subtotalValue').value) || 0;
        const shipping = parseInt(document.getElementById('shippingValue').value) || 0;
        const discount = parseInt(document.getElementById('discountValue').value) || 0;

        const grandTotal = subtotal + shipping - discount;
        // Ensure total is not negative
        const finalTotal = grandTotal > 0 ? grandTotal : 0;
        
        document.getElementById('grandTotal').textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
    }

    // 3. Apply Voucher
    function applyVoucher() {
        const voucherCode = document.getElementById('voucherCode').value.trim();

        if (!voucherCode) {
            alert('Silakan masukkan kode voucher terlebih dahulu.');
            return;
        }

        // Prepare CSRF data
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';
        
        // Check if we have a fresher token from a previous request input
        const formInput = document.querySelector('input[name="' + csrfName + '"]');
        if (formInput) {
            csrfHash = formInput.value;
        }

        const btn = event.target; // Button element
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = '...';

        $.ajax({
            url: '<?= base_url('payment/check-voucher') ?>',
            type: 'POST',
            data: {
                [csrfName]: csrfHash,
                voucher_code: voucherCode,
                subtotal: document.getElementById('subtotalValue').value
            },
            success: function(response) {
                // Update CSRF token if returned
                if (response.token && formInput) {
                    formInput.value = response.token;
                }

                if (response.success) {
                    document.getElementById('voucherId').value = response.voucher_id;
                    document.getElementById('discountValue').value = response.discount;
                    document.getElementById('discountAmount').textContent = '- Rp ' + response.discount.toLocaleString('id-ID');
                    document.getElementById('discountRow').style.display = 'flex';

                    $('#voucherMessage').html('<div class="text-success small mt-1"><i class="fas fa-check-circle"></i> Voucher diterapkan! Hemat Rp ' + response.discount.toLocaleString('id-ID') + '</div>');
                    calculateTotal();
                } else {
                    // Reset discount if failed
                    document.getElementById('voucherId').value = '';
                    document.getElementById('discountValue').value = 0;
                    document.getElementById('discountRow').style.display = 'none';
                    calculateTotal();
                    $('#voucherMessage').html('<div class="text-danger small mt-1"><i class="fas fa-times-circle"></i> ' + response.message + '</div>');
                }
            },
            error: function(xhr) {
                console.error(xhr);
                $('#voucherMessage').html('<div class="text-danger small mt-1">Gagal mengecek voucher.</div>');
            },
            complete: function() {
                btn.disabled = false;
                btn.innerText = originalText;
            }
        });
    }

    // 4. Process Checkout (Midtrans)
    function processCheckout() {
        const form = document.getElementById('checkoutForm');
        
        if (!form.checkValidity()) {
            form.reportValidity(); // Show native browser validation errors
            return;
        }

        const btn = document.querySelector('button[onclick="processCheckout()"]');
        const originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

        const formData = new FormData(form);
        
        // Add manually tracked values
        formData.append('total', document.getElementById('grandTotal').textContent.replace(/[^0-9]/g, ''));
        formData.append('voucher_id', document.getElementById('voucherId').value);
        formData.append('shipping_cost', document.getElementById('shippingValue').value);
        formData.append('discount_amount', document.getElementById('discountValue').value);

        // Ensure CSRF is sent
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: '<?= base_url('payment/process') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Check Snap
                    if (typeof snap === 'undefined') {
                        alert("Sistem pembayaran sedang gangguan (Library belum termuat). Silakan refresh.");
                        return;
                    }

                    snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '<?= base_url('orders/success') ?>/' + response.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '<?= base_url('orders/pending') ?>/' + response.order_id;
                        },
                        onError: function(result) {
                            console.error(result);
                            alert('Pembayaran gagal atau dibatalkan.');
                        },
                        onClose: function() {
                            alert('Anda menutup popup. Silakan selesaikan pembayaran lewat menu Riwayat Pesanan.');
                            // Optional: Redirect to orders list
                            // window.location.href = '<?= base_url('orders') ?>';
                        }
                    });
                } else {
                    alert('Gagal memproses pesanan: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error("Checkout Error:", xhr.responseText);
                alert('Terjadi kesalahan server: ' + error);
            },
            complete: function() {
                btn.disabled = false;
                btn.innerHTML = originalBtnText;
            }
        });
    }
</script>

<?= $this->endSection() ?>