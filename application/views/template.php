<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Sistem Manajemen Penjualan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Nada Teknik">
	<meta name="author" content="@noDev">
	<meta name="robots" content="noindex, nofollow">

	<!-- Open Graph Meta -->
	<meta property="og:title" content="Nada Teknik">
	<meta property="og:site_name" content="Nada Teknik">
	<meta property="og:description" content="Nada Teknik">
	<meta property="og:type" content="website">
	<meta property="og:url" content="">
	<meta property="og:image" content="">

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/backend'); ?>/images/logo-sm.png">

	<!-- App css -->
	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled" />
	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled" />

	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/backend') ?>/libs/select2/css/select2.min.css">

	<!-- Notification css (Toastr) -->
	<link href="<?php echo base_url('assets/backend'); ?>/libs/toastr/build/toastr.min.css" rel="stylesheet" type="text/css" />

	<!-- DataTables -->
	<link href="<?php echo base_url('assets/backend'); ?>/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/backend'); ?>/libs//datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

	<!-- icons -->
	<link href="<?php echo base_url('assets/backend'); ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>


<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>

	<!-- Begin page -->
	<div id="wrapper">

		<!-- Topbar Start -->
		<div class="navbar-custom">
			<ul class="list-unstyled topnav-menu float-end mb-0">
				<li class="dropdown d-inline-block d-lg-none">
					<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<i class="fe-search noti-icon"></i>
					</a>
					<div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
						<form class="p-3">
							<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
						</form>
					</div>
				</li>

				<li class="dropdown notification-list topbar-dropdown">
					<a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<img src="<?php echo base_url('assets/backend'); ?>/images/logo-sm.png" alt="user-image" class="rounded-circle">
						<span class="pro-user-name ms-1">
							<?php echo $this->user_nama; ?> <i class="mdi mdi-chevron-down"></i>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-end profile-dropdown ">
						<!-- item-->
						<div class="dropdown-header noti-title">
							<h6 class="text-overflow m-0 text-center"><?php echo $this->user_namalengkap; ?></h6>
						</div>

						<!-- item-->
						<a href="<?php echo base_url('profil'); ?>" class="dropdown-item notify-item">
							<i class="fe-user"></i>
							<span>Profil</span>
						</a>

						<!-- item-->
						<a href="<?php echo base_url('logout'); ?>" class="dropdown-item notify-item">
							<i class="fe-log-out"></i>
							<span>Logout</span>
						</a>
					</div>
				</li>
			</ul>

			<!-- LOGO -->
			<div class="logo-box">
				<a href="<?php echo base_url('.'); ?>" class="logo logo-light text-center">
					<span class="logo-sm">
						<h3 class="d-inline">SMJ</h3>
					</span>

					<span class="logo-lg">
						<h3 class="d-inline">Management</h3>
					</span>
				</a>

				<a href="<?php echo base_url('.'); ?>" class="logo logo-dark text-center">
					<span class="logo-sm">
						<h3 class="d-inline">SMJ</h3>
					</span>
					<span class="logo-lg">
						<h3 class="d-inline">Management</h3>
					</span>
				</a>
			</div>

			<ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
				<li>
					<button class="button-menu-mobile waves-effect">
						<i class="fe-menu"></i>
					</button>
				</li>

				<li>
					<h4 class="page-title-main"><?php echo $judul; ?></h4>
				</li>

			</ul>

			<div class="clearfix"></div>

		</div>
		<!-- end Topbar -->

		<!-- ========== Left Sidebar Start ========== -->
		<div class="left-side-menu">
			<div class="h-100" data-simplebar>

				<!--- Sidemenu -->
				<div id="sidebar-menu">
					<ul id="side-menu">
						<li class="menu-title">Navigation</li>
						<li>
							<a href="<?php echo base_url('.'); ?>">
								<i class="mdi mdi-view-dashboard"></i>
								<span>Dasbor</span>
							</a>
						</li>

						<?php if ($this->user_level == '2') { ?>
							<li>
								<a href="#email" data-bs-toggle="collapse">
									<i class="mdi mdi-clipboard"></i>
									<span> Produk </span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="email">
									<ul class="nav-second-level">
										<li>
											<a href="<?php echo base_url('kategori'); ?>">
												Kategori
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('produk'); ?>">
												Produk
											</a>
										</li>
									</ul>
								</div>
							</li>
						<?php } ?>
						<?php if ($this->user_level != 5) { ?>

							<?php if ($this->user_level != 1) { ?>
								<li>
									<a href="#stok" data-bs-toggle="collapse">
										<i class="mdi mdi-clipboard"></i>
										<span> Stok </span>
										<span class="menu-arrow"></span>
									</a>
									<div class="collapse" id="stok">
										<ul class="nav-second-level">
											<?php if ($this->user_level == 2) { ?>
												<li>
													<a href="<?php echo base_url('stok'); ?>">
														Tambah Stok
													</a>
												</li>
											<?php } ?>
											<?php if (in_array($this->user_level, [2, 4])) { ?>
												<li>
													<a href="<?php echo base_url('stok/data'); ?>">
														Data
													</a>
												</li>
											<?php } ?>
											<?php if ($this->user_level != 1) { ?>
												<li>
													<a href="<?php echo base_url('stok/retur'); ?>">
														Retur
													</a>
												</li>
											<?php } ?>

										</ul>
									</div>
								</li>
							<?php } ?>

							<li class="menu-title mt-2">Penjualan</li>

							<li>
								<a href="#pembelian" data-bs-toggle="collapse">
									<i class="mdi mdi-clipboard"></i>
									<span> Konsumen </span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="pembelian">
									<ul class="nav-second-level">
										<li>
											<a href="<?php echo base_url('pembelian'); ?>">
												Pembelian suplier
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('pembelian/data'); ?>">
												Pembelian order
											</a>
										</li>

									</ul>
								</div>
							</li>

							<li>
								<a href="#inventaris" data-bs-toggle="collapse">
									<i class="mdi mdi-clipboard"></i>
									<span> Toko </span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="inventaris">
									<ul class="nav-second-level">
										<li>
											<a href="<?php echo base_url('inventaris'); ?>">
												Pembelian suplier
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('inventaris/data'); ?>">
												Pembelian order
											</a>
										</li>
									</ul>
								</div>
							</li>
						<?php } ?>

						<?php if ($this->user_level == 2) { ?>
							<li class="menu-title mt-2">Pelunasan</li>
							<li>
								<a href="#kon" data-bs-toggle="collapse">
									<i class="mdi mdi-clipboard"></i>
									<span> Konsumen </span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="kon">
									<ul class="nav-second-level">
										<li>
											<a href="<?php echo base_url('pelunasan/generate'); ?>">
												Generate
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('pelunasan'); ?>">
												Pelunasan
											</a>
										</li>
									</ul>
								</div>
							</li>

							<li>
								<a href="#toko" data-bs-toggle="collapse">
									<i class="mdi mdi-clipboard"></i>
									<span> Toko </span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="toko">
									<ul class="nav-second-level">
										<li>
											<a href="<?php echo base_url('pelunasan_inven/generate'); ?>">
												Generate
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('pelunasan_inven'); ?>">
												Pelunasan
											</a>
										</li>

									</ul>
								</div>
							</li>

							<li>
								<a href="#it" data-bs-toggle="collapse">
									<i class="mdi mdi-clipboard"></i>

									<span> IT </span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="it">
									<ul class="nav-second-level">
										<li>
											<a href="<?php echo base_url('pelunasan/generate_it'); ?>">
												Generate
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('pelunasan/it'); ?>">
												Pelunasan
											</a>
										</li>
									</ul>
								</div>
							</li>

						<?php } ?>

						<?php if (!in_array($this->user_level, [3, 5])) { ?>
							<li class="menu-title mt-2">Master Data</li>
							<li>
								<a href="<?php echo base_url('user'); ?>">
									<i class="fa fa-users"></i>
									<span>User</span>
								</a>
							</li>
						<?php } ?>

						<?php if ($this->user_level == 5) { ?>
							<li class="menu-title mt-2">Penjualan</li>
							<li>
								<a href="<?php echo base_url('pembelian/add'); ?>">
									<i class="fa fa-users"></i>
									<span>Tambah</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url('pembelian/data'); ?>">
									<i class="fa fa-users"></i>
									<span>Data</span>
								</a>
							</li>
						<?php } ?>


						<?php if (!in_array($this->user_level, [2, 5])) { ?>
							<li class="menu-title mt-2">Pelunasan</li>
							<li>
								<a href="<?php echo base_url('pelunasan/by_user'); ?>">
									<i class="fa fa-users"></i>
									<span>Data</span>
								</a>
							</li>
						<?php } ?>

					</ul>
				</div>
				<!-- End Sidebar -->

				<div class="clearfix"></div>
			</div>
			<!-- Sidebar -left -->

		</div>
		<!-- Left Sidebar End -->

		<!-- ============================================================== -->
		<!-- Start Page Content here -->
		<!-- ============================================================== -->

		<?php $this->load->view($view); ?>

		<!-- ============================================================== -->
		<!-- End Page content -->
		<!-- ============================================================== -->


		<!-- Footer Start -->
		<footer class="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<script>
							document.write(new Date().getFullYear())
						</script> &copy; Adminto theme by <a href="">Coderthemes</a>
					</div>
					<div class="col-md-6">
						<div class="text-md-end footer-links d-none d-sm-block">
							<a href="javascript:void(0);">About Us</a>
							<a href="javascript:void(0);">Help</a>
							<a href="javascript:void(0);">Contact Us</a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- end Footer -->
	</div>
	<!-- END wrapper -->

	<!-- Vendor js -->
	<script src="<?php echo base_url('assets/backend'); ?>/js/vendor.min.js"></script>

	<!-- knob plugin -->
	<script src="<?php echo base_url('assets/backend'); ?>/libs/jquery-knob/jquery.knob.min.js"></script>

	<!--Morris Chart-->
	<script src="<?php echo base_url('assets/backend'); ?>/libs/morris.js06/morris.min.js"></script>
	<script src="<?php echo base_url('assets/backend'); ?>/libs/raphael/raphael.min.js"></script>

	<!-- Toastr js -->
	<script src="<?php echo base_url('assets/backend'); ?>/libs/toastr/build/toastr.min.js"></script>

	<script src="<?php echo base_url('assets/backend') ?>/libs/select2/js/select2.min.js"></script>

	<!-- Required datatable js -->
	<script src="<?php echo base_url('assets/backend'); ?>/libs/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url('assets/backend'); ?>/libs/datatables/dataTables.bootstrap4.min.js"></script>
	<script>
		$(document).ready(function() {
			toastr.options = {
				"newestOnTop": true,
				"positionClass": "toast-top-right",
				"preventDuplicates": true
			}
			$('.dataTable').DataTable();
			$('.select').select2();
		});
	</script>

	<!-- App js-->
	<script src="<?php echo base_url('assets/backend'); ?>/js/app.min.js"></script>

	<?php echo $this->session->flashdata('notifikasi'); ?>
</body>

</html>