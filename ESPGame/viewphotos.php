<?php
include_once 'common/common.php';
session_start();
$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
if (!$conn)
{
	die("Connecttion to data failed:".mysql_error());
}
mysql_select_db('esp');
function getLabeledphotos(){
	$getpid = "select max(times),picid from label group by picid order by times desc;";
	$result = mysql_query($getpid);
	$list = array();
	while ($row = mysql_fetch_object($result)){
		$list[] = $row->picid;
	}
	return $list;
}
function getLabels($pid){
	$getlabel = "select content, times from label where picid = '$pid';";
	$result = mysql_query($getlabel);
	$list = array();
	while ($row = mysql_fetch_object($result)){
		$list[] = $row->content."_".$row->times;
	}
	return $list;
}
function getUrl($pid){
	$geturl = "select url from pic where picid = '$pid';";
	$result = mysql_query($geturl);
	if ($row = mysql_fetch_object($result)){
		return $row->url;
	}
}
?>
<html>
	<head>
		<title>index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href="css/viewphotos.css" type="text/css" rel="stylesheet" />
		<link href="css/index.css" type="text/css" rel="stylesheet" />
		<link href="css/play.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	<body>
		<div id="content">
		<?php include 'header.php';?>
		<div id="main">
			<div id="photos">
				<h1>LabeledPhotos</h1>
				<?php
				foreach ( getLabeledphotos() as $line ) {
					$url=getUrl($line);
				?>
					<div class="photo">
						<p class="name">
							<img src="<?= $url ?>" alt="<?= $url ?>" />
						</p>
						<p class="info">
						<?php 
						foreach ( getLabels($line) as $line2 ) {
						$temp = preg_split("/_/", $line2); 
						?>
							<strong><?= $temp[0] ?></strong>  <?= $temp[1] ?> <br />
						<?php } ?>
						</p>
					</div>
				<?php } ?>
			</div>
		</div>
		</div>
	</body>
</html>
