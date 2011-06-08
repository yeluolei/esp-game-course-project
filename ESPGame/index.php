<html>
	<head>
		<title>index</title>
		<link href="css/index.css" type="text/css" rel="stylesheet"/>
	</head>
	<body>
		<div id ="content">
		<div id="header">
			<div id="title">
				<div id="left">
					<center class="dg">I</center>
					<center class="lg">M</center>
					<center class="lb">A</center>
					<center class="dg">G</center>
					<center class="lg">E</center>
				</div>
				<div id="right">
					<center class="lo"> </center>
					<center class="lr">L</center>
					<center class="ly">A</center>
					<center class="lp">B</center>
					<center class="lr">E</center>
					<center class="ly">L</center>
				</div>
			</div>
		</div>
		<div id="main">
		<div id="game"></div>
			<div id="gameleft">
				<div id="time">
					<h1>Time</h1>
				</div>
				<div id="score">
					<h1>Score</h1>
				</div>
				<div id="passes">
					<h1>Passes</h1>
				</div>
			</div>
			<div id="gamecenter">
				<div id="input">
					<input id="labelbox" type="text"/>
					<input class="button" type="button" value="Label"/>
					<input class="button" type="button" value="Pass"/>
				</div>
				<div id="image"></div>
			</div>
			<div id="gameright">
				<div id="offlimit">
					<h1>Off-limits</h1>
				</div>
				<div id="mylabels">
					<h1>My-labels</h1>
				</div>
			</div>
		</div>
		</div>
		<div id="footer">
		<?php
			$url = 'http://api.flickr.com/services/rest/'; // 请求的URL地址
			$params = '?method=flickr.photos.search' . // method指明Flickr API所提供的某个方法
          			'&api_key=4a06195ccc70207ef0c1710ae6a4ae91' .  // Flickr分配的key
          			'&text=sea'; // 关键字
//生成的URL
//http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=2f59b5e190101271213d4b636e30824f&text=sea
//如果把改URL黏贴到浏览器的地址栏里，同样可以得到XML文件
			$contents = file_get_contents($url . $params);
			$xml = new SimpleXMLElement($contents); // 解析XML文件
			foreach ($xml->photos->photo as $value) {
   			$src = 'http://farm' . $value['farm'] . ".static.flickr.com/" .
    		$value['server'] . '/' . $value['id'] . '_' . $value['secret'] . '_s.jpg'; // _s用来控制显示图片的大小 reference:http://www.flickr.com/services/api/misc.urls.html
    		echo "<img src=\"$src\" />";
			}
		?>
		</div>
		</div>
	</body>
</html>