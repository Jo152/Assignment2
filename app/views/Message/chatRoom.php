<html>
<head>
	<title>ChatRoom w/<?=$data["receiver"]->first_name?></title>
    <style>
        body {
            justify-content: center;
        }
        body, .chatHolder {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .chatHolder {
            border: 1px solid;
            width: 960px;
            height: 70vh;
            overflow: scroll;
        }
        .chatHolder, .messageBox {
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
        .messageBox {
            width: 760px;
            font-size: 17px;
        }

        .submit {
            width: 200px;
            font-size: 15px;
            background-color: #181da3;
            border: none;
            color: white;
        }
        .messageBox, .submit {
            height: 40px;
        }

    </style>
</head>
<body>
    <a href="<?=BASE."/Message"?>">Go back to Messages</a>

    <h3>You are chatting with <?=$data["receiver"]->first_name?></h3>
    <div class="chatHolder">
        <?php
            foreach ($data["messages"] as &$message) {
                $className = $message["sender"] === $_SESSION["profile_id"] ? "sender" : "receiver";
                echo "<div class=$className>"
                    .$message['message']." | ".$message['timestamp'];
                if ($className === 'receiver') {
                    echo "<small><a href=".BASE."/Message/delete/".$message["message_id"].">
                    Delete message</a></small>";
                }
                echo "</div>"
                ;
            }
        ?>
    </div>
    <form method="POST" action="">
        <input class="messageBox" name="message" type="text" autofocus/>
        <label><input type="radio" name="public" value="public">Make this message public?</label><br/>
        <input class="submit" name="action" type="submit" value="Send" />
    </form>
</body>
</html>