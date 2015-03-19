      <div class="row">

      	<div class="twelve columns">

<h2>Create Account</h2>

	<?php 
	
	echo form_open('login/create_member');
	echo form_input('email_address', '', 'placeholder="Email address"');
	echo form_password('password', '', 'placeholder="Password" class="password"');
	?>
	
	<script type="text/javascript">
	if (placeholderIsSupported() !== true)
	{
		document.getElementById('email').value = 'Email address';
		document.getElementById('password').value = 'Password';
	}
	</script>
	<?php 
	echo form_submit('submit', 'Create account');
	echo form_close();
	?>
	<br>Already have an account?<br>
	<?php echo anchor('login', 'Sign in');	
	?>

		<?php echo validation_errors('<p class="error">'); ?>

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
 