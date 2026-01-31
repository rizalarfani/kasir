<div class="content-page">
	<div class="content">

		<!-- Start Content-->
		<div class="container-fluid">
			<div class="card">
				<div class="card-body">
					<form action="<?php echo base_url('profil/update'); ?>" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						
						<div class="row push">
							<div class="col-lg-4"></div>
							<div class="col-lg-4">
								<div class="mb-4">
									<label class="form-label">Nama Lengkap</label>
									<input type="text" class="form-control" name="nama_lengkap" value="<?php echo $edit->user_namalengkap; ?>" required>
								</div>
								<div class="mt-5 mb-4">
									<label class="form-label">Password Saat Ini</label>
									<input type="password" class="form-control" name="password_sekarang">
								</div>
								<div class="row mb-4">
									<div class="col-12">
										<label class="form-label">Password Baru</label>
										<input type="password" class="form-control" name="password_baru_1">
									</div>
								</div>
								<div class="row mb-4">
									<div class="col-12">
										<label class="form-label">Ulangi Password Baru</label>
										<input type="password" class="form-control" name="password_baru_2">
									</div>
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>