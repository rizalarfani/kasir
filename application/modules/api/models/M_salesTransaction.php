<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_SalesTransaction extends CI_Model
{

    public function getProducts($toko_id, $id_product, $id_category)
    {
        $this->db->select('
            products.id as id_product,
            products.category_id as id_category,
            products.name as product_name,
            product_category.name as product_category_name,
            products.kode_barang as product_code,
            products.description as product_description,
            harga.jual as price_sale,
            harga.id as id_price,
        ');
        $this->db->select('(SELECT COALESCE(SUM(stok_masuk.jumlah),0) FROM stok_masuk WHERE stok_masuk.product_id = products.id AND stok_masuk.toko_id = ' . $toko_id . ') AS stock_masuk', FALSE);
        $this->db->select('(SELECT COALESCE(SUM(order_items.order_qty),0) FROM orders LEFT JOIN order_items ON order_items.order_id = orders.id WHERE order_items.product_id = products.id AND orders.toko_id = stok_masuk.toko_id) AS stock_sold', FALSE);
        $this->db->select('(select (stock_masuk - stock_sold)) as stock', FALSE);
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('product_category', 'product_category.id=products.category_id', 'inner');
        $this->db->join('harga', 'harga.product_id = products.id', 'inner');
        $this->db->where('stok_masuk.toko_id', $toko_id);
        $this->db->where('products.is_inven', '0');
        if ($id_product) {
            $this->db->where('products.id', $id_product);
        }
        if ($id_category) {
            $this->db->where('products.category_id', $id_category);
        }
        $this->db->group_by('stok_masuk.product_id');
        $this->db->order_by('products.id', 'asc');
        $data = $this->db->get('stok_masuk')->result();
        return (count((array)$data) > 0) ? $data : false;
    }

    public function generateOrderNumber($add_by)
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
        $huruf = $toko->user_nama;
        $urutan++;
        return $huruf . '.' . date('y') . '.' . sprintf("%05s", $urutan);
    }

    public function cek_stok($product_id, $mitra)
    {
        $this->db->select('stok_masuk.jumlah as ins,stok_out.qty as outs, COALESCE(stok_masuk.jumlah,0)-COALESCE(stok_out.qty,0) as sisane,stok_masuk.id as id_stock_in,stok_out.id as stock_out_id,
        ');
        $this->db->join('stok_masuk', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('stok_out', 'stok_out.id_stok = stok_masuk.id', 'left');
        $this->db->where('toko_id', $mitra);
        $this->db->where('products.id', $product_id);
        $this->db->order_by('stok_masuk.id', 'asc');
        $this->db->group_by('stok_masuk.id');
        return $this->db->get('products')->result();
    }

    public function getStock($toko_id, $id_product)
    {
        $this->db->select('(SELECT COALESCE(SUM(stok_masuk.jumlah),0) FROM stok_masuk WHERE stok_masuk.product_id = products.id AND stok_masuk.toko_id = ' . $toko_id . ') AS stock_masuk', FALSE);
        $this->db->select('(SELECT COALESCE(SUM(order_items.order_qty),0) FROM orders LEFT JOIN order_items ON order_items.order_id = orders.id WHERE order_items.product_id = products.id AND orders.toko_id = stok_masuk.toko_id) AS stock_sold', FALSE);
        $this->db->select('(select (stock_masuk - stock_sold)) as stock', FALSE);
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->where('stok_masuk.toko_id', $toko_id);
        $this->db->where('products.is_inven', '0');
        if ($id_product) {
            $this->db->where('products.id', $id_product);
        }
        $this->db->group_by('stok_masuk.product_id');
        $this->db->order_by('products.id', 'asc');
        $data = $this->db->get('stok_masuk')->row();
        return (count((array)$data) > 0) ? $data : false;
    }

    public function getDetailTransaction($user_id, $toko_id, $id_order)
    {
        $this->db->select('
            products.name as product_name,
            order_items.order_qty as order_qty,
            order_items.harga as unit_cost,
            orders.name as order_name,
            orders.order_number as order_id,
            orders.order_date as order_date,
            orders.total_price as total_price,
            orders.bayar as customer_pay,
            user.user_namalengkap as cashier,
        ');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('user', 'user.user_id = orders.user_id', 'inner');
        $this->db->order_by('order_items.id', 'asc');
        $this->db->where([
            'orders.user_id' => $user_id,
            'orders.toko_id' => $toko_id,
            'orders.id' => $id_order,
        ]);
        $data = $this->db->get('order_items')->result_array();
        return (count((array)$data) > 0) ? $data : false;
    }

    public function getLocationStore($toko_id)
    {
        $this->db->select('prov_name,city_name,dis_name,lengkap,user.no_hp_user');
        $this->db->join('lokasi', 'lokasi.id_mitra = user.user_id', 'inner');
        $this->db->join('provinces', 'provinces.prov_id = lokasi.id_prop', 'inner');
        $this->db->join('cities', 'cities.city_id = lokasi.id_kab', 'inner');
        $this->db->join('districts', 'districts.dis_id = lokasi.id_kec', 'inner');
        $this->db->where('user.user_id', $toko_id);
        $data = $this->db->get('user')->row();
        return (count((array)$data) > 0) ? $data : false;
    }
}

/* End of file M_SalesTransaction.php */
