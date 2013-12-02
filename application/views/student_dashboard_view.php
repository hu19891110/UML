
<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
			<div class="upcomingass large-5 columns">
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
				
		<div class="grades large-5 columns">		
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


 
  <!--
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.interchange.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.abide.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.dropdown.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.placeholder.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.forms.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.alerts.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.magellan.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.reveal.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.tooltips.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.clearing.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.cookie.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.joyride.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.orbit.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.section.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.topbar.js"></script>
  
  -->
