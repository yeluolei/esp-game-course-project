<html>
	<body>
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
		     echo "<script>location.href='login.php'</script>";
		    }
		    $query = "select * from player";
		    mysql_select_db("esp");
		    $result=mysql_query($query);
		    while($rs = mysql_fetch_object($result)){
		    	if($rs->userid == $username){
		      		if($rs->passwd == $password){
		       			$_SESSION['USERNAME'] = $username;
		       			echo "<script>location.href='success.php'</script>";
		      		}
		      		else{
		      			break;
		      		}
		    	}
		    }
		    echo "<CENTER><P><FONT SIZE='4' COLOR='RED'>用户名或密码输入有误，请重新输入！</FONT></P></CENTER>";
		?>
	</body>
</html>