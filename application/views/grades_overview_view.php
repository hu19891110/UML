<!-- Main Content -->
	<div class="large-12 columns padding">
				<h2>List of grades for <?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?></h2> 

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
									title="The assignment ID">
									Assignment #
								</th>
								<th class="tooltip_trigger" 
									title="Date of deadline">
									Date
								</th>
								<th class="tooltip_trigger" 
									title="Grade">
									Grade
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($grades as $grade) { 
							if (in_array($grade[$this->flexi_auth->db_column('uploads', 'grade')], $class_users)) { ?>
							<tr>
								<td><?php echo $grade[this->flexi_auth->db_column('deadlines', 'deadline_enddate')];?></td>
								
								<td><?php echo $grade[$this->flexi_auth->db_column('deadlines', 'grade')];?></td>
							</tr>
							<?php } ?>
						<?php } ?>	
						</tbody>
					</table>	

					
				<?php echo form_close();?>
	</div>	