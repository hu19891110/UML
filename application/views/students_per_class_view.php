<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>Students per Class</h2> 

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
									title="The user group name.">
									Class Name
								</th>
								<th class="tooltip_trigger" 
									title="Student name in class">
									Student name
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($student_classes as $class) { ?>
							<tr>
								<td>
									<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
								</td>
								<td>

							<?php if($class[$this->flexi_auth->db_column('student_class', 'id')] == $users[$this->flexi_auth->db_column('user_acc', 'class_fk')]) 							
							
								 echo $users[$this->flexi_auth->db_column('user_acc', 'username')]; ?>
								
								</td>
							</tr>
						<?php } ?>	
						</tbody>
					</table>	

					
				<?php echo form_close();?>
	</div>	