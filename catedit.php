<meta charset="utf8">
<?php 
	require './lib/mysql.php';

	if (!acc()) {
		header('location:login.php');
		exit();
	}

	//连接数据库
	$conn = mConn();
	//cat_id仅可为数字
	if(!is_numeric($_GET['cat_id'])) {
		exit('数据传输错误。');
	}
	//判断栏目是否存在
	$sql = 'select count(*) from cat where cat_id=' . $_GET['cat_id'] . ';';
	$res = mGetOne($sql);
	if ($res==0) {
		exit('栏目不存在');
	}
	if (empty($_POST)) {
		$sql = 'select catname from cat where cat_id=' . $_GET['cat_id'] . ';';
		$rs = mGetOne($sql);
		$catname = $rs;
 		include('./view/admin/catedit.html');
	}else{
		if ( mExec($_POST,'cat','update','cat_id =' . $_GET['cat_id'])) {
			echo "修改成功";
		}else{
			echo mysql_error();
		}
	}
 ?>