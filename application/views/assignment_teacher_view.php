<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
		
				
				<h3><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h3>
				<p> <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?> </p>
				<p> Enddate and time: <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'enddate')];?></p>
				<?php $checked = ($assignment[$this->flexi_auth->db_column('assignment', 'checked')] == 1) ? 'Yes' : 'No';  ?>
				<p> Checked? : <?php echo $checked;?></p>
					
				<?php if($checked == 'No'){ ?>	
		<a href="<?php echo $base_url . 'dashboard/checker/';?>"> --> Check assignment </a>
				<?php } ?>	
				<br/><br/>
				<h3>Upload correction model</h3>				
				<?php echo form_open_multipart('assignments/do_upload');?>
			<input type="file" name="userfile" size="20"> <br/> <br/>
			<input type="submit" name="add_answer_sheet" value="Upload correction model" class="small button"> <br/> <br/>

</div> <!-- end 12 columns --> 