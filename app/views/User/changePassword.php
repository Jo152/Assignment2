<html>
<head>
	<title>Change password</title>
</head>
<body>
	<h3>Change password</h3>
	<form method="post" action="">
        <label>New Password: <input type="password" name="password" /></label><br />
		<label>New Password confirmation: <input type="password" name="password_confirm" /></label><br />
		<input type="submit" name="action" value="Submit changes" />
	</form>
	<br/>
    <a href="<?=BASE."/Default/goSecure"?>">Home Page</a>
</body>
</html>