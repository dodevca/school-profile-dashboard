<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Galeri</li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->has('success')): ?>
    <div class="alert-wrapper">
        <div class="alert alert-temporary text-white bg-success" role="alert">
            <div class="iq-alert-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="iq-alert-text"><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between breadcrumb-content">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between order-md-2 w-100 w-md-auto">
                        <?php include_once('partials/searchbar.php') ?>
                        <div class="dropdown status-dropdown pr-md-3 mt-3 mt-md-0 border-right btn-new order-md-1">
                            <div class="dropdown-toggle" id="dropdownMenuButton03" data-toggle="dropdown">
                                <div class="btn bg-body"><span class="h6">Urutkan :</span> <?= str_replace(' - ', '-', ucwords(str_replace('-', ' - ', $data['filter']))) ?><i class="bi bi-chevron-down ml-2 mr-0"></i></div>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton03">
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('galeri?query=' . $data['query'] . '&filter=a-z') : base_url('galeri?filter=a-z') ?>">A-Z</a>
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('galeri?query=' . $data['query'] . '&filter=z-a') : base_url('galeri?filter=z-a') ?>">Z-A</a>
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('galeri?query=' . $data['query'] . '&filter=terbaru') : base_url('galeri?filter=terbaru') ?>">Terbaru</a>
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('galeri?query=' . $data['query'] . '&filter=terlama') : base_url('galeri?filter=terlama') ?>">Terlama</a>
                            </div>
                        </div>
                    </div>
                    <div class="pr-md-3 mb-3 mb-md-0 order-2 order-md-1 w-100 w-md-auto">
                        <a href="<?= base_url('galeri/tambah') ?>" class="btn btn-primary w-100 w-md-auto"><i class="bi bi-plus mr-1"></i>Tambah Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-transparent mb-0">
            <div class="card-header d-flex align-items-center justify-content-between p-0 pb-3">
                <div class="header-title">
                    <h4 class="card-title">Daftar Album</h4>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <?php if($data['totalResults'] != 0): ?>
                        <?php forEach($data['results'] as $result): ?>
                            <div class="col-lg-12">
                                <div class="card card-widget task-card bg-white">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <a href="<?= base_url('galeri/' . $result['id']) ?>" class="btn d-flex align-items-center p-0">
                                                    <img src="<?= base_url('uploads/album/' . $result['headline']) ?>" class="card-img-cover rounded img-fluid mr-3" width="72px" height="72px" alt="Responsive image">
                                                    <div>
                                                        <h5 class="text-left mb-2"><?= $result['title'] ?></h5>
                                                        <div class="media align-items-center flex-wrap">
                                                            <div class="text-muted mr-3"><i class="bi bi-calendar mr-2"></i><?= $result['date'] ?></div>
                                                            <div class="text-muted"><i class="bi bi-images mr-2"></i><?= $result['totalImages'] + 1 ?></div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="media align-items-center ml-auto mt-md-0 mt-3">
                                                <a href="<?= base_url('galeri/' . $result['id'] . '?action=edit') ?>" class="btn bg-primary-light mr-2"><i class="bi bi-pen"></i>Edit</a>
                                                <a href="<?= base_url('galeri/' . $result['id'] . '/delete') ?>" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></a>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                   <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning w-100" role="alert">
                                <div class="iq-alert-text">Tidak ada album.</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?= $this->include('layouts/partials/pagination') ?>
    </div>
</div>
<?= $this->endSection() ?>