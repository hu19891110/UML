<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Studentlist for <?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?></h2> 

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
									title="Student first name">
									Student Username
								</th>
								<th class="tooltip_trigger" 
									title="Student last name">
									Student Email
								</th>
								<th class="tooltip_trigger" 
									title="Student last name">
									Update user account
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($users as $user) { 
							if (in_array($user[$this->flexi_auth->db_column('user_acc', 'id')], $class_users)) { ?>
							<tr>
								<td><?php echo $user[$this->flexi_auth->db_column('user_acc', 'username')];?></td>
								
								<td><?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?></td>
								
								<td><a href="<?php echo $base_url.'dashboard/update_user_account/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">Update</a>
							</tr>
							<?php } ?>
						<?php } ?>	
						</tbody>
					</table>	

					
				<?php echo form_close();?>
				<a class="button small" href="<?php echo $base_url.'dashboard/manage_student_classes' ?>">Back</a>
	</div>	