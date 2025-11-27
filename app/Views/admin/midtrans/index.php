<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Konfigurasi Midtrans</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/midtrans/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="server_key" class="form-label">Server Key</label>
                            <input type="text" class="form-control" id="server_key" name="server_key" value="<?= esc($config['server_key']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="client_key" class="form-label">Client Key</label>
                            <input type="text" class="form-control" id="client_key" name="client_key" value="<?= esc($config['client_key']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="merchant_id" class="form-label">Merchant ID</label>
                            <input type="text" class="form-control" id="merchant_id" name="merchant_id" value="<?= esc($config['merchant_id']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="is_production" class="form-label">Mode Produksi</label>
                            <select class="form-select" id="is_production" name="is_production">
                                <option value="0" <?= !$config['is_production'] ? 'selected' : '' ?>>Sandbox</option>
                                <option value="1" <?= $config['is_production'] ? 'selected' : '' ?>>Produksi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Konfigurasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $stats['success_count'] ?></h3>
                    <p>Transaksi Berhasil</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $stats['pending_count'] ?></h3>
                    <p>Transaksi Pending</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $stats['failed_count'] ?></h3>
                    <p>Transaksi Gagal</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Rp <?= number_format($stats['total_revenue'], 0, ',', '.') ?></h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi Terbaru</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Nama Pelanggan</th>
                                <th>Status</th>
                                <th>Jumlah</th>
                                <th>Waktu Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactions)) : ?>
                                <?php foreach ($transactions as $transaction) : ?>
                                    <tr>
                                        <td><?= esc($transaction['order_id']) ?></td>
                                        <td><?= esc($transaction['customer_name'] ?? $transaction['nama_penerima']) ?></td>
                                        <td><span class="badge bg-<?= $transaction['transaction_status'] == 'settlement' ? 'success' : ($transaction['transaction_status'] == 'pending' ? 'warning' : 'danger') ?>"><?= esc($transaction['transaction_status']) ?></span></td>
                                        <td>Rp <?= number_format($transaction['gross_amount'], 0, ',', '.') ?></td>
                                        <td><?= esc($transaction['transaction_time']) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/midtrans/detail/' . $transaction['id']) ?>" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada transaksi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
