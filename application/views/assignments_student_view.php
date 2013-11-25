<div class="large-12 columns">

		<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>

	<div class="h2bg">
	<h2> Student <?php echo $user['uacc_username'];?> </h2>
	<h4> Assignments overview </h4>
	</div>	
	
	
<!-- 	
	<h3>Upload assignment</h3>

	<?php echo $error;?>

	<?php echo form_open_multipart('assignments/do_upload');?>

	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="Upload" class = "small button"/>

	</form>
-->	
	
		
	<table style="width: 1000px;" class="assignmentstudents responsive">
			
			<thead>
			<tr>
				<th class="nothandedin" style="width:500px;">Not handed in assignments</th> 
				<th> Upload my assignment</th>
				<th>Time left</th>			
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
									<div class="button small">
									Upload 
									</div>
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
				<th style="width:500px;" class="handedin">Handed in assignments</th>
				<th>Date handed in</th>			
			</tr>
			</thead>
					<?php if  (!empty($handed_in_assignments)) { ?>
						<tbody>
							<?php foreach ($handed_in_assignments as $assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
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
				<th style="width:500px;">Checked assignments</th>
				<th> Mistakes & grade </th>
				<th> Comments made by teacher </th>
							
			</tr>
			</thead>
					<?php  if (!empty($checked_assignments)) { ?>
						<tbody>
							<?php foreach ($checked_assignments as $checked_assignment) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 500px;">
									<?php echo $checked_assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
								</td>
								
								<td style="width: 320px;">
									<a href="<?php echo $base_url.'dashboard/checked_assignment_per_student/'.$checked_assignment[$this->flexi_auth->db_column('assignment', 'id')].'/' .$user['uacc_id'];?>"> 
									View details
									</a> 
								</td>
								
								<td>
									View comments 
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