<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;

if (!function_exists('api_get')) {
    function api_get($username, $password, $query, $url, $verify)
    {
        $client = new Client();
        $response = $client->request('GET', $url, [
            'verify' => $verify,
            'auth' => [$username, $password],
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}

if (!function_exists('api_post')) {
    function api_post($username, $password, $data, $url, $verify)
    {
        $client = new Client();
        $response = $client->post(
            $url,
            [
                'verify' => $verify,
                'auth' => [$username, $password],
                'form_params' => $data
            ]
        );
        return $response->getBody()->getContents();
    }
}
if (!function_exists('api_json')) {
    function api_json($username, $password, $data, $url, $verify)
    {
        $client = new Client();
        $response = $client->post(
            $url,
            [
                'headers' => [
                    'Content-Type'     => 'application/json',
                ],
                'verify' => $verify,
                'auth' => [$username, $password],
                'body' => json_encode($data),
            ]
        );
        return $response->getBody()->getContents();
    }
}
