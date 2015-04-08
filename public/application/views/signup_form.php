<script type="text/javascript" src="<?php echo base_url()?>js/zxcvbn-async.js"></script>
<script type="text/javascript">
function checkStrength(inpPassword)
{
	if (typeof zxcvbn == 'function') {
		var strength = ["Trivial", "Weak", "Fair", "Good", "Strong"];
		var colour = ["#666","#a03","#fc3","#2d98f3","#009933"];
		var result = zxcvbn(inpPassword.value);
		document.getElementById("passStrength").innerHTML = "Password Strength: <strong><font color='"+colour[result.score]+"'>"+strength[result.score]+"</font></strong>";
	}
}
</script>
 
      <div class="row">

      	<div class="twelve columns">

<h2>Create Account</h2>

	<?php 
	
	echo form_open('Login/create_member');
	echo form_input('email_address', '', 'placeholder="Email address" autofocus size="32"');
	echo form_password('password', '', 'placeholder="Password" class="password" size="32" onkeyup="checkStrength(this)"');
	?>
	<div id='passStrength'></div>
	
	<script type="text/javascript">
	if (placeholderIsSupported() !== true)
	{
		document.getElementById('email').value = 'Email address';
		document.getElementById('password').value = 'Password';
	}
	</script>
	<br>
	<?php 
	echo form_submit('submit', 'Create account');
	echo form_close();
	?>
	<br>Already have an account?<br>
	<?php echo anchor('Login', 'Sign in');	
	?>

		<?php echo validation_errors('<p class="error">'); ?>

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
 