<?php

require_once('functions/duda.php');

// SANDBOX
$sandbox_key = 'MGNiMjcxNWE5NzpEaG03dEs=';
$sandbox_route = 'https://api-sandbox.duda.co/api';

// LIVE
$live_key = '';
$live_route = '';

define('DUDA_API_KEY', $sandbox_key);
define('DUDA_ROUTE', $sandbox_route);
define('ACCOUNT_NAME', 'glennjosephdl@gmail.com');

function printResponse($response){
    $response = json_decode(json_encode($response));
	if($response->status){
        print_r(json_encode($response));
    }else {
        die(json_encode($response));
    }
}
?>