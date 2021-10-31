<?php
namespace App\models;

class Picture extends \App\core\Model{
    public $picture_id;
    public $profile_id;
    public $filename;
    public $caption;

	public function __construct(){
		parent::__construct();
	}

	public function find($picture_id){
		$stmt = self::$connection->prepare("SELECT * FROM picture WHERE picture_id = :picture_id");
		$stmt->execute(['picture_id'=>$picture_id]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Picture");
		return $stmt->fetch();
	}

	public function getAll(){

		$stmt = self::$connection->query("SELECT * FROM picture");
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Picture");
		return $stmt->fetchAll();
	}

	public function getAllForUser($profile_id){
		$stmt = self::$connection->prepare("SELECT * FROM picture WHERE profile_id = :profile_id");
		$stmt->execute(['profile_id'=>$profile_id]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Picture");
		return $stmt->fetchAll();
	}

    public function getPictureOwnerId($picture_id){
		$stmt = self::$connection->prepare("SELECT profile_id FROM picture WHERE picture_id = :picture_id");
		$stmt->execute(['picture_id'=>$picture_id]);
		return $stmt->fetch()[0];
	}

	public function insert(){

		$stmt = self::$connection->prepare("INSERT INTO picture(profile_id, filename,caption)
        VALUES (:profile_id,:filename,:caption)");
		$stmt->execute(['profile_id'=>$this->profile_id,'filename'=>$this->filename,'caption'=>$this->caption]);
	}

	public function update(){
		$stmt = self::$connection->prepare("UPDATE picture SET caption=:caption WHERE picture_id = :picture_id");
		$stmt->execute(['picture_id'=>$this->picture_id,'caption'=>$this->caption]);
	}

	public function delete(){
		
		$stmt = self::$connection->prepare("DELETE FROM picture WHERE picture_id=:picture_id");
		$stmt->execute(['picture_id'=>$this->picture_id]);
	}
}