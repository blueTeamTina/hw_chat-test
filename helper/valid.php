<?php 

class Valid {
			
		public function isValid($args) {
		$error = false;
		foreach ($args as $key => $element) {
		if (empty($element)) {
			echo nl2br("Invalid " . $key . "\n");
			 $error=true;	
			 //exit();							
		}
		
		 else if (strlen($element) < 3) {
			echo nl2br("Invalid " . $key . " length\n");
			$error=true;
			//exit();
		}
		 else if (($key == 'username' || $key == 'firstName' || $key == 'lastName' ) && !preg_match("/^[a-zA-Z ]*$/",$element)) {
			echo nl2br("Invalid " . $key . ". Only letters and white space allowed \n"); 
			$error=true;
			//exit();
		}
		 else if ($key === 'email' && !filter_var($element, FILTER_VALIDATE_EMAIL)) {
			echo 'Invalid ' . $key; 
			$error=true;
			//exit();
		}
		}
		return $error;		
	 }
				
}
