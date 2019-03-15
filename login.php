<?php  
	require './lib/init.php';

	if (empty($_POST)) {
		include ROOT . '/view/front/login.html';
	}else{
		$username = $_POST['username'];
		$pwd = $_POST['password'];

		$sql = "select * from user where name='$username'";
		$user = mGetRow($sql);
		if (empty($user)) {
			error('用户名或密码错误.');
		}else{
			$pwd = $user['salt'].$pwd;
			if ($user['password'] == hash("sha256",$pwd)) {
				setcookie('name' , $user['name'],time()+900);
				setcookie('ccode' , ccode($user['name']),time()+900);
				header("location:artlist.php");
			}else{
				error('用户名或密码错误.');
			}
		}

		
	}
?>