<?php
session_start();
require_once ("../server/config.php");
require_once ("../handlers/crypt.php");


if(isset($_POST['id'])){
	$f_id = $_POST['id'];
	$f_id = decrypt($f_id, ENCRYPTION_KEY);
	$u_id = $_SESSION['id'];
	$message = trim(htmlspecialchars($_POST['message']));
	echo $message;

	$check_f_sql = "SELECT `id`, `u_id`, `f_id`, `name` FROM `friends` 
	WHERE `u_id` = '$f_id' AND `f_id` = '$u_id' ";
	$check_f_q = mysqli_query($connection, $check_f_sql);

	if(mysqli_num_rows($check_f_q) > 0){
		if($message != ''){
			$in_message = "INSERT INTO `messages`(`id`, `user`, `recipient`, `message`) 
			VALUES ('','{$_SESSION['id']}','$f_id','$message')";
			mysqli_query($connection, $in_message);
		}
	}else{
		$sql_user = "SELECT `name`, `surname`, `email` FROM `users` 
		WHERE `id` = '$u_id' ";
		$q_user = mysqli_query($connection, $sql_user);
		$res_user = mysqli_fetch_array($q_user);
		$in_f = "INSERT INTO `friends`(`id`, `u_id`, `f_id`, `name`, `surname`, `email`) 
		VALUES (
			'',
			'$f_id',
			'{$_SESSION['id']}',
			'{$res_user['name']}',
			'{$res_user['surname']}',
			'{$res_user['email']}'
		)";
		mysqli_query($connection, $in_f);
		$in_message = "INSERT INTO `messages`(`id`, `user`, `recipient`, `message`) 
			VALUES ('','{$_SESSION['id']}','$f_id','$message')";
			mysqli_query($connection, $in_message);
	}

	if($message != ''){
		$in_message = "INSERT INTO `messages`(`id`, `user`, `recipient`, `message`) 
		VALUES ('','{$_SESSION['id']}','$f_id','$message')";
		#mysqli_query($connection, $in_message);
	}
}