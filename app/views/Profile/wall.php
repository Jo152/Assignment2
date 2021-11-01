<!DOCTYPE html>
<html>
<head>
    <title>My Profile Wall</title>

</head>
<body>
<a href="<?=BASE."/Default/goSecure"?>">Home Page</a>
    <?php
        $profile = $data['profile'];
        echo "
            <ul>
                <li>First name: $profile->first_name</li>
                <li>Middle name: $profile->middle_name</li>
                <li>Last name: $profile->last_name</li>
                <li><a href='".BASE."/Message/chatRoom/$profile->profile_id'>
                    Chat with $profile->first_name</a></li>
            </ul>
        ";
    ?>

        <h2>Public messages sent to <?=$data["profile"]->first_name?></h2>
            <?php
                foreach ($data["messages"] as &$message) {
                    $messageObj = $message["message"];
                    $isReceiver = $messageObj->receiver === $_SESSION["profile_id"];
                    echo "<div>"
                        .$messageObj->message." | ".$messageObj->timestamp." | Sent to ".$message["receiver"]." by ".$message["sender"];
                    if ($isReceiver) {
                        echo "<small><a href=".BASE."/Message/delete/".$messageObj->message_id.">
                        Delete message</a></small>";
                    }
                }
            ?>
        <?php
            echo "<h2>".$data['profile']->first_name."'s pictures</h2>";
            foreach($data["pictures"] as $value){
                $picture = $value["picture"];
                $numOfLikes = $value["numOfLikes"];
                $likeStatus = $value["hasLiked"] ? "You have liked this photo" :
                "You have not liked this photo";
                echo "
                <div class='imageHolder'>
                    <img src='".BASE."/uploads/$picture->filename' caption='$picture->caption' />
                    <div class='infoActionHolder'>
                        <p>Caption: $picture->caption</p>
                        <p>Likes: $numOfLikes</p>
                        <p>$likeStatus</p>
                        ";
                if ($value["hasLiked"]) {
                    echo "<a href='".BASE."/PictureLike/unlike/$picture->picture_id/".$_SESSION["profile_id"]."'>
                    Unlike Picture</a>";
                } else {                        
                    echo "<a href='".BASE."/PictureLike/like/$picture->picture_id/".$_SESSION["profile_id"]."'>
                        Like Picture</a>";
                } 
            }
        ?>

</body>
</html>