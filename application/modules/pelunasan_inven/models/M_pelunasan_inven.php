<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pelunasan_inven extends CI_Model
{

    function get_data($level, $id)
    {
        $this->db->select('SUM(total) as total,  verifikasi.code_pay, date_created,status');
        $this->db->join('generate_code', 'generate_code.code_pay = verifikasi.code_pay', 'inner');
        // $this->db->join('stok_masuk', 'stok_masuk.code_pays = verifikasi.code_pay', 'inner');

        $this->db->group_by('verifikasi.code_pay');
        if ($level == 4) {
            $this->db->where('user_id', $id);
        }
        $this->db->order_by('date_created', 'desc');
        return $this->M_Universal->getMulti(Null, "verifikasi");
    }

    function get_detail_mitra($code, $u)
    {
        $this->db->select('products.name,stok_masuk.jumlah as qty,hpp,(stok_masuk.jumlah*hpp) as total, stok_masuk.last_update');
        $this->db->join('products', 'stok_masuk.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->join('user', 'user.user_id = stok_masuk.id_mitra', 'inner');
        $this->db->where('code_pays', $code);
        $this->db->where('user.user_id', $u);
        $this->db->order_by('user_namalengkap', 'asc');
        // $this->db->group_by('products.id');
        // $this->db->group_by('hpp');
        // $this->db->group_by('jual');
        $this->db->group_by('stok_masuk.id');

        return $this->db->get('stok_masuk')->result();
    }


    function get_detail_hfc($code)
    {
        $this->db->select('products.name,stok_masuk.jumlah as qty,manajemen,(stok_masuk.jumlah*manajemen) as total, stok_masuk.last_update');
        $this->db->join('products', 'stok_masuk.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->where('code_pays', $code);
        // $this->db->group_by('products.id');
        // $this->db->group_by('manajemen');
        $this->db->group_by('stok_masuk.id');

        return $this->db->get('stok_masuk')->result();
    }


    function get_detail_it($code)
    {
        $this->db->select('products.name,stok_masuk.jumlah as qty,it,(stok_masuk.jumlah*it) as total, stok_masuk.last_update');
        $this->db->join('products', 'stok_masuk.product_id = products.id', 'inner');
        $this->db->join('product_category', 'products.category_id = product_category.id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        $this->db->where('code_pays', $code);
        // $this->db->group_by('products.id');
        // $this->db->group_by('it');
        $this->db->group_by('stok_masuk.id');

        return $this->db->get('stok_masuk')->result();
    }

    function get_mitra($code, $user)
    {
        $this->db->select('user_namalengkap,user_id');
        $this->db->join('user', 'user.user_id = stok_masuk.id_mitra', 'inner');
        $this->db->where('stok_masuk.code_pays', $code);
        if ($user) {
            $this->db->where('stok_masuk.id_mitra', $user);
        }
        $this->db->order_by('user_namalengkap', 'asc');
        $this->db->group_by('user_namalengkap');
        return $this->db->get('stok_masuk')->result();
    }




    function generate($akhir)
    {
        $this->db->select('stok_masuk.*,(jumlah*toko) as total,products.name');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($akhir == null) {
            $akhir = date("Y-m-d");
        }
        $this->db->where('DATE(stok_masuk.last_update) <=', $akhir);
        $this->db->where('code_pays', '');
        $this->db->where('is_inven', '1');
        return $this->db->get('stok_masuk')->result();
    }

    function generate_proses_mitra($tgl)
    {
        $this->db->select('hpp,(hpp*sum(jumlah)) as total,sum(jumlah) as qty,stok_masuk.id_mitra');

        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(stok_masuk.last_update) <=', $tgl);
        $this->db->where('is_inven', '1');
        $this->db->where('code_pays', '');

        $this->db->group_by('stok_masuk.id_mitra');
        $this->db->group_by('hpp');
        return $this->db->get('stok_masuk')->result();
    }


    function generate_proses_it($tgl)
    {
        $this->db->select('it,(it*sum(jumlah)) as total,sum(jumlah) as qty');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(stok_masuk.last_update) <=', $tgl);
        $this->db->where('is_inven', '1');
        $this->db->where('code_pays', '');

        $this->db->group_by('it');
        return $this->db->get('stok_masuk')->result();
    }

    function generate_proses_manajemen($tgl)
    {
        $this->db->select('manajemen,(manajemen*sum(jumlah)) as total,sum(jumlah) as qty');
        $this->db->join('products', 'products.id = stok_masuk.product_id', 'inner');
        $this->db->join('harga', 'stok_masuk.id_harga = harga.id', 'inner');
        if ($tgl == null) {
            $tgl = date("Y-m-d");
        }
        $this->db->where('DATE(stok_masuk.last_update) <=', $tgl);
        $this->db->where('is_inven', '1');
        $this->db->where('code_pays', '');

        $this->db->group_by('manajemen');
        return $this->db->get('stok_masuk')->result();
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


    function cek_inven($code)
    {
        $this->db->select('is_inven');
        $this->db->where('code_pay', $code);
        return $this->db->get('verifikasi')->row('is_inven');
    }
}

/* End of file ModelName.php */
