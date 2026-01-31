<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Cari laporan</h4>
							<?php echo form_open(base_url('pelunasan/generate_it')); ?>
							<div class="row">
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
								<?php echo form_open(base_url('pelunasan/lunasi')); ?>


								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>Code pay</th>
											<th>Total</th>
											<th>Waktu</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$t_jml = [];
										if ($data) {
											foreach ($data as $d) {
												$t_jml[] = $d->total;
										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->code_pay; ?></td>
													<td class="text-end"><?php echo format_rupiah($d->total); ?></td>
													<td><?= $d->last_update; ?></td>
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

												<th class="text-end">
													<?= format_rupiah(array_sum($t_jml)); ?>
												</th>

												<th>
													<?php foreach ($data as $t) {; ?>
														<input type="hidden" name="code[]" value="<?php echo $t->code_pay; ?>">
													<?php } ?>
													<input type="hidden" name="id" value="1">
													<button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin?')">Lunasi</button>
												</th>
											</tr>
										</tfoot>
									<?php } ?>
								</table>
								<?php echo form_close(); ?>

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
	});
</script>