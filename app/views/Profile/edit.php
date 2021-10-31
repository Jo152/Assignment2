<!DOCTYPE html>
<html>
<head>
    <title>Edit your profile</title>
</head>
<body>
    <a href="<?=BASE."/Default/somewhereSecure"?>">Go back to Home Page</a>
    <form method="post" action="">
        <label>First Name: <input type="text" name="first_name" value="<?=$data->first_name?>"/></label><br />
        <label>Middle Name: <input type="text" name="middle_name" value="<?=$data->middle_name?>"/></label><br />
        <label>Last Name: <input type="text" name="last_name" value="<?=$data->last_name?>"/></label><br />

		<input type="submit" name="action" value="Create Profile" />
	</form>
</body>
</html>