<div class="large-12 columns" >

	<div class="h2bg">
		<h2>
			<span class="cijfer"> 8 </span>
	 		Student <?php echo $user['uacc_username'];?> 	
	 		<span class="backtoass"><a
	 			href="<?php echo $base_url.'dashboard/handedin_assignments_per_student/'.$user['uacc_id'];?>"> 
	 			Back to all assignments of the student</a>
	 		</span>
		</h2>
	
		<h4>
			<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>	
			<span class="goedkeuren"> Alles goedkeuren | Alles afkeuren </span>
		</h4>
	</div> <!-- end h2bg --> 
	
	<p> 
	
		<span class="notcheckedbutton"></span>
		<span class="checkedbutton"></span>
		<span class="mistake">-2</span>
		<b> Line 15:</b> The name of the class should be 'student' in stead of 'students' <br/>
		<small> For this mistake 1 point is substracted </small>
	</p>
	
	<p> <b> Line 19:</b> The attribute of the class Student should be 'name' in stead of 'id' <br/>
	<small> For this mistake 2 points are substracted </small>
	</p>
	
	<p> <b> Line 20:</b> The method of the class Mario should be 'getDirection(position)' in stead of 'getDirection()' <br/>
	<small> For this mistake 2 points are substracted </small>
	</p>
	
	<? 
	
		foreach ($errors as $error) {
			
			 $error_id = $error[$this->flexi_auth->db_column('checker_error', 'error_id')];
			 if ($error_id == 1) {
				 ?>
				 <p>Relatie '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': De relatie komt wel voor in het ingeleverde model maar heeft een <strong>andere</strong> naam.</p>
				 <?php
			 } else if ($error_id == 2) {
				 ?>
				 <p>Relatie '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': Deze relatie heeft NIET dezelfde <strong>beginbestemming.</strong> </p>
				 <?php
			 } else if ($error_id == 3) {
				 ?>
				 <p>Relatie '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': Deze relatie heeft NIET dezelfde <strong>eindbestemming.</strong> </p>
				 <?php
			 } else if ($error_id == 4) {
				 ?>
				 <p>Relatie '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': De relatie is NIET van dezelfde soort. </p>
				 <?php
			 } else if ($error_id == 5) {
				 ?>
				 <p> Multiplicty error</p>
				 <?php
			 } else if ($error_id == 6) {
				 ?>
				 <p>Klasse '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>', attribuut '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>': Het Datatype (<?php echo $error[$this->flexi_auth->db_column('checker_error', 'datatype')];?>) komt niet overeen. </p>
				 <?php
			 } else if ($error_id == 7) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 8) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 9) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 10) {
				 ?>
				 <p>Klasse '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>': Het attribuut '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>' mist in het ingeleverde model.</p>

				 <?php
			 } else if ($error_id == 11) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 12) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 13) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 14) {
				 ?>
				 
				 <?php
			 } else if ($error_id == 15) {
				 ?>
				 <p>Klasse '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>' mist in het ingeleverde model. </p>
				 <?php
			 } else if ($error_id == 16) {
				 ?>
				 
				 <?php
			}
			echo '<br/>';
		}
		
	?>	
	 
	
	
</div> <!-- end large-12 columns -->	