<!-- Main Content -->
	<div class="large-12 columns">
	
				<div class="h2bg" style="height: 85px !important;">
					<h2>Studentlist</h2>
					<h4>for <?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?></h4>
					<a href="<?php echo $refered_from; ?>">Back</a> 
				</div>
				<h2></h2> 

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
									Username
								</th>
								<th class="tooltip_trigger" 
									title="Student last name">
									Email
								</th>
								<th class="tooltip_trigger" 
									title="Student last name">
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($users as $user) { 
							if (in_array($user[$this->flexi_auth->db_column('user_acc', 'id')], $class_users)) { ?>
							<tr>
								<td><?php echo $user[$this->flexi_auth->db_column('user_acc', 'username')];?></td>
								
								<td><?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?></td>
								
								<td><a class="modify" href="<?php echo $base_url.'dashboard/users/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">Update</a>
							</tr>
							<?php } ?>
						<?php } ?>	
						</tbody>
					</table>	

					
				<?php echo form_close();?>
	</div>	