<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>">Berita</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page"><?= $data['result']['title'] ?></li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                <h4 class="card-title">Edit Berita</h4>
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
                <?= form_open_multipart('/berita/update') ?>
                    <?= csrf_field() ?>
                    <div class="form-group d-none">
                        <label for="news-id">id</label>
                        <input type="text" class="form-control" id="news-id" name="news-id" value="<?= $data['result']['id'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $data['result']['title'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Isi Berita</label>
                        <textarea class="form-control" id="content-textarea" name="content" rows="16">
                            <?= $data['result']['content'] ?>
                        </textarea>
                    </div>
                    <?php if($data['result']['image'] != null && !empty($data['result']['image'])): ?>
                        <div class="form-group">
                            <label for="content">Headline</label>
                            <br>
                            <a href="<?= base_url('uploads/berita/' . $data['result']['image']) ?>" class="btn btn-outline-secondary"><i class="bi bi-eye mr-2"></i>Lihat headline</a>
                        </div>
                    <?php endif; ?>
                    <div class="position-relative border-top my-4">
                        <div class="position-absolute bg-white p-2" style="top:50%;left:50%;transform:translate(-50%,-50%);">
                            <span class="text-muted">atau ganti headline</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/jpeg,image/jpg,image/gif,image/png,application/pdf,image/x-eps">
                            <label class="custom-file-label" for="image">Unggah gambar</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('berita') ?>" class="btn bg-danger">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="<?= base_url('javascripts/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript">
    tinymce.init({
        selector    : '#content-textarea',
        placeholder : 'Tulis disini ...'
    });
</script>
<?= $this->endSection() ?>