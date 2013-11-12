<div class="large-12 columns padding">

	<h2>Checking System</h2>
	
	<h3>Checking the files...</h3>
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
<?php   foreach($uploads as $upload) {
	
			echo $upload['student_id']; ?>
		
		}
	
	<?php echo $error;?>

	<?php echo form_open_multipart('assignments/do_upload');?>


</div> <!-- end large 12 columns --> 