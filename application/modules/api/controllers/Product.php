<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends RestController
{

    protected $token;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('jwt_helper');
        $this->load->model('M_product', 'product');
        $this->token = JwtAuth::validateToken();
        if (!$this->token) {
            $this->response(['status' => false, 'message' => 'Token Unauthorized'], RestController::HTTP_UNAUTHORIZED);
        }
    }

    public function getProducts_get()
    {
        $id_product = $this->get('id_product');
        $id_category = $this->get('category_id');
        $toko_id = $this->token->data->toko_id;
        if ($toko_id) {
            $getProducts = $this->product->getProducts($toko_id, $id_product, $id_category);
            if ($getProducts) {
                $this->response(['status' => true, 'message' => 'Product ditemukan', 'data' => $getProducts], RestController::HTTP_OK);
            } else {
                $this->response(['status' => true, 'message' => 'Product tidak ditemukan'], RestController::HTTP_OK);
            }
        } else {
            $this->response(['status' => false, 'message' => 'Forbidden'], RestController::HTTP_FORBIDDEN);
        }
    }

    public function getCategoryProducts_get()
    {
        $toko_id = $this->token->data->toko_id;
        if ($toko_id) {
            $getCategory = $this->product->getCategoryProducts($toko_id);
            if ($getCategory) {
                $this->response(['status' => true, 'message' => 'Category product ditemukan', 'data' => $getCategory], RestController::HTTP_OK);
            } else {
                $this->response(['status' => true, 'message' => 'Category product tidak ditemukan'], RestController::HTTP_OK);
            }
        } else {
            $this->response(['status' => false, 'message' => 'Forbidden'], RestController::HTTP_FORBIDDEN);
        }
    }
}
/* End of file Product.php */
