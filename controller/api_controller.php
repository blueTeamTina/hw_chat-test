<?php

class ApiController
{
	public function __construct()
	{
		include 'db.php';
		
	}
	
	/**
	 * @param String $action
	 * @param Object $data
	 * @param String $auth
	 */ 
	public function handle($action, Data $data, $auth)
	{
		switch($action) {
			case 'Login':
				return $this->onLogin($data);
				break;
			case 'Logout':
				
				break;
			case 'Register':
				return $this->onRegister($data);

				break;
			default:
				throw new Exception("Nepostojeca metoda!");
				break;
		}
	}
	
	private function generateResult($ok, $data, $error = NULL)
	{
		$r = new Result();
		$r->ok = $ok;
		$r->data = $data;
		$r->error = $error;
		
		return $r;
	}
	
	private function onLogin($data)
	{
		include 'controller/user_controller.php';
		include 'model/user.php';
		$user = new User($data,array('username','password'));
			
		$uc = new UserController();
		$result = $uc->login($user);
		
		if ($result) {
			$r = $this->generateResult(TRUE, $result, 'Uspjesno ste logirani');
		} else {
			$r = $this->generateResult(FALSE, NULL, 'Invalid login data');
		}
		
		return $r;
	}
	
	public function onRegister($data) {
		
		include 'controller/user_controller.php';
		include 'model/user.php';
		$user = new User($data,array('username', 'password', 'firstname', 'lastname', 'email'));		
		$uc = new UserController();
		$result = $uc->register($user);
		
		if ($result) {
			$r = $this->generateResult(TRUE, $result, 'Uspjesna registracija');
		} else {
			$r = $this->generateResult(FALSE, NULL, 'Invalid register data');
		}
		return $r;
		
	}
} 
