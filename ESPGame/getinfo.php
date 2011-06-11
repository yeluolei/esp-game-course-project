<?php
	include_once 'common/common.php';
	session_start();
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	$ret = array();
	$self= get_self();
	if ($self->status=='4')
	{
		$updateStopGame="update player set status='1',partid=DEFAULT where userid='$_SESSION[USERNAME]';";
		mysql_query($updateStopGame);
		$ret['parterstatus']=0;
	}else {
		$ret['parterstatus']=1;
	}
	
	echo json_encode($ret);
?>