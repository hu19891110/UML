<div class="large-12 columns" >

	<div class="h2bg">
		<h2>
			<?php 
			$user_id = $user['uacc_id'];
			$assignment_grade = $this->flexi_auth->calculate_grade($user_id, $assignment_id);
			?>
			<span class="cijfer"><?php echo $assignment_grade;?> </span>
	 		Student <?php echo $user['uacc_username'];?> 	
	 		<!--<span class="backtoass"><a
	 			href="<?php echo $base_url.'dashboard/assignments_per_student/'.$user['uacc_id'];?>"> 
	 			Back to all assignments of the student</a>
	 		</span>-->
		</h2>
	
		<h4>
			<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>	
			
	<!--	<?php   if($uploads->num_rows()) { echo $uploads->row()->comment; } ?> -->

		</h4>	
	</div>
	<? 
	
		foreach ($errors as $error) {
			
			 $error_id = $error[$this->flexi_auth->db_column('checker_error', 'error_id')];
			 $error_value = $this->flexi_auth->get_error_value($error_id);
			 $error_value = round($error_value, 1);
			 ?>
			 
			 <span class="mistake"><?php echo $error_value;?></span>
			 <?
			 if ($error_id == 1) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': The relationship exists in the handed in model but has <strong>another</strong> name.</p>
				 <?php
			 } else if ($error_id == 2) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': This relationship does NOT have the same <strong>start destination. 
				 <?php
			 } else if ($error_id == 3) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': This relationship does NOT have the same <strong>destination.  
				 <?php
			 } else if ($error_id == 4) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': This relationship is NOT of the same type.
				 <?php
			 } else if ($error_id == 5) {
				 ?>
				 <p> Multiplicty error</p>
				 <?php
			 } else if ($error_id == 6) {
				 ?>
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>', attribute '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>': the datatype (<?php echo $error[$this->flexi_auth->db_column('checker_error', 'datatype')];?>) does not match. </p>
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
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>': The attribute '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>' is missing in the handed in model. </p>

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
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>' is missing in the handed in model.</p>
				 <?php
			 } else if ($error_id == 16) {
				 ?>
				 
				 <?php
			}
			echo '<br/><br/>';
		}
		
	?>	
		
		<!--comment section-->
		
		<h2>Comments</h2>
		<?php if ($comment == '') {
			echo '<p>The teacher did not make any comments on your assignment.</p>';
		} else {
			echo '<p>'. $comment . '</p>';
		}
		?>
		
	 
	
	
</div> <!-- end large-12 columns -->	