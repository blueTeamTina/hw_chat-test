<?php


include 'controller/api_controller.php';
include 'model/result.php';
include 'model/data.php';
include 'valid.php';

// svi ulazni podaci su u POST/REQUEST
// action
// data
// COOKIE(token) identifikacija
	
$args = $_REQUEST;
$v = new Valid();
$error = $v->isValid($args);
	
$json_data_string = '{"username":"'.$_POST['username'].'", "password":"'.$_POST['password'].'",'
				    .'"firstname":"'.$_POST['firstname'].'", "lastname":"'.$_POST['lastname'].'",'
				    .'"email":"'.$_POST['email'].'"}';				   

$data = isset($json_data_string) ? $json_data_string : NULL;
$action = isset($_POST['action']) ? $_POST['action'] : NULL;
$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : NULL;


if (empty($action)) {
	die("Action is not specified");
}

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

if ($error==false){
	try {
		$r = $api->handle($action, $d, $token);
	} catch(Exception $e){
		$r = new Result();
		$r->ok = FALSE;
		$r->error = $e->getMessage();
	}
}

else {
	echo '<br>Ispravite pogreske';
}
	
echo "<br>";

if($r->error!=NULL) {
echo json_encode($r->error);
}
