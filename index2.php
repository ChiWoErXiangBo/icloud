<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>银行家算法</title>
<link rel="shortcut icon" type="image/ico" href="bank.ico" />
<head>
</head>
<style>
a{
font-size:14px;
	color:gray;
}
input:focus{outline:none;}
#all{
	margin:50px auto;
	width:100%;
}
img{
 position:absolute;
 z-index:-1;
 top:0px;
 left:0px;
 width:100%;
}
#caozuo1{
	position:absolute;
	top:80px;
	left:17%;
	height:400px;
	width:62%;
	padding:2%;
	float:left;
	overflow:hidden;
	margin-left:50px;
	color:#fff;
	font-family:微软雅黑;
	background-image:url(./alphabg50.png);
	border-radius:10px;
}
#div_add,#div_apply,#div_delete,#div_look,#div_look_set{
	height:478px;
	overflow:auto;
	font-size:15px;
	padding:10px;
	border-radius:10px;
}
#div_add{
	margin-top:-2000px;
}

#butto{
	position:fixed;
	top:0px;
	left:-220px;
	width:220px;
	z-index:7;
	height:100%;
	background-image:url(./alphabg50.png);
	text-align:center;
}
.btn_tit{
	padding:20px 0px;
	color:#fff;
	font-size:24px;
	font-family:微软雅黑;
	margin-left:20px;
}
#butto input{
	width:180px;
	margin-left:20px;
	color:black;
	cursor:pointer;
	height:40px;
	border-radius:45px;
	margin-top:12px;
	font-family:微软雅黑;
	color:#fff;
	background:transparent;
}
#butto input:hover{
	background-image:url(./alphayellow50.png);
}
#work_queue_length_name_tai{
	color:red;
}
#delete_name_tai{
	color:red;
}
#apply_name_tai{
	color:red;
}
/*选择其id属性值以”tai“结尾的所有的<div>元素 IE9 之前不支持
*/
div [id^="work_queue_length_tai"]{
	color:red;
}
div [id^="apply_tai"]{
	color:red;
}
table td{
	width:120px;
	color:#fff;
	text-shadow:5px 5px 5px #000;
	text-align:center;
	font-size:15px;
}
input[type='button']{		/* 属性选择器 */
	width:100px;	
	color:#fff;
	background:transparent;
	border-radius:15px;
	height:30px;
	font-family:微软雅黑;
	border:1px solid #fff;
	cursor:pointer;
	
}
input[type='button']:hover{
	background-image:url(./alphayellow50.png);
}
input[type='text']{
	border-radius:15px;
	border:1px solid silver;
	outline:none;
	padding:3px 5px;
	color:#fff;
	background:transparent;
	margin-left:20px;
}
a{
	width:100px;
	border:1px solid #ccc;
	//background:orange;
	font-size:13px;
	background:transparent;
	color:#fff;
	text-decoration:none;
	padding:5px 25px;
	border-radius:15px;
}
a:hover{
	background-image:url(./alphayellow50.png);
}
/* 
#inn{
	color:red;
} */
body{}
.openbtn{
	position:fixed;
	bottom:20px;
	left:20px;
	width:40px;
	height:40px;
	z-index:8;
	cursor:pointer;
	border-radius:30px;
	background-image:url(btn.png);
}
</style>
<script src="jquery.js"></script>
<script>
var isopen=0;
$(document).ready(function(){
	$(".openbtn").click(function(){
		if(!isopen){
			$('#butto').animate({"left":"0px"},500).animate({"left":"-20px"},300);
			isopen++;
		}else{
			$('#butto').animate({"left":"0px"},300).animate({"left":"-220px"},500);
			isopen=0;
		}
	});
});
</script>
<script>
//数据区域
	var work_queue_length = 1;					//作业队列长度
	var resource_length = 1;		//资源个数 -1 9
	var resource_max = new Array();			//每个资源最大值
	
	var now_work_queue_length = 0;				//记录当前作业个数
	
	var available = new Array(resource_length);	//表示系统中现有资源	
	var max = new Array(work_queue_length);			//记录每个进程 对每类资源的最大需求
	var allocation = new Array(work_queue_length);	//记录每个进程 对每类资源已分配的数量
	var need = new Array(work_queue_length);			//记录每个进程 对每类资源还需的数量
	
	var name = new Array(work_queue_length);			//记录每个作业的名字
	var condition = new Array(resource_length);		//记录输入框的状态，，，
	
	var safe = new Array(work_queue_length);
	function initialization(){
		work_queue_length = document.getElementById("wo").innerHTML;
		
		resource_length = document.getElementById("re").innerHTML;
		start = resource_length.indexOf(":");			//找到"_"的位置
		resource_length = resource_length.substring(start+1,resource_length.length);	//获得编号
		resource_length = parseInt(resource_length) + 1;
		
		for(i=1;i<resource_length;i++){
		resource_max[i] = document.getElementById("res_"+i).innerHTML;
		
		start = resource_max[i].indexOf(":");				//找到"_"的位置
		resource_max[i] = resource_max[i].substring(start+1,resource_max[i].length);	//获得编号
	
		resource_max[i] = parseInt(resource_max[i]);
		
		
	}
		var start = work_queue_length.indexOf(":");						//找到"_"的位置
		work_queue_length = work_queue_length.substring(start+1,work_queue_length.length);			//获得编号
	work_queue_length = parseInt(work_queue_length);
		for(i = 0;i < work_queue_length;i++){
			max[i] = new Array(resource_length);
			allocation[i] = new Array(resource_length);
			need[i] = new Array(resource_length);

			for(j = 0;j < resource_length;j++ ){	//0位置用于存储  作业名字
				available[j] = resource_max[j];
				condition[j] = 0;
				
				max[i][j] = 0;
				allocation[i][j] = 0;
				need[i][j] = 0;
			}
		}
		condition[0] = -1;					//输入框名字
	}
		function set(){			//重置页面
//添加作业页面的初始化
		document.getElementById("work_queue_length_name").value = "";
		document.getElementById("work_queue_length_name_tai").innerHTML = "&nbsp;";
		for(i = 1;i < resource_length;i++){
			document.getElementById("apply_"+i).value = "";
			document.getElementById("work_queue_length_tai_"+i).innerHTML = "&nbsp;";	
			condition[i] = 0;			
		}
		condition[0] = -1;
//申请资源页面的初始化
		document.getElementById("apply_name").value = "";
		document.getElementById("apply_name_tai").innerHTML = "&nbsp;";
		for(i = 1;i < resource_length;i++){
			document.getElementById("resource_"+i).value = "";
			document.getElementById("apply_tai_"+i).innerHTML = "&nbsp;";			
		}
//撤销页面的初始化
		document.getElementById("delete_name").value = "";
		document.getElementById("delete_name_tai").innerHTML = "&nbsp;";
	}
	window.onload = function(){				//窗口载入执行
		initialization();					//初始化
		$("#work_queue_length_name").bind("input propertychange",function(){ //绑定事件
			check_work_queue_length_name($(this).val());
		});	
		$(".bu").bind("input propertychange",function(){ 	//绑定事件
			check_add($(this).attr("id"),$(this).val());
		});	
		$("#apply_name").bind("input propertychange",function(){ //绑定事件
			check_apply_name("apply",$(this).val());
		});
		$(".app").bind("input propertychange",function(){ //绑定事件
			if(condition[0] == -1){
				set();
				document.getElementById("apply_name_tai").innerHTML = "还未输入作业名";
			}else{
				check_apply($(this).attr("id"),$(this).val());
			}
			
		});	
		$("#delete_name").bind("input propertychange",function(){ //绑定事件
			check_apply_name("delete",$(this).val());
		});
	}
	function check_work_queue_length_name(val){
		if(val == ""){
			document.getElementById("work_queue_length_name_tai").innerHTML = "&nbsp;";	//输入框为空
			condition[0] = -1;
			return;
		}
		for(i =0;i<now_work_queue_length;i++){
			if(max[i][0] == val){
				document.getElementById("work_queue_length_name_tai").innerHTML = "该作业已存在！";
				condition[0] = -1;					//作业队列中找到该作业返回1
				return;
			}
		}
		document.getElementById("work_queue_length_name_tai").innerHTML = "&nbsp;";
		condition[0] = val;
	}
	function check_apply_name(name,val){		//申请资源 删除资源 时 作业名进行检查
		if(val == ""){
			document.getElementById(name+"_name_tai").innerHTML = "&nbsp;";	//输入框为空
			condition[0] = -1;
			return;
		}
		for(i =0;i<now_work_queue_length;i++){
			if(max[i][0] == val){
				document.getElementById(name+"_name_tai").innerHTML = "&nbsp;";
				condition[0] = i;					//作业队列中找到该作业返回1
				//alert(i);
				return;
			}
		}
		document.getElementById(name+"_name_tai").innerHTML = "该作业不存在！";
		condition[0] = -1;
	}
	function check_add(id,val){
		var start = id.indexOf("_");				//找到"_"的位置
		var id = id.substring(start+1,id.length);	//获得编号
		if(val == ""){
			document.getElementById("work_queue_length_tai_"+id).innerHTML = "&nbsp;";
			val = 0;
		}
		val = parseInt(val);
		var reg = /^\d{1,}$/;	//输入的为非负整数
		var d = reg.test(val);
		 if(d == false){
					document.getElementById("work_queue_length_tai_"+id).innerHTML = "请输入非负整数！";
					condition[id] = -1;
			}else{
			if(resource_max[id] < val){
				document.getElementById("work_queue_length_tai_"+id).innerHTML = "错误！所需"+id+"类资源大于银行家拥有的"+id+"类资源,银行家当前拥有"+id+"类资源"+(resource_max[id]);
				condition[id] = -1;
			}else{
				document.getElementById("work_queue_length_tai_"+id).innerHTML = "&nbsp;";
				condition[id] = val;
			}
		}
	}
	function check_apply(id,val){
		var start = id.indexOf("_");				//找到"_"的位置
		var id = id.substring(start+1,id.length);	//获得编号
		if(val == ""){
			document.getElementById("apply_tai_"+id).innerHTML = "&nbsp;";
			val = 0;
		}
		val = parseInt(val);
		var reg = /^\d{1,}$/;	//输入的为非负整数
		var d = reg.test(val);
		if(d == false){
				document.getElementById("apply_tai_"+id).innerHTML = "请输入非负整数！";
				condition[id] = -1;
			}else{
			if(need[condition[0]][id] < val){
				document.getElementById("apply_tai_"+id).innerHTML = "错误！所申请"+id+"类资源大于该作业所需的"+id+"类资源,该作业还需"+id+"类资源"+(need[condition[0]][id]);
				condition[id] = -1;
			}else{
				document.getElementById("apply_tai_"+id).innerHTML = "&nbsp;";
				condition[id] = val;
			}
		}
	}
	function check_condition(){			//检查输入框
		for(i =0;i<resource_length;i++){
			if(condition[i] == -1){
				return 1;
			}
		}
		return 0;
	}
	function add_ok(){
		if(now_work_queue_length < work_queue_length){
			if(check_condition()){
				alert("添加失败！");
			}else{
				for(i =0;i<resource_length;i++){
					max[now_work_queue_length][i] = condition[i];
					need[now_work_queue_length][i] = condition[i];
				}
				allocation[now_work_queue_length][0] = condition[0];
				now_work_queue_length++;
				set();
				alert("添加成功！");
			}
		}else{
			alert("作业队列已满！添加失败！");
		}
		
	}
	function apply_ok(){
		if(check_condition()){
			alert("填写错误！申请失败！");
		}else{
			var sec = security();
			if(sec == 1){
				for(i=1;i<resource_length;i++){
					condition[i] = parseInt(condition[i]);
			allocation[condition[0]][i] = allocation[condition[0]][i]+condition[i];
			need[condition[0]][i] = need[condition[0]][i] - condition[i];
			available[i] = available[i] - condition[i];
				}
				set();
				alert("申请成功！");
				document.getElementById("safe").innerHTML = "&nbsp;";
			}else{
				alert("本次资源申请会使系统进入不安全状态!!!资源申请失败!!!");
				var safe1 = "";
				for(i =0;i<now_work_queue_length;i++){
					safe1 =  safe1 +"->" + safe[i];
				}
				
				document.getElementById("safe").innerHTML = "提示安全序列为"+safe1;
			}
		}
	}
	function delete_ok(){
 		if(condition[0] == -1){
			alert("撤销失败！不存在该作业");
		}else{
			var i=condition[0];
			for(j=1;j<resource_length;j++){
				available[j] = available[j] + allocation[i][j];
			}
			while(allocation[i][0] != 0){
				for(j=0;j<resource_length;j++){
					allocation[i][j] = allocation[i+1][j];
					need[i][j] = need[i+1][j];
					max[i][j] = max[i+1][j];
				}
				i++;
			}
			now_work_queue_length--;
			set();
			alert("撤销成功!");
		}
	}
	var move1 = 0;
	function move(end){
		/* var mm = document.getElementById("div_add");		//当前位置
		if(mm.currentStyle){
			now =mm.currentStyle['marginTop'];	//IE
		}else{
			now = document.defaultView.getComputedStyle(mm,null)['marginTop'];
		}
		now = parseInt(now);
	
		clearInterval(move1);
		if(now < end){
			move1 = setInterval(function(){
			now = now + 5;
			document.getElementById("div_add").style.marginTop = now+"px";
			if(now > end){
					document.getElementById("div_add").style.marginTop = end+"px";
					clearInterval(move1);
				}
			},2);
		}else{
			move1 = setInterval(function(){
			now = now - 5;
			document.getElementById("div_add").style.marginTop = now+"px";
			if(now < end){
					document.getElementById("div_add").style.marginTop = end+"px";
					clearInterval(move1);
				}
			},2);
		} */
		document.getElementById("div_add").style.marginTop = end+"px";
	}
	function add(){
		set();
		move(0);
	}
	function apply(){
		set();
		move(-500);
	}
	function remove_work_queue_length(){
		set();
		move(-1000);
	}
	function look(){
		set();
		move(-1500);
		var html = "<table border='1' ><caption>查看资源状况</caption><tr><td colspan='3'style='font-size:15px;'>银行家所剩资源</td></tr><tr><td style='font-size:15px;'>资源名</td><td style='font-size:15px;'>可用资源</td><td style='font-size:15px;'>总共资源</td></tr>";
		for(i=1;i<resource_length;i++){
			html = html+ "<tr><td style='font-size:15px;'>" + i +"类资源：</td><td style='font-size:15px;'>" + available[i] + " </td><td style='font-size:15px;'> "+ resource_max[i] +"</td></tr>";
		}
		
		html = html + "</table><hr/><table border='1'><caption style='font-size:15px;'>作业占用情况</caption><tr><td style='font-size:15px;'>作业名</td><td style='font-size:15px;'>资源名</td><td style='font-size:15px;'>		已占用</td><td style='font-size:15px;'>还需要</td><td style='font-size:15px;'>共需要</td></tr>";
		for(i = 0;i < now_work_queue_length;i++){
		var nu =0;
			for(j=1;j<resource_length;j++){
				if(max[i][j] != 0)
				nu ++;
			}
		
			html = html+ "<tr ><td style='font-size:15px;' rowspan='"+ 2*(nu) +"'>"  + max[i][0] +"</td></tr>";
			
			for(j = 1;j < resource_length;j++){
				if(max[i][j] != 0){
				html = html+ "<tr><td style='font-size:15px;'>" + j + "类资源</td><td>"+ allocation[i][j] + "</td><td>"+need[i][j] + "</td><td>" + max[i][j] +"</td><tr/>";
				}
				
			}
		}
		html = html + "</table>";
		document.getElementById("div_look").innerHTML = html;
	}
	function look_set(){
		set();
		move(-2000);
	}
	function set_ok(){
		set();
		move(0);
	}
	function security(){		//安全性检查
		var work_queue_lengthing = new Array(resource_length);
		var allo_s = new Array(work_queue_length);
		var need_s = new Array(work_queue_length);
		for(i=0;i<work_queue_length;i++){
			 allo_s[i] = new Array(resource_length);
			 need_s[i] = new Array(resource_length);
			for(j=0;j<resource_length;j++){
				allo_s[i][j] = allocation[i][j];
				need_s[i][j] = need[i][j];
			}
		}
		for(i=1;i<resource_length;i++){
			work_queue_lengthing[i] = available[i];
		}		
		var finish = new Array(now_work_queue_length);
		for(i=0;i<now_work_queue_length;i++){
			finish[i] = false;
		}
		var count = 1;
		var k = 0;
		for(i=1;i<resource_length;i++){			//模拟分配
				condition[i] = parseInt(condition[i]);
				allo_s[condition[0]][i] = allo_s[condition[0]][i] + condition[i];
				need_s[condition[0]][i] = need_s[condition[0]][i] - condition[i];
				work_queue_lengthing[i] = work_queue_lengthing[i] - condition[i];
		}
		for(i=0;i<now_work_queue_length;i++){
			count = 1;
			for(j=1;j<resource_length;j++){
				if((finish[i] == false)&&(need_s[i][j] <= work_queue_lengthing[j])){
					count = count+1;
				}
			}
			if(count == resource_length){
				for(j=1;j<resource_length;j++){
					work_queue_lengthing[j] = work_queue_lengthing[j] + allo_s[i][j];
					finish[i] = true;
				}
				safe[k] = allo_s[i][0];//记录安全序列
				k++;
				i = -1;		//先循环后
			}
		}
		for(i=0;i<now_work_queue_length;i++){
			if(finish[i]==false)
			{
				return 0;
			}
		}
		return 1;
	}
	function out(){
		if(window.confirm("是否退出系统？")){;
			CloseWebPage();
		}		
	}
	function CloseWebPage(){
		if (navigator.userAgent.indexOf("MSIE") > 0) {
			if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
				window.opener = null;
				window.close();
			} else {
				window.open('', '_top');
				window.top.close();
			}
		}else if (navigator.userAgent.indexOf("Firefox") > 0) {
			window.location.href = 'about:blank ';
		}else{
		
		var opened=window.open('about:blank','_self');
		opened.opener=null;
		opened.close();
/* 			window.opener = null;
			window.open('', '_self', '');
			window.close(); */
		 }
}

