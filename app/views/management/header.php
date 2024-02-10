<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AGC-URLSHORTENER | <?=$title?></title>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/management/icons/apple-touch-icon.png') ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/management/icons/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/management/icons/favicon-16x16.png') ?>">
	<link rel="manifest" href="<?= base_url('assets/management/icons/site.webmanifest') ?>">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/fontawesome-free/css/all.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/dist/css/adminlte.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">

	<script src="<?= base_url('assets/management/plugins/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/jszip/jszip.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/pdfmake/pdfmake.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/pdfmake/vfs_fonts.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/dist/js/adminlte.min.js') ?>"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<script>
		function toasInfoAlert(title,message,icon){
			Swal.fire({
				title:title,
				text: message,
				icon: icon,
				backdrop:true,
				animation:true,
				timer: 2500,
				timerProgressBar: true,
				confirmButtonText:"Tamam",
			});
		}
	</script>
</head>
<body class="hold-transition sidebar-mini  text-sm">

<!-- Site wrapper -->
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-light border-bottom-0">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?= base_url('management') ?>" class="btn bg-gradient-light btn-flat btn-sm"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?= base_url('management/links/create') ?>" class="btn bg-gradient-light btn-flat btn-sm"><i class="fas fa-plus-circle"></i> Yeni Link Ekle</a>
			</li>
		</ul>

	</nav>

	<aside class="main-sidebar sidebar-dark-primary">
		<a href="<?= base_url("management") ?>" class="brand-link text-center">
			<span class="brand-text font-weight-bold btn bg-gradient-gray-dark">AGC-URL[shortener]</span>
		</a>

		<div class="sidebar">
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="info">
					<span class="text-light"><i class="fas fa-user-circle text-green"></i> <?=$this->session->userdata('profile_user')["user_name"]?></span><br>
					<span class="text-light bg-gra"><i class="fas fa-address-card text-green"></i> <?=$this->session->userdata('profile_user')["user_group_text"]?></span>
				</div>
			</div>


			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item">
						<a href="<?= base_url("management") ?>" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>

					<li class="nav-header">LİNK İŞLEMLERİ</li>

					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-external-link-square-alt"></i>
							<p>
								Link Yönetimi
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= base_url('management/links') ?>" class="nav-link">
									<i class="fas fa-list-alt nav-icon"></i>
									<p>Linkler</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('management/links/create') ?>" class="nav-link">
									<i class="fas fa-plus-circle nav-icon"></i>
									<p>Yeni Link Ekle</p>
								</a>
							</li>
						</ul>
					</li>

					<?php if(isAdmin()) { ?>
					<li class="nav-header">KULLANICI İŞLEMLERİ</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-users-cog"></i>
							<p>
								Kullanıcı Yönetimi
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= base_url('management/users') ?>" class="nav-link">
									<i class="fas fa-users nav-icon"></i>
									<p>Kullanıcılar</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('management/users/create') ?>" class="nav-link">
									<i class="fas fa-user-plus nav-icon"></i>
									<p>Yeni Kullanıcı Ekle</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-users-cog"></i>
							<p>
								Kullanıcı Grupları Yönetimi
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= base_url('management/groups') ?>" class="nav-link">
									<i class="fas fa-users nav-icon"></i>
									<p>Kullanıcı Grupları</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('management/groups/create') ?>" class="nav-link">
									<i class="fas fa-user-plus nav-icon"></i>
									<p>Yeni Kullanıcı Grubu Ekle</p>
								</a>
							</li>
						</ul>
					</li>
					<?php } ?>

					<li class="nav-header">PROFİLİM</li>
					<li class="nav-item">
						<a href="<?= base_url("management/profile") ?>" class="nav-link">
							<i class="nav-icon fas fa-user"></i>
							<p>Profilim</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url("management/user-logout") ?>" class="nav-link">
							<i class="nav-icon fas fa-times-circle"></i>
							<p>Çıkış Yap</p>
						</a>
					</li>

				</ul>
			</nav>
		</div>
	</aside>

	<div class="content-wrapper">
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1><?=$title?></h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<?php foreach ($breadcrumbs as $item) {
								echo $item;
							} ?>
						</ol>
					</div>
				</div>
			</div>
		</section>
