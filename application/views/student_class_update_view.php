<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Update User Class</h2>
				<a href="<?php echo $base_url;?>dashboard/manage_student_classes">Manage User classes</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<fieldset>
						<legend>Class Details</legend>
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
					</fieldset>
					<fieldset>
						<legend>Add/Remove students</legend>
						<ul>
							<li>
								<a href="<?php echo $base_url;?>dashboard/add_student_to_class/<?php echo $class_id; ?>">Add/remove students</a>
								
							</li>
						</ul>
					</fieldset>				
					<fieldset>
						<legend>Update Class Details</legend>
						<ul>
							<li>
								<label for="submit">Update Class:</label>
								<input type="submit" name="update_student_class" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
	</div>	