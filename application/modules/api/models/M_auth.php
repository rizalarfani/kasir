<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
    public function validasi($username, $password)
    {
        $data = $this->db->get_where('user', [
            'user_nama LIKE BINARY' => $username,
            'user_level' => 5,
        ])->row();
        if ($data) {
            if (password_verify($password, $data->user_password)) {
                return array(
                    'id_user' => (int)$data->user_id,
                    'toko_id' => (int)$data->add_by,
                    'username' => $username,
                    'fullname' => $data->user_namalengkap,
                    'email' => ($data->email_user) ?? '',
                    'phone_number' => ($data->no_hp_user) ?? '0',
                    'image_url' => ($data->photo_user) ? 'http://192.168.22.120/hfc/uploads/profile/' . $data->photo_user : '',
                );
            } else {
                return 0;
            }
        }
    }
}

/* End of file ModelName.php */
