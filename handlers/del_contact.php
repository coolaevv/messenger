<?php

session_start();
require_once("../server/config.php");

if(isset($_POST['id'])){
	$id = trim(htmlspecialchars($_POST['id']));
	$sql = "DELETE FROM `friends` WHERE `id` = '$id' ";
	mysqli_query($connection, $sql);
}
