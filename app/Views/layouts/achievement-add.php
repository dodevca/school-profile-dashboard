<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('prestasi') ?>">Prestasi</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                <h4 class="card-title">Tambah Prestasi</h4>
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
                <?= form_open_multipart('/prestasi/create') ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="type">Jenis Prestasi</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Siswa</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="major">Jurusan</label>
                        <input type="text" class="form-control" id="major" name="major" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Tingkat</label>
                        <input type="text" class="form-control" id="level" name="level" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Tahun</label>
                        <select class="form-control mb-3" id="year" name="year" required>
                           <option value="" selected>Pilih tahun</option>
                           <?php for($year = date('Y'); $year >= 2000; $year--): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endfor; ?>
                        </select>
                     </div>
                    <div class="form-group">
                        <label for="images-group">Unggah Foto<span class="text-muted ml-1 font-weight-light">(Opsional)</span></label>
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