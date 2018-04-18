<?php
	include "conn.php";
	if(isset($_GET['id'])){
		//根据id做hits的更新
		$id=$_GET['id'];
		$sql="update blog set hits=hits+1 where bid='$id'";
		$query=mysqli_query($link,$sql);
		if($query){
			//再查找当前这一条
			$sql="select * from blog where bid='$id'";
			$query=mysqli_query($link,$sql);
			$rs=mysqli_fetch_array($query);
		}
		
	}

?>

<meta charset="utf-8">
<h3>标题:<?php echo $rs['title']?></h3>
<li>时间:<?php echo $rs['time']?></li>
<li>访问率:<?php echo $rs['hits']?></li>
<p><?php echo $rs['content']?></p>
<hr />





