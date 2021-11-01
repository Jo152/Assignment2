<?php

namespace App\controllers;

#[\App\core\LoginFilter]
#[\App\core\ProfileFilter]
class PictureController extends \App\core\Controller {

	function index() {
            $pictureModel = new \App\models\Picture();
            $pictureLike = new \App\models\PictureLike();
            
            $pictures = $pictureModel->getAllForUser($_SESSION['profile_id']);

            $pictureWithLikes = [];
            foreach ($pictures as &$picture) {
                $pictureLike->picture_id=$picture->picture_id;
                array_push($pictureWithLikes,
                    array("picture" => $picture,
                        "numOfLikes" => $pictureLike->getImageLikeCount(),
                        "unreadLikeCount" => $pictureLike->findUnseenLikesOfPicture($picture->picture_id),
                    ));
                    $pictureLike->setLikeToSeen($picture->picture_id);
            }
            $this->view('Picture/listPictures', ["pictureWithLikes" => $pictureWithLikes]);
        }

	function add() {
		if (isset($_POST['action'])) {

			if (isset($_FILES['myImage'])) {
				$check = getimagesize($_FILES['myImage']['tmp_name']);
				$allowedTypes = ['image/gif', 'image/jpeg', 'image/png'];

				if ($check !== false && in_array($check['mime'], $allowedTypes)) {
					$extension = ['image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/png' => 'png'];
					$extension = $extension[$check['mime']];
					$target_folder = 'uploads/';
					$targetFile = uniqid() . ".$extension";
						$picture = new \App\models\Picture();
						$picture->filename = $targetFile;
						$picture->caption = $_POST['caption'];
                        $picture->profile_id = $_SESSION['profile_id'];
						$picture->insert();
						header('location:' . BASE . '/Picture/index/');
                    echo 'error: Possibly wrong file type. The allowed file types are gif, jpeg, png';
                } 
			}
		} else
			$this->view('Picture/upload');
	}

	function delete($picture_id) {
		$picture = new \App\models\Picture();
		$picture = $picture->find($picture_id);
        $picture->picture_id = $picture_id;
		$path =  getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $picture->filename;
		unlink($path);
		$picture->delete();
        header('location:' . BASE . '/Picture/index/');
	}

	function edit($picture_id) {
		$picture = new \App\models\Picture();
		$picture = $picture->find($picture_id);
        $picture->picture_id = $picture_id;
		if (isset($_POST['action'])) {
			$picture->caption = $_POST['caption'];
			$picture->update();
            header('location:' . BASE . '/Picture/index/');
		} else {
			$this->view('Picture/edit', $picture);
		}
	}
}
