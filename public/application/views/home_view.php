<script type="text/javascript">
function signup() {
	window.location.href = "<?php echo base_url()?>index.php/Login/signup";
}
</script>

      <div class="row section-head">

      	<div class="twelve columns">

		<center>
      	<?php 
      	if (is_logged_in()) { 
			echo "<h3>You're logged in. Start by clicking on Accounts</h3>";      	
      	} else {
	      	echo form_button('signup', 'Sign Up Now','onClick="signup()"');
	      	echo "<br>or ".anchor('Login', 'Sign In');
      	} 
      	?>
      	
		</center>
      	</div>
      	
      	</div>