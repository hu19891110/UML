	<div class="large-12 columns padding">
				<h2>Update Privilege</h2>
				<a href="<?php echo $base_url;?>dashboard/manage_privileges">Manage Privileges</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<fieldset>
						<legend>Privilege Details</legend>
						<ul>
							<li class="info_req">
								<label for="privilege">Privilege Name:</label>
								<input type="text" id="privilege" name="update_privilege_name" value="<?php echo set_value('update_privilege_name', $privilege[$this->flexi_auth->db_column('user_privileges', 'name')]);?>" class="tooltip_trigger"
									title="The name of the privilege."
								/>
							</li>
							<li>
								<label for="description">Privilege Description:</label>
								<textarea id="description" name="update_privilege_description" class="width_400 tooltip_trigger"
									title="A short description of the purpose of the privilege."><?php echo set_value('update_privilege_description', $privilege[$this->flexi_auth->db_column('user_privileges', 'description')]);?></textarea>
							</li>
						</ul>
					</fieldset>
									
					<fieldset>
						<legend>Update Privilege Details</legend>
						<ul>
							<li>
								<label for="submit">Update Privilege:</label>
								<input type="submit" name="update_privilege" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
	</div>	