<?php if ($this->flexi_auth->is_admin()) { ?>

<!-- main content -->
<div class="large-12 columns">
	
		
				<div class="h2bg" style="height: 85px !important;">
					<h2><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h2>
					<h4>Assignment details</h4>
					<a href="<?php echo $refered_from; ?>">Back</a> 
				</div>
				<?php if (! empty($message)) { ?>
					<div id="message">
						<?php echo $message; ?>
					</div>
				<?php } ?>
				
			<div class="large-6 columns">		
				<h3> Description of the assignment:</h3> <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?> 
				<h3>Date of deadline:</h3>
					<?php  
	      			$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      			echo date_format($enddate, 'd-m-Y H:i');
	      		?>
				
				
				<h3>Assignment classes: </h3>
				<?php 
				
					$i = 0;
					$numItems = count($assignment_classes);
					
					foreach ($assignment_classes as $assignment_class) {
						$class_id = $assignment_class;
						$class_name = $this->flexi_auth->get_classname_for_class_id($class_id);
						
						$i++;
						
						if ($i == $numItems)
							echo $class_name, '. ';	
						else
							echo $class_name, ', ';
					}
				
				?>
				
				<!-- <?php echo $class_names[$this->flexi_auth->db_column('student_classes', 'studentclass_name')];?> -->
			
				
				
				<?php $checked = ($assignment[$this->flexi_auth->db_column('assignment', 'checked')] == 1) ? 'Yes' : 'No'; ?>
				<h3> Is the assignment already checked? </h3> <?php echo $checked;?>
					
				<?php if($checked == 'No') { ?>	
				<br/> <br/>			
					<a class="small button" href="<?php echo $base_url . 'dashboard/checkassignment/' . $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">Check assignment </a>
				<?php } ?>	
			</div>	
				
			<div class="large-6 columns">	
				<?php $archived = $assignment['assignment_archief']; ?>
	      		<?php if ($archived == 0) { ?>
						<h3>Upload correction model</h3>				
						<?php echo form_open_multipart('dashboard/do_upload');?>
						<input type="file" name="assignment_file" size="20">
						<input type="hidden" id="assignmentID" name="assignmentID" value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" />
						<input type="submit" value="Upload" class="small button"> 
				<?php echo form_close(); ?>
				<?php } ?>
			</div>	

</div> <!-- end 12 columns --> 

<?php } else { ?>
	
<!-- main content -->
<div class="large-12 columns">

		
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
	
		
				<div class="h2bg" style="height: 85px !important;">
					<h2><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h2>
					<h4>Assignment details</h4>
					<a href="<?php echo $refered_from; ?>">Back</a> 
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

<?php } ?>