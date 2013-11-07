
<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
				<table id="asstocheck" class="large-4 columns margin-left">
  				<thead>
    				<tr>
      			<th colspan="2" style="text-align: center;">Upcoming deadlines</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Deadline</th>
      			<th>Date of deadline</th>
    			</tr>
      			<?php 
      			foreach ($deadlines as $deadline)
      			{ ?>
      			<tr>
	      			<td><a href="<?php echo $base_url . 'dashboard/deadline/'. $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></a></td>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></td>
	      		</tr>	
      			<?php } ?>		
      			</tbody>
				</table>
				
				<div id="graph" class="large-4 columns "> </div>
				
				<script>
				graphResolutionByYear = new Array(
				[3,'Test 1'],
				[ 9,'Test 2'],
				[9,'Test 3'],
				[9,'Test 4']
				);

				$("#graph").jqBarGraph({
				data: graphResolutionByYear,
				colors: ['#435B77','#000'],
				width: 250,
				color: '#ffffff',
				type: 'false',
				postfix: '',
				title: '<h3> Grades per test</h3>'
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
