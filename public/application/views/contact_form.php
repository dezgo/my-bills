	<div class="row section-head">
    	<div  class="twelve columns">

			<h1>Contact Us!</h1>
			<?php 
			echo form_open('contact/submit');
			echo form_input('name', '', 'id="name" placeholder="Name" maxlength="20" size="20"');
			echo form_input('email', '', 'id="email" placeholder="Email" maxlength="50" size="50"');
			echo form_textarea(array('name' => 'message', 'placeholder' => 'Message', 'id' => 'message'));
			echo form_submit('submit', 'Submit', 'id="submit"');
			echo form_close();
			?>
	
		</div> <!-- end login form -->

	</div> <!-- end row -->
   
<script type="text/javascript">
$('#submit').click(function() {
	var form_data = {
		name: $('#name').val(),
		email: $('#email').val(),
		message: $('#message').val(),
		ajax: '1'
	};	

	$.ajax({
		url: "<?php echo site_url('contact/submit'); ?>",
		type: 'POST',
		data: form_data,
		success: function(msg) {
			$('#content-wrap').html(msg);
		}
	});
	return false;
});
   
</script>