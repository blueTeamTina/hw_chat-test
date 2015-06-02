<?php

require_once "DAL/baza.php";
require_once "DAL/db.php";

class user_controller
{
	private $data;

	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function login() {
		include 'model/user.php';
		include 'model/token.php';
		include 'model/log.php';	
		$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : NULL;

		$db = Baza::$db;
		
		$user = new User($this->data,array('username', 'password'));
		
		$checkToken = new Token();
		
		$tokenValidateResult = $checkToken->validate($token);
		
		if ($tokenValidateResult === FALSE) {
                return ("Korisnik je logiran <br> Idi na <a href='http://www.w3schools.com'>Chat</a> <br> ili se odjavite:
					    <br><form name='form1' method='POST' action='api.php'> 
					    <input type='hidden' name='controller' value='user_controller'> <input type='submit' name='action' value='Logout'>");
        }
            
		$username = $db->real_escape_string($user->username);
		$password = md5($db->real_escape_string($user->password));
		
		$sql = "SELECT * FROM user "
			   ." WHERE username = '$username' AND password = '$password'";
			   
		$result = $db->query($sql);
		
		if ($result->num_rows === 0) {
			return "Nepostojeci korisnik";
		}
		
		$userID = $result->fetch_object();
		
		$token = new Token();
		$log = new Log();
		
        $token->create($userID->id);
        $log->createLogin($userID->id);
        
		return $userID->id;
	}
	
	public function register() {
		
		include 'model/user.php';

		$db = Baza::$db;
		$user = new User($this->data,array('username', 'password', 'firstname', 'lastname', 'email'));		
		if ($this->check()==TRUE)
		{
				return "Username or e-mail already registered.";
		} 
		$username = $db->real_escape_string($user->username);
		$password = md5($db->real_escape_string($user->password));
		$firstname = $db->real_escape_string($user->firstname);
		$lastname = $db->real_escape_string($user->lastname);
		$email = $db->real_escape_string($user->email);
		
		$sql = "INSERT INTO user (username, password, name, surname, email) "
			   ."VALUES ('$username', '$password', '$firstname', '$lastname', '$email')"; 
	
		$result = $db->query($sql);
		
		if ($result) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function logout() {
		
        include 'model/token.php'; 
		include 'model/log.php';
		
        $tok = new Token();
        $validate = $tok->delete();
        header ("Location: login.php");
        return $validate;
    } 	
    
    public function check() {
		$sql="SELECT * FROM user WHERE username = '".$this->data['username']."' OR email = '".$this->data['email']."'";
		$result = Baza::$db->query($sql);
		if ($result->num_rows === 0) {
			return false;
		} else {
			return true;
		}
	}
	
	//public function editProfile() {}
	
	
		
	
}
