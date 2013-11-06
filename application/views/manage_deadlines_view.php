<<<<<<< HEAD
<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
				
	<div id="mainwrapper">	
	<!--	
		<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/assignments.jpg"/>
		<a href="<?php echo site_url('assignments') ?>"><span class="caption scale-caption">
			<h3></h3>
			<p> Upload test answers <br/>
			Get an overview of uploaded assignments <br/>
			Mark assignments as checked</p>
		</span></a>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/deadlines.jpg"/>
		<span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/archive.jpg"/>
		<span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/register.jpg"/>
		<a href="<?php echo site_url('register') ?>"><span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span></a>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/userdetails.jpg"/>
		<a href="<?php echo $base_url;?>dashboard/update_user_account/<?php echo $currentuser['uacc_id']; ?>">
		<span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span>
		</div> -->
	
			
		<div class="row">			
				
				<table id="asstocheck" class="large-4 columns margin-left">
  				<thead>
    				<tr>
      			<th colspan="2" style="text-align: center;">Upcoming deadlines</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Deadline</th>
      			<th>Date of deadline</th>
    			</tr>
      			<?php 
      			foreach ($deadlines as $deadline)
      			{ ?>
      			<tr>
	      			<td><a href="<?php echo $base_url . 'dashboard/deadline/'. $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></a></td>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></td>
	      		</tr>	
      			<?php } ?>		
      			</tbody>
				</table>
				
				<div class="large-3 columns margin-left deadline">
					<h3> Add a new deadline </h3>

=======
<!-- Main Content -->
	<div class="large-12 columns">
				<h2>Manage deadlines</h2> 

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>

		<div class="large-6 columns">
			<h3> Add a new deadline </h3>
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
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
							
<<<<<<< HEAD
							<table>
=======
							<table style="width: 300px;">
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
								<thead>
									<tr>
										<th class="tooltip_trigger"
											title="The name of the class."/>
											Class Name
										</th>
<<<<<<< HEAD
										<th class="spacer_150 align_ctr tooltip_trigger"
=======
										<th style="text-align:right;" class="spacer_150 align_ctr tooltip_trigger"
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
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
<<<<<<< HEAD
										<td class="align_ctr">
=======
										<td>
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
											<?php 
												// Define form input values.
												$current_status = 0; 
												$new_status = NULL;
											?>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="0"/>
<<<<<<< HEAD
											<input type="checkbox" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>
=======
											<input style="float:right;" type="checkbox" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
										</td>
									</tr>
								<?php } ?>
								</tbody>
								</table>				
						</li> 
<<<<<<< HEAD
								</table>					
						</li> 
						<li>
							<label for="End_date">End date:</label>
							<input type="text" id="datepicker" name="add_deadline_enddate" value=""/>
=======
								 
						<li>
							<label for="End_date">End date:</label>
							<input style="width:150px;" type="text" id="datepicker" name="add_deadline_enddate" value=""/>
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
						</li>
						<li>
						<input type="submit" name="add_deadline" id="add_deadline" value="Add Deadline" class="small button"/>
						</li>
					</ul>
					<?php echo form_close();?>
<<<<<<< HEAD
					

				</div><!--large-3 columns -->
					
				
				</div> <!-- row -->			
			</div> <!-- mainwrapper --> 	
				
		</div> <!-- end 12 columns --> 
=======
		</div>		
				
				
				
				<table id="asstocheck" class="large-5 columns" style="max-width: 800px;">
  				<thead>
    				<tr>
      			<th colspan="3" style="text-align: center;">Upcoming deadlines</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Deadline</th>
      			<th>Date of deadline</th>
      			<th title="If checked, the row will be deleted upon the form being updated.">
					Delete
					</th>
    			</tr>
      			<?php 
      			foreach ($deadlines as $deadline)
      			{ ?>
      			<tr>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></td>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></td>
	      			<td>
	      			<input type="checkbox" name="delete_deadline[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>]" value="1"/>
	      			</td>
	      		</tr>	
      			<?php } ?>		
      			</tbody>
      			<tfoot>
						<td colspan="3">
							
							<input type="submit" name="submit" value="Delete Checked Deadlines" class="button" ?>
						</td>
					</tfoot>
				</table>
						
					
			
	</div><!-- end large 12 columns -->
>>>>>>> 5807679d960db51d4ee93f669634bc889f8a50c5
