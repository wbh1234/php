<?php 
	include "conn.php";
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		
		//先查找id这一条
		$sql="select * from blog where bid='$id'";
		$query=mysqli_query($link,$sql);
		$rs=mysqli_fetch_array($query);
	}
	
	if(isset($_POST['sub'])){
		$title=$_POST['title'];
		$con=$_POST['con'];
		$bid=$_POST['hid'];
		//修改操作
		$sql="update blog set title='$title',content='$con' where bid='$bid'";
		
		//echo $sql;
		//die();
		
		$query=mysqli_query($link,$sql);
		if($query){
			//echo "success";
			header("location:index.php");
		}else{
			echo "error";
		}
	}
?>
<meta charset="utf-8">
<form action="update.php" method="post">
	<input type="hidden" name="hid" value="<?php echo $rs['bid']?>">
	标题:<input type="text" name="title" value="<?php echo $rs['title']?>"><br />
	内容:<textarea cols='30'  rows='10' name="con"><?php echo $rs['content']?></textarea><br />
	<input type="submit" name="sub" value="修改">
</form>