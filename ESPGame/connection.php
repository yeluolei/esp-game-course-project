<?php
include_once 'common/common.php';
session_start();
$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
if (!$conn)
{
	die("Connecttion to data failed:".mysql_error());
}
mysql_select_db('esp');

$succ = FALSE;
$checkself = "SELECT status,pairid,partid from player where userid='$_SESSION[USERNAME]';";
$r = mysql_query($checkself);
if ($s = mysql_fetch_object($r))
{
	if ($s->status == 2)
	{
		$succ = TRUE;
		//if ($row = get_parter()){
			//$updatep="UPDATE player SET partid = '$_SESSION[USERNAME]' where userid='$row->userid';";
			//mysql_query($updatep);

			//$insertpairsql="insert into gamepair(player1,player2) values('$_SESSION[USERNAME]','$row->userid');";
			//mysql_query($insertpairsql);

			/*$sql="select @@IDENTITY as id";
			 $newid=mysql_query($sql);
			 $id = mysql_fetch_object($newid);
			 $id2 = $id->id;*/

			/*$updatep="UPDATE player SET pairid = '$id2' where userid='$row->userid';";
			mysql_query($updatep);

			$updatep="UPDATE player SET pairid = '$id2' where userid='$_SESSION[USERNAME]';";
			mysql_query($updatep);*/

			$_SESSION["pairid"]=$s->pairid;
			echo json_encode(array('partername'=>$s->partid , 'status'=>'success'));
		//}
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
			
		$updatep="UPDATE player SET partid = '$ob->userid' where userid='$_SESSION[USERNAME]';";
		mysql_query($updatep);

		$insertpairsql="insert into gamepair(player1,player2) values('$_SESSION[USERNAME]','$ob->userid');";
		mysql_query($insertpairsql);

		$sql="select @@IDENTITY as id";
		$newid=mysql_query($sql);
		$id = mysql_fetch_object($newid);
		$id2 = $id->id;
		
		$updatep="UPDATE player SET pairid = '$id2' where userid='$ob->userid';";
		mysql_query($updatep);

		$updatep="UPDATE player SET pairid = '$id2' where userid='$_SESSION[USERNAME]';";
		mysql_query($updatep);

		$_SESSION["pairid"]=$id2;
		echo json_encode(array('partername'=>$ob->userid , 'status'=>'success'));
	}
}
if (!$succ) {
	echo json_encode(array('status'=>'fail'));
}
?>
