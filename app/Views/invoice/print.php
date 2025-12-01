<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= $order['id'] ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .invoice-container {
            border: 1px solid #eee;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .company-info h2 {
            margin: 0;
            color: #333;
        }
        .company-info p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #666;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h1 {
            margin: 0;
            color: #0d6efd;
            text-transform: uppercase;
            font-size: 2em;
        }
        .invoice-meta {
            margin-top: 10px;
            font-size: 0.9em;
        }
        .billing-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .bill-to, .ship-to {
            width: 48%;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 0.85em;
            color: #888;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            width: 40%;
            margin-left: auto;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .totals-row.grand-total {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.85em;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            border: 1px solid #333;
        }
        .status-paid {
            color: #198754;
            border-color: #198754;
        }
        .status-unpaid {
            color: #dc3545;
            border-color: #dc3545;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .invoice-container {
                box-shadow: none;
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="no-print" style="margin-bottom: 20px; text-align: right;">
            <button onclick="window.print()" style="padding: 10px 20px; background-color: #0d6efd; color: white; border: none; border-radius: 5px; cursor: pointer;">Print Invoice</button>
        </div>

        <div class="invoice-header">
            <div class="company-info">
                <?php if (!empty($store_logo)): ?>
                    <img src="<?= base_url('uploads/' . $store_logo) ?>" alt="Store Logo" style="height: 50px; margin-bottom: 10px;">
                <?php else: ?>
                    <h2><?= esc($store_name ?? 'Souvnela') ?></h2>
                <?php endif; ?>
                <p><?= esc($store_address ?? 'Alamat Toko Belum Diatur') ?></p>
                <p>Telp: <?= esc($store_phone ?? '-') ?></p>
            </div>
            <div class="invoice-details">
                <h1>INVOICE</h1>
                <div class="invoice-meta">
                    <p><strong>No:</strong> #INV-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></p>
                    <p><strong>Tanggal:</strong> <?= date('d F Y', strtotime($order['created_at'])) ?></p>
                    <p>
                        <strong>Status Pembayaran:</strong> 
                        <span class="status-badge <?= ($order['payment_status'] == 'settlement' || $order['payment_status'] == 'capture') ? 'status-paid' : 'status-unpaid' ?>">
                            <?= strtoupper($order['payment_status'] == 'settlement' || $order['payment_status'] == 'capture' ? 'PAID' : $order['payment_status']) ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="billing-info">
            <div class="bill-to">
                <div class="section-title">Ditagihkan Kepada</div>
                <p><strong><?= esc($order['nama_penerima']) ?></strong></p>
                <p><?= esc($order['email']) ?></p>
                <p><?= esc($order['no_telepon']) ?></p>
            </div>
            <div class="ship-to">
                <div class="section-title">Dikirim Ke</div>
                <p><strong><?= esc($order['nama_penerima']) ?></strong></p>
                <p><?= esc($order['alamat_lengkap']) ?></p>
                <?php if (!empty($order['tracking_number'])): ?>
                    <p><strong>Resi:</strong> <?= esc($order['tracking_number']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($order['items'])): ?>
                    <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td><?= esc($item['nama_produk']) ?></td>
                        <td class="text-center"><?= $item['jumlah'] ?></td>
                        <td class="text-right">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td class="text-right">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>Rp <?= number_format($order['subtotal'], 0, ',', '.') ?></span>
            </div>
            <div class="totals-row">
                <span>Ongkos Kirim</span>
                <span>Rp <?= number_format($order['ongkir'], 0, ',', '.') ?></span>
            </div>
            <?php if (!empty($order['discount_amount']) && $order['discount_amount'] > 0): ?>
            <div class="totals-row" style="color: #dc3545;">
                <span>Diskon</span>
                <span>- Rp <?= number_format($order['discount_amount'], 0, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <div class="totals-row grand-total">
                <span>Grand Total</span>
                <span>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di <?= esc($store_name ?? 'Souvnela') ?>!</p>
            <?php if (!empty($store_website)): ?>
                <p><?= esc($store_website) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
