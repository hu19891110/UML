<!-- main content -->
<div class="large-12 columns">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
		
				<div class="h2bg" style="height: 70px !important;">
					<h2><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h2>
					<h4>Assignment details</h4>
				</div>
				
				<h3> Description: </h3><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?>
				<h3> Date of deadline: </h3> 
					<?php $enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      		echo date_format($enddate, 'd-m-Y H:i'); ?>
	      		<?php $already_checked = $this->flexi_auth->answers_already_checked($currentuser['uacc_id'], $assignment[$this->flexi_auth->db_column('assignment', 'id')]); ?>
	      		<?php if (!$already_checked) { ?>
	      		<h3>Upload your answers</h3>
	      		<?php $already_uploaded = $this->flexi_auth->answers_already_uploaded($currentuser['uacc_id'], $assignment[$this->flexi_auth->db_column('assignment', 'id')]); ?>
	      		<?php if ($already_uploaded) { ?>
	      		<p>You have already uploaded answers for this assignment. Uploading another file will overwrite your previous answers. </p>
	      		<?php } ?>
	      		<?php echo form_open_multipart('dashboard/do_upload');?>
				<input type="hidden" id="assignmentID" name="assignmentID" value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" />
				<input type="file" name="assignment_file" size="20" />
				<br />
				<input type="submit" value="Upload" assignmentID="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" class = "small button"/>
				</form>
				<?php } ?>
									


</div> <!-- end 12 columns --> 