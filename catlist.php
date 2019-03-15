<meta charset="utf8">
<?php 
	require './lib/init.php';

	if (!acc()) {
		header('location:login.php');
		exit();
	}

	//连接数据库
	$conn = mConn();
	//查找数据，装入cat数组
	$sql = 'select * from cat';
	$res = mQuery($sql);
	while (($th = mysql_fetch_assoc($res))!==false) {
		$cat[]=$th;
	}

	//最后插入页面，使cat数组在HTML页面生效。
	include('./view/admin/catlist.html');
 ?>