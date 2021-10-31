<?php
namespace App\models;

#[\App\core\LoginFilter]
class Profile extends \App\core\Model{
	
    public $user_id;
    public $first_name;
    public $middle_name;
    public $last_name;

	public function __construct(){
        
		parent::__construct();
	}

public function getProfileById($profile_id) {
        $stmt = self::$connection->prepare("SELECT * FROM profile WHERE profile_id = :profile_id");
		$stmt->execute(['profile_id'=>$profile_id]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Profile");
		return $stmt->fetch();
    }

    public function insert(){

		$stmt = self::$connection->prepare("INSERT INTO profile(user_id, first_name, middle_name, last_name)
        VALUES (:user_id, :first_name, :middle_name, :last_name)");
		$stmt->execute([
            "user_id"=>$this->user_id,
            "first_name"=>$this->first_name,
            "middle_name"=>$this->middle_name,
            "last_name"=>$this->last_name
            ]);
        $this->profile_id = self::$connection->lastInsertId();
	}

    public function find($userId){

		$stmt = self::$connection->prepare("SELECT * FROM profile WHERE user_id = :user_id");
		$stmt->execute(['user_id'=>$userId]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Profile");
		return $stmt->fetch();
	}

    public function getAllProfiles(){

		$stmt = self::$connection->query("SELECT * FROM profile");
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Profile");
		return $stmt->fetchAll();
	}

    public function delete(){

		$stmt = self::$connection->prepare("DELETE FROM profile WHERE user_id=:user_id");
		$stmt->execute(['user_id'=>$this->user_id]);
	}

    public function update(){
		$stmt = self::$connection->prepare("UPDATE profile
            SET first_name = :first_name, middle_name = :middle_name,
            last_name = :last_name WHERE profile_id = :profile_id");
		$stmt->execute([
            "profile_id" => $this->profile_id,
            "first_name" => $this->first_name,
            "middle_name" => $this->middle_name,
            "last_name" => $this->last_name]);
	}

public function searchProfile($query) {
        $stmt = self::$connection->prepare("SELECT * FROM profile
            WHERE CONCAT(first_name, middle_name, last_name) LIKE :query");
		$stmt->execute(['query'=>"%$query%"]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Profile");
		return $stmt->fetchAll();
    }
}