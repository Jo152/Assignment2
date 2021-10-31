<?php
namespace App\controllers;

#[\App\core\LoginFilter]
class ProfileController extends \App\core\Controller{

    public function createProfile() {
        if (isset($_POST["createProfile"])) {
            $profile = new \App\models\Profile();
            $profile->user_id = $_SESSION['user_id'];
            $profile->first_name = $_POST["first_name"];
            $profile->middle_name = $_POST["middle_name"];
            $profile->last_name = $_POST["last_name"];
            $profile->insert();
            $_SESSION['profile_id'] = $profile->profile_id;
			header('location:'.BASE.'/Default/somewhereSecure');
        } else {
            $this->view("Profile/createProfile");
        }
    }

    #[\App\core\ProfileFilter]
	function edit(){
		$profile = new \App\models\Profile();
        $profile = $profile->getProfileById($_SESSION["profile_id"]);
		if(isset($_POST["action"])){
			$profile->profile_id = $_SESSION["profile_id"];
			$profile->first_name = $_POST["first_name"];
			$profile->middle_name = $_POST["middle_name"];
			$profile->last_name = $_POST["last_name"];
			$profile->update();
			header("location:".BASE."/Default/somewhereSecure");
		}else{
			$this->view("Profile/edit", $profile);
		}
	}

    #[\App\core\ProfileFilter]
    public function wall($profile_id) {
        $profile = new \App\models\Profile();
        $messageModel = new \App\models\Message();
        $picture = new \App\models\Picture();
        $pictureLike = new \App\models\PictureLike();

        // profile info
        $userProfile = $profile->getProfileById($profile_id);
        if ($userProfile == false) {
            echo "404. A profile with that id does not exist. Sorry.
                <a href='".BASE."/Default/somewhereSecure'>Go back home</a>
            ";
            return;
        }

        // pictures
        $userPictures = $picture->getAllForUser($profile_id);
        $pictureWithLikes = [];
        foreach ($userPictures as &$otherUserPicture) {
            $pictureLike->picture_id=$otherUserPicture->picture_id;
            $pictureLike->profile_id=$_SESSION["profile_id"];
            array_push($pictureWithLikes,
                array("picture" => $otherUserPicture,
                "numOfLikes" => $pictureLike->getImageLikeCount(),
                "hasLiked" => $pictureLike->hasUserLikedImage()));
        }

        // public messages
        $messages = $messageModel->getAllPublicMessagesByUser($profile_id);
        $messagesWithInfo = [];
        foreach ($messages as &$message) {
            array_push(
                $messagesWithInfo,
                array("message" => $message,
                "sender" => $profile->getProfileById($message->sender)->first_name,
                "receiver" => $profile->getProfileById($message->receiver)->first_name
            ));
        }
        
        $this->view('/Profile/wall', [
            "profile"=>$userProfile,
            "pictures"=> $pictureWithLikes,
            "messages" => $messagesWithInfo,
        ]);
    }
}
?>