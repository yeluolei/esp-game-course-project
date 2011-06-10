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
		     echo "<script>location.href='register.php'</script>";
		    }
		    $query = "insert into player values('$username','$password','1');";
		    echo $query."\n";
		    mysql_select_db("esp");
		    $result = mysql_query($query);
		    if (!$result)
		    {
		    	echo "<script>location.href='register.php'</script>";
		    }
		    else 
		    {
		    	$_SESSION['USERNAME'] = $username;
		    	echo "<script>location.href='success.php'</script>";
		    }
?>