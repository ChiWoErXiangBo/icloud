<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
</head>
    <body>
    	<?php 
    	error_reporting(E_ALL & ~E_NOTICE) ;
    	echo "成功！";
    	header("Content-Type:text/html;charset=utf-8");
    

        function replace_separator($path){
            $path=str_replace(DIRECTORY_SEPARATOR, '/', $path);
            return $path;
            } 


/*
函数作用：移动目录下所有文件和子目录到指定的路径下
函数参数：
    @param    string $source 需要移动文件的目录，例如:/user/local/bm001
    @param    string $target 文件移动的目标路径，例如/user/local
*/
	function MoveFolderFiles($source,$target){
	    /*检查要移动的额目录是否存在*/
	    if(!file_exists($source))return false;
	    /*检查移动后的存储目录是否存在*/
	    if(!file_exists($target))@mkdir($target);
	    /*打开目录并获取文件*/
	    $dir        =@opendir($source);
	    $files        =array();    //用来存储目录下的文件
	    $dirs        =array();    //用来存储目录下的子目录
	    if(false!=$dir){
	        while($item    =readdir($dir)){
	            $itemPath    =$source.'/'.$item;
	            if($item!='.'&&$item!='..'){
	                if(filetype($itemPath)=='file'){
	                    $files[]    =$item;
	                }elseif(filetype($itemPath)=='dir'){
	                    $dirs[]        =$item;
	                }
	            }
	        }
	        @closedir($dir);
	    }
	    /*复制文件到目标地址*/
	    foreach($files as $file){
	        @copy($source.'/'.$file,$target.'/'.$file);
            //echo $source.'/'.$file; 
            //echo $target.'/'.$file;  
            //拷贝文件到目标地址
	        //@unlink($source.'/'.$file);                    //删除原始文件
	    }
	     
	    /*递归处理子目录*/
	    if(sizeof($dirs)>0){
	        foreach($dirs  as $childDir){
	            MoveFolderFiles($source.'/'.$childDir,$target.'/'.$childDir);
	        }
	    }
	    //删除当前目录
	    @rmdir($source);
	}
    
	 
    
    $pathfrom = $_POST['path'];
    $pathfurther = $_POST['id'];
    $pathfrom2 = $_POST['path2'];
    $pathfurther2 = $_POST['id2'];
    //echo $pathfurther2;

    //$pathfrom = replace_separator($pathfrom);
    //echo $pathfrom;
    //$pathfrom1 = explode('/', $_FILES["path"]['tmp_name']);
    //$pathfrom2 = $pathfrom1[sizeof($pathfrom1)-1];
    $pathto = 'E:/cloud/files/'.$pathfurther.'/'.$_FILES["path"]['name'];
    echo $pathto;

    //可以作为path  $_FILES["path"]['name']可以作为filename
    $fileName = $_FILES["path"]['name'];
    $p = $_FILES["path"]['tmp_name'];
    $p1 = replace_separator($p);
    $pa = explode('/', $pathfrom2);
    $pathto3 = $pa[sizeof($pa)-1];
    //$pathto2 = $pathto1.$_FILES["path2"]['name'];
    $pathTo = 'E:/cloud/files/'.$pathfurther2.'/'.$pathto3;
    
    //$pathto4 = $pathto2.$pathto3;
     //echo  $pathto;
     //echo $pathTo;

     //if($pathto1!=$pathto){
            MoveFolderFiles($pathfrom2,$pathTo);
            $flag = explode('/', $pathto);
            $Flag = $flag[sizeof($flag)-1];
            echo $Flag;
                if($Flag!=""){
                 copy($p1,$pathto);
             }
        if(id!=''){
    	header('Refresh:3;http://localhost/01.php?dir='.$pathfurther);
    }
        else{
            header('Refresh:3;http://localhost/01.php?dir='.$pathfurther2);
        }
    	
    	require("gongyong.php");
         $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting"); 
        mysql_query("set names 'utf8'"); 
        mysql_select_db($mysql_database) or die('Can\'t use foo : ' . mysql_error());
        $pathtos = 'files/'.$pathfurther.'/'.$_FILES["path"]['name'];    
        $sql1="INSERT INTO `fileinformation`(`adminid`, `filename`, `user`, `path`, `receiver`) VALUES (null,'$fileName','$pathfurther','$pathtos',null)";
        $result = mysql_query($sql1);
        $row = mysql_fetch_row($result);
    	?>
    </body>
</html>