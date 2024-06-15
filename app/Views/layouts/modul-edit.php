<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('modul') ?>">Modul</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page"><?= $data['result']['title'] ?></li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-start">
                <div class="header-title">
                    <h4 class="card-title">Edit Modul</h4>
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
                    <div class="form-group d-none">
                        <label for="modul-id">id</label>
                        <input type="text" class="form-control" id="modul-id" name="modul-id" value="<?= $data['result']['id'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $data['result']['title'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="major">Jurusan</label>
                        <input type="text" class="form-control" id="major" name="major" value="<?= $data['result']['major'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="writer">Penulis</label>
                        <input type="text" class="form-control" id="writer" value="<?= $data['result']['writer'] ?>" name="writer" required>
                    </div>
                    <div class="form-group">
                        <label for="teacher">Pengajar</label>
                        <input type="text" class="form-control" id="teacher" value="<?= $data['result']['teacher'] ?>" name="teacher" required>
                    </div>
                    <div class="form-group">
                        <label for="tags">Tagar</label>
                        <input type="text" class="form-control" id="tags" name="tags" value="<?= $data['result']['tags'] ?>" placeholder="Contoh tags, ..., ...,">
                        <small id="tags-help" class="form-text text-muted">Tulis tags/tagar dipisahkan menggunakan tanda koma (,).</small>
                    </div>
                    <div class="form-group">
                        <label for="current-modul">Modul</label>
                        <input type="text" class="form-control" id="current-modul" name="current-modul" value="<?= $data['result']['modul'] ?>" readonly>
                        <a href="<?= base_url('uploads/modul/' . $data['result']['modul']) ?>" class="btn btn-outline-primary w-100 mt-2"><i class="bi bi-eye"></i>Tampilkan Modul</a>
                    </div>
                    <div class="position-relative border-top my-4">
                        <div class="position-absolute bg-white p-2" style="top:50%;left:50%;transform:translate(-50%,-50%);">
                            <span class="text-muted">ganti dengan modul baru</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modul-group">Ganti Modul</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="modul" name="modul" accept="application/pdf,application/force-download,application/x-download,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
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