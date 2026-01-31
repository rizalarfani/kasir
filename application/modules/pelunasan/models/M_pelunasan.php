<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pelunasan extends CI_Model
{

    function get_data($level, $id)
    {
        $this->db->select('SUM(total) as total,  verifikasi_adm.code_pay, date_created,status');
        $this->db->join('generate_code', 'generate_code.code_pay = verifikasi_adm.code_pay', 'inner');
        // $this->db->join('stok_out', 'stok_out.code_pay = verifikasi_adm.code_pay', 'inner');

        $this->db->group_by('verifikasi_adm.code_pay');
        if ($level == 4) {
            $this->db->where('user_id', $id);
        }
        if ($id == 1) {
            $this->db->where('user_id', $id);
        }
        $this->db->order_by('date_created', 'desc');
        return $this->M_Universal->getMulti(Null, "verifikasi_adm");
    }

    function get_data_it()
    {
        $this->db->select('SUM(total) as total,  verifikasi_adm.code_pay, date_created,status');
        $this->db->join('generate_code', 'generate_code.code_pay = verifikasi_adm.code_pay', 'inner');
        $this->db->where('user_id', 1);
        $this->db->group_by('verifikasi_adm.code_pay');
        $this->db->order_by('date_created', 'desc');
        return $this->M_Universal->getMulti(Null, "verifikasi_adm");
    }

    function get_detail_mitra($code, $u)
    {
        $this->db->select('products.name,sum(stok_out.qty) as qty,hpp,(sum(stok_out.qty)*hpp) as total, order_date');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'order_items.order_id = orders.id', 'inner');
        $this->db->join('products', 'order_items.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.id_mitra', 'inner');
        $this->db->where('code_pay', $code);
        $this->db->where('user.user_id', $u);
        $this->db->order_by('user_namalengkap', 'asc');
        $this->db->group_by('products.id');
        $this->db->group_by('hpp');
        $this->db->group_by('jual');
        return $this->db->get('stok_out')->result();
    }


    function get_detail_hfc($code)
    {
        $this->db->select('products.name,sum(stok_out.qty) as qty,manajemen,(sum(stok_out.qty)*manajemen) as total, order_date');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'order_items.order_id = orders.id', 'inner');
        $this->db->join('products', 'order_items.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->where('code_pay', $code);
        $this->db->group_by('products.id');
        $this->db->group_by('manajemen');
        return $this->db->get('stok_out')->result();
    }

    function get_detail_toko($code, $u)
    {
        $this->db->select('products.name,sum(stok_out.qty) as qty,toko,(sum(stok_out.qty)*toko) as total, order_date');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'order_items.order_id = orders.id', 'inner');
        $this->db->join('products', 'order_items.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.toko_id', 'inner');
        $this->db->where('code_pay', $code);
        $this->db->where('user.user_id', $u);
        $this->db->order_by('user_namalengkap', 'asc');
        $this->db->group_by('products.id');
        $this->db->group_by('toko');
        return $this->db->get('stok_out')->result();
    }

    function get_detail_it($code)
    {
        $this->db->select('products.name,sum(stok_out.qty) as qty,it,sum(stok_out.qty)*it as total, order_date');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'order_items.order_id = orders.id', 'inner');
        $this->db->join('products', 'order_items.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->where('code_pay', $code);
        $this->db->group_by('products.id');
        $this->db->group_by('it');
        return $this->db->get('stok_out')->result();
    }

    function get_mitra($code, $user)
    {
        $this->db->select('user_namalengkap,user_id');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.id_mitra', 'inner');
        $this->db->where('stok_out.code_pay', $code);
        if ($user) {
            $this->db->where('stok_masuk.id_mitra', $user);
        }
        $this->db->order_by('user_namalengkap', 'asc');
        $this->db->group_by('user_namalengkap');
        return $this->db->get('stok_out')->result();
    }

    function get_toko($code, $user)
    {
        $this->db->select('user_namalengkap,user_id');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.toko_id', 'inner');
        $this->db->where('stok_out.code_pay', $code);
        if ($user) {
            $this->db->where('stok_masuk.toko_id', $user);
        }
        $this->db->order_by('user_namalengkap', 'asc');
        $this->db->group_by('user_namalengkap');
        return $this->db->get('stok_out')->result();
    }

    public function generate_it($akhir)
    {
        $this->db->select('code_pay');
        $this->db->where('DATE(date_created) <=', $akhir);
        $this->db->from('generate_code');
        $where_clause = $this->db->get_compiled_select();

        $this->db->select('verifikasi_adm.code_pay, total, last_update');
        $this->db->where("`code_pay` IN ($where_clause)", NULL, FALSE);
        $this->db->where('status', 0);
        $this->db->where('user_id', '1'); #it
        return $this->db->get('verifikasi_adm')->result();
    }



    function generate($akhir)
    {
        $this->db->select('stok_out.*,jual,(jual*qty) as jumlah,products.name,order_date,id_mitra,orders.toko_id');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($akhir == null) {
            $akhir = date("Y-m-d");
        }
        $this->db->where('DATE(order_date) <=', $akhir);
        $this->db->where('code_pay', '');
        return $this->db->get('stok_out')->result();
    }

    function generate_proses_mitra($tgl)
    {
        $this->db->select('hpp,(hpp*sum(qty)) as jumlah,sum(qty) as qty,stok_masuk.id_mitra');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(order_date) <=', $tgl);
        $this->db->where('code_pay', '');
        $this->db->group_by('stok_masuk.id_mitra');
        $this->db->group_by('hpp');
        return $this->db->get('stok_out')->result();
    }


    function generate_proses_it($tgl)
    {
        // $this->db->select('code_pay');
        // $this->db->from('generate_code');
        // $this->db->where('DATE(date_Created) BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        // $where_clause = $this->db->get_compiled_select();

        $this->db->select('it,(it*sum(qty)) as jumlah,sum(qty) as qty');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        // $this->db->where("`code_pay` IN ($where_clause)", NULL, FALSE);
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(order_date) <=', $tgl);
        $this->db->where('code_pay', '');
        $this->db->group_by('it');
        return $this->db->get('stok_out')->result();
    }

    function generate_proses_manajemen($tgl)
    {
        $this->db->select('manajemen,(manajemen*sum(qty)) as jumlah,sum(qty) as qty');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(order_date) <=', $tgl);
        $this->db->where('code_pay', '');
        // $this->db->group_by('stok_out.id');
        // $this->db->group_by('products.id');
        $this->db->group_by('manajemen');
        return $this->db->get('stok_out')->result();
    }

    function generate_proses_toko($tgl)
    {
        $this->db->select('toko,(toko*sum(qty)) as jumlah,sum(qty) as qty,orders.toko_id');
        $this->db->join('order_items', 'order_items.id = stok_out.order_item_id', 'inner');
        $this->db->join('orders', 'orders.id = order_items.order_id', 'inner');
        $this->db->join('stok_masuk', 'stok_masuk.id = stok_out.id_stok', 'inner');
        $this->db->join('products', 'products.id = order_items.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(order_date) <=', $tgl);
        $this->db->where('code_pay', '');
        // $this->db->group_by('stok_out.id');
        $this->db->group_by('toko');
        $this->db->group_by('orders.toko_id');
        return $this->db->get('stok_out')->result();
    }

    function order_no()
    {
        $hasil = $this->db->get('generate_code')->last_row();
        if (!$hasil) {
            $urutan = 0;
        } else {
            $kode = $hasil->code_pay;
            $urutan = end(explode('.', $kode));
        }
        $urutan++;
        return date('y') . '.' . date('m') . '.' . date('d') . '.' . $urutan;
    }

    function cek_pelunasan($code, $id)
    {
        $this->db->where('code_pay', $code);
        $this->db->where('user_id', $id);
        return $this->db->get('verifikasi_adm')->row();
    }

    function lunas($code, $id)
    {
        $this->db->where('code_pay', $code);
        $this->db->where('user_id', $id);
        return  $this->db->update('verifikasi_adm', array('status' => 1));
    }

    function get_lunas_user($user_id)
    {
        $this->db->select('verifikasi_adm.*, is_inven');
        $this->db->join('verifikasi', 'verifikasi.code_pay = verifikasi_adm.code_pay', 'inner');
        $this->db->where('verifikasi_adm.user_id', $user_id);
        $this->db->order_by('last_update', 'desc');
        $this->db->group_by('verifikasi_adm.id');
        return   $this->db->get('verifikasi_adm')->result();
    }

    function cek_inven($code)
    {
        $this->db->select('is_inven');
        $this->db->where('code_pay', $code);
        return $this->db->get('verifikasi')->row('is_inven');
    }
}

/* End of file ModelName.php */
