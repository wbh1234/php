<?php
	//先连接数据库
	include "conn.php";
	if(isset($_POST['sub'])){
		$title=$_POST['title'];
		$con=$_POST['con'];
		//$date=date('Y-m-d');
		//echo $date;
		
		//操作数据库插入数据  
		//拼字符串
		$sql="insert into blog(bid,title,content,time) values(null,'$title','$con',now())";
		//发送这个字符串
		$query=mysqli_query($link,$sql);
		if($query){
			//echo "插入成功";
			header("location:index.php");
		}else{
			echo "插入失败";
		}
		
	}

?>

<meta charset="utf-8">
<form action="add.php" method="post">
	标题:<input type="text" name="title"><br />
	内容:<textarea cols='30'  rows='10' name="con"></textarea><br />
	<input type="submit" name="sub" value="发表1">
</form>