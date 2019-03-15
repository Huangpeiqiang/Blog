<?php  
	require './lib/init.php';
	if (empty($_POST)) {
		include ROOT . '/view/front/register.html';
	}else{
		$user['name'] = trim($_POST['username']);
		if (!isset($user['name'])) {
			error('用户名不可为空');
		}
		$user['nick'] = trim($_POST['nick']);
		if (!isset($user['nick'])) {
			error('昵称不可为空');
		}
		$user['email'] = trim($_POST['email']);
		if (!isset($user['email'])) {
			error('Email不可为空');
		}

		$pwd = trim($_POST['password']);
		$salt = randStr(4);
		$user['salt'] = $salt;
		$pwd = $salt . $pwd;
		$user['password'] =  hash("sha256", $pwd);

		if (mExec($user,'user')) {
			succ('注册成功');
		}else{
			error(mysql_error());
		}
 	}


?>