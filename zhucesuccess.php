
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
</head>
    <body>
    	<form action="index.php" id='forms' name='forms'>
    	</form>
    	<?php 
    	$userId = $_POST['userId'];
    	$password = $_POST['password'];
    	$pathcloud ='E:/cloud/files/'.$userId.'/';
        $pathlocal = 'E:/bendi/';
        require("gongyong.php");
         $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting"); 
        mysql_query("set names 'utf8'"); 
        mysql_select_db($mysql_database) or die('Can\'t use foo : ' . mysql_error());    
        $sql1="SELECT  `adminname` FROM `admininformation` where 1";
        $result = mysql_query($sql1);
        while($row = mysql_fetch_row($result)){
          if ($userId == $row[0]){
          	$a =1;
          }
}
         if(isset($a)){
          echo "注册失败，用户名已存在！";
         }
        if($password!=''&&$userId!=''&&isset($a)==false){
        $sql = "INSERT INTO `admininformation`(`adminid`, `adminname`, `adminpassword`, `cloudaddress`, `localaddress`) VALUES (null,'$userId','$password','$pathcloud','$pathlocal')";
        mysql_query($sql);       
        mysql_close(); //关闭MySQL连接
        $b = mkdir('E:/cloud/files/'.$userId);
        if($b!=false){
       echo '注册成功！正在返回主页';
       }
       else{
        echo "创建失败！";
       }
        }      
  ?>
    	<script>
      function a(){
        document.forms.submit();
      }
          setTimeout(a,3000);
        </script>
    </body>
</html>