<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12">
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

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Lokasi di Peta</label>
                            <div id="map" style="height: 400px; width: 100%;" class="bg-light border"></div>
                            <small class="form-text text-muted">Klik pada peta untuk menentukan lokasi, atau cari alamat di atas.</small>
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
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAPS_API_KEY') ?>&libraries=places&callback=initMap"></script>



<script>
    let map;
    let marker;
    const defaultPosition = { lat: -2.548926, lng: 118.0148634 }; // Center of Indonesia

    function initMap() {
        // Try to get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                createMap(userLocation, 15);
            }, function() {
                // Geolocation failed, use default
                createMap(defaultPosition, 5);
            });
        } else {
            // Browser doesn't support Geolocation, use default
            createMap(defaultPosition, 5);
        }
    }

    function createMap(center, zoom) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: center,
            zoom: zoom
        });

        marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: true,
            title: "Geser untuk menentukan lokasi"
        });

        // Autocomplete search box
        const input = document.createElement('input');
        input.setAttribute('id', 'pac-input');
        input.setAttribute('class', 'form-control');
        input.setAttribute('type', 'text');
        input.setAttribute('placeholder', 'Cari alamat...');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Alamat tidak ditemukan: '" + place.name + "'");
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            updateCoordinates(place.geometry.location.lat(), place.geometry.location.lng());
            
            let address = '';
            if (place.address_components) {
                address = [
                  (place.address_components[0] && place.address_components[0].short_name || ''),
                  (place.address_components[1] && place.address_components[1].short_name || ''),
                  (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            document.getElementById('alamat').value = place.name + ', ' + address;
        });

        // Map click listener
        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            updateCoordinates(e.latLng.lat(), e.latLng.lng());
        });

        // Marker drag listener
        marker.addListener('dragend', function(e) {
            updateCoordinates(e.latLng.lat(), e.latLng.lng());
        });

        updateCoordinates(center.lat, center.lng);
    }

    function updateCoordinates(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    }

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

        $.ajax({
            url: '<?= base_url('payment/check-voucher') ?>',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                voucher_code: voucherCode,
                subtotal: document.getElementById('subtotalValue').value
            },
            success: function(response) {
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
            error: function() {
                $('#voucherMessage').html('<div class="alert alert-danger">Terjadi kesalahan</div>');
            }
        });
    }

    function processCheckout() {
        const form = document.getElementById('checkoutForm');

        if (!form.checkValidity()) {
            alert("Form tidak valid. Harap periksa semua bidang yang wajib diisi (ditandai dengan *).");
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);
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
                    // Open Midtrans Snap
                    snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '<?= base_url('orders/success') ?>/' + response.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '<?= base_url('orders/pending') ?>/' + response.order_id;
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal!');
                        },
                        onClose: function() {
                            alert('Anda menutup popup pembayaran');
                        }
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat memproses pesanan');
            }
        });
    }
</script>

<?= $this->endSection() ?>

