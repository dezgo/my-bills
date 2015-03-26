<script type="text/javascript">
function export_csv()
{
	window.location.href = "<?php echo base_url()?>index.php/payments/export_csv";
}

function import_csv()
{
	window.location.href = "<?php echo base_url()?>index.php/payments/upload_get_file";
}

</script>
<div class="row section-head add-bottom">

      	<div class="twelve columns">

	<h2>History</h2>

	<?php if ($num_results == 0) { ?>
	It looks like you haven't paid any accounts yet. Click Accounts to get started or import your history now.<br>
	<br>		
	<?php } else { 
	
		$this->load->helper('date');
		?>

	<table>
		<thead>
			<?php foreach($fields as $field_name => $field_display): ?>
			<th <?php if ($sort_by == $field_name) echo "class='sort_$sort_order'"; ?>>
				<?php echo anchor("payments/show_list/$field_name/" .
				(($sort_order == 'asc' && $sort_by == $field_name) ? "desc" : "asc"), 
				$field_display); ?>
			</th>
			<?php  endforeach; ?>
			
		</thead>
		
		<tbody>
			<?php foreach($records as $record): ?>
			<tr>
				<?php foreach($fields as $field_name => $field_display): ?>
				<td>
					<?php 
					if ($field_name == 'payment_date') {
						echo date($date_format, gmt_to_local(strtotime($record->$field_name)));
					}
					else
						echo $record->$field_name; 
					?>
				</td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		
	</table>
	
	<?php echo $this->pagination->create_links(); ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
	$('tr:odd').css('background', '#e3e3e3');

	
</script>

<style>
.sort_asc:after {
	content: "^";
}

.sort_desc:after {
	content: "v";
}
</style>
<hr>
<?php 
echo form_button('export', 'Export to CSV', 'onclick="export_csv()"')."&nbsp;";

} 

echo form_button('export', 'Import from CSV', 'onclick="import_csv()"');

?>
	
	</div> <!-- end payments list -->

   	</div> <!-- end row -->