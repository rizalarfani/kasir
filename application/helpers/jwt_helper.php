<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth
{
    static public function validateToken()
    {
        $CI = get_instance();
        $secret_key = getenv('SECRET_KEY');
        $token = null;
        $authHeader = $CI->input->request_headers()['Authorization'];
        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        if ($token) {
            try {
                $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
                return $decoded;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }
    static public function jwtEncode($token)
    {
        return JWT::encode($token, getenv('SECRET_KEY'), 'HS256');
    }
}
