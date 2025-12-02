<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><?= $title ?></h4>
        <a href="<?= base_url('admin/voucher') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="<?= base_url('admin/voucher/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Voucher</label>
                        <input type="text" name="code" class="form-control text-uppercase" required placeholder="CONTOH: MERDEKA2025" value="<?= old('code') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <input type="text" name="description" class="form-control" placeholder="Keterangan voucher" value="<?= old('description') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tipe Diskon</label>
                        <select name="discount_type" class="form-select" required id="discountType">
                            <option value="percentage" <?= old('discount_type') === 'percentage' ? 'selected' : '' ?>>Persentase (%)</option>
                            <option value="fixed" <?= old('discount_type') === 'fixed' ? 'selected' : '' ?>>Nominal Tetap (Rp)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nilai Diskon</label>
                        <input type="number" name="discount_value" class="form-control" required value="<?= old('discount_value') ?>">
                        <small class="text-muted">Masukkan angka saja (contoh: 10 untuk 10%, atau 50000 untuk Rp 50.000)</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Maksimal Diskon (Opsional)</label>
                        <input type="number" name="max_discount" class="form-control" value="<?= old('max_discount') ?>">
                        <small class="text-muted">Hanya berlaku untuk tipe Persentase. Kosongkan jika tidak ada limit.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Minimal Belanja (Opsional)</label>
                        <input type="number" name="min_purchase" class="form-control" value="<?= old('min_purchase') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Batas Penggunaan (Opsional)</label>
                        <input type="number" name="usage_limit" class="form-control" value="<?= old('usage_limit') ?>">
                        <small class="text-muted">Kosongkan jika tidak terbatas.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Berlaku Dari</label>
                        <input type="date" name="valid_from" class="form-control" required value="<?= old('valid_from') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Berlaku Sampai</label>
                        <input type="date" name="valid_until" class="form-control" required value="<?= old('valid_until') ?>">
                    </div>
                </div>

                <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary px-4">Simpan Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('discountType').addEventListener('change', function() {
        const maxDiscountInput = document.querySelector('input[name="max_discount"]');
        if (this.value === 'fixed') {
            maxDiscountInput.disabled = true;
            maxDiscountInput.value = '';
        } else {
            maxDiscountInput.disabled = false;
        }
    });
</script>

<?= $this->endSection() ?>
