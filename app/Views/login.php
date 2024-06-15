<!doctype html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Log In</title>
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" />
        <!-- Stylesheet -->
		<link rel="stylesheet" href="<?= base_url('template/css/backend-plugin.min.css') ?>">
		<link rel="stylesheet" href="<?= base_url('template/css/backend.css') ?>?v=1.0.0">
		<link rel="stylesheet" href="<?= base_url('template/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') ?>">
		<link rel="stylesheet" href="<?= base_url('template/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') ?>">
		<link rel="stylesheet" href="<?= base_url('template/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <?= $this->renderSection('stylesheet') ?>
	</head>
  <body>
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>
        <div class="wrapper">
            <section class="login-content">
                <div class="container">
                    <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center auth-content">
                                <div class="col-lg-6 bg-primary content-left">
                                    <div class="p-3">
                                        <h2 class="mb-2 text-white">Sign In</h2>
                                        <p>Masuk untuk mendapatkan akses ke dashboard.</p>
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
                                        <?php if (session()->has('invalid')): ?>
                                            <div class="alert alert-danger my-3" role="alert">
                                                <div class="iq-alert-icon">
                                                    <i class="bi bi-exclamation-triangle"></i>
                                                </div>
                                                <div class="iq-alert-text mb-0 pl-3">
                                                    <?= session('invalid') ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?= form_open_multipart() ?>
                                            <?= csrf_field() ?>
                                            <div class="form-group">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" type="text" name="username" placeholder=" " <?= $remembered != null ? 'value="' . $remembered['username'] . '"' : '' ?> required>
                                                    <label>Username</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" type="password" name="password" placeholder=" " <?= $remembered != null ? 'value="' . $remembered['password'] . '"' : '' ?> required>
                                                    <label>Password</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="rememberMe" name="rememberMe" value="remember" <?= $remembered != null ? 'checked' : '' ?> style="height: 0px !important">
                                                    <label class="custom-control-label control-label-1 text-white" for="rememberMe">Ingat Saya</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-white">Sign In</button>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 content-right p-5">
                                    <img src="<?= base_url('/images/logo.webp') ?>" class="img-fluid image-right" alt="">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        </div>
		<!-- Wrapper End-->
		<!-- Backend Bundle JavaScript -->
		<script src="<?= base_url('template/js/backend-bundle.min.js') ?>"></script>
		<!-- Table Treeview JavaScript -->
		<script src="<?= base_url('template/js/table-treeview.js') ?>"></script>
		<!-- Chart Custom JavaScript -->
		<script src="<?= base_url('template/js/customizer.js') ?>"></script>
		<!-- Chart Custom JavaScript -->
		<script async src="<?= base_url('template/js/chart-custom.js') ?>"></script>
		<!-- Chart Custom JavaScript -->
		<script async src="<?= base_url('template/js/slider.js') ?>"></script>
		<!-- app JavaScript -->
		<script src="<?= base_url('template/js/app.js') ?>"></script>
		<script src="<?= base_url('template/vendor/moment.min.js') ?>"></script>
        <!-- additional Javascript -->
        <?= $this->renderSection('javascript') ?>
  </body>
</html>