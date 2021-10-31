<html>
<head>
    <title>Upload an image file</title>
</head>
<body>
    <a href="<?=BASE."/Picture/index"?>">Go back</a>
	<form action="" method="post" enctype="multipart/form-data">
		<label>caption text: <input type="text" name="caption" /></label><br />
		<label>Select an image file to upload: <input type= "file" name="myImage" /></label><br>
		<input type="submit" name="action" />
	</form>
		
	</body>
</html>