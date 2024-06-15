<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('modul') ?>">Modul</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-start">
                <div class="header-title">
                    <h4 class="card-title">Tambah Modul</h4>
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
                <?= form_open_multipart('/modul/create') ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="major">Jurusan</label>
                        <input type="text" class="form-control" id="major" name="major" required>
                    </div>
                    <div class="form-group">
                        <label for="writer">Penulis</label>
                        <input type="text" class="form-control" id="writer" name="writer" required>
                    </div>
                    <div class="form-group">
                        <label for="teacher">Pengajar</label>
                        <input type="text" class="form-control" id="teacher" name="teacher" required>
                    </div>
                    <div class="form-group">
                        <label for="tags">Tagar</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Contoh tags, ..., ...,">
                        <small id="tags-help" class="form-text text-muted">Tulis tags/tagar dipisahkan menggunakan tanda koma (,).</small>
                    </div>
                    <div class="form-group">
                        <label for="modul-group">Unggah Modul</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="modul" name="modul" accept="application/pdf,application/force-download,application/x-download,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                <label class="custom-file-label" for="modul">Pilih modul</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('modul') ?>" class="btn bg-danger">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>