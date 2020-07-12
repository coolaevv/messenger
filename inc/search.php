<?php
session_start();
if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Поиск контактов</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="../js/jquery.lib/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<div class="search">
		<input type="button" id="back" value="<" onClick="window.location='../index.html'">
		<input type="text" id="search" placeholder="Введите запрос" autofocus>
		<input type="button" id="go" value="Найти">
	</div>

	<div class="content">
		
	</div>
	
	<script type="text/javascript">
		$('#go').click(function(){
			let dataSearch = $('#search').val();
			$.ajax({
				url: '../handlers/searchContacts.php',
				type: 'post',
				data: {'dataSearch':dataSearch},
				success: function(data){
					$('.content').html(data);
					$('.opt-cont').click(function(){
						let f_id = $(this).attr('data');
						$(this).text('Пользователь добавлен');
						$(this).addClass('ok');
						$(this).removeClass('opt-cont');
						$.ajax({
							url: '../handlers/add_contact.php',
							type: 'post',
							data: {'f_id':f_id},
							success: function(data){
								console.log(data)
							},
							error: function(){
								alert("Error");
							}
						});
					});
				},
				error: function(){
					console.log('Error');
				}
			})
		});
		$(document).ready(function() {
			$('#search').keydown(function(e) {
				if(e.keyCode === 13) {
					let dataSearch = $('#search').val();
					$.ajax({
						url: '../handlers/searchContacts.php',
						type: 'post',
						data: {'dataSearch':dataSearch},
						success: function(data){
							$('.content').html(data);
							$('.opt-cont').click(function(){
								let f_id = $(this).attr('data');
								$(this).text('Пользователь добавлен');
								$(this).addClass('ok');
								$(this).removeClass('opt-cont');
								$.ajax({
									url: '../handlers/add_contact.php',
									type: 'post',
									data: {'f_id':f_id},
									success: function(data){
										console.log(data)
									},
									error: function(){
										alert("Error");
									}
								});
							});
						},
						error: function(){
							console.log('Error');
						}
					});
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