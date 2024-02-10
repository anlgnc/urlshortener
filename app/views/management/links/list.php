<style>
	table td:nth-child(3) {
		max-width: 325px;
		overflow: scroll;
	}

	table td:nth-child(4) {
		max-width: 250px;
		overflow: scroll;
	}
</style>
<section class="content">
	<div class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-header pt-2 pb-2 font-weight-bold">Filtreleme</div>
				<div class="card-body">
					<form action="" data-filter>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?= $this->security->get_csrf_hash(); ?>">

						<div class="row">
							<div class="col-lg-3 col-sm-6">
								<label>Link Grubu</label>
								<select class="form-control form-control-sm" id="created_group" name="created_group">
									<option value="">Tümü</option>
									<?php
									foreach ($userGroups as $item) {
										echo '<option value="' . $item->id . '">' . $item->group_name . '</option>';
									}
									?>
								</select>
							</div>
							<div class="col-lg-3 col-sm-6">
								<label>Link Kullanıcısı</label>
								<select class="form-control form-control-sm" id="created_user" name="created_user">
									<option value="">Tümü</option>
									<?php
									foreach ($users as $item) {
										echo '<option value="' . $item->id . '">' . $item->user_name . '</option>';
									}
									?>
								</select>
							</div>
							<div class="col-lg-3 col-sm-6">
								<label>Durum</label>
								<select class="form-control form-control-sm" id="status" name="status">
									<option value="">Tümü</option>
									<option value="1">Aktif</option>
									<option value="0">Pasif</option>
								</select>
							</div>
						</div>
						<div class="row mt-2">
							<button class="btn bg-gradient-success btn-flat"><i class="fas fa-search"></i> Seçeneklere Göre Filtrele</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-12 table-responsive">
			<table id="table" class="bg-white table table-striped table-hover table-bordered table-fw-widget shadow" data-url="<?= base_url('management/links/getLinks/') ?>">
				<thead>
				<tr class="text-center">
					<th>Link ID</th>
					<th>Durum</th>
					<th>Orj. Link</th>
					<th>Kısa Link</th>
					<th>Ziyaret</th>
					<th>Oluşturan</th>
					<th style="width: 150px">Oluşturma Tarihi</th>
					<th style="width: 150px">İşlemler</th>
				</tr>
				</thead>
				<tbody id="tablecontents"></tbody>
			</table>

		</div>
	</div>

</section>

<script>
	var url = $('[data-url]').data('url');
	var _serialize;
	$(document).ready(function () {
		var _serialize;
		url = $('[data-url]').data('url');
		dataTable(url, '');
		$("[data-filter]").submit(function (event) {
			event.preventDefault();
			var _serialize = $(this).serializeArray();
			var _location = $('[data-url]').data("url");
			table.destroy();
			dataTable(_location, _serialize);
		});
	});

	function dataTable(location, serialize) {

		table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"bProcessing": true,
			"bServerSide": true,
			"searching": true,
			orderCellsTop: true,
			fixedHeader: true,
			filter: true,
			info: true,
			ordering: true,
			retrieve: true,
			responsive: false,
			"ajax": {
				"url": url,
				"type": "POST",
				"data": function (d) {
					d.filter = serialize;
				}
			},
			buttons: [
				{extend: 'excel', className: 'excel-btn', text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel Çıktısı Al'}
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
			},
			"columns": [
				{"data": "id", "class": "text-center  align-middle"},
				{"data": "status", "class": "text-center align-middle"},
				{"data": "original_link", "class": "align-middle"},
				{"data": "short_link", "class": "text-center align-middle"},
				{"data": "req_count", "class": "text-center align-middle"},
				{"data": "created_user", "class": "align-middle"},
				{"data": "created_date", "class": "text-center align-middle"},
				{"data": "btn", "class": "text-center  align-middle"},
			],
			"lengthMenu": [20, 50, 100, 500, 1000],
			columnDefs: [

				{orderable: false, targets: 7},

			],
		});

	}
</script>
<script>

	var base_url = "<?=base_url('management')?>";

	function deleteItem(id) {
		Swal.fire({
			title: "İçeriği Silmek İstediğinize Emin Misiniz?",
			text: "İçerik silindikten sonra geri getirilememektedir.!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Evet, Sil!",
			cancelButtonText: "Hayır",
		}).then((result) => {
			if (result.isConfirmed) {

				$.ajax({
					type: "POST",
					url: base_url + '/links/delete',
					data: {
						id: id,
					},
					success: function (response) {
						if (response.status) {
							toasInfoAlert("Silme Durumu", "Silme işlemi başarılı bir şekilde gerçekleştirilmiştir.", "success")
						} else {
							toasInfoAlert("Silme Durumu", "Silme işlemi gerçekleştirilemedi.", "error")
						}
					}
				});
			}
		});
	}
</script>
