<div class="row section-head">

	<div class="twelve columns">

	<?php 
	echo form_open('login/send_password_reset'); 
	echo form_label('Email address','lbl_email_address');
	echo form_input('email_address', '', 'size=30 placeholder="Email address" autofocus');

	// show captcha HTML using Securimage::getCaptchaHtml()
	require_once APPPATH.'third_party/securimage.php';
	$options = array();
	$options['input_name'] = 'ct_captcha'; // change name of input element for form post

	if (!empty($_SESSION['ctform']['captcha_error'])) {
		// error html to show in captcha output
		$options['error_html'] = $_SESSION['ctform']['captcha_error'];
	}

    echo Securimage::getCaptchaHtml($options);
    
    echo form_submit('submit', 'Reset');
	echo form_close();

	echo '<br>Don\'t have an account?&nbsp;';
	echo anchor('login/signup', 'Create one');
	
	echo validation_errors('<p class="error">'); 
	?>
		
	</div> <!-- end login form -->

</div> <!-- end row -->
 