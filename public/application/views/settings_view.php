      <div class="row section-head">

      	<div class="twelve columns">
      	
      	
      	<?php 
      	echo "<h3>".$message."</h3>";
      	echo form_open('settings/update');
      	echo form_label("Date format","date_format");
      	echo form_input("date_format",$date_format);
      	echo form_submit('submit','Update');
      	echo form_close();
      	?>
      	
      	</div>
      	
      	</div>