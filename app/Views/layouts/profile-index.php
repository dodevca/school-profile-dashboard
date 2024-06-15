<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
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
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div class="profile-img position-relative">
                        <i class="bi bi-person-fill display-2"></i>
					</div>
					<div class="ml-3">
						<h4 class="mb-1"><?= $data['username'] ?></h4>
						<p class="mb-2"><?= ucwords($data['as']) ?></p>
						<div class="d-inline bg-success font-size-14 px-3 py-2 rounded">Aktif</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<ul class="d-flex nav nav-pills mb-3 text-center profile-tab" id="profile-pills-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active show" data-toggle="pill" href="#update-password" role="tab" aria-selected="false">Update Password</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#new-username" role="tab" aria-selected="false">Ganti Username</a>
					</li>
				</ul>
				<div class="profile-content tab-content">
					<div id="update-password" class="tab-pane fade active show">
						<div class="row">
							<div class="col-lg-12">
								<div class="card shadow-none">
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
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
										<?= form_open('/profil/password') ?>
                    						<?= csrf_field() ?>
											<div class="form-group">
												<label for="password">Password baru</label>
												<input type="password" class="form-control" id="change-password" name="password" required>
											</div>
											<div class="form-group">
												<label for="password-match">Masukkan kembali password</label>
												<input type="password" class="form-control" id="change-password-match" name="password-match" required>
											</div>
											<button type="button" class="btn btn-primary" id="change-password-button" data-toggle="modal" data-target="#updatePassword">Ganti Password</button>
											<div class="modal fade" id="updatePassword" tabindex="-1" aria-labelledby="updatePasswordTitle" aria-modal="true" role="dialog">
												<div class="modal-dialog modal-dialog-scrollable" role="document">
													<div class="modal-content">
														<div class="modal-body text-center">
															<i class="bi bi-exclamation-circle-fill mb-3 display-3 text-warning"></i>
															<p class="text-warning">Pastikan tidak ada kesalahan penulisan dalam mengisi password.</p>
															<br>
															<p>Setelah anda mengganti password, anda akan keluar secara otomatis dan silahkan untuk login kembali kedalam dashboard.</p>
														</div>
														<div class="modal-footer border-0 justify-content-center">
															<button type="submit" class="btn btn-primary">Ganti</button>
															<button type="button" class="btn bg-secondary-light" data-dismiss="modal">Batal</button>
														</div>
													</div>
												</div>
											</div>
										<?= form_close() ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="new-username" class="tab-pane fade">
						<div class="row">
							<div class="col-lg-12">
								<div class="card shadow-none">
									<div class="card-body">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
										<?= form_open('/profil/username') ?>
                    						<?= csrf_field() ?>
											<div class="form-group">
												<label for="username">Username baru</label>
												<input type="text" class="form-control" id="new-username" name="username" required>
											</div>
											<div class="form-group">
												<label for="password">Password</label>
												<input type="password" class="form-control" id="username-password" name="password" required>
											</div>
											<button type="submit" class="btn btn-primary" id="new-username-button">Simpan</button>
										<?= form_close() ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>