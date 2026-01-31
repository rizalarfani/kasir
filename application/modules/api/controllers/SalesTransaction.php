<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class SalesTransaction extends RestController
{

    protected $token;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('jwt_helper');
        $this->load->model('M_salesTransaction', 'salesTransaction');
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
            $getProducts = $this->salesTransaction->getProducts($toko_id, $id_product, $id_category);
            if ($getProducts) {
                $this->response(['status' => true, 'message' => 'Product ditemukan', 'data' => $getProducts], RestController::HTTP_OK);
            } else {
                $this->response(['status' => true, 'message' => 'Product tidak ditemukan'], RestController::HTTP_OK);
            }
        } else {
            $this->response(['status' => false, 'message' => 'Forbidden'], RestController::HTTP_FORBIDDEN);
        }
    }

    private function cekStock($id_product, $qty, $toko_id)
    {
        $stock_in = $this->salesTransaction->cek_stok($id_product, $toko_id);
        $stock_gudang = $this->salesTransaction->getStock($toko_id, $id_product);
        if ((int)($stock_gudang->stock) < (int)$qty) {
            return false;
        }
        $sisa = array();
        $id_stock_in = array();

        foreach ($stock_in as $index => $data) {
            if ($data->sisane != '0' && $data->sisane != null) {
                $id_stock_in[] = $data->id_stock_in;
                $sisa[] = $data->sisane;
            }
        }
        $quantity = [];
        $id_stok = [];
        for ($i = 0; $i < count($sisa); $i++) {
            $sisaan = $qty - $sisa[$i];
            if ($sisaan < 0) {
                $kurang = $sisa[$i] + $sisaan;
                if ($kurang >= 0) {
                    array_push($quantity, (int)$kurang);
                    array_push($id_stok, (int)$id_stock_in[$i]);
                }
            } else {
                array_push($quantity, (int)$sisa[$i]);
                array_push($id_stok, (int)$id_stock_in[$i]);
            }
            $qty = $sisaan;
        }
        return [
            'qty' => $quantity,
            'id_stok' => $id_stok
        ];
    }

    public function order_post()
    {
        $customer_name = $this->post('customer_name', true);
        $customer_pay = $this->post('customer_pay', true);
        $customer_date = $this->post('customer_date', true);
        $customer_total_price = $this->post('customer_total_price', true);
        $customer_total_items = $this->post('customer_total_items', true);
        $customer_orders = $this->post('customer_orders', true);
        $user_id = $this->token->data->id_user;
        $toko_id = $this->token->data->toko_id;
        $order_id = $this->salesTransaction->generateOrderNumber($toko_id);

        $dataorder = array(
            'name' => $customer_name,
            'bayar' => $customer_pay,
            'order_date' => $customer_date,
            'order_number' => $order_id,
            'user_id' => $user_id,
            'toko_id' => $toko_id,
            'total_price' => $customer_total_price,
            'total_items' => $customer_total_items,
        );
        $this->db->trans_start();
        $this->db->insert('orders', $dataorder);
        $orderId = $this->db->insert_id();

        foreach ($customer_orders as $order) {
            $datas = array(
                'order_id' => $orderId,
                'product_id' => $order['product_id'],
                'order_qty' => $order['order_qty'],
                'harga' => $order['harga'],
                'id_harga' => $order['id_harga'],
            );
            $stok = $this->cekStock($order['product_id'], $order['order_qty'], $toko_id);
            if ($stok == False) {
                $this->db->trans_rollback();
                $this->response(['status' => false, 'message' => 'Gagal stok kurang'], RestController::HTTP_OK);
                exit;
            }
            $this->db->insert('order_items', $datas);
            $id_item = $this->db->insert_id();
            foreach ($stok['qty'] as $index => $s) {
                if ($s != 0) {
                    $out = array(
                        'qty' => $s,
                        'id_stok' => $stok['id_stok'][$index],
                        'order_item_id' => $id_item
                    );
                    $this->db->insert('stok_out', $out);
                }
            }
            $this->db->trans_commit();
        }
        $status = $this->db->trans_status();
        if ($status) {
            $orders = $this->salesTransaction->getDetailTransaction($user_id, $toko_id, $orderId);
            $data = [];
            $total_price = $orders[0]['total_price'];
            $locationStore = $this->salesTransaction->getLocationStore($toko_id);
            foreach ($orders as $order) {
                $response = [
                    'product_name' => $order['product_name'],
                    'order_qty' => (int)$order['order_qty'],
                    'unit_cost' => (int)$order['unit_cost'],
                    'order_id' => $order['order_id'],
                    'price' => (int)$order['unit_cost'] * $order['order_qty'],
                ];
                array_push($data, $response);
            }
            $this->response(['status' => true, 'data' => [
                'orders' => $data,
                'customer' => [
                    'customer_name' => $orders[0]['order_name'],
                    'customer_total' => (int)$total_price,
                    'customer_pay' => (int)$orders[0]['customer_pay'],
                    'customer_return' => (int)$orders[0]['customer_pay'] - $total_price,
                    'cashier' => $orders[0]['cashier'],
                    'customer_order_date' => tgl_indo(date('Y-m-d', strtotime($orders[0]['order_date']))),
                    'customer_order_time' => date('h:m:s', strtotime($orders[0]['order_date']))
                ],
                'store' => [
                    'address' => $locationStore->lengkap . ' ' . 'Kec ' . $locationStore->dis_name . ', ' . $locationStore->city_name . ', Prov ' . $locationStore->prov_name,
                    'phone_number' => ($locationStore->no_hp_user) ? $locationStore->no_hp_user : '',
                ]
            ], 'message' => 'Berhasil transaksi!'], RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Gagal melakukan transaksi!!']);
        }
    }
}

/* End of file SalesTransaction.php */
