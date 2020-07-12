<?php
require_once ("../server/config.php");
session_start();

$login = trim(htmlspecialchars($_POST['login']));
$pswd = trim(htmlspecialchars(md5($_POST['pswd'])));
$ua = trim(htmlspecialchars($_POST['ua']));
$date = date('d.m.Y'); //дата
$time = date('H:i:s'); //время
$u_ip = $_SERVER['REMOTE_ADDR'];

$sql_check_user = "SELECT `email` FROM `users` WHERE `email` = '$login'";
$check_query = mysqli_query($connection, $sql_check_user);

if(mysqli_num_rows($check_query) > 0){
	$sql_check_pswd = "SELECT `password` FROM `users` WHERE `password` = '$pswd'";
	$check_query_pswd = mysqli_query($connection, $sql_check_pswd);

	if(mysqli_num_rows($check_query_pswd) > 0){
		$sql = "SELECT `id`, `name`, `surname`, `email`, `password`, `ua` FROM `users` WHERE `email` = '$login'";
		$query = mysqli_query($connection, $sql);
		foreach($query as $query_rows){
			$_SESSION['id'] = $query_rows['id'];
			$_SESSION['name'] = $query_rows['name'];
			$_SESSION['surname'] = $query_rows['surname'];
			$_SESSION['login'] = $query_rows['email'];
		}
		if(isset($_SESSION['id']) || isset($_SESSION['name']) || isset($_SESSION['surname']) || isset($_SESSION['login'])){
			echo "OK";
		}
	}else{
		echo "<div class='error-message' style='color: red'>Неверный пароль!</div>";
	}
}else{
	echo "<div class='error-message' style='color: red'>Такого пользователя не существует!</div>";
}