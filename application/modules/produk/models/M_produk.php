<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_produk extends CI_Model
{
    public function get_all()
    {
        $this->db->select('products.*,product_category.name as kat,harga.jual,harga.it');
        $this->db->join('harga', 'products.id = harga.product_id', 'inner');
        $this->db->join('product_category', 'product_category.id = products.category_id', 'inner');
        $this->db->order_by('add_date', 'desc');
        return $this->db->get('products')->result();
    }

    public function get_harga($id)
    {
        $this->db->where('product_id', $id);
        return $this->db->get('harga')->last_row();
    }

    public function create_acronym($words)
    {
        $words = explode(' ', $words);
        $acronym = '';

        foreach ($words as $word) {
            $acronym .= $word[0];
        }
        $acronym = strtoupper($acronym);
        return $acronym;
    }
    public function create_product_sku($name, $category)
    {
        $name = $this->create_acronym($name);
        $category = $this->create_acronym($category);
        $key = substr(time(), -3);
        $sku =  $category . $name . $key;
        return $sku;
    }

    public function detail($id)
    {
        $this->db->join('products', 'products.id = harga.product_id', 'inner');
        $this->db->where('product_id', $id);
        return $this->db->get('harga')->last_row();
    }
}
/* End of file ModelName.php */
