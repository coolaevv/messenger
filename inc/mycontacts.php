<?php 
session_start();
require_once("../server/config.php");
require_once("../handlers/crypt.php");
if(isset($_SESSION['id'])){
	$sql = "SELECT `id`, `u_id`, `f_id`, `name`, `surname`, `email` FROM `friends` 
	WHERE `u_id` = '{$_SESSION['id']}' ";
	$query = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Мои контакты</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../js/jquery.lib/jquery.js"></script>
	<style>
		*{box-sizing: border-box;font-family: 'Calibri', sans-serif}
		.main{
			width: 50%;
			padding: 10px;
			border: 1px solid #2980b9;
			border-radius: 4px;
			margin: 5% auto;
			color: #34495e;
		}
		.main .cont{
			width: 100%;
			padding: 10px;
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			align-items: center;
			text-align: center;
		}
		.opt{
			cursor: pointer;
		}
		@media screen and (max-width: 700px){
			.main{
				width: 100%;
			}
		}
	</style>
</head>
<body>
	<div class="main">
<?php
	foreach($query as $contact){
	?>
		<div class="cont">
			<div class="name">
				<?php echo $contact['name']; ?>
			</div>
			<div class="surname">
				<?php echo $contact['surname']; ?>
			</div>
			<div class="email">
				<?php echo $contact['email']; ?>
			</div>
			<div class="opt" data="<?php echo $contact['id']; ?>">
				Удалить
			</div>
		</div>
	<?php
	}
?>
	</div>
	<script type="text/javascript">
		$('.opt').click(function(){
			let id = $(this).attr('data');
			$.ajax({
				url: '../handlers/del_contact.php',
				type: 'post',
				data: {'id':id},
				success: function(data){
					console.log(data)
				},
				error: function(){
					console.log('Error');
				}
			});
		});
	</script>
</body>
</html>
<?php
}else{
	header("Location: ../login.html");
}

?>