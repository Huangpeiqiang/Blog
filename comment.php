<?php 
	require './lib/init.php';

	if (!acc()) {
		header('location:login.php');
		exit();
	}
	
	//数据库连接
	$conn = mConn();
	$sql = 'select * from art';
	$art = mGetAll($sql);

	if (empty($_POST)) {
		include ROOT . '/view/front/art.html';
	}else{
		$comm['art_id'] = $_GET['art_id'];
		if (!is_numeric($comm['art_id'])) {
			error('ID必须是数字');
		}
		//匿名设置
		$comm['nick'] = $_POST['username'];
		if (empty($comm['nick'])) {
			$comm['nick'] = '匿名';
		}
		//Email不可为空
		$comm['email'] = $_POST['email'];
		if (empty($comm['email'])) {
			 error('Email不可为空');
		}
		//内容不可为空
		$comm['content'] = $_POST['comment'];
		if (empty($comm['content'])) {
			 error('内容不可为空');
		}
		//设置时间
		$comm['pubtime'] = time();
		//获取IP
		$comm['ip'] = sprintf(ip2long(getRealIp()));

		if (mExec($comm,'comment')) {
			$sql = 'update art set comm=comm+1 where art_id='.$comm['art_id'].';';
			mQuery($sql);
			succ('插入成功');
		}else{
			error(mysql_error());
		}
	}
 ?>