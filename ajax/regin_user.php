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
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."'");
	$id = -1;
	
	if($user_read = $query_user->fetch_row()) {
		echo $id;
	} else {
		$mysqli->query("INSERT INTO `users`(`login`, `password`, `roll`) VALUES ('".$login."', '".$password."', 0)");
		
		$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`= '".$password."';");
		$user_new = $query_user->fetch_row();
		$id = $user_new[0];
			
		if($id != -1) $_SESSION['user'] = $id; // запоминаем пользователя
		echo $id;
	}
?>