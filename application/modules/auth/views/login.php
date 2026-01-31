<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Login | Sistem Management Penjualan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="HFC" name="description" />
	<meta content="@PHB_dev" name="author" />
	<meta content="noindex, nofollow" name="robots">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->

	<!-- App css -->
	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled" />
	<link href="<?php echo base_url('assets/backend'); ?>/css/config/default/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled" />

	<!-- icons -->
	<link href="<?php echo base_url('assets/backend'); ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="loading authentication-bg authentication-bg-pattern">
	<div class="account-pages my-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6 col-xl-4">
					<div class="text-center">
						<a href="index.html">
							
						</a>
						<p class="text-muted mt-2 mb-4">SISTEM MANAJEMEN PENJUALAN</p>

					</div>
					<div class="card">
						<div class="card-body p-4">
							<div class="text-center mb-4">
								<h4 class="text-uppercase mt-0">Sign In</h4>
							</div>
							<?php if ($this->session->flashdata('notifikasi')) { ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<p class="mb-0"><?php echo $this->session->flashdata('notifikasi'); ?></p>
								</div>
							<?php } ?>

							<form action="auth/proses" method="POST">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<div class="mb-2">
									<label for="emailaddress" class="form-label">Username</label>
									<input class="form-control" type="text" name="username" placeholder="Masukkan Username Anda" required>
								</div>

								<div class="mb-2">
									<label for="password" class="form-label">Password</label>
									<input class="form-control" type="password" name="password" placeholder="Masukkan Password Anda" required>
								</div>

								<div class="mb-2 d-grid text-center">
									<button class="btn btn-primary" type="submit">Log In</button>
								</div>
							</form>
							<!-- <div class="row mt-3">
								<div class="col-12 text-center">
									<p> <a href="pages-recoverpw.html" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Forgot your password?</a></p>
									<p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-dark ms-1"><b>Sign Up</b></a></p>
								</div>
							</div> -->
						</div>
						<!-- end card-body -->
					</div>
					<!-- end row -->

				</div>
				<!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end page -->

	<!-- Vendor js -->
	<script src="<?php echo base_url('assets/backend'); ?>/js/vendor.min.js"></script>

	<!-- App js -->
	<script src="<?php echo base_url('assets/backend'); ?>/js/app.min.js"></script>
</body>

</html>