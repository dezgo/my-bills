
      <div class="row section-head">

      	<div class="twelve columns">
   <link rel="stylesheet" href="<?php echo base_url();?>css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<?php 
echo form_open('site/update_account');
echo form_hidden('id',$id);
$this->table->add_row(
	form_label('Account Name', 'account'),
	form_input('account',$account));
$this->table->add_row(
	form_label('Last Due', 'last_due'),
	form_input('last_due',$last_due,"id='last_due'"));
$this->table->add_row(
	form_label('Times/year', 'times_per_year'),
	form_input('time_per_year',$times_per_year));
$this->table->add_row(
	form_label('Amount', 'amount'),
	form_input('amount',$amount));
$this->table->add_row(
	"&nbsp;",
	form_submit('submit', 'Update'));

echo $this->table->generate();

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