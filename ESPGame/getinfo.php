<?php
	include_once 'common/common.php';
	include_once 'getdata.php';
	session_start();
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	$ret = array();
	$self= get_self();
	/*
	 * 4----对方窗口关闭
	 * 2----正在游戏
	 * 1----等待链接
	 * 5----pass
	 * 6----match
	 */
	if ($self->status=='4')
	{
		$updateStopGame="update player set status='1',partid=DEFAULT,pairid=DEFAULT where userid='$_SESSION[USERNAME]';";
		mysql_query($updateStopGame);
		$ret['parterstatus']=0;
	}
	else if($self->status == '5')
	{
		$checkself = "SELECT * from gamepair where id='$_SESSION[pairid]';";
		$result = mysql_query($checkself);
		$pair = mysql_fetch_object($result);
		$getpic = "SELECT pic.picid as picid, url from game,pic where id='$pair->currentgame' and pic.picid = game.picid;";
		$result2 = mysql_query($getpic);
		$picid = mysql_fetch_object($result2);
		
		$updatestart="UPDATE player SET status = '2' where userid='$_SESSION[USERNAME]' || userid='$_SESSION[partnerid]';";
		mysql_query($updatestart);
		$_SESSION['picid'] = $picid->picid;
		$_SESSION['gameid'] = $pair->currentgame;
		$limits = getOfflimits($picid->picid);
		$ret["picid"]= $picid->picid;
		$ret["url"] = $picid->url;
		$ret['parterstatus']=3;
		$ret['limits']=$limits;
	}
		else if($self->status == '6')
	{
		$checkself = "SELECT * from gamepair where id='$_SESSION[pairid]';";
		$result = mysql_query($checkself);
		$pair = mysql_fetch_object($result);
		$getpic = "SELECT pic.picid as picid, url from game,pic where id='$pair->currentgame' and pic.picid = game.picid;";
		$result2 = mysql_query($getpic);
		$picid = mysql_fetch_object($result2);
		
		$updatestart="UPDATE player SET status = '2' where userid='$_SESSION[USERNAME]' || userid='$_SESSION[partnerid]';";
		mysql_query($updatestart);
		$limits = getOfflimits($picid->picid);
		$_SESSION['picid'] = $picid->picid;
		$_SESSION['gameid'] = $pair->currentgame;
		$ret["picid"]= $picid->picid;
		$ret["url"] = $picid->url;
		$ret['parterstatus']=6;
		$ret['limits']=$limits;
	}
	else {
		$ret['parterstatus']=1;
		$ret['picid']=$_SESSION['picid'];
		$ret['gameid']=$_SESSION['gameid'];
	}
	
	echo json_encode($ret);
?>