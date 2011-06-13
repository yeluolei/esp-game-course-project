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

function get_pic_from_flickr( mysqli $db){
	$keywords = array("sky","sea","dog","car","light","plane","computer","tree","world","house","animal","river","beer","usa","people");
	$keywordsnum = count($keywords);
	srand();
	$keyword = $keywords[rand(0, $keywordsnum-1)];
	$queryPrepare = "insert into pic(url) values(?)";
	$stmt = $db->prepare($queryPrepare);
	$stmt->bind_param("s",$time);
	$stmt->execute();

	$url = 'http://api.flickr.com/services/rest/'; // 请求的URL地址
	$params = '?method=flickr.photos.search' . // method指明Flickr API所提供的某个方法
 '&api_key=4a06195ccc70207ef0c1710ae6a4ae91' .  // Flickr分配的key
 '&text='.$keyword.'&per_page=11'; // 关键字
	//生成的URL
	//http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=2f59b5e190101271213d4b636e30824f&text=sea
	//如果把改URL黏贴到浏览器的地址栏里，同样可以得到XML文件
	$contents = file_get_contents($url . $params);
	$xml = new SimpleXMLElement($contents); // 解析XML文件
	$src;
	foreach ($xml->photos->photo as $value) {
		$src = 'http://farm' . $value['farm'] . ".static.flickr.com/" .
		$value['server'] . '/' . $value['id'] . '_' . $value['secret'] . '_m.jpg'; // _s用来控制显示图片的大小 reference:http://www.flickr.com/services/api/misc.urls.html
		$stmt->bind_param("s",$src);
		$stmt->execute();
		break;
		//echo "<img src=\"$src\" />";
	}
	$sql="select @@IDENTITY as id";
	$result = $db->query($sql);
	$picid = $result->fetch_array();
	return array( 'picid' => $picid['id'], 'url'=>$src);
}
function get_pic(  mysqli $link )
{
	srand();
	$r = rand(1,100);
	$result;
	if($r > 49){
		$result = get_pic_from_flickr($link);
	}
	else{
		$tableName='pic';
		$queryString = "SELECT picid, url FROM ".$tableName."
WHERE picid >= (SELECT floor(RAND() * (SELECT MAX(picid) FROM ".$tableName.")))  
ORDER BY picid LIMIT 1";

		$tempresult = $link->query($queryString);
		$pic = $tempresult->fetch_array();
		$result = array("url"=> $pic["url"],"picid"=>$pic["picid"]);
	}
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