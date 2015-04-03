<div class="row section-head">

	<div class="twelve columns">
	
<?php echo validation_errors(); ?> 
<?php echo form_open('captcha'); ?>
<p>
  <label for="name">Name:
    <input id="name" name="name" type="text" />
  </label>
</p>
<?php echo $image; ?>
<p>
  <label for="name">Captcha:
    <input id="captcha" name="captcha" type="text" />
  </label>
</p>
<?php echo form_submit("submit", "Submit"); ?> 
<?php echo form_close(); ?>

</div>
</div>