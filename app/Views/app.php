<!doctype html>
<html lang="id">
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
            <div class="iq-sidebar sidebar-default ">
                <div class="iq-sidebar-logo d-flex align-items-center">
                    <a href="/" class="header-logo">
                        <img src="<?= base_url('images/logo.png') ?>" alt="logo">
                        <h3 class="logo-title light-logo">SMK N 2 Kupang</h3>
                    </a>
                    <div class="iq-menu-bt-sidebar ml-0">
                        <i class="bi bi-x-lg wrapper-menu"></i>
                    </div>
                </div>
                <div class="data-scrollbar" data-scroll="1">
                    <nav class="iq-sidebar-menu">
                        <ul id="iq-sidebar-toggle" class="iq-menu">
                            <li class="<?= $currentPage == 'Dashboard' ? 'active' : '' ?>">
                                <a href="<?= base_url() ?>" class="svg-icon">
                                    <i class="bi bi-columns"></i>
                                    <span class="ml-4">Dashboard</span>
                                </a>
                            </li>
                            <li class="<?= $currentPage == 'Berita' ? 'active' : '' ?>">
                                <a href="<?= base_url('berita') ?>" class="svg-icon">
                                    <i class="bi bi-newspaper"></i>
                                    <span class="ml-4">Berita</span>
                                </a>
                            </li>
                            <li class="<?= $currentPage == 'Pengumuman' ? 'active' : '' ?>">
                                <a href="<?= base_url('pengumuman') ?>" class="svg-icon">
                                    <i class="bi bi-megaphone"></i>
                                    <span class="ml-4">Pengumuman</span>
                                </a>
                            </li>
                            <li class="<?= $currentPage == 'Agenda' || $currentPage == 'Pengajuan Agenda' ? 'active' : '' ?>">
                                <a href="#agenda" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                    <i class="bi bi-calendar4"></i>
                                    <span class="ml-4">Agenda</span>
                                    <i class="bi bi-chevron-right iq-arrow-right arrow-active"></i>
                                    <i class="bi bi-chevron-down iq-arrow-right arrow-hover"></i>
                                </a>
                                <ul id="agenda" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                    <li class="<?= $currentPage == 'Agenda' ? 'active' : '' ?>">
                                        <a href="<?= base_url('agenda') ?>" class="svg-icon">
                                            <i class="bi bi-dash m-0"></i>
                                            <span class="ml-4">Daftar Agenda</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="<?= $currentPage == 'Galeri' ? 'active' : '' ?>">
                                <a href="<?= base_url('galeri') ?>" class="svg-icon">
                                    <i class="bi bi-images"></i>
                                    <span class="ml-4">Galeri</span>
                                </a>
                            </li>
                            <li class="<?= $currentPage == 'Modul' ? 'active' : '' ?>">
                                <a href="<?= base_url('modul') ?>" class="svg-icon">
                                    <i class="bi bi-book"></i>
                                    <span class="ml-4">Modul</span>
                                </a>
                            </li>
                            <li class="<?= $currentPage == 'Prestasi' ? 'active' : '' ?>">
                                <a href="<?= base_url('prestasi') ?>" class="svg-icon">
                                    <i class="bi bi-trophy"></i>
                                    <span class="ml-4">Prestasi</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
			<div class="iq-top-navbar">
				<div class="iq-navbar-custom">
					<nav class="navbar navbar-expand-lg navbar-light p-0">
						<div class="iq-navbar-logo d-flex align-items-center justify-content-between">
							<i class="bi bi-list wrapper-menu"></i>
							<a href="<?= base_url() ?>" class="header-logo">
								<h4 class="logo-title text-uppercase">Panel Admin</h4>
							</a>
						</div>
						<div class="navbar-breadcrumb">
							<h5><?= $currentPage ?></h5>
						</div>
						<div class="d-flex align-items-center">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <?= $this->renderSection('searchbar') ?>
                                <li class="nav-item nav-icon dropdown caption-content pt-0">
                                    <a href="#" class="search-toggle dropdown-toggle  d-flex align-items-center" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-person-circle"></i>
                                        <div class="caption ml-3">
                                            <i class="bi bi-chevron-down"></i>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right border-none" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item d-flex svg-icon">
                                            <i class="bi bi-person-fill text-primary"></i>
                                            <a href="<?= base_url('profil') ?>">Profil Akun</a>
                                        </li>
                                        <li class="dropdown-item d-flex svg-icon border-top">
                                            <i class="bi bi-box-arrow-right text-danger" style="margin-top: 3px"></i>
                                            <a href="<?= base_url('logout') ?>">Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
						</div>
					</nav>
				</div>
			</div>
            <div class="content-page position-relative">
                <div class="container-fluid">
                    <?= $this->renderSection('breadcrumb') ?>
                    <?= $this->renderSection('content') ?>
                </div>
                <?= $this->renderSection('popup-action') ?>
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
        <?= $this->renderSection('javascript') ?>
	</body>
</html>