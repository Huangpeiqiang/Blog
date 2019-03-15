<?php 
	require './lib/init.php';
	$art_id = $_GET['art_id'];

	if (!acc()) {
		header('location:login.php');
		exit();
	}

	$conn = mConn();
	$sql = 'select art.*,cat.catname from art left join cat on art.cat_id = cat.cat_id where art_id = ' . $art_id .';';
	$art = mGetRow($sql);
	$sql = 'select * from cat';
	$cat = mGetAll($sql);

	if (empty($_POST)) {
		include ROOT . '/view/admin/artedit.html';
	}else{
		//检测cat_id是否数字
		$article['cat_id'] = $_POST['cat_id'];
		if (!is_numeric($art['cat_id'])) {
			error('栏目ID出错');
		}
		//判断title是否为空
		$article['title'] = $_POST['title'];
		if (empty($art['title'])) {
			error('栏目名为空');
		}
		//判断内容是否为空
		$article['content'] = $_POST['content'];
		$article['content'] = nl2br($article['content']);
		if (empty($article['content'])) {
			error('内容为空');
		}
		//查询是否存在文章
		$sql = 'select count(*) from art where art_id = ' . $art_id . ';';
		$res = mGetOne($sql);
		if ($res==0) {
			error('无文章');
		}
		
		$article['lastup'] = time();
		if (mExec($article,'art','update', 'art_id = ' . $art_id)) {
			succ('成功修改');
		}else{
			error(mysql_error());
		}
	}
 ?>