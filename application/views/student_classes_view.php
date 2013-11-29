<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Manage Student Classes</h2> 

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
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
				
				
			<div class="classes large-6 columns"> 	
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
								<a href="<?php echo $base_url;?>dashboard/update_student_class/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">
								Modify
								</a>
								</td>
								<td class="align_ctr">
								<?php if ($this->flexi_auth->is_privileged('Delete Student Class')) { ?>
								<input type="submit" name="delete_class[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>]" value="Delete" class="button" />
								<?php } ?>
								<!-- 
									<?php if ($this->flexi_auth->is_privileged('Delete Student Class')) { ?>
									<input type="checkbox" name="delete_class[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>]" value="1"/>
									
									<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="delete_class[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>]" value="0"/>
								<?php } ?>
								-->
								</td>
								
								
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<td colspan="5">
							<!--
								<?php $disable = (! $this->flexi_auth->is_privileged('Update Student Class') && ! $this->flexi_auth->is_privileged('Delete Student Class')) ? 'disabled="disabled"' : NULL;?>
								<input type="submit" name="submit" value="Delete Checked Student Classes" class="button" <?php echo $disable; ?>/>
							-->
							</td>
						</tfoot>
					</table>
					
				<?php echo form_close();?>
				</div>	
	</div>	