
      <div class="row section-head">

      	<div class="twelve columns">
   <link rel="stylesheet" href="<?php echo base_url();?>css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<?php 
echo form_open('site/update_account');
echo form_hidden('id',$id);
echo form_input('account',$account);
echo form_input('last_due',$last_due,"id='last_due'");
echo form_input('time_per_year',$times_per_year);
echo form_input('amount',$amount);
echo form_submit('submit', 'Update');
echo form_close();

?>

<script>
jQuery.noConflict();
$(function() {
	$( "#last_due" ).datepicker();
});
</script>
      	
      	</div>
    </div>