<?php if ($this->flexi_auth->is_admin()) { ?>
<!-- main content -->
<div class="large-12 columns">
		<div class="h2bg">
			<h2>Assignments</h2>
			<h4>Manage your assignments</h4>
		</div>

	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
		<?php if ($update_assignment_info == 0) { ?>
			<h2>Add new assignment</h2> 
			<div class="large-4 columns">
					<?php
					$form_name = array('name' => 'deadline');
					echo form_open(current_url(), $form_name);	?>

					<ul>
						<li>
							<label for="Description">Assignment Name: </label>
							<input type="text" id="" name="add_assignment_name" value=""/>
						</li>
						<li>
							<label for="Description">Assignment Description: </label>
							<input type="text" id="" name="add_assignment_desc" value=""/>
						</li>
						<li>

							<label for="class">Student Class:</label>

							<script type="text/javascript">
        						function toggle_all(check) {  //naam van de functie
           					 var form = document.forms['deadline']; // dit leest het formulier in <form name="deadline" ... >
            				var formelements = form.elements;
            				for(var i = 0; i < formelements.length; i++) // loop door alle elementen
                			if(formelements[i].type && formelements[i].type=='checkbox'){ // controleer per element of het een checkbox is
                    		formelements[i].checked = check; // vink checkbox aan
                			}                  // 'check' is een variabele die true (aan) of false (uit) kan zijn
        					}
   					 	</script>
							<input type="button" class="check" value="Check all" onclick="toggle_all(true);"/>
							<input type="button" class="check" value="Uncheck all" onclick="toggle_all(false);"/><br/>
							
							<table>

							<table style="width: 300px;">
								<thead>
									<tr>
										<th class="tooltip_trigger"
											title="The name of the class."/>
											Class Name
										</th>

										<th style="text-align:right;" class="spacer_150 align_ctr tooltip_trigger"

											title="If checked, the deadline will be for this class."/>
											Assign deadline
										</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($classes as $class) { ?>
									<tr>
										<td>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][id]" value="<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>"/>
											<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
										</td>
										
										<td class="align_ctr">

											<?php 
												// Define form input values.
												$current_status = 0; 
												$new_status = NULL;
											?>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="0"/>
											
											<input style="float:right;" type="checkbox" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>

										</td>
									</tr>
								<?php } ?>
								</tbody>
								</table>				
						</li> 
														 
						<li>
							<label for="End_date">End date:</label>
							<input style="width:150px;" type="text" id="datepicker" name="add_assignment_enddate" value=""/>
						</li>
						<li>
						<input type="submit" name="add_assignment" id="add_assignment" value="Add" class="small button"/>
						</li>
					</ul>
					<?php echo form_close();?>
				</div><!--large-5 columns -->
				<?php } else if($update_assignment_info == 1) { ?>
				<h2> Update assignment </h2>			
				<div class="large-4 columns">
				<?php
					$form_name = array('name' => 'deadline');
					echo form_open(current_url(), $form_name);	?>

					<ul>
						<li>
							<label for="Description">Assignment Name: </label>
							<input type="text" id="" name="update_assignment_name" value="<?php echo $update_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>"/>
						</li>
						<li>
							<label for="Description">Assignment Description: </label>
							<input type="text" id="" name="update_assignment_desc" value="<?php echo $update_assignment[$this->flexi_auth->db_column('assignment', 'desc')];?>"/>
						</li>
						<li>

							<label for="class">Student Class:</label>

							<script type="text/javascript">
        						function toggle_all(check) {  //naam van de functie
           					 var form = document.forms['deadline']; // dit leest het formulier in <form name="deadline" ... >
            				var formelements = form.elements;
            				for(var i = 0; i < formelements.length; i++) // loop door alle elementen
                			if(formelements[i].type && formelements[i].type=='checkbox'){ // controleer per element of het een checkbox is
                    		formelements[i].checked = check; // vink checkbox aan
                			}                  // 'check' is een variabele die true (aan) of false (uit) kan zijn
        					}
   					 	</script>
							<input type="button" class="check" value="Check all" onclick="toggle_all(true);"/>
							<input type="button" class="check" value="Uncheck all" onclick="toggle_all(false);"/><br/>
							
							<table>

							<table style="width: 300px;">
								<thead>
									<tr>
										<th class="tooltip_trigger"
											title="The name of the class."/>
											Class Name
										</th>

										<th style="text-align:right;" class="spacer_150 align_ctr tooltip_trigger"

											title="If checked, the deadline will be for this class."/>
											Assign deadline
										</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($classes as $class) { ?>
									<tr>
										<td>
											<input type="hidden" name="update[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][id]" value="<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>"/>
											<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
										</td>
										
										<td class="align_ctr">

											<?php 
												// Define form input values.
												// $current_status = 0;
												//$new_status = NULL;
												
												$current_status = (in_array($class[$this->flexi_auth->db_column('student_class', 'id')], $assignment_classes)) ? 1 : 0;
												
												
										$new_status = (in_array($class[$this->flexi_auth->db_column('student_class', 'id')], $assignment_classes)) ? 'checked="checked"' : NULL;
										
											?>
											<input type="hidden" name="update[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
											<input type="hidden" name="update[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="0"/>
											
											<input style="float:right;" type="checkbox" name="update[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>

										</td>
									</tr>
								<?php } ?>
								</tbody>
								</table>				
						</li> 
														 
						<li>
							<label for="End_date">End date:</label>
							<input style="width:150px;" type="text" id="datepicker" name="update_assignment_enddate" value="<?php echo $update_assignment[$this->flexi_auth->db_column('assignment', 'enddate')];?>"/>
						</li>
						<li>
						<input type="submit" name="update_assignment" id="update_assignment" value="Save" class="small button"/>
						</li>
					</ul>
				
				<?php echo form_close(); ?>
				</div>
				<?php } ?>
				
				
			<div class="assignments large-8 columns">	
				<?php if ($update_assignment_info == 1) { ?>
				<a href="<?php echo $base_url . 'dashboard/assignments/'?>" class="small button">Add new assignment</a>			
				<?php } ?>
			
				<?php echo form_open(); ?>
				<table class="tablesorter">
  				<thead>
    				<tr>
      			<th>Assignment</th>
      			<th>Deadline</th>
      			<th>Details</th>
      			<th>Upload</th>
      			<th>Check</th>
      			<th>Grades</th>
      			<th>Archive</th>
      			<th></th>
      			<th></th>
      			
    				</tr>
  				</thead>
  				<tbody>
  			
  			
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			
      			<?php
      				$current_time = date('F d, Y G:i');
						$assignment_time = $assignment['assignment_enddate'];
						$datetime2 = strtotime($assignment_time);
						$datetime1 = strtotime($current_time);
						$datediff = $datetime2 - $datetime1;
						$days_left = floor($datediff/(60*60*24)); 
      			?>
      			<tr>
	      			<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
	      			<td>
	      				<?php  
	      				$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      				echo date_format($enddate, 'd-m-Y H:i');
	      				?>
	      			</td>
	      			<td> <a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View details</a> </td>
	      			<td><a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"> Upload </a> </td>
	      			<?php if ($days_left < 0 && $assignment['assignment_checked'] == 0) { ?>
	      			<td> <a href="<?php echo $base_url.'dashboard/checkassignment/' . $assignment['assignment_id'] ?>" value="Check">Check</a> </td>
	      			<?php } else { ?>
	      			<td> </td>
	      			<?php } ?>
	      			<?php if ($assignment['assignment_checked'] == 1) { ?>
	      			<td> <a href="<?php echo $base_url . 'dashboard/grade_overview/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">Grades</a> </td>
	      			<td> <a href="<?php echo $base_url . 'dashboard/archive_assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">Archive</a></td>
	      			<?php } else { ?>
	      			<td></td>
	      			<td></td>
	      			<?php } ?>
	      			<td> <a class="modify" href="<?php echo $base_url . 'dashboard/assignments/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">Modify</a> </td>
	      			<td>
		      			<input type="hidden" id="assignmentID" name="assignmentID" value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" />
						<input type="submit" name="delete_assignment" assignmentID="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" value="Delete" class="delete"/>
		      			
	      			</td>
	      			
	      		</tr>	
      			<?php } ?>	
      			
      			</tbody>
				</table>
				
				<?php echo form_close(); ?>
				</div>
						
		</div> <!-- end 12 columns --> 		
