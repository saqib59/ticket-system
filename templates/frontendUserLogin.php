<?php 
// if($current_user->ID == 0)
// { 
?>

<div class="container-wrap">
	<div class='container'>
		<div class="row">
	<div id="register_area">
		<!-- <img src="https://pureproofinc.com/wp-content/uploads/2020/03/logo.png"> -->
		<h1>login</h1>
		<form method="post" id="user-login-form">
		<div class="filed">
			<i class="fa fa-envelope"></i>
			<input type="text" name="user_name" placeholder="User Name Or Email">
		</div>
		<div class="filed">
			<i class="fa fa-lock"></i>
			<input type="password" name="pass" placeholder="Password">
			<input type="hidden" name="action" value="user_login">
		</div>				
		<div class="field">
			<label class="containerform">Remember me
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
			<a href="#" class="forgot">Forgot Password?</a>
			<div class="clearfix"></div>
		</div>
		<button type="submit" class="button-submit" id="login-user">Login</button>
		<p>Don’t Have an Account? <a href=<?= home_url().'/register'; ?>>Register</a></p>
		</form>
	</div>
		</div><!--/row-->
</div><!--/container-wrap-->
<?php
/*}
else{
	wp_redirect(home_url());
}*/
 ?>
