<?php
$connection = mysqli_connect("localhost", "root", "", "messanger");
mysqli_set_charset($connection, 'utf8'); //Кодировка приложения UTF-8
if(!$connection){
	print_r("Ошибка подключения к базе данных! ". mysqli_connect_error());
}