<!-- Main Content -->
	<div class="large-12 columns padding">
			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
			
				<?php echo form_open(current_url());	?>  	
					<table>
						<thead>
							<tr>
								<th class="tooltip_trigger"
									title="The name of the user."/>
									Username
								</th>
								<th class="tooltip_trigger"
									title="A short description of the purpose of the user."/>
									Email
								</th>
								<th class="spacer_150 align_ctr tooltip_trigger"
									title="If checked, the user will be granted the user."/>
									Class member
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($users as $user) { ?>
							<tr>
								<td>
									<input type="hidden" name="id" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>"/>
									<a href="<?php echo $base_url;?>dashboard/update_user_account/<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>">
									<?php echo $user[$this->flexi_auth->db_column('user_acc', 'username')];?>
									</a>
									
								</td>
								<td><?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?></td>
								
								<td class="align_ctr">
										<?php
										// Define form input values.
										$current_status = (in_array($user[$this->flexi_auth->db_column('user_acc', 'id')], $class_users)) ? 1 : 0; 
									
										$action_button = ($current_status == 0) ? '<input type="submit" name="add_student'.$user[$this->flexi_auth->db_column('user_acc', 'id')].'" value="Add student" />' : '<input type="submit" name="remove_student'.$user[$this->flexi_auth->db_column('user_acc', 'id')].'" value="Remove student"/>' ;
										?>
								<?php echo $action_button; ?>
								</td>
							</tr>
						<?php }  ?>
						</tbody>
						<?/*
						<tfoot>
							<tr>
								<td colspan="3">
									<input type="submit" name="update_class_user" value="Update Class Students" class="link_button large"/>
								</td>
							</tr>
						</tfoot>
						*/?>
					</table>					
				<?php echo form_close();?>
	</div>