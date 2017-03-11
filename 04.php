	<?php 
        header("Content-Type:text/html;charset=utf-8");
    	$sender = $_POST['sender'];
    	$target = $_POST['target'];
    	$file = $_POST['file'];
        require("gongyong.php");
         $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting"); 
        mysql_query("set names 'utf8'"); 
        mysql_select_db($mysql_database) or die('Can\'t use foo : ' . mysql_error());
        //$sql="SELECT `adminname` FROM `admininformation` WHERE 1";
        //$result = mysql_query($sql);
        //while($row = mysql_fetch_row($result)){
        //if ($target==$row[0]) {
           // echo "没有这个用户";
       // }
   // }
        
    
        
    	//$target = $_POST['target'];
    	//$file = $_POST['file'];

       echo '文件',$file,'已向用户',$target,'发送';
    	//echo "E:/cloud/files/admin20/textBenefits.gif";
    	//echo $sender;
    	//echo $target;    
        $sql1="UPDATE `fileinformation` SET `receiver`='$target' where `path`='$file'";
        $result1 = mysql_query($sql1);
        //row = mysql_fetch_row($result);
        //echo $row;
    	?>
 