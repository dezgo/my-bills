<link rel="stylesheet" href="<?php echo base_url();?>css/onoffswitch.css">

<div class="row section-head add-bottom">
	<div class="twelve columns">

		<?php
      	echo "<h3>".$message."</h3>";
		echo validation_errors('<p class="error">');
      	echo form_open('Site/update_profile');
      	
      	// firstname
      	echo form_label("First name","lbl_firstname");
      	echo form_input("first_name",$firstname,"autofocus");
      	
      	// lastname
      	echo form_label("Last name","lbl_lastname");
      	echo form_input("last_name",$lastname);
      	
      	// Email address
      	echo form_label("Email","lbl_email");
      	echo form_input("email_address",$email_address,"size='50'");
      	
      	// password
      	echo lang("new_password","password");
      	echo form_password("password","");
      	echo lang("confirm_password","passconf");
      	echo form_password("passconf","");
      	echo "Leave blank to keep your current password";

      	// google authentication
      	echo form_label("Google Authentication","lbl_google_auth");
      	?>

		<!--  https://proto.io/freebies/onoff/ -->
		<div class="onoffswitch">
		    <input style="display: none" type="checkbox" name="chkGoogleAuthEnabled" value="yesthanks" class="onoffswitch-checkbox" id="myonoffswitch" <?php if($google_auth_enabled) echo 'checked'; ?>>
		    <label class="onoffswitch-label" for="myonoffswitch">
		        <span class="onoffswitch-inner"></span>
		        <span class="onoffswitch-switch"></span>
		    </label>
		</div>

		<?php
      	echo lang("qr_code","qr_code");
		echo "<img src='".$qr_url."'><br>";
      	echo form_label("Secret","lbl_secret");
		echo form_input("google_auth_secret",$google_auth_secret);
		if (!$google_auth_enabled) 
		{
			echo form_label("Verification Code","lbl_verification_code");
			echo form_input("google_auth_code");
			echo "To turn on google authentication, open your google authenticator app and scan the QR Code or type in the secret. Then enter the verification code.";
		}
		else 
		{
			echo "If you've accidentally removed your account from the google authenticator app, you can add it again by scanning the QR Code or typing in the secret.";
		}
		
      	// close form
      	echo "<BR><BR>";
      	echo form_submit('submit','Update');
      	echo form_close();
      	?>
	
	</div>
</div>