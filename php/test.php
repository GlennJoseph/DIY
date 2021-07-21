<?php
require('init.php');

// $payload = @file_get_contents('php://input');
// $data = json_decode($payload);

// if (gettype($data) !== 'object') die(json_encode(["status"=>false,"response"=>"Data is not an object"]));

// switch($data->action){
//     case 'create_Session':
// 		$session_id = create_session($data);
// 		printResponse($session_id);
//     break;


//     case 'publish_Site':

//     break;


//     default:
//         die(json_encode(["status"=>false, "response"=>"Method Not Allowed - ".$data->action."not found."]));
//     break;
// }

// print_r(unpublishSite((object)['site_name'=>'bb9e83fc43794e9c8b0cdc446a9046c0']));

echo $_SERVER['SERVER_NAME'];


?>