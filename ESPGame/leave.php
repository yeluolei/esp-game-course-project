<?php
	include_once 'common/common.php';
	session_start();
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	$query = "update player set status='1',partid=DEFAULT,pairid=DEFAULT where userid='$_SESSION[USERNAME]';";
	mysql_query($query);
	unset($_SESSION[gameid]);
	unset($_SESSION[partnerid]);
	unset($_SESSION[picid]);
?>