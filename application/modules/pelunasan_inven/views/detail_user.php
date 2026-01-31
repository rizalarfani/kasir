<div class="content-page">
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<?php
				if ($mitra) {
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
														if ($cek_admin->status == 0 && $this->user_level == 2) { ?>
															<?php echo form_open(base_url('Pelunasan/lunasi')); ?>
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
				<?php
				if ($toko) {
					foreach ($toko as $o) { ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<h3 class="header-title mb-3"><?= $o->user_namalengkap; ?></h3>
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
												$data = $this->M_pelunasan->get_detail_toko($code, $o->user_id);
												if ($data) {
													foreach ($data as $index => $d) {
														$hpp[] = $d->total;
														$qty[] = $d->qty;
												?>
														<tr>
															<td><?php echo $no++; ?></td>
															<td><?php echo $d->name; ?></td>
															<td><?php echo format_rupiah($d->toko); ?></td>
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
														$cek_admin = $this->M_pelunasan->cek_pelunasan($code, $o->user_id);

														if ($cek_admin->status == 0  && $this->user_level == 2) { ?>
															<?php echo form_open(base_url('Pelunasan/lunasi')); ?>
															<input type="hidden" name="code" value="<?php echo $code; ?>">
															<input type="hidden" name="id" value="<?php echo $o->user_id; ?>">
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

				<?php if ($it) { ?>
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
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</div>