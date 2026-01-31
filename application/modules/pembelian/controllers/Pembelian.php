<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->cek_login();
		$this->load->model(array('M_pembelian'));
	}

	private function meta($awal, $akhir)
	{
		$data = array(
			"data"          => $this->M_pembelian->get_data($awal, $akhir, $this->user_level, $this->user_id),
			"judul"			=> "Laporan",
			"keterangan"	=> ($awal == '') ? "Laporan pembelian barang hari ini" : "Laporan pembelian barang " . $awal . ' s/d ' . $akhir,
			"view"			=> "data",
		);

		return $data;
	}

	public function index()
	{
		$start = $this->input->post('awal');
		$end = $this->input->post('akhir');
		$this->load->view('template', $this->meta($start, $end));
	}

	public function add()
	{
		$data = array(
			"data"          => $this->M_pembelian->get_produk($this->user_addby),
			"dt" 			=> $this->M_pembelian->get_temp($this->user_id),
			"judul"			=> "Tambah Pembelian",
			"keterangan"	=> "Tambah Pembelian",
			"view"			=> "add",
		);
		$this->load->view('template', $data);
	}



	public function add_proses()
	{
		$data = array(
			"user_id"          => $this->user_id,
			"product_id"	   => $this->input->post('produk'),
			"order_qty"		   => $this->input->post('qty'),
			"harga"		   => $this->input->post('harga'),
			"id_harga" => $this->input->post('idharga'),
		);
		$in = $this->M_Universal->insert($data, "order_items_temp");
		($in) ? $this->notification->success("Berhasil tambah !") : $this->notification->error("Gagal !!");
		redirect('pembelian/add');
	}
	function get_harga()
	{
		$id = $this->input->get('id');
		$this->db->where('product_id', $id);
		$hasil = $this->db->get('harga')->last_row();
		echo json_encode($hasil);
	}



	function get_stoks()
	{
		$id = $this->input->get('id');
		$gudang = $this->M_pembelian->get_produk_akhir($this->user_addby, $id);
		echo json_encode($gudang);
	}


	function cek_stok($id, $qty, $mitra)
	{
		$a = $this->M_pembelian->cek_stok($id, $mitra);
		$gudang = $this->M_pembelian->get_produk_akhir($this->user_addby, $id);
		if ((int)($gudang) < (int)$qty) {
			return false;
		}
		$sisa = array();
		$id = array();

		foreach ($a as $index => $c) {
			if ($c->sisane != '0' && $c->sisane != null) {
				$id[] = $c->msk_id;
				$sisa[] = $c->sisane;
			}
		}

		$data['qty'] = [];
		$data['id_stok'] = [];
		$data['order_item_id'] = [];
		for ($i = 0; $i < count($sisa); $i++) {
			$sisaan = $qty - $sisa[$i];
			if ($sisaan < 0) {
				$kurang = $sisa[$i] + $sisaan;
				if ($kurang >= 0) {
					array_push($data['qty'], (int)$kurang);
					array_push($data['id_stok'], (int)$id[$i]);
				}
			} else {
				array_push($data['qty'], (int)$sisa[$i]);
				array_push($data['id_stok'], (int)$id[$i]);
			}
			$qty = $sisaan;
		}
		return $data;
	}

	function add_post()
	{
		$this->db->select('product_id,id_harga,harga,order_qty,user_id');
		$data = $this->M_Universal->getMulti(array('user_id' => $this->user_id), "order_items_temp");
		$order_id = $this->M_pembelian->order_no($this->user_addby);

		$dataorder = array(
			'name' => $this->input->post('nama'),
			'bayar' => $this->input->post('byr'),
			'order_date' => $this->input->post('tgl'),
			'order_number' => $order_id,
			'user_id' => $this->user_id,
			'toko_id' => $this->user_addby,
			'total_price' => $this->input->post('total'),
			'total_items' => $this->input->post('item'),
		);
		// db trasas
		$this->db->trans_start();

		$this->db->insert('orders', $dataorder);
		$idnya = $this->db->insert_id();
		$this->M_Universal->delete(["user_id" => $this->user_id], "order_items_temp");

		foreach ($data as $d) {
			$datas = array(
				'order_id' => $idnya,
				'product_id' => $d->product_id,
				'order_qty' => $d->order_qty,
				'harga' => $d->harga,
				'id_harga' => $d->id_harga,
			);
			$stok = $this->cek_stok($d->product_id, $d->order_qty, $this->user_addby);

			if ($stok == False) {
				// trans rool back
				$this->db->trans_rollback();
				$this->notification->error("Gagal stok kurang!");
				redirect(base_url('pembelian/add'));
			}
			$this->db->insert('order_items', $datas);
			$id_item = $this->db->insert_id();

			foreach ($stok['qty'] as $index => $s) {
				if ($s != 0) {
					$out = array(
						'qty' => $s,
						'id_stok' => $stok['id_stok'][$index],
						'order_item_id' => $id_item
					);
					$this->db->insert('stok_out', $out);
				}
			}
			// trans commit
			$this->db->trans_commit();
		}
		$stok = [];
		$this->notification->success('Berhasil !!');
		redirect(base_url('pembelian/detail/') . enkrip($order_id));
	}

	function hapus($id)
	{
		$id_user = dekrip($id);
		if (empty($id_user)) redirect('pembelian/add');
		$hapus = $this->M_Universal->delete(["id" => $id_user], "order_items_temp");
		($hapus) ? $this->notification->success('Berhasil hapus!!') : $this->notification->error("Gagal hapus!");
		redirect('pembelian/add');
	}


	function data()
	{
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$data = array(
			"data"          => $this->M_pembelian->get_data_kasir($awal, $akhir, $this->user_level, $this->user_id),
			"judul"			=> "Laporan",
			"keterangan"	=> ($awal == '') ? "Laporan pembelian barang hari ini" : "Laporan pembelian barang " . $awal . ' s/d ' . $akhir,
			"view"			=> "kasir",
		);
		$this->load->view('template', $data);
	}

	function detail($id)
	{
		$id = dekrip($id);
		if (empty($id)) redirect('pembelian/data');
		$data = array(
			"data"          => $this->M_pembelian->get_data_kasir_detail($id),
			"judul"			=> "Laporan",
			"keterangan"	=> "Detail Pembelian " . $id,
			"view"			=> "invoice",
		);
		$this->load->view('template', $data);
	}
}
