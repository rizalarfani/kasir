<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'dasbor';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']                 = 'auth/login';
$route['logout']                = 'auth/logout';
