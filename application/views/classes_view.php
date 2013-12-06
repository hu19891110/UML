<!-- Main Content -->
	<div class="large-12 columns">
	
				<div class="h2bg">
					<h2>Classes</h2>
					<h4>Manage your classes</h4>
				</div>

				<h2>Add new class</h2> 

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
		
		<?php if ($update_class_info == 0) { ?>		
				<div class="large-6 columns">
					<?php echo form_open(current_url());	?>  	
				
						<h3>Class Details</h3>
						<ul>
							<li class="info_req">
								<label for="class">Class Name:</label>
								<input type="text" id="class" name="insert_class_name" value="<?php echo set_value('insert_class_name');?>" class="tooltip_trigger"
									title="The name of the student class."/>
							</li>
							<li>
								<label for="description">Class Description:</label>
								<textarea id="description" name="insert_class_description" class="width_400 tooltip_trigger"
									title="A short description of the purpose of the student class."><?php echo set_value('insert_class_description');?></textarea>
							</li>
						</ul>
		
						<input type="submit" name="insert_student_class"id="submit" value="Add" class="button small"/>
					<br/> <br/>
				
			
				<?php echo form_close();?>
				</div> <!--large-6 columns -->
		<?php } ?>		
		
		
		<?php if ($update_class_info == 1) { ?>
			<div class="large-6 columns">
			<?php echo form_open(current_url());	?>  	
						<h3>Class Details</h3>
						<ul>
							<li class="info_req">
								<label for="class">Class Name:</label>
								<input type="text" id="class" name="update_class_name" value="<?php echo set_value('update_class_name', $class[$this->flexi_auth->db_column('student_class', 'name')]);?>" class="tooltip_trigger"
									title="The name of the user class."/>
							</li>
							<li>
								<label for="description">Class Description:</label>
								<textarea id="description" name="update_class_description" class="width_400 tooltip_trigger"
									title="A short description of the purpose of the user class."><?php echo set_value('update_class_description', $class[$this->flexi_auth->db_column('student_class', 'description')]);?></textarea>
							</li>
						</ul>					
			
					<input type="submit" name="update_student_class" id="submit" value="Save" class="button small"/>
				<?php echo form_close();?>
			
			</div>
		<?php } ?>
				
			<div class="classes large-6 columns"> 	
				<?php if ($update_class_info == 1) { ?>
				<a href="<?php echo $base_url . 'dashboard/classes/'?>" class="small button">Add new class</a>			
				<?php } ?>
				<?php echo form_open(current_url());	?>  	
					<table>
						<thead>
							<tr>
								<th class="spacer_150 tooltip_trigger" 
									title="The user group name.">
									Class Name
								</th>
								<th class="tooltip_trigger" 
									title="A short description of the purpose of the student class.">
									Class Description
								</th>
								<th class="tooltip_trigger" 
									title="A short description of the purpose of the student class.">
									List of students in class
								</th>
								<th> </th>
								<th class="spacer_100 align_ctr tooltip_trigger" 
									title="If checked, the row will be deleted upon the form being updated.">
								</th>
								
							</tr>
						</thead>
						<tbody>
						<?php foreach ($student_classes as $class) { ?>
							<tr>
								<td>
										<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
									
								</td>
								<td><?php echo $class[$this->flexi_auth->db_column('student_class', 'description')];?></td>
								<td><a href="<?php echo $base_url;?>dashboard/students_per_class/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">View list of students</a></td>
								<td>
								<a class="modify" href="<?php echo $base_url;?>dashboard/classes/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">
								Modify
								</a>
								</td>
								<td class="align_ctr">
								<?php if ($this->flexi_auth->is_admin()) { ?>
								<input type="submit" name="delete_class[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>]" value="Delete" class="delete" />
								<?php } ?>
								</td>
								
								
							</tr>
						<?php } ?>
						</tbody>
					</table>
					
				<?php echo form_close();?>
				</div>	
	</div>	