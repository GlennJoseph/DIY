<?php
// init
require('init.php');

$payload = @file_get_contents('php://input');
$data = json_decode($payload);

switch($data->action){
    case 'get_Template':
        $templates = getTemplates();
        print_r($templates);
        break;
    case 'sign_Up':
        // first name, last name, email address
        createAccount($ACCOUNT_NAME);
        //getAccount($ACCOUNT_NAME);
        // $SITE_NAME = createSite($data->templateID);
        // grantSiteAccess($data->accountName, $SITE_NAME, $data->permissions);
        // $RESET_PASSWORD_LINK = getResetPasswordLink($data->accountName);
        // print_r($RESET_PASSWORD_LINK);
        break;
    default:
        echo 'default';
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