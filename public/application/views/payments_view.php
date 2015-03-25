      <div class="row section-head add-bottom">

      	<div class="twelve columns">

	<h1>History</h1>

	<?php if ($num_results == 0) { ?>
		<h3>It looks like you haven't paid any accounts yet. Click Accounts to get started.</h3>
		
	<?php } else { ?>

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
						echo date($date_format, strtotime($record->$field_name));
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

	<?php } ?>
	
	</div> <!-- end payments list -->

   	</div> <!-- end row -->