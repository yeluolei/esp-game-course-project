<?php
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
		    $query = "insert into player values('$username','$password',DEFAULT,DEFAULT);";
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