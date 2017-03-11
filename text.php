<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
<script src='./jquery-3.0.0.js'></script>
</head>
    <body>
    	<?php 
    	header('Content-Type: text/html; charset=utf-8');
       //echo $_POST['a'];
        ?>
    	<script>
    		window.onload=function(){
    		var c =2;
        $.ajax({
              url:'text2.php'
             ,type:'POST'
             ,dataType:'json'
             ,data:{a:c}
             ,success:function(result) { alert(result); }
             ,error:function(xhr){alert('动态页出错\n\n'+xhr.responseText);}
            });
}
        </script>
        
    </body>
</html>