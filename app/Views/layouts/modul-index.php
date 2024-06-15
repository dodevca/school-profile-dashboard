<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Modul</li>
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
                <div class="d-flex flex-column flex-md-row align-items-center breadcrumb-content mb-3">
                    <div class="mb-3 mb-md-0 order-2 w-100 w-md-auto">
                        <a href="<?= base_url('modul/tambah') ?>" class="btn btn-primary w-100 w-md-auto"><i class="bi bi-plus mr-1"></i>Tambah Modul</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table data-table table-striped">
                        <thead>
                            <tr class="ligth">
                                <th>Judul</th>
                                <th>Jurusan</th>
                                <th>Penulis</th>
                                <th>Pengajar</th>
                                <th>Tanggal</th>
                                <th class="text-right no-sorting">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php forEach($data['results'] as $result): ?>
                                <tr>
                                    <td><?= $result['title'] ?></td>
                                    <td><?= $result['major'] ?></td>
                                    <td><?= $result['writer'] ?></td>
                                    <td><?= $result['teacher'] ?></td>
                                    <td><?= $result['date'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <a href="<?= base_url('uploads/modul/' . $result['modul']) ?>" class="btn bg-primary mr-2"><i class="bi bi-eye"></i>Lihat</a>
                                            <a href="<?= base_url('modul/' . $result['id']) ?>" class="btn bg-primary-light mr-2"><i class="bi bi-pen m-0"></i></a>
                                            <a href="<?= base_url('modul/' . $result['id']) . '/delete' ?>" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Judul</th>
                                <th>Jurusan</th>
                                <th>Penulis</th>
                                <th>Pengajar</th>
                                <th>Tanggal</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>