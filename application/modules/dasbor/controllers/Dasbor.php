<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dasbor extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->cek_login();
		$this->load->model('M_dasbor');
	}
	public function index()
	{
		$tgl1 = array_column($this->M_dasbor->grafik(), 'tgl');
		$tgl2 = array_column($this->M_dasbor->grafik_inv(), 'tgl');
		$val1 = array_column($this->M_dasbor->grafik(), 'laku');
		$val2 = array_column($this->M_dasbor->grafik_inv(), 'laku');

		$combine1 = array_combine($tgl1, $val1);
		$combine2 = array_combine($tgl2, $val2);

		$merge = array_merge($tgl1, $tgl2);
		$unik = array_unique($merge);
		asort($unik);
		$jumlah = count($unik);
		$kosong = array_fill(0, $jumlah, 0);
		$combinekosong = array_combine($unik, $kosong);
		$hasil1 = [];
		$no = 0;
		foreach ($combinekosong as $key => $cs) {
			if ($combine1[$key] == null) {
				$hasil1[$no] = $cs;
			} else {
				$hasil1[$no] = $combine1[$key];
			}
			$no++;
		}
		$hasil2 = [];
		$no = 0;
		foreach ($combinekosong as $key => $cs) {
			if ($combine2[$key] == null) {
				$hasil2[$no] = $cs;
			} else {
				$hasil2[$no] = $combine2[$key];
			}
			$no++;
		}

		$data = array(
			"judul"			=> "Dashbor",
			"keterangan"	=> "Grafik Penjualan Barang",
			"halaman"		=> "dasbor",
			"tanggal"		=> json_encode($unik),
			"jumlah1" 	    => json_encode($hasil1),
			"jumlah2" 	    => json_encode($hasil2),
			"view"			=> "dasbor",
		);

		$this->load->view('template', $data);
	}

	function per()
	{
		$tgl1 =	array(
			'0' => "2022-11-02",
			'1' => "2022-11-03",
		);

		$val1 =	array(
			'0' => "5",
			'1' => "7",
		);



		// 		["2022-11-02"]=>
		//   string(1) "5"
		//   ["2022-11-03"]=>
		//   string(1) "7"
		//   ["2022-11-04"]=>
		//   int(0)


		$tgl2 =	array(
			'0' => "2022-11-02",
			'1' => "2022-11-04",
		);

		$val2 =	array(
			'0' => "2",
			'1' => "3",
		);


		$combine1 = array_combine($tgl1, $val1);
		$combine2 = array_combine($tgl2, $val2);

		$merge = array_merge($tgl1, $tgl2);
		$unik = array_unique($merge);
		asort($unik);
		$jumlah = count($unik);
		$kosong = array_fill(0, $jumlah, 0);
		$combinekosong = array_combine($unik, $kosong);
		$hasil1 = [];
		foreach ($combinekosong as $key => $cs) {
			if ($combine1[$key] == null) {
				$hasil1[$key] = $cs;
			} else {
				$hasil1[$key] = $combine1[$key];
			}
		}

		var_dump($hasil1);

		$hasil2 = [];
		foreach ($combinekosong as $key => $cs) {
			if ($combine2[$key] == null) {
				$hasil2[$key] = $cs;
			} else {
				$hasil2[$key] = $combine2[$key];
			}
		}

		var_dump($hasil2);
	}
}
