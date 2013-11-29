<!-- main content -->
<div class="large-12 columns padding">
	
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
		<?php if ($update_assignment_info == 0) { ?>
			<h2>Add new assignment</h2> 
			<div class="large-5 columns">
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
				<div class="large-5 columns">
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
				
				
			<div class="assignments large-7 columns">	
				<?php if ($update_assignment_info == 1) { ?>
				<a href="<?php echo $base_url . 'dashboard/assignments/'?>" class="small button">Add new assignment</a>			
				<?php } ?>
			
				<?php echo form_open(); ?>
				<table class="tablesorter">
  				<thead>
    				<tr>
      			<th>Assignment</th>
      			<th>Deadline of assignment</th>
      			<th>View details</th>
      			<th></th>
      			<th></th>
    				</tr>
  				</thead>
  				<tbody>
  			
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			<tr>
	      			<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
	      			<td>
	      				<?php  
	      				$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      				echo date_format($enddate, 'd-m-Y H:i:s');
	      				?>
	      			</td>
	      			<td> <a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View details</a> </td>
	      			<td> <a href="<?php echo $base_url . 'dashboard/assignments/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">Modify</a> </td>
	      			<td>
		      			<input type="hidden" id="assignmentID" name="assignmentID" value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" />
						<input type="submit" name="delete_assignment" assignmentID="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" value="Delete" class="small button"/>
		      			
	      			</td>
	      			
	      		</tr>	
      			<?php } ?>	
      			
      			</tbody>
				</table>
				
				<?php echo form_close(); ?>
				</div>
						
		</div> <!-- end 12 columns --> 		
