<?php
			@set_magic_quotes_runtime(0);
			$conn = mysql_connect("127.0.0.1","root","1"); 
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
		    if(@get_magic_quotes_gpc()==0){
		    	$username=addslashes($username);
		    	$password=addslashes($password);
		    }
		    $username = str_replace("_","\_",$username);//转义掉”_”
		    $username = str_replace("%","\%",$username);//转义掉”%”
		    $password = str_replace("_","\_",$password);//转义掉”_”
			$password = str_replace("%","\%",$password);//转义掉”%”
		    $query = "insert into player values('$username','$password',DEFAULT,DEFAULT,DEFAULT);";
		    mysql_select_db("esp");
		    $result = mysql_query($query);
		    if (!$result)
		    {
		    	echo json_encode(array('succ'=>false,'msg'=>"User name is already exist!"));
		    }
		    else 
		    {
		    	$_SESSION['USERNAME'] = $username;
		    	echo json_encode(array('succ'=>true,'userid'=>$username));
		    }
?>