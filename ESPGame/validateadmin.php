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
	    	exit();
	    }
	    else{
	    	$query = "select * from admin";
		    mysql_select_db("esp");
		    $result=mysql_query($query);
		    $succful = FALSE;
		    while($rs = mysql_fetch_object($result)){
		    	if($rs->userid == $username){
		      		if($rs->passwd == $password){
		      			$succful = TRUE;
		       			$_SESSION['USERNAME'] = $username;
		       			echo json_encode(array('succ'=>true , 'userid'=>$username));
		       			exit();
		      		}
		      		else{
		      			echo json_encode(array('succ'=>false, 'msg'=>"Password Error"));
		      			exit();
		      		}
		    	}
		    }
		    if (!$succful)
		    {
		    	echo json_encode(array('succ'=>false, 'msg'=>"User Name not exit"));
		    }
	    }
?>