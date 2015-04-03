<div class="row section-head">

	<div class="twelve columns">

	<?php 
	$this->lang->load('standard');
	echo form_open('login/forgot_password'); 
	echo lang('email_address','email_address');
	echo form_input('email_address', $email_address, 'size=30 placeholder="'.$this->lang->line('email_address').'" autofocus');

	echo lang('captcha','captcha');
	echo $image.'<br><br>';
	echo form_input('captcha');
		
	echo form_submit('submit', $this->lang->line('reset'));
	echo form_close();

	echo $this->lang->line('no_account').'&nbsp;';
	echo anchor('login/signup', $this->lang->line('create_one'));
	
	echo validation_errors('<p class="error">'); 
	?>
		
	</div> <!-- end login form -->

</div> <!-- end row -->
 