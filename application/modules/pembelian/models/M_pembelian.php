<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembelian extends CI_Model
{
    function get_data($start_date, $end_date, $level, $id)
    {
        $this->db->select('order_items.id,stok_masuk.id_mitra,products.name,qty,user_namalengkap,(jual*qty) as jual,order_date,orders.order_number');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('harga', 'harga.id = stok_masuk.id_harga', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('product_category', 'product_category.id = products.category_id', 'inner');
        $this->db->join('user', 'user.user_id = orders.toko_id', 'inner');
        $this->db->order_by('order_date', 'asc');
        if ($start_date == null) {
            $start_date = $end_date = date("Y-m-d");
        }
        if ($level == 4) {
            $this->db->where('stok_masuk.toko_id', $id);
        }
        if ($level == 5) {
            $this->db->where('orders.user_id', $id);
        }
        $this->db->where('DATE(order_date) BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        return $this->M_Universal->getMulti(Null, "stok_out");
    }

    function get_produk($addby)
    {
        $this->db->select('products.id,products.name');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->where('toko_id', $addby);
        $this->db->group_by('stok_masuk.product_id');
        return $this->db->get('stok_masuk')->result();
    }

    function get_produk_awal($addby = null, $id)
    {
        $this->db->select('COALESCE(sum(jumlah),0) as awal');
        $this->db->join('stok_masuk', 'stok_masuk.product_id = products.id', 'inner');
        $this->db->where('stok_masuk.product_id', $id);
        if ($addby != null) {
            $this->db->where('stok_masuk.toko_id', $addby);
        } else {
            $this->db->group_by('stok_masuk.toko_id');
        }

        return $this->db->get('products')->row('awal');
    }

    function get_produk_laku($addby = null, $id)
    {
        $this->db->select('COALESCE(sum(order_qty),0) as laku');
        $this->db->join('order_items', 'order_items.order_id = orders.id', 'left');
        $this->db->where('order_items.product_id', $id);
        if ($addby != null) {
            $this->db->where('orders.toko_id', $addby);
        } else {
            $this->db->group_by('orders.toko_id');
        }
        return $this->db->get('orders')->row('laku');
    }


    function get_produk_akhir($addby = null, $id)
    {

        $awal = $this->get_produk_awal($addby, $id);
        $laku = $this->get_produk_laku($addby, $id);
        return $awal - $laku;
    }




    function cek_stok($product, $mitra)
    {
        $this->db->select('stok_masuk.jumlah as ins,stok_out.qty as outs, COALESCE(stok_masuk.jumlah,0)-COALESCE(stok_out.qty,0) as sisane,
   stok_masuk.id as msk_id,stok_out.id as out_id,
        ');
        $this->db->join('stok_masuk', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('stok_out', 'stok_out.id_stok = stok_masuk.id', 'left');
        $this->db->where('toko_id', $mitra);
        $this->db->where('products.id', $product);
        $this->db->order_by('stok_masuk.id', 'asc');
        $this->db->group_by('stok_masuk.id');
        return $this->db->get('products')->result();
    }

    function get_temp($id)
    {
        $this->db->select('order_items_temp.id,products.name, order_qty,jual,(order_qty*jual) as total');
        $this->db->join('harga', 'harga.id = order_items_temp.id_harga', 'inner');
        $this->db->join('products', 'products.id = order_items_temp.product_id', 'inner');
        return $this->M_Universal->getMulti(array('user_id' => $id), "order_items_temp");
    }

    function order_no($add_by)
    {
        $toko =  $this->M_Universal->getOne(array('user_id' => $add_by), "user");
        $this->db->select('order_number');
        $this->db->join('user', 'user.user_id = orders.user_id', 'inner');
        $this->db->where('user.add_by', $toko->user_id);
        $hasil = $this->db->get('orders')->last_row();
        if (!$hasil) {
            $urutan = 0;
        } else {
            $kode = $hasil->order_number;
            $urutan = substr($kode, strpos($kode, ".") + 4);
        }
        $urutan++;
        $huruf = $toko->user_nama;
        return $huruf . '.' . date('y') . '.' . sprintf("%05s", $urutan);
    }

    function get_data_kasir($start_date, $end_date, $level, $id)
    {
        $this->db->select('orders.*,name');
        $this->db->join('user', 'user.user_id = orders.toko_id', 'inner');
        $this->db->order_by('order_date', 'asc');
        if ($start_date == null) {
            $start_date = $end_date = date("Y-m-d");
        }
        if ($level == 4) {
            $this->db->where('toko_id', $id);
        }
        if ($level == 5) {
            $this->db->where('orders.user_id', $id);
        }
        $this->db->where('DATE(order_date) BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        return $this->M_Universal->getMulti(Null, "orders");
    }

    function get_data_kasir_detail($id)
    {
        $this->db->select('order_items.*,user_namalengkap,order_number,orders.toko_id,order_date, products.name as produk,description, bayar');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('user', 'user.user_id = orders.toko_id', 'inner');
        $this->db->order_by('order_items.id', 'asc');
        return $this->M_Universal->getMulti(array('order_number' => $id), "order_items");
    }

    function get_kasir($id)
    {
        $this->db->select('user_namalengkap');
        $this->db->join('orders', 'orders.user_id = user.user_id', 'inner');
        $this->db->where('order_number', $id);
        return $this->db->get('user')->row();
    }
}

/* End of file ModelName.php */
