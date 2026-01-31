<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?php echo (uri(2) == 'edit') ? 'Edit' : 'Tambah'; ?> <?= $judul; ?></h4>

							<form action="<?php echo (uri(2) == "edit")
												? base_url('stok/update') : base_url('stok/add_retur_proses'); ?>" method="POST" autocomplete="off">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

								<!-- <div class="form-floating mb-3">
									<select class="form-select" name="toko" id="toko" aria-label="Floating label select example" required>
										<option value="">Pilih</option>
										<?php
										foreach ($toko as $t) { ?>
											<option value="<?= $t->user_id; ?>" <?php if (uri(2) == "edit" || $this->input->get('id') != null) echo $this->input->get('id') == $t->user_id ? "selected" : ""; ?>><?= $t->user_namalengkap; ?></option>
										<?php } ?>
									</select>
									<label for="example-select-floating">Nama Toko</label>
								</div> -->
								<div class="row">
									<div class="col-md-6">

										<div class="form-floating mb-3">
											<select class="form-select" name="produk" id="produk" aria-label="Floating label select example" required>
												<option value="">Pilih</option>
												<?php foreach ($data as $t) { ?>
													<option value="<?= $t->ids; ?>"><?= $t->name; ?></option>
												<?php } ?>
											</select>
											<label for="example-select-floating">Produk</label>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-floating mb-3">
											<select class="form-select" name="tgl" id="tgl" aria-label="Floating label select example" required>
											</select>
											<label for="example-select-floating">Stok Tanggal</label>
										</div>
									</div>
								</div>
								<div class="row">
									<!-- <div class="col-md-6">
										<div class="form-floating mb-3">
											<input type="number" class="form-control" readonly name="awal" id="awal" autocomplete="off">
											<label>Stok Awal</label>
										</div>
									</div> -->
									<div class="col-md-6">

										<div class="form-floating mb-3">
											<input type="number" class="form-control" name="qty" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" required autocomplete="off">
											<label>QTY</label>
										</div>
									</div>
									<div class="col-md-6">

										<div class="form-floating mb-3">
											<input type="text" class="form-control" name="ket" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" required autocomplete="off">
											<label>Keterangan</label>
										</div>
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


		$('#produk').change(function() {
			var id = $(this).val();
			
			var toko = <?php echo $this->user_id;?>;
			var toko= 7;
			$.ajax({
				url: "<?php echo base_url(); ?>stok/get_stok_tgl?id=" + id + "&id_tok=" + toko,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += "<option value='" + data[i].id + "'>" + data[i].last_update + "</option>";
					}
					$('#tgl').html(html);
				}
			});
		});
	});
</script>