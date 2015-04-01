<div class="row section-head">

	<div class="twelve columns">

	<?php 
	echo form_open('login/send_password_reset'); 
	echo form_label('Email address','lbl_email_address');
	echo form_input('email_address', '', 'size=30 placeholder="Email address" autofocus');

	echo form_submit('submit', 'Reset');
	echo form_close();

	echo '<br>Don\'t have an account?&nbsp;';
	echo anchor('login/signup', 'Create one');
	
	echo validation_errors('<p class="error">'); 
	?>
		
	</div> <!-- end login form -->

</div> <!-- end row -->
 