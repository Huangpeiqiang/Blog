<?php 
	require './lib/init.php';
	//连接数据库
	$conn = mConn();
	//cat_id数据结构判定
	if(!is_numeric($_GET['cat_id'])) {
		exit('数据传输错误。');
	}
	//判断栏目下是否有文章
	$sql = 'select count(*) from art where cat_id=' . $_GET['cat_id'] . ';';
	$rs = mGetOne($sql);
	if($rs!=0){
		exit('栏目下存在文章不可删除');
	}
	//判断栏目是否存在
	$sql = 'select count(*) from cat where cat_id=' . $_GET['cat_id'] . ';';
	$rs = mGetOne($sql);
	if ($rs==0) {
		exit('栏目不存在');
	}

	$sql = 'delete from cat where cat_id = ' . $_GET['cat_id'] . ';';
	
	if (mQuery($sql)) {
		echo "删除成功";
	}else{
		echo mysql_error();
	}
?>