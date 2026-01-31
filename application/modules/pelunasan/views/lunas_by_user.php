<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?= $keterangan; ?></h4>

							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>Code Pay</th>
											<th>Total</th>
											<th>Ket.</th>
											<th>Status</th>
											<th>Waktu</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										if ($data) {
											foreach ($data as $d) {
												$url = ($d->is_inven == 0) ? 'pelunasan' : 'pelunasan_inven';

										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->code_pay; ?></td>
													<td class="text-end"><?php echo format_rupiah($d->total); ?></td>
													<td><?php echo $d->keterangan; ?></td>
													<td>
														<?php echo ($d->status == 1) ? 'lunas' : 'belum'; ?>
													</td>
													<td><?= $d->last_update; ?></td>
													<td><a href="<?php echo base_url($url) . '/lihat_by_user/' . enkrip($d->code_pay); ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat data">
															<i class="fa fa-eye"></i>
														</a></td>
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