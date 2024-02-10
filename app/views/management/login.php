<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AGC-URL shortener | Log in</title>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/management/icons/apple-touch-icon.png') ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/management/icons/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/management/icons/favicon-16x16.png') ?>">
	<link rel="manifest" href="<?= base_url('assets/management/icons/site.webmanifest') ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/fontawesome-free/css/all.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/management/dist/css/adminlte.min.css') ?>">
	<script src="<?= base_url('assets/management/plugins/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/bootstrap/js/bootstrap.bundle.min.js"') ?>"></script>
	<script src="<?= base_url('assets/management/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
	<script src="<?= base_url('assets/management/dist/js/adminlte.min.js') ?>"></script>
	<style>
		body {
			background: rgb(242, 242, 242);
			background: linear-gradient(0deg, rgba(242, 242, 242, 1) 0%, rgba(255, 255, 255, 1) 100%);
		}
	</style>
</head>
<body class="hold-transition login-page">
<div class="login-box ">
	<div class="login-logo">
		<b>AGC-URL</b>[shortener]
	</div>
	<hr>
	<div class="card">
		<div class="card-body login-card-body shadow" style="border-radius: 5px;border-bottom: 7px solid #000000">

			<form id="login_form">
				<div class="input-group mb-3">
					<input name="username" id="username" type="text" class="form-control" placeholder="Kullanıcı Adı">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input name="password" id="password" type="password" class="form-control" placeholder="Parola">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group last mb-3">
							<div class="input-group-append">
								<div class="input-group-prepend">
									<div class="input-group-text p-0"><img id="cptch" class="p-0" src="<?= base_url("management/login/captcha") ?>"></div>
								</div>
								<input type="text" class="form-control" name="captcha" id="cptchinp" placeholder="Güvenlik Anahtarı">

							</div>

						</div>
					</div>
					<div class="col-12">
						<button type="submit" class="btn bg-gradient-dark btn-block font-weight-bold">Giriş Yap</button>
					</div>
				</div>

			</form>
		</div>
	</div>
	<hr>
</div>
<span class="text-gray mx-auto mt-2 text-sm">Copyright © <?= date("Y", now()) ?> <strong>[anlgnc]</strong></span>
</body>
</html>
<script>
	$(document).ready(function () {
		var Toast = Swal.mixin({
			toast: true,
			position: 'bottom-end',
			showConfirmButton: false,
			timer: 3000
		});

		$('#login_form').submit(function (event) {
			event.preventDefault();

			let alert = $('#alert');

			var formValid = true;
			$(this).find('[required]').each(function () {
				if ($(this).val() === '') {
					formValid = false;
					return false;
				}
			});

			if (!formValid) {
				alert('Lütfen tüm alanları doldurun.');
				return;
			}

			var formData = $(this).serialize();

			$.ajax({
				type: 'POST',
				url: '<?=base_url("management/user-login")?>',
				data: formData,
				dataType: 'json',

				success: function (response) {
					if (response.status == "error") {

						Toast.fire({
							icon: response.status,
							title: response.message,
						})

					} else {
						document.getElementById("cptch").src = '<?=base_url("management/login/captcha")?>';
						document.getElementById("cptchinp").value = '';
						Toast.fire({
							icon: response.status,
							title: response.message,
						})
						setTimeout(function () {
							window.location.href = "<?=base_url('management')?>";
						}, 3000);
					}
				},
				error: function () {
					$('#result').html('Teknik Hata');
				}
			});
		});
	});
</script>
