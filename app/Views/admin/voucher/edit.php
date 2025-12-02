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
            <form action="<?= base_url('admin/voucher/update/' . $voucher['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Voucher</label>
                        <input type="text" name="code" class="form-control text-uppercase" required value="<?= old('code', $voucher['code']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <input type="text" name="description" class="form-control" value="<?= old('description', $voucher['description']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tipe Diskon</label>
                        <select name="discount_type" class="form-select" required id="discountType">
                            <option value="percentage" <?= old('discount_type', $voucher['discount_type']) === 'percentage' ? 'selected' : '' ?>>Persentase (%)</option>
                            <option value="fixed" <?= old('discount_type', $voucher['discount_type']) === 'fixed' ? 'selected' : '' ?>>Nominal Tetap (Rp)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nilai Diskon</label>
                        <input type="number" name="discount_value" class="form-control" required value="<?= old('discount_value', $voucher['discount_value']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Maksimal Diskon (Opsional)</label>
                        <input type="number" name="max_discount" class="form-control" value="<?= old('max_discount', $voucher['max_discount']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Minimal Belanja (Opsional)</label>
                        <input type="number" name="min_purchase" class="form-control" value="<?= old('min_purchase', $voucher['min_purchase']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Batas Penggunaan (Opsional)</label>
                        <input type="number" name="usage_limit" class="form-control" value="<?= old('usage_limit', $voucher['usage_limit']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" <?= old('is_active', $voucher['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="isActive">Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Berlaku Dari</label>
                        <input type="date" name="valid_from" class="form-control" required value="<?= old('valid_from', date('Y-m-d', strtotime($voucher['valid_from']))) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Berlaku Sampai</label>
                        <input type="date" name="valid_until" class="form-control" required value="<?= old('valid_until', date('Y-m-d', strtotime($voucher['valid_until']))) ?>">
                    </div>
                </div>

                <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary px-4">Update Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const discountType = document.getElementById('discountType');
    const maxDiscountInput = document.querySelector('input[name="max_discount"]');

    function toggleMaxDiscount() {
        if (discountType.value === 'fixed') {
            maxDiscountInput.disabled = true;
            maxDiscountInput.value = '';
        } else {
            maxDiscountInput.disabled = false;
        }
    }

    discountType.addEventListener('change', toggleMaxDiscount);
    toggleMaxDiscount(); // Run on load
</script>

<?= $this->endSection() ?>
