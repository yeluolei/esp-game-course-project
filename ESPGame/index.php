<html>
	<head>
		<title>index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href="css/index.css" type="text/css" rel="stylesheet"/>
		<link href="css/play.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
	</head>
	<body>
		<div id ="content">
			<?php include 'header.php';?>
			<div id="main">
				<center id="loginreg">
						<label class="t">Login</label>
						<div class="block">
							<label class="field">User Name:</label>
							<input id="userid" class="labelbox" type="text" name="userid"/>
						</div>
						<div class="block">
							<label class="field">Password:</label>
							<input id="passwd" class="labelbox" type="text" name="passwd"/>
						</div>
						<p id="noti"></p>
						<div class="buttonarea">
							<a id="changereg" href="#" >Register</a>
							<input id="login" class="button" type="button" value="Login"/>
						</div>
				</center>
				<div id ="toppair">
					<table>
						<tbody>
						<tr style="background-color:#5C9446;">
							<td>player 1</td>
							<td>player 2</td>
							<td>score</td>
						</tr>
						<?php
						include 'getdata.php';
						foreach ( getToppairs() as $line ) {
							?>
							<tr>
								<td><?= $line['player1']?></td>
								<td><?= $line['player2']?></td>
								<td><?= $line['sum'] ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
