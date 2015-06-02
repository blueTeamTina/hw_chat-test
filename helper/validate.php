<?php 

class Valid {
			
		public function isValid($args) {
			
		$error = array();
		
			foreach ($args as $key => $element) {
				if (empty($element)) {
					array_push($error, "Invalid '$key'");
				}
		
				else if (strlen($element) < 3) {
					array_push($error, "Invalid  '$key'  length");
				}
				else if (($key == 'username' || $key == 'firstName' || $key == 'lastName' ) && !preg_match("/^[a-zA-Z ]*$/",$element)) {
					array_push($error, "Invalid '$key'. Only letters and white space allowed"); 
				}
				else if ($key === 'email' && !filter_var($element, FILTER_VALIDATE_EMAIL)) {
					array_push($error, "Invalid '$key'"); 	
				}
			}
		
			if (empty($error)) {
			return false;		
			} else {
				return $error;
			}
		}				
}
