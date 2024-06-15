<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('galeri') ?>">Galeri</a></li>
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
                <h4 class="card-title">Buat Album Baru</h4>
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
                <?= form_open_multipart('/galeri/create') ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="headline">Gambar Utama</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="headline" name="headline" accept="image/jpeg,image/gif,image/png,image/jpg,image/webp" required>
                                <label class="custom-file-label" for="headline">Pilih gambar</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Unggah</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="images">Gambar Lainnya</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="images" name="images[]" accept="image/jpeg,image/gif,image/png,image/jpg,image/webp" onChange="updateList()" multiple required>
                                <label class="custom-file-label" for="images">Pilih atau drop gambar disini</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Unggah</button>
                            </div>
                        </div>
                        <p class="mb-0" id="images-label"></p>
                        <ul id="file-list" class="pl-3 mt-2"></ul>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('galeri') ?>" class="btn bg-danger">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>