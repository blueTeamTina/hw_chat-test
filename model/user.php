<?php

class User
{
	public $username;
	public $password;
	public $firstname;
	public $lastname;
	public $email;

	public function __construct($data,$required)
	{
		
		for ($i = 0; $i < count($required); $i++) { 
			$this->$required[$i] = $data->$required[$i];
		}
	}

}
