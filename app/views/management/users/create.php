<section class="content">
	<div class="row">
		<div class="col-lg-6 col-sm-12">
			<div class="card ">
				<div class="card-header">Yeni Kullanıcı Ekleme</div>
				<div class="card-body">
					<div class="mb-3">
						<label for="user_name" class="form-label">Kullanıcı Adı</label>
						<input type="text" class="form-control form-control-border" id="user_name" required>
					</div>
					<div class="mb-3">
						<label for="user_password" class="form-label">Kullanıcı Parolası</label>
						<input type="text" class="form-control form-control-border" id="user_password" required>
					</div>
					<div class="mb-3">
						<label for="user_group" class="form-label">Kullanıcı Grubu</label>
						<select class="custom-select form-control-border rounded-0" id="user_group" name="status" aria-label="Default select example">
							<?php
							foreach ($groups as $group) {
								echo '<option value="' . $group->id . '">' . $group->group_name . '</option>';
							}
							?>
						</select>
					</div>
					<div class="mb-3 col-lg-4 col-sm-12">
						<label for="status" class="form-label">Kullanıcı Durumu</label>
						<select class="custom-select form-control-border rounded-0" id="status" name="status" aria-label="Default select example">
							<option value="1" selected>Aktif</option>
							<option value="0">Pasif</option>
						</select>
					</div>
				</div>
				<div class="card-footer text-right">
					<button onclick="backward()" type="button" class="btn btn-flat bg-gradient-danger btn-sm"><i class="fas fa-caret-square-left"></i> Geri Dön</button>
					<button onclick="submitLink()" id="submit_btn" type="button" class="btn btn-flat bg-gradient-success btn-sm"><i class="fas fa-save"></i> Kaydı Ekle</button>
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
		let user_name=$("#user_name").val();
		let user_password=$("#user_password").val();
		let user_group=$("#user_group").val();
		let status=$("#status").val();

		if (user_name != "" && user_password != "" && user_group != "" && status != "") {
			$.ajax({
				type: "POST",
				url: base_url + '/users/create',
				data: {
					user_name: user_name,
					user_password: user_password,
					user_group: user_group,
					status: status,
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
		}
	}
</script>
