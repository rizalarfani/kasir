<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Web extends RestController {
    
    public function information_get(){
        $jumlah_cabang = $this->countCabang();
        $penjualan_now = $this->countPenjualanNow();
        $penjualan_bulan = $this->countPenjualanBulan();
        $monitoring_stok = $this->get_stock();
        $getHistoryTransaction = $this->getHistoryTransaction();
        
        $data = [
            'jumlah_cabang' => (int)$jumlah_cabang,
            'total_penjualan_now' => (int)$penjualan_now->income,
            'total_penjualan_bulan' => (int)$penjualan_bulan->income,
            'jumlah_transaksi' => (int)$penjualan_bulan->transaction_amount,
            'monitoring_stok' => $monitoring_stok,
            'transaksi_terakhir' => $getHistoryTransaction,
        ];
        $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
    }
    
    private function countCabang(){
        $this->db->select('user_id');
        $this->db->where('user_level', 4);
        return $this->db->get('user')->num_rows();
    }
    
    private function countPenjualanNow()
    {
        $this->db->select('
            COALESCE(SUM(orders.total_price),0) as income,
        ');
        $this->db->where([
            'DATE(orders.order_date)' => date('y-m-d'),

        ]);
        $data = $this->db->get('orders')->row();
        return (count((array)$data) > 0) ? $data : false;
    }
    
    private function countPenjualanBulan()
    {
        $this->db->select('
            COALESCE(SUM(orders.total_price),0) as income,
             COUNT(orders.id) as transaction_amount,
        ');
        $this->db->where([
            'MONTH(orders.order_date)' => date('m'),

        ]);
        $data = $this->db->get('orders')->row();
        return (count((array)$data) > 0) ? $data : false;
    }
    
    private function get_stock()
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
        $this->db->select('(SELECT COALESCE(SUM(stok_masuk.jumlah),0) FROM stok_masuk WHERE stok_masuk.product_id = products.id) AS stock_masuk', FALSE);
        $this->db->select('(SELECT COALESCE(SUM(order_items.order_qty),0) FROM orders LEFT JOIN order_items ON order_items.order_id = orders.id WHERE order_items.product_id = products.id AND orders.toko_id = stok_masuk.toko_id) AS stock_sold', FALSE);
        $this->db->select('(select (stock_masuk - stock_sold)) as stock', FALSE);
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('product_category', 'product_category.id=products.category_id', 'inner');
        $this->db->join('harga', 'harga.product_id = products.id', 'inner');
        $this->db->where('products.is_inven', '0');
        $this->db->limit('5');
        $this->db->group_by('stok_masuk.product_id');
        $this->db->order_by('stock','asc');
        $data = $this->db->get('stok_masuk')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    
    private function getHistoryTransaction()
    {
        $this->db->select(
            'orders.name,
            orders.order_number,
            orders.total_price,
            orders.total_items,
            orders.order_date,
            user.user_namalengkap,
        '
        );
        $this->db->join('user','user.user_id=orders.toko_id','inner');
        
        $this->db->limit(5);
        $this->db->order_by('orders.id','desc');
        $data = $this->db->get('orders')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
}