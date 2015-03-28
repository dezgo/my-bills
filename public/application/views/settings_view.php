<?php 		$timezone_auto = $this->session->userdata('timezone'); ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        if("<?php echo $timezone_auto; ?>".length==0){
            var visitortime = new Date();
            var visitortimezone = -visitortime.getTimezoneOffset()/60;
            $.ajax({
                type: "GET",
                url: "<?php echo base_url()?>index.php/settings/timezone/" + visitortimezone,
                success: function(){
                    location.reload();
                }
            });
        }
    });
</script>

	<div class="row section-head">

      	<div class="twelve columns">
      	
      	
      	<?php
      	echo "<h3>".$message."</h3>";
      	echo form_open('settings/update');
      	
      	// date format
      	echo form_label("Date format","date_format");
      	echo form_input("date_format",$date_format);
      	echo 'See '.anchor('http://php.net/manual/en/function.date.php','this link').' for examples<br>';

      	// email reminder days
      	echo form_label("Email Reminder days","email_reminder_days");
      	echo form_input("email_reminder_days",$email_reminder_days);
      	echo 'Number of days before bill is due to send email reminder (zero for no reminders)<br>';
      	 
      	// items per page
      	echo form_label("Items / page","items_per_page");
      	echo form_input("items_per_page",$items_per_page);
      	echo 'Number of items to show per page in accounts and payments lists<br>';
      	
      	// timezone
      	if ($auto_timezone != '') $timezone = $timezone_auto;
      	echo form_label("Timezone","timezone");
      	echo timezone_menu($timezone, "", "cmbTimezone");
      	echo 'Set timezone automatically';
      	echo form_checkbox('auto_timezone','TRUE',$auto_timezone);
      	echo '<br><br>';
      	
      	echo form_submit('submit','Update');
      	echo form_close();
      	?>
      	
      	</div>
      	
      	</div>