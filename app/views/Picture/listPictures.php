<html>
<head>
	<title>All your pictures</title>
    <style>
        .wrapper {
            width: 90vw;
            margin: auto;
        }
        .imageHolder {
            padding: 10px;
            border-bottom: 1px solid;
        }
        body, .infoActionHolder, .imageHolder, .wrapper {
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
    <div class="wrapper">
        <?php
            echo "
                <a href='".BASE."/Picture/add'>Add a new picture</a>
                <h2>These are all of your images. Only you can edit and delete them.</h2>
            ";
            foreach($data["pictureWithLikes"] as $value){
                $picture = $value["picture"];
                $numOfLikes = $value["numOfLikes"];
                $unreadLikeCount = $value["unreadLikeCount"];
                echo "
                <div class='imageHolder'>
                    <img src='".BASE."/uploads/$picture->filename' caption='$picture->caption' />
                    <div class='infoActionHolder'>
                        <p>Caption: $picture->caption</p>
                        <p>Likes: $numOfLikes</p>
                        <p>Unread Likes: $unreadLikeCount</p>
                        <a href='".BASE."/Picture/delete/$picture->picture_id'>delete</a>
                        <a href='".BASE."/Picture/edit/$picture->picture_id'>edit</a>
                    </div>
                </div>
                ";
            }
        ?>
    </div>
</body>
</html>