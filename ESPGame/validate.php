<html>
	<body>
		<?php
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
		     header("Location:login.php");
		    }
		    $query = "select * from player";
		    mysql_select_db("esp");
		    $result=mysql_query($query);
		    while($rs = mysql_fetch_object($result)){
		    	if($rs->userid == $username){
		      		if($rs->passwd == $password){
		       			$_SESSION['USERNAME'] = $username;
		       			header("Location:success.php");
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