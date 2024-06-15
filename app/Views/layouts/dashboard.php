<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card dashboard-hero" style="background-image: url('<?= base_url('template/images/page-img/01.jpg') ?>');">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <h2 class="my-5">Selamat datang, <?= $data['admin'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between p-0 pb-3">
            <div class="header-title">
                <h4 class="mb-0">Ringkasan</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <a href="<?= base_url('berita') ?>">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Blog</h5>
                        <span class="badge badge-success">Diunggah</span>
                    </div>
                    <h2 class="counter"><?= $data['news'] ?></h2>
                    <div class="d-flex  align-items-center justify-content-between mt-1">
                        <p class="text-muted mb-0">Berita</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <a href="<?= base_url('agenda') ?>">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Agenda</h5>
                        <span class="badge badge-success">Diunggah</span>
                    </div>
                    <h2 class="counter"><?= $data['event'] ?></h2>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="text-muted mb-0">Agenda</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <a href="<?= base_url('pengumuman') ?>">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Pengumuman</h5>
                        <span class="badge badge-success">Diunggah</span>
                    </div>
                    <h2 class="counter"><?= $data['announcement'] ?></h2>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="text-muted mb-0">Pengumuman</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <a href="<?= base_url('modul') ?>">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Modul</h5>
                        <span class="badge badge-success">Diunggah</span>
                    </div>
                    <h2 class="counter"><?= $data['modul'] ?></h2>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="text-muted mb-0">Unduhan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-transparent mb-0">
            <div class="card-header d-flex align-items-center justify-content-between p-0 pb-3">
                <div class="header-title">
                    <h4 class="card-title">Pintasan</h4>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <a href="<?= base_url('berita/tambah') ?>">
                                    <div class="d-flex align-items-center justify-content-start mb-4">
                                        <i class="bi bi-newspaper  text-secondary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="mb-1">Buat Berita</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <a href="<?= base_url('pengumuman/tambah') ?>">
                                    <div class="d-flex align-items-center justify-content-start mb-4">
                                        <i class="bi bi-megaphone-fill text-secondary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="mb-1">Buat Pengumuman</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <a href="<?= base_url('agenda/tambah') ?>">
                                    <div class="d-flex align-items-center justify-content-start mb-4">
                                        <i class="bi bi-calendar-plus-fill text-secondary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="mb-1">Tambah Agenda</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <a href="<?= base_url('galeri/tambah') ?>">
                                    <div class="d-flex align-items-center justify-content-start mb-4">
                                        <i class="bi bi-image-fill text-secondary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="mb-1">Galeri Baru</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <a href="<?= base_url('modul/tambah') ?>">
                                    <div class="d-flex align-items-center justify-content-start mb-4">
                                        <i class="bi bi-book-fill text-secondary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="mb-1">Tambah Modul</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <a href="<?= base_url('prestasi/tambah') ?>">
                                    <div class="d-flex align-items-center justify-content-start mb-4">
                                        <i class="bi bi-trophy-fill text-secondary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="mb-1">Tambah Prestasi</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>