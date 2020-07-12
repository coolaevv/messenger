<?php
		foreach($query as $myContac){
		?>
	<div class="contact">
		<div class="name">
			<?php echo $myContac['name']; ?>
		</div>
		<div class="surname">
			<?php echo $myContac['surname']; ?>
		</div>
		<div class="email">
			<?php echo $myContac['email']; ?>
		</div>
		<div class="opt">
			
		</div>
	</div>
		<?php
		}
	?>