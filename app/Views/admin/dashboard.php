<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold">Selamat datang, Admin 👋</h4>
        <p class="text-muted">Lihat ringkasan toko Souvnela hari ini</p>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <?php
        $stats = $stats ?? ['sales'=>0,'products'=>0,'orders'=>0,'visitors'=>0,'lowstock'=>0];
        $cards = [
            ['title'=>'Total Penjualan','icon'=>'bi-cash-stack','value'=>'Rp '.number_format($stats['sales'],0,',','.'),'desc'=>'Pendapatan total'],
            ['title'=>'Produk Tersedia','icon'=>'bi-box-seam','value'=>$stats['products'],'desc'=>'Stok rendah: '.$stats['lowstock']],
            ['title'=>'Total Pesanan','icon'=>'bi-cart-check','value'=>$stats['orders'],'desc'=>'Pesanan aktif'],
            ['title'=>'Pengunjung Hari Ini','icon'=>'bi-people','value'=>$stats['visitors'],'desc'=>'Aktivitas harian'],
        ];
        foreach($cards as $c): ?>
        <div class="col-sm-6 col-lg-3">
            <div class="card p-4 text-center shadow-sm">
                <div class="display-6 text-primary mb-2"><i class="<?= $c['icon'] ?>"></i></div>
                <h6><?= $c['title'] ?></h6>
                <h4><?= $c['value'] ?></h4>
                <small class="text-muted"><?= $c['desc'] ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Grafik -->
    <div class="card p-4 mb-4 shadow-sm">
        <h6 class="fw-semibold mb-3"><i class="bi bi-graph-up me-2"></i>Grafik Penjualan Mingguan</h6>
        <div style="height: 300px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold m-0"><i class="bi bi-box2-fill me-2"></i>Daftar Produk</h6>
            <a href="<?= base_url('admin/produk/tambah') ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Produk
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products ?? [] as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($p['name']) ?></td>
                        <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td>
                            <?php if ($p['stock'] <= 0): ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php elseif ($p['stock'] < 5): ?>
                                <span class="badge bg-warning text-dark">Menipis</span>
                            <?php else: ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/produk/edit/'.$p['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <a href="<?= base_url('admin/produk/delete/'.$p['id']) ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart_labels ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min']) ?>,
        datasets: [{
            data: <?= json_encode($chart_sales ?? [120000,150000,90000,170000,140000,190000,220000]) ?>,
            borderColor: '#0056ff',
            backgroundColor: 'rgba(0,86,255,0.08)',
            fill: true,
            tension: 0.35,
            borderWidth: 2
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { color: '#6c757d' } },
            x: { ticks: { color: '#6c757d' } }
        }
    }
});
</script>

<?= $this->endSection() ?>
