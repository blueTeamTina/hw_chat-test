<?php

class UserController
{
	
	public function __construct()
	{
		
	}
	
	public function login(User $user) {
		
		$db = Baza::$db;
		$username = $db->real_escape_string($user->username);
		$password = md5($db->real_escape_string($user->password));
		
		$sql = "SELECT * FROM user "
			   ." WHERE username = '$username' AND password = '$password' ";
		$r = $db->query($sql);
		
		if ($r->num_rows === 0) {
			return false;
		}
		$u = $r->fetch_object();
		
		return $u->id;
	}
	
	public function register(User $user) {
		
		$db = Baza::$db;
		$username = $db->real_escape_string($user->username);
		$password = md5($db->real_escape_string($user->password));
		$firstname = $db->real_escape_string($user->firstname);
		$lastname = $db->real_escape_string($user->lastname);
		$email = $db->real_escape_string($user->email);
		
		$sql = "INSERT INTO user (username, password, name, surname, email) "
			   ."VALUES ('$username', '$password', '$firstname', '$lastname', '$email')"; 
	
		$r = $db->query($sql);
		return $r;
		
	}
}
