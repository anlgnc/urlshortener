<section class="content">
	<div class="row">
		<div class="col-lg-4 col-sm-12">
			<div class="card">
				<div class="card-header font-weight-bold">Profil Bilgilerim</div>
				<div class="card-body">
					<div class="mb-3">
						<label for="user_name" class="form-label">Kullanıcı Adınız</label>
						<input type="text" class="form-control form-control-border" value="<?= $this->session->userdata('profile_user')["user_name"] ?>" readonly>
					</div>
					<div class="mb-3">
						<label for="user_name" class="form-label">Kullanıcı Grubunuz</label>
						<input type="text" class="form-control form-control-border" value="<?= $this->session->userdata('profile_user')["user_group_text"] ?>" readonly>
					</div>
					<div class="mb-3">
						<label for="user_name" class="form-label">Son Oturum IP</label>
						<input type="text" class="form-control form-control-border" value="<?= $this->session->userdata('profile_user')["ip"] ?>" readonly>
					</div>
					<div class="mb-3">
						<label for="user_name" class="form-label">Son Oturum Açma Tarihiniz</label>
						<input type="text" class="form-control form-control-border" value="<?= date("d.m.Y - H:i", $this->session->userdata('profile_user')["login"]) ?>" readonly>
					</div>
					<div class="mb-3">
						<label for="user_name" class="form-label">Kullanıcı Açılış Tarihiniz</label>
						<input type="text" class="form-control form-control-border" value="<?= date("d.m.Y - H:i", $this->session->userdata('profile_user')["login"]) ?>" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-sm-12">
			<div class="card">
				<div class="card-header font-weight-bold">Profil Parolası Değiştirme</div>
				<div class="card-body">
					<div class="mb-3">
						<label for="current_password" class="form-label">Güncel Parolanız</label>
						<input type="password" id="current_password" class="form-control form-control-border" value="" required>
					</div>
					<div class="mb-3">
						<label for="new_password" class="form-label">Yeni Parolanız</label>
						<input type="password" id="new_password" class="form-control form-control-border" value="" required>
					</div>
					<div class="mb-3">
						<label for="re_new_password" class="form-label">Yeni Parolanız (Tekrar)</label>
						<input type="password" id="re_new_password" class="form-control form-control-border" value="" required>
					</div>
				</div>
				<div class="card-footer text-center">
					<button onclick="submitLink()" id="submit_btn" type="button" class="btn btn-flat bg-gradient-success btn-sm"><i class="fas fa-save"></i> Parolayı Güncelle</button>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	var base_url = "<?=base_url('management')?>";

	function backward() {
		document.location.href = base_url + "/groups";
	}

	function submitLink() {
		let user_password = $("#current_password").val();
		let new_user_password = $("#new_password").val();
		let re_user_password = $("#re_new_password").val();

		if(new_user_password != re_user_password){
			toasInfoAlert("Parola Hatası", "Parolalar uyuşmuyor lütfen, parola ve parola tekrarı alanlarına aynı parolaları giriniz.", "error");
			return;
		}

		if (user_password != "" && new_user_password != "" && re_user_password != "" && new_user_password == re_user_password) {
			$.ajax({
				type: "POST",
				url: base_url + '/profile',
				data: {
					user_password: user_password,
					new_user_password: new_user_password,
					re_user_password: re_user_password,
				},
				dataType: "JSON",
				success: function (response) {
					if (response.status) {
						toasInfoAlert(response.title, response.message, response.status)
					} else {
						toasInfoAlert(response.title, response.message, response.status)
					}
				}
			});
		}else{
			toasInfoAlert("Parola Hatası", "Boş alanlar tespit edildi. Lütfen, boş alan bırakmayınız!", "error");
		}
	}
</script>
