
      <div class="row section-head">

      	<div class="twelve columns">

	<?php 
	if ($failed > 0)
	{
		echo "Sorry, either that email address is unknown, or the password is wrong. Please try again.";
	}
	?>

	<?php if (isset($account_created)) {?>
		<h3><?php echo $account_created; ?></h3>
	<?php } else { ?>
		<h2>Login, champ!</h2>
	<?php  } ?>
	
	<?php 
	echo form_open('login/validate_credentials'); 
	echo form_input('email_address', '', 'placeholder="Email address" autofocus');
	echo form_password('password', '', 'placeholder="Password" class="password"');
	?>
	
	<script type="text/javascript">
	if (placeholderIsSupported() !== true)
	{
		document.getElementById('email_address').value = 'Email address';
		document.getElementById('password').value = 'Password';
	}
	</script>
	<?php 
	echo form_submit('submit', 'Sign in');
	echo form_close();
	?>
	<br>Don't have an account?<br>
	<?php echo anchor('login/signup', 'Create account');	
	?>

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
 