<?php 
/*if($current_user->ID == 0)
{ */
?>

<div class="container-wrap">
	<div class='container'>
		<div class="row">
	<div id="register_area">
		<!-- <img src="https://pureproofinc.com/wp-content/uploads/2020/03/logo.png"> -->
		<h1>Register</h1>
		<form id="user_register_form" method="POST">
		<div class="filed">
			<i class="fa fa-user"></i>
			<input type="text" name="user_name" placeholder="User Name">
		</div>
		<div class="filed">
			<i class="fa fa-envelope"></i>
			<input type="email" name="email" placeholder="Email">
		</div>
		<div class="filed">
			<i class="fa fa-lock"></i>
			<input id="pass" type="password" name="pass" placeholder="Password">
			<input type="hidden" name="action" value="daily_user_registration_form">
		</div>
		<div class="filed">
			<i class="fa fa-lock"></i>
			<input type="password" name="c_pass" placeholder="Confirm Password">
		</div>				
		<button type="submit" id="register_submit" class="button-submit">Register</button>
		<p>You already have an account? <a href=<?= home_url().'/ticket-sytem-login' ?>>Login</a></p>
		</form>
	</div>

		</div><!--/row-->

	</div>
</div><!--/container-wrap-->

<?php  
/*}
else{
	wp_redirect(home_url());
}*/
?>