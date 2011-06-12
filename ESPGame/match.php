<?php
	include_once 'common/common.php';
	session_start();
	$succ = FALSE;
	$labelid = $_GET['label'];
	$userid = $_SESSION['USERNAME'];
	$picid = $_GET['picid'];
	
	
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	$addlabel = "insert into labelforgame values('$labelid','$userid','$picid');";
	$executeadd = mysql_query($addlabel);
	$partner = "SELECT * from player where userid = (select partid from player where userid = '$userid');";
	$executep = mysql_query($partner);
	if($executep){
		while($row = mysql_fetch_object($executep)){
			if($row -> status == 2){
				$getlabels = "SELECT * from labelforgame where player = '$row->userid'
				 and labelid = '$labelid' and picid = '$picid';";
				$executelabels = mysql_query($getlabels);
				if($executelabels){
					$succ = TRUE;
				}
			}
		}
	}
	
	if ($succ) {
		echo json_encode(array('matched'=>'true'));
	}
	else{
		echo json_encode(array('matched'=>'false'));
	}
?>