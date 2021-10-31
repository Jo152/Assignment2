<?php

namespace App\controllers;

#[\App\core\LoginFilter]
#[\App\core\ProfileFilter]
class PictureLikeController extends \App\core\Controller {

    public function like($pictureId, $profileId) {
		$pictureLike = new \App\models\PictureLike();

        $pictureLike->picture_id = $pictureId;
        $pictureLike->profile_id = $profileId;
        $pictureLike->read_status=UNSEEN;
        $pictureLike->timestamp=date("Y-m-d");
        $pictureLike->insert();
        
        $picture = new \App\models\Picture();
        $pictureOwnerId = $picture->getPictureOwnerId($pictureId);
        header('location:' . BASE . '/Profile/wall/'.$pictureOwnerId);
    }

    public function unlike($pictureId, $profileId) {
		$pictureLike = new \App\models\PictureLike();

        $pictureLike->picture_id = $pictureId;
        $pictureLike->profile_id = $profileId;
        $pictureLike->delete();
        
        $picture = new \App\models\Picture();
        $pictureOwnerId = $picture->getPictureOwnerId($pictureId);
        header('location:' . BASE . '/Profile/wall/'.$pictureOwnerId);
    }

}
