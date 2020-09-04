<?php
$current_user = wp_get_current_user();


// var_dump($directoryURI);
function check_url_ticket_page($slug){
	$directoryURI = $_SERVER['REQUEST_URI'];
		if (strpos($directoryURI, $slug) !== false) {
	    return true;
	}
}

if ($current_user->roles[0] == 'ticket-system-user') {
?>

<div id="content-lhs">
			<ul>
	<li><a href="<?= home_url().'/ticket-system-dashboard'; ?>" class=<?php echo (check_url_ticket_page('ticket-system-dashboard'))? 'active': ''; ?> ><i class="fa fa-area-chart" aria-hidden="true" ></i> Dashboard</a></li>
	<!-- <li><a href=""><i class="fa fa-user" aria-hidden="true"></i> User - Ticket</a></li> -->
	<!-- <li><a href="#"><i class="fa fa-trash" aria-hidden="true"></i> Ticket Delete</a></li> -->
	<li><a href="<?= home_url().'/ticket-system-create-ticket'; ?>"  class=<?php echo (check_url_ticket_page('ticket-system-create-ticket'))? 'active': ''; ?> ><i class="fa fa-cogs" aria-hidden="true"></i> Create Ticket</a></li>
	<?php
	if (get_option( 'chat_manager') ) {
	?>
	<li><a href="<?= home_url().'/ticket-system-msg-board'; ?>"  class=<?php echo (check_url_ticket_page('ticket-system-msg-board'))? 'active': ''; ?> ><i class="fa fa-users" aria-hidden="true"></i> Message board</a></li>
	<?php
	}

	if (get_option( 'file_manager') ) {
	?>
	<li><a href="<?= home_url().'/ticket-system-files'; ?>"  class=<?php echo (check_url_ticket_page('ticket-system-files'))? 'active': ''; ?> ><i class="fa fa-file" aria-hidden="true"></i> file sharing</a></li>
	<?php
		}
		?>
	<li><a href="<?= wp_logout_url( home_url().'/ticket-system-login' ); ?>"><i class="fa fa-file" aria-hidden="true"></i>Logout</a></li>
	
			</ul>
		</div>

		<?php
	}
	else{
		?>
		<div id="content-lhs">
			<ul>
	<li><a href="<?= home_url().'/ticket-system-dashboard'; ?>" class=<?php echo (check_url_ticket_page('ticket-system-dashboard'))? 'active': ''; ?> ><i class="fa fa-area-chart" aria-hidden="true" ></i> Dashboard</a></li>
	<?php
	if (get_option( 'chat_manager') ) {
	?>
	<li><a href="<?= home_url().'/ticket-system-msg-board'; ?>"  class=<?php echo (check_url_ticket_page('ticket-system-msg-board'))? 'active': ''; ?> ><i class="fa fa-users" aria-hidden="true"></i> Message board</a></li>
	<?php
	}

	if (get_option( 'file_manager') ) {
	?>
	<li><a href="<?= home_url().'/ticket-system-files'; ?>"  class=<?php echo (check_url_ticket_page('ticket-system-files'))? 'active': ''; ?> ><i class="fa fa-file" aria-hidden="true"></i> File sharing</a></li>
	<?php
		}
		?>
	<li><a href="<?= wp_logout_url( home_url().'/ticket-system-login' ); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
			</ul>
		</div>
		<?php

	}