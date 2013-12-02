<div class="large-12 columns">

	<div class="h2bg">
	<h4> Grades overview</h4>
	</div>		

	<?php if ($this->flexi_auth->is_admin()) { ?>
		<?php  if (!empty($checked_assignments)) { ?>
			<?php foreach ($checked_assignments as $checked_assignment) { ?> <!-- for each assignment -->
				<h3><?php echo $checked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h3>
				<table style="width: 1000px;" class="assignmentstudents responsive">
				<?php /* ?>
				<thead>
				<tr>
					<th>Student </th>	
					<th>grade </th>
				</tr>
				</thead>
				<?php */ ?>
					<tbody>
					<?php  if (!empty($users)) { ?>
						<?php foreach ($users as $user) { ?>
						<?php 
							$assignment_id = $checked_assignment[$this->flexi_auth->db_column('assignment', 'id')];
							$student_id = $user['uacc_id'];
							$grade = $this->flexi_auth->get_grade_for_assignment_by_student($assignment_id, $student_id);
							if ($grade != FALSE) {
							?>
							
								<tr>
									<td><?php echo $user['upro_first_name'] . ' ' . $user['upro_last_name'];?></td>
									<td><?php echo $grade; ?></td>
									<td><a href="<?php echo $base_url.'dashboard/checked_assignment_per_student/'.$checked_assignment[$this->flexi_auth->db_column('assignment', 'id')].'/' .$user['uacc_id'];?>">details</a></td>
								</tr>
							
								<?php } ?>
								
							<?php } ?>
						<?php } else { ?>
								<tr>
									<td colspan="7" class="highlight_red">
										No grades are available.
									</td>
								</tr>
							
						<?php } ?>
						</tbody>
						
					</table>
						<?php // */ ?>
			<?php } ?>
		<?php } ?>
	<?php } else { ?> 
		<table style="width: 1000px;" class="assignmentstudents responsive">
				<thead>
				<tr>
					<th>Assignment </th>	
					<th>Grade </th>
					<th>Details </th>
				</tr>
				</thead>
					<tbody>
					<?php 
					 if (!empty($checked_assignments)) { ?>
					<?php foreach ($checked_assignments as $checked_assignment) { ?> 
					<?php 
							$assignment_id = $checked_assignment[$this->flexi_auth->db_column('assignment', 'id')];
							$student_id = $currentuser['uacc_id'];
							$grade = $this->flexi_auth->get_grade_for_assignment_by_student($assignment_id, $student_id);
							if ($grade != FALSE) {
							?>
							
								<tr>
									<td><?php echo $checked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
									<td><?php echo $grade; ?></td>
									<td><a href="<?php echo $base_url.'dashboard/checked_assignment_per_student/'.$checked_assignment[$this->flexi_auth->db_column('assignment', 'id')].'/' .$currentuser['uacc_id'];?>">details</a></td>
								</tr>
							
								<?php } ?>
								
							<?php } ?>
						<?php } else { ?>
								<tr>
									<td colspan="7" class="highlight_red">
										No grades are available.
									</td>
								</tr>
							
						<?php } ?>
						</tbody>
						
					</table>

	
	<?php } ?>
	
	
		
		
</div>		