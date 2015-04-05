<div class="row section-head add-bottom">
	<div class="twelve columns">

		<?php
      	echo "<h3>".$message."</h3>";
		echo validation_errors('<p class="error">');
      	echo form_open('Site/update_profile');
      	
      	// firstname
      	echo form_label("Firstname","lbl_firstname");
      	echo form_input("first_name",$firstname,"autofocus");
      	
      	// lastname
      	echo form_label("Lastname","lbl_lastname");
      	echo form_input("last_name",$lastname);
      	
      	// Email address
      	echo form_label("Email","lbl_email");
      	echo form_input("email_address",$email_address,"size='50'");
      	
      	// password
      	echo form_label("New Password","lbl_new_password");
      	echo form_password("password","");
      	echo form_label("Confirm Password","lbl_new_password_confirm");
      	echo form_password("passconf","");
      	echo "Leave blank to keep your current password";
      	
      	// close form
      	echo "<BR><BR>";
      	echo form_submit('submit','Update');
      	echo form_close();
      	?>
	
	</div>
</div>