<?php
namespace App\models;

class User extends \App\core\Model{
	
	public $username;
	public $password_hash;

	public function __construct(){

		parent::__construct();
	}

	

	public function getAllUsers(){

		$stmt = self::$connection->query("SELECT * FROM user");
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\User");
		return $stmt->fetchAll();
	}

	public function find($username){
		$stmt = self::$connection->prepare("SELECT user.*, profile.profile_id FROM user LEFT JOIN profile ON user.user_id = profile.user_id WHERE username LIKE :username");
		$stmt->execute(['username'=>$username]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\User");
		return $stmt->fetch();
	}

	public function insert(){

		if($this->isValid()){

			$stmt = self::$connection->prepare("INSERT INTO user(username, password_hash) VALUES (:username, :password_hash)");
			$stmt->execute(['username'=>$this->username, 'password_hash'=>$this->password_hash]);
			$this->user_id = self::$connection->lastInsertId();
			return true;
			
			if(self::$connection->prepare("SELECT * FROM user WHERE username = :username")) {
				echo "error, already exist.";
				return false;
			}

		}else
			return false;
	}


	public function updatePassword(){
		$stmt = self::$connection->prepare("UPDATE user SET password_hash = :password_hash
        WHERE user_id = :user_id");
		$stmt->execute(['user_id'=>$this->user_id, 'password_hash'=>$this->password_hash]);
	}
	public function isValid(){

		return !empty($this->username) && !password_verify('', $this->password_hash);
	}
	

}