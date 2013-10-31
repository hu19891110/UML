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
		<!-- Image Caption 6 -->
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
		</div>
		
	</div> <!-- mainwrapper --> 	
				
				
				<!-- 
				<table>
  				<thead>
    				<tr>
      			<th width="200">Table Header</th>
      			<th>Table Header</th>
      			<th width="150">Table Header</th>
   				<th width="150">Table Header</th>
    				</tr>
  				</thead>
  				<tbody>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
      			<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
     				<td>Content Goes Here</td>
      			<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
    			<tr>
      			<td>Content Goes Here</td>
      			<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      			<td>Content Goes Here</td>
   				<td>Content Goes Here</td>
    			</tr>
  				</tbody>
				</table>
				--> 
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
  



	
