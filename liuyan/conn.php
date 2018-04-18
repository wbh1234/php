<?php
//创建数据库连接
	$link=@mysqli_connect('localhost','root','') or die('打开连接失败');
	//连接数据库
	@mysqli_select_db($link,'newblog1') or die('选择数据库失败');
	//设置传输编码
	mysqli_set_charset($link,'UTF8');

?>