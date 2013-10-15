<div class="large-12 columns padding">

	<h2>Assignments Overview</h2>
	
	<h3>Upload assignment</h3>
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>

	<?php echo $error;?>

	<?php echo form_open_multipart('upload/do_upload');?>

	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="Upload" class = "small button"/>

	</form>

</div> <!-- end large 12 columns --> 