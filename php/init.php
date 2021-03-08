<?php

require_once('functions/duda.php');

// SANDBOX
$sandbox_key = 'MGNiMjcxNWE5NzpEaG03dEs=';
$sandbox_route = 'https://api-sandbox.duda.co/api';
$get_Templates_endpoint = '/sites/multiscreen/templates';
$create_Account_endpoint = '/accounts/create';

// LIVE
$live_key = '';
$live_route = '';

define('DUDA_API_KEY', $sandbox_key);
define('DUDA_ROUTE', $sandbox_route);
define('DUDA_ENDPOINT', $get_Templates_endpoint);
?>