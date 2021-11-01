<html>
<head>
	<title>My Pictures</title>
</head>
<body>
    <h3>My pictures</h3>
        <?php
            echo "
            <a href='".BASE."/Picture/add'>Add new picture</a>";
            foreach($data["pictureWithLikes"] as $value){
                $picture = $value["picture"];
                $numOfLikes = $value["numOfLikes"];
                $unreadLikeCount = $value["unreadLikeCount"];
                echo "
                <br><br>
                    <img src='".BASE."/uploads/$picture->filename' caption='$picture->caption' />
                    <p>Caption: $picture->caption</p>
                    <p>Likes: $numOfLikes</p>
                    <p>Unread Likes: $unreadLikeCount</p>
                    <a href='".BASE."/Picture/delete/$picture->picture_id'>delete</a>
                    <a href='".BASE."/Picture/edit/$picture->picture_id'>edit</a>   
                ";
            }
        ?>
        <br><br>
        <a href="<?=BASE."/Default/goSecure"?>">Home Page</a>
</body>
</html>