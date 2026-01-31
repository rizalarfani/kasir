<div class="content-page">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title mb-3"><?php echo (uri(2) == 'edit') ? 'Edit' : 'Tambah'; ?> <?= $keterangan; ?></h4>

							<form action="<?php echo uri(2) == "edit" ? url(1, "update") : url(1, "tambah"); ?>" method="POST" autocomplete="off">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="id" value="<?php echo uri(2) == "edit" ? enkrip($edit->id) : ""; ?>">

								<div class="form-floating mb-3">
									<input type="text" class="form-control" name="nama" value="<?php echo uri(2) == "edit" ? $edit->name : ""; ?>" placeholder="Nama Barang" autocomplete="off">
									<label>Nama Barang</label>
								</div>

								<div class="form-floating mb-3">
									<select class="form-select select" name="kat" required>
										<option value="">Pilih Kategori</option>
										<?php foreach ($kat as $k) {	?>
											<?php $ka = uri(2) == "edit" ? $edit->category_id : ""; ?>
											<option value="<?= $k->id; ?>" <?php echo ($ka == $k->id) ? 'selected' : ''; ?>><?= $k->name; ?></option>
										<?php } ?>
									</select>
								</div>



								<div class="form-floating form-control mb-3">
									<p class="example-select-floating">Produk Toko</p>
									<?php $ya = uri(2) == "edit" ? $edit->is_inven : ""; ?>

									<div class="form-check form-check-inline">
										<input class="form-check-input" <?php echo ($ya == 1) ? 'checked' : ''; ?> type="radio" name="inv" id="inlineRadio1" value="1">
										<label class="form-check-label" for="inlineRadio1">Ya</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" <?php echo ($ya == 0) ? 'checked' : ''; ?> name="inv" id="inlineRadio2" value="0">
										<label class="form-check-label" for="inlineRadio2">Tidak</label>
									</div>
								</div>

								<div class="form-floating mb-3">
									<input type="text" class="form-control" name="jual" value="<?php echo uri(2) == "edit" ? $edit->jual : ""; ?>" placeholder="Hpp" autocomplete="off" required>
									<label>Harga Jual Konsumen</label>
								</div>

								<div class="form-floating mb-3">
									<input type="text" class="form-control" id='toko' name="toko" value="<?php echo uri(2) == "edit" ? $edit->manajemen : ""; ?>" placeholder="NHarga jual" autocomplete="off" required>
									<label>Harga Manajemen</label>
								</div>
								<div class="form-floating mb-3">
									<input type="text" class="form-control" id='per_it' name="per_it" value="<?php echo uri(2) == "edit" ? $edit->persentase_it : ""; ?>" placeholder="% Harga jual" autocomplete="off" required>
									<label>% IT</label>
								</div>

								<div class="form-floating mb-3">
									<input type="text" class="form-control" id='it' name="it" value="<?php echo uri(2) == "edit" ? $edit->it : ""; ?>" placeholder="NHarga jual" autocomplete="off" required>
									<label>Harga IT</label>
								</div>


								<div class="form-floating mb-3">
									<textarea name="des" class="form-control"><?php echo uri(2) == "edit" ? $edit->description : ""; ?></textarea>
									<label for="example-select-floating">Deskripsi</label>
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
							<h4 class="header-title mb-3">Daftar <?= $keterangan; ?></h4>

							<div class="table-responsive">
								<table class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama</th>
											<th>Kode</th>
											<th>Kategori</th>
											<th style="text-align:right">Harga Jual</th>
											<th style="text-align:right">Harga IT</th>
											<th>Sedia</th>
											<th style="width:100px">Aksi</th>
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
													<td><?php echo $d->kode_barang; ?></td>
													<td><?php echo $d->kat; ?></td>
													<td style="text-align:right"><?php echo format_rupiah($d->jual) ?></td>
													<td style="text-align:right"><?php echo format_rupiah($d->it) ?></td>
													<td><?php echo ($d->is_available == 1) ? 'Ya' : 'Tidak'; ?></td>
													<td>
														<div class="btn-group">
															<a href="<?php echo url(1) . '/edit/' . enkrip($d->id); ?>" class="btn btn-xs btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
																<i class="fa fa-edit"></i>
															</a>

															<a href="<?php echo url(1) . '/hapus/' . enkrip($d->id); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
																<i class="fa fa-times"></i>
															</a>

															<!-- <a href="<?php echo url(1) . '/lihat/' . enkrip($d->id); ?>" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
																<i class="fa fa-eye"></i>
															</a> -->
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
<script src="<?php echo base_url('assets/backend'); ?>/js/vendor.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$("#per_it").on("keyup change", function(e) {
			var id = $(this).val();
			if (id != 0) {
				var toko = $('#toko').val();
				var hasil = parseInt(toko * (id / 100));
				$('#it').val(hasil);
			}
		})
	});
</script>