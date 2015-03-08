   <!-- Content
   ================================================== -->
   <div id="content-wrap">  

      <div class="row section-head">

      	<div class="twelve columns">

	<?php if (isset($account_created)) {?>
		<h3><?php echo $account_created; ?></h3>
	<?php } else { ?>
		<h1>Login, champ!</h1>
	<?php  } ?>
	
	<?php	
	echo form_open('login/validate_credentials');
	echo form_input('username', '', 'placeholder="Username"');
	echo form_password('password', '', 'placeholder="Password" class="password"');
	echo form_submit('submit', 'Login');
	echo anchor('login/signup', 'Create Account');	
	echo form_close();
	?>

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
   	
   </div> <!-- end content-wrap -->