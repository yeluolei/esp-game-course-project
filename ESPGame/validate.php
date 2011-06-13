<?php
		@set_magic_quotes_runtime(0);
		include_once 'common/common.php';
		$conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd); 
		if (!$conn)
		{
			die("Connecttion to data failed:".mysql_error());
		}
		session_start();
		$username = $_POST['userid'];
	    $password = $_POST['passwd'];
	    if($username == "" || $password == ""){
	     	echo json_encode(array('succ'=>false,'msg'=>"User name and passwowd can't be empty!"));
	    }
	    else {
	    	if(@get_magic_quotes_gpc()==0){
		    	$username=addslashes($username);
		    	$password=addslashes($password);
		    }
		    $username = str_replace("_","\_",$username);//转义掉”_”
		    $username = str_replace("%","\%",$username);//转义掉”%”
		    $password = str_replace("_","\_",$password);//转义掉”_”
			$password = str_replace("%","\%",$password);//转义掉”%”
		    $query = "select * from player";
		    mysql_select_db("esp");
		    $result=mysql_query($query);
		    $succful = FALSE;
		    while($rs = mysql_fetch_object($result)){
		    	if($rs->userid == $username){
		      		if($rs->passwd == $password){
		      			$succful = TRUE;
		       			$_SESSION['USERNAME'] = $username;
		       			echo json_encode(array('succ'=>true , 'userid'=>$username));
		      		}
		      		else{
		      			echo json_encode(array('succ'=>false, 'msg'=>"Password Error"));
		      		}
		    	}
		    }
		    if (!$succful)
		    {
		    	echo json_encode(array('succ'=>false, 'msg'=>"User Name not exit"));
		    }
	    }
?>