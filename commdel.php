<?php 
	require './lib/init.php';
	$commid = $_GET['comment_id'];

	$conn = mConn();
	$sql = 'delete from comment where comment_id='.$commid;
	if (mQuery($sql)) {
		//评论数量-1
		$sql = 'select * from comm';
		$comm = mGetAll($sql);

		$sql = 'update art set comm=comm-1 where art_id='.$comm['art_id'];
		mQuery($sql);
		//跳回之前页面
		$ref = $_SERVER['HTTP_REFERER'];
 		header("Location: $ref");
	}else{
		error(mysql_error());
	}
 ?>