<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<!-- thanks to http://stackoverflow.com/questions/11887934/check-if-daylight-saving-time-is-in-effect-and-if-it-is-for-how-many-hours -->
<script type="text/javascript">
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
        if("<?php echo $_SESSION['timezone']; ?>".length==0 || today.dst() != "<?php echo $_SESSION['dst']?>".length){
            var visitortime = new Date();
            var visitortimezone = -visitortime.getTimezoneOffset()/60-today.dst();
            $.ajax({
            	type: "POST",
            	crossDomain: true,
                url: "<?php echo base_url()?>index.php/Settings/timezone/" + visitortimezone + "/" + today.dst(),
                success: function(){
                    location.reload();
                },
            	error: function(){
                	alert('error');
            	},
            	statusCode: {
            	    404: function() {
            	        alert( "page not found" );
            	      }
            	    }
            });
        }
    });

</script>

<script type="text/javascript">
function editAccount(id) {
	window.location.href = "<?php echo base_url()?>index.php/site/edit_account/" + id;
}

function deleteAccount(id) {
	if (confirm('This will permanently delete this bill. Proceed?')) {
		window.location.href = "<?php echo base_url()?>index.php/site/delete_account/" + id;
	}
}

function insertAccount() {
	window.location.href = "<?php echo base_url()?>index.php/site/insert_account";
}

function toggleEditMode() {
	var payCol = document.getElementsByName("payButton");
	var editCol = document.getElementsByName("editButtons");

	for(i=0; i<payCol.length; i++) {
		if(payCol[i].style.display == "none") {
			payCol[i].style.display = "block";
			editCol[i].style.display = "none";
		} else {
			payCol[i].style.display = "none";
			editCol[i].style.display = "block";
		}
	}
}

function payAccount(id,amount) {
	var amountActual = prompt("Enter the amount to pay", amount);
	if (amountActual !== null && amountActual !== undefined)
		window.location.href = "<?php echo base_url()?>index.php/site/pay_account/" + id + "/" + amountActual;
}

</script>
  
      <div class="row section-head add-bottom">

      	<div class="twelve columns">
<?php if (!isset($_SESSION['timezone']) || $_SESSION['timezone'] == '') { ?>
One moment while we get your timezone....
<?php } else { ?>

<div style="width:100%">
	<a style="float:right" href="javascript:toggleEditMode()">Toggle Edit Mode</a>
</div>
	<h1>Accounts</h1>

	<?php if ($num_results == 0) { ?>
		<h3>It looks like you haven't created any accounts yet. Click Add to get started.</h3>
		
	<?php } else { ?>

	<table>
		<thead>
			<?php 
			foreach($fields as $field_name => $field_display):
				echo "<th";
				if ($sort_by == $field_name) echo " class='sort_$sort_order'";
				echo ">";
				echo anchor("site/members_area/$field_name/" .
					(($sort_order == 'asc' && $sort_by == $field_name) ? "desc" : "asc"), 
					$field_display);
				echo "</th>";
			endforeach; 

			$this->load->helper('gmt');
			?>
			
		</thead>
		
		<tbody>
			<?php foreach($records as $record): ?>
			<tr>
				<?php foreach($fields as $field_name => $field_display): ?>
				<td>
					<?php 
					if ($field_name == 'last_due' | $field_name == 'next_due') {
						echo get_local_date($record->$field_name);
					}
					else
						echo $record->$field_name; 
					?>
				</td>
				<?php endforeach; ?>
				<td name="editButtons" style="display:none">
					<?php echo form_button('name','Edit','onClick="editAccount(' . $record->id . ')"'); ?>
					<?php echo form_button('name','Delete','onClick="deleteAccount(' . $record->id . ')"'); ?>
				</td>
				<td name="payButton">
					<?php echo form_button('name','Pay','onClick="payAccount(' . $record->id . ','.$record->amount.')"'); ?>
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

	<?php } ?>

	<?php echo form_button('name','Add','onClick="insertAccount()"'); } ?>
	
	</div> <!-- end accounts list -->

   	</div> <!-- end row -->