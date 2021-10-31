<html>
<head>
	<title>Edit picture</title>
</head>
<body>
	<form method="post" action="">
		<img src='<?=BASE?>/uploads/<?=$data->filename ?>' /><br />
		<label>Caption: <input type="text" name="caption" value="<?=$data->caption ?>" /></label><br />

		<input type="submit" name="action" value="Submit changes" />
	</form>
	<a href="<?=BASE?>/Default/index">Cancel</a>
</body>
</html>