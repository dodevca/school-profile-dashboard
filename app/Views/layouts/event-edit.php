<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item"><a href="<?= base_url('agenda') ?>">Agenda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">123456789</li>
    </ol>
</nav>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                <h4 class="card-title">Edit Agenda</h4>
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
                <?= form_open_multipart('/agenda/update') ?>
                    <?= csrf_field() ?>
                    <div class="form-group d-none">
                        <label for="event-id">Id</label>
                        <input type="text" class="form-control" id="event-id" name="event-id" value="<?= $data['result']['id'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $data['result']['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="10" required><?= $data['result']['description'] ?></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date-start">Tanggal Mulai</label>
                            <div class="card-body inln-date flet-datepickr border border-light rounded py-4">
                                <input type="text" id="inline-date" class="date-input basicFlatpickr d-none" name="date-start" value="<?= $data['result']['dateStart'] ?>" readonly="readonly" required>
                            </div>
                            <input type="time" class="form-control mt-3" id="time" name="time-start" value="<?= $data['result']['timeStart'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date-end">Tanggal Selesai</label>
                            <div class="card-body inln-date flet-datepickr border border-light rounded py-4">
                                <input type="text" id="inline-date1" class="date-input basicFlatpickr d-none" name="date-end" value="<?= $data['result']['dateEnd'] ?>" readonly="readonly" required>
                            </div>
                            <input type="time" class="form-control mt-3" id="time1" name="time-end" value="<?= $data['result']['timeEnd'] ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?= base_url('agenda') ?>" class="btn bg-danger">Batal</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>