<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>login</title>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
	<link href="css/login.css" type="text/css" rel="stylesheet"/>
</head>
<body>
	<div id="content">
		<?php include 'header.php'; ?>
		<form method="post" action="validate.php">
			<div class="block">
				<label class="field">User Name:</label>
				<input class="labelbox" type="text" name="userid"/>
			</div>
			<div class="block">
				<label class="field">Password:</label>
				<input class="labelbox" type="text" name="passwd"/>
			</div>
			<input class="button"  type="submit" value="Login"/>
		</form>
	</div>
</body>
</html>
