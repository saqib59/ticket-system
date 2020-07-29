<div class="wrap">
	<?php
	settings_errors();
	?>
	<form action="options.php" method="post">
		<?php
		settings_fields( 'ticket_system_settings' );
		do_settings_sections( 'my_plugin' );
		submit_button();
		?>
	</form>
</div>