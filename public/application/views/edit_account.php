
      <div class="row section-head">

      	<div class="twelve columns">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<?php 
echo validation_errors();

echo form_open('Site/edit_account');
echo form_hidden('id',$id);
//$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
//$this->table->set_template($tmpl);
$this->table->add_row(
	form_label('Account Name', 'account'),
	form_input('account',$account));
$this->table->add_row(
	form_label('Last Due', 'last_due'),
	form_input('last_due',md_unix_to_local($last_due, $date_format_php, $timezone, $dst),"id='last_due'"));
$this->table->add_row(
	form_label('Times/year', 'times_per_year'),
	form_input('times_per_year',$times_per_year));
$this->table->add_row(
	form_label('Amount', 'amount'),
	form_input('amount',$amount));

if ($id == 0) $caption = 'Add'; else $caption = 'Update';
$this->table->add_row(
	"&nbsp;",
	form_submit('submit', $caption));

echo $this->table->generate();

echo form_close();

?>

  <script>
  $(function() {
    $( "#last_due" ).datepicker({
		dateFormat: '<?php echo $date_format?>'
	});
  });
  </script>
      	
      	</div>
    </div>