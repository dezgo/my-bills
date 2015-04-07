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
	if ($message != '') echo $message;
	
	echo form_open('Login/validate_google_auth_code','autocomplete="off"'); 
	echo form_hidden('member_id',$member_id);
	echo form_label('Google Authenticator Verification Code','lbl_google_auth_code');
	echo form_input('google_auth_code','','autocomplete="off"');
	echo form_label("Don't prompt for verification code on this computer for 30 days",'lbl_google_auth_remember');
	?>
		<!--  https://proto.io/freebies/onoff/ -->
		<div class="onoffswitch">
		    <input style="display: none" type="checkbox" name="google_auth_remember" value="yesthanks" class="onoffswitch-checkbox" id="myonoffswitch">
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

	  		</div> <!-- end login form -->

   	</div> <!-- end row -->
 