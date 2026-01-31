<div class="content-page">
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<?php

				if ($mitra && uri(4) != 'it') {
					foreach ($mitra as $u) { ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<h3 class="header-title mb-3"><?= $u->user_namalengkap; ?></h3>
									<div class="table-responsive">
										<table class="table table-hover">
											<thead>
												<tr>
													<th>No</th>
													<th>Item</th>
													<th>Nominal</th>
													<th>QTY</th>
													<th>Total</th>
													<th>Tanggal</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												$hpp = [];
												$qty = [];
												$data = $this->M_pelunasan->get_detail_mitra($code, $u->user_id);
												if ($data) {
													foreach ($data as $index => $d) {
														$hpp[] = $d->total;
														$qty[] = $d->qty;
												?>
														<tr style="vertical-align:middle">
															<td><?php echo $no++; ?></td>
															<td><?php echo $d->name; ?></td>
															<td><?php echo format_rupiah($d->hpp); ?></td>
															<td><?php echo $d->qty; ?></td>
															<td><?php echo format_rupiah($d->total); ?></td>
															<td><?= $d->last_update; ?></td>
														</tr>
													<?php } ?>
											<tfoot>
												<tr>
													<th></th>
													<th></th>
													<th></th>
													<th><?= array_sum($qty); ?></th>
													<th><?= format_rupiah(array_sum($hpp)); ?></th>
													<th>
														<?php
														$cek_admin = $this->M_pelunasan->cek_pelunasan($code, $u->user_id);
														if ($cek_admin->status != 1) { ?>
															<?php echo form_open(base_url('Pelunasan_inven/lunasi')); ?>
															<input type="hidden" name="code" value="<?php echo $code; ?>">
															<input type="hidden" name="id" value="<?php echo $u->user_id; ?>">
															<button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin?')">Lunasi</button>
															<?php echo form_close(); ?>
														<?php } else { ?>
															Lunas : <?= $cek_admin->last_update; ?>
														<?php } ?>
													</th>
												</tr>
											</tfoot>
										<?php } else { ?>
											<tr>
												<td class="text-center" colspan="9">Tidak ada data</td>
											</tr>
										<?php } ?>
										</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
				<?php }
				} ?>



				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h3 class="header-title mb-3">IT</h3>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>NO</th>
											<th>Item</th>
											<th>Nominal</th>
											<th>QTY</th>
											<th>Total</th>
											<th>Tanggal</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
										$hpp = [];
										$qty = [];
										$data = $this->M_pelunasan->get_detail_it($code);
										if ($data) {
											foreach ($data as $index => $d) {
												$hpp[] = $d->total;
												$qty[] = $d->qty;
										?>
												<tr>
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->name; ?></td>
													<td><?php echo format_rupiah($d->it); ?></td>
													<td><?php echo $d->qty; ?></td>
													<td><?php echo format_rupiah($d->total); ?></td>
													<td><?= $d->last_update; ?></td>

												</tr>
											<?php } ?>
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th><?= array_sum($qty); ?></th>
											<th><?= format_rupiah(array_sum($hpp)); ?></th>
											<th>

											</th>
										</tr>
									</tfoot>
								<?php } else { ?>
									<tr>
										<td class="text-center" colspan="9">Tidak ada data</td>
									</tr>
								<?php } ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<?php if (uri(4) != 'it') { ?>

					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<h3 class="header-title mb-3">HFC</h3>
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>NO</th>
												<th>Item</th>
												<th>Nominal</th>
												<th>QTY</th>
												<th>Total</th>
												<th>Tanggal</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											$hpp = [];
											$qty = [];
											$data = $this->M_pelunasan->get_detail_hfc($code);
											if ($data) {
												foreach ($data as $index => $d) {
													$hpp[] = $d->total;
													$qty[] = $d->qty;
											?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $d->name; ?></td>
														<td><?php echo format_rupiah($d->manajemen); ?></td>
														<td><?php echo $d->qty; ?></td>
														<td><?php echo format_rupiah($d->total); ?></td>
														<td><?= $d->last_update; ?></td>

													</tr>
												<?php } ?>
										<tfoot>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th><?= array_sum($qty); ?></th>
												<th><?= format_rupiah(array_sum($hpp)); ?></th>
												<th>

												</th>
											</tr>
										</tfoot>
									<?php } else { ?>
										<tr>
											<td class="text-center" colspan="9">Tidak ada data</td>
										</tr>
									<?php } ?>
									</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</div>

<!--  +<script
  src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
  integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA="
  crossorigin="anonymous"></script>
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