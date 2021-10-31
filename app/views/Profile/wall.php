<!DOCTYPE html>
<html>
<head>
    <title><?=$data['profile']->first_name?>'s wall</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .chatHolder {
            border: 1px solid;
            width: 960px;
            height: 30vh;
            overflow: scroll;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
            margin-bottom: 10px;
            padding: 10px;
        }
        .sender {
            background-color: #a8bff7;
            display: flex;
            justify-content: flex-end;
        }
        .receiver {
            background-color: #b8b8b8;
            display: flex;
        }
        .receiver, .sender {
            margin-bottom: 10px;
            width: 90%;
            font-size: 20px;
        }
        form {
            display: flex;
            justify-content: center;
        }
        .chatWrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .pictureWrapper {
            width: 90vw;
            margin: auto;
        }
        .imageHolder {
            padding: 10px;
            border-bottom: 1px solid;
        }
        body, .infoActionHolder, .imageHolder, .pictureWrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        p {
            margin:3px 0px;
        }
        img {
            max-height: 600px;
            max-width: 1000px;
        }

    </style>
</head>
<body>
<a href="<?=BASE."/Default/somewhereSecure"?>">Go back to Home Page</a>

<div>
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
</div>

<div class="chatWrapper">
        <h2>Public messages sent to <?=$data["profile"]->first_name?></h2>
        <div class="chatHolder">
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
                    echo "</div>"
                    ;
                }
            ?>
        </div>
</div>

<div class="pictureWrapper">
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
                echo "
                    </div>
                </div>
                ";
            }
        ?>
    </div>

</body>
</html>