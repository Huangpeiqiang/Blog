<?php 
	//设置初始位置
	define('ROOT', dirname(__DIR__));
	date_default_timezone_set("Asia/Shanghai");
	//引入数据库函数
	require(ROOT . '/lib/mysql.php');
	require(ROOT . '/lib/func.php');

	$_POST = _addslashes($_POST);
	$_GET = _addslashes($_GET);
	$_COOKIE = _addslashes($_COOKIE);
 ?>