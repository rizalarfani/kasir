<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pelunasan_inven extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->cek_login();
		$this->load->model('M_pelunasan_inven', 'M_pelunasan');
	}

	private function meta()
	{
		$data = array(
			"data"          => $this->M_pelunasan->get_data($this->user_level, $this->user_id),
			"judul"			=> "Laporan Pelunasan",
			"keterangan"	=> "Laporan pelunasan barang",
			"view"			=> "data",
		);

		return $data;
	}

	public function index()
	{
		$this->load->view('template', $this->meta());
	}

	public function lihat($code)
	{

		$data = array(
			"code"			=> dekrip($code),
			"judul"			=> "Laporan Pelunasan " . dekrip($code),
			"keterangan"    => "Laporan Pelunasan " . dekrip($code),
			"mitra"			=> $this->M_pelunasan->get_mitra(dekrip($code), null),
			"view"			=> "detail",
		);

		$this->load->view('template', $data);
	}

	function generate()
	{
		$akhir = $this->input->post('akhir');
		if ($akhir == null) {
			$akhir = date("Y-m-d");
		}
		$data = array(
			"data"          => $this->M_pelunasan->generate($akhir),
			"judul"			=> "Laporan",
			"keterangan"	=> "Laporan pembelian barang belum tergenerate s/d " . $akhir,
			"view"			=> "generate",
			"akhir"			=> $akhir,
		);
		$this->load->view('template', $data);
	}

	function proses_generate($tgl)
	{
		$kode = $this->M_pelunasan->order_no();
		$mitra = $this->M_pelunasan->generate_proses_mitra($tgl);
		foreach ($mitra as $tr) {
			$data[] = $tr->id_mitra;
			$jumlah[] = $tr->total;
			$qty[] = $tr->qty;
		}
		$it = $this->M_pelunasan->generate_proses_it($tgl);

		foreach ($it as $t) {
			$data[] = 1; #id it
			$jumlah[] = $t->total;
			$qty[] = $t->qty;
		}


		$hfc = $this->M_pelunasan->generate_proses_manajemen($tgl);
		foreach ($hfc as $t) {
			$data[] = 11; #id hfc
			$jumlah[] = $t->total;
			$qty[] = $t->qty;
		}

		foreach ($data as $index => $d) {
			$object = array(
				'code_pay' => $kode,
				'user_id' => $d,
				'total' => $jumlah[$index],
				'qty' => $qty[$index],
				'is_inven' => 1
			);
			$this->M_Universal->insert($object, "verifikasi");
		}


		// insert ke verif_admin

		$this->db->select('sum(total) as total, user_id');
		$this->db->where('code_pay', $kode);
		$this->db->where('user_id !=', 11); #bkn hfc
		$this->db->group_by('code_pay');
		$this->db->group_by('user_id');
		$verif_adm = $this->db->get('verifikasi')->result();
		foreach ($verif_adm as $ver) {
			$object = array(
				'code_pay' => $kode,
				'total' => $ver->total,
				'user_id' => $ver->user_id,
				'status' => 0
			);
			$this->M_Universal->insert($object, "verifikasi_adm");
		}

		$object = array(
			'code_pay' => $kode
		);

		$this->M_Universal->insert($object, "generate_code");
		$ids = $this->M_pelunasan->generate($tgl);
		foreach ($ids as $id) {
			$this->db->where('id', $id->id);
			$this->db->update('stok_masuk', array('code_pays' => $kode));
		}
		$this->notification->success("Berhasil tambah !");
		redirect(base_url('pelunasan_inven/lihat/' . enkrip($kode)));
	}

	function lunasi()
	{

		$code = $this->input->post('code');
		$id = $this->input->post('id');

		if (is_array($code)) {
			foreach ($code as $c) {
				$this->M_pelunasan->lunas($c, $id);
			}
		} else {
			$this->M_pelunasan->lunas($code, $id);
		}

		$this->notification->success("Berhasil melunasi !");
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function lihat_by_user($code)
	{
		$data = array(
			"code"			=> dekrip($code),
			"judul"			=> "Laporan Pelunasan " . dekrip($code),
			"keterangan" => "Laporan Pelunasan " . dekrip($code),
			"mitra"			=> ($this->user_level == 3) ? $this->M_pelunasan->get_mitra(dekrip($code), $this->user_id) : false,
			"toko"			=> ($this->user_level == 4) ? $this->M_pelunasan->get_toko(dekrip($code), $this->user_id) : false,
			"it"			=> ($this->user_level == 1) ? true : false,
			"view"			=> "detail_user",
		);
		$this->load->view('template', $data);
	}
}
