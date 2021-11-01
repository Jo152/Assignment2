<?php

namespace App\core;

#[\Attribute]
class ProfileFilter{

	function execute(){
		
		if(!isset($_SESSION['profile_id']) || $_SESSION['profile_id'] == null){
			header('location:'.BASE.'/Profile/createProfile');
		}
	}
}
?>