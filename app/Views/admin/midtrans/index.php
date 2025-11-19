<?= $this->extend('admin/layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Midtrans Configuration</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="<?= base_url('admin/midtrans/update') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="serverKey">Server Key</label>
                                    <input type="text" class="form-control" id="serverKey" name="serverKey" value="<?= esc($serverKey) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="clientKey">Client Key</label>
                                    <input type="text" class="form-control" id="clientKey" name="clientKey" value="<?= esc($clientKey) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="isProduction">Environment</label>
                                    <select class="form-control" id="isProduction" name="isProduction">
                                        <option value="0" <?= !$isProduction ? 'selected' : '' ?>>Sandbox</option>
                                        <option value="1" <?= $isProduction ? 'selected' : '' ?>>Production</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>