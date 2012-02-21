<div id="login_form" class="form">

	<h1>Login</h1>
    <?php 
	echo form_open('admin/validate_credentials');
	echo form_input('username', 'Username');
	echo form_password('password', 'Password');
	echo form_submit('submit', 'Login');
	echo form_close();
	?>

</div><!-- end login_form-->