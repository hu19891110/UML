<div class="large-12 columns padding">

	
		<h2> Studentlist </h2>
		
		<table class="responsive">
			<thead>
			<tr>
				<th class="spacer_200">Email</th>
				<th>Username</th>	
				<th>Full Name</th>		
				<th></th>		
			</tr>
			</thead>
		
		
	<?php if (!empty($users)) { ?>
						<tbody>
							<?php foreach ($users as $user) { ?>
							<tr>
								<td>
									<?php echo $user['uacc_email'];?>
								</td>
								<td>
									<?php echo $user['uacc_username'];?>
								</td>
								<td>
									<?php echo $user['upro_first_name'];?> <?php echo $user['upro_last_name'];?>
								</td>
								<td>
									<a href="<?php echo $base_url.'dashboard/assignments_per_student/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>"> 
									View assignments
									</a> 
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
	
	<a style="clear: both; float: left;" href="<?php echo $base_url.'dashboard/add_assignment/';?>"> Back to assignments</a>

		
</div>		