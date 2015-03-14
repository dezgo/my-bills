
      <div class="row section-head">

      	<div class="twelve columns">

	<?php 
	if ($failed > 0)
	{
		echo "Sorry, either that username is unknown, or the password is wrong. Please try again.";
	}
	?>

	<?php if (isset($account_created)) {?>
		<h3><?php echo $account_created; ?></h3>
	<?php } else { ?>
		<h1>Login, champ!</h1>
	<?php  } ?>
	
	<?php echo form_open('login/validate_credentials'); ?>
	
	<script type="text/javascript">
	if (placeholderIsSupported() == true)
	{
	<?php 
		echo "document.write('".form_input('username', '', 'placeholder="Username"')."');
		";
		echo "document.write('".form_password('password', '', 'placeholder="Password" class="password"')."');
		";
	?> 
	}
	else
	{
	<?php 
		echo "document.write('".form_input('username', 'Username')."');
		";
		echo "document.write('".form_password('password', 'Password', 'class="password"')."');
		";
	?>
	}
	</script>
	<?php 
	echo form_submit('submit', 'Login');
	echo anchor('login/signup', 'Create Account');	
	echo form_close();
	?>

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
 