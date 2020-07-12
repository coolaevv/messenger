<?php
require_once ('../server/config.php');
session_start();

if(isset($_POST['f_id'])){
	$f_id = trim(htmlspecialchars($_POST['f_id']));

	$sql_user = "SELECT `id`, `name`, `surname`, `email`, `password`, `ua` FROM `users` 
	WHERE `id` = '$f_id' ";

	$query = mysqli_query($connection, $sql_user);
	$user = mysqli_fetch_array($query);

	$sql_f = "INSERT INTO `friends`(`id`, `u_id`, `f_id`, `name`, `surname`, `email`) 
		VALUES (
			'',
			'{$_SESSION['id']}',
			'$f_id',
			'{$user['name']}',
			'{$user['surname']}',
			'{$user['email']}'
		)";

	$check = "SELECT `id`, `u_id`, `f_id`, `name`, `surname`, `email` FROM `friends` 
	WHERE `id` = '$f_id' ";
	$q_check = mysqli_query($connection, $check);
	if(mysqli_num_rows($q_check) > 0){
		//Уже в контактах
	}else{
		mysqli_query($connection, $sql_f);
	}
}
