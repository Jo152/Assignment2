<?php
namespace App\controllers;

#[\App\core\LoginFilter]
#[\App\core\ProfileFilter]
class MessageController extends \App\core\Controller{

    public function index() {
        $message = new \App\models\Message();
        $profile = new  \App\models\Profile();
        $userProfileId = $_SESSION["profile_id"];
        $senderIds = $message->getAllSendersForReceiver($userProfileId);
        $receiverIds = $message->getAllReceiversForSender($userProfileId);
        $senderAndMessage = [];

        foreach ($senderIds as &$value) {

            $sender = $profile->getProfileById((int)$value[0]);
            $unreadMessages = $message->findUnreadAndToReadMessagesWithSender((int)$value[0], $userProfileId);

            if (!empty($unreadMessages)) {

                array_push($senderAndMessage,
                    array("sender" => $sender,
                    "unreadMessages" => $unreadMessages));
           } else {
            array_push($senderAndMessage, array("sender" => $sender, "unreadMessages" => false));
           }
        }
        $receivers = [];
        foreach ($receiverIds as &$value) {;
            $receiver = $profile->getProfileById((int)$value[0]);
            array_push($receivers, $receiver);
        }
        $this->view("Message/listMessageContacts", [
            "senderAndMessage"=>$senderAndMessage, "receivers"=>$receivers]);
    }

    public function chatRoom($receiverId) {
        $profile = new  \App\models\Profile();
        $message = new \App\models\Message();
        $receiver = $profile->getProfileById($receiverId);
        if ($receiver == false) {
            echo "404. A profile with that id does not exist. Sorry.
                <a href='".BASE."/Message/index'>Go back to contacts</a>
            ";
            return;
        }
        // the current user is the sender of the message
        $currentUserId = $_SESSION["profile_id"];

        if (isset($_POST["action"])) {
            $message->message=$_POST["message"];
            $message->sender=$currentUserId;
            $message->receiver=$receiverId;
            $message->timestamp=date("Y-m-d");
            $message->read_status=UNREAD;
            $message->private_status= isset($_POST["public"]) ? PUBLIC_MSG : PRIVATE_MSG;
            $message->insert();
        }
        $messages = $message->getAllMessagesBetweenSenderAndReceiver($receiverId, $currentUserId);
        foreach ($messages as &$msg) {
            if ($msg["receiver"] == $currentUserId &&
                ($msg["read_status"] == UNREAD || $msg["read_status"] == REREAD)) {
                    $message->setStatus($msg["message_id"], "read");
            }
        }
        $this->view("Message/chatRoom", ["messages"=>$messages, "receiver"=>$receiver]);
    }

    public function delete($messageId) {
        $message = new \App\models\Message();
        $message->messageId = $messageId;
        $senderId = $message->find($messageId)["sender"];
        $message->delete();
        header('Location:'.BASE.'/Message/chatRoom/'.$senderId);
    }

    public function setStatus($status, $messageId) {
        $message = new \App\models\Message();
        $message->setStatus($messageId, $status);
        header('Location:'.BASE.'/Message/index/');
    }
}