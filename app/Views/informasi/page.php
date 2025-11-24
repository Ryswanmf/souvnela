<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h1 class="fw-bold mb-4"><?= esc($title) ?></h1>
                        <hr class="mb-4">
                        <div>
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
