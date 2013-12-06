<div class="large-12 columns">

	<div class="h2bg" style="height: 85px !important;">
	<h2> Student <?php echo $user['uacc_username'];?> </h2>
	<h4> Assignments overview </h4>
	<a href="<?php echo $refered_from; ?>">Back</a> 
	</div>

	<table style="width: 1000px;" class="assignmentstudents responsive">

			<thead>
			<tr>
				<th class="nothandedin" style="width:700px;">Not handed in assignments</th>
				<th>Assignment end date</th>
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
									<?php
		$date = $assignment[$this->flexi_auth->db_column('assignment', 'enddate')];
		echo date('F d, Y G:i', strtotime($date));
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
				<th style="width:700px;">Checked assignments</th>

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
				<th style="width:700px;">Not checked assignments</th>

			</tr>
			</thead>
					<?php  if (!empty($notchecked_assignments)) { ?>
						<tbody>
							<?php foreach ($notchecked_assignments as $notchecked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">

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
</div>		