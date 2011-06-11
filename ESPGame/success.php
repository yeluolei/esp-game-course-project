<html>
	<head>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript">
		$(connect());	
		
		function connect(){
			$.get('connection.php',function(data){
					if (data.status == "fail"){
						setTimeout("connect()", 1000);
						}
					else{
						$('#noti').html('connect with : '+ data.partername);
					}
				},"json");
		};
		</script>
	</head>
	<body>
		<?php
		session_start();
		?>
		<p id="noti">success! <?=$_SESSION['USERNAME']?></p>
	</body>
</html>