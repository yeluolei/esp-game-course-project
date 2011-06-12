<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>index</title>
<link href="css/play.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/image.js"></script>
<script type="text/javascript" src="js/play.js"></script>
<script src="js/countdown.js" type="text/javascript" charset="utf-8"></script>
<script>
			$(
					function(){
						$('#label').bind("click",test);

					    $('#counter_2').countdown({
					        image: 'image/digits.png',
					        startTime: '00:10',
					        timerEnd: function(){ alert('end!'); },
					        format: 'mm:ss'
					      });
						}

					
			);
			
			function test(){
				var item = $('#labelbox').attr("value");
				var id = 1;
				$.get('match.php',{label:item, picid:id},function(data){
					if (data.matched == "false"){
						alert("not matched");
						}
					else{
						$('#gameimg').attr({
							src : data.url
						});
						alert("matched");
					}
				},"json");
			};
		</script>
</head>
<body>
<?php
session_start();
?>
	<div id="content">
	<?php include 'header.php';?>
		<div id="main">
			<div id="game">
				<div id="gameleft">
					<div id="time">
						<h1>Time</h1>
						<div id="counter_2"></div>
						<div class="desc"></div>
					</div>
					<div id="score">
						<h1>Score</h1>
					</div>
					<div id="passes">
						<h1>Passes</h1>
					</div>
					<div id="offlimit">
						<h1>Off-limits</h1>
					</div>
					<div id="mylabels">
						<h1>My-labels</h1>
					</div>
				</div>
				<div id="gamecenter">
					<div id="input">
						<input id="labelbox" type="text" /> <input id="label"
							class="button" type="button" value="Label" /> <input id="pass"
							class="button" type="button" value="Pass" /> <img id="gameimg"
							src="image/test.jpg" />
					</div>
					<div id="image"></div>
				</div>
			</div>
		</div>
		<div id="footer"></div>
	</div>
</body>
</html>
