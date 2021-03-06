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
			
			<div class="dashboard large-6 columns" style="min-height: 200px;">
				<?php
				foreach ($assignments as $assignment)
      			{
					$ass_checked = $assignment['assignment_checked'];
					if($ass_checked == 1) {
						$ass_id = $assignment[$this->flexi_auth->db_column('assignment', 'id')];
						$ass_name = $assignment[$this->flexi_auth->db_column('assignment', 'name')];
						//print_r($assignment);
						//$gem = $this->flexi_auth->db_column('uploads', 'grade');
						
						if ( $this->login->tbl_col_uploads['grade'] != '' ) {
							//$this->db->select('uploads.grade');
							$this->db->from('uploads');
							$this->db->where('deadline_id = ' . $ass_id);
							$bla = $this->db->get();
							$bla = $bla->result_array();
							
							$total = 0;
							$i = 0;
							$j = 0;
							foreach($bla as $bl) {
								if($bl['Type'] == 1) {
									if ($bl['grade'] >= 5.5){
										$j++;
									}
									else{
										$i++;
									}
								}
							}
							
							//avg array, vullen per assignment
							$vol[] = $j;
							$onvol[] = $i;
							$name[] = $ass_name;
						}
					}
				}
				
				if ( empty ($vol[0])  )
					$vol[0] = 0;
				if ( empty ($vol[1]) )
					$vol[1] = 0;
				if ( empty ($vol[2]) )
					$vol[2] = 0;
					
				if ( empty ($onvol[0])  )
					$onvol[0] = 0;
				if ( empty ($onvol[1]) )
					$onvol[1] = 0;
				if ( empty ($onvol[2]) )
					$onvol[2] = 0;
					
				if ( empty ($name[0]) )
					$name[0] = 'nog geen assignment';
				if ( empty ($name[1]) )
					$name[1] = 'nog geen assignment';
				if ( empty ($name[2]) )
					$name[2] = 'nog geen assignment';
				?>
				
				<div id="graph1" class="large-4 columns "> </div>
				<script>
				graphResolutionByYear2 = new Array(
				[[<?php echo $vol[count($vol) - 3]; ?>, <?php echo $onvol[count($onvol) - 3]; ?>], '<?php echo $name[count($name) - 3]; ?>'],
				[[<?php echo $vol[count($vol) - 2]; ?>, <?php echo $onvol[count($onvol) - 2]; ?>], '<?php echo $name[count($name) - 2]; ?>'],
				[[<?php echo $vol[count($vol) - 1]; ?>, <?php echo $onvol[count($onvol) - 1]; ?>], '<?php echo $name[count($name) - 1]; ?>']
				);

				
				$("#graph1").jqBarGraph({
				data: graphResolutionByYear2,
				colors: ['#435B77','#000'],
				legends: ['Passing grades', 'Non-Passing grades'],
				legend: true,
 				width: 450,
 				color: '#ffffff',
 				type: 'multi',
 				postfix: '',
				title: '<h3>Amount of passing and non-passing grades.</h3>'
 				});
				</script>
			</div>
						
			<div class="dashboard large-6 columns" style="min-height: 200px;">
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
				</thead>
  				<tbody>
				<tr>
				</tr>
				
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			
      			<?php
      				$current_time = date('F d, Y G:i');
						$assignment_time = $assignment['assignment_enddate'];
						$datetime2 = strtotime($assignment_time);
						$datetime1 = strtotime($current_time);
						$datediff = $datetime2 - $datetime1;
						$days_left = floor($datediff/(60*60*24)); 
      			?>
      			<?php $i = 0;
				if ($days_left > 0){ if($i < 10) { ?>
      			<tr>
	      			<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
	      			<td>
	      				<?php  
	      					$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      					echo date_format($enddate, 'd-m-Y H:i');
	      				?>
	      			</td>
	      			<td> 
						<?php
							$amount = $this->flexi_auth->get_amount_students_not_handed_in($assignment[$this->flexi_auth->db_column('assignment', 'id')]);
							echo $amount;
						?>
					</td>
					</tr>	
					<?php $i++; } } ?>
	      		
      			<?php } ?>		
      			</tbody>
				</table>
				</div>
		</div>
		
		<div class="row">
		<div class="dashboard large-6 columns">
				<table class="tablesorter">
  				<thead>
  					<tr>
						<th colspan="3" style="text-align:center;"> Assignments to be checked </th>
					</tr>	
  				</thead>
  				<tr>
      			<th>Assignment</th>
      			<th>Date Deadline</th>
      			<th></th>
    			</tr>
				</thead>
  				<tbody>
				<tr>
				</tr>
      			<?php 
      			foreach ($assignments as $assignment)
      			{ ?>
      			
      			<?php
      				$current_time = date('F d, Y G:i');
						$assignment_time = $assignment['assignment_enddate'];
						$datetime2 = strtotime($assignment_time);
						$datetime1 = strtotime($current_time);
						$datediff = $datetime2 - $datetime1;
						$days_left = floor($datediff/(60*60*24)); 
      			?>
				
      			<?php if ($days_left < 0 && $assignment['assignment_checked'] == 0){ ?>
					<tr>
	      			<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
	      			<td>
	      				<?php  
	      					$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      					echo date_format($enddate, 'd-m-Y H:i');
	      				?>
	      			</td>
	      			<td> 
						<a style="float:left; margin-top:10px;" href="<?php echo $base_url.'dashboard/checkassignment/' . $assignment['assignment_id'] ?>">
						<input type="submit" value="Check" class="small button"></a>
					</td>
					</tr>
					<?php } ?>
	      			
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

				<?php
				foreach ($assignments as $assignment)
      			{
					$ass_checked = $assignment['assignment_checked'];
					if($ass_checked == 1) {
						$ass_id = $assignment[$this->flexi_auth->db_column('assignment', 'id')];
						$ass_name = $assignment[$this->flexi_auth->db_column('assignment', 'name')];
						
						//$gem = $this->flexi_auth->db_column('uploads', 'grade');
						
						if ( $this->login->tbl_col_uploads['grade'] != '' ) {
							//$this->db->select('uploads.grade');
							$this->db->from('uploads');
							$this->db->where('deadline_id = ' . $ass_id);
							$bla = $this->db->get();
							$bla = $bla->result_array();
						
							
							$total = 0;
							$i = 0;
							$gem = 0;
							foreach($bla as $bl) {							
								if($bl['Type'] == 1) {
									$total += $bl['grade'];
									$i++;
								}
							}
							if($i == 0) {
								$gem = 0;
							} else {
								$gem = $total / $i;
							}
							//avg array, vullen per assignment
							$avg[] = $gem;
							$name[] = $ass_name;
						}
					}
				}
				
				if ( empty ($avg[0])  )
					$avg[0] = 0;
				if ( empty ($avg[1]) )
					$avg[1] = 0;
				if ( empty ($avg[2]) )
					$avg[2] = 0;
				if ( empty ($avg[3]) )
					$avg[3] = 0;
					
				if ( !isset ($avg[0]) )
					$name[0] = 'nog geen assignment';
				if ( !isset ($avg[1]) )
					$name[1] = 'nog geen assignment';
				if ( !isset ($avg[2]) )
					$name[2] = 'nog geen assignment';
				if ( !isset ($avg[3]) )
					$name[3] = 'nog geen assignment';
					
					
				?>
				<div class="dashboard large-6 columns">
				<div id="graph"> </div>
				
				<script>
				graphResolutionByYear = new Array(
				[[<?php echo $avg[count($avg) - 4]; ?>], '<?php echo $name[count($avg) - 4]; ?>'],
				[[<?php echo $avg[count($avg) - 3]; ?>], '<?php echo $name[count($avg) - 3]; ?>'],
				[[<?php echo $avg[count($avg) - 2]; ?>], '<?php echo $name[count($avg) - 2]; ?>'],
				[[<?php echo $avg[count($avg) - 1]; ?>], '<?php echo $name[count($avg) - 1]; ?>']
				/*[[<?php echo $avg[count($avg) - 4]; ?>], '<?php $i = $name[count($avg) - 4]; while(strlen($i) > 12) $i = substr($i, 0, -1);  echo $i; ?>'],
				[[<?php echo $avg[count($avg) - 3]; ?>], '<?php $i = $name[count($avg) - 3]; while(strlen($i) > 12) $i = substr($i, 0, -1);  echo $i; ?>'],
				[[<?php echo $avg[count($avg) - 2]; ?>], '<?php $i = $name[count($avg) - 2]; while(strlen($i) > 12) $i = substr($i, 0, -1);  echo $i; ?>'],
				[[<?php echo $avg[count($avg) - 1]; ?>], '<?php $i = $name[count($avg) - 1]; while(strlen($i) > 12) $i = substr($i, 0, -1);  echo $i; ?>']*/

				);

 				$("#graph").jqBarGraph({
 				data: graphResolutionByYear,
 				colors: ['#435B77','#000'],
				legends: ['Average grade per test'],
				legend: false,
 				width: 450,
 				color: '#ffffff',
 				type: 'multi',
 				postfix: '',
				title: '<h3> Average grades per test</h3>'
 				});
				</script>
				
				</div> <!-- row -->			
			</div> <!-- mainwrapper --> 	
				</div>
		</div> <!-- end 12 columns --> 
		</div>
		</div>
		
		

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
				$i = 0;
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
      			<?php if ($days_left > 0){ if($i < 10) {?>
	      			<td><a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></a></td>
	      			<td><?php $date = $assignment[$this->flexi_auth->db_column('assignment', 'enddate')];
							echo date('d-m-Y H:i', strtotime($date));?></td>
	      			<td> <a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">Upload assignment</a> </td>
	      		<?php $i++;} } ?>	
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
				
				
				<?php
				$stu_id = $currentuser['uacc_id'];
				foreach ($assignments as $assignment)
      			{
					$ass_id = $assignment[$this->flexi_auth->db_column('assignment', 'id')];
					$ass_name = $assignment[$this->flexi_auth->db_column('assignment', 'name')];
					
					
					//$gem = $this->flexi_auth->db_column('uploads', 'grade');
					
					if ( $this->login->tbl_col_uploads['grade'] != '' ) {
						//$this->db->select('uploads.grade');
						$this->db->from('uploads');
						$this->db->where('deadline_id = ' . $ass_id);
						$this->db->where('student_id = ' . $stu_id);
						$bla = $this->db->get();
						$bla = $bla->result_array();
						
						$cijfer = 0;
						foreach($bla as $bl) {
							$cijfer = $bl['grade'];
						}
						
						//avg array, vullen per assignment
						$avg[] = $cijfer;
						$name[] = $ass_name;
					}

				}
				
				if ( empty ($avg[0])  )
					$avg[0] = 0;
				if ( empty ($avg[1]) )
					$avg[1] = 0;
				if ( empty ($avg[2]) )
					$avg[2] = 0;
					
				if ( empty ($name[0]) )
					$name[0] = 'nog geen assignment';
				if ( empty ($name[1]) )
					$name[1] = 'nog geen assignment';
				if ( empty ($name[2]) )
					$name[2] = 'nog geen assignment';
				?>
				
				<div id="graph" class="large-4 columns "> </div>
				<script>
				graphResolutionByYear = new Array(
				[[<?php echo $avg[0]; ?>], '<?php echo $name[0]; ?>'],
				[[<?php echo $avg[1]; ?>], '<?php echo $name[1]; ?>'],
				[[<?php echo $avg[2]; ?>], '<?php echo $name[2]; ?>']
				);

				$("#graph").jqBarGraph({
				data: graphResolutionByYear,
				colors: ['#435B77','#000'],
				width: 250,
				color: '#ffffff',
				type: 'false',
				postfix: '',
				title: '<h3> Your grades</h3>'
				});
				</script>

				

</div> <!-- end 12 columns --> 

<?php } ?>