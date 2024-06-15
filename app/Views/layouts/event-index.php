<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Agenda</li>
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
                                <div class="btn bg-body"><span class="h6">Urutkan :</span> <?= ucwords(str_replace('-', ' ', $data['filter'])) ?><i class="bi bi-chevron-down ml-2 mr-0"></i></div>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton03">
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('agenda?query=' . $data['query'] . '&filter=mendatang') : base_url('agenda?filter=mendatang') ?>">Mendatang</a>
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('agenda?query=' . $data['query'] . '&filter=terbaru') : base_url('agenda?filter=terbaru') ?>">Terbaru</a>
                                <a class="dropdown-item" href="<?= !empty($data['query']) ? base_url('agenda?query=' . $data['query'] . '&filter=terlama') : base_url('agenda?filter=terlama') ?>">Terlama</a>
                            </div>
                        </div>
                    </div>
                    <div class="pr-md-3 mb-3 mb-md-0 order-2 order-md-1 w-100 w-md-auto">
                        <a href="<?= base_url('agenda/tambah') ?>" class="btn btn-primary w-100 w-md-auto"><i class="bi bi-plus mr-1"></i>Tambah Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-transparent mb-0">
            <div class="card-header d-flex align-items-center justify-content-between p-0 pb-3">
                <div class="header-title">
                    <h4 class="card-title">Agenda Sekolah</h4>
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
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#modal<?= $result['id'] ?>">
                                                    <h5 class="text-left mb-2"><?= $result['name'] ?></h5>
                                                    <div class="bg-info-light px-2 py-1 rounded mb-2">
                                                        <p class="mb-0"><?= $result['dateStart'] ?> - <?= $result['dateEnd'] ?></p>
                                                    </div>
                                                    <div class="media align-items-center flex-wrap">
                                                        <div class="text-muted mr-3"><i class="bi bi-calendar mr-2"></i><?= $result['date'] ?></div>
                                                        <div class="text-muted"><i class="bi bi-eye mr-2"></i><?= $result['views'] ?></div>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="media align-items-center ml-auto mt-md-0 mt-3">
                                                <a href="<?= base_url('agenda/' . $result['id']) ?>" class="btn bg-primary-light mr-2"><i class="bi bi-pen"></i>Edit</a>
                                                <a href="<?= base_url('agenda/' . $result['id']) . '/delete' ?>" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></a>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="modal fade" id="modal<?= $result['id'] ?>" tabindex="-1" aria-labelledby="<?= $result['id'] ?>Title" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header justify-content-center">
                                                    <h5 class="modal-title" id="<?= $result['id'] ?>Title"><?= $result['name'] ?></h5>
                                                </div>
                                                <div class="modal-body">
                                                    <table>
                                                        <tr>
                                                            <td class="font-weight-bold">Dimulai</td>
                                                            <td class="px-2">:</td>
                                                            <td><?= $result['dateStart'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold">Berakhir</td>
                                                            <td class="px-2">:</td>
                                                            <td><?= $result['dateEnd'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold">Deskripsi</td>
                                                            <td class="px-2">:</td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                    <p class="pl-3"><?= $result['description'] ?></p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <a href="<?= base_url('agenda/' . $result['id']) ?>" type="button" class="btn bg-primary-light">Edit</a>
                                                    <button type="button" class="btn bg-secondary-light" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                   <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning w-100" role="alert">
                                <div class="iq-alert-text">Tidak ada agenda.</div>
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