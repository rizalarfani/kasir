<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Account extends RestController
{

    protected $token;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('jwt_helper');
        $this->token = JwtAuth::validateToken();
        if (!$this->token) {
            $this->response(['status' => false, 'message' => 'Token Unauthorized'], RestController::HTTP_UNAUTHORIZED);
        }
    }

    public function changeProfile_post()
    {
        $fullname = $this->post('fullname', true);
        $email = $this->post('email', true);
        $phone = $this->post('phone_number', true);
        $user_id = $this->token->data->id_user;
        $profile = $_FILES['photo_profile']['name'];
        if ($user_id) {
            if ($profile) {
                $upload_profile = $this->_uploadPhoto($user_id);
                if (!$upload_profile['status']) {
                    $this->response(['status' => false, 'message' => $profile['message']], RestController::HTTP_OK);
                }
                $data = ['user_namalengkap' => $fullname, 'email_user' => $email, 'no_hp_user' => $phone, 'photo_user' => $upload_profile['message']];
            } else {
                $data = ['user_namalengkap' => $fullname, 'email_user' => $email, 'no_hp_user' => $phone];
            }
            $update = $this->M_Universal->update($data, ['user_id' => $user_id], 'user');
            $user = $this->M_Universal->getOne(['user_id' => $user_id], 'user');
            $data_user = [
                'id_user' => (int)$user->user_id,
                'username' => $user->user_nama,
                'fullname' => $user->user_namalengkap,
                'email' => ($user->email_user) ?? '',
                'phone_number' => ($user->no_hp_user) ?? '0',
                'image_url' => ($user->photo_user) ? 'http://192.168.22.120/hfc/uploads/profile/' . $user->photo_user : '',
            ];
            ($update) ? $this->response(['status' => true, 'message' => 'Berhasil update profile', 'user' => $data_user], RestController::HTTP_OK) : $this->response(['status' => false, 'message' => 'Gagal update profile'], RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Forbidden'], RestController::HTTP_FORBIDDEN);
        }
    }

    private function _uploadPhoto($user_id)
    {
        $config['upload_path'] = './uploads/profile';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['remove_spaces'] = true;
        $config['detect_mime']   = true;
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('photo_profile')) {
            return [
                'status' => false,
                'message' => $this->upload->display_errors()
            ];
        } else {
            $data = $this->upload->data();
            $before_photo = $this->M_Universal->getOneSelect('photo_user', ['user_id' => $user_id], 'user');
            if ($before_photo->photo_user) {
                unlink(FCPATH . 'uploads/profile/' . $before_photo->photo_user);
            }
            return [
                'status' => true,
                'message' => $data['file_name']
            ];
        }
    }
}
/* End of file Controllername.php */
