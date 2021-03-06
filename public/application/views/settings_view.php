	<div class="row section-head">

      	<div class="twelve columns">
      	
      	
      	<?php
      	echo "<h3>".$message."</h3>";
      	echo form_open('Settings/update');
      	
      	// date format
      	echo form_label("Date format","date_format");
      	echo form_input("date_format",$date_format);
      	echo 'e.g. d/mm/yy - 5/02/2015, d-m-y - 5-2-15, dd.mm.yyyy - 05.02.2015 ';

      	// email reminder days
      	echo form_label("Email Reminder days","email_reminder_days");
      	echo form_input("email_reminder_days",$email_reminder_days);
      	echo 'Number of days before bill is due to send email reminder (zero for no reminders)<br>';
      	 
      	// items per page
      	echo form_label("Items / page","items_per_page");
      	echo form_input("items_per_page",$items_per_page);
      	echo 'Number of items to show per page in accounts and payments lists<br>';
      	
      	// timezone
      	echo form_label("Timezone","timezone");
      	echo timezone_menu($timezone, '', 'cmbTimezone', 'autocomplete="off"');
      	echo form_checkbox('chkDst','true',$dst);
      	echo 'Daylight Savings time?<br>';
      	echo '<br><br>';
      	
      	echo form_submit('submit','Update');
      	echo form_close();
      	?>
      	
      	</div>
      	
      	</div>