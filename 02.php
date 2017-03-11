<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="布尔教育 http://www.itbool.com" />
<link rel="stylesheet" href="./background.css" />
</head>
  <body>
  	<?php 

  	$userId = $_POST['userid'];
  	echo $userId;
  	header('Refresh:2;http://localhost/01.php?dir='.$userId);
  	//echo $userId;
       echo '<form action="01.php" method="post">',
    		'下载成功',
    		"<input type='hidden' name='id' value='",$userId,"'/>",
    		'<input type="submit" value="点击返回"/>';
    
    header("Content-Type:text/html;charset=utf-8"); 
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
	        @copy($source.'/'.$file,$target.'/'.$file);    //拷贝文件到目标地址
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
	 
    $pathcloud=$_POST['pathcloud'];
    echo $pathcloud;
    $pathfrom =$_POST['pathbendi'];
    //$pathfrom2 =$_POST['pathbendi2'];
    $pathfrom1 ='E:/bendi/'.$pathfrom;
    //echo $pathcloud;
    echo $pathfrom1;
    if(is_dir($pathcloud)){
    MoveFolderFiles($pathcloud,$pathfrom1);
    }
    else{
    	 copy($pathcloud,$pathfrom1);
    }


    ?>
    </body>
</html>


