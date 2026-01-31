<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->cek_login();
		$this->load->model(array('M_stok', 'produk/M_produk'));
	}

	private function meta($id)
	{
		$data = array(
			"suplier"       => $this->M_Universal->getMulti(array('user_level' => '3'), "user"),
			"data"          => $this->M_Universal->getMulti(Null, "products"),
			"toko"			=> $this->M_stok->get_toko(),
			"data_tampil"	=> $this->M_stok->data_temp($id, $this->user_id),
			"it"			=> $this->M_stok->hrg_it(),
			"judul"			=> "Stok",
			"keterangan"	=> "Manajemen Stok Barang",
			"view"			=> "data",
		);
		return $data;
	}

	public function index()
	{
		$id = $this->input->get('id');
		$this->load->view('template', $this->meta($id));
	}

	public function get_stok_awal()
	{
		$id_product = $this->input->get('id_product');
		$toko_id = $this->input->get('id_tok');
		$mit = $this->input->get('id_mit');
		$data['awal'] = $this->M_stok->get_stok_awal($toko_id, $id_product);
		echo json_encode($data);
	}

	public function get_stok_awal_mitra()
	{
		$id = $this->input->get('id');
		$data['hpp'] = $this->M_stok->get_hrg_awal($id);
		echo json_encode($data);
	}


	public function get_stok_tgl()
	{
		$id = $this->input->get('id');
		$toko = $this->input->get('id_tok');
		$data = $this->M_stok->get_stok_tgl($toko, $id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->get('id');
		$data = $this->M_Universal->getMulti(array('toko_id' => $id, 'add_by' => $this->user_id), "stok_masuk_temp");
		// $inven = false;
		$jum = 0;
		// $t_qty = [];
		// $t_hrg = [];

		foreach ($data as $d) {
			$cek = $this->M_Universal->getOne(["id" => $d->product_id], "products");
			if ($cek->is_inven == 1) {
				$jum++;
				if ($jum == 1) {
					$order_id = $this->M_stok->order_no($d->toko_id);
				}
				$datas = array(
					'order_number' => $order_id,
					'product_id' => $d->product_id,
					'toko_id'	=> $d->toko_id,
					'id_mitra'  => $d->id_mitra,
					"jumlah"	=> $d->jumlah,
					"add_by"	=> $d->add_by,
					"hpp" 		=> $d->hpp,
					"id_harga"  => $d->id_harga,
					"toko"		=> $d->toko
				);
			} else {
				$datas = array(
					'order_number' => '',
					'product_id' => $d->product_id,
					'toko_id'	=> $d->toko_id,
					'id_mitra'  => $d->id_mitra,
					"jumlah"	=> $d->jumlah,
					"add_by"	=> $d->add_by,
					"hpp" 		=> $d->hpp,
					"id_harga"  => $d->id_harga,
					"toko"		=> $d->toko
				);
			}
			$update = $this->M_Universal->insert($datas, "stok_masuk");
		}
		// if ($inven) {

		// 	$cek = $this->M_Universal->getOne(["user_id" => $data[0]->toko_id], "user");
		// 	$dataorder = array(
		// 		'name' => $cek->user_namalengkap,
		// 		'bayar' => 0,
		// 		'order_date' => date('Y-m-d'),
		// 		'order_number' => $order_id,
		// 		'user_id' => $this->user_id,
		// 		'toko_id' => $data[0]->toko_id,
		// 		'total_price' => array_sum($t_hrg),
		// 		'total_items' => array_sum($t_qty),
		// 		'is_inven' => '1',
		// 	);
		// 	$this->M_Universal->insert($dataorder, "orders");
		// 	$id = $this->db->insert_id();
		// 	$this->M_Universal->insert_batch($order, "order_items");

		// 	$this->db->where('order_id', $order_id);
		// 	$this->db->update('order_items', array('order_id' => $id));
		// }


		if ($update) {
			$hapus = $this->M_Universal->delete(["toko_id" => $id], "stok_masuk_temp");
		}
		($hapus) ? $this->notification->success("Berhasil tambah!") : $this->notification->error("Gagal tambah!!");
		redirect('stok');
	}


	public function tambah()
	{
		$prod = $this->input->post("produk");
		$hpp = $this->input->post("h_mitra");
		$hfc = $this->input->post('h_pt');
		$jual = $this->input->post('h_tk');
		$it = $this->input->post('h_it');
		$cek = $this->M_Universal->getOne(["id" => $prod], "products");
		$toko = $hpp + $hfc + $it;
		if ($cek->is_inven == 0) {
			$toko = $jual - $hpp - $hfc - $it;
		}
		$data = array(
			"hpp"				=> $hpp,
			"product_id"		=> $prod,
			"id_mitra"			=> $this->input->post("mitra"),
			"jumlah"			=> $this->input->post("qty"),
			"toko_id"			=> $this->input->post("toko"),
			"add_by"			=> $this->user_id,
			"id_harga"			=> $this->input->post("hrg"),
			"toko"				=> $toko
		);
		$tambah = $this->M_Universal->insert($data, "stok_masuk_temp");
		($tambah) ? $this->notification->success("Berhasil tambah!") : $this->notification->error("Gagal tambah!!");
		redirect('stok?id=' . $this->input->post("toko"));
	}

	public function hapus()
	{
		$id_user = dekrip(uri(3));
		if (empty($id_user)) redirect('stok');
		$hapus = $this->M_Universal->delete(["id" => $id_user], "stok_masuk_temp");
		($hapus) ? $this->notification->success('Berhasil hapus !!') : $this->notification->error("Gagal hapus !");
		redirect($_SERVER['HTTP_REFERER']);
	}

	function data()
	{
		$data = array(
			"judul"	=> "Manajemen Stok Barang",
			'data' => $this->M_stok->get_all($this->user_level, $this->user_id),
			"keterangan"	=> "Manajemen Stok Barang",
			"view"			=> "data_stok",
		);

		$this->load->view('template', $data);
	}

	function retur()
	{
		$data = array(
			'data' => $this->M_stok->get_retur($this->user_level, $this->user_id),
			"judul"	=> "Manajemen Retur Barang",
			"keterangan"	=> "Manajemen Retur Barang",
			"view"			=> "data_retur",
		);
		$this->load->view('template', $data);
	}

	public function add_retur()
	{
		$data = array(
			"judul"			=> "Manajemen Retur Barang",
			'data' 			=> $this->M_stok->get_all($this->level, $this->user_id),
			"keterangan"	=> "Manajemen Retur Barang",
			"view"			=> "add_retur",
		);
		$this->load->view('template', $data);
	}

	public function add_retur_proses()
	{
		$data = array(
			'product_id' 	=> $this->input->post('produk'),
			"id_stok"	=> $this->input->post('tgl'),
			"qty"			=> $this->input->post('qty'),
			"add_by" => $this->user_id,
			"ket" => $this->input->post('ket'),
		);
		$tambah = $this->M_Universal->insert($data, "retur");
		($tambah) ? $this->notification->success("Berhasil tambah!") : $this->notification->error("Gagal tambah!!");
		redirect('stok/retur');
	}
}
