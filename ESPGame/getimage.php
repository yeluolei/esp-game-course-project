<?php
/*
 * 如果get参数中有picid
 * 则会返回一张不重复的pic
 * 返回值：url  and   picid
 * Zhu Xinyu
 *
 */
include_once 'common/common.php';
$db = new mysqli($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$cfg_dbname);
$tableName="pic";
$picid;
$uniquePicFlag = 0;
if(is_array($_GET)&&count($_GET)>0){
	if(isset($_GET["picid"])){
		$picid=$_GET["picid"];
		$uniquePicFlag = 1;
	}
}

$queryString = "SELECT picid, url FROM ".$tableName."
WHERE picid >= (SELECT floor(RAND() * (SELECT MAX(picid) FROM ".$tableName.")))  
ORDER BY picid LIMIT 1";

$result;
$pic;
//echo $queryString;
while(1){
	$result = $db->query($queryString);
	$pic = $result->fetch_array();
	if($uniquePicFlag == 1 && $pic["picid"] == $picid){
		continue;
	}
	else {
		break;
	}
}

if(!$result){
	echo("error");
	exit();
}

echo json_encode(array("url"=> $pic["url"],"picid"=>$pic["picid"]));

function get_image()
{
	return json_encode(array("url"=> "image/test2.jpg"));
}
?>
