<meta charset="utf8">
<?php 
	require './lib/init.php';

	if (!acc()) {
		header('location:login.php');
		exit();
	}

	//插入页面
	if (empty($_POST)) {//判断有无内容插入
		include( ROOT . '/view/admin/catadd.html');
		exit();
	}else{
		$cat['catname'] = trim($_POST['catname']);//catname不可为空
		if (empty($cat['catname'])) {
			exit('栏目名不可为空');
		}
	}
	//连接数据库
	$conn = mConn();
	//验证栏目名称是否重复
	$sql = 'select catname from cat';
	$cat_name = mysql_query($sql,$conn);
	while(($res = mysql_fetch_row($cat_name))!==false){
		 if ($res[0] == $cat['catname']) {
		 	exit('栏目名重复');
		 }
	}

	$sql = 'insert into cat(catname) value(\'' . $cat['catname'] . '\');';
	if(mysql_query($sql,$conn)){
		succ('插入成功');
	}else{
		echo mysql_error();
	}

 ?>