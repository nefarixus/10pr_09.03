<?php
	session_start();
	include("../settings/connect_datebase.php");
	include("../recaptcha/autoload.php");
	
	$secret = '6LdvNEosAAAAAJEYP9nmgmhdaQwETDg61LXxKlvp';

	if (isset($_POST['g-recaptcha-response'])) {
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if ($resp -> isSuccess()) {
			echo 'Регистрация прошла успешно';
		} else {
			echo 'Пользователь не распознан';
		}
	} else {
		echo 'Нет ответа от ReCaptcha';
	}
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`= '".$password."';");
	
	$id = -1;
	while($user_read = $query_user->fetch_row()) {
		$id = $user_read[0];
	}
	
	if($id != -1) {
		$_SESSION['user'] = $id;
	}
	echo md5(md5($id));
?>