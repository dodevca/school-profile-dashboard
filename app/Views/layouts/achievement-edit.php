<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('prestasi') ?>">Prestasi</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page"><?= $data['result']['type'] ?> - <?= $data['result']['name'] ?> - <?= $data['result']['year'] ?></li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                <h4 class="card-title">Edit Prestasi</h4>
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
                <?= form_open_multipart('/prestasi/update') ?>
                    <?= csrf_field() ?>
                    <div class="form-group d-none">
                        <label for="achievement-id">Id</label>
                        <input type="text" class="form-control" id="achievement-id" name="achievement-id" value="<?= $data['result']['id'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Jenis Prestasi</label>
                        <input type="text" class="form-control" id="type" name="type" value="<?= $data['result']['type'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Siswa</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $data['result']['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="major">Jurusan</label>
                        <input type="text" class="form-control" id="major" name="major" value="<?= $data['result']['major'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Tingkat</label>
                        <input type="text" class="form-control" id="level" name="level" value="<?= $data['result']['level'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Tahun</label>
                        <select class="form-control mb-3" id="year" name="year" required>
                           <?php for($year = date('Y'); $year >= 2000; $year--): ?>
                                <option value="<?php echo $year; ?>" <?= $year == $data['result']['year'] ? 'selected' : '' ?>><?php echo $year; ?></option>
                            <?php endfor; ?>
                        </select>
                     </div>
                    <?php if(!empty($data['result']['images']) && count($data['result']['images']) > 0): ?>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="description">Daftar Foto</label>
                                <?php foreach($data['result']['images'] as $result): ?>
                                    <div class="card card-widget task-card bg-white">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <img src="<?= base_url('uploads/prestasi/' . $result) ?>" class="card-img-cover rounded img-fluid mr-3" alt="Responsive image">
                                                    </div>
                                                </div>
                                                <div class="media align-items-center mt-md-0 mt-3">
                                                    <a href="<?= base_url('uploads/' . base64_encode('achievements') . '/delete?id=' . base64_encode($data['result']['id']) .'&item=' . base64_encode($result)) ?>" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></a>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="position-relative border-top my-4">
                            <div class="position-absolute bg-white p-2" style="top:50%;left:50%;transform:translate(-50%,-50%);">
                                <span class="text-muted">tambah foto baru</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="images-group">Tambah Foto<span class="text-muted ml-1 font-weight-light">(Opsional)</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="images" name="images[]" accept="image/jpeg,image/gif,image/png,image/jpg,image/webp" onChange="updateList()" multiple>
                                <label class="custom-file-label" for="images">Pilih atau drop gambar disini</label>
                            </div>
                        </div>
                        <p class="mb-0" id="images-label"></p>
                        <ul id="file-list" class="pl-3 mt-2"></ul>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('prestasi') ?>" class="btn bg-danger">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>