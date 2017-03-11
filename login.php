<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
<link rel="stylesheet" href="./background.css" />
</head>
    <body>
        
        <input type="hidden" name='password' value='$password' />
    	<?php 
    	/****
    	布尔教育 高端PHP培训
    	培  训: http://www.itbool.com
    	论  坛: http://www.zixue.it
    	****/
    	
    	$userId = $_POST['userId'];
    	$password = $_POST['password'];
        require("gongyong.php");
         $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting"); 
        mysql_query("set names 'utf8'"); 
        mysql_select_db($mysql_database) or die('Can\'t use foo : ' . mysql_error());    
        $sql1="SELECT  `adminpassword` FROM `admininformation` where `adminname`='$userId'";
        $result = mysql_query($sql1);
        $row = mysql_fetch_row($result);
        if($password==$row[0]){
            echo "登录成功";
            header('Refresh:2;http://localhost/01.php?dir='.$userId);
        }
        else{
            echo "登录失败，用户名或密码错误";
            echo "<form action='index.php' method='post' name='forms' id='forms'></form>";
        }

    	
    	?>
  
    </body>
    <script>
 
        function a(){
            document.forms.submit();
        }
                setTimeout(a,3000);
    </script>
</html>