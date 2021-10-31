<html>
<head>
    <title>Home</title>
</head>
<body>
	<p>Welcome <?= $_SESSION['username'] ?></p>
	<p><a href='<?= BASE."/Picture/index/"?>'>
        Your Pictures</a></p>
    <p><a href='<?= BASE ?>/Message/'>Messages</a></p>
    <p><a href='<?= BASE ?>/Profile/edit'>Edit your profile</a></p>
    <p><a href='<?= BASE ?>/User/changePassword'>Change your password</a></p>
	<p><a href='<?= BASE ?>/Default/logout'>Logout</a></p>

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