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
	left: 160px;
	}
	h1{
		position: relative;
		left: 50px;
	}
</style>
</head>
    <body>
    	<h1>请注册</h1><br /><br />
        <form action="zhucesuccess.php" method="post" id='zhuce' onsubmit="return check();">
        	用&nbsp;户&nbsp;名:&nbsp;<input type="text" name='userId' value='admin' id='user'/><br /><br />
        	密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;<input type="text" name='password' id='passwords'/><br /><br />
        	确认密码:&nbsp;<input type="text" name='password' id='passwords2'/><br />
        	<br />
        	<input type="submit" class='button'value='注册'/>
        </form>
    </body>
    
    <script>
   
    function check(){
         var passwords2 = document.getElementById('passwords2').value;
        var passwords = document.getElementById('passwords').value;
        var user = document.getElementById('user').value;
        if(passwords2==''||passwords==''||user==''){
            alert('请将信息填写完整！');
            return false;
        }
        else{
    	if(passwords2==passwords){
    		return true;

    	}
    	else{
    		alert('请重新输入，因为密码不一致');
    		return false;
    		
    	}
        }


    }

    </script>
</html>