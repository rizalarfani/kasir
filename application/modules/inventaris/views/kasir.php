<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Cari laporan</h4>
							<?php echo form_open(base_url('inventaris/data')); ?>
							<div class="row">
								<div class="col-md-6">
									<div class="form-floating mb-3">
										<input class="form-control" type="date" name="awal" required>
										<label for="example-select-floating">Tanggal Awal</label>
									</div>
								</div>
								<div class="col-md-6">

									<div class="form-floating mb-3">
										<input class="form-control" type="date" name="akhir" required>
										<label for="example-select-floating">Tanggal Akhir</label>
									</div>
								</div>
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-primary">Cari</button>
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
											<th>Order ID</th>
											<th>Nama</th>
											<th>QTY</th>
											<th>Waktu</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$t_qty = [];
										if ($data) {
											foreach ($data as $d) {
												$t_qty[] = $d->total;
												$t_jml[] = $d->total_price;

										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?= $d->order_number; ?></td>
													<td><?php echo $d->user_namalengkap; ?></td>
													<td><?php echo $d->total; ?></td>
													<td><?= $d->last_update; ?></td>
													<td>
														<div class="btn-group">
															<a href="<?php echo url(1) . '/detail/' . enkrip($d->order_number); ?>" class="btn btn-xs btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak">
																<i class="fa fa-print"></i>
															</a>
														</div>
													</td>
												</tr>
											<?php }
										} else { ?>
											<tr>
												<td class="text-center" colspan="8">Tidak ada data</td>
											</tr>
										<?php } ?>
									</tbody>
									<?php if ($data) { ?>
										<tfoot>
											<tr>
												<th colspan="3">
												</th>
												<th>
													<?= array_sum($t_qty); ?>
												</th>
												<th colspan="3">

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
		var segments = "<?php echo uri(2); ?>"
		var user = $('#user').val();
		if (user == 4 && segments == 'edit') {
			$('.nano').removeClass('d-none');
		}


		$('#produk').change(function() {
			var id = $(this).val();
			var toko = $('#toko').val();
			$.ajax({
				url: "<?php echo base_url(); ?>stok/get_stok_awal?id=" + id + "&id_tok=" + toko,
				method: "get",
				async: false,
				dataType: 'json',
				success: function(data) {
					$('#awal').val(data.stok);
				}
			});
		});
	});
</script>