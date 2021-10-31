<?php

namespace App\core;

#[\Attribute]
class LoginFilter{

	function execute(){
		
		if(!isset($_SESSION['user_id'])){
			header('location:'.BASE.'/Default/index');
		}
	}
}
?>