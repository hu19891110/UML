<div class="large-12 columns padding">
		<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
		<?php } ?>
	
		
		<?php if ($update_user_info == 0) { ?>
			<h2> Add a new student </h2>			
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
					<input type="submit" name="register_user" id="submit" value="Add" class="small button"/>
				
				<?php echo form_close();?>
				</div><!--large-6 columns -->
			<?php } else if($update_user_info == 1) { ?>
			<h2> Update student </h2>			
			
			<div class="large-5 columns">
			<?php echo form_open();?>  	
					
						<h3>Personal Details</h3>
						<ul>
							<li class="info_req">
								<label for="first_name">First Name:</label>
								<input type="text" id="first_name" name="update_first_name" value="<?php echo set_value('update_first_name',$update_user['upro_first_name']);?>"/>
							</li>
							<li class="info_req">
								<label for="last_name">Last Name:</label>
								<input type="text" id="last_name" name="update_last_name" value="<?php echo set_value('update_last_name',$update_user['upro_last_name']);?>"/>
							</li>
						</ul>
					
					
				
						<h3>Login Details</h3>
						<ul>
							<li class="info_req">
								<label for="email_address">Email Address:</label>
								<input type="text" id="email_address" name="update_email_address" value="<?php echo set_value('update_email_address',$update_user[$this->flexi_auth->db_column('user_acc', 'email')]);?>" class="tooltip_trigger"
									title="Set the users email address that they can use to login with."
								/>
							</li>
							<li>
								<label for="username">Username:</label>
								<input type="text" id="username" name="update_username" value="<?php echo set_value('update_username',$update_user[$this->flexi_auth->db_column('user_acc', 'username')]);?>" class="tooltip_trigger"
									title="Set the users username that they can use to login with."
								/>
							</li>
							<li>
								<label for="password">Password:</label>
								<a href="<?php echo $base_url.'dashboard/change_password/'.$update_user[$this->flexi_auth->db_column('user_acc', 'id')];?>" class="tooltip_trigger small button" title="Manage a users access privileges."> Change password</a>
							</li>
							
							<li class="info_req">
								<label for="group">Group:</label>
								<select id="group" name="update_group" class="tooltip_trigger"
									title="Set the users group, that can define them as an admin, public, moderator etc.">
								<?php foreach($groups as $group) { ?>
									<?php if ($group[$this->flexi_auth->db_column('user_group', 'id')] == $update_user[$this->flexi_auth->db_column('user_acc', 'group_id')]) {
										$group_status = "selected";
									} else {
										$group_status = NULL;
									}
									?>
									<option value="<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')];?>" <?php echo $group_status; ?>>
										<?php echo $group[$this->flexi_auth->db_column('user_group', 'name')];?>
									</option>
								<?php } ?>
								</select>
							</li>
							<li class="info_req">
								<label for="class">Student Class:</label>
								<select id="class" name="update_class" class="tooltip_trigger"
									title="Set the students class.">
								<?php foreach($classes as $class) { ?>
									<?php if ($class[$this->flexi_auth->db_column('student_class', 'id')] == $update_user[$this->flexi_auth->db_column('user_acc', 'class_id')]) {
										$class_status = "selected";
									} else {
										$class_status = NULL;
									}			
									?>
										<option value="<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>" <?php echo $class_status; ?>>
										<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
									</option>
								<?php } ?> 
								</select>
							</li>
						</ul>

								<input type="submit" name="update_users_account" id="submit" value="Save" class="small button"/>
				
			
				<?php echo form_close();?>
			</div><!--large-5 columns -->
			<?php } ?>

			<div class="users">
			<?php if ($update_user_info == 1) { ?>
			<a class="button small" href="<?php echo $base_url.'dashboard/manage_user_accounts' ?>">Add new student</a>
			<?php } ?>
			<?php echo form_open(); ?>
					<table class="responsive">
						<thead>
							<tr>
								<th class="spacer_200">Email</th>
								<th>First Name</th>
								<th>Last Name</th>
								<!-- 
								<th>User Group</th>
								<th>Times logged in </th> 
								-->
								<th>Assignments</th>
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
								<!--
								<td>
									<?php echo $user[$this->flexi_auth->db_column('user_group', 'name')];?>
								</td>
								<td>
									<?php echo $user['uacc_times_logged_in'];?>
								</td>
								-->
								<td>
								<a href="<?php echo $base_url.'dashboard/assignments_per_student/' . $user[$this->flexi_auth->db_column('user_acc', 'id')];?>">View assignments</a>
								</td>
								<td>
									<a href="<?php echo $base_url.'dashboard/manage_user_accounts/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">
									Modify
									</a>
								</td>
								<td>
									<input type="hidden" id="userID" name="userID" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>" />
									<input type="submit" name="delete_users_account" userID="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>" value="Delete" class="small button"/>
								
								</td>
							</tr>
						<?php } ?>
						</tbody>
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
			<?php echo form_close(); ?>
			</div>
					
				<?php if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_users'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } ?>
				
	
</div> <!-- end large 12 columns -->