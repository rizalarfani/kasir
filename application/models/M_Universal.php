<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_universal extends CI_Model
{
    public function getOne($where, $tabel)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }

        $data = $this->db->get($tabel)->row();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getOneSelect($select, $where, $table)
    {
        $this->db->select($select);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $data = $this->db->get($table)->row();
        return $data;
    }
    public function getMulti($where, $tabel)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $data = $this->db->get($tabel)->result();
        return $data;
    }
    public function getMultiSelect($select, $where, $tabel)
    {
        $this->db->select($select);
        if (!empty($where)) {
            $this->db->where($where);
        }

        $data = $this->db->get($tabel)->result();
        return $data;
    }

    public function update($data, $where, $tabel)
    {
        $this->db->where($where);
        $update = $this->db->update($tabel, $data);
        return ($update) ? true : false;
    }

    public function insert($data, $tabel)
    {
        return ($this->db->insert($tabel, $data)) ? true : false;
    }

    public function delete($where, $tabel)
    {
        return ($this->db->where($where)->delete($tabel)) ? true : false;
    }
    public function getOrderBy($where, $tabel, $order, $urutan, $limit)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($urutan)) {
            $this->db->order_by($order, $urutan);
        } else {
            $this->db->order_by($order);
        }
        if (!empty($limit)) {
            $this->db->limit($limit);
        }

        $data = $this->db->get($tabel)->result();
        return $data;
    }
    public function insert_batch($data, $tabel)
    {
        $this->db->trans_start();
        $this->db->insert_batch($tabel, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getGroupSelect($select, $where, $tabel, $group, $order, $urutan)
    {
        $this->db->select($select);
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($group)) {
            $this->db->group_by($group);
        }
        if (!empty($order)) {
            $this->db->order_by($order, $urutan);
        }

        $data = $this->db->get($tabel)->result();
        return $data;
    }

    public function multiple_delete($colom, $data_id, $tabel)
    {
        $this->db->where_in($colom, $data_id);
        return $this->db->delete($tabel);
    }

    public function getCount($where, $tabel)
    {
        if ($where) {
            $this->db->where($where);
        }

        return $this->db->get($tabel)->num_rows();
    }
    public function format_rupiah($rp)
    {
        return number_format($rp, 2, ',', '.');
    }
}
