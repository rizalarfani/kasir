<?php defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->cek_login();
		$this->load->model('M_produk');
	}

	private function meta()
	{
		$data = array(
			"data"          => $this->M_produk->get_all(),
			"kat"          => $this->M_Universal->getMulti(Null, "product_category"),
			"keterangan"	=> "Produk",
			"judul" => "Produk",
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
		$data["edit"]	= $this->M_produk->detail(dekrip(uri(3)));
		$this->load->view('template', $data);
	}

	public function lihat()
	{

		$data["keterangan"] = "Produk";
		$data["judul"] = "Produk";
		$data['kat']	= $this->M_Universal->getMulti(Null, "product_category");
		$data['harga']  = $this->M_Universal->getMulti(["product_id" => dekrip(uri(3))], "harga");
		$data["edit"]	= $this->M_produk->detail(dekrip(uri(3)));
		$data["view"]   = "lihat";
		$this->load->view('template', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'nama produk', 'required|trim');
		$this->form_validation->set_rules('kat', 'kategori', 'required|trim');
		$this->form_validation->set_rules('it', 'harga it', 'required|trim');
		$this->form_validation->set_rules('jual', 'harga jual', 'required|trim');
		$this->form_validation->set_rules('toko', 'harga toko', 'required|trim');

		if ($this->form_validation->run()  == true) {
			$nama = $this->input->post("nama");
			$kat = $this->input->post("kat");
			$ka = $this->M_Universal->getOne(["id" => $kat], "product_category");
			$data = array(
				"kode_barang"			=> $this->M_produk->create_product_sku($nama, $ka->name),
				"name"					=> $this->input->post("nama"),
				"description"	        => $this->input->post("des"),
				"category_id"		    => $kat,
				"is_inven" => $this->input->post('inv'),
			);
			$lokasi = $this->M_Universal->insert($data, "products");
			$id = $this->db->insert_id();

			$lokasi = array(
				"product_id" => $id,
				"manajemen"  => $this->input->post('toko'),
				"jual"   => $this->input->post('jual'),
				"it"   => $this->input->post('it'),
				"persentase_it" => $this->input->post('per_it')
			);
			$lokasi = $this->M_Universal->insert($lokasi, "harga");
			($lokasi) ? $this->notification->success("Berhasil tambah !") : $this->notification->error("Gagal tambah !!");
		} else {
			$this->notification->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
		}
		redirect('produk');
	}

	public function update()
	{
		$id		= dekrip($this->input->post("id"));
		$this->form_validation->set_rules('nama', 'nama produk', 'required|trim');
		$this->form_validation->set_rules('kat', 'kategori', 'required|trim');
		$this->form_validation->set_rules('beli', 'harga beli', 'required|trim');
		$this->form_validation->set_rules('jual', 'harga jual', 'required|trim');

		if ($this->form_validation->run()  == true) {
			$data			= array(
				"name"					=> $this->input->post("nama"),
				"description"	        => $this->input->post("des"),
				"category_id"		    => $this->input->post("kat"),

			);

			$update = $this->M_Universal->update($data, ["id" => $id], "products");
			$cek	=  $this->M_produk->get_harga($id);
			$hpp  = $this->input->post('beli');
			$jual   = $this->input->post('jual');
			if (($cek->hpp != $hpp) || ($cek->jual != $jual)) {


				$lokasi = array(
					"product_id" => $id,
					"hpp"  => $this->input->post('beli'),
					"jual"   => $this->input->post('jual'),
				);
				$lokasi = $this->M_Universal->insert($lokasi, "harga");
				($lokasi) ? $this->notification->success("Berhasil ubah !") : $this->notification->error("Gagal !!");
			}

			($update) ? $this->notification->success("Berhasil ubah !") : $this->notification->error("Gagal ubah !!");
		}
		redirect('produk');
	}

	public function hapus()
	{
		$id_user = dekrip(uri(3));
		if (empty($id_user)) redirect('produk');
		$hapus = $this->M_Universal->delete(["id" => $id_user], "products");
		($hapus) ? $this->notification->success('Berhasil hapus!!') : $this->notification->error("Gagal hapus!");
		redirect('produk');
	}
}
