<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="cart" class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Keranjang Belanja</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-5">
                <i class="bi bi-cart-x" style="font-size: 4rem;"></i>
                <h4 class="mt-3">Keranjang Anda kosong</h4>
                <p class="text-muted">Silakan tambahkan produk ke keranjang terlebih dahulu.</p>
                <a href="<?= base_url('/produk') ?>" class="btn btn-primary">Lihat Produk</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th colspan="2">Produk</th>
                            <th>Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <?php $qty = $item['quantity'] ?? $item['jumlah'] ?? 1; ?>
                            <tr>
                                <td style="width: 100px;">
                                    <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" class="img-fluid rounded">
                                </td>
                                <td><?= esc($item['nama']) ?></td>
                                <td><?= number_to_currency($item['harga'], 'IDR') ?></td>
                                <td style="width: 150px;">
                                    <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $qty ?>" class="form-control form-control-sm" min="1" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="text-end"><?= number_to_currency($item['harga'] * $qty, 'IDR') ?></td>
                                <td class="text-end">
                                    <a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4 justify-content-end">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Belanja</h5>
                            <h3 class="fw-bold"><?= number_to_currency($total, 'IDR') ?></h3>
                            <hr>
                            <a href="<?= base_url('cart/checkout') ?>" class="btn btn-primary w-100">Lanjut ke Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
