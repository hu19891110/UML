<div class="large-12 columns">


	<div class="h2bg">
	<h2> Student <?php echo $user['uacc_username'];?> </h2>
	<h4> Assignments overview </h4>
	</div>	
	
	
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
		
	<table style="width: 1000px;" class="assignmentstudents responsive">
			
			<thead>
			<tr>
				<th class="nothandedin" style="width:500px;">Not handed in assignments</th> 
				<th>Upload my assignment</th>
				<th>Deadline</th>			
			</tr>
			</thead>
			
						<?php  if (!empty($not_handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($not_handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								<td>
									
									<?php echo form_open_multipart('dashboard/do_upload');?>
										<input type="file" name="assignment_file" size="200" />
										<input type="hidden" id="assignmentID" name="assignmentID" value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" />
										<input type="submit" value="Upload" assignmentID="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" class = "small button"/>
										<?php form_close(); ?>
								
								</td>
								<td>
									<?php 
									$current_time = date('F d, Y G:i');
									$assignment_time = $assignment['assignment_enddate'];
									$datetime2 = strtotime($assignment_time);
									$datetime1 = strtotime($current_time);
									$datediff = $datetime2 - $datetime1;
									$days_left = floor($datediff/(60*60*24)); 
									
									if ($days_left < 0) {
										$days_left = -$days_left;				
										?>
										<p class="red"> <?php echo date('F d, Y G:i', strtotime($assignment_time)) . ' , ' . $days_left . ' days ago.';?></p>
										<?php
									} else {
										?>
										<p> <?php echo date('F d, Y G:i', strtotime($assignment_time)) . ' , ' . $days_left . ' days left.'; ?> </p>
										<?php
									}
									?> 
									</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php }  ?>	
	</table>
										
			
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th style="width:500px;" class="handedin">Handed in assignments</th>
				<th>Date handed in</th>			
			</tr>
			</thead>
					<?php if  (!empty($handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td>
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								
								<td>
									<?php
									$assignment_id = $assignment[$this->flexi_auth->db_column('assignment', 'id')];
									$student_id = $user['uacc_id'];
									$date = $this->flexi_auth->get_upload_date_time($assignment_id, $student_id);
									$upload_id = $this->flexi_auth->get_upload_id($assignment_id, $student_id);
									$late = $this->flexi_auth->upload_too_late($upload_id, $assignment_id);
									if ($late > 0) {
										?>
										<p class="red"> <?php echo date('F d, Y G:i', strtotime($date)) . ' , ' . $late . ' days late.';?></p>
										<?php
									} else {
										?>
										<p> <?php echo date('F d, Y G:i', strtotime($date)); ?> </p>
										<?php
									}
									?>

								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
	</table>		
	

			
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th style="width:500px;">Checked assignments</th>
				<th> Mistakes & grade </th>
							
			</tr>
			</thead>
					<?php  if (!empty($checked_assignments)) { ?>
						<tbody>
							<?php foreach ($checked_assignments as $checked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
									<?php echo $checked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								
								<td style="width: 500px;">
									<a href="<?php echo $base_url.'dashboard/checked_assignment_per_student/'.$checked_assignment[$this->flexi_auth->db_column('assignment', 'id')].'/' .$user['uacc_id'];?>"> 
									View details
									</a> 
								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php }  ?>
	</table>				
	
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th style="width:500px;">Not checked assignments</th>
						
			</tr>
			</thead>
					<?php  if (!empty($notchecked_assignments)) { ?>
						<tbody>
							<?php foreach ($notchecked_assignments as $notchecked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
		
								<?php echo $notchecked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								 
								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No assignments are available.
								</td>
							</tr>
						</tbody>
					<?php }  ?>
	</table>		
					
				<?php /*  if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_users'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } */?>
			

		
		
</div>		