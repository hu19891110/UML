<div class="large-12 columns padding">

	<h2> Assignments for student <?php echo $user['uacc_username'];?> </h2>
		
		
	<table style="width: 1000px;" class="assignmentstudents responsive">
			<thead>
			<tr>
				<th>Not handed in assignments</th>
				<th>Time left</th>			
			</tr>
			</thead>
					<?php if (!empty($users)) { ?>
						<tbody>
							<?php foreach ($users as $user) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">
									Software Engineering Assignment 5 
									<!-- <?php echo $user['uacc_email'];?> --> <!--echo assignment name-->
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
				<th>Handed in assignments</th>
				<th>Date handed in</th>			
			</tr>
			</thead>
					<?php if (!empty($users)) { ?>
						<tbody>
							<?php foreach ($users as $user) { ?> <!-- for each assignment -->
							<tr>
								<td style="width: 700px;">
									Software Engineering Assignment 7 
									<!-- <?php echo $user['uacc_email'];?> --> <!--echo assignment name-->
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
					
				<?php if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_users'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } ?>
			
	
	<a href="<?php echo $base_url.'dashboard/assignments_students/';?>"> Back to student list </a>
		
		
</div>		