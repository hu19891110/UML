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
				<p> <b> Description of the assignment:</b> <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?> </p>
				<p> <b>Enddate and time:</b> 
					<?php  
	      			$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      			echo date_format($enddate, 'd-m-Y H:i:s');
	      		?>
				</p>
				<p>
				Assignment classes: 
				<?php 
				
					foreach ($assignment_classes as $assignment_class) {
						$class_id = $assignment_classes[$this->flexi_auth->db_column('class_assignments', 'id')];
						$class_name = $this->flexi_auth->get_classname_for_class_id($class_id);
						echo $class_name;
					}
					
				?>
				
				<!-- <?php echo $class_names[$this->flexi_auth->db_column('student_classes', 'studentclass_name')];?> -->
				</p>
				
				
				<?php $checked = ($assignment[$this->flexi_auth->db_column('assignment', 'checked')] == 1) ? 'Yes' : 'No';  ?>
				<p> <b> Is the assignment already checked? </b> : <?php echo $checked;?></p>
					
				<?php if($checked == 'No'){ ?>	
		<a class="small button" href="<?php echo $base_url . 'dashboard/checker/';?>">Check assignment </a>
				<?php } ?>	
				<br/><br/>
				<h3>Upload correction model</h3>				
				<?php echo form_open_multipart('assignments/do_upload');?>
			<input type="file" name="userfile" size="20"> <br/> <br/>
			<input type="submit" name="add_answer_sheet" value="Upload" class="small button"> <br/> <br/>

</div> <!-- end 12 columns --> 