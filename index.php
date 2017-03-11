<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
<link rel="stylesheet" href="./background.css" />
<style>
	body{
		width: 300px;
		margin: 0 auto;

	}
	.button{
	position: relative;
	left: 70px;
	}
	h1{
		position: relative;
		left: -30px;
	}
</style>
</head>
    <body>

    	<h1>欢迎使用百度云盘!</h1><br /><br />
        <form action="login.php" method="post" id='denglu'onsubmit="return check()">
        	用户名:&nbsp;<input type="text" name='userId' value='admin' id='user'/><br /><br />
        	密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;<input type="password" name='password' id='passwords'/><br /><br />
        	<input type="button" name='logIn' value='注册' class ='button' id ='zhuce' onclick="location.href='http://localhost/zhuce.php'"/>
        	<input type="submit" class='button' id="submit" value='登录'/>
        </form>
    </body>
    <script>
      //var submit = document.getElementById('submit');
      function check(){
      	var name = document.getElementById('user').value;
      	var password = document.getElementById('passwords').value;
      	if(name==''||password==''){
      		alert('用户名或密码不能为空');
      		return false;
      	}
      	else{
      		return true;
      	}
      }
      



    </script>
</html>