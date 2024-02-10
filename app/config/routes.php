<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Kullanıcı Login - Logout
$route['management/login'] = 'management/login';
$route['management/user-login'] = 'management/login/login';
$route['management/user-logout'] = 'management/login/logout';
$route['management/captcha'] = 'management/login/captcha';


$route['management'] = 'management/home';

// Link Yönetimi
$route['management/links'] = 'management/links';
$route['management/links/create'] = 'management/links/create';
$route['management/links/edit/(:num)'] = 'management/links/edit/$1';
$route['management/links/delete'] = 'management/links/delete';
$route['management/links/check'] = 'management/links/linkCheck';

// Kullanıcı Yönetimi
$route['management/users'] = 'management/users';
$route['management/users/create'] = 'management/users/create';
$route['management/users/edit/(:num)'] = 'management/users/edit/$1';
$route['management/users/delete'] = 'management/users/delete';

// Kullanıcı Grup Yönetimi
$route['management/groups'] = 'management/groups';
$route['management/groups/create'] = 'management/groups/create';
$route['management/groups/edit/(:num)'] = 'management/groups/edit/$1';
$route['management/groups/delete'] = 'management/groups/delete';

$route['(:any)'] = 'main/index/$1';
