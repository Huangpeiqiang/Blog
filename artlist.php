<?php 
	require './lib/init.php';

	if (!acc()) {
		header('location:login.php');
		exit();
	}

	$conn = mConn();

	//设置页码
	$sql = 'select count(*) from art';
	$sum = mGetOne($sql);
	$cnt = 5;
	$at = isset($_GET['page'])?$_GET['page']:1;
	$page = getPage($sum,$cnt,$at);

	$sql = 'select art.*,cat.catname from art left join cat on art.cat_id=cat.cat_id order by art_id limit '.($at-1)*$cnt.','.$cnt.';';
	$art = mGetAll($sql);

	include ROOT . '/view/admin/artlist.html';
 ?>