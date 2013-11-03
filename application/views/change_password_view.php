	<div class="large-12 columns padding">
	
	<!-- Main Content -->

				<h2>Change Password</h2>
				

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<div class="w100 frame">
						<ul>
							<li>
								
							</li>
							<li class="info_req">
								<label for="current_password">Current Password:</label>
								<input type="password" id="current_password" name="current_password" value="<?php echo set_value('current_password');?>"/>
							</li>
							<li class="info_req">
								<label for="new_password">New Password:</label>
								<input type="password" id="new_password" name="new_password" value="<?php echo set_value('new_password');?>"/>
							</li>
							<li class="info_req">
								<label for="confirm_new_password">Confirm New Password:</label>
								<input type="password" id="confirm_new_password" name="confirm_new_password" value="<?php echo set_value('confirm_new_password');?>"/>
							</li>
							<li>
								<input type="submit" name="change_password" id="submit" value="Submit" class="button small"/>
							</li>
						</ul>
					</div>
				<?php echo form_close();?>
	
	</div>	