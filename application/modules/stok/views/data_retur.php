<div class="content-page">
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?= $keterangan; ?></h4>
							<a href="<?= base_url('stok/add_retur'); ?>" class="btn btn-primary">Tambah</a>
							<hr>
							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>Supplier</th>
											<th>Nama Barang</th>
											<th>QTY</th>
											<th>Alasan</th>
											<th>Status</th>
											<th>Tanggal</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										if ($data) {
											foreach ($data as $d) {
										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->user_namalengkap; ?></td>
													<td><?php echo $d->name; ?></td>
													<td><?php echo $d->qty; ?></td>
													<td><?php echo $d->ket; ?></td>
													<td><?php echo $d->status; ?></td>
													<td><?php echo $d->date_created; ?></td>
													<td></td>
												</tr>
										<?php }
										} ?>
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