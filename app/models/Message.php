<?php

namespace App\models;

class Message extends \App\core\Model{

    public $sender;
    public $receiver;
    public $message;
    public $timestamp;
    public $read_status;
    public $private_status;

	public function __construct(){
		parent::__construct();
	}

    public function insert(){
		$stmt = self::$connection->prepare("INSERT INTO message(
            sender, receiver, message, timestamp, read_status, private_status)
            VALUES (
                :sender, :receiver, :message, :timestamp, :read_status, :private_status)");
		$stmt->execute(
            ["sender"=>$this->sender,
            "receiver"=>$this->receiver,
            "message"=>$this->message,
            "timestamp"=>$this->timestamp,
            "read_status"=>$this->read_status,
            "private_status"=>$this->private_status,
            ]
        );
	}

    public function find($messageId) {
		$stmt = self::$connection->prepare("SELECT * FROM message WHERE message_id = :message_id");
		$stmt->execute(['message_id'=>$messageId]);
		return $stmt->fetch();
    }

    public function getAllFromSenders($receiverId) {
		$stmt = self::$connection->prepare("SELECT DISTINCT sender FROM message WHERE receiver = :receiver_id");
		$stmt->execute(['receiver_id'=>$receiverId]);
		return $stmt->fetchAll();
    }

    public function getAllFromReceivers($senderId) {
		$stmt = self::$connection->prepare("SELECT DISTINCT receiver FROM message WHERE sender = :sender_id");
		$stmt->execute(['sender_id'=>$senderId]);
		return $stmt->fetchAll();
    }

    public function getAllMessages($user1Id, $user2Id) {
		$stmt = self::$connection->prepare("SELECT * FROM message
        WHERE (receiver = :user2_id
            AND sender = :user1_id)
        OR (receiver = :user1_id
            AND sender = :user2_id)");
		$stmt->execute(["user2_id"=>$user2Id, "user1_id"=>$user1Id]);
		return $stmt->fetchAll();
    }

    public function unreadAndToReadMessages($senderId, $receiverId) {
		$stmt = self::$connection->prepare("SELECT * FROM message
        WHERE (receiver = :receiver_id AND sender = :sender_id)
        AND (read_status = :reread_status OR read_status = :unread_status)");
		$stmt->execute([
            "sender_id"=>$senderId,
            "receiver_id"=>$receiverId,
            "reread_status"=> REREAD,
            "unread_status"=> UNREAD
            ]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Message");
		return $stmt->fetchAll();
    }

    public function delete() {
      
        $stmt = self::$connection->prepare("DELETE from message WHERE message_id = :message_id");
        $stmt->execute(['message_id'=>$this->messageId]);
    }

    public function getAllPublicMessages() {
		$stmt = self::$connection->prepare("SELECT * FROM message WHERE private_status = :private_status");
		$stmt->execute(["private_status"=> PUBLIC_MSG]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Message");
		return $stmt->fetchAll();
    }


    public function getAllPublicMessagesByUser($profileId) {
		$stmt = self::$connection->prepare("SELECT * FROM message
        WHERE private_status = :private_status
        AND receiver = :receiver_id");
		$stmt->execute(["private_status"=> PUBLIC_MSG, "receiver_id"=> $profileId]);
		$stmt->setFetchMode(\PDO::FETCH_GROUP|\PDO::FETCH_CLASS, "App\\models\\Message");
		return $stmt->fetchAll();
    }

    public function setStatus($messageId, $status) {
        $stmt = self::$connection->prepare("UPDATE message
        SET read_status = :read_status WHERE message_id = :message_id");
        if($status == "read") {
            $statusCode = READ;
        } else if ($status == "reread") {
            $statusCode = REREAD;
        } else if ($status == "unread") {
            $statusCode = UNREAD;
        }
        $stmt->execute(["read_status"=>$statusCode, "message_id"=> $messageId]);
    }
}