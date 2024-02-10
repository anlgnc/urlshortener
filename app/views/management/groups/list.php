<section class="content">
	<div class="row">
		<div class="col-12 table-responsive">
			<table id="table" class="bg-white table table-striped table-hover table-bordered table-fw-widget shadow" data-url="<?= base_url('management/groups/getGroups/') ?>">
				<thead>
				<tr class="text-center">
					<th style="width: 25px">ID</th>
					<th style="width: 50px">Durum</th>
					<th>Grup Adı</th>
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


	let url = $('[data-url]').data('url');

	let table = $('#table').DataTable({
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
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
		},
		"ajax": {
			"url": url,
			"type": "POST",
			"data": function (d) {
				d.filter = $('[data-search-filter]').serializeArray();
			}
		},
		"columns": [
			{"data": "id", "class": "text-center  align-middle"},
			{"data": "status", "class": "text-center align-middle"},
			{"data": "group_name", "class": "text-left align-middle"},
			{"data": "created_date", "class": "text-center align-middle"},
			{"data": "btn", "class": "text-center  align-middle"},
		],

		"lengthMenu": [20, 50, 100, 500, 1000],
		columnDefs: [
			{orderable: false, targets: 4},

		],
	});

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
					url: base_url + '/groups/delete',
					data: {
						id: id,
					},
					success: function (response) {
						if (response.status) {
							toasInfoAlert(response.title,response.message,response.status)
						} else {
							toasInfoAlert(response.title,response.message,response.status)
						}
					}
				});
			}
		});
	}
</script>
