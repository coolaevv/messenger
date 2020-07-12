<?php
require_once ("../server/config.php");

$name = trim(htmlspecialchars($_POST['name']));
$surname = trim(htmlspecialchars($_POST['surname']));
$email = trim(htmlspecialchars($_POST['email']));
$pswd = trim(htmlspecialchars(md5($_POST['pswd'])));
$ua = trim(htmlspecialchars($_POST['ua']));

$sql_check_user = "SELECT `email` FROM `users` WHERE `email` = '$email'";
$check_query = mysqli_query($connection, $sql_check_user);

if(mysqli_num_rows($check_query)){
	echo "<div class='error-message'>Пользоватеть с таким email уже существует!</div>";
}else{
	$sql = "INSERT INTO `users`(`id`, `name`, `surname`, `email`, `password`, `ua`) 
	VALUES ('','$name','$surname','$email','$pswd','$ua')";

	$reg = mysqli_query($connection, $sql);

	if($reg){
		echo "<div class='success-message'>Регистрация прошла успешно!</div>";
	}else{
		echo "<div class='success-message' style='color: red;'>Ошибка при регистрции =(( </div>";
	}
	mysqli_close($connection);
}