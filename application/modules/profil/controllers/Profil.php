<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {
	
    public function __construct()
    {
        parent::__construct();
		
		$this->cek_login();
    }
	
	public function index()
	{
		$data = array(
			"judul"			=> "Profil",
			"keterangan"	=> "Sunting Data Diri",
			"halaman"		=> "profil",
			"breadcrumb"	=> "User|Profil",
			"view"			=> "profil",
			"edit"			=> $this->M_Universal->getOne(["user_id" => $this->user_id], "user"),
		);
		
		$this->load->view('template', $data);
	}
	
	public function update()
	{
		$user_id		= $this->user_id;
		$namalengkap	= $this->input->post('nama_lengkap');
		
		if ($this->input->post('password_sekarang')){
			$passlama		= addslashes($this->input->post('password_sekarang'));
			$passbaru1		= addslashes($this->input->post('password_baru_1'));
			$passbaru2		= password_hash(addslashes($this->input->post('password_baru_2')), PASSWORD_DEFAULT);
			
			$cek = $this->db->query("SELECT user_password FROM user WHERE user_id='$user_id'");
			if (password_verify($passlama, $cek->row('user_password'))){
				if (password_verify($passbaru1, $passbaru2)){
					
					$data = array(
						"user_namalengkap"	=> $namalengkap,
						"user_password"		=> $passbaru2,
					);
					
					$update = $this->M_Universal->update($data, ["user_id" => $user_id], "user");
					
					notifikasi_redirect("success", "Update profil dan password berhasil", $_SERVER['HTTP_REFERER']);
				} else {
					notifikasi_redirect("error", "Password baru yang Anda masukkan tidak sama", $_SERVER['HTTP_REFERER']);
				}
			} else {
				notifikasi_redirect("error", "Password saat ini yang Anda masukkan salah", $_SERVER['HTTP_REFERER']);
			}
		} else {
			$update = $this->M_Universal->update(["user_namalengkap" => $namalengkap], ["user_id" => $user_id], "user");
		}
		
		if ($update){
			$session = array(
				'is_logged_in'		=> $this->login,
				'user_nama'			=> $this->user_nama,
				'user_level'		=> $this->user_level,
				'user_id'			=> $this->user_id,
				'user_namalengkap'	=> $namalengkap
			);
			
			$this->session->set_userdata("log_admin", $session);
			notifikasi_redirect("success", "Update profil berhasil", $_SERVER['HTTP_REFERER']);
		} else {
			notifikasi_redirect("error", "Update profil gagal", $_SERVER['HTTP_REFERER']);
		}
	}
	
}
