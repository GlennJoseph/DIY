<?php
require('init.php');

$payload = @file_get_contents('php://input');
$data = json_decode($payload);

print_r(testMail($data));
?>