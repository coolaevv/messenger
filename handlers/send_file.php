<?php
session_start();
require_once ("../server/config.php");
require_once ("../handlers/crypt.php");

if( isset($_FILES['file']) ){
	$f_name = $_FILES['file']['name'];
	$f_size = $_FILES['file']['size'];
	$f_type = $_FILES['file']['type'];
	$f_tmp  = $_FILES['file']['tmp_name'];


	$check_f_sql = "SELECT `id`, `u_id`, `f_id`, `name` FROM `friends` 
	WHERE `u_id` = '$f_id' AND `f_id` = '$u_id' ";
	$check_f_q = mysqli_query($connection, $check_f_sql);

	if(mysqli_num_rows($check_f_q) > 0){
		$in_message = "INSERT INTO `messages`(`id`, `user`, `recipient`, `message`) 
		VALUES ('','{$_SESSION['id']}','$f_id','$message')";
		mysqli_query($connection, $in_message);
	}else{
		$sql_user = "SELECT `name`, `surname`, `email` FROM `users` 
		WHERE `id` = '$u_id' ";
		$q_user = mysqli_query($connection, $sql_user);
		$res_user = mysqli_fetch_array($q_user);
		echo $res_user['name'];
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
	}

	$type_file = explode('/', $f_type);
	$type = $type_file[0];
	$ext = $type_file[1];
	$mime_type_file = $type_file[0].'/'.$type_file[1];
	
	
	function translitL($value){
		$latin = array(
			'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
			'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
			'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
			'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
			'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
			'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
			'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
			'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
			'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
			'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
			'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
			'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
			'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
			'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',    ' ' => '-'
		);
		$value = strtr($value, $latin);
		return $value;
	}
	move_uploaded_file($f_tmp, '../files/'.$type.'/' . translitL($f_name));
	$host = "http://217.71.129.139:4047";
	$url_file = $host."/files/".$type."/";
	$response = "<div class=file_response><a href='".$url_file.translitL($f_name)."' title='Скачать: ".translitL($f_name)."' download='".translitL($f_name)."'>".translitL($f_name)."</a></div>";

	if($f_name !== ''){
		echo $response;

		$u_id = $_SESSION['id'];
		$f_id = $_SESSION['id_use'];

		$response_files = $url_file.translitL($f_name);

		$sql_in_dialog = "INSERT INTO `messages`(`id`, `user`, `recipient`, `message`) 
		VALUES ('','$u_id','$f_id','$response_files')";
		mysqli_query($connection, $sql_in_dialog);
	}
}



/*$type_file = explode('/', $f_type);
	$type = $type_file[0];
	$ext = $type_file[1];
	$mime_type_file = $type_file[0].'/'.$type_file[1];
	
	move_uploaded_file($f_tmp, '../files/'.$type.'/' . $f_name);

	$url_file = "http://socket/files/";
	$response = "<div class=file_response><a href='".$url_file.$f_name."' title='Скачать: ".$f_name."' download='".$f_name."'>".$f_name."</a></div>";

	if($f_name !== ''){
		echo $response;

		$u_id = $_SESSION['id'];
		$f_id = $_SESSION['id_use'];

		$response_files = $url_file.$f_name;

		$sql_in_dialog = "INSERT INTO `messages`(`id`, `user`, `recipient`, `message`) 
		VALUES ('','$u_id','$f_id','$response_files')";
		mysqli_query($connection, $sql_in_dialog);
	}*/