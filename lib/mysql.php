<meta charset="utf8">
<?php 
/**
* mysql.php mysql操作的系列函数
* @author Baibai
*/
/**
* 连接数据库
* @return resource 成功返回一个资源
*/

function mConn()
{
	//静态变量使得 mConn在同一个页面 数据库值只连接一次
	static $conn = null;
	$cfg = include(ROOT . '/lib/config.php');
	if ($conn == null) {
		$conn = mysql_connect($cfg['host'],$cfg['user'],$cfg['password']);
		mysql_query('set name '.$cfg['charset'],$conn);
		mysql_query('use '.$cfg['db'],$conn);
	}
	return $conn;
}

/**
* 执行sql语句
*
* @param string $sql
* @return mixed 返回布尔型值/数组
*/
function mQuery($sql)
{
	return mysql_query($sql,mConn());
}

/**
* 查询select语句并返回多行,适用于查多条数据
* @param string $sql select语句
* @return mixed array 查询到返回二维数组,未查到返回false
*/
function mGetAll($sql)
{
	$row = null;
	$res = mQuery($sql);
	if (!$res) {
		echo mysql_error();
		exit();
	}else{
		while (($rs = mysql_fetch_assoc($res))!=false) {
			$row[] = $rs;
		}
	}
	return $row;
}

/**
* 查询select语句并返回一行
* @param string $sql select语句
* @return mixed array 查询到返回一维数组,未查到返回false
*/
function mGetRow($sql) {
	$rs = mQuery($sql);
	return $rs?mysql_fetch_assoc($rs):false;
}

/**
* 查询select语句并返回一个单元
* @param string $sql select语句
* @return mixed string 返回1个标量值未查到返回false
*/
function mGetOne($sql) {
	$rs = mQuery($sql);
	if($rs){
		$row = mysql_fetch_row($rs);
		return $row[0];
	} else {
		return false;
	}
}

/**
* 拼接sql语句并发送查询
* @param array $data 要插入或更改的数据,键代表列名,值为新值
* @param string $table 待插入的表名
* @param string $act 插入还是更新 默认为insert
* @param string $where 防止update语句更改忘记加where 改了所有的值
*/
function mExec($data,$table,$act='insert',$where='0'){
	if ($act == 'insert') {
		$sql = 'insert into ' . $table . '(';
		$sql .= implode(',', array_keys($data)) . ") values ('";
		$sql .= implode("','",array_values($data)) . "')";
		return mQuery($sql);	
	}else if ($act == 'update') {
		$sql = 'update '.$table.' set ';
		foreach ($data as $k => $v) {
			$sql .= $k . '=\'' . $v . '\',';
		}
		$sql = rtrim($sql , ',');
		$sql .= ' where '. $where . ';';
		return mQuery($sql);
	}
}

/**
* 返回最近的一次insert产生的主键值
* @return int
*/
function getLastId() {
	return mysql_insert_id(mConn());
}

/**
* 生成水印图片
* @package 未完成
*/
/*function getWaterPic($big,$small,$pic_path)
{
	$b = imagecreatefromjpeg($big);
	$s = imagecreatefromjpeg($small);

	list($bw,$bh) = getimagesize($big);
	list($sw,$sh) = getimagesize($small);

	imagecopymerge($b, $s, $bw-$sw, $bh-$sh, 0, 0, $sw, $sh, 40);

	imagepng($b,$pic_path);

	imagedestroy($b);
	imagedestroy($s);
}*/

 ?>