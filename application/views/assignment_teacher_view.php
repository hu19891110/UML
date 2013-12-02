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
			
				
				
				<?php $checked = ($assignment[$this->flexi_auth->db_column('assignment', 'checked')] == 1) ? 'Yes' : 'No';  ?>
				<h3> Is the assignment already checked? </h3> <?php echo $checked;?>
					
				<?php if($checked == 'No'){ ?>	
	<br/> <br/>			
		<a class="small button" href="<?php echo $base_url . 'dashboard/checker/';?>">Check assignment </a>
				<?php } ?>	
				<br/><br/>
				<h3>Upload correction model</h3>				
				<?php echo form_open_multipart('assignments/do_upload');?>
			<input type="file" name="userfile" size="20"> <br/> <br/>
			<input type="submit" name="add_answer_sheet" value="Upload" class="small button"> <br/> <br/>

</div> <!-- end 12 columns --> 