<html>
<head>
	<title>Your Messaging Contacts</title>
    <style>
        .wrapper {
            display: flex;
        }
        .wrapper > div {
            flex: 1;
            height: 90vh;
            overflow: scroll;
            border-right: 1px solid;
            padding: 10px;
        }
    </style>
</head>
<body>
    <a href="<?=BASE."/Default/somewhereSecure"?>">Go back to the Home Page</a>
    <div class="wrapper">
        <div>
            <h3>Who sent you a message:</h3>
            <small>Click on a person to view the conversation.</small>
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
                        echo "</ul><br/>";
                    }
                }
            ?>
        </div>
        <div>
            <h3>You sent a message to:</h3>
            <small>Click on a person to view the conversation</small>
            <br />
            <?php
                foreach ($data["receivers"] as &$receiver) {
                    echo "<a href='".BASE."/Message/chatRoom/$receiver->profile_id'>$receiver->first_name</a><br/>";
                }
            ?>
        </div>
    </div>
</body>
</html>