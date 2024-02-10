<section class="content">
	<div class="row">
		<div class="col-lg-6 col-sm-12">
			<div class="card ">
					<div class="card-header">Kullanıcı Grubu Düzenleme</div>
				<div class="card-body">
					<div class="mb-3">
						<label for="group_name" class="form-label">Grup Adı</label>
						<input type="text" class="form-control form-control-border" id="group_name" value="<?=$group_name?>" required>
					</div>
					<div class="mb-3 col-lg-4 col-sm-12">
						<label for="status" class="form-label">Grup Durumu</label>
						<select class="custom-select form-control-border rounded-0" id="status" name="status" aria-label="Default select example">
							<option value="1"  <?=($status==1)? "selected" : null?> >Aktif</option>
							<option value="0" <?=($status==0)? "selected" : null?> >Pasif</option>
						</select>
					</div>
				</div>
				<div class="card-footer text-right">
					<button onclick="backward()" type="button" class="btn btn-flat bg-gradient-danger btn-sm"><i class="fas fa-caret-square-left"></i> Geri Dön</button>
					<button onclick="submitLink()" id="submit_btn" type="button" class="btn btn-flat bg-gradient-success btn-sm"><i class="fas fa-save"></i> Kaydı Güncelle</button>
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

		let groupNameElement = $("#group_name");
		let _groupNameElement = $("#group_name").val();
		let _groupStatus = $("#status").val();

		if (_groupNameElement != "" && groupNameElement.length > 0) {
			$.ajax({
				type: "POST",
				url: base_url + '/groups/edit/<?=$id?>',
				data: {
					grup_name: _groupNameElement,
					status: _groupStatus,
				},
				dataType: "JSON",
				success: function (response) {
					if (response.status) {
						toasInfoAlert(response.title,response.message,response.status)
					} else {
						toasInfoAlert(response.title,response.message,response.status)
					}
				}
			});
		}

	}
</script>
