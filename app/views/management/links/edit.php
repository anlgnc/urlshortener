<section class="content">
	<div class="row">
		<div class="col-lg-6 col-sm-12">
			<div class="card ">
				<div class="card-header">Link Düzenleme</div>
				<div class="card-body">

					<div id="link-zone" class="alert bg-gradient-info p-2 text-center" role="alert">
						<span id="link"><?=base_url($short_link)?></span>
					</div>
					<div class="mb-3">
						<label for="original_link" class="form-label">Kısaltılacak Link</label>
						<input type="text" class="form-control form-control-border" id="original_link" value="<?=$original_link?>" required>
					</div>
					<div class="mb-3 col-lg-4 col-sm-12">
						<label for="status" class="form-label">Link Durumu</label>
						<select class="custom-select form-control-border rounded-0" id="status" name="status">
							<option value="1" <?=$status==1 ? "selected": null ?>>Aktif</option>
							<option value="0" <?=$status==0 ? "selected": null ?>>Pasif</option>
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
		document.location.href = base_url + "/links";
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
				url: base_url + '/links/edit/<?=$id?>',
				data: {
					link: _linkElement,
					status: _linkStatus,
					'<?=$this->security->get_csrf_token_name()?>' : '<?=$this->security->get_csrf_hash() ?>'
				},
				dataType: "JSON",
				success: function (response) {

					if (response.status) {
						linkZoneElement.removeClass("d-none");
						linkZoneLinkElement.text("<?=base_url()?>" + response.link);
						toasInfoAlert("Link Güncelleme Durumu", "Güncelleme işlemi başarılı bir şekilde gerçekleştirilmiştir.", "success")

					} else {
						linkZoneElement.removeClass("d-none");
						linkZoneLinkElement.text('Ooops! Teknik bir hata meydana geldi.');
						toasInfoAlert("Link Güncelleme Durumu", "Güncelleme işlemi gerçekleştirilememiştir.", "error")

					}
				}

			});
		}

	}
</script>
