<script type="text/javascript">
function editAccount(id) {
	window.location.href = "<?php echo base_url()?>site/edit_account/" + id;
}

function deleteAccount(id) {
	if (confirm('This will permanently delete this bill. Proceed?')) {
		window.location.href = "<?php echo base_url()?>site/delete_account/" + id;
	}
}
  
  </script>
  
      <div class="row section-head add-bottom">

      	<div class="twelve columns">

	<h1>Accounts</h1>
	
	<table>
		<thead>
			<?php foreach($fields as $field_name => $field_display): ?>
			<th <?php if ($sort_by == $field_name) echo "class='sort_$sort_order'"; ?>>
				<?php echo anchor("site/members_area/$field_name/" .
				(($sort_order == 'asc' && $sort_by == $field_name) ? "desc" : "asc"), 
				$field_display); ?>
			</th>
			<?php  endforeach; ?>
			<th>
				<?php echo anchor("","Actions"); ?>
			</th>
		</thead>
		
		<tbody>
			<?php foreach($records as $record): ?>
			<tr>
				<?php foreach($fields as $field_name => $field_display): ?>
				<td>
					<?php echo $record->$field_name; ?>
				</td>
				<?php endforeach; ?>
				<td>
					<?php echo form_button('name','Edit','onClick="editAccount(' . $record->id . ')"'); ?>
					<?php echo form_button('name','Delete','onClick="deleteAccount(' . $record->id . ')"'); ?>
				</td>
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

   		</div> <!-- end accounts list -->

   	</div> <!-- end row -->