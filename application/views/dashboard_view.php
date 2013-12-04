<?php if ($this->flexi_auth->is_admin()) { ?> 


<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
				
	<div id="mainwrapper">	
	
		<script>
		$(document).ready(function() 
    { 
        $("#asstocheck").tablesorter(); 
    } 
	) </script>
	
			
		<div class="row">		
		
	<!--	
			<div class="dashboard">
				<?php echo form_open(current_url());	?>  	
					<table>
						<thead>
							<tr>
								<th colspan="3" style="text-align:center;"> Classes </th>
							</tr>				
						
						</thead>
						<tr>
								<th class="spacer_150 tooltip_trigger" 
									title="The user group name.">
									Class Name
								</th>
								<th class="tooltip_trigger" 
									title="A short description of the purpose of the student class.">
									List of students in class
								</th>
							</tr>
						<tbody>
						<?php foreach ($student_classes as $class) { ?>
							<tr>
								<td>
									<a href="<?php echo $base_url;?>dashboard/update_student_class/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">
										<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
									</a>
								</td>
								<td><a href="<?php echo $base_url;?>dashboard/students_per_class/<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>">View list of students</a></td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<td colspan="5">
							</td>
						</tfoot>
					</table>
		
				<?php echo form_close();?>
		</div>
	-->
			
			<div class="dashboard large-6 columns">
				<table>
						<thead>
							<tr>
								<th colspan="5" style="text-align:center;"> Users </th>
							</tr>							
						</thead>
						<tr>

								<th class="spacer_200">Email</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>User Group</th>
								<th>Times logged in </th>
							</tr>
						<?php if (!empty($users)) { ?>
						<tbody>
							<?php foreach ($users as $user) { ?>
							<tr>
								<td>
									<?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?>
								</td>
								<td>
									<?php echo $user['upro_first_name'];?>
								</td>
								<td>
									<?php echo $user['upro_last_name'];?>
								</td>
								<td>
									<?php echo $user[$this->flexi_auth->db_column('user_group', 'name')];?>
								</td>
								<td>
									<?php echo $user['uacc_times_logged_in'];?>
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
			</div>
						
			<div class="dashboard large-6 columns">
				<table class="tablesorter">
  				<thead>
  					<tr>
						<th colspan="3" style="text-align:center;"> Not yet handed in assignments </th>
					</tr>	
  				</thead>
  				<tr>
      			<th>Assignment</th>
      			<th>Deadline of assignment</th>
      			<th>Amount of students not yet handed in</th>
    			</tr>
  				<tbody>
  			
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			<tr>
      			<?php
      				$current_time = date('F d, Y G:i');
						$assignment_time = $assignment['assignment_enddate'];
						$datetime2 = strtotime($assignment_time);
						$datetime1 = strtotime($current_time);
						$datediff = $datetime2 - $datetime1;
						$days_left = floor($datediff/(60*60*24)); 
      			?>
      			<?php if ($days_left > 0){ ?>
      			
	      			<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
	      			<td>
	      				<?php  
	      					$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      					echo date_format($enddate, 'd-m-Y H:i');
	      				?>
	      			</td>
	      			<td> </td>
					<?php } ?>
	      		</tr>	
      			<?php } ?>		
      			</tbody>
				</table>
		</div>				
				
	<!--			
			<div class="dashboard">
				<table class="tablesorter">
  				<thead>
  					<tr>
						<th colspan="3" style="text-align:center;"> Assignments </th>
					</tr>	
  				</thead>
  				<tr>
      			<th>Assignment</th>
      			<th>Deadline of assignment</th>
      			<th>View details </th>
    			</tr>
  				<tbody>
  			
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			<tr>
	      			<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
	      			<td>
	      				<?php  
	      					$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      					echo date_format($enddate, 'd-m-Y H:i');
	      				?>
	      			</td>
	      			<td> <a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View details</a> </td>

	      		</tr>	
      			<?php } ?>		
      			</tbody>
				</table>
		</div>
-->
				
				<div id="graph"> </div>
				
				<script>
				graphResolutionByYear = new Array(
				[[3, 8],'Test 1'],
				[[4, 9],'Test 2'],
				[[1, 9],'Test 3']
				);

				$("#graph").jqBarGraph({
				data: graphResolutionByYear,
				colors: ['#435B77','#000'],
				legends: ['Lowest grade','Highest grade'],
				legend: true,
				width: 350,
				color: '#ffffff',
				type: 'multi',
				postfix: '',
				title: '<h3> Highest and lowest grades per test</h3>'
				});
				</script>
				
				</div> <!-- row -->			
			</div> <!-- mainwrapper --> 	
				
		</div> <!-- end 12 columns --> 

<?php } else { ?>

<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
			<div class="dashboard large-6 columns">
				<table>
  				<thead>
    				<tr>
      			<th colspan="3" style="text-align: center;">Upcoming assignments</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Assignment</th>
      			<th>Date of deadline</th>
      			<th>Upload</th>
    			</tr>
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			<tr>
      			<?php
      				$current_time = date('F d, Y G:i');
						$assignment_time = $assignment['assignment_enddate'];
						$datetime2 = strtotime($assignment_time);
						$datetime1 = strtotime($current_time);
						$datediff = $datetime2 - $datetime1;
						$days_left = floor($datediff/(60*60*24)); 
      			?>
      			<?php if ($days_left > 0){ ?>
	      			<td><a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></a></td>
	      			<td><?php $date = $assignment[$this->flexi_auth->db_column('assignment', 'enddate')];
							echo date('d-m-Y H:i', strtotime($date));?></td>
	      			<td> Upload assignment </td>
	      		<?php } ?>	
	      		</tr>	
      			<?php } ?>		
      			</tbody>
				</table>
		</div>		
				
		<div class="dashboard large-6 columns">		
				<table>
  				<thead>
    				<tr>
      			<th colspan="3" style="text-align: center;">Grades</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Assignment name</th>
      			<th>Assignment description</th>
      			<th>Grade</th>
    			</tr>
      		<tr>
      			<td> </td>
      			<td> </td>
      			<td> </td>
      		
      		</tr>
      		
      			</tbody>
				</table>
		</div>		
				
				<div id="graph" class="large-4 columns "> </div>
				<script>
				graphResolutionByYear = new Array(
				[8,'Test 1'],
				[ 9,'Test 4'],
				[9,'Test 5'],
				[9,'Test 7']
				);

				$("#graph").jqBarGraph({
				data: graphResolutionByYear,
				colors: ['#435B77','#000'],
				width: 250,
				color: '#ffffff',
				type: 'false',
				postfix: '',
				title: '<h3> Highest grades</h3>'
				});
				</script>


</div> <!-- end 12 columns --> 

<?php } ?>