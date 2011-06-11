<?php
//数据库连接信息
$cfg_dbhost = 'localhost';
$cfg_dbname = 'esp';
$cfg_dbuser = 'root';
$cfg_dbpwd = '1';
$cfg_db_language = 'utf8';


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
?>