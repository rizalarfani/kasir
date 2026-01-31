<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->cek_login(2);
	}

	private function meta()
	{
		$data = array(
			"data"          => $this->M_Universal->getMulti(Null, "product_category"),
			"judul"			=> "Kategori",
			"keterangan"	=> "Manajemen Kategori Barang",
			"breadcrumb"	=> "Master Data|Kategori",
			"view"			=> "data",
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
		$data["edit"]	= $this->M_Universal->getOne(["id" => dekrip(uri(3))], "product_category");

		$this->load->view('template', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'nama', 'required');
		if ($this->form_validation->run()  == true) {
			$data = array(
				"name"			=> $this->input->post("nama"),
			);
			$tambah = $this->M_Universal->insert($data, "product_category");
			($tambah) ? $this->notification->success("Berhasil tambah user!") : $this->notification->error("Gagal tambah user!!");
		} else {
			$this->notification->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
		}
		redirect('kategori');
	}

	public function update()
	{
		$user_id		= dekrip($this->input->post("user_id"));
		$this->form_validation->set_rules('nama', 'nama', 'required');
		if ($this->form_validation->run()  == true) {
			$data			= array(
				"name"			=> $this->input->post("nama"),
			);
			$update = $this->M_Universal->update($data, ["id" => $user_id], "product_category");
			($update) ? $this->notification->success("Berhasil ubah !") : $this->notification->error("Gagal ubah !!");
		}
		redirect('kategori');
	}

	public function hapus()
	{
		$id_user = dekrip(uri(3));
		if (empty($id_user)) redirect('kategori');
		$hapus = $this->M_Universal->delete(["id" => $id_user], "product_category");
		($hapus) ? $this->notification->success('Berhasil hapus !!') : $this->notification->error("Gagal hapus !");
		redirect('kategori');
	}
}
