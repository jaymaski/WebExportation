<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['users/users_dashboard'] = 'users/index';

$route['default_controller'] = 'users/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
