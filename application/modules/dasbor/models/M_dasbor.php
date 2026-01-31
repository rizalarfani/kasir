<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dasbor extends CI_Model
{

    function grafik()
    {
        $this->load->library('session');
        if (in_array($this->session->userdata('log_admin')['user_level'], array('1', '2'))) {
            $this->db->select('SUM(total_items) as laku, Date(order_date) as tgl');
            $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
            $this->db->group_by('DATE(order_date)');
            return $this->db->get('order_items')->result();
        } else if ($this->session->userdata('log_admin')['user_level'] == '3') {
            $this->db->select('stok_out.qty as laku, Date(order_date) as tgl');
            $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
            $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
            $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
            $this->db->where('id_mitra', $this->session->userdata('log_admin')['user_id']);
            $this->db->group_by('DATE(order_date)');
            return $this->db->get('stok_out')->result();
        } else if ($this->session->userdata('log_admin')['user_level'] == '4') {
            $this->db->select('stok_out.qty as laku, Date(order_date) as tgl');
            $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
            $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
            $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
            $this->db->join('user', 'user.user_id = orders.user_id', 'inner');
            $this->db->where('user.add_by', $this->session->userdata('log_admin')['user_id']);
            $this->db->group_by('DATE(order_date)');
            return $this->db->get('stok_out')->result();
        } else if ($this->session->userdata('log_admin')['user_level'] == '5') {

            $this->db->select('stok_out.qty as laku, Date(order_date) as tgl');
            $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
            $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
            $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
            $this->db->join('user', 'user.user_id = orders.user_id', 'inner');
            $this->db->where('user.user_id', $this->session->userdata('log_admin')['user_id']);
            $this->db->group_by('DATE(order_date)');
            return $this->db->get('stok_out')->result();
        }
    }

    function grafik_inv()
    {
        $this->load->library('session');
        if (in_array($this->session->userdata('log_admin')['user_level'], array('1', '2'))) {
            $this->db->select('SUM(jumlah) as laku, Date(last_update) as tgl');
        } else if ($this->session->userdata('log_admin')['user_level'] == '3') {
            $this->db->select('SUM(jumlah) as laku, Date(last_update) as tgl');
            $this->db->where('id_mitra', $this->session->userdata('log_admin')['user_id']);
        } else if ($this->session->userdata('log_admin')['user_level'] == '4') {
            $this->db->select('SUM(jumlah) as laku, Date(last_update) as tgl');
            $this->db->where('toko_id', $this->session->userdata('log_admin')['user_id']);
        } else if ($this->session->userdata('log_admin')['user_level'] == '5') {
            $this->db->select('SUM(jumlah) as laku, Date(last_update) as tgl');
            $this->db->join('user', 'user.user_id = stok_masuk.toko_id', 'inner');
            $this->db->where('user.add_by', $this->session->userdata('log_admin')['user_addby']);
        }
        $this->db->where('order_number !=', '');
        $this->db->group_by('DATE(last_update)');
        return $this->db->get('stok_masuk')->result();
    }
}

/* End of file M_dasbor.php */
