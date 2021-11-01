<html>
<head>
	<title>Message List</title>
</head>
<body>
    <h3>Message List</h3>    
            <h3>Received messages:</h3>
            <br />
            <?php
                foreach ($data["senderAndMessage"] as &$value) {
                    $sender = $value["sender"];
                    echo "
                    <br/>
                    <a href='".BASE."/Message/chatRoom/$sender->profile_id'>$sender->first_name</a>";
                    if ($value["unreadMessages"]) {
                        echo "<p>Unread and To Reread message(s) sent by $sender->first_name:</p>
                        <ul>";
                        foreach ($value['unreadMessages'] as &$unreadMessage) {
                            echo "
                            <li>$unreadMessage->message</li>
                            <a href='".BASE."/Message/setStatus/read/$unreadMessage->message_id'>
                                Set status to \"Read\"</a>
                            <a href='".BASE."/Message/setStatus/reread/$unreadMessage->message_id'>
                                Set status to \"ReRead\"</a>
                            ";
                        }
                    }
                }
            ?>
            <h3>Sent messages:</h3>
            <br />
            <?php
                foreach ($data["receivers"] as &$receiver) {
                    echo "<a href='".BASE."/Message/chatRoom/$receiver->profile_id'>$receiver->first_name</a><br/>";
                }
            ?>
            <br>
            <a href="<?=BASE."/Default/goSecure"?>">Home Page</a>
</body>
</html>