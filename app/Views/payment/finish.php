<!DOCTYPE html>
     <html lang="id">
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>Pembayaran Selesai - Souvnela</title>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     </head>
     <body>
         <div class="container" style="margin-top: 100px; max-width: 600px;">
             <div class="card shadow-lg border-0 text-center">
                 <div class="card-body p-5">
                     <?php if ($transactionStatus == 'settlement' || $transactionStatus == 'capture'): ?>
                         <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                         <h2 class="fw-bold mb-3">Pembayaran Berhasil!</h2>
                         <p class="text-muted mb-4">Terima kasih telah berbelanja di Souvnela</p>
                     <?php else: ?>
                         <i class="fas fa-clock fa-5x text-warning mb-4"></i>
                         <h2 class="fw-bold mb-3">Pembayaran Pending</h2>
                         <p class="text-muted mb-4">Silakan selesaikan pembayaran Anda</p>
                     <?php endif; ?>

                     <div class="bg-light p-3 rounded mb-4">
                         <p class="mb-1"><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                         <p class="mb-0"><strong>Total:</strong> Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></p>
                     </div>

                     <a href="/orders/detail/<?= $order['id'] ?>" class="btn btn-primary btn-lg mb-2">
                         <i class="fas fa-receipt me-2"></i>Lihat Detail Pesanan
                     </a>
                     <a href="/produk" class="btn btn-outline-secondary btn-lg">
                         <i class="fas fa-shopping-bag me-2"></i>Belanja Lagi
                     </a>
                 </div>
             </div>
         </div>
     </body>
     </html>