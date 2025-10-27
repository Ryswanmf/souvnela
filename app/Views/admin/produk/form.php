<?= $this->extend('layouts/layout_admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold"><?= $title ?></h4>
        <p class="text-muted">Isi detail produk dengan lengkap</p>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <p class="fw-bold">Gagal menyimpan, mohon periksa isian Anda:</p>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <?php if (isset($produk['id'])): ?>
                <input type="hidden" name="_method" value="POST"> <!-- Method spoofing for update -->
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= old('nama', $produk['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?= old('deskripsi', $produk['deskripsi'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar" id="gambar" class="form-control">
                        <?php if (isset($produk['gambar']) && $produk['gambar']): ?>
                            <div class="mt-2">
                                <small>Gambar saat ini:</small>
                                <img src="<?= base_url('uploads/' . $produk['gambar']) ?>" width="100" class="rounded">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control" value="<?= old('harga', $produk['harga'] ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" value="<?= old('stok', $produk['stok'] ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kaos" <?= (old('kategori', $produk['kategori'] ?? '') == 'Kaos') ? 'selected' : '' ?>>Kaos</option>
                        <option value="Mug" <?= (old('kategori', $produk['kategori'] ?? '') == 'Mug') ? 'selected' : '' ?>>Mug</option>
                        <option value="Tumbler" <?= (old('kategori', $produk['kategori'] ?? '') == 'Tumbler') ? 'selected' : '' ?>>Tumbler</other>
                        <option value="Lainnya" <?= (old('kategori', $produk['kategori'] ?? '') == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
                <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
