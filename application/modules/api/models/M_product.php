<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Product extends CI_Model
{
    public function getCategoryProducts($toko_id)
    {
        $this->db->select('product_category.name as name_category,product_category.id as id_category');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->where('toko_id', $toko_id);
        $this->db->group_by('product_category.id');
        $data = $this->db->get('stok_masuk')->result();
        return (count((array)$data) > 0) ? $data : false;
    }

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
}
/* End of file M_Product.php */
