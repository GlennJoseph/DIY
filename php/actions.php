<?php
// init
require('init.php');

$payload = @file_get_contents('php://input');
$data = json_decode($payload);

switch($data->action){
    case 'get_Template':

        $templates = getTemplates();
        print_r(json_encode($templates));
        break;
    case 'sign_Up':
        // first name, last name, email address
        // !ASSIGNMENT Create Account
        // !ASSIGNMENT Create Site 
        // !ASSIGNMENT Grant Access
        // Generate SSO (Enterprise only)
        // !ASSIGNMENT Reset Password
        break;
    default:
        //code
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