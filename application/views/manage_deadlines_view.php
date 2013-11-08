<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
<h2>Manage deadlines</h2> 

			<div class="large-6 columns">
			<h3> Add a new deadline </h3>
					<?php
					$form_name = array('name' => 'deadline');
					echo form_open(current_url(), $form_name);	?>

					<ul>
						<li>
							<label for="Description"> Description: </label>
							<input type="text" id="" name="add_deadline_desc" value=""/>
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
							<input style="width:150px;" type="text" id="datepicker" name="add_deadline_enddate" value=""/>
						</li>
						<li>
						<input type="submit" name="add_deadline" id="add_deadline" value="Add Deadline" class="small button"/>
						</li>
					</ul>
					<?php echo form_close();?>
				</div><!--large-6 columns -->
			
				<?php echo form_open(current_url()); ?>
				<table id="asstocheck" class="large-5 columns" style="max-width:800px;">
  				<thead>
    				<tr>
      			<th colspan="3" style="text-align: center;">Upcoming deadlines</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Deadline</th>
      			<th>Date of deadline</th>
      			<th>Delete deadline</th>
    			</tr>
      			<?php 
      			foreach ($deadlines as $deadline)
      			{ ?>
      			<tr>
	      			<td><input type="hidden" name="delete[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][id]" value="<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"/>
	      			<a href="<?php echo $base_url . 'dashboard/deadline/'. $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></a></td>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></td>
	      			<td>
	      			<?php 
						// Define form input values.
						$current_status = 0; 
						$new_status = NULL;
					?>
	      			
	      			<input type="hidden" name="delete[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
					<input type="hidden" name="delete[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][new_status]" value="0"/>
											
					<input style="float:right;" type="checkbox" name="delete[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/></td>
	      		</tr>
	      		
      			<?php } ?>		
      			</tbody>
      			<tfoot>
      				<tr><td colspan="3">
      				<input type="submit" name="delete_deadline" id="add_deadline" value="Delete Checked deadlines" class="small button"/>
      				</td></tr>	
      			</tfoot>
				</table>
				<?php echo form_close(); ?>
										
				
		</div> <!-- end 12 columns --> 		
