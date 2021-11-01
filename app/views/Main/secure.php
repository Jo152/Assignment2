<html>
<head>
    <title>Home Page</title>
</head>
<body>
	<p>Welcome <?= $_SESSION['username'] ?></p>
	
    <p><a href='<?= BASE ?>/Message/'>My Messages</a></p>
    <p><a href='<?= BASE."/Picture/index/"?>'>
        My Pictures</a></p>
    <p><a href='<?= BASE ?>/User/changePassword'>Change password</a></p>
    <p><a href='<?= BASE ?>/Profile/edit'>Edit profile</a></p>
    
	<p><a href='<?= BASE ?>/Default/logout'>Logout</a></p>

    <h3>Search for a user</h3>
    <form method="GET">
        <input type="search" name="searchQuery" />
        <input type="submit" name="action" />
    </form>
    <?php
        if($data) {
            foreach ($data as &$user) {
                echo "
                    <a href='".BASE."/Profile/wall/$user->profile_id'>
                        $user->first_name $user->middle_name $user->last_name</a>
                    <br />
                ";
            }
        }
    ?>

</body>
</html>