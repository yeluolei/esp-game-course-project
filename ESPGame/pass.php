<?php
session_start();
include_once 'common/common.php';
$pairid=$_SESSION['pairid'];


$db = new mysqli($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$cfg_dbname);

//$queryPrepare = "insert into game(pairid,picid,status) values(?,?,?)";
//$queryString = "SELECT picid, url FROM ".$tableName."
//WHERE picid >= (SELECT floor(RAND() * (SELECT MAX(picid) FROM ".$tableName.")))  
//ORDER BY picid LIMIT 1";
//$result = $db->query($queryString);
//$pic = $result->fetch_array();

$picarry = get_pic($db);  //获取下一张图片
$insertquery = "insert into game(pairid,picid,status) values('$pairid','$picarry[picid]',0)";
$db->query($insertquery);
//$gamestatues = 0;
//$stmt = $db->prepare($queryPrepare);
//$stmt->bind_param("i,s,i",$pairid,$picarry['picid'],$gamestatues);
//$stmt->execute();

$sql="select @@IDENTITY as id";
$result = $db->query($sql);
$gameidarray = $result->fetch_array();
$gameid = $gameidarray['id'];

$updatepair="UPDATE gamepair SET currentgame = '$gameid' where id='$_SESSION[pairid]';";
$db->query($updatepair);

$updates="UPDATE player SET status = '5' where userid='$_SESSION[partnerid]';";
$db->query($updates);

echo json_encode(array("url"=> $picarry["url"],"picid"=>$picarry["picid"],"gameid"=>$gameid));

?>