function reboot(){
	if(window.confirm("是否重置系统？")){
		now_work_queue_length = 0;
		move(-2000);
		set();
		initialization();
	}	
}
</script>
<body>
<!-- If you add scripts before closing body tag, it will not prevent page
from rendering, thus making your website load faster -->
<script src="jsized.snow.min.js" type="text/javascript"></script>        
<script>
    /**
     * This function takes 2 arguments
     * First is the path to the directory with snowflake images
     * Second is the maximum number of snowflakes, please do not
     * set this number above 60 as it will impact the performance
     */
    createSnow('', 60);
</script>
<img src="1.jpg">
<embed style="position:absolute;top:10px;right:10px;z-index:5;" src="lover_ying.mp3" width=300 height=50 type=audio/mpeg loop="true" autostart="true">
<div id ="all">
	<div id="caozuo1">
		<div id="div_add">新加作业<br/>
			新 加 作 业 名	  <input type='text' class='na' id='work_queue_length_name'/><div id='work_queue_length_name_tai'></div>
	<?php
	error_reporting(0);
	
		$maxwork_queue_length = $_POST['maxwork_queue_length1'];
		
		$maxres = $_POST['maxRes1'];	//资源种类

		if($maxres == ""){
			$resource_length = 6;  //默认
		}else{
			$resource_length = $maxres+1;		//资源个数  个默认
		}	
		
			for($i=0;$i<$resource_length;$i++){
				$mm = "maxUse1_".$i;
				$maxuse[$i+1] = $_POST[$mm];   //每个资源的最大值
				if($maxuse[$i+1] == ""){
					$maxuse[$i+1] = 10;
				}
				//echo $maxuse[$i]."<br>";
			}
		
		
		if($maxwork_queue_length == ""){
			$maxwork_queue_length = 10;		//作业对列 默认
		}

		
		
		for($i = 1;$i < $resource_length;$i++){
			 echo "<div id='inn'>本作业所需".$i."类资源<input type='text' class='bu' id= 'resource_".$i."'   placeholder='0'  /><div id='work_queue_length_tai_".$i."'>&nbsp;</div></div>"; 
		 }
	?>	
		<input type='button' onClick='add_ok()' value='确定添加作业'/>
		<input type='button' onClick='set()' value='重置'/>
		</div>
		<div id = "div_apply">申请资源<br/>
			要申请资源的作业名<input type="text" id="apply_name" /><div id="apply_name_tai"></div>
			<?php	
			for($i = 1;$i < $resource_length;$i++){
				echo "<div id='inn'>该作业需要申请".$i."类资源的数量<input type='text' class='app'  id= 'apply_".$i."'placeholder='0' /><div id='apply_tai_".$i."'>&nbsp;</div></div>";
			}
			?>
			<input type='button' onClick='apply_ok()' value='确定申请资源'/>
			<input type='button' onClick='set()' value='重置'/><div id='safe'></div>
		</div>
		<div id="div_delete">
			撤销资源<br/>
			要撤销资源的作业名<input type="text" id="delete_name" /><div id ="delete_name_tai"></div><br/>	
			<input type='button' onClick='delete_ok()' value='确定撤销作业'>
			<div id="lis"></div>
		</div>
		<div id = "div_look">查看资源分配情况</div>	
		<div id = "div_look_set">当前设置为
	<?php
		echo "<div id='wo'>系统的最大接受作业数:".$maxwork_queue_length."</div><br/>";
		echo "<div id='re'>资源种类:".($resource_length-1)."</div><br/>";
		
		for($i=1;$i<$resource_length;$i++){
		
		echo "<div id='res_".$i."'>第".$i."类资源的最大值:".		$maxuse[$i]."</div><br/>";
		}
		
		
	?>
		<input type="button" onClick="set_ok()" value="确认" >
		<a href="set.php">重新设置</a>
		</div>
	</div>
	<div id="butto">
			<div class="btn_tit">银行家算法</div>
			<input type="button" onClick="add()" 	value="新加作业"><br>
			<input type="button" onClick="apply()" 	value="为作业申请资源"><br>
			<input type="button" onClick="remove_work_queue_length()" value="撤销作业"><br>
			<input type="button" onClick="look()" 	value="查看资源情况"><br>
			<input type="button" onClick="look_set()" 	value="查看设置"><br>
			<input type="button" onClick="reboot()"	value="重置系统"><br>
			<input type="button" onClick="out()"	value="退出系统"><br>
	</div>
	<div class="openbtn"></div>
</div>
</body>
</html>