<?php } else { ?>
<div class="large-12 columns">


	<div class="h2bg">
	<h2> Student <?php echo $user['uacc_username'];?> </h2>
	<h4> Assignments overview </h4>
	</div>	
	
	
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
		
	<table style="width: 1000px;" class="assignmentstudents responsive">
			
			<thead>
			<tr>
				<th class="nothandedin" style="width:500px;">Not handed in assignments</th> 
				<th>Upload my assignment</th>
				<th>Deadline</th>			
			</tr>
			</thead>
			
						<?php  if (!empty($not_handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($not_handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
								<a href="<?php echo $base_url.'dashboard/assignment/'.$assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"> 
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></a>
								</td>
								<td>
									
									<?php echo form_open_multipart('dashboard/do_upload');?>
										<input type="hidden" id="assignmentID" name="assignmentID" value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" />
										<input type="file" name="assignment_file" size="20" />
										<input type="submit" value="Upload" assignmentID="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" class = "small button"/>
										</form>
								
								</td>
								<td>
									<?php 
									$current_time = date('F d, Y G:i');
									$assignment_time = $assignment['assignment_enddate'];
									$datetime2 = strtotime($assignment_time);
									$datetime1 = strtotime($current_time);
									$datediff = $datetime2 - $datetime1;
									$days_left = floor($datediff/(60*60*24)); 
									
									if ($days_left < 0) {
										$days_left = -$days_left;				
										?>
										<p class="red"> <?php echo date('F d, Y G:i', strtotime($assignment_time)) . ' , ' . $days_left . ' days ago.';?></p>
										<?php
									} else {
										?>
										<p> <?php echo date('F d, Y G:i', strtotime($assignment_time)) . ' , ' . $days_left . ' days left.'; ?> </p>
										<?php
									}
									?> 
									</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php }  ?>	
	</table>
										
			
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th style="width:500px;" class="handedin">Handed in assignments</th>
				<th>Date handed in</th>			
			</tr>
			</thead>
					<?php if  (!empty($handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td>
									<a href="<?php echo $base_url.'dashboard/assignment/'.$assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"> 
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></a>
								</td>
								
								<td>
									<?php
									$assignment_id = $assignment[$this->flexi_auth->db_column('assignment', 'id')];
									$student_id = $user['uacc_id'];
									$date = $this->flexi_auth->get_upload_date_time($assignment_id, $student_id);
									$upload_id = $this->flexi_auth->get_upload_id($assignment_id, $student_id);
									$late = $this->flexi_auth->upload_too_late($upload_id, $assignment_id);
									if ($late > 0) {
										?>
										<p class="red"> <?php echo date('F d, Y G:i', strtotime($date)) . ' , ' . $late . ' days late.';?></p>
										<?php
									} else {
										?>
										<p> <?php echo date('F d, Y G:i', strtotime($date)); ?> </p>
										<?php
									}
									?>

								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
	</table>		
	

			
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th style="width:500px;">Checked assignments</th>
				<th> Mistakes & grade </th>
							
			</tr>
			</thead>
					<?php  if (!empty($checked_assignments)) { ?>
						<tbody>
							<?php foreach ($checked_assignments as $checked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
									<?php echo $checked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								
								<td style="width: 500px;">
									<a href="<?php echo $base_url.'dashboard/checked_assignment_per_student/'.$checked_assignment[$this->flexi_auth->db_column('assignment', 'id')].'/' .$user['uacc_id'];?>"> 
									View details
									</a> 
								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php }  ?>
	</table>				
	
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th style="width:500px;">Not checked assignments</th>
						
			</tr>
			</thead>
					<?php  if (!empty($notchecked_assignments)) { ?>
						<tbody>
							<?php foreach ($notchecked_assignments as $notchecked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
		
								<?php echo $notchecked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								 
								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php }  ?>
	</table>		
		
</div>
<?php } ?>