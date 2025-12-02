<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= $order['kode'] ?? str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
            --text-dark: #212529;
            --text-muted: #6c757d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: var(--text-dark);
            line-height: 1.5;
            background-color: #f5f5f5;
            margin: 0;
            padding: 40px 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 40px;
            position: relative;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .brand-section {
            flex: 1;
        }

        .brand-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0 0 5px 0;
            letter-spacing: -0.5px;
        }

        .brand-info {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .invoice-title-section {
            text-align: right;
        }

        .invoice-title {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0 0 5px 0;
            letter-spacing: -1px;
            text-transform: uppercase;
            opacity: 0.1;
        }

        .invoice-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .status-paid {
            background-color: #d1e7dd;
            color: var(--success-color);
        }

        .status-unpaid {
            background-color: #f8d7da;
            color: var(--danger-color);
        }

        /* Invoice Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
            padding: 25px;
            background-color: var(--light-gray);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .detail-item h4 {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin: 0 0 5px 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .detail-item p {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        /* Addresses */
        .address-section {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
        }

        .address-col {
            flex: 1;
        }

        .address-col h3 {
            font-size: 13px;
            text-transform: uppercase;
            color: var(--primary-color);
            margin: 0 0 10px 0;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--light-gray);
            padding-bottom: 8px;
        }

        .address-content p {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #495057;
        }

        .address-content strong {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Table */
        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: var(--light-gray);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px;
            text-align: left;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .items-table th:first-child { border-top-left-radius: 6px; border-bottom-left-radius: 6px; border-left: 1px solid var(--border-color); }
        .items-table th:last-child { border-top-right-radius: 6px; border-bottom-right-radius: 6px; border-right: 1px solid var(--border-color); text-align: right; }
        .items-table th:nth-child(2) { text-align: center; }
        .items-table th:nth-child(3) { text-align: right; }

        .items-table td {
            padding: 15px;
            font-size: 14px;
            border-bottom: 1px solid var(--light-gray);
            color: var(--text-dark);
        }

        .items-table td:last-child { text-align: right; font-weight: 600; }
        .items-table td:nth-child(2) { text-align: center; color: var(--text-muted); }
        .items-table td:nth-child(3) { text-align: right; color: var(--text-muted); }

        /* Totals */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .totals-box {
            width: 300px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .total-row.final {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid var(--border-color);
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .discount-text { color: var(--danger-color); }

        /* Footer */
        .footer {
            text-align: center;
            border-top: 1px solid var(--border-color);
            padding-top: 30px;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Print Button */
        .print-btn-container {
            text-align: right;
            margin-bottom: 20px;
        }

        .btn-print {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        }

        .btn-print:hover {
            background-color: #0b5ed7;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body {
                background-color: white;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 40px;
                margin: 0;
                max-width: 100%;
                width: 100%;
                border-radius: 0;
                position: static; /* Remove relative positioning */
            }
            .print-btn-container {
                display: none !important;
            }
            .details-grid, .items-table th, .status-paid, .status-unpaid {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: var(--light-gray) !important; /* Force background */
            }
            /* Ensure links don't show URLs */
            a[href]:after {
                content: none !important;
            }
        }
    </style>
    <script>
        // Auto print fallback if button doesn't work
        function triggerPrint() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="invoice-container">
        <!-- Print Button -->
        <div class="print-btn-container">
            <button onclick="triggerPrint()" class="btn-print">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                </svg>
                Cetak Invoice
            </button>
        </div>

        <div class="header">
            <div class="brand-section">
                <?php if (!empty($store_logo)): ?>
                    <img src="<?= base_url('uploads/' . $store_logo) ?>" alt="Store Logo" class="brand-logo">
                <?php else: ?>
                    <img src="<?= base_url('assets/images/logobiru.png') ?>" alt="Store Logo" class="brand-logo">
                <?php endif; ?>
                
                <h1 class="brand-name"><?= esc($store_name ?? 'Souvnela') ?></h1>
                <p class="brand-info"><?= esc($store_address ?? 'Jl. Soekarno Hatta No.10, Rajabasa Raya, Bandar Lampung') ?></p>
                <p class="brand-info"><?= esc($store_phone ?? '(0721) 703995') ?></p>
                <?php if (!empty($store_website)): ?>
                    <p class="brand-info"><?= esc($store_website) ?></p>
                <?php endif; ?>
            </div>

            <div class="invoice-title-section">
                <div class="invoice-title">INVOICE</div>
                <?php
                    $paidStatuses = ['settlement', 'capture', 'paid'];
                    $isPaid = in_array($order['payment_status'], $paidStatuses);
                ?>
                <div class="invoice-status <?= $isPaid ? 'status-paid' : 'status-unpaid' ?>">
                    <?= $isPaid ? 'LUNAS' : strtoupper($order['payment_status']) ?>
                </div>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <h4>No. Referensi</h4>
                <p>#<?= $order['kode'] ?? str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></p>
            </div>
            <div class="detail-item">
                <h4>Tanggal Pemesanan</h4>
                <p><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
            </div>
            <div class="detail-item">
                <h4>Metode Pengiriman</h4>
                <p><?= !empty($order['shipping_method']) ? strtoupper($order['shipping_method']) : '-' ?></p>
            </div>
        </div>

        <div class="address-section">
            <div class="address-col">
                <h3>Ditagihkan Kepada</h3>
                <div class="address-content">
                    <p><strong><?= esc($order['nama_penerima']) ?></strong></p>
                    <p><?= esc($order['email']) ?></p>
                    <p><?= esc($order['no_telepon']) ?></p>
                </div>
            </div>
            <div class="address-col">
                <h3>Dikirim Ke</h3>
                <div class="address-content">
                    <p><strong><?= esc($order['nama_penerima']) ?></strong></p>
                    <p style="line-height: 1.6;"><?= esc($order['alamat_lengkap']) ?></p>
                    <?php if (!empty($order['tracking_number'])): ?>
                        <p style="margin-top: 8px;"><strong style="color: var(--primary-color);">No. Resi: <?= esc($order['tracking_number']) ?></strong></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Produk</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($order['items'])): ?>
                    <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td>
                            <strong style="color: var(--text-dark); display: block; margin-bottom: 4px;"><?= esc($item['nama_produk']) ?></strong>
                            <!-- <small style="color: var(--text-muted);">SKU: PROD-001</small> -->
                        </td>
                        <td><?= $item['jumlah'] ?></td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="totals-section">
            <div class="totals-box">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>Rp <?= number_format($order['total_harga'] - $order['ongkir'] + ($order['discount_amount'] ?? 0), 0, ',', '.') ?></span>
                </div>
                <div class="total-row">
                    <span>Biaya Pengiriman</span>
                    <span>Rp <?= number_format($order['ongkir'], 0, ',', '.') ?></span>
                </div>
                <?php if (!empty($order['discount_amount']) && $order['discount_amount'] > 0): ?>
                <div class="total-row discount-text">
                    <span>Voucher Diskon</span>
                    <span>- Rp <?= number_format($order['discount_amount'], 0, ',', '.') ?></span>
                </div>
                <?php endif; ?>
                <div class="total-row final">
                    <span>Total Pembayaran</span>
                    <span>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di <strong><?= esc($store_name ?? 'Souvnela') ?></strong>.</p>
            <p style="margin-top: 5px;">Jika Anda memiliki pertanyaan mengenai invoice ini, silakan hubungi kami.</p>
        </div>
    </div>
</body>
</html>
