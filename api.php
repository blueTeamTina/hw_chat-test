<?php


include 'controller/api_controller.php';
include 'model/result.php';

// svi ulazni podaci su u POST/REQUEST
// action
// data
// COOKIE(token) identifikacija

$json_data_string='{"username":"'.$_POST['username'].'", "password":"'.$_POST['password'].'"}';

$action = isset($_POST['action']) ? $_POST['action'] : NULL;
$data = isset($json_data_string) ? $json_data_string : NULL;
$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : NULL;


if (empty($action)) {
	die("Action is not specified");
}

include 'model/data.php';
$d = new Data();
if (!empty($data)) {
	$obj = json_decode($data, TRUE);
	
	if (json_last_error() !== JSON_ERROR_NONE) {
		die("Invalid JSON received");
	}
	
	foreach($obj as $key => $val) {
		$d->$key = $val;
	}
	
}

$api = new ApiController();
try {
	$r = $api->handle($action, $d, $token);
} catch(Exception $e){
	$r = new Result();
	$r->ok = FALSE;
	$r->error = $e->getMessage();
}

echo json_encode($r);