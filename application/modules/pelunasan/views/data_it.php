<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<!-- <div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Cari laporan</h4>
							<?php echo form_open(base_url('pelunasan')); ?>
							<div class="row">
								<div class="col-md-4">
									<div class="form-floating mb-3">
										<input class="form-control" type="date" name="awal" required>
										<label for="example-select-floating">Tanggal Awal</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-floating mb-3">
										<input class="form-control" type="date" name="akhir" required>
										<label for="example-select-floating">Tanggal Akhir</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-floating mb-3">
									<select class="form-select" name="status" aria-label="Floating label select example">
										<option value="">Semua</option>
										<option value="1">Lunas</option>
										<option value="0">Belum Lunas</option>
									</select>
										<label for="example-select-floating">Status</label>
									</div>
								</div>
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-primary">Cari</button>
							</div>
							</form>
						</div>
					</div>
				</div> -->

				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?= $keterangan; ?></h4>
							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>CodePay</th>
											<th>Total</th>
											<th>Waktu</th>
											<th>Status</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;

										if ($data) {
											foreach ($data as $d) { ?>

												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?= $d->code_pay; ?></td>
													<td><?php echo format_rupiah($d->total); ?></td>
													<td><?php echo $d->date_created; ?></td>
													<td><?= ($d->status == 0) ? 'belum lunas' : 'lunas'; ?></td>
													<td>
														<div class="btn-group">
															<?php if (uri(2) == 'it') {

																$this->db->where('code_pay', $d->code_pay);
																$kon = $this->db->get('stok_out')->row();

																if ($kon != '') { ?>
																	<a href="<?php echo url(1) . '/lihat/' . enkrip($d->code_pay) . '/it'; ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat data">
																		<i class="fa fa-eye"></i>
																	</a>
																<?php } else { ?>
																	<a href="<?php echo url(1) . '_inven/lihat/' . enkrip($d->code_pay) . '/it'; ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat data">
																		<i class="fa fa-eye"></i>
																	</a>
																<?php } ?>


															<?php	} else { ?>
																<a href="<?php echo url(1) . '/lihat/' . enkrip($d->code_pay); ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat data">
																	<i class="fa fa-eye"></i>
																</a>
															<?php } ?>

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