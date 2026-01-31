<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?php echo (uri(2) == 'edit') ? 'Edit' : 'Tambah'; ?> Kategori</h4>

							<form action="<?php echo uri(2) == "edit" ? url(1, "update") : url(1, "tambah"); ?>" method="POST" autocomplete="off">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="user_id" value="<?php echo uri(2) == "edit" ? enkrip($edit->id) : ""; ?>">

								<div class="form-floating mb-3">
									<input type="text" class="form-control" name="nama" value="<?php echo uri(2) == "edit" ? $edit->name : ""; ?>" placeholder="Nama kategori" autocomplete="off">
									<label>Nama Kategori</label>
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

				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3">Daftar Kategori</h4>

							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Kategori</th>
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
													<td><?php echo $d->name; ?></td>
													<td>
														<div class="btn-group">
															<a href="<?php echo url(1) . '/edit/' . enkrip($d->id); ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Kategori">
																<i class="fa fa-user-edit"></i>
															</a>

															<a href="<?php echo url(1) . '/hapus/' . enkrip($d->id); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
																<i class="fa fa-user-times"></i>
															</a>
														</div>
													</td>
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