<section class="content">
	<div class="row">
		<div class="col-lg-3 col-6">
			<div class="small-box bg-gradient-danger">
				<div class="inner">
					<h3><?= count($links) ?></h3>
					<p>Aktif Link Sayısı</p>
				</div>
				<div class="icon">
					<i class="fas fa-external-link-square-alt"></i>
				</div>
				<a href="<?= base_url('management/links') ?>" class="small-box-footer">Yönetim <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-6">
			<div class="small-box bg-gradient-light">
				<div class="inner">
					<h3><?= $links_views ?></h3>
					<p>Aktif Link Ziyaret Sayısı</p>
				</div>
				<div class="icon">
					<i class="fas fa-globe-asia"></i>
				</div>
				<a href="<?= base_url('management/links') ?>" class="small-box-footer">Yönetim <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<?php if (isAdmin()) { ?>
		<div class="col-lg-3 col-6">
			<div class="small-box bg-gradient-blue">
				<div class="inner">
					<h3><?=count($users)?></h3>
					<p>Aktif Kullanıcı Sayısı</p>
				</div>
				<div class="icon">
					<i class="fas fa-globe-asia"></i>
				</div>
				<a href="<?= base_url('management/users') ?>" class="small-box-footer">Yönetim <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="row">

	</div>
</section>
