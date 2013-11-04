<!-- Include head -->
<?php $this->load->view('includes/head'); ?>
<!-- Include header -->
<?php $this->load->view('includes/header-teacher'); ?>

<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
				
	<div id="mainwrapper">	
	<!--	
		<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/assignments.jpg"/>
		<a href="<?php echo site_url('assignments') ?>"><span class="caption scale-caption">
			<h3></h3>
			<p> Upload test answers <br/>
			Get an overview of uploaded assignments <br/>
			Mark assignments as checked</p>
		</span></a>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/deadlines.jpg"/>
		<span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/archive.jpg"/>
		<span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/register.jpg"/>
		<a href="<?php echo site_url('register') ?>"><span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span></a>
		</div>
		
			<div id="box-6" class="box">
		<img id="image-6" src="../includes/images/userdetails.jpg"/>
		<a href="<?php echo $base_url;?>dashboard/update_user_account/<?php echo $currentuser['uacc_id']; ?>">
		<span class="caption scale-caption">
			<h3></h3>
			<p> </p>
		</span>
		</div> -->
	
			
		<div class="row">			
				
				<table id="asstocheck" class="large-4 columns margin-left">
  				<thead>
    				<tr>
      			<th colspan="2" style="text-align: center;">Upcoming deadlines</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th >Deadline</th>
      			<th> Date of deadline </th>
    			</tr>
    			
      			<?php 
      			foreach ($deadlines as $deadline)
      			{ ?>
      			<tr>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></td>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></td>
	      		</tr>
      			<?php } ?>
    					
    		
  				</tbody>
				</table>
				
				<div id="graph" class="large-4 columns margin-left"> </div>
				
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
				
				<div class="large-3 columns margin-left deadline">
					<h3> Add a new deadline </h3>
					<?php echo form_open(current_url());	?>
					<ul>
						<li>
							<label for="Description"> Description: </label>
							<input type="text" id="" name="add_deadline_desc" value=""/>
						</li>
						<li>
							<label for="class">Student Class:</label>	
							<table>
								<thead>
									<tr>
										<th class="tooltip_trigger"
											title="The name of the class."/>
											Class Name
										</th>
										<th class="spacer_150 align_ctr tooltip_trigger"
											title="If checked, the deadline will be for this class."/>
											Assign deadline
										</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($classes as $class) { ?>
									<tr>
										<td>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][id]" value="<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>"/>
											<?php echo $class[$this->flexi_auth->db_column('student_class', 'name')];?>
										</td>
										<td class="align_ctr">
											<?php 
												// Define form input values.
												$current_status = 0; 
												$new_status = NULL;
											?>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
											<input type="hidden" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="0"/>
											<input type="checkbox" name="add[<?php echo $class[$this->flexi_auth->db_column('student_class', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>
										</td>
									</tr>
								<?php } ?>
								</tbody>
								</table>					
						</li> <br/>
						<li>
							<label for="End_date">End date:</label>
							<input type="text" id="datepicker" name="add_deadline_enddate" value=""/>
						</li>
						<li>
						<input type="submit" name="add_deadline" id="add_deadline" value="Add Deadline" class="small button"/>
						</li>
					</ul>
					<?php echo form_close();?>

				</div><!--large-3 columns -->
					
				
				</div> <!-- row -->			
			</div> <!-- mainwrapper --> 	
				
		</div> <!-- end 12 columns --> 


<!-- Include footer -->
<?php $this->load->view('includes/footer'); ?>	




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
  



	
