<?php
session_start();
define("PORT", "8080");
include "chat.php";
$chat = new Chat();

mb_internal_encoding("UTF-8");
echo " Сервер запущен!\r\n";
echo " Лог клиентов: \r\n\r\n";

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, 0, PORT);
socket_listen($socket);

$clientSocketArray = array($socket);

while(true){
	$newSocketArray = $clientSocketArray;
	$null = [];
	socket_select($newSocketArray, $null, $null, 0, 10);

	if(in_array($socket, $newSocketArray)){
		$newSocket = socket_accept($socket);
		$clientSocketArray[] = $newSocket;

		$header = socket_read($newSocket, 1024);
		$chat->sendHeaders($header, $newSocket, 'localhost/messenger/server', PORT);

		socket_getpeername($newSocket, $client_ip_address);

		$request = file_get_contents("http://api.sypexgeo.net/json/"); 
		$array = json_decode($request);
		ini_set('date.timezone', 'Asia/Novosibirsk');
		$data_time = date("d.m.y G:i");
		echo "ip: ".$client_ip_address." ".$array->city->name_ru." ".$data_time."\r\n\r\n";

		$newSocketArrayIndex = array_search($socket, $newSocketArray);
		unset($newSocketArray[$newSocketArrayIndex]);
	}

	foreach($newSocketArray as $newSocketArrayResource){
		while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
			$socketMessage = $chat->unseal($socketData);
			$chatMessage = $chat->onlineSend($socketMessage);

			$array_users = $clientSocketArray;
			$send_user_data = array_search($newSocketArrayResource, $array_users);
			if($send_user_data !== false){
				unset($array_users[$send_user_data]);
			}
			$chat->send($chatMessage, $array_users);

			break 2;
		}

		$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
		if($socketData === false){
			socket_getpeername($newSocketArrayResource, $client_ip_address);

			$newSocketArrayIndex = array_search($newSocketArrayResource, $clientSocketArray);
			unset($clientSocketArray[$newSocketArrayIndex]);
		}
	}
}

socket_close($socket);