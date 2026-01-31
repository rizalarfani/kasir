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
												? base_url('stok/update') : base_url('stok/tambah'); ?>" method="POST" autocomplete="off">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="hrg" id="hrg">

								<div class="form-floating mb-3">
									<select class="form-select" name="toko" id="toko_id" aria-label="Floating label select example" required>
										<option value="">Pilih</option>
										<?php
										foreach ($toko as $t) { ?>
											<option value="<?= $t->user_id; ?>" <?php if (uri(2) == "edit" || $this->input->get('id') != null) echo $this->input->get('id') == $t->user_id ? "selected" : ""; ?>><?= $t->user_namalengkap; ?></option>
										<?php } ?>
									</select>
									<label for="example-select-floating">Nama Toko</label>
								</div>
								<div class="row">
									<div class="col-md-6">

										<div class="form-floating mb-3">
											<select class="form-select" name="produk" id="produk" aria-label="Floating label select example" required>
												<option value="">Pilih</option>
												<?php foreach ($data as $t) { ?>
													<option value="<?= $t->id; ?>"><?= $t->name; ?></option>
												<?php } ?>
											</select>
											<label for="example-select-floating">Produk</label>
										</div>
									</div>
									<div class="col-md-6">

										<div class="form-floating mb-3">
											<select class="form-select" name="mitra" id="mitra" aria-label="Floating label select example" required>
												<option value="">Pilih</option>
												<?php foreach ($suplier as $t) { ?>
													<option value="<?= $t->user_id; ?>"><?= $t->user_namalengkap; ?></option>
												<?php } ?>
											</select>
											<label for="example-select-floating">Supplier</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-floating mb-3">
											<input type="number" class="form-control" readonly name="awal" id="awal" autocomplete="off">
											<label>Stok Awal</label>
										</div>
									</div>
									<div class="col-md-6">

										<div class="form-floating mb-3">
											<input type="number" class="form-control" name="qty" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" required autocomplete="off">
											<label>QTY</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-floating mb-3">
											<input type="number" class="form-control" name="h_mitra" id="h_mitra" autocomplete="off" required>
											<label>HPP (MITRA)</label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" name="h_pt" id="h_pt" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" readonly autocomplete="off">
											<label>HRG. (MANAJEMEN)</label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" name="h_tk" id="h_tk" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" readonly autocomplete="off">
											<label>HRG. (Konsumen)</label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-floating mb-3">
											<input type="text" class="form-control" name="h_it" id="h_it" value="<?php echo uri(2) == "edit" ? $edit->user_nama : ""; ?>" readonly autocomplete="off">
											<label>HRG. (IT)</label>
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

				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?= $keterangan; ?></h4>

							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Barang</th>
											<th>QTY</th>
											<th>Mitra</th>
											<th>Hpp</th>
											<th>Hrg. Manajemen</th>
											<th>Hrg. IT</th>
											<th>Hrg. Toko</th>
											<th>Hrg. Konsumen</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$t_qty = [];
										if ($data_tampil) {
											foreach ($data_tampil as $d) {
												$mitra	= $this->M_Universal->getOne(["user_id" => $d->id_mitra], "user");
												$t_qty[] = $d->jumlah;
										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->name; ?></td>
													<td><?php echo $d->jumlah; ?></td>
													<td><?php echo $mitra->user_namalengkap; ?></td>
													<td><?php echo format_rupiah($d->hpp); ?></td>
													<td><?php echo format_rupiah($d->manajemen); ?></td>
													<td><?php echo format_rupiah($d->it); ?></td>
													<td><?php echo format_rupiah($d->toko); ?></td>
													<td><?php echo format_rupiah($d->jual); ?></td>
													<td>
														<div class="btn-group">
															<!-- <a href="<?php echo url(1) . '/edit/' . enkrip($d->id); ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Kategori">
																<i class="fa fa-user-edit"></i>
															</a> -->

															<a href="<?php echo url(1) . '/hapus/' . enkrip($d->id); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
																<i class="fa fa-user-times"></i>
															</a>
														</div>
													</td>
												</tr>
											<?php }
										} else { ?>
											<tr>
												<td class="text-center" colspan="10">Tidak ada data</td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="10" class="text-center">
												<a href="<?php echo base_url('stok/simpan?id=' . $this->input->get('id')); ?>" class="btn btn-lg btn-warning text-lg-center" onclick="return confirm('Apakah Anda yakin?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Simpan semua data">
													Simpan Semua Data
												</a>
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var itnya = '<?php echo $it->nominal; ?>';
		var segments = "<?php echo uri(2); ?>"
		var user = $('#user').val();
		if (user == 4 && segments == 'edit') {
			$('.nano').removeClass('d-none');
		}

		$('#produk').change(function() {
			var id = $(this).val();
			var toko = $('#toko_id').val();
			$.ajax({
				url: "<?php echo base_url(); ?>stok/get_stok_awal?id_product=" + id + "&id_tok=" + toko,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					if (data['awal'].stok == null) {
						var stok = 0
					} else {
						var stok = data['awal'].stok;
					}
					$('#awal').val(stok);
				}
			});
		});

		$('#mitra').change(function() {
			var id = $('#produk').val();
			$.ajax({
				url: "<?php echo base_url(); ?>stok/get_stok_awal_mitra?id=" + id + "&id_tok=" + toko + "&id_mit=" + mitra,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					$('#h_mitra').val(0);
					$('#hrg').val(data['hpp'].id);
					$('#h_pt').val(data['hpp'].manajemen);
					$('#h_tk').val(data['hpp'].jual);
					$('#h_it').val(data['hpp'].it);
				}
			});
		});
	});
</script>