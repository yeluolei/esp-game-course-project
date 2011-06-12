<?php
//数据库连接信息
$cfg_dbhost = 'localhost';
$cfg_dbname = 'esp';
$cfg_dbuser = 'root';
$cfg_dbpwd = '1';
$cfg_db_language = 'utf8';

$stat_requestPass = '5';
$stat_agreePass = '6';

function get_parter()
{
	$parter = "SELECT * from player where userid = (select partid from player where userid = '$_SESSION[USERNAME]');";
	$rp = mysql_query($parter);
	if ($row = mysql_fetch_object($rp)){
		return $row;
	}
	return FALSE;
}

function get_self()
{
	$self = "SELECT * from player where userid ='$_SESSION[USERNAME]';";
	$rp = mysql_query($self);
	if ($row = mysql_fetch_object($rp)){
		return $row;
	}
	return FALSE;
}

function get_pic(  mysqli $link )
{
	$tableName='pic';
	$queryString = "SELECT picid, url FROM ".$tableName."
WHERE picid >= (SELECT floor(RAND() * (SELECT MAX(picid) FROM ".$tableName.")))  
ORDER BY picid LIMIT 1";
	
	$result = $link->query($queryString);
	$pic = $result->fetch_array();
	$result = array("url"=> $pic["url"],"picid"=>$pic["picid"]);
	return $result;
}

function get_pic_p()
{
	$tableName='pic';
	$queryString = "SELECT picid, url FROM ".$tableName."
WHERE picid >= (SELECT floor(RAND() * (SELECT MAX(picid) FROM ".$tableName.")))  
ORDER BY picid LIMIT 1";
	
	$result = mysql_query($queryString);
	$pic = mysql_fetch_array($result);
	$result = array("url"=> $pic["url"],"picid"=>$pic["picid"]);
	return $result;
}
?>