<?php
session_start();
include_once 'common/common.php';
include_once 'getdata.php';
$pairid=$_SESSION['pairid'];

$db = new mysqli($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$cfg_dbname);

$picarry = get_pic($db);  //获取下一张图片
$insertquery = "insert into game(pairid,picid,status) values('$pairid','$picarry[picid]',0)";
$db->query($insertquery);

$sql="select @@IDENTITY as id";
$result = $db->query($sql);
$gameidarray = $result->fetch_array();
$gameid = $gameidarray['id'];

$_SESSION['gameid'] = $gameid;

$updatepair="UPDATE gamepair SET currentgame = '$gameid' where id='$_SESSION[pairid]';";
$db->query($updatepair);

$updates="UPDATE player SET status = '5' where userid='$_SESSION[partnerid]';";
$db->query($updates);
$_SESSION['picid'] = $picarry["picid"];
$limits = getOfflimits($picarry["picid"]);
echo json_encode(array("url"=> $picarry["url"],"picid"=>$picarry["picid"],"gameid"=>$gameid,'limits'=>$limits));

?>
