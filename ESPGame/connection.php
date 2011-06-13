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

$succ = FALSE;
$checkself = "SELECT status,pairid,partid from player where userid='$_SESSION[USERNAME]';";
$r = mysql_query($checkself);
if ($s = mysql_fetch_object($r))
{
	if($s->status == 7){
		$queryupdate="UPDATE player SET status = '1' where userid='$_SESSION[USERNAME]';";
		mysql_query($queryupdate);
		echo json_encode(array('status'=>'fail',"7777"=>"sfssdfsa"));
		exit();
	}
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
			//$getpic = "SELECT pic.picid as picid, url from player,game,pic,gamepair where player.id='$_SESSION[USERNAME]' and game.id=gamepair.currentgame and pic.picid = game.picid and gamepair.id= player.partid;";
			$getpic = "select url, pic.picid as picid,game.id as gameid from gamepair, pic, game where gamepair.id = '$s->pairid' and gamepair.currentgame=game.id and game.picid=pic.picid";
			$result2 = mysql_query($getpic);
			$picid = mysql_fetch_object($result2);
			$_SESSION["pairid"]=$s->pairid;
			$_SESSION["partnerid"] = $s->partid;
			$_SESSION['picid'] = $picid->picid;
			$_SESSION['gameid'] = $picid->gameid;
			$limits = getOfflimits($s->partid);
			echo json_encode(array('partername'=>$s->partid ,'limits'=>$limits, 'status'=>'success',"url"=>$picid->url));
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
		$id2 = $id->id;  //gamepair id
		
		//$insertquery = "insert into game(pairid,picid,status) values('$id2','$picarry[picid]',0)";
		
		$updatep="UPDATE player SET pairid = '$id2' where userid='$ob->userid';";
		mysql_query($updatep);

		$updatep="UPDATE player SET pairid = '$id2' where userid='$_SESSION[USERNAME]';";
		mysql_query($updatep);

		$_SESSION["pairid"]=$id2;
		$_SESSION["partnerid"]= $ob->userid;
		
		$picarry = get_pic_p();  //获取下一张图片
		$insertquery = "insert into game(pairid,picid,status) values('$id2','$picarry[picid]',0)";
		mysql_query($insertquery);
		$_SESSION['picid'] = $picarry['picid'];
		$sql="select @@IDENTITY as id"; //获取game的id
		$gameidrwa = mysql_query($sql);
		$gameidarray = mysql_fetch_array($gameidrwa);
		$gameid = $gameidarray['id'];
		$_SESSION['gameid'] = $gameid;
		$updatepair="UPDATE gamepair SET currentgame = '$gameid' where id='$id2';";
		mysql_query($updatepair);
		$limits = getOfflimits($picarry["picid"]);
		echo json_encode(array('partername'=>$ob->userid ,'limits'=>$limits, 'status'=>'success',"url"=>$picarry['url']));
	}
}
if (!$succ) {
	echo json_encode(array('status'=>'fail'));
}
?>
