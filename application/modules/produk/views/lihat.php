<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Detail</h4>

							<div class="form-floating mb-3">
								<input readonly type="text" class="form-control" name="nama" value="<?php echo $edit->name; ?>" placeholder="Nama Barang" autocomplete="off">
								<label>Nama Barang</label>
							</div>
							<div class="form-floating mb-3">
								<input readonly type="text" class="form-control" name="nama" value="<?php echo $edit->kode_barang; ?>" placeholder="Nama Barang" autocomplete="off">
								<label>Kode Barang</label>
							</div>

							<div class="form-floating mb-3">
								<select disabled class="form-select" name="kat" aria-label="Floating label select example" required>
									<option value="">Pilih</option>
									<?php foreach ($kat as $k) {	?>
										<?php $ka = uri(2) == "edit" ? $edit->category_id : ""; ?>
										<option value="<?= $k->id; ?>" <?php echo ($ka = $k->id) ? 'selected' : ''; ?>><?= $k->name; ?></option>
									<?php } ?>
								</select>
								<label for="example-select-floating">Kategori</label>
							</div>
							<div class="form-floating mb-3">
								<textarea readonly name="des" class="form-control"><?php echo $edit->description; ?></textarea>
								<label for="example-select-floating">Deskripsi</label>
							</div>


							<div class="text-center">
								<button type="button" class="btn btn-outline-warning" onclick="window.location='<?php echo base_url('produk/edit/' . enkrip($edit->id)); ?>'">Edit</button>
							</div>
							</form>
						</div>
					</div>
				</div>

				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Daftar Harga Update</h4>

							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th style="text-align:right">Harga Beli</th>
											<th style="text-align:right">Harga Jual</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										if ($harga) {
											foreach ($harga as $d) {
										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->add_date; ?></td>
													<td style="text-align:right"><?php echo $this->M_Universal->format_rupiah($d->hpp); ?></td>
													<td style="text-align:right"><?php echo $this->M_Universal->format_rupiah($d->jual); ?></td>
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
				url: "<?php echo base_url(); ?>User/get_kota?id=" + id,
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
				url: "<?php echo base_url(); ?>User/get_kec?id=" + id,
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
				url: "<?php echo base_url(); ?>User/get_des?id=" + id,
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