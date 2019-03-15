<?php 
	require './lib/init.php';
	if (!acc()) {
		header('location:login.php');
		exit();
	}

	//连接数据库
	$conn = mConn();
	$sql = 'select * from comment';
	$comm = mGetAll($sql);

	include ROOT . '/view/admin/commlist.html';
 ?>