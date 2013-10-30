	<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Insert New Student Class</h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
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
		
						<input type="submit" name="insert_student_class"id="submit" value="Insert new student class" class="button small"/>
					<br/> <br/>
					<a href="<?php echo $base_url;?>dashboard/manage_student_classes">Manage student classes</a>
			
				<?php echo form_close();?>
	</div>	