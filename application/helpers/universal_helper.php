<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function uri($segment)
{
	$uri = get_instance();
	$uri = $uri->uri->segment($segment);

	return $uri;
}

function url($segment, $isi_url = '')
{
	$url = get_instance();
	$url_data = array();

	for ($s = 1; $s <= $segment; $s++) {
		$url_data[] = $url->uri->segment($s);
	}

	if ($isi_url){
		$url = implode("/", $url_data) .'/'. $isi_url;
	} else {
		$url = implode("/", $url_data);
	}

	return base_url($url);
}

function menu_aktif($halaman, $menu, $jenis)
{
	if ($jenis == "parent") {
		$menus = explode("|", $menu);

		foreach ($menus as $menu) {
			if ($halaman == $menu) {
				echo "open";
			}
		}
	} else if ($jenis == "menu") {
		if ($halaman == $menu) {
			echo "active";
		}
	}
}

function notifikasi_redirect($jenis, $pesan, $redirect)
{
	$notif = get_instance();
	$notif->session->set_flashdata("notifikasi", "<script>toastr.$jenis('$pesan');</script>");

	redirect($redirect);
}

function Btambah($tujuan)
{
	return "<a href=" . $tujuan . " class='btn btn-sm btn-dark' data-toggle='tooltip' title='Tambah'><i class='fa fa-plus'> Tambah Data</i></a>";
}

function Bedit($tujuan)
{
	return "<a href=" . $tujuan . " class='btn  btn-sm btn-warning' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil-alt'></i></a>";
}

function Bdelete($tujuan)
{
	return "<a href=" . $tujuan . "  data-toggle='modal' data-target='#confirmModal'  class='deleteBtn btn btn-sm btn-danger' data-toggle='tooltip' title='Hapus'><i class='fa fa-times'></i></a>";
}

function Breset($tujuan)
{
	return "<a href=" . $tujuan . "  onclick='return confirm(\"Yakin Reset ?\")'  class='btn btn-sm btn-primary' data-toggle='tooltip' title='Reset'><i class='fa fa-spinner'></i></a>";
}

function Bdetail($tujuan)
{
	return "<a href=" . $tujuan . " class='btn btn-sm btn-info' data-toggle='tooltip' title='Detail'><i class='fa fa-eye'></i></a>";
}

function level_user($status)
{
	if ($status == "1"){
		$status = "IT";
	} else if ($status == "2"){
		$status = "Manajemen";
	} else if ($status == "3"){
		$status = "Mitra";
	} else if ($status == "4"){
	$status = "Toko";
	} else if ($status == "5"){
	$status = "Kasir";
   }
	return $status;
}


// custom enkripsi
function enkrip($string)
{
	if ($string) {
		global $bumbu_racikan;
		$bumbu = md5(str_replace("=", "", base64_encode("PHB_Tegal")));
		$katakata = false;
		$metodeenkrip = "AES-256-CBC";
		$kunci = hash('sha256', $bumbu);
		$kodeiv = substr(hash('sha256', $bumbu), 0, 16);

		$katakata = str_replace("=", "", openssl_encrypt($string, $metodeenkrip, $kunci, 0, $kodeiv));
		$katakata = str_replace("=", "", base64_encode($katakata));

		return $katakata;
	}
}

function dekrip($string)
{
	if ($string) {
		global $bumbu_racikan;
		$bumbu = md5(str_replace("=", "", base64_encode("PHB_Tegal")));
		$katakata = false;
		$metodeenkrip = "AES-256-CBC";
		$kunci = hash('sha256', $bumbu);
		$kodeiv = substr(hash('sha256', $bumbu), 0, 16);

		$katakata = openssl_decrypt(base64_decode($string), $metodeenkrip, $kunci, 0, $kodeiv);
		return $katakata;
	}

}

function format_rupiah($rp)
{
	return number_format($rp, 2, ',', '.');
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
