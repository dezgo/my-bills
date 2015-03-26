      <div class="row">

      	<div class="twelve columns">

<h2>Create Account</h2>

<?php echo $error;?>

<?php echo form_open_multipart(base_url().'index.php/payments/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Upload" />

</form>

</div>
</div>