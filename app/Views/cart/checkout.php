<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <h1 class="text-center mb-4">
                <i class="bi bi-bag-check-fill text-primary me-2"></i>
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
                        <i class="bi bi-truck me-2"></i>Informasi Pengiriman
                    </h5>
                </div>
                <div class="card-body">
                    <form id="checkoutForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap *</label>
                                <input type="text" class="form-control" name="nama_penerima" required value="<?= session()->get('nama') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Telepon *</label>
                                <input type="tel" class="form-control" name="telepon" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" class="form-control" name="email" required value="<?= session()->get('email') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap *</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3" required placeholder="Masukkan alamat lengkap pengiriman"></textarea>
                        </div>

                        <input type="hidden" name="latitude" id="latitude" value="">
                        <input type="hidden" name="longitude" id="longitude" value="">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kota *</label>
                                <input type="text" class="form-control" name="kota" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kode Pos *</label>
                                <input type="text" class="form-control" name="kode_pos" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="2" placeholder="Catatan untuk penjual"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Metode Pengiriman *</label>
                            <select class="form-select" name="shipping_method" id="shippingMethod" required>
                                <option value="">Pilih Metode Pengiriman</option>
                                <option value="reguler" data-cost="10000">Reguler (3-5 hari) - Rp 10.000</option>
                                <option value="express" data-cost="25000">Express (1-2 hari) - Rp 25.000</option>
                                <option value="same_day" data-cost="50000">Same Day - Rp 50.000</option>
                            </select>
                        </div>

                        <!-- Voucher -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-ticket-perforated me-1"></i>Kode Voucher
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="voucherCode" placeholder="Masukkan kode voucher">
                                <button type="button" class="btn btn-outline-primary" onclick="applyVoucher()">Pakai</button>
                            </div>
                            <div id="voucherMessage" class="mt-2"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($cart_items)): ?>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <?php
                                $imagePath = FCPATH . 'uploads/' . $item['gambar'];
                                $imageSrc = (!empty($item['gambar']) && file_exists($imagePath)) ? '/uploads/' . $item['gambar'] : '/assets/images/default-product.png';
                                ?>
                                <img src="<?= $imageSrc ?>" alt="<?= $item['nama_produk'] ?>" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold"><?= $item['nama_produk'] ?></h6>
                                    <small class="text-muted">Qty: <?= $item['jumlah'] ?> × Rp <?= number_format($item['harga'], 0, ',', '.') ?></small>
                                </div>
                                <div class="text-end">
                                    <strong class="text-primary">Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Total Bayar</h5>
                            <h5 class="mb-0 text-primary" id="grandTotal">Rp <?= number_format($total, 0, ',', '.') ?></h5>
                        </div>
                    </div>

                    <input type="hidden" id="subtotalValue" value="<?= $total ?>">
                    <input type="hidden" id="shippingValue" value="0">
                    <input type="hidden" id="discountValue" value="0">
                    <input type="hidden" id="voucherId" value="">

                    <button type="button" class="btn btn-primary w-100 mt-3 py-3 fw-semibold" onclick="processCheckout()">
                        <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                    </button>

                    <div class="text-center mt-3 pt-3 border-top">
                        <img src="/public/assets/images/midtrans-logo.png" alt="Midtrans" style="height: 30px;">
                        <p class="text-muted small mt-2 mb-0">Pembayaran aman dengan Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php 
    // Use key passed from controller, fallback to env helper if not set
    $clientKey = $midtransClientKey ?? env('MIDTRANS_CLIENT_KEY'); 
?>
<?php if (empty($clientKey)): ?>
    <script>console.error("MIDTRANS_CLIENT_KEY is missing! Check .env file and restart server.");</script>
    <div class="alert alert-danger text-center my-3">
        <strong>Konfigurasi Error:</strong> Client Key Midtrans belum diset. Pembayaran tidak dapat dilakukan.
    </div>
