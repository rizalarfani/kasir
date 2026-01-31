<script>
	function show_alert() {
		if (!confirm("Do you really want to do this?")) {
			return false;
		}
		this.form.submit();
	}
</script>
<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Tambah Pesanan</h4>
							<?php echo form_open(base_url('inventaris/add_proses')); ?>
							<div class="row">
								<div class="col-md-5">
									<div class="form-floating mb-3">
										<select class="form-select" name="produk" id="produk" aria-label="Floating label select example" required>
											<option value="">Pilih</option>
											<?php
											foreach ($data as $d) { ?>
												<option value="<?php echo $d->id; ?>" stok="<?= $d->stok; ?>"><?php echo $d->name; ?></option>
											<?php } ?>
										</select>
										<label for="example-select-floating">Pilih produk</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-floating mb-3">
										<input class="form-control" type="number" id="hrg" name="harga" readonly>
										<input class="form-control" type="hidden" id="idhrg" name="idharga">

										<label for="example-select-floating">Harga</label>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-floating mb-3">
										<input class="form-control" type="number" id="stok" name="stok" readonly>
										<label for="example-select-floating">Stok</label>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-floating mb-3">
										<input class="form-control" type="number" id="qty" name="qty">
										<label for="example-select-floating">QTY</label>
									</div>
								</div>
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-primary">Tambah</button>
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
								<table class="table table-hover ">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Barang</th>
											<th>QTY</th>
											<th>Harga</th>
											<th>Total</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$t_qty = [];
										$t_jml = [];
										// echo $this->db->last_query();

										// 										var_dump($data);
										// 										die();
										if ($dt) {
											foreach ($dt as $d) {
												$t_qty[] = $d->order_qty;
												$t_jml[] = $d->total;

										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->name; ?></td>
													<td><?php echo $d->order_qty; ?></td>
													<td><?php echo format_rupiah($d->jual); ?></td>
													<td><?php echo format_rupiah($d->total); ?></td>
													<td>
														<div class="btn-group">


															<a href="<?php echo url(1) . '/hapus/' . enkrip($d->id); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
																<i class="fa fa-user-times"></i>
															</a>
														</div>
													</td>
												</tr>
											<?php }
										} else { ?>
											<tr>
												<td class="text-center" colspan="9">Tidak ada data</td>
											</tr>
										<?php } ?>
									</tbody>
									<?php if ($data) { ?>
										<tfoot>
											<tr>
												<th colspan="2">
												</th>
												<th>
													<?= array_sum($t_qty); ?>
												</th>
												<th></th>
												<th>
													<?= format_rupiah(array_sum($t_jml)); ?>
												</th>
												<th></th>
											</tr>


											<tr>

												<th colspan="6">
													<?php echo form_open(base_url('pembelian/add_post')); ?>
													<div class="row">
														<div class="col-md-6">
															<div class="form-floating mb-3">
																<input class="form-control" type="text" id="an" name="nama" required>
																<label for="example-select-floating">AN</label>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-floating mb-3">
																<input class="form-control" type="datetime-local" id="date" name="tgl" required>
																<label for="example-select-floating">Tanggal</label>
																<input type="hidden" name="total" value="<?= array_sum($t_jml); ?>">
																<input type="hidden" name="item" value="<?= array_sum($t_qty); ?>">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating mb-3 ">
															<input class="form-control" type="number" name="byr" required>
															<label for="example-select-floating">Bayar</label>
														</div>
													</div>
													<hr>
													<button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-lg btn-warning float-end ">Order</button>
													<?php echo form_close(); ?>
												</th>

											</tr>
										</tfoot>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script src="<?php echo base_url('assets/backend'); ?>/js/vendor.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#produk').change(function() {

			var id = $(this).val();
			$.ajax({
				url: "<?php echo base_url(); ?>pembelian/get_harga?id=" + id,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					$('#hrg').val(data.jual);
					$('#idhrg').val(data.id);

				}
			});

			$.ajax({
				url: "<?php echo base_url(); ?>pembelian/get_stoks?id=" + id,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					$('#stok').val(data);
				}
			});
		});
	});
</script>