<?php 
	//初始化
	require './lib/init.php';
	if (!acc()) {
		header('location:login.php');
		exit();
	}
	//数据库连接
	$conn = mConn();
	//查找cat,制作下拉菜单
	$sql = 'select * from cat';
	$cat = mGetAll($sql);

	if (empty($_POST)) {

		include(ROOT . '/view/admin/artadd.html');
	}else{
		if (($art['title'] = trim($_POST['title'])) == null) {
			error('文章名不可为空');
		}
		$art['content'] = trim($_POST['content']);
		$art['content'] = nl2br($art['content']);
		if ($art['content'] == null) {
			error('文章内容不可为空');
		}
		$art['cat_id'] = $_POST['cat_id'];
		if (!is_numeric($art['cat_id'])) {
			error('栏目出错');
		}

		$art['pubtime'] = time();

		if (!empty($_POST['tag'])) {
			$art['tag'] = $_POST['tag'];		
		}
		//图片添加
		$path = createDir();
		$ext = getExt($_FILES['pic']['name']);
		$rand = randStr();
		if (move_uploaded_file($_FILES['pic']['tmp_name'], '.'.$path.'/'.$rand.$ext)){
			$art['pic_path'] = '.'.$path.'/'.$rand.$ext;
			$art['thumb'] = mkThumb($art['pic_path'])?mkThumb($art['pic_path']):error('缩略图出错.');
		}

		//cat表下数量递增
		$sql = 'update cat set num=num+1 where cat_id='.$art['cat_id'].';';
		mQuery($sql);

		if (mExec($art,'art')) {
			succ('文章插入成功');
			header('location:artlist.php');
			exit();
		}else{
			error(mysql_error());
		}
	}
 ?>