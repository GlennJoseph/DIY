<?php
// init
require('init.php');

$payload = @file_get_contents('php://input');
$data = json_decode($payload);
print_r($payload);
print_r('asd');

switch($data->action){

    case 'get_Templates':
        $templates = getTemplates();
        printResponse($templates);
	break;


    case 'sign_Up':
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
		
		// // Use json_encode when printing to app.js
		
		// print_r(json_encode(["status"=>true,"response"=>$data,"request"=>'Sign Up']));
		$data->status = true;
		$data->request = 'Sign Up';
		printResponse($data);

	break;


    default:
		print_r($data);
	break;

}


// $action = $data->action;

// switch ($action) {
//   case 'get_Template':
//     getTemplates();
//     break;
//   case 'walk':
//     print_r('is walking!');
//     break;
//   case 'run':
//     print_r('is running!');
//     break;
//   default:
//     print_r('not doing anything!');
// }

// // ASSOC ARRAY
// $a = (object)['name'=>'Glenn'];
// print_r($a->name);

// // STRING OBJECT or JSON STRING
// $b = "{'name':'Trek'}"; 


// //print_r(getTemplates());

?>