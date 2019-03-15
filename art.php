<?php 
	require './lib/init.php';
	$aid = intval($_GET['art_id']);
	//数据库连接
	$conn = mConn();
	//建立article表
	$sql = 'select art.*,cat.catname from art left join cat on art.cat_id=cat.cat_id where art_id = ' . $aid .';';
	$art = mGetRow($sql);
	if (empty($art)) {
		header('Location:index.php');
		exit();
	}
	//建立cat表
	$sql = 'select * from cat;';
	$cat = mGetAll($sql);
	//建立comment表
	$sql = 'select * from comment where art_id = ' . $aid . ';';
	$comment = mGetAll($sql);

	include ROOT . '/view/front/art.html'; 
 ?>