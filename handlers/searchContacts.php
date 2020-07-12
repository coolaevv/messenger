<?php
session_start();
require_once('../server/config.php');
if(isset($_POST['dataSearch'])){
	$search = $_POST['dataSearch'];
	$search = trim(htmlspecialchars($search));

	$sql = "SELECT `id`, `name`, `surname`, `email`, `password`, `ua` FROM `users` 
	WHERE `name` = '$search' OR `surname` = '$search' OR `email` = '$search' ";

	$query = mysqli_query($connection, $sql);

	if(mysqli_num_rows($query) > 0){
		foreach($query as $contact){
			$sql_2 = "SELECT `id`, `u_id`, `f_id`, `name`, `surname`, `email` FROM `friends` 
			WHERE `u_id` = '{$_SESSION['id']}' AND `f_id` = '{$contact['id']}' ";

			$query_2 = mysqli_query($connection, $sql_2);
			if(mysqli_num_rows($query_2) > 0){
				//Есть в контактах
			}else{
				?>
					<div class="result_search">
						<div class="name">
							<?php
								echo $contact['name'];
							?>
						</div>
						<div class="surname">
							<?php
								echo $contact['surname'];
							?>
						</div>
						<div class="email">
							<?php
								echo $contact['email'];
							?>
						</div>
						<div class="opt-cont" data="<?php echo $contact['id']; ?>">
							Добавить
						</div>
					</div>
				<?php
			}
		}
	}else{
		?>
		<div class="result_search">
			<?php
				echo "Поиск не дал результатов :-(";
			?>
		</div>
		<?php
	}
}
#<?php
#	echo $contact['name']." ".$contact['surname']." ".$contact['email'];