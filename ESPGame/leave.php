<?php
	include_once 'common/common.php';
	session_start();
	$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	if (!$conn)
	{
		die("Connecttion to data failed:".mysql_error());
	}
	mysql_select_db('esp');
	
	function getUrl($pid){
	$geturl = "select url from pic where picid = '$pid';";
	$result = mysql_query($geturl);
	if ($row = mysql_fetch_object($result)){
		return $row->url;
	}
	}
	
	$query = "update player set status='7',partid=DEFAULT,pairid=DEFAULT where userid='$_SESSION[USERNAME]';";
	mysql_query($query);
	$lookupquery = "select distinct picid from labelforgame where pairid='$_SESSION[pairid]'";
	$picresult = mysql_query($lookupquery);
	while($picids = mysql_fetch_array($picresult)){
		$lookupquery = "select * from labelforgame where picid ='$picids[picid]' and pairid='$_SESSION[pairid]'";;
		$result = mysql_query($lookupquery);
		echo "<div>";
		echo "<img style='width : 150px ; height: 150px;' src='".getUrl($picids['picid'])."'/></br>";
		while($labels = mysql_fetch_array($result)){
			echo '<strong style="display: inline-block; width: 11em;text-align: center;">'.$labels["player"].'</strong>';
			echo $labels["labelid"].'<br/>';
		}
		echo "</div>";
	}
	//$lookupquery = "select * from labelforgame where pairid='$_SESSION[pairid]'";
	
//	$result = mysql_query($lookupquery);
//	$array = array();
//	$cnt = 0;
//	echo "<table>";
//	while($row = mysql_fetch_object($result)){
//		echo "<tr>";
//		echo "<td><img style='width : 100px ; height: 80px;' src='".getUrl($row->picid)."'/></td>";
//		echo "<td>".$row->player."</td>";
//		echo "<td>".$row->labelid."</td>";
//		echo "</tr>";
//	}
	
	echo "</table>";
	
	//unset($_SESSION[gameid]);
	//unset($_SESSION[partnerid]);
	//unset($_SESSION[picid]);
?>