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
						alert("matched");
					}
				},"json");
			};
		</script>
<style type="text/css">
br {
	clear: both;
}

.cntSeparator {
	font-size: 54px;
	margin: 10px 7px;
	color: #000;
}

.desc {
	margin: 7px 3px;
}

.desc div {
	float: left;
	font-family: Arial;
	width: 70px;
	margin-right: 65px;
	font-size: 13px;
	font-weight: bold;
	color: #000;
}

#time{
	overflow:hiden;
}
</style>
</head>
<body>
<?php
session_start();
?>
<button id="begingame">开始游戏</button>
<div id="content"><?php include 'header.php';?>
<div id="main">
<div id="game">
<div id="gameleft">
<div id="time">
<h1>Time</h1>
<div id="counter_2"></div>
<div class="desc">
</div>
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
<div id="input"><input id="labelbox" type="text" /> <input id="label"
	class="button" type="button" value="Label" /> <input id="pass"
	class="button" type="button" value="Pass" /> <img id="gameimg"
	src="image/test.jpg" /></div>
<div id="image"></div>
</div>
</div>
</div>
<div id="footer"><?php

/*$url = 'http://api.flickr.com/services/rest/'; // 璇锋眰鐨刄RL鍦板潃
 $params = '?method=flickr.photos.search' . // method鎸囨槑Flickr API鎵�彁渚涚殑鏌愪釜鏂规硶
 '&api_key=4a06195ccc70207ef0c1710ae6a4ae91' .  // Flickr鍒嗛厤鐨刱ey
 '&text=sea'; // 鍏抽敭瀛�	//鐢熸垚鐨刄RL
 //http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=2f59b5e190101271213d4b636e30824f&text=sea
 //濡傛灉鎶婃敼URL榛忚创鍒版祻瑙堝櫒鐨勫湴鍧�爮閲岋紝鍚屾牱鍙互寰楀埌XML鏂囦欢
 $contents = file_get_contents($url . $params);
 $xml = new SimpleXMLElement($contents); // 瑙ｆ瀽XML鏂囦欢
 foreach ($xml->photos->photo as $value) {
 $src = 'http://farm' . $value['farm'] . ".static.flickr.com/" .
 $value['server'] . '/' . $value['id'] . '_' . $value['secret'] . '_s.jpg'; // _s鐢ㄦ潵鎺у埗鏄剧ず鍥剧墖鐨勫ぇ灏�reference:http://www.flickr.com/services/api/misc.urls.html
 echo "<img src=\"$src\" />";
 }*/
?></div>
</div>
</body>
</html>
