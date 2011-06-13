<?php
	include_once 'common/common.php';
	include_once 'getdata.php';
	session_start();
	$succ = FALSE;
	$labelid = $_GET['label'];
	$userid = $_SESSION['USERNAME'];
	$picid = $_SESSION['picid'];
	$pairid = $_SESSION['pairid'];
	$gameid = $_SESSION['gameid'];
	
	$limits = getOfflimits($picid);
	foreach ($limits as $limit){
		if($limit == $labelid){
			echo json_encode(array('matched'=>'limited','label'=>$limit));
			exit();
		}
	}
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	$addlabel = "insert into labelforgame values('$labelid','$userid','$picid','$pairid','$gameid');";
	$executeadd = mysql_query($addlabel);
	$partner = "SELECT * from player where userid = (select partid from player where userid = '$userid');";
	$executep = mysql_query($partner);
	if($executep){
		while($row = mysql_fetch_object($executep)){
			if($row -> status == 2){
				$getlabels = "SELECT * from labelforgame where player = '$row->userid'
				 and labelid = '$labelid' and picid = '$picid' and gameid='$gameid';";
				$executelabels = mysql_query($getlabels);
				if(mysql_num_rows($executelabels) <> 0){
					$succ = TRUE;
				}
			}
		}
	}
	
	mysql_close($conn);
	if ($succ) {
		$pairid=$_SESSION['pairid'];
		$db = new mysqli($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$cfg_dbname);
		//获取新图片
		$picarry = get_pic($db);
		//创建新的game
		$insertquery = "insert into game(pairid,picid,status) values('$pairid','$picarry[picid]',0)";
		$db->query($insertquery);
		
		$sql="select @@IDENTITY as id";
		$result = $db->query($sql);
		$gameidarray = $result->fetch_array();
		$newgameid = $gameidarray['id'];
		$_SESSION['gameid'] = $newgameid;  //更新game id
		//更新current game
		$updatepair="UPDATE gamepair SET currentgame = '$newgameid' where id='$_SESSION[pairid]';";
		$db->query($updatepair);
		//update old game status;
		$updates="UPDATE game SET status = '1' where id='$gameid';";
		$db->query($updates);
		
		//updata the label info
		$countsql = "select count(*) as c from label where picid='$_SESSION[picid]' and content = '$_GET[label]'";
		$count_result = $db->query($countsql);
		$temp = $count_result->fetch_assoc();
		$num = $temp['c'];
		if($num == 0){
			$insertsql = "insert into label values('$_SESSION[picid]','$_GET[label]',1)";
			$db->query($insertsql);
		}
		else {
			$updatesql = "update label set times = times + 1 where picid='$_SESSION[picid]' and content = '$_GET[label]'";
			$db->query($updatesql);
		}
		$num_result = $result->num_rows;
		// 通知对方
		$updates="UPDATE player SET status = '6' where userid='$_SESSION[partnerid]';";
		$_SESSION['picid'] = $picarry["picid"];
		$db->query($updates);

		echo json_encode(array('matched'=>'true','limits'=>$limits,"url"=> $picarry["url"],"picid"=>$picarry["picid"],"gameid"=>$gameid));
	}
	else{
		echo json_encode(array('matched'=>'false'));
	}
?>