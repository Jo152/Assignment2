<html>
<head>
	<title>ChatRoom</title>
</head>
<body>
    <h3>ChatRoom with <?=$data["receiver"]->first_name?></h3>
        <?php
            foreach ($data["messages"] as &$message) {
                $className = $message["sender"] === $_SESSION["profile_id"] ? "sender" : "receiver";
                echo "<div class=$className>"
                    .$message['message']." | ".$message['timestamp'];
                if ($className === 'receiver') {
                    echo "<small><a href=".BASE."/Message/delete/".$message["message_id"].">
                    Delete message</a></small>";
                }

            }
        ?>
    <form method="POST" action="">
        <input class="messageBox" name="message" type="text" autofocus/>
        <label><input type="radio" name="public" value="public">Public</label><br/>
        <input class="submit" name="action" type="submit" value="Send" />
    </form>
    <br>
    <a href="<?=BASE."/Message"?>">Message List</a>
</body>
</html>