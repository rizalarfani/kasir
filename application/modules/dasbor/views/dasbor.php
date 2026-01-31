<div class="content-page">
	<div class="content">

		<!-- Start Content-->
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h4 class="header-title"><?= $keterangan; ?></h4>
							<div class="chartjs-chart">
								<div class="chartjs-size-monitor">
									<div class="chartjs-size-monitor-expand">
										<div class=""></div>
									</div>
									<div class="chartjs-size-monitor-shrink">
										<div class=""></div>
									</div>
								</div>
								<canvas id="lineChart" class="chartjs-render-monitor"></canvas>
							</div>
						</div> <!-- end card-body -->
					</div> <!-- end card -->
				</div><!-- end col -->
			</div>
			<!-- end row -->

		</div> <!-- container -->

	</div> <!-- content -->
</div>


<!-- Init js -->
<script src="<?php echo base_url('assets/backend'); ?>/libs/chart.js/Chart.bundle.min.js"></script>
<script type="text/javascript">
	var ctx = document.getElementById('lineChart').getContext('2d');
	var jumlah1 = <?php echo $jumlah1; ?>;
	var jumlah2 = <?php echo $jumlah2; ?>;
	var tanggal = <?php echo $tanggal; ?>;
	var myChart = new Chart(ctx, {
		//chart akan ditampilkan sebagai bar chart
		type: 'line',
		data: {
			//membuat label chart
			labels: tanggal,
			datasets: [{
				label: '# Konsumen',
				//isi chart
				data: jumlah1,
				//membuat warna pada bar chart
				backgroundColor: 'rgba(255, 99, 132, 0.2)',
				borderColor: 'rgba(255,99,132,1)',
				borderWidth: 3
			}, {
				label: '# Toko',
				//isi chart
				data: jumlah2,
				//membuat warna pada bar chart
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				borderWidth: 3
			}],


		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
</script>