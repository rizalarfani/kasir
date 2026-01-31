<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?php echo (uri(2) == 'edit') ? 'Edit' : 'Tambah'; ?> Pengguna</h4>
							<form action="<?php echo uri(2) == "edit" ? url(1, "update") : url(1, "tambah"); ?>" method="POST" autocomplete="off">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="user_id" value="<?php echo uri(2) == "edit" ? enkrip($edit->user_id) : ""; ?>">
								<div class="form-floating mb-3">
									<input type="text" class="form-control" name="user_nama" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" placeholder="Nama Pengguna" autocomplete="off">
									<label>Username</label>
								</div>
								<?php if (uri(2) != 'edit') : ?>
									<div class="form-floating mb-3">
										<input type="password" class="form-control" name="user_password" placeholder="Password Pengguna" autocomplete="off" required>
										<label>Password</label>
									</div>
								<?php endif; ?>
								<div class="form-floating mb-3">
									<input type="text" class="form-control" name="user_namalengkap" value="<?php echo uri(2) == "edit" ? $edit->user_namalengkap : ""; ?>" placeholder="Nama Lengkap" autocomplete="off" required>
									<label>Nama Lengkap</label>
								</div>
								<?php if ($this->user_level == 4) { ?>
									<div class="form-floating mb-3">
										<select class="form-select" name="user_level" id="user" aria-label="Floating label select example" required>
											<option value="5" selected <?php if (uri(2) == "edit") echo $edit->user_level == 5 ? "selected" : ""; ?>>Kasir</option>
										</select>
										<label for="example-select-floating">Level</label>
									</div>
								<?php } else { ?>
									<div class="form-floating mb-3">
										<?php if ($this->user_level == 1) : ?>
											<select class="form-select" name="user_level" id="user" aria-label="Floating label select" required>
												<option value="">Pilih Level</option>
												<option value="1" <?php if (uri(2) == "edit") echo $edit->user_level == 1 ? "selected" : ""; ?>>IT</option>
												<option value="2" <?php if (uri(2) == "edit") echo $edit->user_level == 2 ? "selected" : ""; ?>>Manajemen</option>
												<option value="3" <?php if (uri(2) == "edit") echo $edit->user_level == 3 ? "selected" : ""; ?>>Supplier</option>
												<option value="4" <?php if (uri(2) == "edit") echo $edit->user_level == 4 ? "selected" : ""; ?>>Toko</option>
												<option value="5" <?php if (uri(2) == "edit") echo $edit->user_level == 5 ? "selected" : ""; ?>>Kasir</option>
											</select>
										<?php elseif ($this->user_level == 2) : ?>
											<select class="form-select" name="user_level" id="user" aria-label="Floating label select" required>
												<option value="">Pilih Level</option>
												<option value="2" <?php if (uri(2) == "edit") echo $edit->user_level == 2 ? "selected" : ""; ?>>Manajemen</option>
												<option value="3" <?php if (uri(2) == "edit") echo $edit->user_level == 3 ? "selected" : ""; ?>>Supplier</option>
												<option value="4" <?php if (uri(2) == "edit") echo $edit->user_level == 4 ? "selected" : ""; ?>>Toko</option>
												<option value="5" <?php if (uri(2) == "edit") echo $edit->user_level == 5 ? "selected" : ""; ?>>Kasir</option>
											</select>
										<?php endif; ?>
										<label for="example-select-floating">Level</label>
									</div>
								<?php } ?>
								<div class="nano d-none">
									<div class="form-floating mb-3">
										<select class="form-select" name="prov" id="prov" aria-label="Floating label select example">
											<option value="">Pilih Provinsi</option>
											<?php foreach ($data as $d) { ?>
												<option value="<?= $d->prov_id; ?>" <?php if (uri(2) == "edit") echo $edit->id_prop == $d->prov_id ? "selected" : ""; ?>><?php echo $d->prov_name; ?></option>
											<?php } ?>
										</select>
										<label for="example-select-floating">Provinsi</label>
									</div>
									<div class="form-floating mb-3">
										<select class="form-select" name="kota" id="kota" aria-label="Floating label select example">
											<option value="">Pilih Kota</option>
										</select>
										<label for="example-select-floating">Kota</label>
									</div>
									<div class="form-floating mb-3">
										<select class="form-select" name="kec" id="kec" aria-label="Floating label select example">
											<option value="">Pilih Kecamatan</option>
										</select>
										<label for="example-select-floating">Kecamatan</label>
									</div>
									<div class="form-floating mb-3">
										<select class="form-select" name="desa" id="desa" aria-label="Floating label select example">
											<option value="">Pilih Desa</option>
										</select>
										<label for="example-select-floating">Desa</label>
									</div>

									<div class="form-floating mb-3">
										<textarea name="des" class="form-control"><?php echo (uri(2) == "edit") ? $edit->lengkap : ""; ?></textarea>
										<label for="example-select-floating">Alamat lengkap</label>
									</div>
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary"><?php echo (uri(2) == 'edit') ? 'Update' : 'Tambah'; ?></button>
									<?php if (uri(2) == "edit") { ?>
										<button type="button" class="btn btn-outline-danger" onclick="window.location='<?php echo base_url(uri(1)); ?>'">Batal</button>
									<?php } ?>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Daftar Pengguna</h4>

							<div class="table-responsive">
								<table class="table table-striped table-hover dataTable">
									<thead>
										<tr>
											<th style="width:200px">Username</th>
											<th>Nama</th>
											<th style="width:140px">Level</th>
											<th style="width:100px"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($data_user) {
											foreach ($data_user as $d) {
										?>
												<tr style="vertical-align:middle">
													<td><?php echo $d->user_nama; ?></td>
													<td><?php echo $d->user_namalengkap; ?></td>
													<td><?php echo level_user($d->user_level); ?></td>
													<td>
														<div class="btn-group">
															<a href="<?php echo url(1) . '/edit/' . enkrip($d->user_id); ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
																<i class="fa fa-user-edit"></i>
															</a>

															<?php if ($this->user_nama != $d->user_nama) { ?>
																<a href="<?php echo url(1) . '/hapus/' . enkrip($d->user_id); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus User">
																	<i class="fa fa-user-times"></i>
																</a>
															<?php } ?>
														</div>
													</td>
												</tr>
											<?php }
										} else { ?>
											<tr>
												<td class="text-center" colspan="4">Tidak ada data</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/backend'); ?>/js/vendor.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var segments = "<?php echo uri(2); ?>"
		var user = $('#user').val();
		if (user == 4 && segments == 'edit') {
			$('.nano').removeClass('d-none');
		}

		$('#user').change(function() {
			var id = $(this).val();
			if (id == 4) {
				$('.nano').removeClass('d-none');
			} else {
				$('.nano').addClass('d-none');
			}
		});

		$('#prov').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo base_url(); ?>user/get_kota?id=" + id,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += "<option value='" + data[i].city_id + "'>" + data[i].city_name + "</option>";
					}
					$('#kota').html(html);
				}
			});
		});

		$('#kota').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo base_url(); ?>user/get_kec?id=" + id,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += "<option value='" + data[i].dis_id + "'>" + data[i].dis_name + "</option>";
					}
					$('#kec').html(html);
				}
			});
		});
		$('#kec').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo base_url(); ?>user/get_des?id=" + id,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += "<option value='" + data[i].subdis_id + "'>" + data[i].subdis_name + "</option>";
					}
					$('#desa').html(html);
				}
			});
		});
	});
</script>