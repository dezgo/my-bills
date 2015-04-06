<link rel="stylesheet" href="<?php echo base_url();?>css/onoffswitch.css">
<style>
.onoffswitch-inner:before {
    content: "YES";
}
.onoffswitch-inner:after {
    content: "NO";
}
</style>

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
	echo form_open('Login/validate_credentials'); 
	echo lang('email_address','email_address');
	echo form_input('email_address', '', 'autofocus size="40"');
	echo lang('password','password');
	echo form_password('password', '', 'class="password"');
	echo form_label('Keep me logged in for 30 days','lbl_password_remember');
?>
		<!--  https://proto.io/freebies/onoff/ -->
		<div class="onoffswitch">
		    <input style="display: none" type="checkbox" name="stay_logged_in" value="yesthanks" class="onoffswitch-checkbox" id="myonoffswitch">
		    <label class="onoffswitch-label" for="myonoffswitch">
		        <span class="onoffswitch-inner"></span>
		        <span class="onoffswitch-switch"></span>
		    </label>
		</div>
<?php
	echo '<br><br>';
	echo form_submit('submit', 'Sign in');
	echo form_close();
	?>
	<br>Forget your password?&nbsp;
	<?php echo anchor('Login/forgot_password', 'Reset it');?>	
	<br>Don't have an account?&nbsp;
	<?php echo anchor('Login/signup', 'Create one');?>

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
 