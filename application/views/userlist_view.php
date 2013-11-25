<div class="large-12 columns padding">

			<h2> Add a new user </h2>			
			<div class="large-5 columns">
				<?php echo form_open('register/register_account'); ?>  	
					
						<h3>Personal Details</h3>
						<ul>
							<li class="info_req">
								<label for="first_name">First Name:</label>
								<input type="text" id="first_name" name="register_first_name" value="<?php echo set_value('register_first_name');?>"/>
							</li>
							<li class="info_req">
								<label for="last_name">Last Name:</label>
								<input type="text" id="last_name" name="register_last_name" value="<?php echo set_value('register_last_name');?>"/>
							</li>
						</ul>
					
					
				
					<h3>Login Details</h3>
					<ul>
						<li class="info_req">
							<label for="email_address">Email Address:</label>
							<input type="text" id="email_address" name="register_email_address" value="<?php echo set_value('register_email_address');?>" class="tooltip_trigger"
								title="This demo requires that upon registration, you will need to activate your account via clicking a link that is sent to your email address."
							/>
						</li>
						<li class="info_req">
							<label for="username">Username:</label>
							<input type="text" id="username" name="register_username" value="<?php echo set_value('register_username');?>" class="tooltip_trigger"
								title="Set a username that can be used to login with."
							/>
						</li>
							<li class="info_req">
								<label for="class">Student Class:</label>
								<select id="class" name="register_class" class="tooltip_trigger"
									title="Set the students class.">
								<?php foreach($classes as $class) { ?>
									<option value="<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>" >
										<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
									</option>
								<?php } ?>
								</select>
							</li>
						<li class="info_req">
							<label for="password">Password: <i>has been generated randomly and will be mailed to user</i></label>
							<input type="password" id="password" name="register_password" value="<?php echo set_value('register_password', random_string('alnum', 13));?>"/>
						</li>		
					</ul>
					<input type="submit" name="register_user" id="submit" value="Submit" class="small button"/>
				
				<?php echo form_close();?>
		</div><!--large-6 columns -->
	
	
	
		
					<table class="responsive">
						<thead>
							<tr>
								<th class="spacer_200">Email</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>User Group</th>
								<th>Times logged in </th>
								<th></th>
								<th></th>
								<!--
								<th class="spacer_100 align_ctr tooltip_trigger"
									title="Manage the access privileges of users.">
									User Privileges
								</th>
								<th class="spacer_100 align_ctr tooltip_trigger"
									title="If checked, the users account will be locked and they will not be able to login.">
									Account Suspended
								</th>
								<th class="spacer_100 align_ctr tooltip_trigger" 
									title="If checked, the row will be deleted upon the form being updated.">
									Delete
								</th>
								-->
								
							</tr>
						</thead>
						<?php if (!empty($users)) { ?>
						<tbody>
							<?php foreach ($users as $user) { ?>
							<tr>
								<td>
									<?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?>
								</td>
								<td>
									<?php echo $user['upro_first_name'];?>
								</td>
								<td>
									<?php echo $user['upro_last_name'];?>
								</td>
								<td>
									<?php echo $user[$this->flexi_auth->db_column('user_group', 'name')];?>
								</td>
								<td>
									<?php echo $user['uacc_times_logged_in'];?>
								</td>
								<td>
									<a href="<?php echo $base_url.'dashboard/update_user_account/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">
									Modify
									</a>
								</td>
								<td>
									<input type="submit" name="delete_users_account" id="delete" value="Delete" class="small button"/>
								
								</td>

								<!--
								<td class="align_ctr">
									<a href="<?php echo $base_url.'dashboard/update_user_privileges/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">Manage</a>
								</td>
								<td class="align_ctr">
									<input type="hidden" name="current_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'suspend')];?>"/>
									A hidden 'suspend_status[]' input is included to detect unchecked checkboxes on submit
									<input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="0"/>
								
								<?php if ($this->flexi_auth->is_privileged('Update Users')) { ?>
									<input type="checkbox" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="1" <?php echo ($user[$this->flexi_auth->db_column('user_acc', 'suspend')] == 1) ? 'checked="checked"' : "";?>/>
								<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="0"/>
								<?php } ?>
								</td>
								
								<td class="align_ctr">
								<?php if ($this->flexi_auth->is_privileged('Delete Users')) { ?>
									<input type="checkbox" name="delete_user[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="1"/>
								<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="delete_user[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="0"/>
								<?php } ?>
								</td>
								-->
							</tr>
						<?php } ?>
						</tbody>
						<!--
						<tfoot>
							<tr>
								<td colspan="7">
									<?php $disable = (! $this->flexi_auth->is_privileged('Update Users') && ! $this->flexi_auth->is_privileged('Delete Users')) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="update_users" value="Update / Delete Users" class="link_button large" <?php echo $disable; ?>/>
								</td>
							</tr>
						</tfoot>
						-->
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No users are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
					</table>
					
				<?php if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_users'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } ?>
					
	
</div> <!-- end large 12 columns -->