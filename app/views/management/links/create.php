<section class="content">
	<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="card ">
				<div class="card-header">Yeni Link Ekleme</div>
				<div class="card-body">

					<div id="link-zone" class="alert bg-gradient-info p-2 text-center d-none" role="alert">
						<span id="link"></span>
					</div>
					<div class="mb-3">
						<label for="original_link" class="form-label">Kısaltılacak Link</label>
						<input onkeyup="checker()" type="text" class="form-control form-control-border" id="original_link" required>
					</div>
					<div class="mb-3 col-lg-4 col-sm-12">
						<label for="status" class="form-label">Link Durumu</label>
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
		document.location.href = base_url + "/links";
	}

	function checker() {
		let sbmt = $("#submit_btn");
		let input = $("#original_link");
		let _input = input.val();

		$.ajax({
			type: "POST",
			url: base_url + '/links/check',
			data: {
				link: _input,
			},
			success: function (response) {
				if (response.status) {
					input.removeClass("is-invalid");
					input.addClass("is-valid");
					input.removeClass("disabled");
					sbmt.removeClass("disabled");
				} else {
					input.removeClass("is-valid");
					input.addClass("is-invalid");
					sbmt.addClass("disabled");

				}
			}
		});
	}

	function submitLink() {

		let linkZoneElement = $("#link-zone");
		let linkZoneLinkElement = $("#link");
		let linkElement = $("#original_link");
		let _linkElement = $("#original_link").val();
		let _linkStatus = $("#status").val();

		if (_linkElement != "" && linkElement.length > 0) {
			$.ajax({
				type: "POST",
				url: base_url + '/links/create',
				data: {
					link: _linkElement,
					status: _linkStatus,
				},
				dataType: "JSON",
				success: function (response) {
					if (response.status) {
						linkZoneElement.removeClass("d-none");
						linkZoneLinkElement.text("<?=base_url()?>" + response.link);
						toasInfoAlert("Link Ekleme Durumu", "Ekleme işlemi başarılı bir şekilde gerçekleştirilmiştir.", "success")
					} else {
						linkZoneElement.removeClass("d-none");
						linkZoneLinkElement.text('Ooops! Teknik bir hata meydana geldi.');
						toasInfoAlert("Link Ekleme Durumu", "Ekleme işlemi gerçekleştirilememiştir.", "error")
					}
				}
			});
		}

	}
</script>
