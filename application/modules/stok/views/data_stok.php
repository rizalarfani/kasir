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
								<table id="example" class="table table-hover dataTable">
									<thead>
										<tr>
											<th>No</th>
											<th>Cabang/Toko</th>
											<th>Nama Barang</th>
											<th>Masuk</th>
											<th>Keluar</th>
											<th>Retur</th>
											<th>Akhir</th>
											<!-- <th>Aksi</th> -->
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										if ($data) {
											foreach ($data as $d) {
												$keluar =  $this->M_stok->laku($d->ids, $d->user_id);
										?>
												<tr style="vertical-align:middle">
													<td><?php echo $no++; ?></td>
													<td><?php echo $d->user_namalengkap; ?></td>
													<td><?php echo $d->name; ?></td>
													<td><?php echo $d->masuk; ?></td>
													<td><?php echo $keluar->stok; ?></td>
													<td><?php echo $d->retur; ?></td>
													<td><?php echo $d->masuk - $keluar->stok; ?></td>
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

<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#example").dataTable().fnDestroy();
		$('#example').DataTable({
			order: [
				[6, 'asc']
			],
		});
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