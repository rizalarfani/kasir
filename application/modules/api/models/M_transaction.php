<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Transaction extends CI_Model
{
    public function getCount($user_id, $toko_id)
    {
        $this->db->select('
            COALESCE(SUM(orders.total_price),0) as income,
            COALESCE(SUM(orders.total_items),0) as total_quantity,
            COUNT(orders.id) as transaction_amount,
        ');
        $this->db->where([
            'orders.user_id' => $user_id,
            'orders.toko_id' => $toko_id,
            'DATE(orders.order_date)' => date('y-m-d'),

        ]);
        $data = $this->db->get('orders')->row();
        return (count((array)$data) > 0) ? $data : false;
    }

    public function getHistoryTransaction($user_id, $toko_id, $start_date, $end_date)
    {
        $this->db->select(
            'orders.name,
            orders.order_number,
            orders.total_price,
            orders.total_items,
            orders.order_date
        '
        );
        $this->db->where([
            'orders.user_id' => $user_id,
            'orders.toko_id' => $toko_id,
        ]);
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(orders.order_date) BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        } else {
            $this->db->where([
                'DATE_FORMAT(orders.order_date,"%y")' => date('y'),
                'DATE_FORMAT(orders.order_date,"%m")' => date('m'),
            ]);
        }
        $data = $this->db->get('orders')->result();
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
            'order_number' => $id_order,
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
/* End of file ModelName.php */
