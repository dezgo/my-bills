<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
<!-- thanks to http://stackoverflow.com/questions/11887934/check-if-daylight-saving-time-is-in-effect-and-if-it-is-for-how-many-hours -->
	Date.prototype.stdTimezoneOffset = function() {
	    var jan = new Date(this.getFullYear(), 0, 1);
	    var jul = new Date(this.getFullYear(), 6, 1);
	    return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
	}
	
	Date.prototype.dst = function() {
	    return this.getTimezoneOffset() < this.stdTimezoneOffset();
	}
	
	var today = new Date();

 	$(document).ready(function() {
        if("<?php echo $timezone; ?>".length==0){
            var visitortime = new Date();
            var visitortimezone = -visitortime.getTimezoneOffset()/60-today.dst();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url()?>index.php/settings/timezone/" + visitortimezone + "/" + today.dst(),
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