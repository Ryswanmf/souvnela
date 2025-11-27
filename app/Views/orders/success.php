<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Souvnela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            padding-top: 80px;
            padding-bottom: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            padding: 50px 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        .success-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            animation: scaleIn 0.5s ease-out;
        }
        .success-icon i {
            font-size: 60px;
            color: white;
        }
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        .order-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 40px;
            border-radius: 25px;
            font-weight: 600;
            margin: 5px;
        }
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            padding: 12px 40px;
            border-radius: 25px;
            font-weight: 600;
            margin: 5px;
        }
    </style>
</head>
<body>
    <?= $this->include('layout/header') ?>

    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h2 class="mb-3">Pembayaran Berhasil!</h2>
            <p class="text-muted mb-4">Terima kasih atas pesanan Anda. Pembayaran telah berhasil diproses.</p>
            
            <div class="order-info">
                <div class="row">
                    <div class="col-6 text-start">
                        <small class="text-muted">No. Pesanan</small>
                        <h5 class="mb-0">#<?= $order['id'] ?></h5>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted">Total Bayar</small>
                        <h5 class="mb-0 text-success">Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></h5>
                    </div>
                </div>
            </div>

            <p class="mb-4">
                <i class="fas fa-info-circle text-primary"></i> 
                Pesanan Anda akan segera diproses. Anda dapat melacak status pesanan di halaman Pesanan Saya.
            </p>

            <div class="mt-4">
                <a href="<?= base_url('orders/detail/' . $order['id']) ?>" class="btn btn-primary">
                    <i class="fas fa-receipt"></i> Lihat Detail Pesanan
                </a>
                <a href="<?= base_url('orders') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-list"></i> Pesanan Saya
                </a>
            </div>

            <div class="mt-4">
                <a href="<?= base_url('produk') ?>" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
            </div>
        </div>
    </div>

    <?= $this->include('layout/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
