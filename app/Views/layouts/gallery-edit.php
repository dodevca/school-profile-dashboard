<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('galeri') ?>">Galeri</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page"><?= $data['result']['title'] ?></li>
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
                    <h5 class="mb-2 mb-md-0"><?= $data['result']['title'] ?></h5>
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between order-md-2 w-100 w-md-auto">
                        <?php if($action == 'edit'): ?>
                            <a href="<?= base_url('galeri/' . $data['result']['id'] . '?action=preview') ?>" class="btn btn-secondary w-100 w-md-auto mr-md-2 mb-2 mb-md-0"><i class="bi bi-eye mr-1"></i>Preview</a>
                        <?php else: ?>
                            <a href="<?= base_url('galeri/' . $data['result']['id'] . '?action=edit') ?>" class="btn btn-secondary w-100 w-md-auto mr-md-2 mb-2 mb-md-0"><i class="bi bi-pen mr-1"></i>Edit</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($action == 'edit'): ?>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    <h4 class="card-title">Edit <?= $data['result']['title'] ?></h4>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-warning my-3" role="alert">
                            <div class="iq-alert-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <ul class="iq-alert-text mb-0 pl-3">
                                <?php foreach(session('errors') as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?= form_open_multipart('/galeri/update') ?>
                        <?= csrf_field() ?>
                        <div class="form-group d-none">
                            <label for="title">id</label>
                            <input type="text" class="form-control" id="album-id" name="album-id" value="<?= $data['result']['id'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $data['result']['title'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="10" required><?= $data['result']['description'] ?></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="headline">Daftar Gambar</label>
                                <div class="card card-widget task-card bg-white">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <img src="<?= base_url('uploads/album/' . $data['result']['headline']) ?>" class="card-img-cover rounded img-fluid mr-3" alt="Responsive image">
                                                    <div class="media w-100">
                                                        <div class="custom-control custom-radio custom-radio-color-checked custom-control-inline bg-body pr-3 py-2 pl-5 rounded mt-2">
                                                            <input type="radio" class="custom-control-input bg-info" id="radio<?= preg_replace("/[^a-z0-9.]+/i", '', explode('.', $data['result']['headline'])[0]) ?>" name="headline" value="<?= $data['result']['headline'] ?>" checked>
                                                            <label class="custom-control-label" for="radio<?= preg_replace("/[^a-z0-9.]+/i", '', explode('.', $data['result']['headline'])[0]) ?>">Atur sebagai headline</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="media align-items-center mt-md-0 mt-3">
                                                <button type="button" class="btn bg-secondary-light" disabled><i class="bi bi-trash m-0"></i></button>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <?php foreach($data['result']['images'] as $result): ?>
                                    <div class="card card-widget task-card bg-white">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <img src="<?= base_url('uploads/album/' . $result) ?>" class="card-img-cover rounded img-fluid mr-3" alt="Responsive image">
                                                        <div class="media w-100">
                                                            <div class="custom-control custom-radio custom-radio-color-checked custom-control-inline bg-body pr-3 py-2 pl-5 rounded mt-2">
                                                                <input type="radio" class="custom-control-input bg-info" id="radio<?= preg_replace("/[^a-z0-9.]+/i", '', explode('.', $result)[0]) ?>" name="headline" value="<?= $result ?>">
                                                                <label class="custom-control-label" for="radio<?= preg_replace("/[^a-z0-9.]+/i", '', explode('.', $result)[0]) ?>">Atur sebagai headline</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media align-items-center mt-md-0 mt-3">
                                                    <a href="<?= base_url('uploads/' . base64_encode('gallery') . '/delete?id=' . base64_encode($data['result']['id']) .'&item=' . base64_encode($result)) ?>" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></a>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('galeri') ?>" class="btn bg-danger">Batal</a>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-lg-12">
            <div class="card-body p-0">
                <div class="row text-center">
                    <div class="col-12 col-md-6 col-lg-7">
                        <figure class="figure">
                            <img src="<?= base_url('uploads/album/' . $data['result']['headline']) ?>" class="figure-img img-fluid w-100 rounded mb-0">
                        </figure>
                    </div>
                    <div class="col-12 col-md-4 col-lg-5">
                        <div class="card">
                            <div class="card-body text-left">
                                <h5 class="mb-3"><?= $data['result']['title'] ?></h5>
                                <p class="mb-0">
                                    <?= $data['result']['description'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php foreach($data['result']['images'] as $result): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <figure class="figure">
                                <img src="<?= base_url('uploads/album/' . $result) ?>" class="figure-img img-fluid w-100 rounded mb-0">
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($action == 'edit'): ?>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    <h4 class="card-title">Tambah Gambar</h4>
                    </div>
                </div>
                <div class="card-body">
                    <?= form_open_multipart('/galeri/upload-image') ?>
                        <?= csrf_field() ?>
                        <div class="form-group d-none">
                            <label for="title">id</label>
                            <input type="text" class="form-control" id="album-id" name="album-id" value="<?= $data['result']['id'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Pilih Gambar</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="images" id="images" name="images[]" accept="image/jpeg,image/gif,image/png,image/jpg,image/webp" onChange="updateList()" multiple required>
                                    <label class="custom-file-label" for="inputGroupFile04">Pilih gambar</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Unggah</button>
                                </div>
                            </div>
                            <p class="mb-0" id="images-label"></p>
                            <ul id="file-list" class="pl-3 mt-2"></ul>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>