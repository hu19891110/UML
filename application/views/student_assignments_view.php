<div class="large-12 columns padding">

	<h2>Upload Assignment</h2>
	
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>

	<?php echo $error;?>

	<?php echo form_open_multipart('upload/do_upload');?>

	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="upload" />

	</form>

</div> <!-- end large 12 columns --> 