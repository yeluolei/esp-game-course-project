<?php
include_once 'common/common.php';
$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
if (!$conn)
{
	die("Connecttion to data failed:".mysql_error());
}
mysql_select_db('esp');

function getToppairs(){
	$getpair = "SELECT gamepair.player1 as player1, gamepair.player2 as player2, SUM(game.status) as sum from game inner join gamepair on game.pairid = gamepair.id group by game.pairid order by SUM(game.status) desc;";
	$result = mysql_query($getpair);
	$index = 0;
	$list = array();
	//$temparray = mysql_fetch_array($result);
	while ($array = mysql_fetch_array($result)){
		//echo 'www';
		if($index >= 10){
			break;
		}
		//print_r($array);
		$list[$index] = $array;
		$index = $index + 1;
	}
	return $list;
};
function getOfflimits($pid){
	$getlimits = "SELECT content from label where picid = '$pid' and times > 1;";
	$result = mysql_query($getlimits);
	$list = array();
	while ($row = mysql_fetch_object($result)){
		$list[] = $row->content;
	}
	//print_r($list);
	return $list;
};

function getOfflimits_o(mysqli $db, $pid){
	$getlimits = "SELECT content from label where picid = '$pid' and times > 1;";
	$result = $db->query($getlimits);
	$list = array();
	while ($row = $result->fetch_object()){
		$list[] = $row->content;
	}
	//print_r($list);
	return $list;
};
?>