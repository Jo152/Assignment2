<html>
<head>
	<title>Change your password</title>
</head>
<body>
	<?php
		if(isset($_GET['error'])){
			echo $_GET['error'];
		}
	?>
    <br/>
    <a href="<?=BASE."/Default/somewhereSecure"?>">Go back to Home Page</a>
	<form method="post" action="">

        <label>New Password: <input type="password" name="password" /></label><br />
		<label>New Password confirmation: <input type="password" name="password_confirm" /></label><br />
	
		<input type="submit" name="action" value="Submit changes" />
	</form>
</body>
</html>