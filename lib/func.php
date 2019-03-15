<?php 
function succ($msg = '成功')
{
	$res = 'succ';
	include(ROOT . '/view/admin/info.html');
}

function error($msg = '失败')
{
	$res = 'fail';
	include(ROOT . '/view/admin/info.html');
	exit();
}

/**
* 获取IP
*/
function getRealIp(){
	static $realip = null;
	if (getenv('HTTP_X_FORWARDED_FOR')) {
		$realip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_CLIENT_IP')) {
		$realip = getenv('HTTP_CLIENT_IP');
	} else {
		$realip = getenv('REMOTE_ADDR');
	}
		return $realip;
}

/**
* 获取Page页码
* @param int $sum 文章总数
* @param int $cur 每页显示文章数
* @param int $art 当前位置
* @return array $Page 页码数组
*/
function getPage($sum,$cur,$art=1)
{
	$max = ceil($sum/$cur);
	$left = max(1,$art-2);
	$right = min($left+4,$max);

	for ($i=$left; $i <= $right; $i++) { 
			$page[$i] = 'page='.$i;
	}
	return $page;
}
/**
* 获取文件后缀
* @param string $file_name 文件名
* @return string 后缀
*/
function getExt($file_name)
{
	return strrchr($file_name, '.')?strrchr($file_name, '.'):false;
}
/**
* 获取文件夹路径
* @return string 文件夹路径
*/
function createDir()
{
	$path = '/upload/'.date('Y/m',time());
	$abs =  ROOT . $path;
	if (is_dir($abs) || mkdir($abs,0777,true)) {
		return $path;
	}else{
		return false;
	}
}
/**
* 生成随机字符串
* @param int $length 产生几位的随机字符
* @return string 随机字符串
*/
function randStr($length=6) {
	$str = str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz23456789');
	$str = substr($str, 0 , $length);
	return $str;
}


/**
* 生成缩略图
* @param $ori 源图地址,$sw,$sh缩小到什么程度
* @return $opath 缩略图地址
*/
function mkThumb($ori,$sw=200,$sh=200)
{
	//dirname(提取该文件文件夹) eg:D:\phpStudy\PHPTutorial\WWW\Blog\1.php 提取得到 D:\phpStudy\PHPTutorial\WWW\Blog
	$path = dirname($ori).'/'.randStr(6).'.'.'png';
	//大图路径opic,小图路径opath
	$opic = ROOT . $ori;
	$opath = $path;
	//getimagesize()自行print_r,[0]为宽,[1]为高,[2]为type
	list($bw,$bh,$type) = getimagesize($opic);
	//判别后缀,使函数通用性上升
	$map = array(
		1 => 'imagecreatefromgif', 
		2 => 'imagecreatefromjpeg',
		3 => 'imagecreatefrompng',
		6 =>'imagecreatefromwbmp',
		15 =>'imagecreatefromwbmp'
		);
	if (!isset($map[$type])) {
		error('无此类型图片');
	}

	$func = $map[$type];
	$big = $func($ori);
	//生成小画布用于暂放缩略图
	$small = imagecreatetruecolor($sw, $sh);
	$white = imagecolorallocate($small, 255, 255, 255);

	imagefill($small, 0, 0, $white);
	//等比例缩放
	$rate = max($bw/$sw,$bh/$sh);
	$rw = $bw/$rate;
	$rh = $bh/$rate;
	//imagecopyresampled(目标画布, 源图地址, 目标开始x坐标, 目标开始y坐标, 源地址开始x坐标, 源地址开始y坐标, 目标结束坐标x, 目标结束坐标y, 源图结束坐标x, 源图结束坐标y);可视为一个鼠标画矩形框,然后复制粘贴到另外一个矩形框里.
	imagecopyresampled($small, $big, ($sw-$rw)/2, ($sh-$rh)/2, 0, 0, $rw, $rh, $bw, $bh);

	imagepng($small,$opath);

	imagedestroy($big);
	imagedestroy($small);

	return $opath;
}

/**
* md5 加密用户名和盐
* @param str $name 用户名
* @return str 返回加密后的字符串
*/
function ccode($name)
{
	$cfg = include ROOT . '/lib/config.php';
	$salt = $cfg['salt'];
	return md5($salt.'|'.$name);
}

/**
* 验证cookie
*/
function acc()
{
	if (!isset($_COOKIE['name']) || !isset($_COOKIE['ccode'])) {
		return false;
	}
	return $_COOKIE['name']===$_COOKIE['name'];
}

/**
* 转义字符串
* 对post,get,cookie 数组进行转义
*/

function _addslashes($arr)
{
	foreach ($arr as $k => $v) {
		if (is_string($v)) {
			$arr[$k] = addslashes($v);
		}else if(is_array($v)){
			$arr[$k] = _addslashes($v);
		}
	}
	return $arr;
}
?>