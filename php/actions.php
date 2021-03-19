<?php
// init
require('init.php');

$payload = @file_get_contents('php://input');
$data = json_decode($payload);

if (gettype($data) !== 'object') die(json_encode(["status"=>false,"response"=>"Data is not an object"]));

switch($data->action){

    case 'get_Templates':
        $templates = getTemplates();
        printResponse($templates);
	break;


    case 'sign_Up':
		if(!isset($data->account_name) || $data->account_name) die(json_encode(["status"=>false, "response"=>"account_name not found"]));
		if(!isset($data->template_id) || $data->template_id) die(json_encode(["status"=>false, "response"=>"template_id not found"]));

		// CREATE ACCOUNT ----------
		$account = createAccount($data);
		if(!$account['status']) printResponse($account);

		// CREATE SITE ----------
		$site = createSite($data);
		if(!$site['status']){
			deleteAccount($data);
			printResponse($site);
		}
		$data->site_name = $site['response']->site_name;

		// // GET SSO LINK ----------
		$sso_link = getSSOLink($data);
		if(!$sso_link['status']){
			deleteAccount($data);
			deleteSite($data);
			printResponse($sso_link);
		}
		$data->sso_link = $sso_link['response']->url;

		// // GRANT SITE ACCESS ----------
		$site_access = grantSiteAccess($data);
		if(!$site_access['status']){
			deleteAccount($data);
			deleteSite($data);
			printResponse($site_access);
		}

		// // GET RESET PASSWORD LINK ----------
		$reset_password_link = getResetPasswordLink($data);
		if(!$reset_password_link['status']){
			deleteAccount($data);
			deleteSite($data);
			printResponse($reset_password_link);
		}
		$data->reset_password_link = $reset_password_link['response']->reset_url;
		
		// send mail containing reset password link
		$test_mail = testMail($data);
		if(!$test_mail['status']){
			deleteAccount($data);
			deleteSite($data);
			printResponse($test_mail);
		}

		// print response to be seen on js
		$data->status = true;
		$data->request = 'Sign Up';
		printResponse($data);

	break;

	case 'checkout':
		$new_customer = create_customer($data);
		$new_charge = create_charge($data);
		print_r(json_encode($new_charge));
	break;

	case 'subscribe_Legacy':
		$customer = create_customer($data);
		$data->customer = $customer['response']->id;
		$subscription = create_subscription($data);
		printResponse($subscription);
	break;

	case 'subscribe':
		$session_id = create_checkout_session($data);
		printResponse($session_id);
	break;

    default:
		die(json_encode(["status"=>false, "response"=>"Method Not Allowed - ".$data->action."not found."]));
	break;

}


?>