<?php
include_once 'common/common.php';
$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
if (!$conn)
{
	die("Connecttion to data failed:".mysql_error());
}
mysql_select_db('esp');

function getToppairs(){
	$getpair = "SELECT gamepair.player1, gamepair.player2, SUM(game.status) as sum from game inner join gamepair on game.pairid = gamepair.id group by game.pairid order by SUM(game.status) desc;";
	$result = mysql_query($getpair);
	$index = 0;
	$list = array();
	while ($row = mysql_fetch_object($result) && $index<4){
		$list[] = $row;
		$index++;
	}
	print_r($list);
	return $list;
};
function getOfflimits($pid){
	$getlimits = "SELECT content from label where picid = '$pid' and times > 3;";
	$result = mysql_query($getlimits);
	$list = array();
	while ($row = mysql_fetch_object($result)){
		$list[] = $row->content;
	}
	print_r($list);
	return $list;
};
?>