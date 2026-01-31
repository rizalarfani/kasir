<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    function get_prov(){
        return $this->db->get('provinces')->result();
    }
 
    function get_kota($id){
        $hasil=$this->db->query("SELECT * FROM cities WHERE prov_id='$id'");
        return $hasil->result();
    }

    function get_kecamatan($id){
        $hasil=$this->db->query("SELECT * FROM districts WHERE city_id='$id'");
        return $hasil->result();
    }

    function get_desa($id){
        $hasil=$this->db->query("SELECT * FROM subdistricts WHERE dis_id='$id'");
        return $hasil->result();
    }

    function get_user($level,$id){
        if($level==4){
            $this->db->where('add_by', $id);
            
        }
       return $this->M_Universal->getMulti(null, "user");

    }

}

/* End of file ModelName.php */
