<?php

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth', 'auth');
        $this->load->helper('jwt_helper');
    }

    public function login_post()
    {
        $username = $this->post('username', true);
        $password = $this->post('password', true);
        $validasi = $this->auth->validasi($username, $password);
        if ($validasi) {
            $token = [
                'expired' => time() + getenv('EXPIRED'),
                'data' => $validasi
            ];
            $jwt = JwtAuth::jwtEncode($token);
            $this->M_Universal->update(['access_token' => $jwt], ['user_nama' => $username], 'user');
            $response = [
                'status' => true,
                'message' => 'Login Berhasil!!',
                'access_token' => $jwt,
                'expired_at' => time() + getenv('EXPIRED'),
                'token_type' => 'Bearer',
                'user' => $validasi,
            ];
            $this->response($response, RestController::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => 'Username atau password Anda salah!!',
            ];
            $this->response($response, RestController::HTTP_UNAUTHORIZED);
        }
    }

    public function forgotPassword_post()
    {
        $email = $this->post('email', true);
        $get_user = $this->M_Universal->getOneSelect('user_id', ['email_user' => $email], 'user');
        if ($get_user) {
            $user_id = $get_user->user_id;
            $digits = 4;
            $code = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $token = [
                'expired' => time() + getenv('EXPIRED'),
                'data' => $code
            ];
            $jwt = JwtAuth::jwtEncode($token);
            $insert = $this->M_Universal->insert(['user_id' => $user_id, 'code_otp' => $code, 'token_otp' => $jwt], 'code_otp');
            ($insert) ? $response = ['status' => true, 'message' => 'Kode OTP telah dikirim ke email!', 'token' => $jwt] : $response = ['status' => false, 'message' => 'Gagal!!'];
            $this->response($response, RestController::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => 'Email user tidak ditemukan!!'
            ];
            $this->response($response, RestController::HTTP_NOT_FOUND);
        }
    }

    public function validateCodeOtp_post()
    {
        $code_otp = $this->post('code_otp');
        $token = $this->post('token_otp');
        $get_otp = $this->M_Universal->getOneSelect('code_otp,user_id', ['token_otp' => $token], 'code_otp');
        if ($get_otp) {
            if ($get_otp->otp == $code_otp) {
                $this->response([
                    'status' => true,
                    'message' => 'Code OTP valid!',
                    'data' => [
                        'user_id' => (int)$get_otp->user_id,
                    ],
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Code OTP yang dikirim tidak valid!!'
                ], RestController::HTTP_FORBIDDEN);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Token tidak ditemukan!!'
            ], RestController::HTTP_NOT_FOUND);
        }
    }
    public function logout_post()
    {
        $token = JwtAuth::validateToken();
        $user_id = $token->data->id_user;
        if ($token) {
            $update = $this->M_Universal->update(['access_token' => NULL], ['user_id' => $user_id], 'user');
            ($update) ? $response = ['status' => true, 'message' => 'Berhasil logout'] : $response = ['status' => false, 'message' =>
            'Gagal logout!'];
            $this->response($response, RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Token Unauthorized'], RestController::HTTP_UNAUTHORIZED);
        }
    }
}