<?php else: ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= esc($clientKey) ?>"></script>
<?php endif; ?>


    // Update shipping cost
    document.getElementById('shippingMethod').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const shippingCost = parseInt(selectedOption.dataset.cost) || 0;

        document.getElementById('shippingValue').value = shippingCost;
        document.getElementById('shippingCost').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');

        calculateTotal();
    });

    function calculateTotal() {
        const subtotal = parseInt(document.getElementById('subtotalValue').value);
        const shipping = parseInt(document.getElementById('shippingValue').value);
        const discount = parseInt(document.getElementById('discountValue').value);

        const grandTotal = subtotal + shipping - discount;
        document.getElementById('grandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    function applyVoucher() {
        const voucherCode = document.getElementById('voucherCode').value.trim();

        if (!voucherCode) {
            alert('Masukkan kode voucher');
            return;
        }

        // Try to get fresh CSRF token if available in form, otherwise use rendered one
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';
        const formInput = document.querySelector('input[name="' + csrfName + '"]');
        if (formInput) {
            csrfHash = formInput.value;
        }

        $.ajax({
            url: '<?= base_url('payment/check-voucher') ?>',
            type: 'POST',
            data: {
                [csrfName]: csrfHash,
                voucher_code: voucherCode,
                subtotal: document.getElementById('subtotalValue').value
            },
            success: function(response) {
                // Update CSRF hash if provided in response (good practice)
                if (response.token) {
                    if (formInput) formInput.value = response.token;
                    csrfHash = response.token;
                }

                if (response.success) {
                    document.getElementById('voucherId').value = response.voucher_id;
                    document.getElementById('discountValue').value = response.discount;
                    document.getElementById('discountAmount').textContent = '- Rp ' + response.discount.toLocaleString('id-ID');
                    document.getElementById('discountRow').style.display = 'flex';

                    $('#voucherMessage').html('<div class="alert alert-success">Voucher berhasil diterapkan!</div>');
                    calculateTotal();
                } else {
                    $('#voucherMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Voucher Error:", xhr.responseText);
                let msg = 'Terjadi kesalahan saat mengecek voucher.';
                if (xhr.status === 403) {
                    msg = 'Sesi atau Token Keamanan kadaluarsa. Silakan refresh halaman.';
                }
                $('#voucherMessage').html('<div class="alert alert-danger">' + msg + '</div>');
            }
        });
    }

    function processCheckout() {
        const form = document.getElementById('checkoutForm');
        const btn = document.querySelector('button[onclick="processCheckout()"]');

        if (!form.checkValidity()) {
            alert("Form tidak valid. Harap periksa semua bidang yang wajib diisi (ditandai dengan *).");
            form.reportValidity();
            return;
        }

        // Disable button to prevent double submit
        const originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

        const formData = new FormData(form);
        // Use dynamic CSRF token if available, fallback to rendered one
        // It is recommended to have <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>"> in head
        // But here we stick to what is available or standard CI4 behavior
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>'); 
        
        formData.append('total', document.getElementById('grandTotal').textContent.replace(/[^0-9]/g, ''));
        formData.append('voucher_id', document.getElementById('voucherId').value);
        formData.append('shipping_cost', document.getElementById('shippingValue').value);
        formData.append('discount_amount', document.getElementById('discountValue').value);

        $.ajax({
            url: '<?= base_url('payment/process') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Check if Snap is loaded
                    if (typeof snap === 'undefined') {
                        alert("Error: Library Pembayaran (Midtrans) gagal dimuat. Kemungkinan Client Key belum dikonfigurasi di server.");
                        console.error("Midtrans Snap JS not found. Check your internet connection or MIDTRANS_CLIENT_KEY configuration.");
                        return;
                    }

                    // Open Midtrans Snap
                    snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '<?= base_url('orders/success') ?>/' + response.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '<?= base_url('orders/pending') ?>/' + response.order_id;
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal! Silakan coba lagi.');
                            console.error(result);
                        },
                        onClose: function() {
                            alert('Anda menutup popup pembayaran. Silakan selesaikan pembayaran melalui riwayat pesanan.');
                        }
                    });
                } else {
                    alert('Gagal: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log(xhr.responseText);
                alert('Terjadi kesalahan sistem saat memproses pesanan. Coba refresh halaman.');
            },
            complete: function() {
                // Re-enable button
                btn.disabled = false;
                btn.innerHTML = originalBtnText;
            }
        });
    }
</script>

<?= $this->endSection() ?>

