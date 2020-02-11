<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] 	= 'users/index';

$route['users/users_dashboard'] = 'users/index';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;

$route['users/requests/view_request'] = 'request/view_request';
$route['users/requests/all_request'] 	= 'request/index';
$route['users/requests/view_request'] = 'request/view_request';
$route['users/requests/create_task'] 	= 'request/create_task';
