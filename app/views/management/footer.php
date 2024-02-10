</div>
<footer class="main-footer">
	<div class="float-right d-none d-sm-block">
		<span class="btn bg-gradient-light btn-flat btn-sm"><?= date("d.m.Y - H:i", $this->session->userdata('profile_user')["login"]) ?></span>
		<span class="btn bg-gradient-light btn-flat btn-sm"><?= $this->session->userdata('profile_user')["ip"] ?></span>
		<span class="btn bg-gradient-light btn-flat btn-sm"><i class="fas fa-rocket text-danger"></i> <b>Version</b> 1.0.1</span>
	</div>
	<strong>Copyright &copy; <?= date("Y", now()) ?> <span class="btn bg-gradient-light btn-flat btn-sm font-weight-bold">ANLGNC</span></strong>
</footer>
</div>
</body>
</html>
