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
		    	header("Location:register.php");
		    }
		    $query = "insert into player values('$username','$password','1',DEFAULT);";
		    echo $query."\n";
		    mysql_select_db("esp");
		    $result = mysql_query($query);
		    if (!$result)
		    {
		    	header("Location:register.php");
		    }
		    else 
		    {
		    	$_SESSION['USERNAME'] = $username;
		    	header("Location:success.php");
		    }
?>