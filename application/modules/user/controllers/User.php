<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->cek_login();
		$this->load->model('M_user');
	}

	private function meta()
	{
		$data = array(
			"data"          => $this->M_user->get_prov(),
			"judul"			=> "User",
			"keterangan"	=> "Manajemen Pengguna",
			"halaman"		=> "user",
			"breadcrumb"	=> "Master Data|User",
			"view"			=> "user",
			"data_user"		=> $this->M_user->get_user($this->user_level, $this->user_id),
		);

		return $data;
	}

	public function index()
	{
		$this->load->view('template', $this->meta());
	}

	public function edit()
	{
		$data			= $this->meta();
		$this->db->join('lokasi', 'lokasi.id_mitra = user.user_id', 'left');
		$data["edit"]	= $this->M_Universal->getOne(["user_id" => dekrip(uri(3))], "user");
		$this->load->view('template', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('user_nama', 'username', 'required|trim');
		$this->form_validation->set_rules('user_password', 'password', 'required|trim');
		$this->form_validation->set_rules('user_namalengkap', 'nama lengkap', 'required|trim');
		if ($this->form_validation->run()  == true) {
			$level = $this->input->post("user_level");
			$data = array(
				"user_nama"			=> $this->input->post("user_nama"),
				"user_password"		=> password_hash($this->input->post("user_password"), PASSWORD_BCRYPT),
				"user_namalengkap"	=> $this->input->post("user_namalengkap"),
				"user_level"		=> $level,
				'add_by'            => $this->session->userdata('log_admin')['user_id'],
			);
			$tambah = $this->M_Universal->insert($data, "user");
			if ($level == 4) {
				$id = $this->db->insert_id();
				$lokasi = array(
					"id_mitra" => $id,
					"id_prop"  => $this->input->post('prov'),
					"id_kab"   => $this->input->post('kota'),
					"id_kec"   => $this->input->post('kec'),
					"lengkap"  => $this->input->post('des')
				);
				$lokasi = $this->M_Universal->insert($lokasi, "lokasi");
				($lokasi) ? $this->notification->success("Berhasil tambah user!") : $this->notification->error("Gagal tambah user!!");
			}
			($tambah) ? $this->notification->success("Berhasil tambah user!") : $this->notification->error("Gagal tambah user!!");
		} else {
			$this->notification->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
		}
		redirect('user');
	}

	public function update()
	{
		$user_id		= dekrip($this->input->post("user_id"));
		$level = $this->input->post("user_level");
		$this->form_validation->set_rules('user_nama', 'username', 'required|trim');
		$this->form_validation->set_rules('user_namalengkap', 'nama lengkap', 'required|trim');
		if ($this->form_validation->run()  == true) {
			$data			= array(
				"user_nama"			=> $this->input->post("user_nama"),
				"user_namalengkap"	=> $this->input->post("user_namalengkap"),
				"user_level"		=> $this->input->post("user_level"),
				'user_edited'		=> date("Y-m-d H:i:s"),
			);
			if ($level == 4) {
				$lokasi = array(
					"id_prop"  => $this->input->post('prov'),
					"id_kab"   => $this->input->post('kota'),
					"id_kec"   => $this->input->post('kec'),
					"lengkap"  => $this->input->post('des')
				);
				$this->M_Universal->update($lokasi, ['id_mitra' => $user_id], 'lokasi');
			}
			$update = $this->M_Universal->update($data, ["user_id" => $user_id], "user");
			($update) ? $this->notification->success("Berhasil ubah user!") : $this->notification->error("Gagal ubah user!!");
		}
		redirect('user');
	}

	public function hapus()
	{
		$id_user = dekrip(uri(3));
		if (empty($id_user)) redirect('user');
		$hapus = $this->M_Universal->delete(["user_id" => $id_user], "user");
		($hapus) ? $this->notification->success('Berhasil hapus user!!') : $this->notification->error("Gagal hapus user!");
		redirect('user');
	}


	function get_kota()
	{
		$id = $this->input->get('id');
		$data = $this->M_user->get_kota($id);
		echo json_encode($data);
	}
	function get_kec()
	{
		$id = $this->input->get('id');
		$data = $this->M_user->get_kecamatan($id);
		echo json_encode($data);
	}

	function get_des()
	{
		$id = $this->input->get('id');
		$data = $this->M_user->get_desa($id);
		echo json_encode($data);
	}
}
