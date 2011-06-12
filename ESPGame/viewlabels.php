<?php
include_once 'common/common.php';
session_start();
$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
if (!$conn)
{
	die("Connecttion to data failed:".mysql_error());
}
mysql_select_db('esp');
function getPhotos(){
	$getpid = "select max(labelid),picid from labelforgame where player = '$_SESSION[USERNAME]' group by picid order by labelid desc;";
	$result = mysql_query($getpid);
	$list = array();
	while ($row = mysql_fetch_object($result)){
		$list[] = $row->picid;
	}
	return $list;
}
function getLabels($pid){
	$getlabels = "select labelid from labelforgame where player = '$_SESSION[USERNAME]' and picid = '$pid';";
	$result = mysql_query($getlabels);
	$list = array();
	while ($row = mysql_fetch_object($result)){
		$list[] = $row;
	}
	return $list;
}
function getUrl($pid){
	$geturl = "select url from pic where picid = '$pid';";
	$result = mysql_query($geturl);
	$list = array();
	if ($row = mysql_fetch_object($result)){
		$list[] = $row->url;
	}
	return $list;
}
?>
<html>
	<head>
		<title>index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href="css/viewphotos.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	<body>
		<div id="main">
			<div id="photos">
				<h1>LabeledPhotos</h1>
				<?php
				foreach ( getPhotos() as $line ) {
					$url=getUrl($line);
				?>
					<div class="photo">
						<p class="name">
							<img src="<?= $url ?>" alt="<?= $line ?>" />
						</p>
						<p class="info">
						<?php 
						foreach ( getLabels($line) as $line2 ) {
						?>
							<strong><?= $line ?></strong><br />
						<?php } ?>
						</p>
					</div>
				<?php } ?>
			</div>
		</div>
	</body>
</html>
