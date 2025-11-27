<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-shopping-cart"></i> Kelola Pesanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pesanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Status Filter -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= base_url('admin/pesanan') ?>" 
                           class="btn btn-outline-primary <?= !isset($_GET['status']) ? 'active' : '' ?>">
                            Semua
                        </a>
                        <a href="<?= base_url('admin/pesanan?status=pending') ?>" 
                           class="btn btn-outline-warning <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'active' : '' ?>">
                            Pending
                        </a>
                        <a href="<?= base_url('admin/pesanan?status=processing') ?>" 
                           class="btn btn-outline-info <?= isset($_GET['status']) && $_GET['status'] == 'processing' ? 'active' : '' ?>">
                            Processing
                        </a>
                        <a href="<?= base_url('admin/pesanan?status=shipped') ?>" 
                           class="btn btn-outline-primary <?= isset($_GET['status']) && $_GET['status'] == 'shipped' ? 'active' : '' ?>">
                            Shipped
                        </a>
                        <a href="<?= base_url('admin/pesanan?status=delivered') ?>" 
                           class="btn btn-outline-success <?= isset($_GET['status']) && $_GET['status'] == 'delivered' ? 'active' : '' ?>">
                            Delivered
                        </a>
                        <a href="<?= base_url('admin/pesanan?status=cancelled') ?>" 
                           class="btn btn-outline-danger <?= isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'active' : '' ?>">
                            Cancelled
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pesanan</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?= $order['id'] ?></td>
                                        <td>
                                            <strong><?= esc($order['nama_penerima']) ?></strong><br>
                                            <small class="text-muted"><?= esc($order['email']) ?></small>
                                        </td>
                                        <td>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php 
                                            $pesananModel = new \App\Models\PesananModel();
                                            $statusLabel = $pesananModel->getStatusLabel($order['status']);
                                            $badgeClass = '';
                                            switch ($order['status']) {
                                                case 'pending': $badgeClass = 'warning'; break;
                                                case 'processing': $badgeClass = 'info'; break;
                                                case 'shipped': $badgeClass = 'primary'; break;
                                                case 'delivered': $badgeClass = 'success'; break;
                                                case 'cancelled': $badgeClass = 'danger'; break;
                                            }
                                            ?>
                                            <span class="badge badge-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                        </td>
                                        <td><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary" 
                                                    data-toggle="modal" 
                                                    data-target="#updateStatusModal<?= $order['id'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Update Status Modal -->
                                    <div class="modal fade" id="updateStatusModal<?= $order['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="<?= base_url('admin/pesanan/updateStatus/' . $order['id']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Status Order #<?= $order['id'] ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Status Baru</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                                                <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                                                <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                                                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nomor Resi (Opsional)</label>
                                                            <input type="text" 
                                                                   name="tracking_number" 
                                                                   class="form-control" 
                                                                   value="<?= esc($order['tracking_number'] ?? '') ?>"
                                                                   placeholder="Masukkan nomor resi">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Catatan</label>
                                                            <textarea name="notes" 
                                                                      class="form-control" 
                                                                      rows="3" 
                                                                      placeholder="Catatan untuk pelanggan (opsional)"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada pesanan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
