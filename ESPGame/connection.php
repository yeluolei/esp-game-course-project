<?php
	include_once 'common/common.php';
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	$succ = FALSE;
	$checkself = "SELECT status from player where userid='$_SESSION[USERNAME]';";
	$r = mysql_query($checkself);
	if ($s = mysql_fetch_object($r))
	{
		if ($s->status == 2)
		{
			$succ = TRUE;
			$parter = "SELECT * from player where userid = (select partid from player where userid = '$_SESSION[USERNAME]');";
			$rp = mysql_query($parter);
			while($row = mysql_fetch_object($rp)){
				$updatep="UPDATE player SET partid = '$_SESSION[USERNAME]' where userid='$row->userid';";
				mysql_query($updatep);
				echo json_encode(array('partername'=>$row->userid , 'status'=>'success'));
			}
		}
	}
	
	if (!$succ){
		# Set self to can be connect.
		$queryupdate="UPDATE player SET status = '1' where userid='$_SESSION[USERNAME]';";
		mysql_query($queryupdate);
		$query="SELECT * FROM player where status = '1' && userid <> '$_SESSION[USERNAME]';";
		
		$result = mysql_query($query);
		
		# Set the parters and self to status 2 and self is a parter.
		while($ob = mysql_fetch_object($result)){
			$succ = TRUE;
			$updatestart="UPDATE player SET status = '2' where userid='$_SESSION[USERNAME]' || userid='$ob->userid';";
			mysql_query($updatestart);
			$up = "UPDATE player SET partid = '$_SESSION[USERNAME]' where userid='$ob->userid';";
			mysql_query($up);
			echo json_encode(array('partername'=>$ob->userid , 'status'=>'success'));
		}
	}
	if (!$succ) {
		echo json_encode(array('status'=>'fail'));
	}
?>
