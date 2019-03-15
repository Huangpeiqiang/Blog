<?php 
	require './lib/init.php';
	$conn = mConn();
	$sql = 'select * from cat;';
	$cat = mGetAll($sql);

	if( isset($_GET['cat_id']) ) {
		$where = 'and art.cat_id='.$_GET['cat_id'];
	} else {
		$where = '';
	}

	$sql = 'select count(*) from art where 1 '. $where;
	$sum = mGetOne($sql);//文章总数
	$cnt = 2;//每页显示文章数
	$ar = isset($_GET['page'])?$_GET['page']:1;//当前页面
	$page = getPage($sum,$cnt,$ar);

	$conn = mConn();
	$sql = 'select art_id,tag,art.cat_id,user_id,nick,pubtime,title,comm,content,cat.catname from art left join cat on art.cat_id=cat.cat_id where 1 '. $where .' order by art_id desc limit '.($ar-1)*$cnt.','.$cnt;
	$art = mGetAll($sql);

	require ROOT . '/view/front/index.html';
 ?>