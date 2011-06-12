<html>
	<head>
		<title>index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href="css/index.css" type="text/css" rel="stylesheet"/>
		<link href="css/play.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
					$('#login').click(
							function(){
								$.post("validateadmin.php",
									{userid:$('#userid').attr('value'),passwd:$('#passwd').attr('value')},
									function(data){
										if (data.succ==true)
										{
											window.location.href="viewphotos.php";
										}else{
											$('#noti').html(data.msg);
										}
									},"json");
							}
					);
			});
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
							<input id="login" class="button" type="button" value="Login""/>
						</div>
				</center>
			</div>
		</div>
	</body>
</html>

