<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title><?= $currentPage ?></title>
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
			<div id="loading-center"></div>
		</div>
		<div class="wrapper">
			<div class="mt-5 iq-maintenance">
				<div class="container-fluid p-0">
					<div class="row no-gutters">
						<div class="col-sm-12 text-center">
							<div class="iq-maintenance">
								<img src="<?= base_url('images/logo.webp') ?>" class="mb-4" width="200px" alt="">
								<h3 class="mt-4 mb-1">We are Currently Performing Maintenance</h3>
								<p>Please check back in sometime.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="container mt-3">
					<div class="row">
						<div class="col-lg-4">
							<div class="card text-center">
								<div class="card-body">
									<i class="ri-window-line ri-4x line-height text-primary"></i>
									<h5 class="card-title mt-1">Why is the Site Down?</h5>
									<p class="mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card text-center">
								<div class="card-body">
									<i class="ri-time-line ri-4x line-height text-primary"></i>
									<h5 class="card-title mt-1">What is the Downtime?</h5>
									<p class="mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card text-center">
								<div class="card-body">
									<i class="ri-information-line ri-4x line-height text-primary"></i>
									<h5 class="card-title mt-1">Do you need Support?</h5>
									<p class="mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
	</body>
</html>