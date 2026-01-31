<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends RestController
{

    protected $token;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('jwt_helper');
        $this->load->model('M_transaction', 'transaction');
        $this->token = JwtAuth::validateToken();
        if (!$this->token) {
            $this->response(['status' => false, 'message' => 'Token Unauthorized'], RestController::HTTP_UNAUTHORIZED);
        }
    }

    public function count_get()
    {
        $toko_id = $this->token->data->toko_id;
        $user_id = $this->token->data->id_user;
        $get = $this->transaction->getCount($user_id, $toko_id);
        if ($get) {
            $data = [
                'income' => (int)$get->income,
                'transaction_amount' => (int)$get->transaction_amount,
                'total_quantity' => (int)$get->total_quantity,
            ];
            $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Tidak ditemukan']);
        }
    }

    public function historyTransaction_get()
    {
        $toko_id = $this->token->data->toko_id;
        $user_id = $this->token->data->id_user;
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $get = $this->transaction->getHistoryTransaction($user_id, $toko_id, $start_date, $end_date);
        $data = [];
        if ($get) {
            foreach ($get as $row) {
                array_push($data, [
                    'order_name' => $row->name,
                    'order_id' => $row->order_number,
                    'order_price' => (int)$row->total_price,
                    'order_date' => $row->order_date,
                ]);
            }
            $this->response(['status' => true,  'message' => 'Data ditemukan', 'data' => $data], RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Tidak ditemukan'], RestController::HTTP_OK);
        }
    }

    public function getDetailOrder_get()
    {
        $id_order = $this->get('order_id');
        $toko_id = $this->token->data->toko_id;
        $user_id = $this->token->data->id_user;
        $orders = $this->transaction->getDetailTransaction($user_id, $toko_id, $id_order);
        if ($orders) {
            $data = [];
            $total_price = $orders[0]['total_price'];
            $locationStore = $this->transaction->getLocationStore($toko_id);
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
            $this->response([
                'status' => true, 'message' => 'Transaksi ditemukan', 'data' => [
                    'orders' => $data,
                    'customer' => [
                        'customer_name' => $orders[0]['order_name'],
                        'customer_total' => (int)$total_price,
                        'customer_pay' => (int)$orders[0]['customer_pay'],
                        'customer_return' => (int)$orders[0]['customer_pay'] - $total_price,
                        'cashier' => $orders[0]['cashier'],
                        'customer_order_date' => tgl_indo(date('Y-m-d', strtotime($orders[0]['order_date']))),
                        'customer_order_time' => date('h:m:s', strtotime($orders[0]['order_date']))
                    ]
                ],
                'store' => [
                    'address' => $locationStore->lengkap . ' ' . 'Kec ' . $locationStore->dis_name . ', ' . $locationStore->city_name . ', Prov ' . $locationStore->prov_name,
                    'phone_number' => ($locationStore->no_hp_user) ? $locationStore->no_hp_user : '',
                ]
            ], RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Transaksi tidak ditemukan'], RestController::HTTP_OK);
        }
    }
}
/* End of file Controllername.php */
