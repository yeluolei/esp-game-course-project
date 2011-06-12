<?php
session_start();
$pairid=$_SESSION['pairid'];
include_once 'common/common.php';
$db = new mysqli($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$cfg_dbname);
$queryPrepare = "insert into game(pairid,picid,status) values(?,?,?)";
$queryString = "SELECT picid, url FROM ".$tableName."
WHERE picid >= (SELECT floor(RAND() * (SELECT MAX(picid) FROM ".$tableName.")))  
ORDER BY picid LIMIT 1";
$result = $db->query($queryString);
$pic = $result->fetch_array();
$stmt = $db->prepare($queryPrepare);
$stmt->bind_param("i,s,i",$pairid,$pic['picid'],0);
$stmt->execute();


?>
