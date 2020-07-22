<?php
$current_user = wp_get_current_user();

$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];
if ($current_user->roles[0] == 'pureproof-user') {
?>

<div id="content-lhs">
			<ul>
	<li><a href="<?= home_url().'/user-ticket'; ?>" class=<?php echo ($first_part == 'user-ticket')? 'active': ''; ?> ><i class="fa fa-area-chart" aria-hidden="true" ></i> Dashboard</a></li>
	<!-- <li><a href=""><i class="fa fa-user" aria-hidden="true"></i> User - Ticket</a></li> -->
	<!-- <li><a href="#"><i class="fa fa-trash" aria-hidden="true"></i> Ticket Delete</a></li> -->
	<li><a href="<?= home_url().'/create-ticket-2'; ?>" class=<?php echo ($first_part == 'create-ticket-2')? 'active': ''; ?> ><i class="fa fa-cogs" aria-hidden="true"></i> Create Ticket</a></li>
	<li><a href="<?= home_url().'/message-board'; ?>" class=<?php echo ($first_part == 'message-board')? 'active': ''; ?> ><i class="fa fa-users" aria-hidden="true"></i> Message board</a></li>
	<li><a href="<?= home_url().'/file-sharing'; ?>" class=<?php echo ($first_part == 'file-sharing')? 'active': ''; ?> ><i class="fa fa-file" aria-hidden="true"></i> file sharing</a></li>
	
			</ul>
		</div>

		<?php
	}
	else{
		?>
		<div id="content-lhs">
			<ul>
	<li><a href="<?= home_url().'/user-ticket'; ?>" class=<?php echo ($first_part == 'user-ticket')? 'active': ''; ?> ><i class="fa fa-area-chart" aria-hidden="true" ></i> Dashboard</a></li>
	<li><a href="<?= home_url().'/message-board'; ?>" class=<?php echo ($first_part == 'message-board')? 'active': ''; ?> ><i class="fa fa-users" aria-hidden="true"></i> Message board</a></li>
	<li><a href="<?= home_url().'/file-sharing'; ?>" class=<?php echo ($first_part == 'file-sharing')? 'active': ''; ?> ><i class="fa fa-file" aria-hidden="true"></i> file sharing</a></li>
			</ul>
		</div>
		<?php

	}