<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section id="profile" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-4"><?= $title ?></h2>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <?= form_open_multipart('profile/update') ?>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= esc($user['id']) ?>">

                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="<?= $user['foto_profil'] ? base_url('uploads/' . $user['foto_profil']) : base_url('assets/images/default-avatar.png') ?>" 
                                         alt="Foto Profil" 
                                         class="img-fluid rounded-circle mb-3" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                    <div class="mb-3">
                                        <label for="foto_profil" class="form-label">Ubah Foto Profil</label>
                                        <input class="form-control" type="file" id="foto_profil" name="foto_profil">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap', esc($user['nama_lengkap'])) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']) ?>" readonly>
                                    </div>
                                                                         <div class="mb-3">
                                                                            <label for="email" class="form-label">Email</label>
                                                                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', esc($user['email'])) ?>">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                                                            <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= old('nomor_telepon', esc($user['nomor_telepon'])) ?>">
                                                                        </div>
                                                                         <div class="mb-3">
                                                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                                                                <option value="">Pilih...</option>
                                                                                <option value="Laki-laki" <?= old('jenis_kelamin', $user['jenis_kelamin']) == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                                                                <option value="Perempuan" <?= old('jenis_kelamin', $user['jenis_kelamin']) == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', esc($user['tanggal_lahir'])) ?>">
                                                                        </div>                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= old('alamat', esc($user['alamat'])) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
