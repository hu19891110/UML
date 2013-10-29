<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
			
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
									<input type="hidden" name="update[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>][id]" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>"/>
									<?php echo $user[$this->flexi_auth->db_column('user_acc', 'username')];?>
									
								</td>
								<td><?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?></td>
								
								<td class="align_ctr">
										<?php
										// Define form input values.
										$current_status = (in_array($user[$this->flexi_auth->db_column('user_acc', 'id')], $class_users)) ? 1 : 0; 
										$new_status = (in_array($user[$this->flexi_auth->db_column('user_acc', 'id')], $class_users)) ? 'checked="checked"' : NULL;
									?>

									<input type="hidden" name="update[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
									<input type="hidden" name="update[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>][new_status]" value="0"/> 
									<input type="checkbox" name="update[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>][new_status]" value="<?php echo $current_status ?>" <?php echo $new_status ?>/>
								</td>
							</tr>
						<?php }  ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<input type="submit" name="update_class_user" value="Update Class Students" class="link_button large"/>
								</td>
							</tr>
						</tfoot>
					</table>					
				<?php echo form_close();?>
			</div>
		</div>
	</div>	