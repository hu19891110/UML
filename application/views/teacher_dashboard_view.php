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
  



	
