<html>
	<head>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript">
		$(init());
		function init()
		{
			close();
			check();
		};
		
		function connect(){
			$.get('connection.php',function(data){
					if (data.status == "fail"){
						setTimeout("connect()", 1000);
						}
					else{
						$('#noti').html('connect with : '+ data.partername);
						check();
					}
				},"json");
		};

		function close()
		{
			$(window).unload(
					function(){
						$.post('stopgame.php',{operation:'0'});
						});
		};

		function check()
		{
			$.get('getinfo.php',
					function(data){
						if (data.parterstatus == 0)
							{
								alert('parter leave');
								location.herf="login.php";
							}
						else{
								setTimeout("check()", 1000);
							}
				},"json");
			}
		
		</script>
	</head>
	<body>
		<?php
		session_start();
		?>
		<p id="noti">success! <?=$_SESSION['USERNAME']?></p>
	</body>
</html>