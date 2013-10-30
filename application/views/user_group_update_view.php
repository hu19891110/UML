<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Update User Group</h2>
				<a href="<?php echo $base_url;?>dashboard/manage_user_groups">Manage User Groups</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<fieldset>
						<legend>Group Details</legend>
						<ul>
							<li class="info_req">
								<label for="group">Group Name:</label>
								<input type="text" id="group" name="update_group_name" value="<?php echo set_value('update_group_name', $group[$this->flexi_auth->db_column('user_group', 'name')]);?>" class="tooltip_trigger"
									title="The name of the user group."/>
							</li>
							<li>
								<label for="description">Group Description:</label>
								<textarea id="description" name="update_group_description" class="width_400 tooltip_trigger"
									title="A short description of the purpose of the user group."><?php echo set_value('update_group_description', $group[$this->flexi_auth->db_column('user_group', 'description')]);?></textarea>
							</li>
							<li>
								<?php $ugrp_admin = ($group[$this->flexi_auth->db_column('user_group', 'admin')] == 1) ;?>
								<label for="admin">Is Admin Group:</label>
								<input type="checkbox" id="admin" name="update_group_admin" value="1" <?php echo set_checkbox('update_group_admin', 1, $ugrp_admin);?> class="tooltip_trigger"
									title="If checked, the user group is set as an 'Admin' group."/>
							</li>
							<li>
								<label for="admin">User Group Privileges:</label>
								<a href="<?php echo $base_url;?>dashboard/update_group_privileges/<?php echo $group['ugrp_id']; ?>">Manage Privileges for this User Group</a>
							</li>
						</ul>
					</fieldset>
									
					<fieldset>
						<legend>Update Group Details</legend>
						<ul>
							<li>
								<label for="submit">Update Group:</label>
								<input type="submit" name="update_user_group" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
	</div>	