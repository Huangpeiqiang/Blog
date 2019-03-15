<?php 
	require './lib/init.php';

	$aid = intval($_GET['art_id']);
	
	$conn = mConn();
	$sql = 'select cat_id from art where art_id = ' . $aid;
	$cid = mGetOne($sql);
	
	$sql = 'delete from art where art_id = ' . $aid;
	if (mQuery($sql)) {
		$sql = 'update cat set num=num-1 where cat_id='. $cid . ';';
		mQuery($sql);
		//跳回之前页面
		$ref = $_SERVER['HTTP_REFERER'];
 		header("Location: $ref");
	 } else{
	 	error(mysql_error());
	 }
 ?>