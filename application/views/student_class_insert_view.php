	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Insert New Student Class</h2>
				<a href="<?php echo $base_url;?>dashboard/manage_student_classes">Manage student classes</a>

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
								<input type="text" id="class" name="insert_class_name" value="<?php echo set_value('insert_class_name');?>" class="tooltip_trigger"
									title="The name of the student class."/>
							</li>
							<li>
								<label for="description">Class Description:</label>
								<textarea id="description" name="insert_class_description" class="width_400 tooltip_trigger"
									title="A short description of the purpose of the student class."><?php echo set_value('insert_class_description');?></textarea>
							</li>
						</ul>
					</fieldset>

					<fieldset>
						<legend>Insert New Student Class</legend>
						<ul>
							<li>
								<label for="submit">Insert Class:</label>
								<input type="submit" name="insert_student_class"id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
			</div>
		</div>
	</div>	