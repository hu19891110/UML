<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Manage Student Classes</h2> 

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
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
								<th class="spacer_100 align_ctr tooltip_trigger" 
									title="If checked, the row will be deleted upon the form being updated.">
									Delete
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($student_classes as $class) { ?>
							<tr>
								<td>
									<a href="<?php echo $base_url;?>dashboard/update_student_class/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">
										<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
									</a>
								</td>
								<td><?php echo $class[$this->flexi_auth->db_column('student_class', 'description')];?></td>
								<td><a href="<?php echo $base_url;?>dashboard/students_per_class/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">View list of students</a></td>
								<td class="align_ctr">
								<?php if ($this->flexi_auth->is_privileged('Delete Student Class')) { ?>
									<input type="checkbox" name="delete_class[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>]" value="1"/>
								<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="delete_class[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>]" value="0"/>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<td colspan="5">
								<a href="<?php echo $base_url;?>dashboard/insert_student_class" class="button medium">Insert New Student Class</a>
								<?php $disable = (! $this->flexi_auth->is_privileged('Update Student Class') && ! $this->flexi_auth->is_privileged('Delete Student Class')) ? 'disabled="disabled"' : NULL;?>
								<input type="submit" name="submit" value="Delete Checked Student Classes" class="button" <?php echo $disable; ?>/>
							</td>
						</tfoot>
					</table>
					
						
					
				<?php echo form_close();?>
	</div>	