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
      			<th colspan="2" style="text-align: center;">Assignments to check</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th >Assignment</th>
      			<th> Date of deadline </th>
    			</tr>
    			<tr>
      			<td>Class diagram test 1</td>
      			<td>10-08-2013</td>
      	
    			</tr>
    			<tr>
      			<td>Class diagram test 3</td>
      			<td>09-03-2013</td>
    			</tr>
    			<tr>
      			<td>Class diagram test 4</td>
      			<td>12-02-2013</td>
    			</tr>
    			<tr>
      			<td>Class diagram test 7</td>
      			<td>05-09-2013</td>
    			</tr>
    			<tr>
      			<td>Class diagram test 11</td>
      			<td>22-11-2013</td>
    			</tr>	
    			<tr>
      			<td>Class diagram test 18</td>
      			<td>25-11-2013</td>
    			</tr>	
    			<tr>
      			<td>Class diagram test 19</td>
      			<td>30-11-2013</td>
    			</tr>		
    			<tr>
      			<td>Class diagram test 20</td>
      			<td>02-12-2013</td>
    			</tr>	
    			<tr>
      			<td>Class diagram test 21</td>
      			<td>05-12-2013</td>
    			</tr>		
    		
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

					
					<form name="deadline">
					<ul>
						<li>
							<label for="Description"> Description: </label>
							<input type="text" id="" name="add_deadline_desc" value=""/>
						</li>
						<li>
							<label for="class">Student Class:</label>	
							
							
							<script type="text/javascript">
        						function toggle_all(check) {  //naam van de functie
           					 var form = document.forms['deadline']; // dit leest het formulier in <form name="deadline" ... >
            				var formelements = form.elements;
            				for(var i = 0; i < formelements.length; i++) // loop door alle elementen
                			if(formelements[i].type && formelements[i].type=='checkbox'){ // controleer per element of het een checkbox is
                    		formelements[i].checked = check; // vink checkbox aan
                			}                  // 'check' is een variabele die true (aan) of false (uit) kan zijn
        					}
   					 	</script>
							
							<input type="button" class="check" value="Check all" onclick="toggle_all(true);"/>
							<input type="button" class="check" value="Uncheck all" onclick="toggle_all(false);"/><br/>
							</form>
							
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
						</li> 
						<li>
							<label for="End_date">End date:</label>
							<input type="text" id="datepicker" name="add_deadline_enddate" value=""/>
						</li>
						<li>
						<input type="submit" name="add_deadline" id="add_deadline" value="Add Deadline" class="small button"/>
						</li>
					</ul>
					</form>
					

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
  



	
