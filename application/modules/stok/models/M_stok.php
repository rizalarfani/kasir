<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stok extends CI_Model
{

    function get_toko()
    {
        $this->db->join('lokasi', 'lokasi.id_mitra = user.user_id', 'inner');
        return $this->M_Universal->getMulti(array('user_level' => '4'), "user");
    }

    public function get_stok_awal($id_user, $id_prod)
    {
        $this->db->select('SUM(stok_masuk.jumlah)-SUM(order_items.order_qty) as stok');
        $this->db->join('order_items', 'order_items.product_id = stok_masuk.product_id', 'left');
        $this->db->where('stok_masuk.toko_id', $id_user);
        $this->db->where('stok_masuk.product_id', $id_prod);
        return $this->db->get('stok_masuk')->row();
    }

    function get_hrg_awal($id_prod)
    {
        $this->db->select('harga.*');
        $this->db->join('products', 'products.id = harga.product_id ', 'inner');
        $this->db->where('product_id', $id_prod);
        return $this->db->get('harga')->last_row();
    }
    function hrg_it()
    {
        return  $this->db->get('bayaran_it')->last_row();
    }

    function data_temp($id, $usr)
    {
        $this->db->select('stok_masuk_temp.*,it,manajemen,jual,name');
        $this->db->join('products', 'products.id = stok_masuk_temp.product_id', 'inner');
        $this->db->join('harga', 'harga.id = stok_masuk_temp.id_harga', 'inner');
        return $this->M_Universal->getMulti(array('add_by' => $usr, 'toko_id' => $id), "stok_masuk_temp");
    }

    public function laku($produk, $toko)
    {
        $this->db->select('COALESCE(sum(order_qty),0) as stok');
        $this->db->join('order_items', 'order_items.order_id = orders.id', 'inner');
        $this->db->where('toko_id', $toko);
        $this->db->where('product_id', $produk);
        return $this->db->get('orders')->row();
    }

    public function get_all($level, $toko_id)
    {
        $this->db->select('user_id,user_namalengkap,products.name,sum(stok_masuk.jumlah) as masuk,COALESCE(sum(retur.qty),0) as retur,
        products.id as ids');
        $this->db->join('retur', 'retur.id_stok = stok_masuk.id', 'left');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.toko_id', 'inner');
        $this->db->group_by('products.id,toko_id');
        if ($level == 4) {
            $this->db->where('toko_id', $toko_id);
        }
        $this->db->where('is_inven', '0');
        return $this->db->get('stok_masuk')->result();
    }

    function get_retur($level, $id)
    {
        $this->db->select('user_namalengkap,products.name,retur.qty, ket,status,date_created ');
        $this->db->join('stok_masuk', 'stok_masuk.id = retur.id_stok', 'inner');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.toko_id', 'inner');
        if ($level == 4) {
            $this->db->where('toko_id', $id);
        }
        return $this->db->get('retur')->result();
    }

    function get_stok_tgl($id_toko, $id_prod)
    {
        $this->db->where('toko_id', $id_toko);
        $this->db->where('product_id', $id_prod);
        return $this->db->get('stok_masuk')->result();
    }
    function order_no($add_by)
    {
        $toko = $this->db->get_where('user', array('user_id' => $add_by))->row();

        $this->db->select('order_number');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->where('toko_id', $add_by);
        $this->db->where('is_inven', '1');
        $hasil = $this->db->get('stok_masuk')->last_row();
        if (!$hasil) {
            $urutan = 0;
        } else {
            $kode = $hasil->order_number;
            $urutan = substr($kode, strpos($kode, ".") + 10);
        }
        $urutan++;
        $huruf = $toko->user_nama;
        return $huruf . '.inv.' . date('y') . '.' . sprintf("%05s", $urutan);
    }
}

/* End of file ModelName.php */
