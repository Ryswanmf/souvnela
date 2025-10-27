<?= $this->extend('layouts/layout_admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <a href="<?= base_url('admin/testimonial/create') ?>" class="btn btn-primary">Tambah Testimoni</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Testimoni</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?= base_url('admin/testimonial') ?>" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari testimoni..." name="keyword" value="<?= esc($keyword ?? '') ?>">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Konten</th>
                            <th>Author</th>
                            <th>Jabatan Author</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $i => $testimonial): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($testimonial['content']) ?></td>
                                <td><?= esc($testimonial['author']) ?></td>
                                <td><?= esc($testimonial['author_title']) ?></td>
                                <td>
                                    <?php if (!empty($testimonial['photo'])): ?>
                                        <img src="<?= base_url('uploads/' . $testimonial['photo']) ?>" alt="Author Photo" class="img-thumbnail" width="50">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/testimonial/edit/' . $testimonial['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('admin/testimonial/delete/' . $testimonial['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $pager->links('testimonials', 'bootstrap_pagination') ?>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
