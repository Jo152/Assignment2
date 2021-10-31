<?php

namespace App\controllers;

class DefaultController extends \App\core\Controller{

	function index(){
		$this->view('Default/index');
	}

	function register(){
		if(isset($_POST['action'])){

			if($_POST['password'] == $_POST['password_confirm']){
				$user = new \App\models\User();
				$user->username = $_POST['username'];
				$user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$user->insert();

                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['username'] = $user->username;

				if(isset($_POST['twofasetup']))
					header('location:'.BASE.'/Default/twofasetup');

				else
					header('location:'.BASE.'/Profile/createProfile');
					
			} else
				header('location:'.BASE.'/Default/register?error=Passwords do not match!');

		}else {
			$this->view('User/register');
		}
	}

	function twofasetup(){
		if(isset($_POST['action'])){

			$currentcode = $_POST['currentCode'];
			if(\App\core\TokenAuth::verify($_SESSION['secretkey'],$currentcode)){

				$user = new \App\models\User();
				$user->user_id = $_SESSION['user_id'];
				$user->secret_key = $_SESSION['secretkey'];
				$user->update2fa();
				header('location:'.BASE.'/Default/login');

			}else
				header('location:'.BASE.'/Default/twofasetup?error=token not verified!');

		}else {

			$secretkey = \App\core\TokenAuth::generateRandomClue();
			$_SESSION['secretkey'] = $secretkey;
			$url = \App\core\TokenAuth::getLocalCodeUrl($_SESSION['username'],'thedomain.com',$secretkey,'Assignment 2');
			$this->view('User/twofasetup', $url);
		}	
	}

	function makeQRCode(){
		$data = $_GET['data'];
		\QRcode::png($data);
	}

	function login(){

		if(isset($_POST['action'])){
			$user = new \App\models\User();
			$user = $user->find($_POST['username']);

			if($user != null &&
				password_verify($_POST['password'], $user->password_hash)) {

                if($user->secret_key == null) {
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['username'] = $user->username;
					$_SESSION['profile_id'] = $user->profile_id;
                    header('location:'.BASE.'/Default/somewhereSecure');

                } else {
                    $_SESSION['temp_user_id'] = $user->user_id;
                    $_SESSION['temp_username'] = $user->username;
                    $_SESSION['temp_secret_key'] = $user->secret_key;
					$_SESSION['temp_profile_id'] = $user->profile_id;
                    header('location:'.BASE.'/Default/validateLogin');
                }
			}else
				header('location:'.BASE.'/Default/login?error=Username/password mismatch!');
		}else {
			$this->view('User/login');
		}
	}

	function validateLogin(){

		if(isset($_POST['action'])){
			$currentcode = $_POST['currentCode'];

			if(\App\core\TokenAuth::verify($_SESSION['temp_secret_key'],$currentcode)) {

				$_SESSION['user_id'] = $_SESSION['temp_user_id'];
				$_SESSION['username']= $_SESSION['temp_username'];
				$_SESSION['profile_id']= $_SESSION['temp_profile_id'];
				$_SESSION['temp_secret_key'] = '';
				header('location:'.BASE.'/Default/somewhereSecure');
			}else {

				session_destroy();
				header('location:'.BASE.'/Default/login?error=Username/password mismatch!');//reload
			}
		}else{
			$this->view('User/validateLogin');
		}
	}

	function logout(){
		session_destroy();
		header('location:'.BASE.'/');
	}

    #[\App\core\LoginFilter]
	#[\App\core\ProfileFilter]
	function somewhereSecure(){
        if(isset($_GET['action'])){
            $profile = new \App\models\Profile();
            $searchResult = $profile->searchProfile($_GET["searchQuery"]);
            $this->view('Default/secure', $searchResult);
        } else {
            $this->view('Default/secure');
        }
	}

}
?>