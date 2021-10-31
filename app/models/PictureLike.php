<?php
namespace App\models;

class PictureLike extends \App\core\Model{
    public $picture_id;
    public $profile_id;
    public $timestamp;
    public $read_status;

	public function __construct(){
        
		parent::__construct();
	}

    public function insert(){
		$stmt = self::$connection->prepare("INSERT INTO
        picture_like(picture_id, profile_id, timestamp, read_status)
        VALUES (:picture_id, :profile_id, :timestamp, :read_status)");
		$stmt->execute([
            "picture_id"=>$this->picture_id,
            "profile_id"=>$this->profile_id,
            "timestamp"=>$this->timestamp,
            "read_status"=>$this->read_status
        ]);
	}

    public function delete() {
        $stmt = self::$connection->prepare("DELETE from picture_like
        WHERE picture_id = :picture_id
        AND profile_id = :profile_id");
		$stmt->execute(["picture_id"=>$this->picture_id, "profile_id"=>$this->profile_id,]);
    }

    public function getImageLikeCount() {

		$stmt = self::$connection->prepare("SELECT * FROM picture_like
        WHERE picture_id = :picture_id");
		$stmt->execute(["picture_id"=>$this->picture_id]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\PictureLike");
		return count($stmt->fetchAll());
    }

    public function hasUserLikedImage() {
		$stmt = self::$connection->prepare("SELECT * FROM picture_like
        WHERE picture_id = :picture_id
        AND profile_id = :profile_id");
		$stmt->execute(["picture_id"=>$this->picture_id, "profile_id" => $this->profile_id]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\PictureLike");
		return count($stmt->fetchAll()) > 0;
    }

    public function findUnseenLikesOfPicture($pictureId) {
		$stmt = self::$connection->prepare("SELECT * FROM picture_like
        WHERE picture_id = :picture_id AND read_status = :read_status");
		$stmt->execute(["picture_id"=>$pictureId, "read_status"=> UNSEEN]);
		return count($stmt->fetchAll());
    }

    public function setLikeToSeen($pictureId) {
        $stmt = self::$connection->prepare("UPDATE picture_like
        SET read_status = :read_status
        WHERE picture_id = :picture_id");
        $stmt->execute(["read_status"=> SEEN, "picture_id"=> $pictureId]);
    }
}