<html>
	<head>
		<title>index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href="css/index.css" type="text/css" rel="stylesheet"/>
		<link href="css/play.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript">
			function click(){
					$.post("validateadmin.php",
							{userid:$('#userid').val(),passwd:$('#passwd').val()},
							function(data){
								if (data.succ==true)
								{
									window.location.href="viewphotos.php";
								}else{
									$('#noti').html(data.msg);
								}
							},"json");
			};
		</script>
	</head>
	<body>
		<div id ="content">
			<?php include 'header.php';?>
			<div id="main">
				<center id="loginreg">
						<label class="t">Login</label>
						<div class="block">
							<label class="field">AdminName:</label>
							<input id="userid" class="labelbox" type="text" name="userid"/>
						</div>
						<div class="block">
							<label class="field">Password:</label>
							<input id="passwd" class="labelbox" type="text" name="passwd"/>
						</div>
						<p id="noti"></p>
						<div class="buttonarea">
							<input id="login" class="button" type="button" value="Login" onclick="click()"/>
						</div>
				</center>
			</div>
		</div>
	</body>
</html>

