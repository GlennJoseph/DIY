<?php
// PHPMAILER, DUDA
require_once('vendor/autoload.php');
require_once('functions/duda.php');
require_once('functions/mail.php');
require_once('functions/stripe.php');

// SANDBOX
$sandbox_key = 'MGNiMjcxNWE5NzpEaG03dEs=';
$sandbox_route = 'https://api-sandbox.duda.co/api';
$secret_test = 'sk_test_QBwSGkVKrYEcj9jjpCzJMMkQ00bl996YmG';

// LIVE
$live_key = '';
$live_route = '';

define('DUDA_API_KEY', $sandbox_key);
define('DUDA_ROUTE', $sandbox_route);
define('ACCOUNT_NAME', 'glennjosephdl@gmail.com');
define('STRIPE_API_SK', $secret_test);

function printResponse($response){
    $response = json_decode(json_encode($response));
	if($response->status){
        print_r(json_encode($response));
    }else {
        die(json_encode($response));
    }
}
?>