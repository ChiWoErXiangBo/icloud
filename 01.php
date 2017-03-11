<?php 
/*打开并显示文件列表*/
header("Content-Type:text/html;charset=utf-8");
error_reporting(E_ALL & ~E_NOTICE) ;
echo $_POST['selectdata'];
$userid = $_GET['dir'];
//echo $userid;
 define(consist, $userId);
$path="./files".'/'.consist;

$url=$_SERVER['REQUEST_URI'];
if(isset($_GET['dir'])){
	//$Path = $_GET['dir'];
	$path = $path.'/'.$_GET['dir'];
	//$Path = ltrim($Path, "/");
	//$Path = ltrim($Path, ".");
	//$Path = ltrim($Path, "/");

}
else{
 $url = $url."?dir=./";
}
$dh = opendir($path);
if($dh==false){
	echo "打开出错了";
	exit;

}
$list = array();
while ( ($item=readdir($dh))!= false ) {
	# code...
	$list[] = $item;
}
//print_r($list);exit;
closedir($dh);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
<link rel="stylesheet" href="./background.css" />
<script src='./jquery-3.0.0.js'></script>
</head>
<style>
	td{
		border: 1px solid grey;
	}
    #container{
        width:1200px; 
        margin: 0 auto;
    }
	#list{
		width:600px; 
        margin: 0 auto;
	}
	#option{
        width:700px; 
        margin: 0 auto;
		
		
		font-size: 30px;

	}
    #gongxianglist{
        width:600px; 
        margin: 0 auto;
    }
</style>
    <body>
        <div id='container'>
    	 <div id="option">


            <?php
            
            $userid2 = $_GET['dir'];
            echo $userid2; 
            //$userId = $_POST['id'];
            //define(consist, $userId);
            echo "<form action='success.php' method='post' enctype='multipart/form-data' >
            <span style='font-size:25px'>请选择要上传的文件&nbsp;&nbsp;&nbsp</span>
            <input type='file' value='浏览' name='path' id='File'/>",
            '<input type="hidden" value="',$userid2,'" name="id"/>',
            '<input type="submit" value="上传至云"/>',
            '</form>';
            echo '<form action="success.php" method="post" enctype="multipart/form-data" >',
            '<span style="font-size:25px">请选择要上传的文件夹</span>
            <input type="text" value="E:/bendi/images" name="path2" id="File2"/>',
            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
            '<input type="hidden" value="',$userid2,'" name="id2"/>',
            '<input type="submit" value="上传至云"/>',
            '</form>'; 

    
     //}
    	
        
       // }


    echo '</div>
    <div id="list">
    	<h1 style="text-align:center;">云端文件列表</h1>
    	<table>
    		<tr>
    			<td>序号</td>
    			<td>文件名</td>
    			<td>操作</td>
    			<td>操作</td>
    			<td>操作</td>
                <td>操作</td>
    		</tr>';
    		header("Content-Type:text/html;charset=utf-8");
    		foreach ($list as $k => $v) {
    			# code...
    		echo "<tr>";
    		echo "<td>",$k,"</td>";
    		echo "<td>",$v,"</td>";
    		echo "<td>";
            //$pathlatter = $path.'/'.consist;
            //echo $path;
    		if(is_dir($path.'./'.$v)){
    			echo '<a href="',$url,'/',$v,'">浏览</a>';
    		}
    		else{
    		echo '<a href="./files/',$_GET['dir'],'/',$v,'">查看</a>';
    	}
    		echo "</td>";

    		echo "<td>";
            $string = $_GET['dir'].'/'.$v;
            $string = ltrim($string, ".");
            $string = ltrim($string, "/");
            $String = 'E:/cloud/files/'.$string;
            //echo $String;

            echo '<form action="03.php" method="post">',
            '<input type = "hidden" name="pathbendi" value =','"E:/rubbish/',$v,'">',
            '<input type = "hidden" name="userid" value =','"',$userid,'">',
            '<input type = "hidden" name="pathcloud" value =','"',$String,'">',
            '<input type = "submit" value="删除"> ','</form>';
            echo "</td>";
    		
    		echo "<td>";
    		$string = $_GET['dir'].'/'.$v;
    		$string = ltrim($string, ".");
    		$string = ltrim($string, "/");
    		$String = 'E:/cloud/files/'.$string;
            $Strings = 'files/'.$string;
            echo $String;
            $local = $_POST['local'];
            //echo $local;
            //echo $String;
            //if($local=''){
                //$local = 'E:/bendi/';
           // }
            //$haha = $_COOKIE['change'];
            //echo $haha;
            //echo $userId;
    		echo '<form action="02.php" method="post" name = "forms" id="forms"> ',
    		'<input type = "hidden" name="pathbendi" value =','"',$local,$v,'">',
            '<input type = "hidden" name="userid" value =','"',$userid,'">',
            '<input type = "submit" value="下载" name="download" > ',
            //'<input type = "hidden" name="pathbendi2" id="special" value =','"',$haha,'">',
    		'<input type = "hidden" name="pathcloud" value =','"',$String,'">'
    		,'</form>';
    		echo "</td>";
            echo "<td>";
            echo '<form action="04.php" method="post" id="share" >',
            '<input type = "text" name="target" value =','"admin5">',
            '<input type = "hidden" name="sender" value =','"',$userid,'">',
            '<input type = "hidden" name="file" value =','"',$Strings,'">',
            '<input type = "submit" value="分享"name="hh" class="h" id="fenxiang"> ','</form>';
    		echo "</td>";
    		echo "</tr>";
            
    
    		}
    		?>
    	</table>	
     </div>
     <?php 
     error_reporting(E_ALL ^ E_DEPRECATED) ;
        require("gongyong.php");
         $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting"); 
        mysql_query("set names 'utf8'"); 
        //echo $userid;
        mysql_select_db($mysql_database) or die('Can\'t use foo : ' . mysql_error());    
        $sql1="SELECT * FROM `fileinformation` WHERE `receiver` ='$userid'";
        $result = mysql_query($sql1);
        
      echo "<div id='gongxianglist'>
         <table>
            <h1 style='text-align:center;'>共享文件列表</h1>
            <tr>
                <td style='line-height:20px;'>文&nbsp;&nbsp;件&nbsp;&nbsp;名</td>
                <td>发&nbsp;&nbsp;送&nbsp;&nbsp;者</td>
                <td>操&nbsp;&nbsp;&nbsp;作</td>
                <td>操&nbsp;&nbsp;&nbsp;作</td>
            </tr>
            ";
            
       while($row = mysql_fetch_row($result)){
        echo "<tr>";
          echo "<td>",$row[1],"</td>";
          echo "<td>",$row[2],"</td>";
          echo "<td>","<a href='",$row[3],"'>","浏览","</a>","</td>";
          echo '<td>','<form action="02.php" method="post" name = "forms" id="forms"> ',
            '<input type = "hidden" name="pathbendi" value =','"',$row[1],'">',
            '<input type = "hidden" name="userid" value =','"',$userid,'">',
            '<input type = "submit" value="下载" name="download" > ',
            //'<input type = "hidden" name="pathbendi2" id="special" value =','"',$haha,'">',
            '<input type = "hidden" name="pathcloud" value =','"',$row[3],'">'
            ,'</form>','</td>';
            echo "</tr>";
       }
          
        

        echo "</table>";
        echo "</div>";
     ?>
    
     </div>
    </div>
   
    </body>
     
</html>