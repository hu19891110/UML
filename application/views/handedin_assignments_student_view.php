<div class="large-12 columns">

	<div class="h2bg">
	<h2> Student <?php echo $user['uacc_username'];?> </h2>
	<h4> Assignments overview </h4>
	</div>	
		
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th class="nothandedin">Not handed in assignments</th> 
				<th>Time left</th>			
			</tr>
			</thead>
					<?php if (!empty($assignments)) { ?>
						<tbody>
							<?php foreach ($assignments as $assignment) { ?> <!-- for each assignment -->
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
									No users are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
	</table>
								
			
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th class="handedin">Handed in assignments</th>
				<th>Date handed in</th>			
			</tr>
			</thead>
					<?php if (!empty($assignments)) { ?>
						<tbody>
							<?php foreach ($assignments as $assignment) { ?> <!-- for each assignment -->
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
									No users are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
	</table>		
	

			
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th class="">Checked assignments</th>
				<th>Not checked assignments</th>			
			</tr>
			</thead>
					<?php if (!empty($assignments)) { ?>
						<tbody>
							<?php foreach ($assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">
						<?php $checked = ($assignment[$this->flexi_auth->db_column('assignment', 'checked')] == 1) ? 'Yes' : 'No';  ?>

								
						<?php	if ($checked == 'Yes') { ?>								
								
								<a href="<?php echo $base_url.'dashboard/checked_assignments_per_student/'.$assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"> 
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
									</a> 
						<?php } ?>
								</td>
								
								<td>
								<?php	if ($checked == 'No') { ?>		
									<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								
								<?php } ?>
								</td>
								
							</tr>
						<?php } ?>
						</tbody>
					
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No users are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
	</table>				
					
				<?php if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_users'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } ?>
			
	
	<a href="<?php echo $base_url.'dashboard/assignments_students/';?>"> Back to student list </a>
		
		
</div>		