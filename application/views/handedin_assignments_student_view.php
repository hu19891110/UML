<div class="large-12 columns">

	<div class="h2bg">
	<h2> Student <?php echo $user['uacc_username'];?> </h2>
	<h4> Assignments overview </h4>
	</div>	
		
	<table style="width: 1000px;" class="assignmentstudents responsive">
			
			<thead>
			<tr>
				<th class="nothandedin" style="width:700px;">Not handed in assignments</th> 
				<th>Time left</th>			
			</tr>
			</thead>
			
						<?php  if (!empty($not_handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($not_handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								
								<td>
									01 day(s) left <!-- echo deadline date / handed in date -->
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
				<th style="width:700px;" class="handedin">Handed in assignments</th>
				<th>Date handed in</th>			
			</tr>
			</thead>
					<?php if  (!empty($handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								
								<td>
									01 day(s) ago <!-- echo deadline date / handed in date -->
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
				<th style="width:700px;">Checked assignments</th>
				<th >Not checked assignments</th>			
			</tr>
			</thead>
					<?php  if (!empty($checked_assignments)) { ?>
						<tbody>
							<?php foreach ($checked_assignments as $checked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">
		
								
								<a href="<?php echo $base_url.'dashboard/checked_assignment_per_student/'.$checked_assignment[$this->flexi_auth->db_column('assignment', 'id')].'/' .$user['uacc_id'];?>"> 
									<?php echo $checked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
									</a> 
								</td>
								
								<td>
								<?php /*if ($checked == 'No') { ?>		
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								
								<?php }*/ ?>
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
			
			
	<a href="<?php echo $base_url.'dashboard/assignments_students/';?>"> Back to student list </a>
		
		
</div>		