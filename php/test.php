<?php
require('init.php');

$payload = @file_get_contents('php://input');
$data = json_decode($payload);
print_r((array) $data->line_items);

if (gettype($data) !== 'object') die(json_encode(["status"=>false,"response"=>"Data is not an object"]));

switch($data->action){
    case 'create_Session':
		$session_id = create_session($data);
		printResponse($session_id);
    break;

    default:
        die(json_encode(["status"=>false, "response"=>"Method Not Allowed - ".$data->action."not found."]));
    break;
}
?>