<script type="text/javascript">
function signup() {
	window.location.href = "<?php echo base_url()?>login/signup";
}
</script>

      <div class="row section-head">

      	<div class="twelve columns">

<center>
      	<?php echo form_button('signup', 'Sign Up Now','onClick="signup()"'); ?>
      	<br>
      	or <?php echo anchor('login', 'Sign In')?>
      	
</center>
      	</div>
      	
      	</div>