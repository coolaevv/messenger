<?php
session_start();
include "../server/config.php";
include "crypt.php";
$id = trim(htmlspecialchars($_POST['id']));
$id_decript = decrypt($id, ENCRYPTION_KEY);

$_SESSION['id_use'] = $id_decript;

$sql = "SELECT `id`, `user`, `recipient`, `message` FROM `messages` 
WHERE `user` = '{$_SESSION['id']}' AND `recipient` = '$id_decript' OR `user` = '$id_decript' AND `recipient` = '{$_SESSION['id']}'";

$messages = mysqli_query($connection, $sql);

foreach($messages as $dialog){
	$haystack = $dialog['message'];
	$needle = 'http://217.71.129.139:4047/';
	$pos = strripos($haystack, $needle);
	if($_SESSION['id'] === $dialog['recipient']){
		$clss = "message-user-to";
	}else{
		$clss = "message-user";
	}
	if($pos === false){
		?>
			<div class="<?php echo $clss; ?>">
				<div class="text">
					<?php echo $dialog['message']?>
				</div>
			</div>
		<?php
	}else{
		$name_file = str_replace($needle, "", $dialog['message']);
		$name_file = explode("/", $name_file);
	?>
		<div class="<?php echo $clss; ?>">
			<a href="" title="Скачать" download="<?php echo $name_file[2];?>">
				<?php echo $name_file[2];?>
			</a>
		</div><br>
	<?php
	}
}
