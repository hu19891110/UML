	<div class="large-12 columns padding">
				<h2>Account of <?php echo $user['upro_first_name'].' '.$user['upro_last_name']; ?></h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());?>  	
					
						<h3>Personal Details</h3>
						<ul>
							<li class="info_req">
								<label for="first_name">First Name:</label>
								<input type="text" id="first_name" name="update_first_name" value="<?php echo set_value('update_first_name',$user['upro_first_name']);?>"/>
							</li>
							<li class="info_req">
								<label for="last_name">Last Name:</label>
								<input type="text" id="last_name" name="update_last_name" value="<?php echo set_value('update_last_name',$user['upro_last_name']);?>"/>
							</li>
						</ul>
					
					
				
						<h3>Login Details</h3>
						<ul>
							<li class="info_req">
								<label for="email_address">Email Address:</label>
								<input type="text" id="email_address" name="update_email_address" value="<?php echo set_value('update_email_address',$user[$this->flexi_auth->db_column('user_acc', 'email')]);?>" class="tooltip_trigger"
									title="Set the users email address that they can use to login with."
								/>
							</li>
							<li>
								<label for="username">Username:</label>
								<input type="text" id="username" name="update_username" value="<?php echo set_value('update_username',$user[$this->flexi_auth->db_column('user_acc', 'username')]);?>" class="tooltip_trigger"
									title="Set the users username that they can use to login with."
								/>
							</li>
							<li>
								<label for="password">Password:</label>
								<a href="<?php echo $base_url.'dashboard/change_password/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>" class="tooltip_trigger small button" title="Manage a users access privileges."> Change password</a>
							</li>
							
							<?php if ($this->flexi_auth->is_admin()) { ?>
							<? if ($user['uacc_id'] != $currentuser['uacc_id']) { ?>
							<li class="info_req">
								<label for="class">Student Class:</label>
								<select id="class" name="update_class" class="tooltip_trigger"
									title="Set the students class.">
								<?php foreach($classes as $class) { ?>
									<?php $student_class = ($class[$this->flexi_auth->db_column('student_class', 'id')] == $user[$this->flexi_auth->db_column('user_acc', 'class_id')]) ? TRUE : FALSE;?>
									<option value="<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>" <?php echo set_select('update_class', $class[$this->flexi_auth->db_column('student_class', 'id')], $student_class);?>>
										<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
									</option>
								<?php } ?>
								</select>
							</li>
							<?php } ?>
						</ul>
						
						<?php } ?>

						<input type="submit" name="update_users_account" id="submit" value="Save" class="small button"/>								
						<input type="submit" name="delete_users_account" id="delete" value="Delete" class="small button"/>
			
			
				<?php echo form_close();?>
	</div> <!-- end large 12 columns -->